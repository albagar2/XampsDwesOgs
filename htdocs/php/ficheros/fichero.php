<?php 
    if (isset($_POST["enviar"])) {

        // <!-- para ver que tiene el file y el sleep para pararlo en el momento que le digamos -->
        var_dump($_FILES['foto']);
        // sleep(30);

        // para ver los datos de uno en uno
        echo "<br>Nombre original : ".$_FILES['foto']['name']."<br>";
        echo "<br>Nombre temporal : ".$_FILES['foto']['tmp_name']."<br>";
        echo "<br>Tamaño : ".$_FILES['foto']['size']."<br>";
        echo "<br>Tipo : ".$_FILES['foto']['type']."<br>";
        echo "<br>Error : ".$_FILES['foto']['error']."<br>";
        

        // se sube el fichero bien
        if (is_uploaded_file($_FILES['foto']['tmp_name'])){
            $fich=time()."-".$_FILES["foto"]["name"];
            $ruta="fotos/".$fich;
            move_uploaded_file($_FILES['foto']['tmp_name'], $ruta);


            try {
            $conex=new mysqli('localhost','dwes','abc123.','ficheros');
            $conex->query("INSERT INTO fotos (nombre,ruta) VALUES ('$_POST[nombre]','$ruta)");
            $conex->close();

            } catch (Exception $e) {
                unlink($ruta);
                echo''.$e->getMessage().'<br>';
            }

            echo "<br>Datos almacenados correctamente<br>";

        }// si nos da un error        
        else{
            echo "Error ".$_FILES['foto']['error']."<br>";
            if($_FILES['foto']['error'] == 1){
                echo "<br>El fichero supera el limite permitido";
            }
        }
    if(isset($_POST["mostrar"])){
        try {
            $conex=new mysqli('localhost','dwes','abc123.','ficheros');
            $conex->query("SELECT * FROM fotos");

            if($result->num_rows){
                while($reg=$result->fetch_object()){
                    echo "<a href=$reg->$ruta><img src=$reg->ruta width=50 height=50></a>";
                    echo "<br>Nombre: ".$reg->nombre."<br>";
                    echo "<br>========================================================================<br>";
                }
            }else{
                echo "<br>No hay fotos<br>";
                $conex->close();
            }
            

        } catch (Exception $e) {
            echo''.$e->getMessage().'<br>';
        }


    }

    }
?>


<!-- para que se suba se pone enctype="multipart/form-data" -->
<form action="" method="POST" enctype="multipart/form-data">
    Nombre: <input type="text" name="nombre"><br>
    Imagen: <input type="file" name="foto"><br>

    <input type="submit" name="enviar" value="Enviar">
    <input type="submit" name="mostrar" value="Mostrar">

</form>