<?php
require_once "Conexion.php";
include "../model/Tarea.php";
class ControladorTarea
{
    public static function obtenerTodas()
    {
        try {
            $conex = new Conexion("taller_mecanico");
            $result = $conex->prepare("SELECT * FROM tarea");
            if ($result->execute()) {
                $tareas = [];
                while ($data = $result->fetch()) {
                    $tareas[] = $data;
                }
                return $tareas;
            }
            return [];
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return [];
        }
    }
}
