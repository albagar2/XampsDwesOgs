<!DOCTYPE html>
<html>
<body>
    <h2>Acceso Profesores</h2>
    <?php
    include_once '../controller/ControladorProfesor.php';
    if (isset($_POST['entrar'])) echo ControladorProfesor::login();
    ?>
    <form method="POST">
        Código: <input type="text" name="usuario"><br>
        Clave: <input type="password" name="clave"><br>
        <button name="entrar">Entrar</button>
    </form>
</body>
</html>