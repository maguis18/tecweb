<?php
    use TECWEB\MYAPI\Create;
    require_once __DIR__.'/Create/Create.php';

    $productos = new Create('marketzone');
    $productos->add( json_decode( json_encode($_POST) ) );
    echo $productos->getData();

?>