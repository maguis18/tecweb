// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

// FUNCIÓN CALLBACK DE BOTÓN "Buscar"
function buscarID(e) {
    e.preventDefault();

    // OBTENEMOS EL TEXTO QUE SE DESEA BUSCAR
    var terminoBuscar = document.getElementById('search').value;

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        if (client.readyState == 4 && client.status == 200) {
            console.log('[CLIENTE]\n'+client.responseText);
            
            // SE OBTIENE EL ARRAY DE PRODUCTOS A PARTIR DE UN STRING JSON
            let productos = JSON.parse(client.responseText);

            // VERIFICAMOS SI HAY PRODUCTOS
            if(productos.length > 0) {
                // CONSTRUIMOS UNA CADENA PARA LAS FILAS DE LA TABLA
                let template = '';

                productos.forEach((prod) => {
                    let descripcion = `
                        <li>precio: ${prod.precio}</li>
                        <li>unidades: ${prod.unidades}</li>
                        <li>modelo: ${prod.modelo}</li>
                        <li>marca: ${prod.marca}</li>
                        <li>detalles: ${prod.detalles}</li>
                    `;
                    template += `
                        <tr>
                            <td>${prod.id}</td>
                            <td>${prod.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                        </tr>
                    `;
                });

                // REMPLAZAMOS EL CUERPO DE LA TABLA CON LAS NUEVAS FILAS
                document.getElementById("productos").innerHTML = template;
            } else {
                // SI NO HAY COINCIDENCIAS, MOSTRAR MENSAJE
                document.getElementById("productos").innerHTML = `
                    <tr>
                        <td colspan="3">No se encontraron resultados</td>
                    </tr>
                `;
            }
        }
    };
    
    // AQUÍ ENVIAMOS LA VARIABLE "buscar" (parte del nombre, marca o detalles)
    client.send("buscar="+encodeURIComponent(terminoBuscar));
}

// FUNCIÓN CALLBACK DE BOTÓN "Agregar Producto" (SIN CAMBIOS)
function agregarProducto(e) {
    e.preventDefault();

    // SE OBTIENE DESDE EL FORMULARIO EL JSON A ENVIAR
    var productoJsonString = document.getElementById('description').value;
    // SE CONVIERTE EL JSON DE STRING A OBJETO
    var finalJSON = JSON.parse(productoJsonString);
    // SE AGREGA AL JSON EL NOMBRE DEL PRODUCTO
    finalJSON['nombre'] = document.getElementById('name').value;
    // SE OBTIENE EL STRING DEL JSON FINAL
    productoJsonString = JSON.stringify(finalJSON,null,2);

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/create.php', true);
    client.setRequestHeader('Content-Type', "application/json;charset=UTF-8");
    client.onreadystatechange = function () {
        if (client.readyState == 4 && client.status == 200) {
            console.log(client.responseText);
        }
    };
    client.send(productoJsonString);
}

// SE CREA EL OBJETO DE CONEXIÓN COMPATIBLE CON EL NAVEGADOR (SIN CAMBIOS)
function getXMLHttpRequest() {
    var objetoAjax;
    try{
        objetoAjax = new XMLHttpRequest();
    } catch(err1){
        try{
            // IE7 y IE8
            objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
        } catch(err2){
            try{
                // IE5 y IE6
                objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
            } catch(err3){
                objetoAjax = false;
            }
        }
    }
    return objetoAjax;
}

// FUNCIÓN INIT PARA MOSTRAR EL JSON BASE (SIN CAMBIOS)
function init() {
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;
}
function buscarProducto(e) {
    e.preventDefault();

    // 1. OBTENER EL TEXTO DE BÚSQUEDA
    let terminoBuscar = document.getElementById('search').value;

    // 2. CREAR EL OBJETO AJAX
    let client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // 3. MANEJO DE LA RESPUESTA
    client.onreadystatechange = function () {
        if (client.readyState === 4 && client.status === 200) {
            console.log("[CLIENTE]\n" + client.responseText);

            // La respuesta es un array de productos
            let productos = JSON.parse(client.responseText);

            // 4. MOSTRAR LOS PRODUCTOS EN LA TABLA
            if (productos.length > 0) {
                let template = "";
                
                productos.forEach((prod) => {
                    // Para cada producto creamos una fila
                    let descripcion = `
                        <li>precio: ${prod.precio}</li>
                        <li>unidades: ${prod.unidades}</li>
                        <li>modelo: ${prod.modelo}</li>
                        <li>marca: ${prod.marca}</li>
                        <li>detalles: ${prod.detalles}</li>
                    `;
                    template += `
                        <tr>
                            <td>${prod.id}</td>
                            <td>${prod.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                        </tr>
                    `;
                });

                // Colocamos el resultado en el cuerpo de la tabla
                document.getElementById("productos").innerHTML = template;
            } else {
                // Si no hay resultados, mostramos un mensaje
                document.getElementById("productos").innerHTML = `
                    <tr>
                        <td colspan="3">No se encontraron productos</td>
                    </tr>
                `;
            }
        }
    };

    // 5. ENVIAR EL TÉRMINO DE BÚSQUEDA
    // (Usamos "buscar" como variable POST en read.php)
    client.send("buscar=" + encodeURIComponent(terminoBuscar));
}

//VALIDACIONES PARA ISNERCION DE PRODUCTOS
document.addEventListener('DOMContentLoaded', function() {
document.getElementById('formularioProductos').addEventListener('submit', function(event) {
    event.preventDefault();
    const errors = document.querySelectorAll('.error');
    errors.forEach(error => { error.textContent = ''; });

    const nombre = document.getElementById('form-name');
    const marca = document.getElementById('form-marca');
    const modelo = document.getElementById('form-modelo');
    const precio = document.getElementById('form-precio');
    const detalles = document.getElementById('form-detalles');
    const unidades = document.getElementById('form-unidades');
    const imagen = document.getElementById('form-image');

    // Validación de la API de validación del navegador
    if (!nombre.checkValidity()) {
        document.getElementById('error-name').textContent = 'Nombre obligatorio, máximo 100 caracteres.';
    }

    if (!marca.checkValidity()) {
        document.getElementById('error-marca').textContent = 'Selecciona una marca.';
    }

    if (!modelo.checkValidity()) {
        document.getElementById('error-modelo').textContent = 'Modelo obligatorio, máximo 25 caracteres alfanuméricos.';
    }

    if (!precio.checkValidity()) {
        document.getElementById('error-precio').textContent = 'Precio obligatorio, debe ser mayor a 99.9.';
    }

    if (!unidades.checkValidity()) {
        document.getElementById('error-unidades').textContent = 'Unidades obligatorias, no pueden ser negativas.';
    }

    // Si todo es válido, se puede enviar el formulario
    if (this.querySelectorAll(':invalid').length === 0) {
        this.submit();
    }
});
});