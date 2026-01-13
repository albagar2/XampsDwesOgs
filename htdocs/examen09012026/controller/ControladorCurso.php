<?php 
    require_once "Conexion.php";

    class ControladorCurso {
        public static function obtenerCursosProfesor($dni_p) {
            $conex = new Conexion();
            $sql = "SELECT c.* FROM curso c 
                    INNER JOIN prof_curso pc ON c.id_curso = pc.id_curso 
                    WHERE pc.dni_p = '$dni_p'";
            $res = $conex->query($sql);
            $cursos = [];
            while ($fila = $res->fetch_object()) {
                $cursos[] = $fila;
            }
            return $cursos;
        }


        public static function obtenerInfoCurso($id_curso) {
        $conex = new Conexion();
        $res = $conex->query("SELECT * FROM curso WHERE id_curso = $id_curso");
        return $res->fetch_object();
        }

        public static function obtenerProfesorParte($id_parte) {
            $conex = new Conexion();
            $res = $conex->query("SELECT p. * FROM profesores p 
                                 INNER JOIN partes pa ON p.dni_p = pa.dni_p 
                                 WHERE pa.id = $id_parte");
            return $res->fetch_object();
        }
    }
?>

