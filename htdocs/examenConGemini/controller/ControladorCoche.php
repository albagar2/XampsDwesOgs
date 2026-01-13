<?php
require_once "Conexion.php";
include "../model/Coche.php";
class ControladorCoche {
    public static function Buscar($dni) {
        try {
            $conex = new Conexion("taller_mecanico");
            $result = $conex->prepare("SELECT * FROM coche WHERE dni_cliente = ?");
            $result->bindValue(1, $dni);
            if ($result->execute()) {
                $allCoches = [];
                while ($data = $result->fetch()) {
                    $allCoches[] = $data;
                }
                $_SESSION['coches'] = serialize($allCoches);
                if (count($allCoches) == 0) return "No se encuentran coches para este cliente";
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public static function crearCoche($matricula, $marca, $modelo, $km, $foto, $dni_cliente) {
        $ruta = time() . "_" . $matricula . ".jpg";
        if (!move_uploaded_file($foto['tmp_name'], "../coches/" . $ruta)) return "Error al subir foto";

        $c1 = new Coche($matricula, $marca, $modelo, $km, $ruta, $dni_cliente);
        $valores = $c1->toArray();
        try {
            $conex = new Conexion("taller_mecanico");
            $result = $conex->prepare("INSERT INTO coche VALUES(?,?,?,?,?,?)");
            $i = 1;
            foreach ($valores as $valor) {
                $result->bindValue($i++, $valor);
            }
            return $result->execute() ? "Coche creado" : "Error al crear";
        } catch (PDOException $ex) { return $ex->getMessage(); }
    }
}