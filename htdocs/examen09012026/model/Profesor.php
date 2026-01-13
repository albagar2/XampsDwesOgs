<?php
class Profesor {
    protected $dni_p;
    protected $nombre;
    protected $apellidos;
    protected $intentos;

    public function __construct($dni_p, $nombre, $apellidos, $intentos) {
        $this->dni_p = $dni_p;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->intentos = $intentos;
    }

    public function __get($name) { return $this->$name; }
    public function __set($name, $value) { $this->$name = $value; }
}
?>