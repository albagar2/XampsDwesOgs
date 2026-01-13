<?php

    try {
        // CADA VEZ Q SE HAGA UNA CONSULTA Y SE DEVUELVA VALORES SE RECUPERARRAN COMO OBJETOS Y 
        // EL CASE LOWER NOS DARA TODO EN MINUSCULA PARA NO TENER NINGUN PROBLEMA A LA HORA DE BUSCAR COMO ESTABA EN LA BBDD
        $opciones=array(PDO:: ATTR_DEFAULT_FETCH_MODE=> PDO::FETCH_OBJ, PDO::ATTR_CASE=> PDO::CASE_LOWER);
        // primero creamos una conexion que contiene el driver, el dominio del servidor el nombre de la base de datos y los 
        // siguientes parametros seria el nombre del usuario y la contraseña
        $conex= new PDO('mysql:host = localhost; dbname=dwes; charset=utf8mb4', 'dwes', 'abc123.', $opciones);
        
        
        $conex->beginTransaction();
        
        $reg1 = $conex->exec("update stock set unidades=500 where producto='3DSNG'");
        $reg2 = $conex->exec("update stock set unidades=500 where producto='ARCLPMP32GBN'");
        
        if ($reg1 === 0){
            echo 'No se ha actualizado el producto 1 <br>';
        }
        if ($reg2 === 0){
            echo 'No se ha actualizado el producto 2 <br>';
        }
        $conex->commit();
        
        $conex->exec("update stock set unidades=500 where producto='ACERAX3950'");
        
    } catch (PDOException $ex) {
        $conex->rollBack();
        echo $ex->getMessage().'<br>';
        print_r($ex->errorInfo);
    }
    
    echo '<br><br>CONSULTA<br><br>';
    
    try {
        $result=$conex->query("select * from producto");
        echo "Numero de registros devueltos: ".$result->rowCount()."<br>";
        while ($fila=$result->fetch(PDO::FETCH_OBJ)){
            var_dump($fila);
            echo '<br>=========================================================================='
            . '=========================================================<br>';
        }
    } catch (Exception $ex) {
         echo $ex->getMessage().'<br>';
    }
    
    
    
       
    echo '<br><br>CONSULTAS PREPARADAS<br><br>'; 
    
    try {
        
        $menor=100;
        $mayor=200;
        
        $result=$conex->prepare("SELECT * from producto where PVP>? and PVP<?");
        
        //bucle de 0 a 100 para que vaya modificando los parametros que vamos a pasar
        for($i=0;$i<1000;$i+=100){
            // para ir modificando usamos el bind_param
            $result->bindParam(1, $menor);
            $result->bindParam(2, $mayor);
            
            $result->execute();
            
            $menor+=$i;
            $mayor+=$i;
            
            
            //lo mostramos
            echo 'Productos con precio entre '.$menor.' y '.$mayor.'<br>';
            while ($fila=$result->fetch()){
                echo 'Nombre: '.$fila->nombre_corto.'<br>';
            }
            
            echo '<br>==========================<br>';
        }
        
    } catch (PDOException $ex) {
         echo $ex->getMessage().'<br>';
    }
    
    
    
    echo '<br><br>CONSULTAS PREPARADAS CON OTRA FORMA DE PASAR LOS PARAMETROS<br><br>'; 
    
    try {
        
        $menor=100;
        $mayor=200;
        
        $result=$conex->prepare("SELECT * from producto where PVP>:pvp1 and PVP<:pvp2");
        
        //bucle de 0 a 100 para que vaya modificando los parametros que vamos a pasar
        for($i=0;$i<1000;$i+=100){
            // para ir modificando usamos el bind_param
            $result->bindParam(":pvp1", $menor);
            $result->bindParam(":pvp2", $mayor);
            
            $result->execute();
            
            $menor+=$i;
            $mayor+=$i;
            
            
            //lo mostramos
            echo 'Productos con precio entre '.$menor.' y '.$mayor.'<br>';
            while ($fila=$result->fetch()){
                echo 'Nombre: '.$fila->nombre_corto.'<br>';
            }
            
            echo '<br>==========================<br>';
        }
        
    } catch (PDOException $ex) {
         echo $ex->getMessage().'<br>';
    }
    
    echo '<br><br>CONSULTAS PREPARADAS CON OTRA FORMA DE PASAR LOS PARAMETROS PONIENDOLOS EN EL EXECUTE<br><br>'; 
    
    try {
        
        $menor=100;
        $mayor=200;
        
        $result=$conex->prepare("SELECT * from producto where PVP>:pvp1 and PVP<:pvp2");
        
        //bucle de 0 a 100 para que vaya modificando los parametros que vamos a pasar
        for($i=0;$i<1000;$i+=100){
            // para ir modificando usamos el bind_param
            $result->execute(array(":pvp2" => $menor, ":pvp1" => $mayor));
            
            $menor+=$i;
            $mayor+=$i;
            
            
            //lo mostramos
            echo 'Productos con precio entre '.$menor.' y '.$mayor.'<br>';
            while ($fila=$result->fetch()){
                echo 'Nombre: '.$fila->nombre_corto.'<br>';
            }
            
            echo '<br>==========================<br>';
        }
        
    } catch (PDOException $ex) {
         echo $ex->getMessage().'<br>';
    }
?>


