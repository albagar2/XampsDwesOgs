<?php 
require_once 'Conexion.php';
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


        public function __tostring(){
            return "<br>Producto[codigo=" . $this->codigo
                . ", nombre=" . $this->nombre
                . ", precio=" . $this->precio
                . "]<br>";
        }


       public function __get(string $name): mixed {
        return $this->$name;
        }
    
    
        public function insertar(){
            try{
                $conex=new Conexion();
                $conex->query("INSERT INTO producto VALUES ($this->codigo, '$this->nombre, '
                $this->precio");
                $filas=$conex->affected_rows;
                $conex->close();
                return $filas;
            }catch(Exception $e){
                echo "<a href=index.php>Ir a inicio</a>";
                die("ERROR CON LA BD: ".$e->getMessage());
            }
        }


        public static function buscar($cod){
            try{
                $conex=new Conexion();
                $result=$conex->query("SELECT * FROM producto WHERE codigo=$cod");
                if($result->num_rows){
                    $reg=$result->fetch_object();
                    $p= new Producto($reg->codigo,$reg->nombre, $reg->precio);
                }else{
                    $p=false;
                }$conex->close();
                return $p;

            }catch(Exception $e){
                echo "<a hreff=index.php>Ir a inicio</a>";
                die("ERROR CON LA BD: ".$e->getMessage());
            }
        }


        public static function mostrar(){
              try{
                $conex=new Conexion();
                $result=$conex->query("SELECT * FROM producto");
                if($result->num_rows){
                    while ($fila= $result->fetch_object()){
                        //objeto de si mismo con el self ya que estamos en la clasee producto
                        $p=new self($fila->codigo, $fila->nombre, $fila->precio);
                        $producto[]=$p;
                    }
                }else{
                    $producto=false;
                }
                $conex->close();
                return $producto;
            }catch(Exception $e){
                echo "<a hreff=index.php>Ir a inicio</a>";
                die("ERROR CON LA BD: ".$e->getMessage());
            }

        }
    }
    

?>