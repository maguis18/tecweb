function init() {
  $('#product-result').hide();
}

$(document).ready(function() {
  let edit = false; // Bandera para saber si se está en modo edición
  init();
  fetchProducts();

  // Evento keyup para el campo de búsqueda
  $('#search').keyup(function(e) {
    var search = $('#search').val().trim();
    // Si no hay búsqueda, mostramos la lista completa
    if (search === '') {
      fetchProducts();
      $('#product-result').hide();
      $('#container').html('');
      return;
    }
    $.ajax({
      url: 'backend/product-search.php',
      type: 'GET',
      data: { search: search },
      success: function(response) {
        var products = JSON.parse(response);
        var listTemplate = '';
        var tableTemplate = '';
        products.forEach(product => {
          // Construimos la lista para el contenedor (si lo deseas)
          listTemplate += `<li><a href="#" class="product-item">${product.nombre}</a></li>`;
          // Construimos las filas de la tabla
          tableTemplate += `
            <tr productId="${product.id}">
              <td>${product.id}</td>
              <td><a href="#" class="product-item">${product.nombre}</a></td>
              <td>${product.detalles}</td>
              <td>
                <button class="product-delete btn btn-danger">Eliminar</button>
                <button class="product-edit btn btn-warning">Editar</button>
              </td>
            </tr>
          `;
        });
        $('#product-result').show();
        $('#container').html(listTemplate);
        $('#products').html(tableTemplate);
      }
    });
  });

  // Validación del nombre repetido
  $('#name').on('keyup', function() {
    const nombre = $(this).val().trim();
    const productId = $('#productId').val(); // Obtener el ID del producto en edición

    if (!this.checkValidity()) {
      $('#error-name').text('Nombre obligatorio, máximo 100 caracteres.');
      $('#error-name-existe').text(''); // Limpiar mensaje de validación asíncrona
      return; // Detener la ejecución si la validación básica falla
    } else {
      $('#error-name').text(''); // Limpiar mensaje de validación básica si es válido
    }

    if (nombre.length > 0) {
      $.ajax({
        url: './backend/product-search_v2.php',
        type: 'GET',
        data: { 
          nombre: nombre,
          id: productId // Enviar el ID del producto en edición
        },
        success: function(response) {
          const data = JSON.parse(response);
          if (data.exists) {
            $('#error-name-existe').text('El nombre del producto ya existe.');
          } else {
            $('#error-name-existe').text('');
            $('#error-name').text('Nombre válido.');
          }
        },
        error: function() {
          $('#error-name-existe').text('Error al validar el nombre.');
        }
      });
    } else {
      $('#error-name').text('');
      $('#error-name-existe').text('');
    }
  });
  $('#name').focusout(function() {
    if (!this.checkValidity()) {
        $('#error-name').text('Nombre obligatorio, máximo 100 caracteres.');
    } else {
        $('#error-name').text('');
    }
}
);
  $('#form-marca').focusout(function() {
    if (!this.checkValidity()) {
        $('#error-marca').text('Selecciona una marca.');
    } else {
        $('#error-marca').text('Marca valida.');
    }
});

$('#form-modelo').focusout(function() {
    if (!this.checkValidity()) {
        $('#error-modelo').text('Modelo obligatorio, máximo 25 caracteres alfanuméricos.');
    } else {
        $('#error-modelo').text('Modelo valido.');
    }
});

$('#form-precio').focusout(function() {
    if (!this.checkValidity()) {
        $('#error-precio').text('Precio obligatorio, debe ser mayor a 99.9.');
    } else {
        $('#error-precio').text('Precio valido.');
    }
});

$('#form-unidades').focusout(function() {
    if (!this.checkValidity()) {
        $('#error-unidades').text('Unidades obligatorias, no pueden ser negativas.');
    } else {
        $('#error-unidades').text('Unidades validas.');
    }
});


  // Evento de envío del formulario
  $('#product-form').submit(function(e) { 
    e.preventDefault();

    // Validar si el nombre ya existe
    if ($('#error-name-existe').text() !== '') {
      //alert('El nombre del producto ya existe. Por favor, elige otro nombre.');
      return;
    }

    // Validar si hay campos inválidos
    if ($('#product-form').find(':invalid').length > 0) {
      $('#product-form').find(':invalid').trigger('focusout');
      return;
    }

    let postData = {
      nombre: $('#name').val(),
      marca: $('#form-marca').val(),
      modelo: $('#form-modelo').val(),
      precio: parseFloat($('#form-precio').val()),
      unidades: parseInt($('#form-unidades').val()),
      detalles: $('#form-detalles').val(),
      imagen: $('#form-imagen').val(),
      id: $('#productId').val()
    };

    $('button.btn-primary').text("Agregar Producto");
    let url = edit === false ? './backend/product-add.php' : './backend/product-edit.php';

    $.ajax({
      url: url,
      type: 'POST',
      data: JSON.stringify(postData),
      contentType: 'application/json; charset=utf-8',
      dataType: 'json',
      success: function(response) {
        let template_bar = `
          <li style="list-style-type:none;">status: ${response.status}</li>
          <li style="list-style-type:none;">message: ${response.message}</li>
        `;

        $('#error-name').text('');
            $('#error-name-existe').text('');
            $('#error-marca').text('');
            $('#error-modelo').text('');
            $('#error-precio').text('');
            $('#error-unidades').text('');
        $('#name').val('');
        $('#product-form')[0].reset();
        $('#productId').val('');
        $('#error-name-existe').text('');
        $('#product-result').show();
        $('#container').html(template_bar);
        fetchProducts();
        edit = false;
      },
      error: function(xhr, status, error) {
        let template_bar = `
          <li style="list-style-type:none;">status: error</li>
          <li style="list-style-type:none;">message: ${error}</li>
        `;
        $('#product-result').show();
        $('#container').html(template_bar);
      }
    });
  });

  // Función para obtener y mostrar la lista de productos
  function fetchProducts() {
    $.ajax({
      url: 'backend/product-list.php',
      type: 'GET',
      success: function(response) {
        let products = JSON.parse(response);
        let template = '';
        products.forEach(product => {
          template += `
            <tr productId="${product.id}">
              <td>${product.id}</td>
              <td><a href="#" class="product-item">${product.nombre}</a></td>
              <td>${product.detalles}</td>
              <td>
                <button class="product-delete btn btn-danger">Eliminar</button>
                <button class="product-edit btn btn-warning">Editar</button>
              </td>
            </tr>
          `;
        });
        $('#products').html(template);
      }
    });
  }

  // Evento para eliminar un producto
  $(document).on('click', '.product-delete', function() {
    if (confirm('¿Estas seguro de eliminar este elemento?')) {
      const id = $(this).closest('tr').attr('productId');
      $.get('backend/product-delete.php', { id }, (response) => {
        const result = JSON.parse(response); 
        let template_bar = `
          <li style="list-style-type:none;">status: ${result.status}</li>
          <li style="list-style-type:none;">message: ${result.message}</li>
        `;
        $('#product-result').show();
        $('#container').html(template_bar);
        fetchProducts();
      });
    }
  });

  // Evento para editar un producto
  $(document).on('click', '.product-edit', function() {
    let element = $(this)[0].parentElement.parentElement;
    let id = $(element).attr('productId');
    $.post('backend/product-single.php', { id }, function(response) {
      $('button.btn-primary').text("Modificar Producto");
      $('#name').val(response.nombre);
      $('#productId').val(response.id);
      $('#form-marca').val(response.marca);
      $('#form-modelo').val(response.modelo);
      $('#form-precio').val(response.precio);
      $('#form-detalles').val(response.detalles);
      $('#form-unidades').val(response.unidades);
      $('#form-imagen').val(response.imagen);
      $('#error-name-existe').text('');
      edit = true;
    }, 'json');
  });
});