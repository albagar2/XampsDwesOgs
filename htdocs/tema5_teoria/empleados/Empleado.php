<?php
require_once 'Persona.php';
class Empleado extends Persona{
    private $salario;
    
    public function __construct($n = "Antonio", $a = "López", $e = 26,$sal=1500) {
        parent::__construct($n, $a, $e);
        $this->salario=$sal;
    }
    
    public function __get(string $name): mixed {
        return parent::__get($name);
    }

    public function __toString(): string {
        return parent::__toString()." y mi salario es: ".$this->salario;
    }
}