<?php
class AdminController {
  private $pdo;
  public function __construct($pdo){ $this->pdo = $pdo; }
  private function checkAdmin(){
    if (!isset($_SESSION['user']) || $_SESSION['user']['Tipo'] !== 'admin') { header('Location: ../public/index.php?c=auth&a=index'); exit; }
  }
  public function list(){
    $this->checkAdmin();
    $g = new Game($this->pdo);
    $games = $g->all();
    require __DIR__ . '/../views/admin/games_admin_list.php';
  }
  public function add(){
    $this->checkAdmin();
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
      $g = new Game($this->pdo);
      $g->add($_POST);
      header('Location: ../public/index.php?c=admin&a=list');
      return;
    }
    $game = null;
    require __DIR__ . '/../views/admin/form_game.php';
  }
  public function edit(){
    $this->checkAdmin();
    $code = $_GET['code'] ?? null; $g = new Game($this->pdo);
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
      $g->update($code, $_POST);
      header('Location: ../public/index.php?c=admin&a=list');
      return;
    }
    $game = $g->find($code);
    require __DIR__ . '/../views/admin/form_game.php';
  }
  public function delete(){
    $this->checkAdmin();
    $code = $_GET['code'] ?? null; $g = new Game($this->pdo);
    $g->delete($code);
    header('Location: ../public/index.php?c=admin&a=list');
  }
}
