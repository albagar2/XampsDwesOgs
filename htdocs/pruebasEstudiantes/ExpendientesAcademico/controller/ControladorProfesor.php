<?php
require_once "Conexion.php";

class ControladorProfesor {
    public static function login() {
        try {
            $conex = new Conexion();
            $res = $conex->prepare("SELECT * FROM profesor WHERE codigo = ?");
            $res->bindValue(1, $_POST['usuario']);
            $res->execute();
            if ($p = $res->fetch()) {
                if (password_verify($_POST['clave'], $p->clave)) {
                    session_start();
                    $_SESSION['profesor'] = $p;
                    header("Location: menu.php");
                } else return "Contraseña incorrecta";
            } else return "Profesor no encontrado";
        } catch (PDOException $e) { return $e->getMessage(); }
    }

    public static function obtenerTodos() {
        $conex = new Conexion();
        return $conex->query("SELECT * FROM profesor")->fetchAll();
    }
}