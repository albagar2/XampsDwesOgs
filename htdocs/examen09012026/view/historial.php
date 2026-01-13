<?php
session_start();

if (!isset($_SESSION['profesor_dni'])) {
    header("Location: index.php");
    exit;
}

include_once "../controller/ControladorCurso.php";
include_once "../controller/ControladorAlumno.php";
include_once "../controller/ControladorParte.php";

if (!isset($_POST['dni_a'])) {
    header("Location: partes.php");
    exit;
}

$alumno = ControladorAlumno::obtenerAlumno($_POST['dni_a']);
$partes = ControladorAlumno::obtenerPartesAlumno($_POST['dni_a']);
?>
<!DOCTYPE html>
<html>
<body>

<a href="logout.php">Cerrar Sesión</a>
<a href="partes.php">Inicio</a>

<p>Profesor: <?php echo $_SESSION['profesor_nombre']; ?></p>

<h2>
    Historial de partes del alumno:
    <?php echo $alumno->nombre . " " . $alumno->apellidos; ?>
</h2>

<table border="1">
    <tr>
        <th>Fecha</th>
        <th>Profesor</th>
        <th>Motivo</th>
        <th>Imagen</th>
        <th>Quitar parte</th>
    </tr>

<?php
foreach ($partes as $p) {

    if (isset($_POST['quitar_parte']) && $_POST['id_parte'] == $p->id) {
        ControladorParte::quitarParte($_POST['id_parte'], $_POST['id_curso']);
    }

    $profesor = ControladorCurso::obtenerProfesorParte($p->id);

    echo "<tr>
            <td>" . date('d-m-Y', $p->time) . "</td>
            <td>$profesor->nombre $profesor->apellidos</td>
            <td>$p->motivo</td>
            <td>";

    if ($p->foto != "") {
        echo "<img src='../imgpartes/$p->foto' width='100'>";
    } else {
        echo "No hay imagen";
    }

    echo "</td><td>";

    if ($_SESSION['profesor_dni'] == $p->dni_p) { ?>
        <form method="POST">
            <input type="hidden" name="dni_a" value="<?php echo $_POST['dni_a']; ?>">
            <input type="hidden" name="id_curso" value="<?php echo $_POST['id_curso']; ?>">
            <input type="hidden" name="curso_desc" value="<?php echo $_POST['curso_desc']; ?>">
            <input type="hidden" name="id_parte" value="<?php echo $p->id; ?>">
            <input type="submit" name="quitar_parte" value="Quitar parte">
        </form>
    <?php
    } else {
        echo "No autorizado";
    }

    echo "</td></tr>";
}
?>
</table>

</body>
</html>
