<?php
namespace TECWEB\MYAPI;
use TECWEB\MYAPI\Products as Products;
require_once __DIR__ . '/myapi/Products.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$prod_Obj = new Products('marketzone');
$prod_Obj->search($search);
echo $prod_Obj->getData();
?>
