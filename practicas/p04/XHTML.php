<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Práctica 4</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Determina cuál de las siguientes variables son válidas y explica por qué:</p>
    <p>$_myvar,  $_7var,  myvar,  $myvar,  $var7,  $_element1, $house*5</p>
    <?php
        //AQUI VA MI CÓDIGO PHP
        $_myvar;
        $_7var;
        //myvar;       // Inválida
        $myvar;
        $var7;
        $_element1;
        //$house*5;     // Invalida
        
        echo '<h4>Respuesta:</h4>';   
    
        echo '<ul>';
        echo '<li>$_myvar es válida porque inicia con guión bajo.</li>';
        echo '<li>$_7var es válida porque inicia con guión bajo.</li>';
        echo '<li>myvar es inválida porque no tiene el signo de dolar ($).</li>';
        echo '<li>$myvar es válida porque inicia con una letra.</li>';
        echo '<li>$var7 es válida porque inicia con una letra.</li>';
        echo '<li>$_element1 es válida porque inicia con guión bajo.</li>';
        echo '<li>$house*5 es inválida porque el símbolo * no está permitido.</li>';
        echo '</ul>';

        unset($_myvar);
        unset($_7var);
        unset($myvar);
        unset($var7);
        unset($_element1);
?>

<h2>Ejercicio 2</h2>
    <p>Proporcionar los valores de $a, $b, $c como sigue:</p>
    <ul>
    
    <li>$a = "ManejadorSQL";</li>
    <li>$b = 'MySQL';</li>
    <li>$c = &$a;</li>
    </ul>
    <?php
        $a = "ManejadorSQL";
        $b = 'MySQL';
        $c = &$a;

        echo '<h4>Respuesta:</h4>'; 
        echo '<ul>';
        echo '<li>$a = ' . $a . '</li>';
        echo '<li>$b = ' . $b . '</li>';
        echo '<li>$c = ' . $c . '</li>';
        echo '</ul>';
        $a = "PHP server";
        $b = &$a;

        echo '<h4>Paso 2:</h4>
        <ul><li> a. Ahora muestra el contenido de cada variable </li>
        <li>b. Agrega al código actual las siguientes asignaciones:</li>
        <li>c. Vuelve a mostrar el contenido de cada uno</li>
        </ul>';
        echo '<h4>Respuesta:</h4>'; 
        echo '<ul>';
        echo '<li>$a = ' . $a . '</li>';
        echo '<li>$b = ' . $b . '</li>';
        echo '<li>$c = ' . $c . '</li>';
        echo '</ul>';

        unset($a);
        unset($b);
        unset($c);
    ?>
        <h4>¿Qué ocurrio en el segundo bloque de asignaciones?</h4>
        <p>
        Se imprimieron en las variables a, b y c lo mismo , el texto "PHP server" ya que se le asigno a la variable $a el texto de "PHP server" , despues a la variable b se le asigno una referencia a lo que contiene a , y desde un inicio la variable c tenia como valor la referencia a la variable a, por lo que al no reasignarle ningun valor, sigue imprimiendo la referencia al valor de a, que en este punto era el texto "PHP server"</p>   

        <h2>Ejercicio 3</h2>
    <p>Muestra el contenido de cada variable inmediatamente después de cada asignación,
    verificar la evolución del tipo de estas variables (imprime todos los componentes de los
    arreglo):</p>
    <ul>
    <li>$a = "PHP5";</li>
    <li>$z[] = &$a;</li>
    <li>$b = "5a version de PHP";</li>
    <li>$c = $b*10;</li>
    <li>$a .= $b;</li>
    <li>$b *= $c;</li>
    <li>$z[0] = “MySQL”;</li>
    </ul>
    <?php
    echo '<h4>Respuesta:</h4>'; 
        $a = "PHP5";
        echo "a = $a<br>";
        $z[] = &$a;
        echo"z = ";
        var_dump($z);
        echo "<br>";
        $b = "5a version de PHP";
        echo "b = $b<br>";
        @$c = $b*10;
        echo "c = $c<br>";
        $a .= $b;
        echo "a = $a<br>";
        @$b *= $c;
        echo "b = $b<br>";
        echo"z = ";
        $z[0] = "MySQL";
        var_dump($z);
        unset($a);
        unset($b);
        unset($c);
        unset($z);
    ?>

