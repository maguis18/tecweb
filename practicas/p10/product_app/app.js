// Archivo: app.js

// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 100.0,
    "unidades": 1,
    "modelo": "XX-001",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

// FUNCIÓN INIT PARA MOSTRAR EL JSON BASE AL CARGAR LA PÁGINA
function init() {
    let JsonString = JSON.stringify(baseJSON, null, 2);
    document.getElementById("description").value = JsonString;
}

// FUNCIÓN CALLBACK DE BOTÓN "Buscar" (Búsqueda por ID en read.php)
function buscarID(e) {
    e.preventDefault();
    let terminoBuscar = document.getElementById('search').value;

    let client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        if (client.readyState == 4 && client.status == 200) {
            console.log('[CLIENTE]\n' + client.responseText);
            
            let productos = JSON.parse(client.responseText);
            if (productos.length > 0) {
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
                document.getElementById("productos").innerHTML = template;
            } else {
                document.getElementById("productos").innerHTML = `
                    <tr>
                        <td colspan="3">No se encontraron resultados</td>
                    </tr>
                `;
            }
        }
    };
    client.send("buscar=" + encodeURIComponent(terminoBuscar));
}

// FUNCIÓN PARA BÚSQUEDA DE PRODUCTOS POR TEXTO (NOMBRE, MARCA, DETALLES, ETC.)
function buscarProducto(e) {
    e.preventDefault();
    let terminoBuscar = document.getElementById('search').value;

    let client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    client.onreadystatechange = function () {
        if (client.readyState === 4 && client.status === 200) {
            console.log("[CLIENTE]\n" + client.responseText);

            let productos = JSON.parse(client.responseText);
            if (productos.length > 0) {
                let template = "";
                
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

                document.getElementById("productos").innerHTML = template;
            } else {
                document.getElementById("productos").innerHTML = `
                    <tr>
                        <td colspan="3">No se encontraron productos</td>
                    </tr>
                `;
            }
        }
    };
    client.send("buscar=" + encodeURIComponent(terminoBuscar));
}

// FUNCIÓN PARA AGREGAR PRODUCTO (INSERTAR EN BD) CON VALIDACIÓN
function agregarProducto(e) {
    e.preventDefault();

    // 1. Obtener el nombre del input
    let nombreInput = document.getElementById('name').value.trim();
    if (nombreInput === '' || nombreInput.length >100) {
        window.alert("El nombre del producto es obligatorio y máximo 100 caracteres.");
        return;
    }

    // 2. LEER EL CONTENIDO DEL <textarea> (resto de datos)
    let productoJsonString = document.getElementById('description').value;
    let finalJSON;

    // 3. Intentar parsear el JSON
    try {
        finalJSON = JSON.parse(productoJsonString);
    } catch (error) {
        window.alert("JSON inválido. Verifica la sintaxis en el textarea.");
        return;
    }
 
    // 4. Sobrescribir el campo 'nombre' con el valor capturado en <input id="name">
    finalJSON['nombre'] = nombreInput;

    if(finalJSON.marca.trim === ""){
        window.alert("El nombre de la marca es obligatorio.");
        return;
    }


    if (!finalJSON.modelo || finalJSON.modelo.trim() === "" || finalJSON.modelo.length > 25 || !/^[a-zA-Z0-9-]+$/.test(finalJSON.modelo)) {
        window.alert("El modelo es obligatorio y debe ser máximo 25 caracteres alfanuméricos y guiones medios.");
        return;
    }

    

    if(finalJSON.detalles.trim() === " " || finalJSON.detalles.length > 250){
        window.alert("los detalles son obligatorios y deben ser máximo 250 caracteres");
        return;
    }


    // 5. Validar otros campos (precio, unidades, etc.) si deseas:
    let numPrecio = parseFloat(finalJSON.precio);
    if (isNaN(numPrecio) || numPrecio <= 99.9) {
        window.alert("El precio debe ser un número mayor a 99.9.");
        return;
    }
    let numUnidades = parseInt(finalJSON.unidades);
    if (isNaN(numUnidades) || numUnidades < 0) {
        window.alert("Las unidades deben ser un número entero mayor o igual a cero.");
        return;
    }
    // Puedes añadir más validaciones (marca, modelo, etc.) si lo requieres

    // 6. Enviar al servidor (create.php) vía AJAX
    var client = getXMLHttpRequest();
    client.open('POST', './backend/create.php', true);
    client.setRequestHeader('Content-Type', "application/json;charset=UTF-8");
    client.onreadystatechange = function () {
        if (client.readyState === 4 && client.status === 200) {
            let resp;
            try {
                resp = JSON.parse(client.responseText);
            } catch (err) {
                window.alert("La respuesta del servidor no es JSON válido.");
                return;
            }

            // Mostrar mensaje con window.alert
            window.alert(resp.message);

            // Si fue éxito, podrías limpiar el input y textarea
            if (resp.status === "success") {
                document.getElementById('name').value = '';
                document.getElementById('description').value = JSON.stringify(baseJSON, null, 2);
            }
        }
    };

    // 7. Enviar el objeto final al servidor
    client.send(JSON.stringify(finalJSON));
}

// FUNCIÓN PARA CREAR XHR COMPATIBLE CON NAVEGADORES ANTIGUOS
function getXMLHttpRequest() {
    var objetoAjax;
    try {
        objetoAjax = new XMLHttpRequest();
    } catch (err1) {
        try {
            objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (err2) {
            try {
                objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (err3) {
                objetoAjax = false;
            }
        }
    }
    return objetoAjax;
}
