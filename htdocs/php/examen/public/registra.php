<?php
// public/registra.php
require_once __DIR__.'/../controlador/RegistroController.php';
$controller = new RegistroController();
$controller->mostrarRegistro();