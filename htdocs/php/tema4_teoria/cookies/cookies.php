<?php
    //usamos el setcookie
    setcookie("nombre","Pepe", time()+60);
    echo 'hola';
    
    
    ?>


    <!--para usarla hay que hacer una peticion al servidor-->
    <a href="datos.php">Ir a datos</a>
    
    
    
    <?php
    // Duración de la cookie: 1 año
    $duracion = 365 * 24 * 60 * 60; // segundos
    // Nombre de la cookie
    $cookieNombre = "ultimo_acceso";

    // Fecha actual
    $ahora = date("d/m/Y H:i:s");

    // Verificamos si existe la cookie
    if (isset($_COOKIE[$cookieNombre])) {
        // Usuario que ya ha entrado antes
        echo "¡Bienvenido de nuevo! Tu última visita fue el: " . $_COOKIE[$cookieNombre];
    } else {
        // Primera vez que entra
        echo "¡Bienvenido! Esta es tu primera visita.";
    }

//    Guardamos la fecha actual en la cookie (se actualizará en la próxima visita)
//    Definimos lo que se guarda en la cookie
//     
//    La cookie almacena un texto legible directamente
    setcookie($cookieNombre, $ahora, time() + $duracion);
?>
     esto sobre la cookie nos ha dicho que probemos con un ejemplo durante un año y que cada vex 
     que el usuario se conecte le muestre un mensaje con la ultima conexion
        