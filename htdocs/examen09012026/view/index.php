<!DOCTYPE html>
<html lang="es">
<head><title>Login</title></head>
<body>
    <h2>Login Profesores</h2>
    <?php
    include_once "../controller/ControladorProfesor.php";
    if (isset($_POST['enviar'])) {
        echo "<p style='color:red'>" . ControladorProfesor::login() . "</p>";
    }
    ?>
    <form action="" method="POST">
        DNI: <input type="text" name="dni" required><br>
        Clave: <input type="password" name="pass" required><br>
        <button type="submit" name="enviar">Entrar</button>
    </form>
</body>
</html>