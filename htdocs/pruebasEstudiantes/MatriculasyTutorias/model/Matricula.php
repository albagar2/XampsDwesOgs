<?php
class Matricula {
    protected $dni_e;
    protected $cod_p;
    protected $id_a;
    protected $fecha;
    protected $estado;
    protected $horas;

    public function __construct($dni, $prof, $asig) {
        $this->dni_e = $dni; $this->cod_p = $prof; $this->id_a = $asig;
        $this->fecha = date("Y-m-d");
        $this->estado = "Solicitada";
        $this->horas = 0;
    }
    public function toArray() {
        return [$this->dni_e, $this->cod_p, $this->id_a, $this->fecha, $this->estado, $this->horas];
    }
}