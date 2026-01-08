<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Banco</title>
</head>
<body>
    <h1>Acceso Banca Online</h1>

    <form action="index.php" method="POST">
        <div>
            <label for="dni">DNI:</label>
            <input type="text" name="dni" required>
        </div>
        <br>
        <div>
            <label for="clave">Contraseña:</label>
            <input type="password" name="clave" required>
        </div>
        <br>
        <button type="submit">Entrar</button>
    </form>

    <?php if (isset($error)): ?>
        <p style="color: red; font-weight: bold;">
            <?php echo $error; ?>
        </p>
    <?php endif; ?>

    <?php if (isset($intentos) && $intentos > 0): ?>
        <p style="color: orange;">
            LE QUEDA <?php echo $intentos; ?> intento(s).
        </p>
    <?php endif; ?>

</body>
</html>