<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Taller</title>
</head>
<body>
    <h1>Acceso Taller Mecánico</h1>
    <form action="index.php" method="POST">
        <label>DNI:</label> <input type="text" name="dni" required><br><br>
        <label>Clave:</label> <input type="password" name="clave" required><br><br>
        <button type="submit">Entrar</button>
    </form>

    <?php if (isset($error)): ?>
        <p style="color:red; font-weight:bold;"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (isset($intentos) && $intentos > 0): ?>
        <p style="color:orange;">Le quedan <?php echo $intentos; ?> intentos.</p>
    <?php endif; ?>
</body>
</html>