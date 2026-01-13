<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <p>Inicia sesión para continuar</p>
        </div>

        <?php
        session_start();
        if(isset($_SESSION['nombrecompleto'])) header("Location: index.php");
        include_once '../controller/ControladorEmpleado.php';
        if (isset($_POST['enviar'])){
           echo ControladorEmpleado::loginEmpleado();

        }
        ?>
        <form action="" method="POST">
            <input type="hidden" name="action" value="login">
            
            <div class="form-group">
                <label for="usuario">Codigo</label>
                <input 
                    type="text" 
                    id="usuario" 
                    name="usuario" 
                    placeholder="Ingresa tu codigo"
                    required
                    autocomplete="username"
                >
            </div>

            <div class="form-group password-toggle">
                <label for="password">Contraseña</label>
                <input 
                    type="password" 
                    id="clave" 
                    name="clave" 
                    placeholder="Ingresa tu contraseña"
                    required
                    autocomplete="current-password"
                >
            </div>

            <button type="submit" class="btn-login" name="enviar">Iniciar Sesión</button>

        </form>
    </div>


</body>
</html>
