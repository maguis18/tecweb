<?php
namespace TECWEB\MYAPI;
require_once __DIR__ . '/myapi/Products.php';

// Se obtiene el nombre enviado vía GET
$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
$prod_Obj = new Products();
$prod_Obj->singleByName($nombre);

echo $prod_Obj->getData();
?>
