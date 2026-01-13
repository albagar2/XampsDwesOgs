<?php
class Estudiante {
    protected $dni;
    protected $nombre_completo;
    protected $direccion;
    protected $telefono;

    public function __construct($dni, $nombre, $dir, $tel) {
        $this->dni = $dni; $this->nombre_completo = $nombre;
        $this->direccion = $dir; $this->telefono = $tel;
    }
    public function __get($name) { return $this->$name; }
    public function toArray() {
        return [$this->dni, $this->nombre_completo, $this->direccion, $this->telefono];
    }
}