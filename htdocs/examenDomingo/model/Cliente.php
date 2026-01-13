<?php

/**
 * @property string $dni
 * @property string $nombrecompleto
 * @property string $direccion
 * @property string $telf
 */
class Cliente
{
    protected $dni;
    protected $nombrecompleto;
    protected $direccion;
    protected $telf;
    public function __construct($dni, $nombrecompleto, $direccion, $telf)
    {
        $this->dni = $dni;
        $this->nombrecompleto = $nombrecompleto;
        $this->direccion = $direccion;
        $this->telf = $telf;
    }
    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        } else {
            trigger_error("Cliente '$name' no existe", E_USER_NOTICE);
            return null;
        }
    }
    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        } else {
            trigger_error("Cliente '$name' no existe", E_USER_NOTICE);
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
            'dni'       => $this->dni,
            'nombrecompleto'    => $this->nombrecompleto,
            'direccion' => $this->direccion,
            'telf' => $this->telf,
        ];
    }
}
