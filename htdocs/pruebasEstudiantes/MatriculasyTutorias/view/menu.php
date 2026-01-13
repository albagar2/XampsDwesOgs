<?php session_start(); if(!isset($_SESSION['nombre'])) header("Location: login.php"); ?>
<!DOCTYPE html>
<html>
<body>
    <h1>Bienvenido, <?php echo $_SESSION['nombre']; ?> (<?php echo $_SESSION['rol']; ?>)</h1>
    <?php if(strpos($_SESSION['rol'], 'admin') !== false): ?>
        <a href="registrar.php">Registrar Matrícula</a><br>
    <?php endif; ?>
    <a href="expedientes.php">Consulta de Expedientes</a><br>
    <a href="logout.php">Salir</a>
</body>
</html>