<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Formulario</title>
    </head>
    <body>
        <h1>Rellene los datos del formulario</h1>
        
        <form action="" method="post">
            <label for="dni">DNI:</label>
            <input type="text" name="dni" value=""><br>
            
            <br><label for="nombre">Nombre:</label>
            <input type="text" name="nombre" value=""><br>
            
            <br><label for="apell">Apellidos:</label>
            <input type="text" name="apell" value=""><br>
            
            <br><label for="salario">Salario:</label>
            <input type="text" name="salario" value=""><br>
            
            
            <br>Idiomas: <br>
            <input type="checkbox" name="idiomas[]" value="Inglés">Inglés<br>
                <input type="checkbox" name="idiomas[]" value="Francés">Francés<br>
                <input type="checkbox" name="idiomas[]" value="Alemán">Alemán<br>
                <input type="checkbox" name="idiomas[]" value="Chino">Chino<br>
                <input type="checkbox" name="idiomas[]" value="Portugués">Portugués<br>

                
                <br><button type="submit" name="añadir">Añadir</button>
                <button type="submit" name="buscar">Buscar</button>
        </form>
        
        <?php
            
            
//            if (isset($_POST['buscar'])){
//                $dni = $_POST["dni"];
//                $nombre = $_POST["nombre"];
//                $apell = $_POST["apell"];
//                $salario = $_POST["salario"];
//                $idiomas = $_POST['idiomas'];
//                
//                
//                echo $dni." - ".$nombre." - ".$apell." - ".$salario." - Idiomas: ";
//                foreach ($_POST['idiomas'] as $value){
//                    echo $value.', ';
//                }
//            }
            
            
            if (isset($_POST['buscar']) || isset($_POST['añadir'])){
                $dni = $_POST["dni"];
                $nombre = $_POST["nombre"];
                $apell = $_POST["apell"];
                $salario = $_POST["salario"];
                $idiomas = $_POST['idiomas'];
                
                
                try {
                    $conexion = new mysqli("localhost", "dwes", "abc123.", "empleados");
                    
                    if (isset($_POST['añadir'])){
                        
                        $conexion->autocommit(false);
                        
                        
                        $stmtID =$conexion->prepare("INSERT INTO datos(DNI, Nombre, Apellidos, Salario) VALUES (?,?,?,?)");
                        $stmtID->bind_param('sssi', $dni, $nombre, $apell, $salario);
                        $stmtID->execute();
                        
                        
                        
                        
                        $stmtII =$conexion->prepare("INSERT INTO idiomas (DNI, idioma) VALUES (?, ?)");
                        
                        foreach ($_POST['idiomas'] as $value){
                             $stmtII->bind_param('ss', $dni, $value);
                             $stmtII->execute();
                        }
                       
                        $conexion->commit();
                        $conexion->autocommit(true);
                        
                        
                    } if (isset($_POST['buscar'])) {
                       $idiomaSeleccionado = $_POST['idiomas'];
                        $stmtS = $conexion->prepare("SELECT d.nombre, d.apellidos, i.idioma FROM datos d INNER JOIN idiomas i ON d.dni=i.dni WHERE i.idioma = ?");
                        $stmtS->bind_param('s', $idioma);
                        $stmtS->execute();
                        
                        $stmtS->bind_result($nom, $apel, $idioma);
                        $stmtS->store_result();
                        
                        
                        if ($stmtS->num_rows){
                            while ($stmtS->fetch()){
                                foreach ($stmtS as $value){
                                echo 'Nombre: '.$stmtS.' , '.$apel.' esta en '.$idioma;
                                }
                            }
                        }
                    }
                } catch (Exception $exc) {
                    echo $exc->getMessage().'<br>';
                    echo $exc->getLine();
                    echo '<br>Error de conexion';
                    $conexion->rollback();
                }
       
            }
        ?>
    </body>
</html>
