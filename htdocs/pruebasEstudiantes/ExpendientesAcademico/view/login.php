<!DOCTYPE html>
<html>
<body>
    <?php 
    include_once "../controller/ControladorProfesor.php";
    if (isset($_POST['enviar'])) echo ControladorProfesor::login();
    ?>
    <form method="POST">
        Código: <input type="text" name="usuario"><br>
        Clave: <input type="password" name="clave"><br>
        <button name="enviar">Entrar</button>
    </form>
</body>
</html>