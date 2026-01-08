<!DOCTYPE html>
<html>
<body>
    <h1>Historial</h1>
    <table border="1">
        <tr>
            <th>Origen</th>
            <th>Destino</th>
            <th>Fecha</th>
            <th>Cantidad</th>
        </tr>
        <?php foreach ($historial as $mov): ?>
        <tr>
            <td><?php echo $mov->iban_origen; ?></td>
            <td><?php echo $mov->iban_destino; ?></td>
            <td>
                <?php 
                // CONVERSIÓN UNIX A FECHA LEGIBLE
                echo date('d/m/Y - H:i', $mov->fecha); 
                ?>
            </td>
            <td><?php echo $mov->cantidad; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="index.php?accion=inicio">Volver</a>
</body>
</html>