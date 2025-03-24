<?php
class Tabla {
    private $matriz = array();
    private $numFilas;
    private $numColumnas;
    private $estilo;

    public function __construct($rows, $cols, $style) {
        $this->numFilas = $rows;
        $this->numColumnas = $cols;
        $this->estilo = $style;
    }

    public function cargar($row, $col, $val) {
        $this->matriz[$row][$col] = $val;
    }

    private function inicio_tabla() {
        echo '<table style="'.$this->estilo.'">';
    }//se crea la seccion para la tabla 

    private function inicio_fila() {
        echo '<tr>';
    }//table row 

    private function mostrar_dato($row, $col) {
        echo '<td style="'.$this->estilo.'">'.$this->matriz[$row][$col].'</td>';
    }//td datble data 

    private function fin_fila() {
        echo '</tr>';
    }

    private function fin_tabla() {
        echo '</table>';
    }

    public function graficar() {
        $this->inicio_tabla();
        for($i=0; $i<$this->numFilas; $i++) {//si i es menor al numero de filas, continuamos 
            //es decir, si aun no se alcanza el numero de filas, continuamos
            $this->inicio_fila();//incializamos una fila
            for($j=0; $j<$this->numColumnas; $j++) {//si j es menor al numero de columnas
                //es decir, si aun no se alcanza el numero de columnas, continuamos
                $this->mostrar_dato($i, $j);
            }
            $this->fin_fila();
        }
        $this->fin_tabla();
    }
}
?>