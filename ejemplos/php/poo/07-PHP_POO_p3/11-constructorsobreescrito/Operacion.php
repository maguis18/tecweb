<?php
class Operacion {
    protected $valor1;
    protected $valor2;
    protected $resultado;

    public function __construct($val1, $val2) {
        $this->valor1 = $val1;
        $this->valor2 = $val2;
        $this->resultado = 0;
    }

    public function imprimirResultado() {
        echo $this->resultado.'<br>';
    }
}


  //se modifica el comportamiento del método constructor 
    // SE SOBREESCRIBE MÉTODO DE LA SUPERCLASE
    //La sobrescritura permite que una clase hija ofrezca una versión específica de un método que ya está implementado en su clase padre
class Suma extends Operacion {
    private $titulo;

    public function __construct($val1, $val2, $title) {
        $this->titulo = $title;
        // SE USA CONSTRUCTOR DE LA SUPERCLASE Operacion
        parent::__construct($val1, $val2);
        //se manda a llamar al constructor de la clase padre
        //asegura que valor1 y valor2 se inicialicen 
        //adecuadamente según la clase base.

        //evita la repeticion de 
        //$this->valor1 = $val1;
        //$this->valor2 = $val2;
    }

    public function operar() {
        // SE MUESTRA TITULO Y PARTE DEL MENSAJE DE RESULTADO
        echo '<h2>'.$this->titulo.'</h2>';
        echo 'El resultado de '.$this->valor1.'+'.$this->valor2.' es ';
        $this->resultado = $this->valor1 + $this->valor2;
    }
}

class Resta extends Operacion {
    private $titulo;

    public function __construct($val1, $val2, $title) {
        $this->titulo = $title;
        // SE USA CONSTRUCTOR DE LA SUPERCLASE Operacion
        parent::__construct($val1, $val2);
    }

    public function operar() {
        // SE MUESTRA TITULO Y PARTE DEL MENSAJE DE RESULTADO
        echo '<h2>'.$this->titulo.'</h2>';
        echo 'El resultado de '.$this->valor1.'-'.$this->valor2.' es ';
        $this->resultado = $this->valor1 - $this->valor2;
    }
}
?>