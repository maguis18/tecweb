<?php
class Persona{
    private $nombre;
    public function inicializar($name){
        //la palabra reservada this nos indica el valor que queremos modificar  
        $this->nombre = $name;
    }
    public function mostrar(){
        echo '<p>'.$this->nombre.'</p>';
    }
}
?>