<?php

require_once __DIR__ . '/../vendor/autoload.php';

use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Middleware\MethodOverrideMiddleware;


$container = new Container();
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

/*

$app->post('/cart-items', function ($request, $response) {


    $item[] = $request->getParsedBodyParam('item');
    $cart = json_decode($request->getCookieParam('cart', json_encode([])), true);

    foreach ($item as $array) {
        foreach ($array as $key => $value) {
            if ($key == 'id' && $value == 1) {
                $cart["$value"]['name'] = 'One';
                $cart["$value"]['count'] += 1;
            } elseif ($key == 'id' && $value == 2) {
                $cart["$value"]['name'] = 'Two';
                $cart["$value"]['count'] +=2;
            }
        }
    }

    foreach ($item as $array) {
         foreach ($array as $key => $value) {
             if ($key == 'id' && $value == 1) {
                 $count1 += 1;
             } elseif ($key == 'id' && $value == 2) {
                 $count2 += 2;
             }
         }
     }

         $cart = [
             ['name' => 'One', 'count' => $count1],
             ['name' => 'Two', 'count' => $count2]
         ];

    $encodedCart = json_encode($cart);

    return $response->withHeader('Set-Cookie', "cart={$encodedCart}")->withRedirect('/');
});


$app->delete('/cart-items', function ($request, $response) {

    $encodedCart = json_encode($cart = []);

    return $response->withHeader('Set-Cookie', "cart={$encodedCart}")
        ->withRedirect('/');
});*/


$app->run();
