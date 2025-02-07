<?php
header("Content-Type: application/xhtml+xml; charset=UTF-8");
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
echo '<html xmlns="http://www.w3.org/1999/xhtml" lang="es">';
echo '<head><title>Resultado de Validación</title></head>';
echo '<body>';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $edad = $_POST["edad"];
    $sexo = $_POST["sexo"];

    if ($sexo === "femenino" && $edad >= 18 && $edad <= 35) {
        echo "<p>Bienvenida, usted cumple con los requisitos.</p>";
    } else {
        echo "<p>Lo sentimos, pero no cumple con los requisitos necesarios.</p>";
    }
}

echo '</body></html>';
?>