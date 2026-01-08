<?php
class Usuario {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function obtenerPorDNI($dni) {
        $sql = "SELECT * FROM usuarios WHERE dni = :dni";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':dni' => $dni]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function restarIntento($dni) {
        $sql = "UPDATE usuarios SET intentos = intentos - 1 WHERE dni = :dni";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':dni' => $dni]);
        
        $u = $this->obtenerPorDNI($dni);
        if ($u && $u->intentos <= 0) {
            $this->bloquear($dni);
        }
    }

    public function resetearIntentos($dni) {
        $sql = "UPDATE usuarios SET intentos = 3 WHERE dni = :dni";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':dni' => $dni]);
    }

    private function bloquear($dni) {
        $sql = "UPDATE usuarios SET bloqueado = 1 WHERE dni = :dni";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':dni' => $dni]);
    }
}
?>