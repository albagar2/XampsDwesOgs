<?php
    
    session_name('admin');
    session_start();
    if (isset($_SESSION['nombre']) ){
        echo $_SESSION['nombre'];
    }
    $_SESSION['nombre'] = "Pepe";
?>

<br><a href="datos.php">Ir a datos</a>