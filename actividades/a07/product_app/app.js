

$(document).ready(function(){
    let edit = false;
    $('#product-result').hide();
    listarProductos();

    function listarProductos() {
        $.ajax({
            url: './backend/product-list.php',
            type: 'GET',
            success: function(response) {
                // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
                const productos = JSON.parse(response);
            
                // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
                if(Object.keys(productos).length > 0) {
                    // SE CREA UNA PLANTILLA PARA CREAR LAS FILAS A INSERTAR EN EL DOCUMENTO HTML
                    let template = '';

                    productos.forEach(producto => {
                        // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
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
                url: './backend/product-search.php?search='+$('#search').val(),
                data: {search},
                type: 'GET',
                success: function (response) {
                    if(!response.error) {
                        // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
                        const productos = JSON.parse(response);
                        
                        // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
                        if(Object.keys(productos).length > 0) {
                            // SE CREA UNA PLANTILLA PARA CREAR LAS FILAS A INSERTAR EN EL DOCUMENTO HTML
                            let template = '';
                            let template_bar = '';

                            productos.forEach(producto => {
                                // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
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
                                            <button class="product-delete btn btn-danger">
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                `;

                                template_bar += `
                                    <li>${producto.nombre}</il>
                                `;
                            });
                            // SE HACE VISIBLE LA BARRA DE ESTADO
                            $('#product-result').show();
                            // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
                            $('#container').html(template_bar);
                            // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                            $('#products').html(template);    
                        }
                    }
                }
            });
        }
        else {
            $('#product-result').hide();
        }
    });
//buscar nombre repetido
$('#name').on('keyup', function() {
    const nombre = $(this).val().trim();
    //const productId = $('#productId').val();
    if (!this.checkValidity()) {
        $('#error-name').text('Nombre obligatorio, máximo 100 caracteres.');
        $('#error-name-existe').text(''); // Limpiar mensaje de validación asíncrona
        return; // Detener la ejecución si la validación básica falla
    } else {
        $('#error-name').text('Nombre valido'); // Limpiar mensaje de validación básica si es válido
    }
    if (nombre.length > 0) {
        $.ajax({
            url: './backend/product-singlebyname.php',
            type: 'GET',
            data: { nombre: nombre ,
                //id: productId
            },
            success: function(response) {
                const productos = JSON.parse(response);
                if(Object.keys(productos).length > 0) {
                    // Si hay productos con el mismo nombre, mostrar error
                    $('#error-name').text('El nombre del producto ya existe.');
                    //$('#product-result').show();
                } else {
                    // Si no hay productos con el mismo nombre, limpiar el mensaje de error
                    $('#error-name').text('Nombre valido');
                }
            },
        });
    } else {
        $('#error-name').text('');
        $('#error-name-existe').text('');
    }
});

    /*$('#name').focusout(function() {
        if (!this.checkValidity()) {
            $('#error-name').text('Nombre obligatorio, máximo 100 caracteres.');
        } else {
            $('#error-name').text('');
        }
    }
    );*/

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
    $('#product-form').submit(e => {
        e.preventDefault();
        if ($('#error-name-existe').text() !== '') {
            //alert('El nombre del producto ya existe. Por favor, elige otro nombre.');
            return;
        }
        if ($('#product-form').find(':invalid').length > 0) {
            $('#product-form').find(':invalid').trigger('focusout');
            return;
        }
        // SE CONVIERTE EL JSON DE STRING A OBJETO
        
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

  
        const url = edit === false ? './backend/product-add.php' : './backend/product-edit.php';
        
        $.post(url, postData, (response) => {
            console.log("Respuesta del servidor:", response);
            // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
            let respuesta = JSON.parse(response);
            // SE CREA UNA PLANTILLA PARA CREAR INFORMACIÓN DE LA BARRA DE ESTADO
            let template_bar = '';
            template_bar += `
                        <li style="list-style: none;">status: ${respuesta.status}</li>
                        <li style="list-style: none;">message: ${respuesta.message}</li>
                    `;
            // SE REINICIA EL FORMULARIO
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
            // SE HACE VISIBLE LA BARRA DE ESTADO
            $('#product-result').show();
            // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
            $('#container').html(template_bar);
            // SE LISTAN TODOS LOS PRODUCTOS
            listarProductos();
            // SE REGRESA LA BANDERA DE EDICIÓN A false
            edit = false;
        });
    });

    $(document).on('click', '.product-delete', (e) => {
        if(confirm('¿Realmente deseas eliminar el producto?')) {
            const element = $(this)[0].activeElement.parentElement.parentElement;
            const id = $(element).attr('productId');
            $.post('./backend/product-delete.php', {id}, (response) => {
                $('#product-result').hide();
                listarProductos();
            });
        }
    });
//editar producto
    $(document).on('click', '.product-item', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(element).attr('productId');
        $.post('./backend/product-single.php', {id}, (response) => {
            // SE CONVIERTE A OBJETO EL JSON OBTENIDO
            $('button.btn-primary').text("Modificar Producto");
            let product = JSON.parse(response);
            // SE INSERTAN LOS DATOS ESPECIALES EN LOS CAMPOS CORRESPONDIENTES
            $('#name').val(product.nombre);
            $('#form-marca').val(product.marca);
            $('#form-modelo').val(product.modelo);
            $('#form-precio').val(product.precio);
            $('#form-detalles').val(product.detalles);
            $('#form-unidades').val(product.unidades);
            $('#productId').val(product.id);
            $('#form-imagen').val(product.imagen);
            $('#error-name-existe').text('');
            edit = true;
        });
        e.preventDefault();
    });    
});