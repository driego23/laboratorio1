<?php


class Usuario {
    private $usuarios = array(
        'usuario1' => 'c    ontraseña1',
        'usuario2' => 'contraseña2'
    );

    
    public function validarCredenciales($usuario, $password) {
        if (array_key_exists($usuario, $this->usuarios)) {
            if ($this->usuarios[$usuario] === $password) {
                return true;
            }
        }
        return false;
    }
}

?>
