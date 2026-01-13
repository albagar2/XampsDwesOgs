<?php
require_once 'clases/Conexion.php';
require_once 'modelos/Usuario.php';

class LoginController {
    
    public function gestionarLogin() {
        $error = null;
        $intentos = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $conexion = new Conexion();
            $db = $conexion->conectar();
            $usuarioModel = new Usuario($db);

            $dni = $_POST['dni'];
            $pass = md5($_POST['clave']); // Exigido por el examen

            $usuario = $usuarioModel->obtenerPorDNI($dni);

            if ($usuario) {
                if ($usuario->bloqueado == 1) {
                    $error = "USUARIO BLOQUEADO";
                } elseif ($usuario->clave === $pass) {
                    // Login correcto
                    $usuarioModel->resetearIntentos($dni);
                    session_start();
                    $_SESSION['usuario'] = $usuario->Nombre;
                    $_SESSION['dni'] = $usuario->DNI;
                    header("Location: index.php?accion=inicio");
                    return;
                } else {
                    // Clave incorrecta
                    $usuarioModel->restarIntento($dni);
                    // Recargamos usuario para ver intentos actualizados
                    $usuario = $usuarioModel->obtenerPorDNI($dni);
                    if ($usuario->bloqueado) {
                        $error = "USUARIO BLOQUEADO";
                    } else {
                        $intentos = $usuario->intentos;
                        $error = "Nombre de usuario o clave incorrecta";
                    }
                }
            } else {
                $error = "Usuario no encontrado";
            }
        }
        
        // Cargar vista
        require 'vistas/login.php';
    }

    public function cerrarSesion() {
        session_start();
        session_destroy();
        header("Location: index.php");
    }
}
?>