<?php
// backend/index.php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/controllers/productController.php';

use function TECWEB\BACKEND\Controllers\listarProductos;
use function TECWEB\BACKEND\Controllers\agregarProducto;
use function TECWEB\BACKEND\Controllers\eliminarProducto;
use function TECWEB\BACKEND\Controllers\editarProducto;
use function TECWEB\BACKEND\Controllers\buscarProducto;
use function TECWEB\BACKEND\Controllers\obtenerProducto;
use function TECWEB\BACKEND\Controllers\obtenerProductoPorNombre;
$action = isset($_GET['action']) ? $_GET['action'] : 'list';

switch ($action) {
    case 'list':
        listarProductos();
        break;
    case 'add':
        agregarProducto();
        break;
    case 'delete':
        eliminarProducto();
        break;
    case 'edit':
        editarProducto();
        break;
    case 'search':
        buscarProducto();
        break;
    case 'single':
        obtenerProducto();
        break;
    case 'singlebyname':
        obtenerProductoPorNombre();
        break;
    default:
        echo json_encode(["status" => "error", "message" => "Acción no válida"]);
        break;
}
?>