<?php
namespace TECWEB\MYAPI\Delete;
use TECWEB\MYAPI\DataBase\DataBase;


class Delete extends DataBase
{
    public function __construct($db, $user='root', $pass='gatin_123')
    {
        $this->data = array();
        parent::__construct($db, $user, $pass);
    }

public function delete($id) {
    // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    $this->data = array(
        'status'  => 'error',
        'message' => 'La consulta falló'
    );
    // SE VERIFICA HABER RECIBIDO EL ID
    if( isset($id) ) {
        // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
        $sql = "UPDATE productos SET eliminado=1 WHERE id = {$id}";
        if ( $this->conexion->query($sql) ) {
            $this->data['status'] =  "success";
            $this->data['message'] =  "Producto eliminado";
        } else {
            $this->data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this->conexion);
        }
        $this->conexion->close();
    }
}
}
?>