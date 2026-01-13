<?php
require_once "Conexion.php";
include "../model/Trabajo.php";

class ControladorTrabajo {
    public static function asignarTareas($matricula, $mecanico, $tareas, $horas) {
        try {
            $conex = new Conexion("taller_mecanico");
            foreach ($tareas as $id_tarea) {
                $t = new Trabajo($matricula, $mecanico, $id_tarea, $horas);
                $v = $t->toArray();
                $res = $conex->prepare("INSERT INTO trabajo VALUES(?,?,?,?,?,?)");
                $i = 1;
                foreach ($v as $val) { $res->bindValue($i++, $val); }
                $res->execute();
            }
            return "Tareas asignadas correctamente";
        } catch (PDOException $ex) { return $ex->getMessage(); }
    }

    public static function obtenerPorMecanico($codigo) {
        try {
            $conex = new Conexion("taller_mecanico");
            $res = $conex->prepare("SELECT * FROM trabajo WHERE cod_mecanico = ?");
            $res->bindValue(1, $codigo);
            $res->execute();
            return $res->fetchAll();
        } catch (PDOException $ex) { return []; }
    }

    public static function actualizarEstado($mat, $mec, $tar, $est) {
        try {
            $conex = new Conexion("taller_mecanico");
            $res = $conex->prepare("UPDATE trabajo SET estado=? WHERE matricula=? AND cod_mecanico=? AND id_tarea=?");
            $res->bindValue(1, $est);
            $res->bindValue(2, $mat);
            $res->bindValue(3, $mec);
            $res->bindValue(4, $tar);
            return $res->execute() ? "Estado actualizado" : "Error";
        } catch (PDOException $ex) { return $ex->getMessage(); }
    }
}