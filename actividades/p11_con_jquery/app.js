
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
        productos.forEach(producto => {
        let descripcion = `
            <li>precio: ${producto.precio}</li>
            <li>unidades: ${producto.unidades}</li>
            <li>modelo: ${producto.modelo}</li>
            <li>marca: ${producto.marca}</li>
            <li>detalles: ${producto.detalles}</li>
          `;
          template += `
            <tr productId="${producto.id}">
              <td>${producto.id}</td>
              <td><a href="#" class="product-item">${producto.nombre}</a></td>
              <td><ul>${descripcion}</ul></td>
              <td>
                <button class="product-delete btn btn-danger">Eliminar</button>
                <button class="product-edit btn btn-warning">Editar</button>
              </td>
            </tr>
          `;
          template_bar += `<li>${producto.nombre}</li>`;
        });
        $('#product-result').show();
        $('#container').html(listTemplate);
        $('#products').html(tableTemplate);
      }
    });
  });



  // Evento de envío del formulario
  $('#product-form').submit(function(e) { 
    e.preventDefault();
    
    if ($('#error-name-existe').text() !== '') {
      alert('El nombre del producto ya existe. Por favor, elige otro nombre.');
      return;
    }

    // Validar si hay campos inválidos
    if ($('#product-form').find(':invalid').length > 0) {
      $('#product-form').find(':invalid').trigger('focusout');
      return;
    }

    // Crear el objeto con los datos del formulario
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

    $.post(url, postData, function(response) {
      const respuesta = JSON.parse(response);
      let template_bar = `
          <li style="list-style-type:none;">status: ${response.status}</li>
          <li style="list-style-type:none;">message: ${response.message}</li>
        `;
        $('#name').val('');
      $('#product-form')[0].reset();
      $('#productId').val('');
      $('#error-name-existe').text('');
      // Mostrar la barra de estado
      $('#product-result').show();
      $('#container').html(template_bar);
      // Actualizar la lista de productos
      fetchProducts();
      // Regresar la bandera de edición a false
      edit = false;
    });
  });

 // Fin de submit
    // Función para obtener y mostrar la lista de productos
    function fetchProducts() {
      $.ajax({
        url: 'backend/product-list.php',
        type: 'GET',
        success: function(response) {
          let products = JSON.parse(response);
          let template = '';
          products.forEach(product => {
            let descripcion = `
            <li>precio: ${producto.precio}</li>
            <li>unidades: ${producto.unidades}</li>
            <li>modelo: ${producto.modelo}</li>
            <li>marca: ${producto.marca}</li>
            <li>detalles: ${producto.detalles}</li>
          `;
            template += `
            <tr productId="${product.id}">
              <td>${product.id}</td>
              <td>
              <a href="#" class="product-item">
              ${product.nombre}
              </a>
              <td><ul>${descripcion}</ul></td>
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
      if(confirm('¿Estas seguro de eliminar este elemento?')) {
        const id = $(this).closest('tr').attr('productId');
        $.get('backend/product-delete.php', {id}, (response) => {
          const result = JSON.parse(response); 
          let template_bar = `
          <li style="list-style-type:none;">status: ${result.status}</li>
          <li style="list-style-type:none;">message: ${result.message}</li>
        `;
            //alert(result.message);
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
        // Asigna el nombre al input correspondiente y el id al campo oculto
        $('button.btn-primary').text("Modificar Producto");
        $('#name').val(response.nombre);
        $('#productId').val(response.id);
        
        // Se crea un nuevo objeto quitando 'id' y 'nombre'
        let { id, nombre, ...productData } = response;
        
        // Ahora se muestra en el textarea solo el resto de la información
        $('#description').val(JSON.stringify(productData, null, 2));
        edit = true;
      }, 'json');
      let template_bar = `
          <li style="list-style-type:none;">status: ${response.status}</li>
          <li style="list-style-type:none;">message: ${response.message}</li>
        `;
            //alert(result.message);
            $('#product-result').show();
            $('#container').html(template_bar);
            fetchProducts();
    });

});


