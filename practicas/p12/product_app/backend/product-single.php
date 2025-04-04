<?php
    use TECWEB\MYAPI\Read;
    require_once __DIR__.'/Read/Read.php';

    $productos = new Read('marketzone');
    $productos->single( $_POST['id'] );
    echo $productos->getData();
?>