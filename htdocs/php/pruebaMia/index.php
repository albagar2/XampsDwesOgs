<?php
require_once 'controladores/LoginController.php';
require_once 'controladores/TallerController.php';

if (isset($_GET['accion'])) {
    $accion = $_GET['accion'];
    
    // Instancia del controlador principal
    $taller = new TallerController(); // Ya verifica sesión en su constructor
    $login = new LoginController();

    switch ($accion) {
        case 'inicio':
            $taller->inicio();
            break;
        case 'anadir':
            $taller->formAnadirPieza();
            break;
        case 'validar':
            $taller->validarPieza();
            break;
        case 'ejecutar':
            $taller->ejecutarPieza();
            break;
        case 'historial':
            $taller->historial();
            break;
        case 'logout':
            $login->cerrarSesion();
            break;
        default:
            $login->gestionarLogin();
            break;
    }
} else {
    $controller = new LoginController();
    $controller->gestionarLogin();
}
?>