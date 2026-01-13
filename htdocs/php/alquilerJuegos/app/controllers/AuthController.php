<?php
class AuthController {
  private $pdo;
  public function __construct($pdo){ $this->pdo = $pdo; }
  public function index(){
    $error = $_GET['error'] ?? null;
    require __DIR__ . '/../views/login.php';
  }
  public function login(){
    $dni = $_POST['dni'] ?? '';
    $pass = $_POST['pass'] ?? '';
    $client = new Client($this->pdo);
    $user = $client->login($dni,$pass);
    if ($user) {
      $_SESSION['user'] = $user;
      $redirect = $_SESSION['login_redirect'] ?? 'index.php?c=game&a=index';
      unset($_SESSION['login_redirect']);
      header('Location: ' . $redirect);
    } else {
      $error = 'Credenciales incorrectas';
      require __DIR__ . '/../views/login.php';
    }
  }
  public function logout(){
    session_destroy();
    header('Location: ../public/index.php?c=game&a=index');
  }
}
