<?php
// Cargar controladores
require_once 'controladores/LoginController.php';
require_once 'controladores/OperacionesController.php';

// Router básico
if (isset($_GET['accion'])) {
    
    $accion = $_GET['accion'];
    
    if ($accion === 'inicio') {
        $controller = new OperacionesController();
        $controller->inicio();
    } elseif ($accion === 'logout') {
        $controller = new LoginController();
        $controller->cerrarSesion();
    } elseif ($accion === 'historial') {
        $controller = new OperacionesController();
        $controller->historial();
    } elseif ($accion === 'transferir') { // Mostrar formulario
        $controller = new OperacionesController();
        $controller->formTransferencia();
    } elseif ($accion === 'validar') { // Validar datos (pantalla intermedia)
        $controller = new OperacionesController();
        $controller->validarTransferencia();
    } elseif ($accion === 'ejecutar') { // Hacer insert en BD
        $controller = new OperacionesController();
        $controller->ejecutarTransferencia();
    }

} else {
    // Si no hay acción, mostrar Login
    $controller = new LoginController();
    $controller->gestionarLogin();
}
?>

