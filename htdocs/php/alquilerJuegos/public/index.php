<?php
session_start();
require_once __DIR__ . '/../config/db.php';

spl_autoload_register(function($c){
  $paths = [__DIR__ . '/../app/controllers/', __DIR__ . '/../app/models/'];
  foreach($paths as $p) {
    $f = $p . $c . '.php';
    if (file_exists($f)) { require_once $f; return; }
  }
});

$controller = $_GET['c'] ?? 'game';
$action = $_GET['a'] ?? 'index';
$class = ucfirst($controller) . 'Controller';
if (class_exists($class)) {
  $ctrl = new $class($pdo);
  if (method_exists($ctrl, $action)) {
    $ctrl->{$action}();
    exit;
  }
}
http_response_code(404);
echo 'Página no encontrada';
