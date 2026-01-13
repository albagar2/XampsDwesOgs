<?php 
    session_start();
    if (!isset($_SESSION['codigo'])) {
        header("Location: /__DIR__.'/../public/login.php'");
        exit;
    }
    $mensaje = $_GET['mensaje'] ?? '';
?>

<!doctype html>
<html>
<head><meta charset="utf-8"><title>Menu - Taller</title></head>
<body>
    <h1>Menú</h1>
    <p>Usuario: <?php echo $_SESSION['nombrecompleto']; ?> | Rol: <?php echo $_SESSION['rol']; ?> |
       <a href="/logout.php">Cerrar sesión</a></p>

    <?php if (!empty($mensaje)): ?>
        <p style="color:green;"><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <ul>
        <li><a href="/trabajo.php">Ver trabajo</a></li>
        <?php if (strpos($_SESSION['rol'], 'admin') !== false || $_SESSION['rol'] === 'admin'): ?>
            <li><a href="/registra.php">Registro de trabajo</a></li>
        <?php endif; ?>
    </ul>
</body>
</html>