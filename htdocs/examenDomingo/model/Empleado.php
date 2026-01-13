<?php

/**
 * @property string $codigo
 * @property string $clave
 * @property string $nombrecompleto
 * @property string $tlf
 * @property string $rol
 */
class Empleado
{
    protected $codigo;
    protected $clave;
    protected $nombrecompleto;
    protected $telf;
    protected $rol;
    public function __construct($codigo, $clave, $nombrecompleto, $tlf, $rol)
    {
        $this->codigo = $codigo;
        $this->clave = $clave;
        $this->nombrecompleto = $nombrecompleto;
        $this->tlf = $tlf;
        $this->rol = $rol;
    }
    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        } else {
            trigger_error("Empleado '$name' no existe", E_USER_NOTICE);
            return null;
        }
    }
    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        } else {
            trigger_error("Empleado '$name' no existe", E_USER_NOTICE);
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
            'Codigo'       => $this->codigo,
            'Clave'    => $this->clave,
            'Nombre_completo' => $this->nombrecompleto,
            'Tlf' => $this->tlf,
            'Rol' => $this->rol,
        ];
    }
}
