<?php
// Crear objeto de conexión
$link = new mysqli('localhost', 'root', 'gatin_123', 'marketzone');

// Comprobar la conexión
if ($link->connect_errno) {
    die('Falló la conexión: ' . $link->connect_error . '<br/>');
}

$nombre = $_POST['name'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$precio = $_POST['precio'];
$detalles = $_POST['detalles'];
$unidades = $_POST['unidades'];

$sql_verif = "SELECT * FROM productos WHERE nombre = '$nombre' OR marca = '$marca' OR modelo = '$modelo'";
$result = $link->query($sql_verif);

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
echo '<html xmlns="http://www.w3.org/1999/xhtml">';
echo '<head><title>Resultado del Registro de Producto</title>';
echo '<style type="text/css">';
echo 'body { background-color: rgba(156, 247, 250, 0.71); font-family: Open Sans, sans-serif; }'; // Color de fondo aplicado globalmente
echo 'h1 { color: rgb(37, 190, 246); border-bottom: 1px solid rgb(0, 0, 0); }'; // Estilos de título
echo 'li { margin: 10px; }';
echo 'img { margin: 10px; width: 200px; height: 200px; }';
echo '</style>';
echo '</head>';
echo '<body>';

if ($result->num_rows > 0) {
    echo "<h1>El producto ya está registrado</h1>";
    echo "<p>El producto con ese nombre, marca o modelo ya existe en la base de datos.</p>";
} else {
    if ($_FILES['imagen']['error'] == 0) {
        $imagen = $_FILES['imagen']['name'];
        $imagen_tmp = $_FILES['imagen']['tmp_name'];

        if (!is_dir("img/")) {
            mkdir("img/", 0777, true);
        }

        if (!move_uploaded_file($imagen_tmp, "img/" . $imagen)) {
            echo "<p>Hubo un error al subir la imagen. El producto no pudo ser insertado.</p>";
            echo '</body></html>';
            exit; 
        }
    }

    $sql = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen) VALUES ('$nombre', '$marca', '$modelo', '$precio', '$detalles', '$unidades', 'img/$imagen')";
    if ($link->query($sql) === TRUE) {
        echo '<h1>Producto Insertado Correctamente</h1>';
        echo "<p>Estos son los datos registrados:</p>";
        echo "<ul>";
        echo "<li><strong>Nombre:</strong> $nombre</li>";
        echo "<li><strong>Marca:</strong> $marca</li>";
        echo "<li><strong>Modelo:</strong> $modelo</li>";
        echo "<li><strong>Precio:</strong> $precio</li>";
        echo "<li><strong>Detalles:</strong> $detalles</li>";
        echo "<li><strong>Unidades:</strong> $unidades</li>";
        if (!empty($imagen)) {
            echo "<li><strong>Imagen:</strong><br> <img src='img/$imagen' alt='Imagen del producto'></li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Error al registrar el producto: " . $link->error . "</p>";
    }
}

echo '</body></html>';
$link->close();
?>
