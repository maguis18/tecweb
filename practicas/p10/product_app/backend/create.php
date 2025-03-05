<?php
// Archivo: create.php
include_once __DIR__.'/database.php';

// Opcional: para indicar que la respuesta es JSON
header('Content-Type: application/json; charset=utf-8');

// Obtener el cuerpo de la petición (JSON)
$producto = file_get_contents('php://input');

if (!empty($producto)) {
    // Decodificar JSON a objeto/array asociativo
    $jsonOBJ = json_decode($producto);

    // Verificar si el JSON es válido
    if ($jsonOBJ === null) {
        echo json_encode([
            "status"  => "error",
            "message" => "JSON inválido o no se recibió."
        ]);
        exit;
    }

    // Extraer campos del objeto JSON
    // Ajusta según tu esquema de base de datos
    $nombre   = isset($jsonOBJ->nombre)   ? trim($jsonOBJ->nombre)   : '';
    $marca    = isset($jsonOBJ->marca)    ? trim($jsonOBJ->marca)    : '';
    $modelo   = isset($jsonOBJ->modelo)   ? trim($jsonOBJ->modelo)   : '';
    $precio   = isset($jsonOBJ->precio)   ? floatval($jsonOBJ->precio)   : 0;
    $unidades = isset($jsonOBJ->unidades) ? intval($jsonOBJ->unidades) : 0;
    $detalles = isset($jsonOBJ->detalles) ? trim($jsonOBJ->detalles) : '';
    $imagen   = isset($jsonOBJ->imagen)   ? trim($jsonOBJ->imagen)   : 'img/default.png';

    // Validar si el producto (eliminado=0) ya existe: misma marca + nombre o misma marca + modelo
    $sqlCheck = "
        SELECT COUNT(*) AS total
        FROM productos
        WHERE (
                (nombre = '$nombre' AND marca = '$marca')
             OR (marca  = '$marca' AND modelo = '$modelo')
              )
          AND eliminado = 0
    ";
    $resultCheck = $conexion->query($sqlCheck);
    if ($resultCheck) {
        $rowCheck = $resultCheck->fetch_assoc();
        $existe   = $rowCheck['total'] ?? 0;

        if ($existe > 0) {
            echo json_encode([
                "status"  => "error",
                "message" => "El producto ya existe (activo) en la Base de Datos."
            ]);
            exit;
        }
    } else {
        echo json_encode([
            "status"  => "error",
            "message" => "Error al verificar la existencia: " . $conexion->error
        ]);
        exit;
    }

    // Insertar producto nuevo con eliminado=0
    $sqlInsert = "
        INSERT INTO productos
        (nombre, marca, modelo, precio, unidades, detalles, imagen, eliminado)
        VALUES
        ('$nombre', '$marca', '$modelo', $precio, $unidades, '$detalles', '$imagen', 0)
    ";

    if ($conexion->query($sqlInsert)) {
        echo json_encode([
            "status"  => "success",
            "message" => "Producto insertado correctamente."
        ]);
    } else {
        echo json_encode([
            "status"  => "error",
            "message" => "Error al insertar: " . $conexion->error
        ]);
    }

    $conexion->close();
} else {
    // No llegó nada en el cuerpo
    echo json_encode([
        "status"  => "error",
        "message" => "No se recibió ningún JSON."
    ]);
}
?>
