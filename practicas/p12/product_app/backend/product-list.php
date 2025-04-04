<?php
    use TECWEB\MYAPI\Read as Read;
    require_once __DIR__.'/Read/Read.php';

    $productos = new Read('marketzone');
    $productos->list();
    echo $productos->getData();
?>