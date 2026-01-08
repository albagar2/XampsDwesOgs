<?php
require_once 'clases/Conexion.php';
require_once 'modelos/Usuario.php';

class LoginController {
    
    public function gestionarLogin() {
        $error = null;
        $intentos = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $con = new Conexion();
            $db = $con->conectar();
            $userModel = new Usuario($db);

            $dni = $_POST['dni'];
            $pass = md5($_POST['clave']); 

            $usuario = $userModel->obtenerPorDNI($dni);

            if ($usuario) {
                if ($usuario->bloqueado == 1) {
                    $error = "USUARIO BLOQUEADO. CONTACTE ADMIN.";
                } elseif ($usuario->clave === $pass) {
                    $userModel->resetearIntentos($dni);
                    session_start();
                    $_SESSION['usuario'] = $usuario->nombre;
                    $_SESSION['dni'] = $usuario->dni;
                    header("Location: index.php?accion=inicio");
                    return;
                } else {
                    $userModel->restarIntento($dni);
                    // Refrescamos dato para ver intentos
                    $usuario = $userModel->obtenerPorDNI($dni);
                    if ($usuario->bloqueado) {
                        $error = "HA SIDO BLOQUEADO";
                    } else {
                        $intentos = $usuario->intentos;
                        $error = "Contraseña incorrecta";
                    }
                }
            } else {
                $error = "Usuario no existe";
            }
        }
        require 'vistas/login.php';
    }

    public function cerrarSesion() {
        session_start();
        session_destroy();
        header("Location: index.php");
    }
}
?>