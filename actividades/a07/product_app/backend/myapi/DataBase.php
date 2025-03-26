<?php
namespace TECWEB\MYAPI;

abstract class DataBase{
    protected $conexion;

    public function __construct($db, $user, $pass){
        $this->conexion = new \mysqli('localhost', $user, $pass, $db);

        // Verificar si la conexión fue exitosa
        if ($this->conexion->connect_error) {
            die('Conexión fallida: ' . $this->conexion->connect_error);
        }
    }

}

?>