<?php
session_start();
include_once '../controller/ControladorCoche.php';
include_once '../controller/ControladorTrabajo.php';
include_once '../controller/ControladorCliente.php';
include_once '../controller/ControladorEmpleado.php';
include_once '../controller/ControladorTarea.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Trabajo</title>
</head>

<body>
    <?php
    if (!isset($_SESSION['nombre'])) {
        header("Location:login.php");
    } else {
        echo "Bienvenido " . $_SESSION['nombre'], "<a href='logout.php'><input type='button' value='Logout'></a><br>";
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        unset($_SESSION['dni_cliente']);
        unset($_SESSION['coches']);
        unset($_SESSION['coche_seleccionado']);
    }

    if (isset($_POST['buscar'])) {
        $dniCliente = $_POST['dni'];
        $_SESSION['dni_cliente'] = $dniCliente;
        echo ControladorCoche::Buscar($dniCliente);
    }

    if (isset($_POST['seleccionar'])) {
        $cocheSeleccionado = unserialize($_SESSION['coches'])[$_POST['index_coche']];
        $_SESSION['coche_seleccionado'] = serialize($cocheSeleccionado);
    }

    $mostrarFormularioNuevo = false;
    if (isset($_POST['nuevo'])) {
        $mostrarFormularioNuevo = true;
    }

    if (isset($_POST['crear_coche'])) {
        $resultado = ControladorCoche::crearCoche(
            $_POST['matricula'],
            $_POST['marca'],
            $_POST['modelo'],
            $_POST['km'],
            $_FILES['foto'],
            $_POST['dni_cliente']
        );
        echo "<p>$resultado</p>";
        if (isset($_SESSION['dni_cliente'])) {
            ControladorCoche::Buscar($_SESSION['dni_cliente']);
        }
    }

    if (isset($_POST['actualizar_coche'])) {
        $resultado = ControladorCoche::actualizarCoche(
            $_POST['matricula'],
            $_POST['marca'],
            $_POST['modelo'],
            $_POST['km'],
            $_FILES['foto'],
            $_POST['dni_cliente']
        );
        echo "<p>$resultado</p>";
        if (isset($_SESSION['dni_cliente'])) {
            ControladorCoche::Buscar($_SESSION['dni_cliente']);
        }
    }

    if (isset($_POST['actualizar_cliente'])) {
        $resultado = ControladorCliente::actualizarCliente(
            $_POST['dni'],
            $_POST['nombrecompleto'],
            $_POST['direccion'],
            $_POST['tlf']
        );
        echo "<p>$resultado</p>";
    }

    if (isset($_POST['registrar_trabajo'])) {
        $resultado = ControladorTrabajo::crearTrabajo(
            $_POST['matricula'],
            $_POST['cod_mecanico'],
            $_POST['id_tarea'],
            $_POST['horas']
        );
        echo "<p>$resultado</p>";
    }

    if (isset($_POST['asignar_tareas'])) {
        if (isset($_POST['tareas']) && count($_POST['tareas']) > 0) {
            $resultado = ControladorTrabajo::asignarTareas(
                $_POST['matricula'],
                $_POST['cod_mecanico'],
                $_POST['tareas'],
                $_POST['horas']
            );
            setcookie("tareasasginadas", $resultado, time() + 20);
            header("Location: menu.php");
        } else {
            echo "<p>Debe seleccionar al menos una tarea</p>";
        }
    }
    ?>

    <h2>Buscar coches por DNI</h2>
    <form method="post">
        Dni cliente: <input type="text" name="dni" required>
        <input type="submit" value="Buscar" name="buscar">
    </form>

    <?php

    if (isset($_SESSION['coches'])) {
        $coches = unserialize($_SESSION['coches']);
        if (count($coches) > 0) {
            echo "<h2>Listado de coches encontrados:</h2>";
            echo "<table border='1'>";
            echo "<tr><th>Matrícula</th><th>Marca</th><th>Modelo</th><th>Seleccionar</th></tr>";
            foreach ($coches as $index => $coche) {
                echo "<tr>";
                echo "<td>" . $coche->matricula . "</td>";
                echo "<td>" . $coche->marca . "</td>";
                echo "<td>" . $coche->modelo . "</td>";
                echo "<td>
                    <form method='post'>
                        <input type='hidden' name='index_coche' value='" . $index . "'>
                        <input type='submit' value='Seleccionar' name='seleccionar'>
                    </form>
                </td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "<br>";
            echo "<form method='post'>
                        <input type='submit' value='Nuevo' name='nuevo'>
                    </form>";
        }
    }

    if ($mostrarFormularioNuevo && isset($_SESSION['dni_cliente'])) {
        echo "<h2>Crear Nuevo Coche</h2>";
        echo "<form method='post' enctype='multipart/form-data'>";
        echo "<input type='hidden' name='dni_cliente' value='" . $_SESSION['dni_cliente'] . "'>";

        echo "<label>Matrícula: ";
        echo "<input type='text' name='matricula' pattern='[0-9]{4}[A-Z]{3}' required>";
        echo "</label><br><br>";

        echo "<label>Marca: ";
        echo "<input type='text' name='marca' required>";
        echo "</label><br><br>";

        echo "<label>Modelo: ";
        echo "<input type='text' name='modelo' required>";
        echo "</label><br><br>";

        echo "<label>Kilómetros: ";
        echo "<input type='number' name='km' min='0' required>";
        echo "</label><br><br>";

        echo "<label>Foto: ";
        echo "<input type='file' name='foto' accept='.jpg' required>";
        echo "</label><br><br>";

        echo "<input type='submit' value='Crear Coche' name='crear_coche'>";
        echo "</form>";
    }

    if (isset($_SESSION['coche_seleccionado'])) {
        $cocheSeleccionado = unserialize($_SESSION['coche_seleccionado']);
        echo "<h2>Editar Coche</h2>";
        echo "<form method='post' enctype='multipart/form-data'>";
        echo "<label>Matrícula: ";
        echo "<input type='text' name='matricula' value='" . $cocheSeleccionado->matricula . "' readonly>";
        echo "</label><br><br>";
        echo "<label>Marca: ";
        echo "<input type='text' name='marca' value='" . $cocheSeleccionado->marca . "' required>";
        echo "</label><br><br>";
        echo "<label>Modelo: ";
        echo "<input type='text' name='modelo' value='" . $cocheSeleccionado->modelo . "' required>";
        echo "</label><br><br>";
        echo "<label>Kilómetros: ";
        echo "<input type='number' name='km' value='" . $cocheSeleccionado->km . "' min='0' required>";
        echo "</label><br><br>";
        echo "<label>Foto actual: ";
        echo "<img src='../coches/" . $cocheSeleccionado->foto . "' width='200' height='200'><br>";
        echo "Cambiar foto: <input type='file' name='foto' accept='.jpg'>";
        echo "</label><br><br>";
        echo "<input type='hidden' name='dni_cliente' value='" . $cocheSeleccionado->dni_cliente . "'>";
        echo "<input type='submit' value='Actualizar Coche' name='actualizar_coche'>";
        echo "</form>";

        $clienteData = ControladorCliente::obtenerCliente($cocheSeleccionado->dni_cliente);
        if ($clienteData) {
            echo "<h2>Editar Cliente</h2>";
            echo "<form method='post'>";
            echo "<label>DNI: ";
            echo "<input type='text' name='dni' value='" . $clienteData->dni . "' pattern='[0-9]{8}[A-Z]{1}' readonly required>";
            echo "</label><br><br>";
            echo "<label>Nombre Completo: ";
            echo "<input type='text' name='nombrecompleto' value='" . $clienteData->nombrecompleto . "' readonly required>";
            echo "</label><br><br>";
            echo "<label>Dirección: ";
            echo "<input type='text' name='direccion' value='" . $clienteData->direccion . "' required>";
            echo "</label><br><br>";
            echo "<label>Teléfono: ";
            $telefono = isset($clienteData->tlf) ? $clienteData->tlf : (isset($clienteData->telf) ? $clienteData->telf : '');
            echo "<input type='text' name='tlf' value='" . $telefono . "' pattern='[0-9]{9}' required>";
            echo "</label><br><br>";
            echo "<input type='submit' value='Actualizar Cliente' name='actualizar_cliente'>";
            echo "</form>";
        }

        echo "<h2>Asignar Tareas</h2>";
        echo "<form method='post'>";
        echo "<input type='hidden' name='matricula' value='" . $cocheSeleccionado->matricula . "'>";

        echo "<label>Empleado: ";
        echo "<select name='cod_mecanico' required>";
        echo "<option value=''>Seleccione un empleado</option>";
        $empleados = ControladorEmpleado::obtenerTodos();
        foreach ($empleados as $empleado) {
            echo "<option value='" . $empleado->codigo . "'>" . $empleado->nombrecompleto . "</option>";
        }
        echo "</select>";
        echo "</label><br><br>";

        $tareas = ControladorTarea::obtenerTodas();
        $tareasPorTipo = [];
        foreach ($tareas as $tarea) {
            $tipo = isset($tarea->tipo) ? $tarea->tipo : 'Sin tipo';
            if (!isset($tareasPorTipo[$tipo])) {
                $tareasPorTipo[$tipo] = [];
            }
            $tareasPorTipo[$tipo][] = $tarea;
        }

        foreach ($tareasPorTipo as $tipo => $tareasDelTipo) {
            echo "<label>" . $tipo . ": ";
            echo "<select name='tareas[]' multiple size='5'>";
            foreach ($tareasDelTipo as $tarea) {
                echo "<option value='" . $tarea->id . "'>" . $tarea->descripcion . " - " . $tarea->precio . "€</option>";
            }
            echo "</select>";
            echo "</label><br><br>";
        }

        echo "<label>Horas: ";
        echo "<input type='number' name='horas'  required>";
        echo "</label><br><br>";

        echo "<input type='submit' value='Asignar Tareas' name='asignar_tareas'>";
        echo "</form>";
    }
    ?>
    <br>
    <a href="menu.php"><input type='button' value='Volver al menú'></a>

</body>

</html>