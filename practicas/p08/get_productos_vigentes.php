<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Productos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">
</head>
<body>
    <h3>PRODUCTOS VIGENTES</h3>
    <br/>
    <?php
        $link = new mysqli('localhost', 'root', 'gatin_123', 'marketzone');

        if ($link->connect_errno) {
            die('Falló la conexión: ' . $link->connect_error . '<br/>');
        }

        if ($consulta = $link->prepare("SELECT * FROM productos WHERE eliminado = 0")) {
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
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<script>alert("No hay productos sin eliminar para mostrar");</script>';
        }
    ?>
</body>
</html>