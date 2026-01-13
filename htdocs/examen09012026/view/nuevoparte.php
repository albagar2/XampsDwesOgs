<?php
session_start();
if (!isset($_SESSION['profesor_dni'])) header("Location: index.php");
include_once "../controller/ControladorAlumno.php";
include_once "../controller/ControladorParte.php";

$alumno = ControladorAlumno::obtenerAlumno($_POST['dni_a']);
?>
<!DOCTYPE html>
<html>
<body>
    <a href="logout.php">Cerrar Sesión</a> | <a href="partes.php">Volver al inicio</a>
    <h2>Partes de Incidencias</h2>
    <p>Profesor: <?php echo $_SESSION['profesor_nombre']; ?></p>

    <?php
    if (isset($_POST['guardar'])) {
        echo "<p>".ControladorParte::guardarParte()."</p>";
    }
    ?>

    <p>D/Dª <?php echo $_SESSION['profesor_nombre']; ?>, como profesor de este Centro, comunica que el alumno/a 
    <strong><?php echo $alumno->nombre." ".$alumno->apellidos; ?></strong> 
    del grupo <strong><?php echo $_POST['curso_desc']; ?></strong> ha cometido la siguiente falta:</p>

    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="dni_a" value="<?php echo $alumno->dni_a; ?>">
        <input type="hidden" name="id_curso" value="<?php echo $_POST['id_curso']; ?>">
        <input type="hidden" name="curso_desc" value="<?php echo $_POST['curso_desc']; ?>">
        
        <textarea name="motivo" rows="4" cols="50" required></textarea><br><br>
        Imagen (solo JPG): <input type="file" name="foto" accept=".jpg"><br><br>
        <input type="submit" name="guardar" value="Guardar parte">
    </form>
</body>
</html>