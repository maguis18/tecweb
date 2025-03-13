<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo 3 de pOO EN PHP</title>
</head>
<body>
    <?php
    use EJEMPLOS\POO\Cabecera2 as Cabecera;//mandamos a traeral archvi que vamos a usar
    //el as nos sirve para renombrar
    require_once __DIR__.'/Cabecera.php';
    /*$cab1=new Cabecera('El rincon del programador','center');
    $cab1->graficar();*/
    $cab1=new Cabecera('El rincon del programador','center','https://deepseek.com/');
    $cab1->graficar();
    ?>
</body>
</html>