<?php
session_start();
include_once '../controller/ControladorTrabajo.php';
include_once '../controller/ControladorCoche.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Trabajos</title>
</head>

<body>
    <?php
    if (!isset($_SESSION['nombre'])) {
        header("Location:login.php");
    } else {
        echo "Bienvenido " . $_SESSION['nombre'], "<a href='logout.php'><input type='button' value='Logout'></a><br>";
    }

    if (isset($_POST['actualizar_estado'])) {
        $resultado = ControladorTrabajo::actualizarEstado(
            $_POST['matricula'],
            $_POST['cod_mecanico'],
            $_POST['id_tarea'],
            $_POST['estado']
        );
        echo "<p>$resultado</p>";
    }

    if (isset($_SESSION['rol']) && $_SESSION['rol'] == "admin") {
        echo "<h2>Buscar Trabajos</h2>";
        echo "<form method='post'>";
        echo "<label>Matrícula: ";
        echo "<input type='text' name='matricula' pattern='[0-9]{4}[A-Z]{3}'>";
        echo "</label>";
        echo "<label>Fecha: ";
        echo "<input type='date' name='fecha'>";
        echo "</label>";
        echo "<input type='submit' value='Buscar' name='buscar'>";
        echo "</form>";

        if (isset($_POST['buscar']) || isset($_POST['facturar'])) {
            $matricula = isset($_POST['matricula']) && $_POST['matricula'] !== '' ? $_POST['matricula'] : null;
            $fecha = isset($_POST['fecha']) && $_POST['fecha'] !== '' ? $_POST['fecha'] : null;
            $trabajos = ControladorTrabajo::buscarTrabajos($matricula, $fecha);

            if (count($trabajos) > 0) {
                $todasCompletadas = true;
                foreach ($trabajos as $trabajo) {
                    if ($trabajo->estado != 'Completada' && $trabajo->estado != 'Facturada') {
                        $todasCompletadas = false;
                        break;
                    }
                }

                if (isset($_POST['facturar'])) {
                    if ($todasCompletadas) {
                        $cocheData = null;
                        if ($matricula) {
                            $cocheData = ControladorCoche::obtenerCoche($matricula);
                        }

                        echo "<h2>FACTURA</h2>";
                        if ($cocheData) {
                            echo "<h3>La factura para el coche " . $cocheData->marca . " - " . $cocheData->modelo . " con matricula " . 
                            $cocheData->matricula . " son: </h3>";
                            echo "<img src='../coches/" . $cocheData->foto . "' width='200' height='200'><br><br>";
                        } else {
                            echo "<h3>Factura de trabajos:</h3>";
                        }
                        echo "<table border='1'>";
                        echo "<tr><th>Descripción</th><th>Horas</th><th>Precio/Hora</th><th>Subtotal</th></tr>";

                        $total = 0;
                        foreach ($trabajos as $trabajo) {
                            if ($trabajo->estado == 'Completada' || $trabajo->estado == 'Facturada') {
                                $subtotal = $trabajo->precio * $trabajo->horas;
                                $total += $subtotal;

                                echo "<tr>";
                                echo "<td>" . $trabajo->descripcion . "</td>";
                                echo "<td>" . $trabajo->horas . "</td>";
                                echo "<td>" . $trabajo->precio . "€</td>";
                                echo "<td>" . number_format($subtotal, 2) . "€</td>";
                                echo "</tr>";
                            }
                        }

                        echo "<tr>";
                        echo "<td colspan='3'><strong>TOTAL:</strong></td>";
                        echo "<td><strong>" . number_format($total, 2) . "€</strong></td>";
                        echo "</tr>";
                        echo "</table>";
                    } else {
                        echo "<p>No se puede facturar: todas las tareas deben estar completadas</p>";
                    }
                } else {
                    echo "<h2>Listado de Trabajos</h2>";
                    echo "<table border='1'>";
                    echo "<tr><th>Descripción</th><th>Mecánico</th><th>Fecha</th><th>Estado</th><th>Horas</th><th>Precio/Hora</th></tr>";

                    foreach ($trabajos as $trabajo) {
                        echo "<tr>";
                        echo "<td>" . $trabajo->descripcion . "</td>";
                        echo "<td>" . $trabajo->cod_mecanico . "</td>";
                        echo "<td>" . $trabajo->fecha . "</td>";
                        echo "<td>" . $trabajo->estado . "</td>";
                        echo "<td>" . $trabajo->horas . "</td>";
                        echo "<td>" . $trabajo->precio . "€</td>";
                        echo "</tr>";
                    }
                    echo "</table><br>";

                    echo "<form method='post'>";
                    echo "<input type='hidden' name='matricula' value='" . $matricula . "'>";
                    echo "<input type='hidden' name='fecha' value='" . $fecha . "'>";
                    echo "<input type='submit' value='Facturar' name='facturar'>";
                    echo "</form>";
                }
            } else {
                echo "<p>No se encontraron trabajos</p>";
            }
        }
    }

    if (isset($_SESSION['codigo']) && $_SESSION['rol'] == "mecanico") {
        $trabajos = ControladorTrabajo::obtenerTrabajosMecanico($_SESSION['codigo']);

        if (count($trabajos) > 0) {
            echo "<h2>Mis Trabajos</h2>";
            echo "<table border='1'>";
            echo "<tr><th>Matrícula</th><th>ID Tarea</th><th>Fecha</th><th>Estado</th><th>Horas</th><th>Actualizar</th></tr>";

            foreach ($trabajos as $trabajo) {
                echo "<tr>";
                echo "<td>" . $trabajo->matricula . "</td>";
                echo "<td>" . $trabajo->id_tarea . "</td>";
                echo "<td>" . $trabajo->fecha . "</td>";
                echo "<td>" . $trabajo->estado . "</td>";
                echo "<td>" . $trabajo->horas . "</td>";
                echo "<td>";
                echo "<form method='post'>";
                echo "<input type='hidden' name='matricula' value='" . $trabajo->matricula . "'>";
                echo "<input type='hidden' name='cod_mecanico' value='" . $trabajo->cod_mecanico . "'>";
                echo "<input type='hidden' name='id_tarea' value='" . $trabajo->id_tarea . "'>";
                echo "<select name='estado'>";
                echo "<option value='Pendiente'" . ($trabajo->estado == 'Pendiente' ? ' selected' : '') . ">Pendiente</option>";
                echo "<option value='En proceso'" . ($trabajo->estado == 'En proceso' ? ' selected' : '') . ">En proceso</option>";
                echo "<option value='Completada'" . ($trabajo->estado == 'Completada' ? ' selected' : '') . ">Completada</option>";
                echo "</select>";
                echo "<input type='submit' value='Actualizar' name='actualizar_estado'>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No tienes trabajos asignados</p>";
        }
    }
    ?>
    <br>
    <a href="menu.php"><input type='button' value='Volver al menú'></a>

</body>

</html>