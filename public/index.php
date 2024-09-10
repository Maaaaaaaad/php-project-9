<?php

require_once __DIR__ . '/../vendor/autoload.php';

use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Middleware\MethodOverrideMiddleware;

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

$pdo = new \PDO($conStr);
$pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

dump($pdo);




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
