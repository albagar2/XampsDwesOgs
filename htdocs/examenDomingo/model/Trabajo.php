<?php

/**
 * @property string $matricula
 * @property string $cod_mecanico
 * @property string $id_tarea
 * @property string $fecha
 * @property string $estado
 * @property string $horas
 */
class Trabajo
{
    protected $matricula;
    protected $cod_mecanico;
    protected $id_tarea;
    protected $fecha;
    protected $estado;
    protected $horas;
    public function __construct($matricula, $cod_mecanico, $id_tarea,$horas)
    {
        $this->matricula = $matricula;
        $this->cod_mecanico = $cod_mecanico;
        $this->id_tarea = $id_tarea;
        $this->estado = "Pendiente";
        $this->fecha = new DateTime("now");
        $this->horas = $horas;
    }
    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        } else {
            trigger_error("Trabajo '$name' no existe", E_USER_NOTICE);
            return null;
        }
    }
    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        } else {
            trigger_error("Trabajo '$name' no existe", E_USER_NOTICE);
            return null;
        }
    }
    public function __toString()
    {
        return $this->Nombre;
    }
    public function toArray(): array
    {
        $fechaFormateada = $this->fecha instanceof DateTime ? $this->fecha->format('Y-m-d H:i:s') : $this->fecha;
        return [
            'Matricula'       => $this->matricula,
            'Cod_mecanico'    => $this->cod_mecanico,
            'Id_tarea' => $this->id_tarea,
            'Fecha' => $fechaFormateada,
            'Estado' => $this->estado,
            'Horas' => $this->horas,
        ];
    }
}