<h2>Ejercicio 4</h2>
    <p>Lee y muestra los valores de las variables del ejercicio anterior, pero ahora con la ayuda de la matriz $GLOBALS o del modificador global de PHP.</p>
    <?php
    $a = "PHP5";
    $z[] = &$a;
    $b = "5a version de PHP";
    @$c = $b*10;
    $a .= $b;
    @$b *= $c;
    $z[0] = "MySQL";
    echo '<h4>Respuesta:</h4>'; 
    echo "a = " . $GLOBALS['a'] . "<br>";
    echo "b = " . $GLOBALS['b'] . "<br>";
    echo "c = " . $GLOBALS['c'] . "<br>";
    echo"z = ";
    var_dump($GLOBALS['z']);
    unset($a);
    unset($b);
    unset($c);
    unset($z);
    ?>

<h2>Ejercicio 5</h2>
    <p>Dar el valor de las variables $a, $b, $c al final del siguiente script:</p>
    <ul>
    <li>$a = “7 personas”;</li>
    <li>$b = (integer) $a;</li>
    <li>$a = “9E3”;</li>
    <li>$c = (double) $a;</li>
    </ul>
    <?php
    $a = "7 personas";
    $b = (integer) $a;
    $a = "9E3";
    $c = (double) $a;
    echo '<h4>Respuesta:</h4>'; 
    echo '<ul>';
    echo '<li>$a = ' . $a . '</li>';
    echo '<li>$b = ' . $b . '</li>';
    echo '<li>$c = ' . $c . '</li>';
    echo '</ul>';
    unset($a);
    unset($b);
    unset($c);
    ?>

<h2>Ejercicio 6</h2>
    <p>Dar y comprobar el valor booleano de las variables $a, $b, $c, $d, $e y $f y muéstralas
    usando la función var_dump(<datos>).</p>
    <p>Después investiga una función de PHP que permita transformar el valor booleano de $c y $e en uno que se pueda mostrar con un echo:
    <ul>
    <li>$a = “0”;</li>
    <li>$b = “TRUE”;</li>
    <li>$c = FALSE;</li>
    <li>$d = ($a OR $b);</li>
    <li>$e = ($a AND $c);</li>
    <li>$f = ($a XOR $b);</li>
    </ul>
    <?php
        $a = "0";
        $b = "TRUE";
        $c = FALSE;
        $d = ($a OR $b);
        $e = ($a AND $c);
        $f = ($a XOR $b);
        echo '<h4>Respuesta:</h4>'; 
        echo '<ul>';
        echo '<li>a = '; var_dump($a); echo '</li>';
        echo '<li>b = '; var_dump($b); echo '</li>';
        echo '<li>c = '; var_dump($c); echo '</li>';
        echo '<li>d = '; var_dump($d); echo '</li>';
        echo '<li>e = '; var_dump($e); echo '</li>';
        echo '<li>f = '; var_dump($f); echo '</li>';
        echo '</ul>';

        echo '<h4>Transformar el valor booleano de $c y $e en uno que se pueda mostrar con un echo:</h4>';
        echo "c: " . var_export($c, true) . "<br>";
        echo "e: " . var_export($e, true) . "<br>";

        unset($a);
        unset($b);
        unset($c);
        unset($d);
        unset($e);
        unset($f);
        ?>
<h2>Ejercicio 7</h2>
    <p>Usando la variable predefinida $_SERVER, determina lo siguiente:</p>
    <ul>
    <li>La versión de Apache y PHP,</li>
    <li>El nombre del sistema operativo (servidor),</li>
    <li>El idioma del navegador (cliente).</li>
    </ul>
    <?php
    echo '<h4>Respuesta:</h4>'; 
    echo '<ul>';
    echo '<li>La versión de Apache es: ' . $_SERVER['SERVER_SOFTWARE'] . '</li>';
    echo '<li>La versión de PHP es: ' . phpversion() . '</li>'; 
    echo '<li>El nombre del servidor es: ' . $_SERVER['SERVER_NAME'] . '</li>'; 
    echo '<li>El idioma del navegador es: ' . $_SERVER['HTTP_ACCEPT_LANGUAGE'] . '</li>';
    echo '</ul>';
    ?>

</body>
</html>