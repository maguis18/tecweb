<?php
namespace EJEMPLOS\POO;
class Cabecera {
    private $titulo;
    private $ubicacion;
    //el constructor en php es especial
    //en este cas tiene una palabra reservada
    public function __construct($title,$location)
    {
        $this->titulo=$title;
        $this->ubicacion=$location;
    }
    public function graficar()
    {
        $estilo='font-size:40px;text-align:'.$this->ubicacion;
        echo '<div style="'.$estilo.'">';
        echo '<h4>'.$this->titulo.'</h4>';
        echo '</div>';
    }
}
//no se peude dos clases con el mismo nombre en el miso acrchivo el mismo namespace
class Cabecera2 {
    private $titulo;
    private $ubicacion;
    private $enlace;
    //el constructor en php es especial
    //en este cas tiene una palabra reservada
    public function __construct($title,$location,$link)
    {
        $this->titulo=$title;
        $this->ubicacion=$location;
        $this->enlace=$link;
    }
    public function graficar()
    {
        $estilo='font-size:40px;text-align:'.$this->ubicacion;
        echo '<div style="'.$estilo.'">';
        echo '<h4>';
        echo '<a href="'.$this->enlace.'">'.this->titulo.'</a>';
        echo '</h4>';
        echo '</div>';
    }
}
?>