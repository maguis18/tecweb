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
    e.preventDefault(); // Evita que se recargue la página
//fetchProducts();
    // Validamos el nombre
    let nombreInput = $('#name').val();
    if (nombreInput === '' || nombreInput.length > 100) {
      window.alert("El nombre del producto es obligatorio y máximo 100 caracteres.");
      return;
    }

    // Obtenemos el contenido del textarea
    let productoJsonString = $('#description').val();
    let finalJSON;
    try {
      finalJSON = JSON.parse(productoJsonString);
    } catch (error) {
      window.alert("JSON inválido. Verifica la sintaxis en el textarea.");
      return;
    }

    finalJSON.nombre = nombreInput;

    // Validamos la marca
    if (!finalJSON.marca || finalJSON.marca.trim() === "") {
      window.alert("El nombre de la marca es obligatorio.");
      return;
    }

    // Validamos el modelo
    if (
      !finalJSON.modelo ||
      finalJSON.modelo.trim() === "" ||
      finalJSON.modelo.length > 25 ||
      !/^[a-zA-Z0-9-]+$/.test(finalJSON.modelo)
    ) {
      window.alert("El modelo es obligatorio, máximo 25 caracteres alfanuméricos.");
      return;
    }

    // Validamos los detalles
    if (
      !finalJSON.detalles ||
      finalJSON.detalles.trim() === "" ||
      finalJSON.detalles.length > 250
    ) {
      window.alert("Los detalles son obligatorios y deben ser máximo 250 caracteres.");
      return;
    }

    // Validamos el precio
    let numPrecio = parseFloat(finalJSON.precio);
    if (isNaN(numPrecio) || numPrecio <= 99.9) {
      window.alert("El precio debe ser un número mayor a 99.9.");
      return;
    }

    // Validamos las unidades
    let numUnidades = parseInt(finalJSON.unidades);
    if (isNaN(numUnidades) || numUnidades < 0) {
      window.alert("Las unidades deben ser un número entero mayor o igual a cero.");
      return;
    }

    // Envío AJAX para agregar el producto
    $.ajax({
      url: 'backend/product-add.php',
      type: 'POST',
      data: JSON.stringify(finalJSON),
      contentType: 'application/json; charset=utf-8',
      success: function(response) {
        try {
          let jsonResp = JSON.parse(response);
          if (jsonResp.status === 'success') {
            alert(jsonResp.message || 'Producto agregado correctamente.');
            $('#product-form')[0].reset();
            fetchProducts();
            init();
          } else {
            alert(jsonResp.message || 'Ocurrió un error al agregar el producto.');
          }
        } catch (e) {
          alert('Ocurrió un error al procesar la respuesta del servidor.');
        }
      },
      error: function(xhr, status, error) {
        console.error(error);
        alert('Ocurrió un error en la solicitud AJAX.');
      }
    });
  }
  );
  


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
      if(confirm('¿Estas seguro de eliminar etse elemento?')) {
        const id = $(this).closest('tr').attr('productId');
        $.get('backend/product-delete.php', {id}, (response) => {
          fetchProducts();
        });
        }
        });

        $(document).on('click', '.product-item', function(e) {
          e.preventDefault();
          let element = $(this).closest('tr');
          let id = element.attr('productId');
          $.post('backend/product-single.php', { id: id }, function(response) {
            let product = JSON.parse(response);
            $('#name').val(product.nombre);
            // Se reconstruye el objeto JSON con las propiedades del producto (excepto el nombre, que se muestra en el input)
            let productData = {
              precio: product.precio,
              unidades: product.unidades,
              modelo: product.modelo,
              marca: product.marca,
              detalles: product.detalles,
              imagen: product.imagen
            };
            $('#description').val(JSON.stringify(productData, null, 2));
            $('#productId').val(product.id);
            edit = true;
          });
        });
//funcion para editar
/*$(document).on('click', '.product-item', function() {
  const element = $(this)[0].activeElement.parentElement.parentElement;
  const id = $(element).attr('productId');
  $.post('product-single.php', {id}, (response) => {
    const product = JSON.parse(response);
    $('#name').val(task.nombre);
    $('#description').val(task.description);
    $('#taskId').val(task.id);
    edit = true;
  });
  e.preventDefault();
});*/

});


