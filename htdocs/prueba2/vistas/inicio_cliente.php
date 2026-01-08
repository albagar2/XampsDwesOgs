<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio Cliente</title>
</head>
<body>
    <h1>Hola, <?php echo $_SESSION['usuario']; ?></h1>

    <h3>Mis Cuentas</h3>
    <table border="1">
        <tr>
            <th>IBAN</th>
            <th>Saldo</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($misCuentas as $cuenta): ?>
        <tr>
            <td><?php echo $cuenta->iban; ?></td>
            <td><?php echo $cuenta->saldo; ?> €</td>
            <td>
                <a href="index.php?accion=transferir&iban=<?php echo $cuenta->iban; ?>">Transferir</a>
                |
                <a href="index.php?accion=historial&iban=<?php echo $cuenta->iban; ?>">Historial</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <br><br>
    <a href="index.php?accion=logout">Cerrar Sesión</a>
</body>
</html>