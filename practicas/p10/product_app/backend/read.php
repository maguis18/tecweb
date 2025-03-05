<?php
    include_once __DIR__ . '/database.php';

    // Array que se va a devolver en forma de JSON
    $data = array();

    // Verificamos si llega la variable "buscar" por POST
    if (isset($_POST['buscar'])) {
        $buscar = $_POST['buscar'];

        // Construimos la consulta usando LIKE
        // Asegúrate de filtrar/limpiar la entrada en un entorno de producción (para evitar inyección SQL).
        $sql = "SELECT * 
                FROM productos 
                WHERE nombre   LIKE '%$buscar%'
                   OR marca    LIKE '%$buscar%'
                   OR detalles LIKE '%$buscar%'";

        if ($result = $conexion->query($sql)) {
            // AL esperar múltiples filas, usamos un while para cada registro
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $data[] = $row; 
            }
            $result->free();
        } else {
            die('Query Error: ' . mysqli_error($conexion));
        }

        $conexion->close();
    }

    // Se hace la conversión de array a JSON
    // $data será un arreglo vacío si no hubo coincidencias,
    // o contendrá varios objetos en caso de varias coincidencias.
    echo json_encode($data, JSON_PRETTY_PRINT);
?>
