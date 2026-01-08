<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login Taller</title>
</head>
<body>

<h2>Acceso al sistema</h2>

<?php if (!empty($mensaje)) { ?>
    <p style="color:red;"><?php echo $mensaje; ?></p>
<?php } ?>

<form action="../controlador/LoginController.php" method="POST">
    <label>Código de empleado:</label><br>
    <input type="text" name="codigo"><br><br>

    <label>Clave:</label><br>
    <input type="password" name="clave"><br><br>

    <input type="submit" name="enviar" value="Entrar">
</form>

</body>
</html>