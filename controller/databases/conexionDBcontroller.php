<?php
namespace App\controllers\databases;

use mysqli;

class ConexionDBController{
    private $host = 'localhost';
    private $user = 'root';
    private $pwd = '';
    private $dataBase = 'facturacion_tienda_db';
    private $conex;

    public function __construct(){
        $this->conex = new mysqli($this ->host, $this->user, $this->pwd, $this->dataBase);
    }

    public function execSql($sql){
        if ($this ->conex -> connect_error){
            die('Error en la conexión DB'. $this ->conex ->connect_error);
        }
        return $this->conex->query($sql);
    }
    
    public function close(){
        $this ->conex->close();
    }

}