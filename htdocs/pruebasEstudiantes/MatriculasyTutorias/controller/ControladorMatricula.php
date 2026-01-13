<?php
require_once "Conexion.php";
include "../model/Matricula.php";

class ControladorMatricula {
    public static function registrarMasivo($dni, $prof, $asignaturas, $foto) {
        if (strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION)) !== 'png') {
            return "La foto debe ser .png";
        }
        $rutaFoto = time() . "_" . $dni . ".png";
        move_uploaded_file($foto['tmp_name'], "../fotos/" . $rutaFoto);

        try {
            $conex = new Conexion("gestion_academica");
            foreach ($asignaturas as $id_asig) {
                $m = new Matricula($dni, $prof, $id_asig);
                $v = $m->toArray(); // Usamos el método del modelo
                $res = $conex->prepare("INSERT INTO matricula_gestion (dni_estudiante, cod_profesor, id_asignatura, fecha, estado, horas_tutoria) VALUES (?,?,?,?,?,?)");
                $i = 1;
                foreach ($v as $val) { $res->bindValue($i++, $val); }
                $res->execute();
            }
            return "Matrícula realizada correctamente";
        } catch (PDOException $ex) { return $ex->getMessage(); }
    }

    public static function obtenerExpediente($dni) {
        try {
            $conex = new Conexion("gestion_academica");
            $res = $conex->prepare("SELECT m.*, a.nombre_asignatura, a.precio_credito FROM matricula_gestion m INNER JOIN asignatura a ON m.id_asignatura = a.id WHERE m.dni_estudiante = ?");
            $res->bindValue(1, $dni);
            $res->execute();
            return $res->fetchAll();
        } catch (PDOException $ex) { return []; }
    }

    public static function pagarMatrícula($dni) {
        try {
            $conex = new Conexion("gestion_academica");
            $res = $conex->prepare("UPDATE matricula_gestion SET estado='Pagada' WHERE dni_estudiante=? AND estado='Aceptada'");
            $res->bindValue(1, $dni);
            return $res->execute();
        } catch (PDOException $ex) { return false; }
    }
}