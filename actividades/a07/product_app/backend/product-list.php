<?php

use TECWEB\MYAPI\Products as Products;
require_once __DIR__ . '/myapi/Products.php';

$prod_Obj=new Products('marketzone');
$prod_Obj->list();
echo $prod_Obj->getData();
?>