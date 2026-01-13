<?php
require_once "Conexion.php";

class ControladorParte {
    public static function guardarParte() {
        $conex = new Conexion();
        $dni_a = $_POST['dni_a'];
        $dni_p = $_SESSION['profesor_dni'];
        $motivo = $_POST['motivo'];
        $id_curso = $_POST['id_curso'];
        $tiempo = time();
        $nombreFoto = null;

        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
            if ($ext == 'jpg') {
                $nombreFoto = $dni_a."-".$tiempo.".jpg";
                move_uploaded_file($_FILES['foto']['tmp_name'], "../imgpartes/".$nombreFoto);
            }
        }

        $sql = "INSERT INTO partes (dni_p, dni_a, motivo, time, foto) VALUES ('$dni_p', '$dni_a', '$motivo', $tiempo, '$nombreFoto')";
        
        if ($conex->query($sql)) {
            $conex->query("UPDATE curso SET totalpartes = totalpartes + 1 WHERE id_curso = $id_curso");
            return "Parte registrado correctamente.";
        }
        return "Error al registrar el parte.";
    }
    public static function quitarParte($id_parte, $id_curso) {
        if (session_status() == PHP_SESSION_NONE) session_start();
        $conex = new Conexion();
        $check = $conex->query("SELECT dni_p FROM partes WHERE id = $id_parte");
        if (!$check) return "Error al comprobar el parte.";
        $fila = $check->fetch_object();
        if (!$fila) return "Parte no encontrado.";
        if (!isset($_SESSION['profesor_dni']) || $_SESSION['profesor_dni'] != $fila->dni_p) {
            return "No autorizado para eliminar este parte.";
        }
        $res = $conex->query("DELETE FROM partes WHERE id = $id_parte");
        if ($res) {
            $conex->query("UPDATE curso SET totalpartes = totalpartes - 1 WHERE id_curso = $id_curso");
            return "Parte eliminado correctamente.";
        }
        return "Error al eliminar el parte.";
    }
}
?>