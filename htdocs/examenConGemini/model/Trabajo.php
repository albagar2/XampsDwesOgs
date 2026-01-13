<?php
class Trabajo {
    protected $matricula;
    protected $cod_mecanico;
    protected $id_tarea;
    protected $fecha;
    protected $estado;
    protected $horas;

    public function __construct($matricula, $cod_mecanico, $id_tarea, $horas) {
        $this->matricula = $matricula;
        $this->cod_mecanico = $cod_mecanico;
        $this->id_tarea = $id_tarea;
        $this->estado = "Pendiente";
        $this->fecha = date("Y-m-d");
        $this->horas = $horas;
    }

    public function __get($name) {
        return $this->$name;
    }

    public function toArray(): array {
        return [
            'matricula' => $this->matricula,
            'cod_mecanico' => $this->cod_mecanico,
            'id_tarea' => $this->id_tarea,
            'fecha' => $this->fecha,
            'estado' => $this->estado,
            'horas' => $this->horas,
        ];
    }
}