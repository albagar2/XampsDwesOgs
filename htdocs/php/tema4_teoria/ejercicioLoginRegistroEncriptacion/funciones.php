<?php
    function conectarBBDD(){
        try {
            $conex= new PDO('mysql:host = localhost; dbname=usuarios; charset=utf8mb4', 'dwes', 'abc123.');
            return $conex;
        } catch (PDOException $ex) {
           echo $ex->getMessage().'<br>';
        }

    }
?>