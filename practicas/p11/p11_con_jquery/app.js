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

        $('#product-form').submit(e => {
            e.preventDefault();
            const postData = {
              nombre: $('#name').val(),
              json: $('#description').val(),
              productId: $('#productId').val()
            };

});