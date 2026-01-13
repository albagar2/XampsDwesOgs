<?php
class Estudiante {
    public $dni, $nombrecompleto, $direccion, $telf;
    public function __construct($d, $n, $dir, $t) {
        $this->dni = $d; $this->nombrecompleto = $n; $this->direccion = $dir; $this->telf = $t;
    }
}