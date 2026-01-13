<?php
class Alumno {
    protected $dni_a;
    protected $nombre;
    protected $apellidos;
    protected $id_curso;

    public function __construct($dni_a, $nombre, $apellidos, $id_curso) {
        $this->dni_a = $dni_a;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->id_curso = $id_curso;
    }

    public function __get($name) {
        return $this->$name;
    }
}
?>