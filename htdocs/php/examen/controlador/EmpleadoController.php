<?php
require_once __DIR__ . '/../clase/Conexion.php';
require_once __DIR__ . '/../modelo/Empleado.php';
require_once __DIR__ . '/../public/menu.php';

class EmpleadoController {
    private function crearConexion(): PDO {
        $config = require __DIR__.'../clase/Conexion.php';
        $dsn = "mysql:host={$config['db_host']};dbname={$config['db_name']};charset=utf8";
        $pdo =new PDO($dsn, $config['db_user'], $config['db_pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    public function login(): void {
        session_start();
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            if (!isset($_POST['codigo']) || !isset($_POST['clave'])) {
                $error = 'Usuario o clave incorrecta';
            } else {
                $codigo = (int)$_POST['codigo'];
                $pdo = $this->crearConexion();
                $empleado = Empleado::obtenerPorCodigo($pdo, $codigo);
                if ($empleado && password_verify($_POST['clave'], $empleado->getClave())) {
                    
                    $_SESSION['codigo'] = $empleado->getCodigo();
                    $_SESSION['nombrecompleto'] = $empleado->getNombreCompleto();
                    $_SESSION['rol'] = $empleado->getRol();
                    header("Location: /__DIR__.'/../public/menu.php'");
                    exit;
                } else {
                    $error = 'Usuario o clave incorrecta';
                }
            }
        }
        // Mostrar vista login con $error
        require_once __DIR__.'/../public/login.php';
    }

    public function logout(): void {
        session_start();
        session_unset();
        session_destroy();
        header("Location: /_DIR_/.'/../examen/public/login.php'");
        exit;
    }
}