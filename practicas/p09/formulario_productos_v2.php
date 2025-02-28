<!DOCTYPE html>
<html lang="en">
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
          event.preventDefault();//previene errores de validación
          const errors = document.querySelectorAll('.error');
          errors.forEach(error => { error.textContent = ''; });
          
          const nombre = document.getElementById('form-name');
          const marca = document.getElementById('form-marca');
          const modelo = document.getElementById('form-modelo');
          const precio = document.getElementById('form-precio');
          const detalles = document.getElementById('form-detalles');
          const unidades = document.getElementById('form-unidades');

          //Funcion de la api de validación
          if (!nombre.checkValidity()) {
              document.getElementById('error-name').textContent = 'Nombre obligatorio, máximo 100 caracteres.';
          }

          if (!marca.checkValidity()) {
              document.getElementById('error-marca').textContent = 'Selecciona una marca.';
          }

          if (!modelo.checkValidity()) {
              document.getElementById('error-modelo').textContent = 'Modelo obligatorio, máximo 25 caracteres alfanumericos.';
          }

          if (!precio.checkValidity()) {
              document.getElementById('error-precio').textContent = 'Precio obligatorio, debe ser mayor a 99.9.';
          }

          if (!unidades.checkValidity()) {
              document.getElementById('error-unidades').textContent = 'Unidades obligatorias, no pueden ser negativas.';
          }

          // If all are valid, form can be submitted
          if (this.querySelectorAll(':invalid').length === 0) {
              this.submit();
          }
      });
  });
  </script>
</head>
<body>
<?php
if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    $link = new mysqli('localhost', 'root', 'gatin_123', 'marketzone');
    if ($link->connect_errno) {
        die('Falló la conexión: ' . $link->connect_error);
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
    <h1>Registro de productos</h1>
    <p>En este formulario podrás registrar los datos de tu producto.</p>
    <form id="formularioProductos" novalidate action="http://localhost/tecweb/practicas/p08/set_productos_v2.php" method="post" enctype="multipart/form-data">
        <fieldset>
    <legend>Información del Producto</legend>

    <!-- Campo Nombre -->
    <label for="form-name">Nombre:</label>
    <input type="text" id="form-name" required maxlength="100" placeholder="Max 100 caracteres" name="name" value="<?php echo isset($productData) ? $productData['nombre'] : ''; ?>">
    <span id="error-name" class="error"></span>
    <br>

    <!-- Campo Marca -->
    <label for="form-marca">Marca:</label>
    <select id="form-marca" name="marca" required>
        <option value="">Seleccionar</option>
        <option value="Sylvanian Families" <?php echo isset($productData) && $productData['marca'] == 'Sylvanian Families' ? 'selected' : ''; ?>>Sylvanian Families</option>
        <option value="Honey Bee" <?php echo isset($productData) && $productData['marca'] == 'Honey Bee' ? 'selected' : ''; ?>>Honey Bee</option>
        <option value="Calico critters" <?php echo isset($productData) && $productData['marca'] == 'Calico critters' ? 'selected' : ''; ?>>Calico critters</option>
        <option value="Chafarines" <?php echo isset($productData) && $productData['marca'] == 'Chafarines' ? 'selected' : ''; ?>>Chafarines</option>
        <option value="Epoch" <?php echo isset($productData) && $productData['marca'] == 'Epoch' ? 'selected' : ''; ?>>Epoch</option>
        <option value="otra" <?php echo isset($productData) && $productData['marca'] == 'otra' ? 'selected' : ''; ?>>Otra</option>
    </select>
    <span id="error-marca" class="error"></span>
    <br>

    <!-- Campo Modelo -->
    <label for="form-modelo">Modelo:</label>
    <input type="text" id="form-modelo" required maxlength="25" pattern="[A-Za-z0-9]+" placeholder="Max 25 caracteres alfanuméricos" name="modelo" value="<?php echo isset($productData) ? $productData['modelo'] : ''; ?>">
    <span id="error-modelo" class="error"></span>
    <br>

    <!-- Campo Precio -->
    <label for="form-precio">Precio:</label>
    <input type="number" id="form-precio" name="precio" required min="99.9" placeholder="Mayor a 99.9" step="0.01" value="<?php echo isset($productData) ? $productData['precio'] : ''; ?>">
    <span id="error-precio" class="error"></span>
    <br>

    <!-- Campo Detalles -->
    <label for="form-detalles">Detalles:</label>
    <textarea id="form-detalles" rows="4" cols="50" maxlength="250" placeholder="Max 250 caracteres" name="detalles"><?php echo isset($productData) ? $productData['detalles'] : ''; ?></textarea>
    <span id="error-detalles" class="error"></span>
    <br>

    <!-- Campo Unidades -->
    <label for="form-unidades">Unidades:</label>
    <input type="number" id="form-unidades" required min="0" placeholder="No negativos" name="unidades" value="<?php echo isset($productData) ? $productData['unidades'] : ''; ?>">
    <span id="error-unidades" class="error"></span>
    <br>

    <!-- Campo Imagen (Nota: No es posible precargar un archivo para subida debido a restricciones de seguridad del navegador) -->
    <label for="form-image">Imagen del Producto:</label>
    <input type="file" name="imagen" id="form-image" accept="image/*">
    <br>

    <button type="submit">Registrar Producto</button>
    <button type="reset">Reiniciar Formulario</button>
</fieldset>
    </form>


    
</body>
</html>
