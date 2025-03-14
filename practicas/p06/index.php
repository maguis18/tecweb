<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 4</title>
</head>

<body>
    <h2>Ejercicio 1</h2>
    <p>Escribir programa para comprobar si un número es un múltiplo de 5 y 7</p>
    <?php
    require_once __DIR__ . '/src/funciones.php';

        if(isset($_GET['numero']))
        {
        es_multiplo7y5($_GET['numero']);
        }
    ?>

<h2>Ejercicio 2</h2>
    <p>
    Crea un programa para la generación repetitiva de 3 número aleatorios hasta obtener una secuencia compuesta por:impar, par, impar.
    <br>
    Estos números deben almacenarse en una matriz de Mx3, donde M es el número de filas y 3 el número de columnas. Al final muestra el número de iteraciones y la cantidad de números generados:12 números obtenidos en 4 iteraciones </p>

<?php
    require_once __DIR__ . '/src/funciones.php';
    secuencia();
?>

<H2>Ejercicio3</H2>
<p>Utiliza un ciclo while para encontrar el primer número entero obtenido aleatoriamente,
pero que además sea múltiplo de un número dado.</p>
<ul>
    <li>
    Crear una variante de este script utilizando el ciclo do-while.
    </li>
    <li>
    El número dado se debe obtener vía GET.
    </li>
</ul>
<h4>usando while</h4>
<?php
    require_once __DIR__ . '/src/funciones.php';
    if(isset($_GET['numero']))
    {
    primer_numero($_GET['numero']);
    }
?>
<h4>usando do while</h4>
<?php
    require_once __DIR__ . '/src/funciones.php';
    if(isset($_GET['numero']))
    {
    primer_numero_do_while($_GET['numero']);
    }
?>
<h2>Ejercicio 4</h2>
<p>Crear un arreglo cuyos índices van de 97 a 122 y cuyos valores son las letras de la ‘a’
a la "z". Usa la función chr(n) que devuelve el caracter cuyo código ASCII es n para poner
el valor en cada índice. Es decir:</p>
<p>[97] => a
    <br>
[98] => b
<br>
[99] => c
<br>
...
<br>
[122] => z
</p>
<ul>
    <li>Crea el arreglo con un ciclo for</li>
    <li>Lee el arreglo y crea una tabla en XHTML con echo y un ciclo foreach
foreach ($arreglo as $key => $value) {
# code...
} </li>
</ul>

<?php
    require_once __DIR__ . '/src/funciones.php';
    abecedario();
?>

<h2>ejercicio 5</h2>
    <form action="src/xhtml.php" method="post">
        <label for="edad">Edad:</label>
        <input type="number" name="edad" id="edad" required><br><br>

        <label>Sexo:</label>
        <input type="radio" name="sexo" value="femenino" required> Femenino
        <input type="radio" name="sexo" value="masculino" required> Masculino <br><br>

        <input type="submit">
    </form>
    <br>

<h2>EJERCICIO 6</h2>
    <h2>Consultar Información de Autos</h2>
    <form method="post">
        <label for="matricula">Buscar auto por matrícula:</label>
        <input type="text" name="matricula" id="matricula">
        <button type="submit">Buscar</button>
        <br><br>
        <button type="submit" name="mostrar_todos">Todos los Autos</button>
    </form>

    <hr>

    <?php
    require_once 'src/funciones.php';

    $resultado = null;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['matricula']) && !empty($_POST['matricula'])) {
            $matricula = $_POST['matricula'];
            $resultado = buscarPorMatricula($matricula);
        } elseif (isset($_POST['mostrar_todos'])) {
            $resultado = obtenerTodosLosAutos();
            echo "<h3>Lista de Autos Registrados</h3>";
            echo "<pre>";
            print_r($resultado);
            echo "</pre>";
        }
    }

    if ($resultado && !isset($_POST['mostrar_todos'])) {
        echo "<h3>Información del Auto</h3>";
        echo "<pre>";
        print_r($resultado);
        echo "</pre>";
    } elseif (!$resultado && $_SERVER["REQUEST_METHOD"] == "POST") {
        echo "<p>No se encontraron resultados referentes a esa matricula.</p>";
    }
    ?>

</body>
</html>