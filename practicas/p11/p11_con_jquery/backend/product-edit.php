<?php
header('Content-Type: application/json; charset=utf-8');
include_once __DIR__.'/database.php';

// Se obtiene la información del producto enviada en formato JSON
$producto = file_get_contents('php://input');

$data = array(
    'status'  => 'error',
    'message' => 'No se pudo actualizar el producto'
);

if (!empty($producto)) {
    // Convierte el string JSON a objeto
    $jsonOBJ = json_decode($producto);
    
    // Escapar los valores para prevenir inyección SQL (considera usar sentencias preparadas para mayor seguridad)
    $id       = mysqli_real_escape_string($conexion, $jsonOBJ->id);
    $nombre   = mysqli_real_escape_string($conexion, $jsonOBJ->nombre);
    $marca    = mysqli_real_escape_string($conexion, $jsonOBJ->marca);
    $modelo   = mysqli_real_escape_string($conexion, $jsonOBJ->modelo);
    $precio   = floatval($jsonOBJ->precio);
    $detalles = mysqli_real_escape_string($conexion, $jsonOBJ->detalles);
    $unidades = intval($jsonOBJ->unidades);
    $imagen   = mysqli_real_escape_string($conexion, $jsonOBJ->imagen);
    
    // Se construye la consulta UPDATE para modificar el producto
    $sql = "UPDATE productos SET 
                nombre   = '$nombre',
                marca    = '$marca',
                modelo   = '$modelo',
                precio   = $precio,
                detalles = '$detalles',
                unidades = $unidades,
                imagen   = '$imagen'
            WHERE id = '$id'";
    
    if ($conexion->query($sql)) {
        $data['status'] = "success";
        $data['message'] = "Producto actualizado correctamente";
    } else {
        $data['message'] = "ERROR: No se ejecutó $sql. " . mysqli_error($conexion);
    }
    
    $conexion->close();
}

echo json_encode($data, JSON_PRETTY_PRINT);
?>
