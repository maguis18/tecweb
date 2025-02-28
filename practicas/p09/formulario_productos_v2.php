<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <style>
        .error { color: red; font-size: 0.8em; margin-left: 10px; }
        input, select, textarea { margin-bottom: 10px; }
    </style>
</head>
<body>

<?php
if (isset($_GET['id'])) {
    $productId = intval($_GET['id']);
    $link = new mysqli('localhost', 'root', 'gatin_123', 'marketzone');

    if ($link->connect_errno) {
        die('Error de conexión: ' . $link->connect_error);
    }

    if ($consulta = $link->prepare("SELECT * FROM productos WHERE id = ?")) {
        $consulta->bind_param("i", $productId);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $productData = $resultado->fetch_assoc();
        $consulta->close();
    }

    $link->close();
}
?>

<h1>Editar Producto</h1>
<p>Modifica los datos del producto y guarda los cambios.</p>

<form id="formularioProductos" action="update_producto.php" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend>Información del Producto</legend>
        <input type="hidden" name="id" value="<?php echo $productData['id']; ?>" />

        <label for="form-name">Nombre:</label>
        <input type="text" id="form-name" name="nombre" required maxlength="100" placeholder="Max 100 caracteres" value="<?php echo $productData['nombre']; ?>">
        <span id="error-name" class="error"></span>
        <br>

        <label for="form-marca">Marca:</label>
        <select id="form-marca" name="marca" required>
            <option value="">Seleccionar</option>
            <option value="Sylvanian Families" <?php echo ($productData['marca'] == 'Sylvanian Families') ? 'selected' : ''; ?>>Sylvanian Families</option>
            <option value="Honey Bee" <?php echo ($productData['marca'] == 'Honey Bee') ? 'selected' : ''; ?>>Honey Bee</option>
            <option value="Calico critters" <?php echo ($productData['marca'] == 'Calico critters') ? 'selected' : ''; ?>>Calico critters</option>
            <option value="Chafarines" <?php echo ($productData['marca'] == 'Chafarines') ? 'selected' : ''; ?>>Chafarines</option>
            <option value="Epoch" <?php echo ($productData['marca'] == 'Epoch') ? 'selected' : ''; ?>>Epoch</option>
            <option value="otra" <?php echo ($productData['marca'] == 'otra') ? 'selected' : ''; ?>>Otra</option>
        </select>
        <span id="error-marca" class="error"></span>
        <br>

        <label for="form-modelo">Modelo:</label>
        <input type="text" id="form-modelo" name="modelo" required maxlength="25" pattern="[A-Za-z0-9]+" placeholder="Max 25 caracteres alfanuméricos" value="<?php echo $productData['modelo']; ?>">
        <span id="error-modelo" class="error"></span>
        <br>

        <label for="form-precio">Precio:</label>
        <input type="number" id="form-precio" name="precio" required min="99.9" step="0.01" placeholder="Mayor a 99.9" value="<?php echo $productData['precio']; ?>">
        <span id="error-precio" class="error"></span>
        <br>

        <label for="form-detalles">Detalles:</label>
        <textarea id="form-detalles" name="detalles" rows="4" cols="50" maxlength="250" placeholder="Max 250 caracteres"><?php echo $productData['detalles']; ?></textarea>
        <span id="error-detalles" class="error"></span>
        <br>

        <label for="form-unidades">Unidades:</label>
        <input type="number" id="form-unidades" name="unidades" required min="0" placeholder="No negativos" value="<?php echo $productData['unidades']; ?>">
        <span id="error-unidades" class="error"></span>
        <br>

        <label>Imagen Actual:</label><br>
        <?php if (!empty($productData['imagen'])): ?>
            <img src="<?php echo $productData['imagen']; ?>" alt="Imagen del Producto" width="100">
        <?php endif; ?>
        <br>

        <label for="form-image">Cambiar Imagen:</label>
        <input type="file" name="imagen" id="form-image" accept="image/*">
        <br>

        <button type="submit">Guardar Cambios</button>
        <button type="reset">Reiniciar Formulario</button>
    </fieldset>
</form>

</body>
</html>
