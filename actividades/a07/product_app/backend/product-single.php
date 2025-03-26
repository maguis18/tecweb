<?php
namespace TECWEB\MYAPI;
require_once __DIR__ . '/myapi/Products.php';

$id = isset($_POST['id']) ? $_POST['id'] : null;
$prod_Obj = new Products();

if ($id !== null) {
    $prod_Obj->single($id);
} else {
    $prod_Obj->data = ['status' => 'error', 'message' => 'ID no proporcionado'];
}

echo $prod_Obj->getData();
?>
