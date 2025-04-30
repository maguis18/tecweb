<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use TECWEB\BACKEND\Read\Read;
use TECWEB\BACKEND\Create\Create;
use TECWEB\BACKEND\Update\Update;
use TECWEB\BACKEND\Delete\Delete;
require '../vendor/autoload.php';
$app = AppFactory::create();
$app->setBasepath("/tecweb/actividades/a09/product_app/backend");
$app->get('/product/{id}', function(Request $request, Response $response, $args) {
    $productos = new Read('marketzone');
    $productos->single($args['id']);
    $response->getBody()->write($productos->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

// 🔹 GET /products → Listar todos los productos
$app->get('/products', function(Request $request, Response $response) {
    $productos = new Read('marketzone');
    $productos->list();
    $response->getBody()->write($productos->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

// 🔹 GET /products/{search} → Buscar productos por término
$app->get('/products/{search}', function(Request $request, Response $response, $args) {
    $productos = new Read('marketzone');
    $productos->search($args['search']);
    $response->getBody()->write($productos->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

// 🔹 POST /product → Agregar producto
$app->post('/product', function(Request $request, Response $response) {
    $data = json_decode(json_encode($request->getParsedBody()));
    $productos = new Create('marketzone');
    $productos->add($data);
    $response->getBody()->write($productos->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

// 🔹 PUT /product → Editar producto
$app->put('/product', function(Request $request, Response $response) {
    $data = json_decode(json_encode($request->getParsedBody()));
    $productos = new Update('marketzone');
    $productos->edit($data);
    $response->getBody()->write($productos->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

// 🔹 DELETE /product → Eliminar producto
$app->delete('/product', function(Request $request, Response $response) {
    $data = json_decode(json_encode($request->getParsedBody()));
    $productos = new Delete('marketzone');
    $productos->delete($data->id);
    $response->getBody()->write($productos->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();

?>