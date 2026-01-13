<?php
class Conexion extends PDO {
    private $host = "localhost";
    private $usu = "root"; // Ajustar según examen
    private $pass = "";     // Ajustar según examen
    private $bd = "gestion_academia";
    private $options = array(
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_LOWER,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );

    public function __construct() {
        $dsn = "mysql:host={$this->host};dbname={$this->bd};charset=utf8";
        parent::__construct($dsn, $this->usu, $this->pass, $this->options);
    }
}