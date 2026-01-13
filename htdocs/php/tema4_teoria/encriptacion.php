<?php

    echo '<br>============================== Encriptacion con MD5 ============================================<br>';
    // md5 --> Vulnerable a ataques de fuerza bruta y tablas rainbow.
    // password_bcrypt --> Incluye automáticamente un salt único → evita que dos contraseñas iguales tengan el mismo hash.
    // Usa siempre password_hash() con BCRYPT o ARGON2

    $pass = "Alba1234";
    $passmd5=md5($pass);
    
    echo '<br>'.$passmd5;
    
    
    $pass2 = "Alba1234";
    $passmd52=md5($pass2);
    
    echo '<br>'.$passmd52;
    
    echo '<br>'.'<br>';
    
    
    // md5 genera 32 caracteres si la contraseña es mayor te dara incorrecto, por no decir, que 
    // como siempre es la misma cadena es facil de acceder a ella siendo poco segura
    
    // para comprobar si la contraseña es correcta
    if ($passmd5 == md5("Alba1234")) {
        echo 'La contraseña es correcta';
    } else {
        echo 'La contraseña es incorrecta';
    }
    
    // password_bcrypt --> incluye automaticamente un salt unico -> envita que dos contraseñas iguales
    // tengan el mismo hash, minimo son 60 caracteres
    // usa siempre password_hash() con BCRYPT o ARGON2 (usa diferente codificacion)
    
    
    echo '<p><br>================================= Encriptacion con BCRYPT =========================================<br>';
    
    $passbcrypt = password_hash($pass2, PASSWORD_DEFAULT);
    
    echo '<br>'.$passbcrypt.'<br>';
    
    $passbcrypt2 = password_hash($pass2, PASSWORD_DEFAULT);
    echo '<br>'.$passbcrypt2.'<br>';
    
    
    // para verificar
    
    if (password_verify($pass2, $passbcrypt)){
        echo 'La contraseña es correcta';
    } else {
        echo 'La contraseña es incorrecta';
    }