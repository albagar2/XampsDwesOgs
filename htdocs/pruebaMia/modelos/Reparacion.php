<?php
class Reparacion {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function obtenerPorMecanico($dni) {
        $sql = "SELECT * FROM reparaciones WHERE dni_mecanico = :dni";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':dni' => $dni]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM reparaciones WHERE id_reparacion = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function sumarCoste($idReparacion, $importe) {
        // En un taller sumamos costes, no restamos saldo
        $sql = "UPDATE reparaciones SET coste_actual = coste_actual + :importe WHERE id_reparacion = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':importe' => $importe, ':id' => $idReparacion]);
    }
}
?>