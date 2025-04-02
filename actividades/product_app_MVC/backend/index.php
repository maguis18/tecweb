index php 
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
?>