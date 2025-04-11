<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
require '../vendor/autoload.php';
$app = AppFactory::create();
$app->setBasepath("/tecweb/practicas/p13/product_app/backend");
$app->get('/',function(Request $request, Response $response, $args) {
    $response->getBody()->write("hola mundo slim");
    return $response;
});


$app->get("/hola[/{nombre}]",function(Request $request, Response $response, $args){
    $response->getBody()->write("Hola,". $args["nombre"]);
    return $response;
});
$app->run();
?>
