<?php
    //conexion y consulta preparada
    try {
        $conex = new mysqli('localhost' , 'dwes' , 'abc123.' , 'dwes');
        //$stmt=$conex->stmt_init();
        //$stmt->prepare($query);
        $stmt=$conex->prepare("INSERT INTO tienda(nombre,tlf) VALUES(?,?)");
    } catch (Exception $exc) {
        die($exc->getMessage());
    }
    
    //introduccion de datos, hay que hacerlo mediante variables
//    $tiendas=array('Sucursal5'=>'555 55 55 55','Sucursal6'=>'555 55 55 55','Sucursal7'=>'555 55 55 55');
//    $cod=4;
//    $nombre="Sucursal4";
//    $tlf="444 44 44 44";
//        $nombre="";
//        $telf="";
//        $stmt->bind_param('ss',$nombre,$tlf);
//    foreach ($tiendas as $key => $value){
//        $nombre=$key;
//        $tlf=$value;
//        $stmt->execute();
//    }      
//    $stmt->bind_param('iss', $cod,$nombre,$tlf);
    
    //otra forma de pasar las variables es en el execute poniendolo de la siguiente forma
    //$stmt->execute([$nombre,$telf]);
    
    
    //ahora lo vamos a ejecutar
//    if($stmt->execute()){
//        echo 'Tienda insertada <br>';
//    }
    
    // cerramos la consulta
    $stmt->close();
    
    // preparamos una consulta que nos va a mostrar datos
    $stmt=$conex->prepare("SELECT * FROM tienda WHERE cod>?");
    $cod =3;
    $codigo=2;
    $nombre="";
    $telf="";
    
    $stmt->bind_param('i', $cod);
    
    // ejecutamos (pero como muestra verdadero y falso no sabemos los datos
    // aunque si se guardaan) y mostramos
    $stmt->execute();    
    
    //vamos a guardar los datos en las variables creadas para poder mostrarlo
    $stmt->bind_result($codigo,$nombre,$telf);
    
    //para usar num_rows aqui debemos hacer primero esto sino num_row dara 0
    $stmt->store_result();
    //para comprobarlo
    echo $stmt->num_rows();
    
    //si devuelbe filas
    if ($stmt->num_rows()){
        //mientras haya un siguiente
        while ($stmt->fetch()){
            echo 'Codigo: '.$cod.'<br>';
            echo 'Nombre: '.$nombre.'<br>';
            echo 'Telefono: '.$telf.'<br>';
            echo '====================================';
        }
    }
    
    //otra opcion para mostrar
    
    $stmt->execute();
    
    //get result devuelve un objeto
    $result=$stmt->get_result();
    
    //recorremos el resultado
    while ($fila=$result->fetch_object()){
        echo 'Codigo: '.$fila->cod.'<br>';
            echo 'Nombre: '.$fila->nombre.'<br>';
            echo 'Telefono: '.$fila->telf.'<br>';
            echo '====================================';
    }

