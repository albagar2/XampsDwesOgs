<?php

// 1. session_name() debe llamarse ANTES de session_start()
    session_name('admin');
    session_start();
    echo $_SESSION['nombre'];

    // 2. Asignar el valor a $_SESSION['nombre']
    // Si la sesión es nueva, se asignará el valor. 
    // Si ya existe, se podría modificar.
    $_SESSION['nombre'] = "Antonio";


    // --- Cierre de Sesión y Eliminación de Cookies ---

    // 3. ELIMINAMOS la variable 'nombre' de la sesión.
    // session_unset() elimina todas las variables de la sesión, no solo 'nombre'.
    // Si solo quieres eliminar 'nombre', usa: unset($_SESSION['nombre']);
    //eliminamos las cookis del servidor
    session_unset();

    // 4. DESTRUIMOS la sesión en el servidor.
    session_destroy();


    // 6. ELIMINAMOS la cookie del cliente (que se llama 'admin', según session_name())
    // El nombre de la cookie es el nombre de la sesión, que estableciste como 'admin'.
    // La sintaxis de setcookie() debe ser: setcookie(nombre, valor, expiracion, ruta)
    // El valor se puede dejar como una cadena vacía o nula.
    // Para eliminarla, la expiración debe ser un tiempo en el pasado (time() - 1).
    $nombre_cookie = session_name(); // 'admin'
    setcookie($nombre_cookie, '', time() - 3600, '/');
    //eliminamos las cookies del cliente
   // setcookie('admin', $_COOKIE['name'], expires_or_options: time() - 1, '/');
?>
<br><a href="index.php">Volver</a>
<br><a href="registro.php">Registro</a>