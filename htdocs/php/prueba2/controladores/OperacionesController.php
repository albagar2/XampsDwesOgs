<?php
require_once 'clases/Conexion.php';
require_once 'modelos/Cuenta.php';
require_once 'modelos/Transferencia.php';
require_once 'modelos/Usuario.php';

class OperacionesController {
    private $db;

    public function __construct() {
        // Iniciamos conexión para todos los métodos
        $con = new Conexion();
        $this->db = $con->conectar();
        session_start();
        if (!isset($_SESSION['dni'])) {
            header("Location: index.php");
            exit;
        }
    }

    public function inicio() {
        $cuentaModel = new Cuenta($this->db);
        $misCuentas = $cuentaModel->obtenerCuentasPorCliente($_SESSION['dni']);
        require 'vistas/inicio_cliente.php';
    }

    public function historial() {
        // Recogemos IBAN por GET sin alias cortos innecesarios
        if (isset($_GET['iban'])) {
            $transModel = new Transferencia($this->db);
            $historial = $transModel->obtenerHistorial($_GET['iban']);
            require 'vistas/historial.php';
        }
    }

    public function formTransferencia() {
        if (isset($_GET['iban'])) {
            $cuentaModel = new Cuenta($this->db);
            $cuentaOrigen = $cuentaModel->obtenerCuentaPorIban($_GET['iban']);
            // Obtener destinos posibles
            $destinos = $cuentaModel->obtenerDestinatarios($_GET['iban']);
            require 'vistas/transferencias.php';
        }
    }

    public function validarTransferencia() {
        // Recibimos datos del formulario anterior
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $origenIban = $_POST['origen'];
            $destinoIban = $_POST['destino'];
            $cantidad = (float) $_POST['cantidad'];
            
            $cuentaModel = new Cuenta($this->db);
            $cuentaOrigen = $cuentaModel->obtenerCuentaPorIban($origenIban);
            
            // Cálculos
            $comision = $cantidad * 0.01; // 1%
            $totalRestar = $cantidad + $comision;
            $saldoAnterior = $cuentaOrigen->saldo;
            $saldoPosterior = $saldoAnterior - $totalRestar;
            
            // Validaciones visuales para la vista
            $saldoRojo = ($saldoPosterior < 0); 
            
            require 'vistas/validar_transferencia.php';
        }
    }

    public function ejecutarTransferencia() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recogemos datos confirmados (idealmente vendrían en hidden inputs o re-calculados)
            $origen = $_POST['origen'];
            $destino = $_POST['destino'];
            $cantidad = (float) $_POST['cantidad'];
            $comision = (float) $_POST['comision'];
            
            // INICIO TRANSACCIÓN (Seguridad vital en bancos)
            try {
                $this->db->beginTransaction();
                
                $cuentaModel = new Cuenta($this->db);
                $transModel = new Transferencia($this->db);
                
                // 1. Restar a Origen
                $datosOrigen = $cuentaModel->obtenerCuentaPorIban($origen);
                $nuevoSaldoOrigen = $datosOrigen->saldo - ($cantidad + $comision);
                
                // Doble check de seguridad de saldo (por si manipulan HTML)
                if ($nuevoSaldoOrigen < 0) {
                    throw new Exception("Saldo insuficiente manipulado");
                }
                $cuentaModel->actualizarSaldo($origen, $nuevoSaldoOrigen);
                
                // 2. Sumar a Destino
                $datosDestino = $cuentaModel->obtenerCuentaPorIban($destino);
                $cuentaModel->actualizarSaldo($destino, $datosDestino->saldo + $cantidad);
                
                // 3. Sumar Comisión a cuenta Banco (DNI 12121212A -> IBAN ES2099...)
                // Hardcodeamos el IBAN de comisiones según SQL o lo buscamos
                $ibanComisiones = 'ES2099999999999999999999'; 
                $datosComis = $cuentaModel->obtenerCuentaPorIban($ibanComisiones);
                $cuentaModel->actualizarSaldo($ibanComisiones, $datosComis->saldo + $comision);
                
                // 4. Registrar Transferencia
                $fechaUnix = time();
                $transModel->registrar($origen, $destino, $cantidad, $fechaUnix);
                
                $this->db->commit();
                
                // Redirigir a inicio
                header("Location: index.php?accion=inicio");
                
            } catch (Exception $e) {
                $this->db->rollBack();
                die("Error en la transferencia: " . $e->getMessage());
            }
        }
    }
}
?>