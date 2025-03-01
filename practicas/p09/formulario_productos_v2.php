<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Productos</title>
    <style>
        .error {
            color: red;
            font-size: 0.8em;
            margin-left: 10px;
        }
        input, select, textarea {
            margin-bottom: 10px;
        }
    </style>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('formularioProductos').addEventListener('submit', function(event) {
          event.preventDefault();
          const errors = document.querySelectorAll('.error');
          errors.forEach(error => { error.textContent = ''; });

          const nombre = document.getElementById('form-name');
          const marca = document.getElementById('form-marca');
          const modelo = document.getElementById('form-modelo');
          const precio = document.getElementById('form-precio');
          const detalles = document.getElementById('form-detalles');
          const unidades = document.getElementById('form-unidades');
          const imagen = document.getElementById('form-image');

          // Validación de la API de validación del navegador
          if (!nombre.checkValidity()) {
              document.getElementById('error-name').textContent = 'Nombre obligatorio, máximo 100 caracteres.';
          }

          if (!marca.checkValidity()) {
              document.getElementById('error-marca').textContent = 'Selecciona una marca.';
          }

          if (!modelo.checkValidity()) {
              document.getElementById('error-modelo').textContent = 'Modelo obligatorio, máximo 25 caracteres alfanuméricos.';
          }

          if (!precio.checkValidity()) {
              document.getElementById('error-precio').textContent = 'Precio obligatorio, debe ser mayor a 99.9.';
          }

          if (!unidades.checkValidity()) {
              document.getElementById('error-unidades').textContent = 'Unidades obligatorias, no pueden ser negativas.';
          }

          // Si todo es válido, se puede enviar el formulario
          if (this.querySelectorAll(':invalid').length === 0) {
              this.submit();
          }
      });
  });
  </script>
</head>
<body>


    <h1>Registro de productos</h1>
    <p>En este formulario podrás registrar los datos de tu producto.</p>
    <form id="formularioProductos" novalidate action="update_producto.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Información del Producto</legend>
            <input type="hidden" id="form-id" name="id" value="<?= !empty($_POST['id']) ? htmlspecialchars($_POST['id']) : '' ?>">
            <br>
            <label for="form-name">Nombre:</label>
            <input type="text" id="form-name" required maxlength="100" placeholder="Max 100 caracteres" name="name" value="<?= !empty($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>">
            <span id="error-name" class="error"></span>
            <br>
            <label for="form-marca">Marca:</label>
            <select id="form-marca" name="marca" required >
                <option value="">Seleccionar</option>
                <option value="Sylvanian Families" <?= (isset($_POST['marca']) && $_POST['marca'] == 'Sylvanian Families') ? 'selected' : '' ?>>Sylvanian Families</option>
                <option value="Honey Bee" <?= (isset($_POST['marca']) && $_POST['marca'] == 'Honey Bee') ? 'selected' : '' ?>>Honey Bee</option>
                <option value="Calico critters" <?= (isset($_POST['marca']) && $_POST['marca'] == 'Calico critters') ? 'selected' : '' ?>>Calico critters</option>
                <option value="Chafarines" <?= (isset($_POST['marca']) && $_POST['marca'] == 'Chafarines') ? 'selected' : '' ?>>Chafarines</option>
                <option value="Epoch" <?= (isset($_POST['marca']) && $_POST['marca'] == 'Epoch') ? 'selected' : '' ?>>Epoch</option>
                <option value="otra" <?= (isset($_POST['marca']) && $_POST['marca'] == 'otra') ? 'selected' : '' ?>>Otra</option>
            </select>
            <span id="error-marca" the="error"></span>
            <br>
            <label for="form-modelo">Modelo:</label>
            <input type="text" id="form-modelo" required maxlength="25" placeholder="Max 25 caracteres alfanuméricos" pattern="[A-Za-z0-9]+" name="modelo" value="<?= !empty($_POST['modelo']) ? htmlspecialchars($_POST['modelo']) : '' ?>">
            <span id="error-modelo" class="error"></span>
            <br>
            <label for="form-precio">Precio:</label>
            <input type="number" id="form-precio" name="precio" required min="99.9" placeholder="Mayor a 99.9" step="0.01" value="<?= !empty($_POST['precio']) ? htmlspecialchars($_POST['precio']) : '' ?>">
            <span id="error-precio" class="error"></span>
            <br>
            <label for="form-detalles">Detalles:</label>
            <textarea id="form-detalles" rows="4" cols="50" maxlength="250" placeholder="Max 250 caracteres" name="detalles"><?= !empty($_POST['detalles']) ? htmlspecialchars($_POST['detalles']) : '' ?></textarea>
            <span id="error-detalles" class="error"></span>
            <br>
            <label for="form-unidades">Unidades:</label>
            <input type="number" id="form-unidades" required min="0" placeholder="No negativos" name="unidades" value="<?= !empty($_POST['unidades']) ? htmlspecialchars($_POST['unidades']) : '' 
            ?>">
            <span id="error-unidades" class="error"></span>
            <br>

            <label for="form-image">Imagen Actual del Producto:</label><br>
            <?php if (!empty($_POST['imagen'])): ?>
                <img src="<?= htmlspecialchars($_POST['imagen']) ?>" alt="Imagen del Producto" style="width: 100px;"><br>
            <?php else: ?>
                <span>No hay imagen disponible</span><br>
            <?php endif; ?>

            <!-- Campo oculto para mantener la ruta anterior si el usuario NO sube nada nuevo -->
            <input type="hidden" name="imagen_anterior" value="<?= !empty($_POST['imagen']) ? htmlspecialchars($_POST['imagen']) : '' ?>">

            <label for="form-image">Cambiar Imagen:</label>
            <input type="file" name="imagen" id="form-image" accept="image/*"><br>



            <br>
            <button type="submit">Registrar</button>
            <button type="reset">Reiniciar Formulario</button>
        </fieldset>
    </form>
</body>
</html>
