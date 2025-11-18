<link rel="stylesheet" href="estilo.css">

<?php
    include './funciones.php';
    $conex = conectarBBDD();

?>


<div class="login-container">
    
    <h2>Iniciar Sesion</h2>
    
    <form action="" method="post">

        Email: <input type="text" name="email"><br>
        Contraseña: <input type="password" name="pass"><br>
        
        <br><input type="checkbox" name="recordar" value="recordar">Recuerdame<br>
        
        <br><input type="submit" name="acceder" value="Acceder">
        <input type="submit" name="registrar" value="Registrarme"><br>

    </form>
</div>