<?php
namespace App\controllers\databases;

use mysqli;

class ConexionDBController{
    protected $host = 'localhost';
    protected $user = 'root';
    protected $pwd = '';
    protected $dataBase = 'facturacion_tienda_db';
    protected $conex;

    public function __construct(){
        $this->conex = new mysqli($this->host, $this->user, $this->pwd, $this->dataBase);
    }

    public function getConexion(){
        return $this->conex;
    }

    public function execSql($sql){
        if ($this->conex->connect_error){
            die('Error en la conexión DB'. $this->conex->connect_error);
        }
        return $this->conex->query($sql);
    }
    
    public function close(){
        $this->conex->close();
    }
}

