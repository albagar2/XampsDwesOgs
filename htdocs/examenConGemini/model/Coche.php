<?php
class Coche {
    protected $matricula;
    protected $marca;
    protected $modelo;
    protected $km;
    protected $foto;
    protected $dni_cliente;

    public function __construct($mat, $mar, $mod, $km, $fot, $dni) {
        $this->matricula = $mat; $this->marca = $mar; $this->modelo = $mod;
        $this->km = $km; $this->foto = $fot; $this->dni_cliente = $dni;
    }

    public function __get($name) { return $this->$name; }

    public function toArray(): array {
        return [$this->matricula, $this->marca, $this->modelo, $this->km, $this->foto, $this->dni_cliente];
    }
}