<?php
class Recambio {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function obtenerTodos() {
        $sql = "SELECT * FROM recambios";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM recambios WHERE id_recambio = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function registrarLinea($idRep, $idRec, $cant, $fecha, $coste) {
        $sql = "INSERT INTO lineas_reparacion (id_reparacion, id_recambio, cantidad, fecha, coste_total_linea) 
                VALUES (:rep, :rec, :cant, :fecha, :coste)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':rep' => $idRep,
            ':rec' => $idRec,
            ':cant' => $cant,
            ':fecha' => $fecha,
            ':coste' => $coste
        ]);
    }

    public function obtenerHistorial($idReparacion) {
        // Join para sacar el nombre de la pieza
        $sql = "SELECT l.*, r.nombre as nombre_pieza 
                FROM lineas_reparacion l
                JOIN recambios r ON l.id_recambio = r.id_recambio
                WHERE l.id_reparacion = :id
                ORDER BY l.fecha DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idReparacion]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
?>