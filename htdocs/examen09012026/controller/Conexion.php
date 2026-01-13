<?php  
    class Conexion extends mysqli {
        private $host = "localhost";
        private $usu = "dwes";
        private $pass = "abc123.";
        private $bd = "partes";

        public function __construct() {
            parent::__construct($this->host, $this->usu, $this->pass, $this->bd);
            if ($this->connect_error) {
                die("Error de conexión: ".$this->connect_error);
            }
        }
    }
?>