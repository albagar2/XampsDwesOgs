<link rel="stylesheet" href="estilo.css">

<?php
    include './funciones.php';
    $conex = conectarBBDD();

?>



<div class="login-container">
    
    <h2>Registrarme</h2>
    
    <form action="" method="post">

        DNI: <input type="text" name="dni"><br>
        Nombre: <input type="text" name="nombre"><br>
        Apellido: <input type="text" name="apell"><br>
        Email: <input type="text" name="email"><br>
        Contraseña: <input type="password" name="pass"><br>
        
        
        <br><input type="submit" name="logear" value="Login">
        <input type="submit" name="registrar" value="Registrarme"><br>

    </form>
</div>