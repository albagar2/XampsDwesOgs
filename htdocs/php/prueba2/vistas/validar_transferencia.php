<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validar Transferencia</title>
    <style>
        .rojo { color: red; font-weight: bold; }
        .bloque { margin-bottom: 10px; padding: 10px; background: #eee; }
    </style>
</head>
<body>
    <h1>Hola <?php echo $_SESSION['usuario']; ?></h1>
    
    <h3>Confirmar Transferencia</h3>
    
    <form action="index.php?accion=ejecutar" method="POST">
        <div class="bloque">Origen: <?php echo $origenIban; ?></div>
        <input type="hidden" name="origen" value="<?php echo $origenIban; ?>">
        
        <div class="bloque">Destino: <?php echo $destinoIban; ?></div>
        <input type="hidden" name="destino" value="<?php echo $destinoIban; ?>">
        
        <div class="bloque">Cantidad: <?php echo $cantidad; ?></div>
        <input type="hidden" name="cantidad" value="<?php echo $cantidad; ?>">
        
        <div class="bloque">Comisión: <?php echo $comision; ?></div>
        <input type="hidden" name="comision" value="<?php echo $comision; ?>">
        
        <div class="bloque">Saldo Anterior: <?php echo $saldoAnterior; ?></div>
        
        <div class="bloque">
            Saldo Posterior: 
            <span class="<?php echo $saldoRojo ? 'rojo' : ''; ?>">
                <?php echo $saldoPosterior; ?>
            </span>
        </div>

        <?php if (!$saldoRojo): ?>
            <button type="submit" style="background:green; color:white;">Confirmar</button>
        <?php else: ?>
            <button type="button" disabled style="background:grey;">Confirmar</button>
            <p class="rojo">Saldo insuficiente para realizar la operación.</p>
        <?php endif; ?>
        
        <a href="index.php?accion=inicio">Volver</a> | 
        <a href="index.php?accion=logout">Cerrar Sesión</a>
    </form>
</body>
</html>