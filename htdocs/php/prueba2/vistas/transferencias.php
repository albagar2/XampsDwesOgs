<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Realizar Transferencia</title>
</head>
<body>
    <h1>Realizar Transferencia</h1>
    
    <p><strong>Cuenta Origen:</strong> <?php echo $cuentaOrigen->iban; ?> (Saldo: <?php echo $cuentaOrigen->saldo; ?> €)</p>

    <form action="index.php?accion=validar" method="POST">
        <input type="hidden" name="origen" value="<?php echo $cuentaOrigen->iban; ?>">

        <div>
            <label>Destinatario:</label>
            <select name="destino">
                <?php foreach ($destinos as $dest): ?>
                    <option value="<?php echo $dest->iban; ?>">
                        <?php echo $dest->Nombre; ?> - <?php echo $dest->iban; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <br>
        <div>
            <label>Cantidad (€):</label>
            <input type="number" step="0.01" name="cantidad" required>
        </div>
        <br>
        <button type="submit">Validar Transferencia</button>
    </form>

    <br>
    <a href="index.php?accion=inicio">Volver</a>
</body>
</html>