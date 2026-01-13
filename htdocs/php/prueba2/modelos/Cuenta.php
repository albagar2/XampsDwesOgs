<?php
class Cuenta {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function obtenerCuentasPorCliente($dni) {
        $sql = "SELECT * FROM cuentas WHERE dni_cuenta = :dni";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':dni' => $dni]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function obtenerCuentaPorIban($iban) {
        $sql = "SELECT * FROM cuentas WHERE iban = :iban";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':iban' => $iban]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function obtenerDestinatarios($miIban) {
        // Todos los clientes menos yo y la cuenta de comisiones
        // Según SQL comisiones es '12121212A' o podemos filtrar por IBAN si lo sabemos
        // Filtramos que no sea MI cuenta.
        $sql = "SELECT c.iban, u.Nombre FROM cuentas c 
                JOIN usuarios u ON c.dni_cuenta = u.DNI 
                WHERE c.iban != :miIban AND u.Nombre != 'Comisiones'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':miIban' => $miIban]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function actualizarSaldo($iban, $nuevoSaldo) {
        $sql = "UPDATE cuentas SET saldo = :saldo WHERE iban = :iban";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':saldo' => $nuevoSaldo, ':iban' => $iban]);
    }
}
?>