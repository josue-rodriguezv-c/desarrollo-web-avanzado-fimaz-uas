<?php
// Alumno: Josue Antonio Rodriguez Cebreros

class Futbolista
{
    private $id;
    private $nombre;
    private $posicion;
    private $numero;
    private $edad;
    private $equipo;

    public function __construct($id = null, $nombre = "", $posicion = "", $numero = 0, $edad = 0, $equipo = "")
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->posicion = $posicion;
        $this->numero = $numero;
        $this->edad = $edad;
        $this->equipo = $equipo;
    }

    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getPosicion() { return $this->posicion; }
    public function getNumero() { return $this->numero; }
    public function getEdad() { return $this->edad; }
    public function getEquipo() { return $this->equipo; }

    public function setId($id) { $this->id = $id; }
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setPosicion($posicion) { $this->posicion = $posicion; }
    public function setNumero($numero) { $this->numero = $numero; }
    public function setEdad($edad) { $this->edad = $edad; }
    public function setEquipo($equipo) { $this->equipo = $equipo; }
}
?>
