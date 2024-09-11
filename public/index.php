<?php

require_once __DIR__ . '/../vendor/autoload.php';

use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Middleware\MethodOverrideMiddleware;
use App\Connection;
use App\Url;
use App\Urls;
use Slim\Flash;

/*
$url ="postgresql://Mad:799142@localhost:5432/Hexlet";


$databaseUrl = parse_url($url);
$username = $databaseUrl['user'];
$password = $databaseUrl['pass'];
$host = $databaseUrl['host'];
$port = $databaseUrl['port'];
$dbName = ltrim($databaseUrl['path'], '/');

$databaseUrl = parse_url($_ENV['DATABASE_URL']);
$username = $databaseUrl['user'];
$password = $databaseUrl['pass'];
$host = $databaseUrl['host'];
$port = $databaseUrl['port'];
$dbName = ltrim($databaseUrl['path'], '/');


$conStr = sprintf(
    "pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
    $host,
    $port,
    $dbName,
    $username,
    $password
);
*/


$container = new Container();
$container->set('renderer', function () {
    return new \Slim\Views\PhpRenderer(__DIR__ . '/../templates');
});

$container->set('flash', function () {
    return new Slim\Flash\Messages();
});

AppFactory::setContainer($container);
$app = AppFactory::create();
$app->add(MethodOverrideMiddleware::class);
$app->addErrorMiddleware(true, true, true);

$router = $app->getRouteCollector()->getRouteParser();

$app->get('/', function ($request, $response) use ($router) {

    return $this->get('renderer')->render($response, 'index.phtml');
})->setName('Home');


$app->post('/', function ($request, $response, array $args) use ($router) {

    $urlName = $request->getParsedBodyParam('url');
    $validator = new Valitron\Validator($urlName);

    $pdo = Connection::get()->connect();
    $urls = new Urls($pdo);


    $validator->rules([
        'url' => ['name'],
        'required' => ['name']
    ]);

    if ($validator->validate()) {
        if (!$urls->findName($urlName['name'])) {
            //$this->get('flash')->addMessage('success', 'Страница успешно добавлена');
            $url = new Url($urlName['name']);
            $urls->save($url);
            $id = $url->getId();
            return $response->withHeader('X-ID', $id)
                ->withRedirect($router->urlFor('showUrl'));
        } /*else {
            // $this->get('flash')->addMessage('success', 'Страница уже существует');
        }*/
    }
});
/*

    } else {
        $errors [] = $validator->errors();
    }




/*
            $urlName['name'] = $postData['name'];
            $this->get('flash')->addMessage('success', 'Post has been updated');
            $repo->save($post);
            return $response->withRedirect($router->urlFor('posts'));
    }

    $params = [
        'post' => $post,
        'postData' => $postData,
        'errors' => $errors
    ];

    return $this->get('renderer')->render($response, 'index.phtml');*/







$app->get('/urls', function ($request, $response) use ($router) {

    $pdo = Connection::get()->connect();
    $urls = new Urls($pdo);

    $repo = $urls->getEntities();


    $params = [
        'repo' => $repo
    ];

    return $this->get('renderer')->render($response, 'urls.phtml', $params);
})->setName('urls');


$app->get('/urls/{id}', function ($request, $response, array $args) use ($router) {

    $pdo = Connection::get()->connect();
    $urls = new Urls($pdo);

    $url = $urls->findId($args['id']);


    $params = [
        'id' => $url['id'],
        'name' => $url['name'],
        'created' => $url['created_at']
    ];


    return $this->get('renderer')->render($response, 'showUrls.phtml', $params);
})->setName('showUrl');



$app->run();
