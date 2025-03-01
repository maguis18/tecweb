<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Productos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">
    <script>
        function show(rowId) {
    var data = document.getElementById(rowId).querySelectorAll(".row-data");

    var id = data[0].innerHTML;
    var nombre = data[1].innerHTML;
    var marca = data[2].innerHTML;
    var modelo = data[3].innerHTML;
    var precio = data[4].innerHTML;
    var unidades = data[5].innerHTML;
    var detalles = data[6].innerHTML;
    var imagen = data[7].querySelector("img").src;  // Captura la fuente de la imagen

    alert("Nombre: " + nombre + "\nMarca: " + marca + "\nModelo: " + modelo + 
          "\nPrecio: " + precio + "\nUnidades: " + unidades + "\nDetalles: " + detalles );
    send2form(id, nombre, marca, modelo, precio, unidades, detalles, imagen);
}

function send2form(id, nombre, marca, modelo, precio, unidades, detalles, imagen) {
    var form = document.createElement("form");

    form.appendChild(createHiddenInput('id', id));
    form.appendChild(createHiddenInput('name', nombre));
    form.appendChild(createHiddenInput('marca', marca));
    form.appendChild(createHiddenInput('modelo', modelo));
    form.appendChild(createHiddenInput('precio', precio));
    form.appendChild(createHiddenInput('unidades', unidades));
    form.appendChild(createHiddenInput('detalles', detalles));
    form.appendChild(createHiddenInput('imagen', imagen));  // Agrega la imagen al formulario

    form.method = 'POST';
    form.action = 'formulario_productos_v2.php';

    document.body.appendChild(form);
    form.submit();
}

function createHiddenInput(name, value) {
    var input = document.createElement("input");
    input.type = 'hidden';
    input.name = name;
    input.value = value;
    return input;
}
    </script>
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
            echo '<th scope="col">Editar</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            foreach ($rows as $row) {
                echo '<tr id="row' . $row['id'] . '">';
echo '<td class="row-data">' . $row['id'] . '</td>';
echo '<td class="row-data">' . $row['nombre'] . '</td>';
echo '<td class="row-data">' . $row['marca'] . '</td>';
echo '<td class="row-data">' . $row['modelo'] . '</td>';
echo '<td class="row-data">' . $row['precio'] . '</td>';
echo '<td class="row-data">' . $row['unidades'] . '</td>';
echo '<td class="row-data">' . utf8_encode($row['detalles']) . '</td>';
echo '<td class="row-data"><img src="' . $row['imagen'] . '" alt="Producto" style="width: 100px;"></td>';
echo '<td><input type="button" value="Editar" onclick="show(\'row' . $row['id'] . '\')" class="btn btn-success" /></td>';
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