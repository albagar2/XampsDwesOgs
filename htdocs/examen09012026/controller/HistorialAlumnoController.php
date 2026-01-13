<?php
session_start();

if (!isset($_SESSION['profesor_dni'])) {
    header("Location: index.php");
    exit;
}

require_once "../controller/ControladorAlumno.php";
require_once "../controller/ControladorCurso.php";
require_once "../controller/ControladorParte.php";

class HistorialAlumnoController {

    public function mostrarHistorial() {

        if (!isset($_POST['dni_a'])) {
            header("Location: partes.php");
            exit;
        }

        $alumno = ControladorAlumno::obtenerAlumno($_POST['dni_a']);
        $partes = ControladorAlumno::obtenerPartesAlumno($_POST['dni_a']);

        if (isset($_POST['quitar_parte'])) {
            ControladorParte::quitarParte($_POST['id_parte'], $_POST['id_curso']);
            $partes = ControladorAlumno::obtenerPartesAlumno($_POST['dni_a']);
        }

        require "../view/historial.php";
    }
}

$controller = new HistorialAlumnoController();
$controller->mostrarHistorial();
