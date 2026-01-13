<?php
session_start();
include_once '../controller/ControladorMatricula.php';
?>
<!DOCTYPE html>
<html>
<body>
    <h2>Consulta de Expedientes</h2>
    <form method="POST">
        DNI: <input type="text" name="dni_exp">
        <button name="ver_exp">Consultar</button>
    </form>

    <?php
    if (isset($_POST['ver_exp']) || isset($_POST['btn_pagar'])) {
        $dni = $_POST['dni_exp'];
        if (isset($_POST['btn_pagar'])) ControladorMatricula::pagarMatrícula($dni);

        $datos = ControladorMatricula::obtenerExpediente($dni);
        $total = 0; $todosAceptados = true;
        
        echo "<table border='1'><tr><th>Asignatura</th><th>Estado</th><th>Precio</th></tr>";
        foreach ($datos as $d) {
            echo "<tr><td>{$d->nombre_asignatura}</td><td>{$d->estado}</td><td>{$d->precio_credito}€</td></tr>";
            $total += $d->precio_credito;
            if ($d->estado !== 'Aceptada' && $d->estado !== 'Pagada') $todosAceptados = false;
        }
        echo "</table><h3>Total: $total €</h3>";

        if ($todosAceptados && $_SESSION['rol'] == 'admin') {
            echo "<form method='POST'>
                <input type='hidden' name='dni_exp' value='$dni'>
                <button name='btn_pagar'>Generar Carta de Pago</button>
            </form>";
        }
    }
    ?>
    <br><a href="menu.php">Volver</a>
</body>
</html>