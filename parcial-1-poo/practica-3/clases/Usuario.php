<?php

class Usuario
{
    private $nombre;
    private $correo;

    public function __construct($nombre, $correo)
    {
        $this->nombre = $nombre;
        $this->setCorreo($correo);
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setCorreo($correo)
    {
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("El correo '$correo' no tiene un formato válido.");
        }

        $this->correo = $correo;
    }
}

?>
