<?php
class Cadena {
    public static function largo($cad) {
        return strlen($cad);
    }

    public static function mayusculas($cad) {
        return strtoupper($cad);
    }

    public static function minusculas($cad) {
        return strtolower($cad);
    }

    //Estos métodos son static, lo que significa que pertenecen
    //a la clase en lugar de a cualquier objeto específico de 
    //la clase. Pueden ser llamados directamente sobre la clase 
    //sin necesidad de crear una instancia de la misma
}
?>