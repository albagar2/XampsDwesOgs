<?php

require_once "../modelo/Empleado.php";

class LoginController {

    private $conexion;

    public function __construct() {
        $this->crearConexion();
    }

    private function crearConexion() {
        try {
            $this->conexion = new PDO(
                "mysql:host=localhost;dbname=taller_mecanico;charset=utf8",
                "dwes",
                "abc123."
            );
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error en la conexión: " . $e->getMessage());
        }
    }

    public function mostrarFormulario() {
        $mensaje = "";
        require "../vista/login.php";
    }

    public function procesarLogin() {
        if (isset($_POST['codigo']) && isset($_POST['clave'])) {

            $empleadoModel = new Empleado();

            $empleado = $empleadoModel->buscarPorCodigo($this->conexion, $_POST['codigo']);

            if ($empleado && password_verify($_POST['clave'], $empleado['clave'])) {
                
                session_start();
                $_SESSION['empleado'] = $empleado;

                header("Location: menu.php");
                exit;

            } else {
                $mensaje = "Usuario o clave incorrecta";
                require "../vista/login.php";
            }
        } else {
            $mensaje = "Debe introducir usuario y clave";
            require "../vista/login.php";
        }
    }
}


$controlador = new LoginController();

if (isset($_POST['enviar'])) {
    $controlador->procesarLogin();
} else {
    $controlador->mostrarFormulario();
}