<?php
//DEFINISCE LE ROTTE DA INTERCETTARE

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/controllers/HelloController.php';
require __DIR__ . '/controllers/AlunniController.php';

$app = AppFactory::create();

$app->get('/hello', "HelloController:hello"); //rimanda alla funzione della classe hellocontroller
$app->get('/hello/{name}',"HelloController:hello_with_name");
$app->get('/json/{name}', "HelloController:json_name");


//$app->get('/alunni', "AlunniController:index");
$app->get('/alunni/{id}', "AlunniController:view");
$app->post('/alunni', "AlunniController:create");
$app->put('/alunni/{id}', "AlunniController:update");
$app->delete('/alunni/{id}', "AlunniController:destroy");
$app->get('/alunni', "AlunniController:search");
$app->run();
