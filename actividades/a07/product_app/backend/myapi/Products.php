<?php
namespace TECWEB\MYAPI;
use TECWEB\MYAPI\DataBase as DataBase;
require_once __DIR__ . '/Database.php';

class Products extends DataBase{
    private $data=NULL;
    public function __construct($db, $user = 'root', $pass = '')
    {
        $this->data = array();
        parent::__construct($db, $user, $pass);
    }

public function list()
{
    $this->data = array();
    if($result = $this->conexion->query("SELECT * FROM products WHERE eliminado=0"))
    {
        $rows=$result->fetch_all(MYSQLI_ASSOC);
        if(!is_null($rows))
        {
            foreach ($rows as $num=>$row){
                foreach ($row as $key=>$value){
                    $this->data[$num][$key]=$value;
                }
            }
        }
        $result->free();
    }else{
        die('query Error:'.mysqli_error($this->conexion));
    }
    $this->conexion->close();
}
public function getData(){
    return json_encode($this->data, JSON_PRETTY_PRINT);
}


public function add($product) {
    
}

public function delete($id) {
    
}

public function edit($product) {
    
}

public function search($keyword) {
    
}

public function singleByName($name) {
    
}


}
?>