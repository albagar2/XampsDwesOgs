<?php
require_once "Conexion.php";
include "../model/Estudiante.php";

class ControladorEstudiante {
    public static function buscarPorDni($dni) {
        try {
            $conex = new Conexion("gestion_academica");
            $res = $conex->prepare("SELECT * FROM estudiante WHERE dni = ?");
            $res->bindValue(1, $dni);
            $res->execute();
            $datos = $res->fetch();
            if ($datos) {
                $_SESSION['estudiante_encontrado'] = serialize($datos);
                return true;
            }
            return false;
        } catch (PDOException $ex) { return false; }
    }

    public static function actualizarEstudiante($dni, $nombre, $dir, $tel) {
        try {
            $conex = new Conexion("gestion_academica");
            $res = $conex->prepare("UPDATE estudiante SET nombre_completo=?, direccion=?, telefono=? WHERE dni=?");
            $res->bindValue(1, $nombre);
            $res->bindValue(2, $dir);
            $res->bindValue(3, $tel);
            $res->bindValue(4, $dni);
            return $res->execute();
        } catch (PDOException $ex) { return false; }
    }
}