<?php
namespace TECWEB\MYAPI;
require_once __DIR__ . '/myapi/Products.php';
 
$prod_Obj = new Products();
$prod_Obj->add((object)$_POST);
echo $prod_Obj->getData();
?>
