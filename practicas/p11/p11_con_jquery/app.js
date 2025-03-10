// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
  "precio": 0.0,
  "unidades": 1,
  "modelo": "XX-000",
  "marca": "NA",
  "detalles": "NA",
  "imagen": "img/default.png"
};

function init() {
  // Convierte el JSON a string para poder mostrarlo
  var JsonString = JSON.stringify(baseJSON, null, 2);
  console.log("Ejecutando init():", JsonString);
  document.getElementById("description").value = JsonString;
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
      $('#product-result').addClass('d-none').hide();
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
              <td><button class="product-delete btn btn-danger">Eliminar</button></td>
            </tr>
          `;
        });
        $('#product-result').removeClass('d-none').show();
        $('#container').html(listTemplate);
        $('#products').html(tableTemplate);
      }
    });
  });


  // Evento de envío del formulario
  $('#product-form').submit(function(e) { 
    e.preventDefault();
    let postData = JSON.parse($('#description').val());
    postData['nombre'] = $('#name').val();
    postData['id'] = $('#productId').val();
    let url = edit === false ? './backend/product-add.php' : './backend/product-edit.php';



    $.ajax({
      url: url,
      type: 'POST',
      data: JSON.stringify(postData),
      contentType: 'application/json; charset=utf-8',
      dataType: 'json', // Esto fuerza a jQuery a parsear la respuesta como JSON
      success: function(response) {
        console.log("Respuesta del servidor:", response);
        if(response.status === 'error') {
          alert("Error: " + response.message);
          return;
        }
        alert(response.message);
        let template_bar = `
          <li style="list-style-type:none;">status: ${response.status}</li>
          <li style="list-style-type:none;">message: ${response.message}</li>
        `;
        $('#name').val('');
        init(); // Restaura el JSON base en el textarea
        $('#product-result').show();
        $('#container').html(template_bar);
        fetchProducts();
        edit = false;
      },
      error: function(xhr, status, error) {
        console.error("Error en la petición AJAX:", status);
        alert("Ocurrió un error en la petición: ");
      }
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
            template += `
            <tr productId="${product.id}">
              <td>${product.id}</td>
              <td>
              <a href="#" class="product-item">
              ${product.nombre}
              </a>
              </td>
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
      if(confirm('¿Estas seguro de eliminar este elemento?')) {
        const id = $(this).closest('tr').attr('productId');
        $.get('backend/product-delete.php', {id}, (response) => {
          const result = JSON.parse(response); 
            alert(result.message);
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
        $('#name').val(response.nombre);
        $('#productId').val(response.id);
        
        // Se crea un nuevo objeto quitando 'id' y 'nombre'
        let { id, nombre, ...productData } = response;
        
        // Ahora se muestra en el textarea solo el resto de la información
        $('#description').val(JSON.stringify(productData, null, 2));
        edit = true;
      }, 'json');
    });

});


