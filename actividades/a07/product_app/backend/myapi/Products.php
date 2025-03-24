<?php
namespace TECWEB\MYAPI;
use TECWEB\MYAPI\DataBase as DataBase;
require_once __DIR__ . '/Database.php';

class Products extends DataBase{
    private $data=NULL;
    public function __construct($user='root', $pass='gatin_123', $db)
    {
        $this->data = array();
        parent::__construct($user, $pass, $db);
    }
}
?>