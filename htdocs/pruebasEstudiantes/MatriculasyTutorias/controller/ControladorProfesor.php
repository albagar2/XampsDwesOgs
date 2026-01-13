<?php
require_once "Conexion.php";

class ControladorProfesor {
    public static function login() {
        try {
            $conex = new Conexion("gestion_academica");
            $result = $conex->prepare("SELECT * FROM profesor WHERE codigo = ?");
            $result->bindValue(1, $_POST['usuario']);
            $result->execute();
            if ($data = $result->fetch()) {
                if (password_verify($_POST['clave'], $data->clave)) {
                    session_start();
                    $_SESSION['nombre'] = $data->nombre_completo;
                    $_SESSION['codigo'] = $data->codigo;
                    $_SESSION['rol'] = $data->rol;
                    header("Location: ../view/menu.php");
                } else { return "Contraseña incorrecta"; }
            } else { return "Usuario no encontrado"; }
        } catch (PDOException $ex) { echo $ex->getMessage(); }
    }

    public static function obtenerTutores() {
        try {
            $conex = new Conexion("gestion_academica");
            $res = $conex->query("SELECT * FROM profesor WHERE rol LIKE '%tutor%'");
            return $res->fetchAll();
        } catch (PDOException $ex) { return []; }
    }

    public static function logout() {
        session_start();
        session_destroy();
        header("Location: ../view/login.php");
    }
}