<?php


class Usuario {
    // Array simulando usuarios y contraseñas
    private $usuarios = array(
        'usuario1' => 'c    ontraseña1',
        'usuario2' => 'contraseña2'
    );

    // Método para validar las credenciales del usuario
    public function validarCredenciales($usuario, $password) {
        // Verificar si el usuario existe en el array de usuarios
        if (array_key_exists($usuario, $this->usuarios)) {
            // Verificar si la contraseña coincide
            if ($this->usuarios[$usuario] === $password) {
                // Credenciales válidas
                return true;
            }
        }
        
        // Credenciales inválidas
        return false;
    }
}

?>
