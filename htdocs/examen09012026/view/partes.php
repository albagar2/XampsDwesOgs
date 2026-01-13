<?php
session_start();
if (!isset($_SESSION['profesor_dni'])) header("Location: index.php");
include_once "../controller/ControladorCurso.php";
include_once "../controller/ControladorAlumno.php";
?>
<!DOCTYPE html>
<html>
<body>
    <a href="logout.php">Cerrar Sesión</a>
    <p>Profesor: <?php echo $_SESSION['profesor_nombre']; ?></p>
    
    <form method="POST">
        Seleccione curso: 
        <select name="id_curso">
            <?php
            $cursos = ControladorCurso::obtenerCursosProfesor($_SESSION['profesor_dni']);
            foreach ($cursos as $c) {
                echo "<option value='$c->id_curso'>$c->descripcion</option>";
            }
            ?>
        </select>
        <input type="submit" name="ver_curso" value="Seleccionar curso">
    </form>

    <?php
    if (isset($_POST['ver_curso'])) {
        $info = ControladorCurso::obtenerInfoCurso($_POST['id_curso']);
        echo "<h3>Total partes del curso: $info->totalpartes</h3>";
        
        $alumnos = ControladorAlumno::listarPorCurso($_POST['id_curso']);
        echo "<table border='1'><tr><th>Nombre</th><th>Apellidos</th><th>Acción</th></tr>";
        foreach ($alumnos as $al) {
            echo "<tr>
                    <td>$al->nombre</td>
                    <td>$al->apellidos</td>
                    <td>
                        <form action='nuevoparte.php' method='POST'>
                            <input type='hidden' name='dni_a' value='$al->dni_a'>
                            <input type='hidden' name='id_curso' value='$info->id_curso'>
                            <input type='hidden' name='curso_desc' value='$info->descripcion'>
                            <input type='submit' value='Nuevo parte' name='parte'>
                        </form>
                        <form action='historial.php' method='POST'>
                            <input type='hidden' name='dni_a' value='$al->dni_a'>
                            <input type='hidden' name='id_curso' value='$info->id_curso'>
                            <input type='hidden' name='curso_desc' value='$info->descripcion'>
                            <input type='submit' value='Historial' name='historial'>
                        </form>
                    </td>
                  </tr>";
        }
        echo "</table>";
    }
    ?>
</body>
</html>