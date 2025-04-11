<?php
include_once __DIR__.'/database.php';

// SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
$data = array(
    'exists' => false // Por defecto, asumimos que el nombre no existe
);

// SE VERIFICA HABER RECIBIDO EL NOMBRE
if (isset($_GET['nombre'])) {
    $nombre = $_GET['nombre'];
    $id = $_GET['id'] ?? null; // Obtener el ID del producto en edición (si existe)

    // SE REALIZA LA QUERY DE BÚSQUEDA
    $sql = "SELECT COUNT(*) as count FROM productos WHERE nombre = '{$nombre}' AND eliminado = 0";
    
    // Si se proporciona un ID, excluir ese producto de la validación
    if ($id) {
        $sql .= " AND id != '{$id}'";
    }

    if ($result = $conexion->query($sql)) {
        // SE OBTIENEN LOS RESULTADOS
        $row = $result->fetch_assoc();

        // SI HAY RESULTADOS, SE CAMBIA EL VALOR DE 'exists' A true
        if ($row['count'] > 0) {
            $data['exists'] = true;
        }

        // SE LIBERA EL RESULTADO
        $result->free();
    } else {
        die('Query Error: ' . mysqli_error($conexion));
    }

    // SE CIERRA LA CONEXIÓN
    $conexion->close();
}

// SE HACE LA CONVERSIÓN DE ARRAY A JSON
echo json_encode($data, JSON_PRETTY_PRINT);
?>