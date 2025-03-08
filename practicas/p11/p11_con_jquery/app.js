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
  // Llama a init() cuando el DOM esté listo
  init();
fetchProducts();
  // Evento keyup para el campo de búsqueda
  $('#search').keyup(function(e) {
    var search = $('#search').val();
    if (search) {
      $.ajax({
        url: 'backend/product-search.php',
        type: 'GET',
        data: { search: search },
        success: function(response) {
          var products = JSON.parse(response);
          console.log(products);
          var template = '';
          products.forEach(function(product) {
            template += `
            <li><a href="#" class="product-item">${task.name}</a></li>
           ` 
          });
          $('#product-result').show();
          $('#container').html(template);
        }
      });
    }
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
  }); // Fin de submit
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

        
  });


