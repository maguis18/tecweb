<?php
namespace TECWEB\MYAPI;

abstract class DataBase{
    protected $conexion;

    public function __construct($user, $pass,$db){
        $this->conexion = @mysqli_connect('localhost', $user, $pass, $db);

        // Verificar si la conexión fue exitosa
        if (!$this->conexion) {
            die('Conexión fallida:');
        }
    }

}

?>