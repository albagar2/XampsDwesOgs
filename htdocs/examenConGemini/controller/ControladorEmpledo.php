<?php
require_once "Conexion.php";
class ControladorEmpleado {
    public static function loginEmpleado() {
        try {
            $conex = new Conexion("taller_mecanico");
            $result = $conex->prepare("SELECT * FROM empleado WHERE codigo = ?");
            $result->bindValue(1, $_POST['usuario']);
            $result->execute();
            if ($data = $result->fetch()) {
                if (password_verify($_POST['clave'], $data->clave)){
                    session_start();
                    $_SESSION['nombre'] = $data->nombrecompleto;
                    $_SESSION['codigo'] = $data->codigo;
                    $_SESSION['rol'] = $data->rol;
                    header("Location: ../view/menu.php");
                } else {
                    return "Contraseña o usuario incorrecto";
                }
            } else {
                return "No se encuentra el usuario";
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public static function logout() {
        session_start();
        session_destroy();
        session_unset();
        setcookie("PHPSESSID", "", time() - 1);
        header("Location: ../view/login.php");
    }

    public static function obtenerTodos() {
        try {
            $conex = new Conexion("taller_mecanico");
            $result = $conex->prepare("SELECT * FROM empleado");
            if ($result->execute()) {
                $empleados = [];
                while ($data = $result->fetch()) {
                    $empleados[] = $data;
                }
                return $empleados;
            }
            return [];
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return [];
        }
    }
}