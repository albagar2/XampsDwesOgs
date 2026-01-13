<?php session_start(); ?>
<!DOCTYPE html>
<html>
<body>
    <h2>Bienvenido <?php echo $_SESSION['nombre']; ?> (<?php echo $_SESSION['rol']; ?>)</h2>
    <?php if (isset($_GET['msg'])) echo "<p>{$_GET['msg']}</p>"; ?>
    
    <?php if ($_SESSION['rol'] == 'admin'): ?>
        <a href="registrar.php">Registrar Evaluación</a><br>
    <?php endif; ?>
    <a href="expedientes.php">Consulta de Expedientes</a><br>
    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>