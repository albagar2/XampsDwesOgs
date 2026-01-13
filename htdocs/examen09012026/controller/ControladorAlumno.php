<?php
require_once "Conexion.php";

class ControladorAlumno {
    public static function listarPorCurso($id_curso) {
        $conex = new Conexion();
        $res = $conex->query("SELECT * FROM alumnos WHERE id_curso = $id_curso");
        $alumnos = [];
        while ($fila = $res->fetch_object()) {
            $alumnos[] = $fila;
        }
        return $alumnos;
    }

    public static function obtenerAlumno($dni_a) {
        $conex = new Conexion();
        $res = $conex->query("SELECT * FROM alumnos WHERE dni_a = '$dni_a'");
        return $res->fetch_object();
    }
    public static function obtenerPartesAlumno($dni_a) {
        $conex = new Conexion();
        $res = $conex->query("SELECT * FROM partes WHERE dni_a = '$dni_a'");
        $partes = [];
        while ($fila = $res->fetch_object()) {
            $partes[] = $fila;
        }
        return $partes;
    }
}
?>