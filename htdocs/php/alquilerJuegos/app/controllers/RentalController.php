<?php
class RentalController {
  private $pdo;
  public function __construct($pdo){ $this->pdo = $pdo; }
  public function rent(){
    if (!isset($_SESSION['user'])) {
      $_SESSION['login_redirect'] = '../public/index.php?c=game&a=detail&code=' . urlencode($_GET['code'] ?? '');
      header('Location: ../public/index.php?c=auth&a=index');
      return;
    }
    $cod = $_GET['code'] ?? null;
    if (!$cod) { echo 'Falta código'; return; }
    $r = new Rental($this->pdo);
    if ($r->rent($cod, $_SESSION['user']['DNI'])) {
      header('Location: ../public/index.php?c=game&a=detail&code=' . urlencode($cod));
    } else echo 'Error al alquilar';
  }
  public function my(){
    if (!isset($_SESSION['user'])) { header('Location: ../public/index.php?c=auth&a=index'); return; }
    $r = new Rental($this->pdo);
    $rentals = $r->userRentals($_SESSION['user']['DNI']);
    require __DIR__ . '/../views/my_rentals.php';
  }
  public function ret(){
    if (!isset($_SESSION['user'])) { header('Location: ../public/index.php?c=auth&a=index'); return; }
    $id = $_GET['id'] ?? null; if (!$id) { echo 'Falta id'; return; }
    $r = new Rental($this->pdo);
    $r->returnGame($id);
    header('Location: ../public/index.php?c=rental&a=my');
  }
}
