<?php
class Persona{
    protected $nombre;
    protected $apellidos;
    protected $edad;
    protected static $numperson=0;


    public function __construct($n="Antonio",$a="López",$e=26) {
        $this->nombre=$n;
        $this->apellidos=$a;
        $this->edad=$e;
        self::$numperson++;
    }
    
    public function __destruct() {
        self::$numperson--;
    }

    public static function numPerson(){
        return self::$numperson;
    }
    
    public function __get(string $name): mixed {
        return $this->$name;
    }
    
    public function __set(string $name, mixed $value): void {
        $this->$name=$value;                
    }
    public function __toString(): string {
        return "<br>Mi nombre es ".$this->nombre." ".$this->apellidos." y tengo ".$this->edad." años.";
    }
    
    public function __clone(): void {
        $this->edad=0;
        self::$numperson++;
    }
    
    public function __call(string $name, array $arguments){
        if($name=="modificar"){
            if(count($arguments)==1){
                $this->nombre=$arguments[0];
            }
            if(count($arguments)==2){
                $this->nombre=$arguments[0];
                $this->apellidos=$arguments[1];
            }
            if(count($arguments)==3){
                $this->nombre=$arguments[0];
                $this->apellidos=$arguments[1];
                $this->edad=$arguments[2];                
            }            
        }
        if($name=="calcular"){
            
        }
    }
}
