<?php
$link = mysqli_connect("localhost", "root", "gatin_123", "marketzone");

if (!$link) {
    die("Error de conexión: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $precio = $_POST['precio'];
    $unidades = $_POST['unidades'];
    $detalles = $_POST['detalles'];

    // Obtener la imagen actual
    $result = mysqli_query($link, "SELECT imagen FROM productos WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
    $imagen = $row['imagen'];

    // Si se sube una nueva imagen, actualizar la ruta
    if (!empty($_FILES['imagen']['name'])) {
        $imagen = 'uploads/' . $_FILES['imagen']['name'];
        move_uploaded_file($_FILES['imagen']['tmp_name'], $imagen);
    }

    // Actualizar en la BD
    $sql = "UPDATE productos SET 
            nombre='$nombre', 
            marca='$marca', 
            modelo='$modelo', 
            precio=$precio, 
            unidades=$unidades, 
            detalles='$detalles', 
            imagen='$imagen' 
            WHERE id=$id";

    if (mysqli_query($link, $sql)) {
        echo "Producto actualizado correctamente.<br>";
        echo '<a href="get_productos_xhtml_v2.php">Ver productos con unidades menor o igual al tope</a><br>';
        echo '<a href="get_productos_vigentes_v2.php">Ver productos vigentes</a>';
    } else {
        echo "Error al actualizar el producto: " . mysqli_error($link);
    }
}

mysqli_close($link);
?>
