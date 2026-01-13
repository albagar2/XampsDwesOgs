<?php 
    require_once "Conexion.php";
    include "../model/Profesor.php";

    class ControladorProfesor {
        public static function login() {
                $conex = new Conexion();
                $dni = $_POST['dni'];
                $clave = md5($_POST['pass']);
                $ahora = time();

                $sql = "SELECT * FROM profesores WHERE dni_p = '$dni'";
                $res = $conex->query($sql);

                if ($prof = $res->fetch_object()) {
                    if ($prof->bloqueado == 1 && $ahora < ($prof->hora_bloqueo + 60)) {
                        return "Usuario bloqueado. Espere un minuto.";
                    }

                    if ($prof->pass === $clave) {
                        $conex->query("UPDATE profesores SET intentos = 3, bloqueado = 0, hora_bloqueo = 0 WHERE dni_p = '$dni'");
                        session_start();
                        $_SESSION['profesor_dni'] = $prof->dni_p;
                        $_SESSION['profesor_nombre'] = $prof->nombre." ".$prof->apellidos;
                        header("Location: partes.php");
                    } else {
                        $nuevos_intentos = $prof->intentos - 1;
                        if ($nuevos_intentos <= 0) {
                            $conex->query("UPDATE profesores SET intentos = 0, bloqueado = 1, hora_bloqueo = $ahora WHERE dni_p = '$dni'");
                            return "Intentos agotados. Bloqueado durante 1 minuto.";
                        } else {
                            $conex->query("UPDATE profesores SET intentos = $nuevos_intentos WHERE dni_p = '$dni'");
                            return "Clave incorrecta. Quedan $nuevos_intentos intentos.";
                        }
                    }
                } else {
                    return "Usuario o clave incorrecta.";
                }
            }

            public static function logout() {
                session_start();
                session_destroy();
                header("Location: index.php");
            }
        }
?>