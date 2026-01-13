<!DOCTYPE html>


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
                    }
                    while ($datos = $sql_stock->fetch_object()){
                        echo "<p>Tienda: ".$datos->nombre." : ".$datos->unidades." unidades <br>";
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