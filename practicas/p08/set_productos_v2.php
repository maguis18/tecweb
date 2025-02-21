<?php

$nombre = 'nombre_producto';
$marca  = 'marca_producto';
$modelo = 'modelo_producto';
$precio = 1.0;
$detalles = 'detalles_producto';
$unidades = 1;
$imagen   = 'img/imagen.png';

// Crear objeto de conexión
@$link = new mysqli('localhost', 'root', '12345678a', 'marketzone');

// Comprobar la conexión
if ($link->connect_errno) {
    die('Falló la conexión: '.$link->connect_error.'<br/>');
}

$stmt = $link->prepare("SELECT * FROM productos WHERE nombre = ? AND marca = ? AND modelo = ?");
$stmt->bind_param("sss", $nombre, $marca, $modelo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "El producto con ese nombre, marca y modelo ya existe.";
} else {
    $sql = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $insert_stmt = $link->prepare($sql);
    $insert_stmt->bind_param("sssdssi", $nombre, $marca, $modelo, $precio, $detalles, $unidades, $imagen);
    
    if ($insert_stmt->execute()) {
        echo 'Producto insertado correctamente';
    } else {
        echo 'El Producto no pudo ser insertado';
    }

    $insert_stmt->close();
}

$stmt->close();
$link->close();
?>
