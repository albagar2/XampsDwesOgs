<?php
class Transferencia {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function registrar($origen, $destino, $cantidad, $fechaUnix) {
        $sql = "INSERT INTO transferencias (iban_origen, iban_destino, fecha, cantidad) 
                VALUES (:origen, :destino, :fecha, :cantidad)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':origen' => $origen,
            ':destino' => $destino,
            ':fecha' => $fechaUnix,
            ':cantidad' => $cantidad
        ]);
    }

    public function obtenerHistorial($iban) {
        $sql = "SELECT * FROM transferencias WHERE iban_origen = :iban OR iban_destino = :iban ORDER BY fecha DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':iban' => $iban]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
?>