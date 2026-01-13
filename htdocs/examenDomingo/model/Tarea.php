<?php

/**
 * @property string $id
 * @property string $descripcion
 * @property string $precio
 * @property string $tipo
 */
class Tarea
{
    protected $id;
    protected $descripcion;
    protected $precio;
    protected $tipo;
    public function __construct($id, $descripcion, $precio, $tipo)
    {
        $this->id = $id;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->tipo = $tipo;
    }
    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        } else {
            trigger_error("Tarea '$name' no existe", E_USER_NOTICE);
            return null;
        }
    }
    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        } else {
            trigger_error("Tarea '$name' no existe", E_USER_NOTICE);
            return null;
        }
    }
    public function __toString()
    {
        return $this->Nombre;
    }
    public function toArray(): array
    {
        return [
            'Id'       => $this->id,
            'Descripcion'    => $this->descripcion,
            'Precio' => $this->precio,
            'Tipo' => $this->tipo,
        ];
    }
}
