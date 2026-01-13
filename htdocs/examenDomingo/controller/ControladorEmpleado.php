<?php
require_once "Conexion.php";
include "../model/Empleado.php";
class ControladorEmpleado
{
    public static function crearCliente($DNI, $Nombre, $Apellidos, $Direccion, $Localidad, $Clave, $Tipo)
    {
        $c1 = new Cliente($DNI, $Nombre, $Apellidos, $Direccion, $Localidad, $Clave, $Tipo);
        $valores = $c1->toArray();
        try {
            $conex = new Conexion("alquiler_juegos");
            $result = $conex->prepare("INSERT INTO cliente VALUES(?,?,?,?,?,?,?)");
            $i = 1;
            foreach ($valores as $valor) {
                $result->bindValue($i, $valor);
                $i++;
            }
            if ($result->execute()) {
                session_start();
                $_SESSION['nombre'] = $Nombre;
                $_SESSION['DNI'] = $DNI;
                $_SESSION['tipo'] = $Tipo;
                $msg = "Usuario creado correctamente";
                return $msg;
            } else {
                $msg = "Error al crear el usuario";
                return $msg;
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    public static function loginEmpleado()
    {
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
    public static function logout()
    {
        session_start();
        session_destroy();
        session_unset();
        setcookie("PHPSESSID", "", time() - 1);
        header("Location: ../view/login.php");
    }

    public static function obtenerTodos()
    {
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
