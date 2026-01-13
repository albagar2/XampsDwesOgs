<?php
session_start();
include_once '../controller/ControladorCoche.php';
include_once '../controller/ControladorTrabajo.php';
include_once '../controller/ControladorEmpleado.php';
include_once '../controller/ControladorTarea.php';

if (!isset($_SESSION['nombre'])) header("Location: login.php");
?>
<!DOCTYPE html>
<html>
<body>
    <h2>Registrar Trabajo</h2>
    <form method="post">
        DNI Cliente: <input type="text" name="dni" required>
        <input type="submit" value="Buscar" name="buscar">
    </form>

    <?php
    if (isset($_POST['buscar'])) {
        $_SESSION['dni_cliente'] = $_POST['dni'];
        ControladorCoche::Buscar($_POST['dni']);
    }

    if (isset($_SESSION['coches'])) {
        $coches = unserialize($_SESSION['coches']);
        foreach ($coches as $index => $coche) {
            echo "Matrícula: " . $coche->matricula . " - " . $coche->marca;
            echo "<form method='post'><input type='hidden' name='idx' value='$index'><input type='submit' name='seleccionar' value='Seleccionar'></form><br>";
        }
    }

    if (isset($_POST['seleccionar'])) {
        $_SESSION['c_sel'] = serialize(unserialize($_SESSION['coches'])[$_POST['idx']]);
    }

    if (isset($_SESSION['c_sel'])) {
        $c = unserialize($_SESSION['c_sel']);
        echo "<h3>Asignar Tareas a: " . $c->matricula . "</h3>";
        ?>
        <form method="post">
            <input type="hidden" name="matricula" value="<?php echo $c->matricula; ?>">
            Mecánico: 
            <select name="cod_mecanico">
                <?php
                foreach (ControladorEmpleado::obtenerTodos() as $e) {
                    echo "<option value='{$e->codigo}'>{$e->nombrecompleto}</option>";
                }
                ?>
            </select><br>
            Tareas (Multiselect): <br>
            <select name="tareas[]" multiple>
                <?php
                foreach (ControladorTarea::obtenerTodas() as $t) {
                    echo "<option value='{$t->id}'>{$t->descripcion} ({$t->precio}€)</option>";
                }
                ?>
            </select><br>
            Horas: <input type="number" name="horas"><br>
            <input type="submit" name="asignar_tareas" value="Asignar">
        </form>
    <?php } ?>
</body>
</html>