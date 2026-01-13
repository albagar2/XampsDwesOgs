<?php
require_once "Conexion.php";
include "../model/Coche.php";
class ControladorCoche
{
    public static function Buscar($dni)
    {
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
                if (count($allCoches) == 0) {
                    $msg = "No se encuentra el cliente en la BD";
                    return $msg;
                }
            } else {
                $msg = "No se encuentra el cliente en la BD";
                return $msg;
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public static function crearCoche($matricula, $marca, $modelo, $km, $foto, $dni_cliente)
    {

        $ruta = "";
        if (isset($foto)) {
            $extension = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
            if ($extension !== 'jpg') {
                return "La imagen debe ser JPG";
            }
            
            $nombreFoto = $foto['name'];
            $ruta = time() . "_" . $matricula . ".jpg";
            $rutaDestino = "../coches/" . $ruta;


            if (!move_uploaded_file($foto['tmp_name'], $rutaDestino)) {
                return "Error al subir la foto";
            }
        } else {
            return "Error: No se ha seleccionado ninguna foto";
        }

        $c1 = new Coche($matricula, $marca, $modelo, $km, $ruta, $dni_cliente);
        $valores = $c1->toArray();

        try {
            $conex = new Conexion("taller_mecanico");
            $result = $conex->prepare("INSERT INTO coche VALUES(?,?,?,?,?,?)");
            $i = 1;
            foreach ($valores as $valor) {
                $result->bindValue($i, $valor);
                $i++;
            }
            if ($result->execute()) {
                $msg = "Coche creado correctamente";
                return $msg;
            } else {
                $msg = "Error al crear el coche";
                return $msg;
            }
        } catch (PDOException $ex) {
            return "Error: " . $ex->getMessage();
        }
    }

    public static function actualizarCoche($matricula, $marca, $modelo, $km, $foto, $dni_cliente)
    {
        $ruta = null;
        if (isset($foto) && $foto['error'] == 0) {
            $extension = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
            if ($extension !== 'jpg') {
                return "La imagen debe ser JPG";
            }
            $ruta = time() . "_" . $matricula . ".jpg";
            $rutaDestino = "../coches/" . $ruta;
            if (!move_uploaded_file($foto['tmp_name'], $rutaDestino)) {
                return "Error al subir la foto";
            }
        }

        try {
            $conex = new Conexion("taller_mecanico");
            if ($ruta !== null) {
                $result = $conex->prepare("UPDATE coche SET marca=?, modelo=?, km=?, foto=?, dni_cliente=? WHERE matricula=?");
                $result->bindValue(1, $marca);
                $result->bindValue(2, $modelo);
                $result->bindValue(3, $km);
                $result->bindValue(4, $ruta);
                $result->bindValue(5, $dni_cliente);
                $result->bindValue(6, $matricula);
            } else {
                $result = $conex->prepare("UPDATE coche SET marca=?, modelo=?, km=?, dni_cliente=? WHERE matricula=?");
                $result->bindValue(1, $marca);
                $result->bindValue(2, $modelo);
                $result->bindValue(3, $km);
                $result->bindValue(4, $dni_cliente);
                $result->bindValue(5, $matricula);
            }
            if ($result->execute()) {
                return "Coche actualizado correctamente";
            } else {
                return "Error al actualizar el coche";
            }
        } catch (PDOException $ex) {
            return "Error: " . $ex->getMessage();
        }
    }

    public static function obtenerCoche($matricula)
    {
        try {
            $conex = new Conexion("taller_mecanico");
            $result = $conex->prepare("SELECT * FROM coche WHERE matricula = ?");
            $result->bindValue(1, $matricula);
            if ($result->execute()) {
                return $result->fetch();
            }
            return null;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return null;
        }
    }

    
}
