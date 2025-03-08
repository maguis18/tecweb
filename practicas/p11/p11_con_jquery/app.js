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
    
     /* Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;

    // SE LISTAN TODOS LOS PRODUCTOS
    //listarProductos();
}

$(document).ready(function() {
    //$('#product-result').hide();
        $('#search').keyup(function(e){
            if($('#search').val()){
                let search=$('#search').val();
                //console.log(search);
                $.ajax({
                    url:'backend/product-search.php',
                    type:'GET',
                    data:{search},
                    success: function (response) {
                          let products = JSON.parse(response);
                          console.log(products);
                          let template = '';
                          products.forEach(product => {
                            template += `
                                   <li>${product.nombre}</li>
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
          
              // validamos el nommbre
              let nombreInput = $('#name').val();
              if (nombreInput === '' || nombreInput.length > 100) {
                window.alert("El nombre del producto es obligatorio y máximo 100 caracteres.");
                return;
              }
          
              
              let productoJsonString = $('#description').val();
              let finalJSON;
          
              // etso nos ayuda a obtener los datos de la textarea
              try {
                finalJSON = JSON.parse(productoJsonString);
              } catch (error) {
                window.alert("JSON inválido. Verifica la sintaxis en el textarea.");
                return;
              }
        
              finalJSON.nombre = nombreInput;
          
              // verificamos la marca
              if (!finalJSON.marca || finalJSON.marca.trim() === "") {
                window.alert("El nombre de la marca es obligatorio.");
                return;
              }
          
              // valdiamos el modelo
              if (
                !finalJSON.modelo ||
                finalJSON.modelo.trim() === "" ||
                finalJSON.modelo.length > 25 ||
                !/^[a-zA-Z0-9-]+$/.test(finalJSON.modelo)
              ) {
                window.alert("El modelo es obligatorio, máximo 25 caracteres alfanuméricos.");
                return;
              }
          
              // validamos los detalles
              if (
                !finalJSON.detalles ||
                finalJSON.detalles.trim() === "" ||
                finalJSON.detalles.length > 250
              ) {
                window.alert("Los detalles son obligatorios y deben ser máximo 250 caracteres.");
                return;
              }
          
              //validamos el prwcio
              let numPrecio = parseFloat(finalJSON.precio);
              if (isNaN(numPrecio) || numPrecio <= 99.9) {
                window.alert("El precio debe ser un número mayor a 99.9.");
                return;
              }
          
              //validamos las unidades
              let numUnidades = parseInt(finalJSON.unidades);
              if (isNaN(numUnidades) || numUnidades < 0) {
                window.alert("Las unidades deben ser un número entero mayor o igual a cero.");
                return;
              }
          //si todos los datos cumplem las validaciones
              $.ajax({
                url: 'backend/product-add.php', // Ajusta la ruta si es necesario
                type: 'POST',
                data: JSON.stringify(finalJSON),
                contentType: 'application/json; charset=utf-8',
                success: function(response) {
                  //console.log('Respuesta del servidor:', response);
                  // Intentamos parsear la respuesta para ver si incluye 'status' y 'message'
                  try {
                    let jsonResp = JSON.parse(response);
                    if (jsonResp.status === 'success') {
                      alert(jsonResp.message || 'Producto agregado correctamente.');
                      $('#product-form')[0].reset();
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
            });
          


});