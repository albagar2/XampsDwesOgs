<form action="" method="post">
    usuario: <input type="text" name="usu"><br>
    password: <input type="text" name="pass"><br>
    
    <input type="submit" name="entrar" value="Entrar">
    
</form>
<?php
    if (isset($_POST['entrar'])){
//        try {
//            $conex= new mysqli('localhost', 'dwes', 'abc123.', 'empleados');
//            // binary para que distinga entre mayuscula y minuscula
//            // un usuario sin contraseña seria en el passwor ponner esto: usuario' OR '1'='1
//            $result=$conex->query("SELECT * FROM datos WHERE usuario=BINARY '$_POST[usu]' "
//                    . "AND password=BINARY '$_POST[pass]'");
//        } catch (Exception $ex) {
//            echo $ex->getMessage();
//        }
//        if ($result->num_rows){
//            echo 'Has entrado';
//        } else {
//            echo 'CREDENCIALES INCORRECTAS';
//        }
        
        // con consulta preparada y evitamos que entre por inyeccion sql es decir que no pueda poner lo del OR
        try {
            $conex= new mysqli('localhost', 'dwes', 'abc123.', 'empleados');
            $stmt=$conex->prepare("SELECT * FROM datos WHERE usuario=BINARY ? "
                    . "AND password=BINARY ?");
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        $stmt->bind_param('ss', $_POST['usu'], $_POST['pass']);
        $stmt->execute();
        
        $result=$stmt->get_result();
        if ($result->num_rows){
            echo 'Has entrado';
        } else {
            echo 'CREDENCIALES INCORRECTAS';
        }
        
    }
    
?>

