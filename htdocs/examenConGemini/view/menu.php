<?php session_start(); ?>
<!DOCTYPE html>
<html>
<body>
    <h1>Bienvenido, <?php echo $_SESSION['nombre']; ?></h1>
    <a href="registrartrabajo.php">Registrar Trabajo (Admin)</a><br>
    <a href="vertrabajo.php">Ver mis trabajos (Mecánico)</a><br>
    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>