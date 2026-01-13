<?php
session_start();
include_once '../controller/ControladorTrabajo.php';
?>
<!DOCTYPE html>
<html>
<body>
    <h2>Mis Trabajos</h2>
    <?php
    if (isset($_POST['act'])) echo ControladorTrabajo::actualizarEstado($_POST['mat'], $_POST['mec'], $_POST['tar'], $_POST['est']);
    
    $trabs = ControladorTrabajo::obtenerPorMecanico($_SESSION['codigo']);
    echo "<table border='1'><tr><th>Matrícula</th><th>Tarea</th><th>Estado</th><th>Acción</th></tr>";
    foreach ($trabs as $t) {
        echo "<tr>
            <td>{$t->matricula}</td>
            <td>{$t->id_tarea}</td>
            <td>{$t->estado}</td>
            <td>
                <form method='POST'>
                    <input type='hidden' name='mat' value='{$t->matricula}'>
                    <input type='hidden' name='mec' value='{$t->cod_mecanico}'>
                    <input type='hidden' name='tar' value='{$t->id_tarea}'>
                    <select name='est'>
                        <option value='En proceso'>En proceso</option>
                        <option value='Completada'>Completada</option>
                    </select>
                    <button name='act'>Actualizar</button>
                </form>
            </td>
        </tr>";
    }
    echo "</table>";
    ?>
    <br><a href="menu.php">Volver</a>
</body>
</html>