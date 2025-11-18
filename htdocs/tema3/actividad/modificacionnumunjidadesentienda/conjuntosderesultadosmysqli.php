<!DOCTYPE html>
<!--A partir de la página web obtenida en el ejercicio anterior, añade la opción de modificar el
número de unidades del producto en cada una de las tiendas. Utiliza una consulta preparada
para la actualización de registros en la tabla stock. No es necesario tener en cuenta las tareas
de inserción (no existían unidades anteriormente) y borrado (si el número final de unidades
es cero).
En esta ocasión es necesario crear un nuevo formulario en la página, en la sección donde
se muestra el número de unidades por tienda. Cuando se envía ese formulario, hay que
preparar la consulta y ejecutarla una vez por cada registro de la tabla stock (una vez por
cada tienda en la que exista stock de ese producto). -->

<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio: Conjuntos de resultados en MySQLi</title>
         <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div id="encabezado">
            <h1>Ejercicio: Conjuntos de resultados en MySQLi</h1>
            <?php
            $error= false;
            $msg="";
                try {
                     // 1. Conexión a la base de datos
                    $conexion = new mysqli("localhost", "dwes", "abc123.", "dwes");
                    $conexion->set_charset("utf8mb4");
                } catch (mysqli_sql_exception $exc) {
                    $error = true;
                    $msg="Error de conexión con la base de datos";
                }
                if (!$error){
            ?>
            
             <!-- FORMULARIO DE SELECCIÓN DE PRODUCTO -->
            <form action="" method="post">
                <label for="producto">Producto:</label>
                <select id="producto" name="producto">
                    <option value="">-- Selecciona un producto --</option>
                    <?php
                        // 2. Consulta SQL
                        $sql = "SELECT * FROM producto";
                        $resultado = $conexion->query($sql);
                        
                        if ($resultado->num_rows == 0){
                            echo "<option>No se han podido obtener los productos</option>";
                        }else{
                            while ($datos = $resultado->fetch_object()){
                                echo "<option ";
                                if (isset($_POST['mostrar']) && $_POST['producto'] == $datos->cod)
                                    echo "selected";
                                    echo " value='$datos->cod'>$datos->nombre_corto</option>";
                            }
                        }
                    ?>
            </select>

                <button type="submit" name="mostrar" value="mostrar">Mostrar stock</button>
            </form>
        </div>
        
        <div id="contenido">
            <?php
                if (isset($_POST['mostrar']) && $_POST['producto'] != "") {
                    
                    echo "<h3>Stock del producto en las tiendas:</h3>";
                    
                $sql_stock = $conexion->query("SELECT tienda.nombre, stock.unidades
                                  FROM stock, tienda where stock.tienda = tienda.cod and
                                  stock.producto ='$_POST[producto]'
                                  ");
            
                 
                    if ($sql_stock->num_rows == 0){
                         echo "<p>No hay stock disponible para este producto.</p>";
                    }else{
            ?>
            
             <!-- FORMULARIO PARA ACTUALIZAR STOCK -->
            <form action="" method="post">
                <input type="hidden" name="producto" value="
                    <?php 
                        echo $_POST['producto']; 
                    ?>
                ">
            
            
            <?php
                    
                    // Mostramos las tiendas con sus unidades
                    while ($datos = $sql_stock->fetch_object()){
                        echo "<p>Tienda: ".$datos->nombre." : ";
                        echo "<input type='number' name='stock["
                                .$datos->nombre."]' value='".$datos->unidades."' min='0'>";
                        echo  ""." unidades </p><br>";
                    }
                    
            ?>
                <input type="submit" name="actualizar" value="Actualizar">
            </form>
            <?php
                    }  
                }
                if (isset($_POST['actualizar'])){
                        echo 'Ha pulsado el boton actualizar<br>';
                        $mostrar=$_POST['stock']; // ← Te mostrará los valores enviados
//                        print_r($mostrar);
                        
                    foreach ($mostrar as $key => $value) {
                        echo 'En la tienda '.$key.' hay '.$value;
                    }
                        echo 'El producto '.$mostrar->producto;
                        
                        // Consulta preparada para actualizar el stock
                        $stmt=$conexion->prepare("update stock set unidades=? where producto = ? and tienda = ?");
                        if ($stmt) {
                        foreach ($_POST['stock'] as $codTienda => $unidades) {
                            // Actualizamos solo si el producto ya existe, sin insertar ni borrar
                            $stmt->bind_param("isi", $unidades, $_POST['producto'], $codTienda);
                            $stmt->execute();
                        }
                        $stmt->close();
                        echo "<p>Stock actualizado correctamente.</p>";
                } else {
                    echo "<p>Error al preparar la consulta de actualización.</p>";
                }
                }
                $conexion->close();
                
            ?>
    </div>
        <?php
            
                }
        ?>
        
    <div id="pie">
        <?php
            echo $msg;
        ?>
        
    </div>
        
    </body>
</html>