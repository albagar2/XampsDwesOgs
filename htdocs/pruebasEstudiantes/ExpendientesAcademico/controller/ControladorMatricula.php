<?php
require_once "Conexion.php";
include "../model/Matricula.php";

class ControladorMatricula {
    public static function buscarPorEstudiante($dni) {
        $conex = new Conexion();
        $res = $conex->prepare("SELECT * FROM matricula WHERE dni_estudiante = ?");
        $res->bindValue(1, $dni);
        $res->execute();
        return $res->fetchAll();
    }

    public static function registrarTodo($estudiante, $matricula, $actividades, $foto) {
        $conex = new Conexion();
        try {
            $conex->beginTransaction();

            // 1. Actualizar o Insertar Estudiante
            $resEst = $conex->prepare("REPLACE INTO estudiante (dni, nombrecompleto, direccion, telf) VALUES (?,?,?,?)");
            $resEst->execute([$estudiante->dni, $estudiante->nombrecompleto, $estudiante->direccion, $estudiante->telf]);

            // 2. Gestión de Foto
            $nombreFoto = $matricula->foto_estudiante;
            if ($foto['size'] > 0) {
                $nombreFoto = time() . "_" . $matricula->id_matricula . ".jpg";
                move_uploaded_file($foto['tmp_name'], "../img_alumnos/" . $nombreFoto);
            }

            // 3. Insertar/Actualizar Matrícula
            $resMat = $conex->prepare("REPLACE INTO matricula VALUES (?,?,?,?,?,?)");
            $resMat->execute([$matricula->id_matricula, $matricula->asignatura, $matricula->nivel, $matricula->horas_semanales, $nombreFoto, $estudiante->dni]);

            // 4. Insertar Evaluaciones
            $resEv = $conex->prepare("INSERT INTO evaluacion (id_matricula, cod_profesor, id_actividad, fecha, estado, nota) VALUES (?,?,?,?,?,?)");
            foreach ($actividades as $id_act) {
                $resEv->execute([$matricula->id_matricula, $_POST['cod_profesor'], $id_act, date("Y-m-d"), 'Pendiente', 0]);
            }

            $conex->commit();
            return true;
        } catch (Exception $e) {
            $conex->rollBack();
            return $e->getMessage();
        }
    }
}