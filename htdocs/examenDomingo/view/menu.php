<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>

<body>
    <?php
    if (!isset($_SESSION['nombre'])) {
        header("Location:login.php");
    } else {
        echo "Bienvenido ". $_SESSION['nombre'],"<a href='logout.php'><input type='button' value='Logout'></a><br>";
    } 
        if(isset($_COOKIE['tareasasginadas'])){
        echo $_COOKIE['tareasasginadas']. "<br>";
    }
    if($_SESSION['rol'] == "admin"){
        echo ' <a href="registrartrabajo.php">Registrar Trabajo</a>';
    }

    ?>
 <br>
 <a href="vertrabajo.php">Ver Trabajo</a>
</body>

</html>