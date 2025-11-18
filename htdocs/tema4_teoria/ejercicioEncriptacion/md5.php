<link rel="stylesheet" href="estilo.css">

<?php
    include './funciones.php';
    $conex = conectarBBDD();
    
    // echo 'Entre a la conexion de bbdd <p>';
    if (isset($_POST["entrar"])){
        $password = md5($_POST["pass"]);
        
        $sql = $conex->prepare("Select * from usuario where Email = ?");
        $sql->bindParam(1, $_POST["email"]);
        $sql->execute();
        
        $resultCon = $sql;
       // echo "Este es el resultado de la consulta";
        // comprobamos si no existe el usuario
        if ($sql->rowCount() == 0){
            $error_mail = "El usuario introducido no existe en al BD <br>";
        } else {
            $datos=$sql->fetch(PDO::FETCH_OBJ);
            
            // COMROBAMOS QUE LA CONTRASEÑA SEA CORRECTA
            if ($datos->pass == $pass){
                // CREAMOS COOKIE
                setcookie("DNI", $datos->DNI);
                setcookie("Nombre",$datos->Nombre);
                setcookie("Apellidos",$datos->Apellidos);
                
                header("Location:index.php");
                exit();
            }else{
                $error_pass ="La contraseña es incorrecta <br>";
            }
        }
             
    }
?>
<div class="login-container">
    
    <h2>Iniciar sesion</h2>
    
    <form action="" method="POST">
    
        Email: <input type="text" name="email"><br>
        <?php 
            if (isset($error_mail)){
                echo "<span style='color:red'>$error_mail</span>";
            }
        ?>
        Contraseña: <input type="password" name="pass"><br>
         <?php 
            if (isset($error_pass)){
                echo "<span style='color:red'>$error_pass</span>";
            }
        ?>
        <input type="submit" name="entrar" value="Entrar"><br>
    
    </form>
    
</div>
