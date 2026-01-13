<?php
require_once 'clases/Conexion.php';
require_once 'modelos/Reparacion.php';
require_once 'modelos/Recambio.php';

class TallerController {
    private $db;

    public function __construct() {
        $con = new Conexion();
        $this->db = $con->conectar();
        session_start();
        if (!isset($_SESSION['dni'])) {
            header("Location: index.php");
            exit;
        }
    }

    public function inicio() {
        $repModel = new Reparacion($this->db);
        // Filtramos reparaciones por el mecánico logueado
        $misReparaciones = $repModel->obtenerPorMecanico($_SESSION['dni']);
        require 'vistas/inicio_mecanico.php';
    }

    public function historial() {
        if (isset($_GET['id'])) {
            $recModel = new Recambio($this->db);
            $repModel = new Reparacion($this->db);
            
            $reparacion = $repModel->obtenerPorId($_GET['id']);
            $historial = $recModel->obtenerHistorial($_GET['id']);
            
            require 'vistas/historial_reparacion.php';
        }
    }

    public function formAnadirPieza() {
        if (isset($_GET['id'])) {
            $repModel = new Reparacion($this->db);
            $recModel = new Recambio($this->db);

            $reparacion = $repModel->obtenerPorId($_GET['id']);
            $listaPiezas = $recModel->obtenerTodos();

            require 'vistas/anadir_pieza.php';
        }
    }

    public function validarPieza() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idRep = $_POST['id_reparacion'];
            $idPieza = $_POST['id_pieza'];
            $cantidad = (int) $_POST['cantidad'];

            $repModel = new Reparacion($this->db);
            $recModel = new Recambio($this->db);

            $reparacion = $repModel->obtenerPorId($idRep);
            $pieza = $recModel->obtenerPorId($idPieza);

            // Cálculos
            $costeOperacion = $pieza->precio_unitario * $cantidad;
            $costeAnterior = $reparacion->coste_actual;
            $costePosterior = $costeAnterior + $costeOperacion;
            
            // Límite de presupuesto (Ejemplo de regla de negocio "examen")
            // Supongamos que si pasa de 2000€ sale aviso rojo
            $alertaPresupuesto = ($costePosterior > 2000);

            require 'vistas/validar_pieza.php';
        }
    }

    public function ejecutarPieza() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idRep = $_POST['id_reparacion'];
            $idPieza = $_POST['id_pieza'];
            $cantidad = (int) $_POST['cantidad'];
            $costeTotal = (float) $_POST['coste_total'];

            try {
                $this->db->beginTransaction();

                $repModel = new Reparacion($this->db);
                $recModel = new Recambio($this->db);

                // 1. Registrar la línea (historial)
                $fecha = time();
                $recModel->registrarLinea($idRep, $idPieza, $cantidad, $fecha, $costeTotal);

                // 2. Actualizar el total de la reparación
                $repModel->sumarCoste($idRep, $costeTotal);

                $this->db->commit();
                header("Location: index.php?accion=inicio");

            } catch (Exception $e) {
                $this->db->rollBack();
                die("Error al añadir pieza: " . $e->getMessage());
            }
        }
    }
}
?>