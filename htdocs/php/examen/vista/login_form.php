<?php
// $error lo podemos tener definido por el controlador
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Login - Taller</title></head>
<body>
    <h1>Login</h1>
    <?php if (!empty($error)): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="post" action="/../examen/public/login.php">
        <label>Código: <input type="text" name="codigo" required></label><br>
        <label>Clave: <input type="password" name="clave" required></label><br>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>