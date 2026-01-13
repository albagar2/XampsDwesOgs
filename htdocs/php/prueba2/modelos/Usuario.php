<?php
class Usuario {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function obtenerPorDNI($dni) {
        $sql = "SELECT * FROM usuarios WHERE DNI = :dni";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':dni' => $dni]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function restarIntento($dni) {
        // Resta 1 a los intentos. Si llega a 0, bloquea.
        $sql = "UPDATE usuarios SET intentos = intentos - 1 WHERE DNI = :dni";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':dni' => $dni]);
        
        // Comprobamos si hay que bloquear tras restar
        $usuario = $this->obtenerPorDNI($dni);
        if ($usuario && $usuario->intentos <= 0) {
            $this->bloquearUsuario($dni);
        }
    }

    public function resetearIntentos($dni) {
        $sql = "UPDATE usuarios SET intentos = 3 WHERE DNI = :dni";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':dni' => $dni]);
    }

    private function bloquearUsuario($dni) {
        $sql = "UPDATE usuarios SET bloqueado = 1 WHERE DNI = :dni";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':dni' => $dni]);
    }
}
?>