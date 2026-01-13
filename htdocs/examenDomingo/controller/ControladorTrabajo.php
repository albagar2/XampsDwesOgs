<?php
require_once "Conexion.php";
include "../model/Trabajo.php";
class ControladorTrabajo
{
    public static function crearTrabajo($matricula, $cod_mecanico, $id_tarea, $horas)
    {
        $t1 = new Trabajo($matricula, $cod_mecanico, $id_tarea, $horas);
        $valores = $t1->toArray();
        try {
            $conex = new Conexion("taller_mecanico");
            $result = $conex->prepare("INSERT INTO trabajo VALUES(?,?,?,?,?,?)");
            $i = 1;
            foreach ($valores as $valor) {
                $result->bindValue($i, $valor);
                $i++;
            }
            if ($result->execute()) {
                $msg = "Se ha registrado el trabajo";
                return $msg;
            } else {
                $msg = "Error al crear el trabajo";
                return $msg;
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public static function asignarTareas($matricula, $cod_mecanico, $tareas,$horas)
    {
        $errores = 0;
        $exitosos = 0;
        foreach ($tareas as $id_tarea) {
            $t1 = new Trabajo($matricula, $cod_mecanico, $id_tarea, $horas);
            $valores = $t1->toArray();
            try {
                $conex = new Conexion("taller_mecanico");
                $result = $conex->prepare("INSERT INTO trabajo VALUES(?,?,?,?,?,?)");
                $i = 1;
                foreach ($valores as $valor) {
                    $result->bindValue($i, $valor);
                    $i++;
                }
                if ($result->execute()) {
                    $exitosos++;
                } else {
                    $errores++;
                }
            } catch (PDOException $ex) {
                $errores++;
            }
        }
        if ($errores > 0) {
            return "Se registraron $exitosos tareas correctamente y $errores con error";
        } else {
            return "Se han registrado las tareas correctamente";
        }
    }

    public static function obtenerTrabajosMecanico($cod_mecanico)
    {
        try {
            $conex = new Conexion("taller_mecanico");
            $result = $conex->prepare("SELECT * FROM trabajo WHERE cod_mecanico = ?");
            $result->bindValue(1, $cod_mecanico);
            if ($result->execute()) {
                $trabajos = [];
                while ($data = $result->fetch()) {
                    $trabajos[] = $data;
                }
                return $trabajos;
            }
            return [];
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return [];
        }
    }

    public static function actualizarEstado($matricula, $cod_mecanico, $id_tarea, $estado)
    {
        try {
            $conex = new Conexion("taller_mecanico");
            $result = $conex->prepare("UPDATE trabajo SET estado=? WHERE matricula=? AND cod_mecanico=? AND id_tarea=?");
            $result->bindValue(1, $estado);
            $result->bindValue(2, $matricula);
            $result->bindValue(3, $cod_mecanico);
            $result->bindValue(4, $id_tarea);
            if ($result->execute()) {
                return "Estado actualizado correctamente";
            } else {
                return "Error al actualizar el estado";
            }
        } catch (PDOException $ex) {
            return "Error: " . $ex->getMessage();
        }
    }

    public static function buscarTrabajos($matricula = null, $fecha = null)
    {
        try {
            $conex = new Conexion("taller_mecanico");
            $query = "SELECT t.*, ta.descripcion, ta.precio FROM trabajo t 
                      INNER JOIN tarea ta ON t.id_tarea = ta.id 
                      WHERE 1=1";
            $params = [];
            
            if ($matricula !== null && $matricula !== '') {
                $query .= " AND t.matricula = ?";
                $params[] = $matricula;
            }
            
            if ($fecha !== null && $fecha !== '') {
                $query .= " AND DATE(t.fecha) = ?";
                $params[] = $fecha;
            }
            
            $result = $conex->prepare($query);
            
            for ($i = 0; $i < count($params); $i++) {
                $result->bindValue($i + 1, $params[$i]);
            }
            
            if ($result->execute()) {
                $trabajos = [];
                while ($data = $result->fetch()) {
                    $trabajos[] = $data;
                }
                return $trabajos;
            }
            return [];
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return [];
        }
    }
}
