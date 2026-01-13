<?php
session_start();
if (!isset($_SESSION['profesor']) || $_SESSION['profesor']->rol != 'admin') header("Location: login.php");
require_once "../controller/ControladorEstudiante.php";
require_once "../controller/ControladorMatricula.php";
require_once "../controller/ControladorProfesor.php";

$est = null;
$m_sel = null;

if (isset($_POST['buscar'])) {
    $est = ControladorEstudiante::obtenerPorDni($_POST['dni_busq']);
    if (!$est) $msg = "Estudiante no encontrado";
}

if (isset($_POST['guardar'])) {
    // Validaciones manuales según examen
    if (!preg_match("/[0-9]{8}[A-Z]/", $_POST['dni'])) $err = "DNI Inválido";
    elseif (count($_POST['actividades']) == 0) $err = "Selecciona al menos una actividad";
    else {
        include "../model/Estudiante.php";
        $objE = new Estudiante($_POST['dni'], $_POST['nombre'], $_POST['dir'], $_POST['tel']);
        $objM = new Matricula($_POST['id_mat'], $_POST['asig'], $_POST['nivel'], $_POST['horas'], $_POST['foto_actual']);
        
        $res = ControladorMatricula::registrarTodo($objE, $objM, $_POST['actividades'], $_FILES['foto']);
        if ($res === true) {
            header("Location: menu.php?msg=Evaluaciones registradas para " . $_POST['nombre']);
        } else $err = $res;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<body>
    <form method="POST">
        DNI a buscar: <input type="text" name="dni_busq">
        <button name="buscar">Buscar</button>
    </form>

    <?php if ($est): ?>
        <h3>Datos de <?php echo $est->nombrecompleto; ?></h3>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="dni" value="<?php echo $est->dni; ?>">
            Matrícula ID: <input type="text" name="id_mat" pattern="[0-9]{4}[A-Z]{3}">
            Asignatura: <input type="text" name="asig">
            Profesor: 
            <select name="cod_profesor">
                <?php foreach(ControladorProfesor::obtenerTodos() as $p) echo "<option value='{$p->codigo}'>{$p->nombrecompleto}</option>"; ?>
            </select>
            Actividades (Multiselect):
            <select name="actividades[]" multiple>
                <option value="1">Examen Parcial</option>
                <option value="2">Proyecto Final</option>
            </select>
            <button name="guardar">Registrar</button>
        </form>
    <?php endif; ?>
</body>
</html>