<?php
// public/trabajo.php
session_start();
if (!isset($_SESSION['codigo'])) {
    header("Location: /__DIR__.'/../public/login.php'");
    exit;
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Trabajos</title></head>
<body>
    <p>Usuario: <?php echo $_SESSION['nombrecompleto']; ?> (<?php echo $_SESSION['rol']; ?>) | <a href="/logout.php">Cerrar sesión</a></p>
    <h1>Trabajos</h1>
    <p>Lista de trabajos.</p>
    <p><a href="/menu.php">Volver al menú</a></p>
</body>
</html>