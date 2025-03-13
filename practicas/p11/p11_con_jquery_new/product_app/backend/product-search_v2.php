<?php
include_once __DIR__.'/database.php';

//archivo para hacer la bsuqeuda del nomrbe y que no sea igual
$data = array(
    'exists' => false 
);

// SE VERIFICA HABER RECIBIDO EL NOMBRE
if (isset($_GET['nombre'])) {
    $nombre = $_GET['nombre'];


    $sql = "SELECT COUNT(*) as count FROM productos WHERE nombre = '{$nombre}' AND eliminado = 0";
    if ($result = $conexion->query($sql)) {
        
        $row = $result->fetch_assoc();

        
        if ($row['count'] > 0) {
            $data['exists'] = true;
        }

        
        $result->free();
    } else {
        die('Query Error: ' . mysqli_error($conexion));
    }

   
    $conexion->close();
}
echo json_encode($data, JSON_PRETTY_PRINT);
?>