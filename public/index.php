<?php

require_once __DIR__ . '/../vendor/autoload.php';

use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Middleware\MethodOverrideMiddleware;

/*$pdo = new \PDO("pgsql:localhost:5432/Hexlet;user=Mad;password=799142");
$pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);*/

/*$dsn = 'postgresql:dbname=Hexlet;host=localhos';
$user = 'Mad';
$password = '799142';

$dbh = new PDO($dsn, $user, $password);

var_dump($dbh);*/

var_dump($_ENV);

var_dump($_SERVER);

var_dump($_SESSION);

/*$databaseUrl = parse_url($_ENV['DATABASE_URL']);
$username = $databaseUrl['user']; // janedoe
$password = $databaseUrl['pass']; // mypassword
$host = $databaseUrl['host']; // localhost
$port = $databaseUrl['port']; // 5432
$dbName = ltrim($databaseUrl['path'], '/'); // mydb*/

/*$container = new Container();
$container->set('renderer', function () {
    return new \Slim\Views\PhpRenderer(__DIR__ . '/../templates');
});

AppFactory::setContainer($container);
$app = AppFactory::create();
$app->add(MethodOverrideMiddleware::class);
$app->addErrorMiddleware(true, true, true);

$app->get('/', function ($request, $response) {

    return $this->get('renderer')->render($response, 'index.phtml');
});



$app->run();*/
