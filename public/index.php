<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Check;
use DI\Container;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Promise\CancellationException;
use Slim\Factory\AppFactory;
use Slim\Middleware\MethodOverrideMiddleware;
use DiDom\Document;
use Valitron\Validator;
use Illuminate\Support;
use App\Connection;
use App\Url;
use App\Urls;
use Slim\Flash;
use App\UrlCheck;

session_start();

$container = new Container();
$container->set('renderer', function () {
    return new \Slim\Views\PhpRenderer(__DIR__ . '/../templates');
});

$container->set('flash', function () {
    return new Slim\Flash\Messages();
});


$app = AppFactory::createFromContainer($container);
$app->add(MethodOverrideMiddleware::class);
$app->addErrorMiddleware(true, true, true);

$router = $app->getRouteCollector()->getRouteParser();

$app->get('/', function ($request, $response) {
    return $this->get('renderer')->render($response, 'index.phtml');
})->setName('Home');

$app->get('/urls', function ($request, $response) {

    $pdo = Connection::get()->connect();
    $urls = new Urls($pdo);
    $check = new UrlCheck($pdo);

    $repo = $urls->getEntities();

    $repos = [];

    foreach ($repo as $value) {
        $repos[] = [
            'id' => $value['id'],
            'name' => $value['name'],
            'last_check' => $check->getlastCheck($value['id']),
            'code' => $check->getStatusCode($value['id'])
        ];
    }

    $params = [
        'repo' => $repos
    ];

    return $this->get('renderer')->render($response, 'urls.phtml', $params);
})->setName('urls');


$app->post('/urls', function ($request, $response, array $args) use ($router) {

    $pdo = Connection::get()->connect();
    $urlName = $request->getParsedBodyParam('url');

    $urls = new Urls($pdo);

    $validator = new Validator($urlName);
    $validator->rule('url', 'name')->message('Некорректный URL');
    $validator->rule('lengthMax', 'name', 255)->message('Некорректный URL');
    $validator->rule('required', 'name')->message('URL не должен быть пустым');


    if ($validator->validate()) {
        if (!$urls->findName($urlName['name'])) {
            $this->get('flash')->addMessage('success', 'Страница успешно добавлена');
            $url = new Url($urlName['name']);
            $urls->save($url);
            $id = $urls->getID($urlName['name']);
            return $response->withRedirect($router->urlFor('showUrl', $id));
        } else {
            $this->get('flash')->addMessage('success', 'Страница уже существует');
            $id = $urls->getID($urlName['name']);
            return $response->withRedirect($router->urlFor('showUrl', $id));
        }
    } else {
        $error = $validator->errors();

        $params = [
            'errors' => $error,
            'name' => $urlName['name']
        ];

        return $this->get('renderer')->render($response->withStatus(422), 'index.phtml', $params);
    }
})->setName('saveUrl');


$app->get('/urls/{id}', function ($request, $response, $args) {

    $messages = $this->get('flash')->getMessages();
    $pdo = Connection::get()->connect();
    $urls = new Urls($pdo);
    $check = new UrlCheck($pdo);

    $url = $urls->findId($args['id']);
    $urlCheck = $check->getChecks($args['id']);

    $checks = [];

    foreach ($urlCheck as $value) {
        $checks[] = [
            'checkId' => $value['id'],
            'code' => $value['status_code'],
            'h1' => $value['h1'],
            'title' => $value['title'],
            'description' => $value['description'],
            'checkCreat' => $value['created_at']
        ];
    }

    $params = [
        'id' => $url['id'],
        'name' => $url['name'],
        'created' => $url['created_at'],
        'messages' => $messages,
        'checks' => $checks
    ];

    return $this->get('renderer')->render($response, 'showUrls.phtml', $params);
})->setName('showUrl');



$app->post('/urls/{id}/checks', function ($request, $response, $args) use ($router) {

    $id = $args['id'];
    $pdo = Connection::get()->connect();

    $urls = new Urls($pdo);
    $url = $urls->findId($id);
    $checkUrl = new Check($url['id']);
    $error = null;

    $client =  new Client(['verify' => false,]);

    try {
        $resp = $client->request('GET', $url['name']);
        $code = $resp->getStatusCode();
    } catch (ConnectException | ClientException | CancellationException $e) {
        $error = $e;
    }

    if (is_null($error)) {
        $checkUrl->setStatusCode($code);
        $check = new UrlCheck($pdo);

        $document = new Document($url['name'], true);

        $title = optional($document->first('title'));
        $h1 = optional($document->first('h1'));
        $description = $document->first('meta[name=description]');

        if (isset($description)) {
            $description1 = $description->getAttribute('content');
        } else {
            $description1 = null;
        }



        $checkUrl->setTitle($title->text());
        $checkUrl->setH1($h1->text());
        $checkUrl->setDescription($description1);




        $check->setCheck($checkUrl);

        $this->get('flash')->addMessage('success', 'Страница успешно проверена');
    } else {
        $this->get('flash')->addMessage('error', 'Произошла ошибка при проверке, не удалось подключиться');
    }


    return $response->withRedirect($router->urlFor('showUrl', $url));
})->setName('checkUrl');

$app->run();
