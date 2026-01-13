<?php
session_start();
require_once "../controller/ControladorEvaluacion.php";
$profe = $_SESSION['profesor'];
?>
<!DOCTYPE html>
<html>
<body>
    <?php if ($profe->rol == 'profesor'): ?>
        <h2>Mis correcciones pendientes (Hoy)</h2>
        <?php 
        $evs = ControladorEvaluacion::obtenerPendientesHoy($profe->codigo);
        echo "<table border='1'><tr><th>Matricula</th><th>Nota</th><th>Accion</th></tr>";
        foreach ($evs as $e) {
            echo "<tr><form method='POST'>
                <td>{$e->id_matricula}</td>
                <td><input type='number' name='nota' step='0.1'></td>
                <td><button name='corregir'>Evaluar</button></td>
            </form></tr>";
        }
        echo "</table>";
        ?>
    <?php else: // Perfil ADMIN ?>
        <h2>Consulta Administrador</h2>
        <form method="POST">
            Matrícula: <input type="text" name="f_mat">
            Fecha: <input type="date" name="f_fec">
            <button name="f_buscar">Consultar</button>
        </form>
        <?php endif; ?>
</body>
</html>