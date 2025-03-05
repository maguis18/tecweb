<?php
    include_once __DIR__.'/database.php';

    $data = array();

    if( isset($_POST['buscar']) ) {
        $buscar = $_POST['buscar'];

        // Consulta con LIKE (nombre, marca, detalles)
        $sql = "
            SELECT *
            FROM productos
            WHERE nombre   LIKE '%{$buscar}%'
               OR marca    LIKE '%{$buscar}%'
               OR detalles LIKE '%{$buscar}%'
        ";

        if($result = $conexion->query($sql)) {
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $result->free();
        } else {
            die('Query Error: '.mysqli_error($conexion));
        }
        $conexion->close();
    }

    // Array de productos a JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
?>
