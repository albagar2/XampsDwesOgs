<?php
class GameController {
  private $pdo;
  public function __construct($pdo){ $this->pdo = $pdo; }
  public function index(){
    $m = new Game($this->pdo);
    $games = $m->all();
    require __DIR__ . '/../views/home.php';
  }
  public function detail(){
    $code = $_GET['code'] ?? null;
    if (!$code) { echo 'Juego no especificado'; return; }
    $m = new Game($this->pdo);
    $game = $m->find($code);
    $rented = $m->isRented($code);
    require __DIR__ . '/../views/game_detail.php';
  }
}
