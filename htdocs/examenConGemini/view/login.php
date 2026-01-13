<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
    <?php
    session_start();
    include_once '../controller/ControladorEmpleado.php';
    if (isset($_POST['enviar'])) echo ControladorEmpleado::loginEmpleado();
    ?>
    <form action="" method="POST">
        Código: <input type="text" name="usuario" required><br>
        Clave: <input type="password" name="clave" required><br>
        <button type="submit" name="enviar">Iniciar Sesión</button>
    </form>
</body>
</html>