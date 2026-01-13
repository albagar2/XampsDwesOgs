<?php
require_once "Conexion.php";

class ControladorTarea {
    public static function obtenerTodas() {
        try {
            $conex = new Conexion("taller_mecanico");
            $res = $conex->query("SELECT * FROM tarea");
            return $res->fetchAll();
        } catch (PDOException $ex) { return []; }
    }
}