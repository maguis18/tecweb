<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Productos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">
</head>
<body>
    <h3>PRODUCTOS</h3>
    <br/>
    <?php
    if (isset($_GET['tope'])) {
        $tope = $_GET['tope'];

        $link = new mysqli('localhost', 'root', 'gatin_123', 'marketzone');

        if ($link->connect_errno) {
            die('Falló la conexión: ' . $link->connect_error . '<br/>');
        }

        if ($consulta = $link->prepare("SELECT * FROM productos WHERE unidades <= ?")) {
            $consulta->bind_param("i", $tope);
            $consulta->execute();
            $result = $consulta->get_result();
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            $consulta->close();
        }

        $link->close();

        if (!empty($rows)) {
            echo '<table class="table">';
            echo '<thead class="thead-dark">';
            echo '<tr>';
            echo '<th scope="col">#</th>';
            echo '<th scope="col">Nombre</th>';
            echo '<th scope="col">Marca</th>';
            echo '<th scope="col">Modelo</th>';
            echo '<th scope="col">Precio</th>';
            echo '<th scope="col">Unidades</th>';
            echo '<th scope="col">Detalles</th>';
            echo '<th scope="col">Imagen</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            foreach ($rows as $row) {
                echo '<tr>';
                echo '<th scope="row">' . $row['id'] . '</th>';
                echo '<td>' . $row['nombre'] . '</td>';
                echo '<td>' . $row['marca'] . '</td>';
                echo '<td>' . $row['modelo'] . '</td>';
                echo '<td>' . $row['precio'] . '</td>';
                echo '<td>' . $row['unidades'] . '</td>';
                echo '<td>' . utf8_encode($row['detalles']) . '</td>';
                echo '<td><img src="' . $row['imagen'] . '" alt="Producto" style="width: 100px;"></td>';
                echo '<td><a href="formulario_productos_v2.php?id=' . $row['id'] . '" class="btn btn-primary">Editar</a></td>'; 
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<script>alert("El parametro Tope no fue indicado");</script>';
        }
    } else {
        die('Parámetro "tope" no detectado...');
    }
    ?>
</body>
</html>