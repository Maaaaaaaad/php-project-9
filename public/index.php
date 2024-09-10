<?php

require_once __DIR__ . '/../vendor/autoload.php';

use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Middleware\MethodOverrideMiddleware;

$url = [
    "scheme" => "postgresql",
    "host" => "dpg-crg1fi3qf0us73desm50-a",
    "user" => "mad",
    "pass" => "l5HOcwzap3wrbBZ5NJCZouZRgOiPf6g5",
    "path"=> "hexlet_bfjd"
];

var_dump($_ENV['DATABASE_URL']);

//{ ["scheme"]=> string(10) "postgresql" ["host"]=> string(26) "dpg-crg1fi3qf0us73desm50-a" ["user"]=> string(3) "mad" ["pass"]=> string(32) "l5HOcwzap3wrbBZ5NJCZouZRgOiPf6g5" ["path"]=> string(12) "/hexlet_bfjd" }
$databaseUrl = parse_url($_ENV['DATABASE_URL']);
$username = $databaseUrl['user'];
$password = $databaseUrl['pass'];
$host = $databaseUrl['host'];
$port = 5432;
$dbName = ltrim($databaseUrl['path'], '/');




$conStr = sprintf("pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
    $host,
    $port,
    $dbName,
    $username,
    $password
);




$pdo = new \PDO($conStr);
$pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);




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
