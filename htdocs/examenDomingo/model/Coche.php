<?php

/**
 * @property string $matricula
 * @property string $marca
 * @property string $modelo
 * @property string $km
 * @property string $foto
 * @property string $dni_cliente
 */
class Coche
{
    protected $matricula;
    protected $marca;
    protected $modelo;
    protected $km;
    protected $foto;
    protected $dni_cliente;
    public function __construct($matricula, $marca, $modelo, $km, $foto, $dni_cliente)
    {
        $this->matricula = $matricula;
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->km = $km;
        $this->foto = $foto;
        $this->dni_cliente = $dni_cliente;
    }
    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        } else {
            trigger_error("Coche '$name' no existe", E_USER_NOTICE);
            return null;
        }
    }
    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        } else {
            trigger_error("COche '$name' no existe", E_USER_NOTICE);
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
            'Matricula'       => $this->matricula,
            'Marca'    => $this->marca,
            'Modelo' => $this->modelo,
            'Km' => $this->km,
            'Foto' => $this->foto,
            'Dni_cliente'     => $this->dni_cliente,
        ];
    }
}
