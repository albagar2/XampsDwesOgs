<form action="" method="post">
    DNI: <input type="text" name="dni"><br>
    Nombre: <input type="text" name="nombre"><br>
    Apellidos: <input type="text" name="apell"><br>
    Salario: <input type="text" name="sal"><br>
    
    Idiomas: <br>
    <input type="checkbox" name="idiomas[]" value="1">Español<br>
    <input type="checkbox" name="idiomas[]" value="2">Inglés<br>
    <input type="checkbox" name="idiomas[]" value="4">Aleman<br>
    <input type="checkbox" name="idiomas[]" value="8">Chino<br>
    
    
    <select multiple="" name="estudios[]">
        <option value="ESO">ESO</option>
        <option value="Bachillerato">Bachillerato</option>
        <option value="CFGM">Ciclo Formativo de Grado Medio</option>
        <option value="CFGS">Ciclo Formativo de Grado Superior</option>
    </select><br>


    Usuario: <input type="text" name="usu"><br>
    Clave: <input type="text" name="pass"><br>
    
    <input type="submit" name="insertar" value="Insertar">
    <input type="submit" name="recuperar" value="Recuperar">
</form>

<?php
    if (isset($_POST['insertar'])){
        
        try {
            
            $conex = new mysqli('localhost', 'dwes', 'abc123.', 'empleados');
            
            $conex->set_charset("utf8mb4");
            
            $idio=0;
            
            foreach ($_POST['idiomas'] as $value){
                $idio+=$value;
            }
            
            $estud = implode(',', $_POST['estudios']);
            
            $conex->query("INSERT INTO datos VALUES('$_POST[dni]','$_POST[nombre]','$_POST[apell]',$_POST[sal],"
                    . "$idio, '$estud','$_POST[usu]','$_POST[pass]')");
            
            
        } catch (mysqli_sql_exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    if (isset($_POST['recuperar'])){
        try {
            $conex = new mysqli('localhost', 'dwes', 'abc123.', 'empleados');
            $conex->set_charset("utf8mb4");
            
            $result=$conex->query("SELECT * FROM datos");
            
            if ($result->num_rows){
                while($fila=$result->fetch_object()){
                    echo "DNI: ".$fila->dni."<br>";
                    echo "Nombre: ".$fila->nombre."<br>";
                    echo "Apellidos: ".$fila->apellidos."<br>";
                    echo "Salario: ".$fila->salario."<br>";
                    echo "Idiomas: ".$fila->idiomas."<br>";
                    echo "Estudios: ".$fila->estudios."<br>";
                    echo "========================================<br>";
                }
            } else {
                echo 'No hay registros';
            }
            
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }
?>

