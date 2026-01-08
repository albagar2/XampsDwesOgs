<?php
class Conexion {
    private $host = 'localhost';
    private $db = 'banco_bloqueo';
    private $user = 'root';
    private $pass = '';
    private $dsn;

    public function __construct() {
        $this->dsn = "mysql:host={$this->host};dbname={$this->db};charset=utf8mb4";
    }

    public function conectar() {
        try {
            $pdo = new PDO($this->dsn, $this->user, $this->pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
?>