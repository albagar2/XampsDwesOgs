<!DOCTYPE html>
<html lang="es">
<body>
    <h1>Historial de piezas: <?php echo $reparacion->matricula; ?></h1>
    <table border="1">
        <tr>
            <th>Pieza</th>
            <th>Cantidad</th>
            <th>Fecha</th>
            <th>Coste Línea</th>
        </tr>
        <?php foreach ($historial as $linea): ?>
        <tr>
            <td><?php echo $linea->nombre_pieza; ?></td>
            <td><?php echo $linea->cantidad; ?></td>
            <td><?php echo date('d/m/Y H:i', $linea->fecha); ?></td>
            <td><?php echo $linea->coste_total_linea; ?> €</td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="index.php?accion=inicio">Volver</a>
</body>
</html>