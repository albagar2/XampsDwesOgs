<?php  
    Class Conexion extends PDO{
        private $host = "localhost";
        private $usu= "dwes";
        private $pass = "abc123.";
        private $bd = "";
        private $options = array(
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_LOWER,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );
    public function __construct(string $bd) {
        $dsn = "mysql:host={$this->host};dbname={$bd};charset=utf8";
        parent::__construct($dsn, $this->usu, $this->pass, $this->options);
    }
    public function __get($name)
    {
        return $this->$name;
    }
    public function __set($name, $value)
    {
        $this->$name=$value;
    }
    }
?>