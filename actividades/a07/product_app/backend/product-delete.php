<?php
namespace TECWEB\MYAPI;
use TECWEB\MYAPI\Products as Products;
require_once __DIR__ . '/myapi/Products.php';

$id = isset($_POST['id']) ? $_POST['id'] : null;
$prod_Obj=new Products('marketzone');
$prod_Obj->delete($id);
echo $prod_Obj->getData();
?>
