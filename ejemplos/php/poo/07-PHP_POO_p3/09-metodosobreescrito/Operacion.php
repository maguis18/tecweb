<?php
class Operacion {
    protected $valor1;
    protected $valor2;
    protected $resultado;

    public function __construct() {
        $this->valor1 = 0;
        $this->valor2 = 0;
        $this->resultado = 0;
    }

    public function cargar1($val) {
        $this->valor1 = $val;
    }

    public function cargar2($val) {
        $this->valor2 = $val;
    }

    public function imprimirResultado() {
        echo $this->resultado.'<br>';
    }
}
//extends indica que Suma hereda todas las propiedades y 
// métodos de Operacion, pero puede añadir o modificar su funcionalidad
class Suma extends Operacion {
    public function operar() {
        $this->resultado = $this->valor1 + $this->valor2;
    }

    //se modifica el comportamiento del método imprimirResultado() 
    // para incluir una descripción del cálculo antes de llamar al
    //  método original de la clase padre usando parent::imprimirResultado()
    // SE SOBREESCRIBE MÉTODO DE LA SUPERCLASE
    //La sobrescritura permite que una clase hija ofrezca una versión específica de un método que ya está implementado en su clase padre
    public function imprimirResultado() {
        echo "El resultado de ".$this->valor1."+".$this->valor2." es ";
        // SE USA MÉTODO DE LA SUPERCLASE
        parent::imprimirResultado();
    }
}
//El método en la clase hija debe tener exactamente el mismo nombre, tipo de retorno, y parámetros que el método en la clase padre que está sobrescribiendo.

class Resta extends Operacion {
    public function operar() {
        $this->resultado = $this->valor1 - $this->valor2;
    }
    
    // SE SOBREESCRIBE MÉTODO DE LA SUPERCLASE
    public function imprimirResultado() {
        echo "El resultado de ".$this->valor1."-".$this->valor2." es ";
        // SE USA MÉTODO DE LA SUPERCLASE
        parent::imprimirResultado();
    }
}
?>