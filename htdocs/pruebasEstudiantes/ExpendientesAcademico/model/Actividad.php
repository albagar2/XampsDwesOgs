<?php
class Actividad {
    protected $id, $descripcion, $peso, $tipo;
    public function __construct($id, $desc, $peso, $tipo) {
        $this->id = $id; $this->descripcion = $desc; $this->peso = $peso; $this->tipo = $tipo;
    }
    public function __get($name) { return $this->$name; }
}
?>