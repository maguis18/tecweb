
<?php
function es_multiplo7y5($num)
{
    if ($num%5==0 && $num%7==0)
    {
        echo '<h3>R= El número '.$num.' SÍ es múltiplo de 5 y 7.</h3>';
    }
    else
    {
        echo '<h3>R= El número '.$num.' NO es múltiplo de 5 y 7.</h3>';
    }
}

function secuencia(){
    $secuencia = [];
    $i = 0;
    
    function esPar($numero) {
        return $numero % 2 == 0;
    }
    
    while (true) {
        $i++;
        $n1 = rand(1, 999); 
        $n2 = rand(1, 999);
        $n3 = rand(1, 999);
    
        if (!esPar($n1) && esPar($n2) && !esPar($n3)) {
            $total = $i * 3;
            echo "<H3>R= " . $total . " números obtenidos en " . $iteraciones . " iteraciones.\n</H3>";
            break; 
        } else {
            $secuencia[$i] = [$n1, $n2, $n3];
        }
    }
} 


function primer_numero($numero)
{
    while(true)
    {
        $n1 = rand(1, 999);
        if($n1 % $numero == 0)
        {
            echo '<h3>R= El primer número entero obtenido aleatoriamente que es múltiplo de '.$n1.' es: '.$numero.'</h3>';
            break;
        }
    }
}
function primer_numero_do_while($numero)
{
    do
    {
        $n1 = rand(1, 999);
        if($n1 % $numero == 0)
        {
            echo '<h3>R= El primer número entero obtenido aleatoriamente que es múltiplo de '.$numero.' es: '.$n1.'</h3>';
            break;
        }
    } while(true);
}


?>
