<?php 
require_once '../controller/conexion.php';
    class Producto{
        private $codigo;
        private $nombre;
        private $precio;

        public function __construct($cod = 0, $nombre="", $precio = 0){
            $this->codigo = $cod;
            $this->nombre = $nombre;
            $this->precio = $precio;
        }


        public function nuevoProducto($cod,$nom,$pre) {
            $this->codigo = $cod;
            $this->nombre = $nom;
            $this->precio = $pre;
        }


        public function __toString(): string {
        return "<br>Producto[codigo=" . $this->codigo
                . ", nombre=" . $this->nombre
                . ", precio=" . $this->precio
                . "]<br>";
        }

        public function __get(string $name): mixed {
        return $this->$name;
        }

    }    

?>