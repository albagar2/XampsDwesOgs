<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmar Pieza</title>
    <style>.rojo { color: red; font-weight: bold; }</style>
</head>
<body>
    <h1>Confirmar operación</h1>
    <form action="index.php?accion=ejecutar" method="POST">
        
        <p>Coche: <strong><?php echo $reparacion->matricula; ?></strong></p>
        <p>Pieza: <?php echo $pieza->nombre; ?> (x<?php echo $cantidad; ?>)</p>
        <p>Subtotal Operación: <?php echo $costeOperacion; ?> €</p>
        <hr>
        <p>Coste Anterior: <?php echo $costeAnterior; ?> €</p>
        <p class="<?php echo $alertaPresupuesto ? 'rojo' : ''; ?>">
            Coste Posterior: <?php echo $costePosterior; ?> €
            <?php if ($alertaPresupuesto): ?> (¡PRESUPUESTO ALTO!) <?php endif; ?>
        </p>

        <input type="hidden" name="id_reparacion" value="<?php echo $idRep; ?>">
        <input type="hidden" name="id_pieza" value="<?php echo $idPieza; ?>">
        <input type="hidden" name="cantidad" value="<?php echo $cantidad; ?>">
        <input type="hidden" name="coste_total" value="<?php echo $costeOperacion; ?>">

        <button type="submit">Confirmar e Insertar</button>
    </form>
    <br>
    <a href="index.php?accion=inicio">Volver</a>
</body>
</html>