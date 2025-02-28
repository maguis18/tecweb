<?php
/* MySQL Conexion */
$link = mysqli_connect("localhost", "root", "gatin_123", "marketzone");

// Chequea conexión
if($link === false){
    die("ERROR: No pudo conectarse con la DB. " . mysqli_connect_error());
}

// Obtener datos del formulario
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$precio = $_POST['precio'];
$unidades = $_POST['unidades'];
$detalles = $_POST['detalles'];
$imagen = $_POST['imagen'];

// Actualizar el producto en la base de datos
$sql = "UPDATE productos SET nombre='$nombre', marca='$marca', modelo='$modelo', precio='$precio', unidades='$unidades', detalles='$detalles', imagen='$imagen' WHERE id='$id'";

if(mysqli_query($link, $sql)){
    echo "El producto ha sido editado correctamente.";
} else {
    echo "ERROR: No se ejecutó $sql. " . mysqli_error($link);
}

// Cierra la conexión
mysqli_close($link);
?>

<p>
    <a href="get_producto_xhtml_v2.php">Ver productos con unidades ≤ tope</a>
</p>
<p>
    <a href="get_productos_vigentes_v2.php">Ver productos vigentes</a>
</p>