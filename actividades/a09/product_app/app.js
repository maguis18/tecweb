// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

$(document).ready(function(){
    let edit = false;

    let JsonString = JSON.stringify(baseJSON,null,2);
    $('#description').val(JsonString);
    $('#product-result').hide();
    listarProductos();

    function listarProductos() {
        $.ajax({
            url: 'http://localhost/tecweb/actividades/a09/product_app/backend/products',
            type: 'GET',
            dataType: 'json',
            success: function(productos) {
                // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
                //const productos = JSON.parse(response);
                //console.log("Respuesta cruda:", response); 
                if(Object.keys(productos).length > 0) {
                    // SE CREA UNA PLANTILLA PARA CREAR LAS FILAS A INSERTAR EN EL DOCUMENTO HTML
                    let template = '';

                    productos.forEach(producto => {
                        // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                        let descripcion = '';
                        descripcion += '<li>precio: '+producto.precio+'</li>';
                        descripcion += '<li>unidades: '+producto.unidades+'</li>';
                        descripcion += '<li>modelo: '+producto.modelo+'</li>';
                        descripcion += '<li>marca: '+producto.marca+'</li>';
                        descripcion += '<li>detalles: '+producto.detalles+'</li>';
                    
                        template += `
                            <tr productId="${producto.id}">
                                <td>${producto.id}</td>
                                <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                <td><ul>${descripcion}</ul></td>
                                <td>
                                    <button class="product-delete btn btn-danger">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                    $('#products').html(template);
                }
            }
        });
    }

    $('#search').keyup(function() {
        if($('#search').val()) {
            let search = $('#search').val();
            $.ajax({
                url: 'http://localhost/tecweb/actividades/a09/product_app/backend/products/' + encodeURIComponent(search),
                data: {search},
                type: 'GET',
                dataType: 'json',
                success: function (productos) {
                    if (Object.keys(productos).length > 0) {
                        let template = '';
                        let template_bar = '';

                        productos.forEach(producto => {
                            let descripcion = `
                                <li>precio: ${producto.precio}</li>
                                <li>unidades: ${producto.unidades}</li>
                                <li>modelo: ${producto.modelo}</li>
                                <li>marca: ${producto.marca}</li>
                                <li>detalles: ${producto.detalles}</li>`;

                            template += `
                                <tr productId="${producto.id}">
                                    <td>${producto.id}</td>
                                    <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                    <td><ul>${descripcion}</ul></td>
                                    <td>
                                        <button class="product-delete btn btn-danger">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>`;

                            template_bar += `<li>${producto.nombre}</li>`;
                        });

                        $('#product-result').show();
                        $('#container').html(template_bar);
                        $('#products').html(template);
                    }
                }
            });
        } else {
            $('#product-result').hide();
        }
    });

    $('#product-form').submit(e => {
        e.preventDefault();
    
        // Convierte el textarea en objeto
        const postData = JSON.parse($('#description').val());
        postData.nombre = $('#name').val();
        postData.id     = $('#productId').val();  // "" cuando es alta
    
        const url    = 'http://localhost/tecweb/actividades/a09/product_app/backend/product';
        const method = edit ? 'PUT' : 'POST';
    
        $.ajax({
            url,
            method,
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            data: JSON.stringify(postData),
            success: (respuesta) => {
                const template_bar = `
                    <li style="list-style:none;">status: ${respuesta.status}</li>
                    <li style="list-style:none;">message: ${respuesta.message}</li>`;
                $('#name').val('');
                $('#description').val(JSON.stringify(baseJSON, null, 2));
                $('#product-result').show();
                $('#container').html(template_bar);
                listarProductos();
                edit = false;
            }
        });
    });

    $(document).on('click', '.product-delete', () => {
        if (confirm('¿Realmente deseas eliminar el producto?')) {
            const element = $(this)[0].activeElement.parentElement.parentElement;
            const id = $(element).attr('productId');
    
            $.ajax({
                url: 'http://localhost/tecweb/actividades/a09/product_app/backend/product',
                method: 'DELETE',
                contentType: 'application/json; charset=utf-8',
                dataType: 'json',
                data: JSON.stringify({ id }),
                success: (result) => {
                    const template_bar = `
                        <li style="list-style:none;">status: ${result.status}</li>
                        <li style="list-style:none;">message: ${result.message}</li>`;
                    $('#product-result').show();
                    $('#container').html(template_bar);
                    listarProductos();
                }
            });
        }
    });

    $(document).on('click', '.product-item', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(element).attr('productId');
    
        $.ajax({
            url: 'http://localhost/tecweb/actividades/a09/product_app/backend/product/' + id,
            method: 'GET',
            dataType: 'json',
            success: (product) => {
                $('#name').val(product.nombre);
                $('#productId').val(product.id);
    
                delete product.nombre;
                delete product.eliminado;
                delete product.id;
    
                $('#description').val(JSON.stringify(product, null, 2));
                edit = true;
            }
        });
        e.preventDefault();
    });
}
);