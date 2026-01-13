
<h2>Producto</h2>
<form action="" method="post">
    Codigo: <input type="text" name="cod"><br>
    Nombre: <input type="text" name="nom"><br>
    Precio: <input type="text" name="pre"><br>


    <input type="submit" name="insertar" value="Insertar">
    <input type="submit" name="buscar" value="Buscar">
    <input type="submit" name="mostrar" value="Mostrar">
</form>



<?php
    require_once 'Producto.php';

    if (isset($_POST['insertar'])) {
        $p= new Producto($_POST['cod'], $_POST['nom'], $_POST['pre']);
        if($p->insertar()){
            echo "<br>Producto insertado correctamente<br>";
        }else{
            echo "<br>No se ha insertado el producto<br>";
        }
    }


     if (isset($_POST['buscar'])) {
        $p=Producto::buscar($_POST['cod']);
        if($p){
            echo $p;
        }else{
            echo 'No se encuentra ningun producto con este codigo';
        }
     }

    if (isset($_POST['mostrar'])) {
        $productos=Producto::mostrar();
        if($productos){
            foreach($productos as $p){
                //nombre de la clase no de la bbdd
                echo "Código: ".$p->codigo."<br>";
                echo "Nombre: ".$p->nombre."<br>";
                echo "Precio: ".$p->precio."<br>";
                echo "<br>=========<br>";
            }
        }else{
            echo "No hay productos";
        }
    }

?>
