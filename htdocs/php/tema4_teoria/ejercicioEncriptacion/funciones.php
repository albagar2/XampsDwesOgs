<?php
    function conectarBBDD(){
        try {
            $conex= new PDO('mysql:host = localhost; dbname=usuarios; charset=utf8mb4', 'dwes', 'abc123.');
            $conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           // echo 'Conexion<br>';
            return $conex;
        } catch (PDOException $ex) {
           echo '<p>'.$ex->getMessage().'<br>';
        }

    }
?>