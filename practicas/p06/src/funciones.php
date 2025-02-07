
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
            echo "<H3>R= " . $total . " números obtenidos en " . $i . " iteraciones.\n</H3>";
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

function abecedario()
{
    $letras=[];
    for($i=97; $i<123; $i++)
    {
        $letras[$i] = chr($i);
    }
    $contador = 0;
    foreach ($letras as $key => $value) {
    echo '['.$key.'] => '.$value.'<br>';
    $contador++;
    if ($contador >25)
    break;
}
}

$vehiculos = [
    "UBN6338" => [
        "Auto" => ["marca" => "FIAT", "modelo" => 2020, "tipo" => "camioneta"],
        "Propietario" => ["nombre" => "Alfonzo Esparza", "ciudad" => "Puebla", "direccion" => "C.U., Jardines de San Manuel"]
    ],
    "ZPR5673" => [
        "Auto" => ["marca" => "TOYOTA", "modelo" => 2018, "tipo" => "sedan"],
        "Propietario" => ["nombre" => "Maria Lopez", "ciudad" => "Puebla", "direccion" => "Calle Rio Verde 2333"]
    ],
    "XKD1290" => [
        "Auto" => ["marca" => "FORD", "modelo" => 2019, "tipo" => "hatchback"],
        "Propietario" => ["nombre" => "Jose Martínez", "ciudad" => "Monterrey", "direccion" => "San Pedro 450"]
    ],
    "GHT4352" => [
        "Auto" => ["marca" => "FIAT", "modelo" => 2017, "tipo" => "camioneta"],
        "Propietario" => ["nombre" => "Juli Castellanos", "ciudad" => "México DF", "direccion" => "Insurgentes Sur 1890"]
    ],
    "GSR1234" => [
        "Auto" => ["marca" => "MAZDA", "modelo" => 2021, "tipo" => "sedan"],
        "Propietario" => ["nombre" => "Ricardo Díaz", "ciudad" => "Cancún", "direccion" => "Nader 12"]
    ],
    "TUV5432" => [
        "Auto" => ["marca" => "CHEVROLET", "modelo" => 2016, "tipo" => "hatchback"],
        "Propietario" => ["nombre" => "Carla Lopez", "ciudad" => "Tijuana", "direccion" => "Zona Rio"]
    ],
    "RTY5643" => [
        "Auto" => ["marca" => "FIAT", "modelo" => 2020, "tipo" => "sedan"],
        "Propietario" => ["nombre" => "Carlos Salas", "ciudad" => "Morelia", "direccion" => "Camelinas 980"]
    ],
    "FGH6789" => [
        "Auto" => ["marca" => "HYUNDAI", "modelo" => 2019, "tipo" => "camioneta"],
        "Propietario" => ["nombre" => "Sofia Ortiz", "ciudad" => "Guadalajara", "direccion" => "Revolución 456"]
    ],
    "CVB3456" => [
        "Auto" => ["marca" => "VOLKSWAGEN", "modelo" => 2018, "tipo" => "hatchback"],
        "Propietario" => ["nombre" => "Miguel Ángel Torres", "ciudad" => "Puebla", "direccion" => "14 Sur 1345"]
    ],
    "NMJ2345" => [
        "Auto" => ["marca" => "AUDI", "modelo" => 2021, "tipo" => "sedan"],
        "Propietario" => ["nombre" => "Ana María Sánchez", "ciudad" => "Querétaro", "direccion" => "Tecnológico 100"]
    ],
    "JKL4321" => [
        "Auto" => ["marca" => "BMW", "modelo" => 2022, "tipo" => "sedan"],
        "Propietario" => ["nombre" => "Roberto Navarro", "ciudad" => "San Luis Potosí", "direccion" => "Himalaya 234"]
    ],
    "OPQ8765" => [
        "Auto" => ["marca" => "MERCEDES", "modelo" => 2018, "tipo" => "sedan"],
        "Propietario" => ["nombre" => "Lucía Méndez", "ciudad" => "León", "direccion" => "Libertad 345"]
    ],
    "STU3456" => [
        "Auto" => ["marca" => "FIAT", "modelo" => 2015, "tipo" => "hatchback"],
        "Propietario" => ["nombre" => "Oscar Gutiérrez", "ciudad" => "Toluca", "direccion" => "Los Portales 12"]
    ],
    "IOP6789" => [
        "Auto" => ["marca" => "RENAULT", "modelo" => 2016, "tipo" => "sedan"],
        "Propietario" => ["nombre" => "Fernanda Ramírez", "ciudad" => "Cuernavaca", "direccion" => "Plan de Ayala 321"]
    ],
    "ZXV3214" => [
        "Auto" => ["marca" => "PEUGEOT", "modelo" => 2020, "tipo" => "hatchback"],
        "Propietario" => ["nombre" => "Julio César", "ciudad" => "Acapulco", "direccion" => "Costera 123"]
    ]
];

function buscarPorMatricula($matricula) {
    global $vehiculos;
    return $vehiculos[$matricula] ?? false;
}

function obtenerTodosLosAutos() {
    global $vehiculos;
    return $vehiculos;
}
?>
