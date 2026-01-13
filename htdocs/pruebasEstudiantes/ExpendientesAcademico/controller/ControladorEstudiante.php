<?php
require_once "Conexion.php";

class ControladorEstudiante {
    public static function obtenerPorDni($dni) {
        try {
            $conex = new Conexion();
            $res = $conex->prepare("SELECT * FROM estudiante WHERE dni = ?");
            $res->bindValue(1, $dni);
            $res->execute();
            return $res->fetch();
        } catch (PDOException $e) { return null; }
    }
}