<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Reparaciones</title>
</head>
<body>
    <h1>Hola, <?php echo $_SESSION['usuario']; ?></h1>
    <h3>Mis Reparaciones Asignadas</h3>

    <table border="1">
        <tr>
            <th>Matrícula</th>
            <th>Descripción</th>
            <th>Coste Actual</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($misReparaciones as $rep): ?>
        <tr>
            <td><?php echo $rep->matricula; ?></td>
            <td><?php echo $rep->descripcion; ?></td>
            <td><?php echo $rep->coste_actual; ?> €</td>
            <td>
                <a href="index.php?accion=anadir&id=<?php echo $rep->id_reparacion; ?>">Añadir Pieza</a> | 
                <a href="index.php?accion=historial&id=<?php echo $rep->id_reparacion; ?>">Ver Piezas</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="index.php?accion=logout">Cerrar Sesión</a>
</body>
</html>