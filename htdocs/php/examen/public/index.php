<!DOCTYPE html>

<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Taller Mecanico</title>
    </head>
    <body>
        
        <?php
        // redirige a login.php o menu si sesión iniciada pero por tiempo solo dirigue al login
         
            header("Location: controlador/LoginController.php");
            exit;

        ?>
    </body>
</html>
