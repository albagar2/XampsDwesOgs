<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Recambio</title>
</head>
<body>
    <h1>Reparación: <?php echo $reparacion->matricula; ?></h1>
    <p>Coste acumulado: <?php echo $reparacion->coste_actual; ?> €</p>

    <form action="index.php?accion=validar" method="POST">
        <input type="hidden" name="id_reparacion" value="<?php echo $reparacion->id_reparacion; ?>">
        
        <label>Seleccione Pieza:</label>
        <select name="id_pieza">
            <?php foreach ($listaPiezas as $p): ?>
                <option value="<?php echo $p->id_recambio; ?>">
                    <?php echo $p->nombre; ?> - <?php echo $p->precio_unitario; ?> €
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>
        <label>Cantidad:</label>
        <input type="number" name="cantidad" value="1" min="1" required>
        <br><br>
        <button type="submit">Siguiente</button>
    </form>
    <br>
    <a href="index.php?accion=inicio">Cancelar</a>
</body>
</html>