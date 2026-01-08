<?php
class Client {
  private $pdo;
  public function __construct($pdo){ $this->pdo = $pdo; }
  public function findByDNI($dni){
    $st = $this->pdo->prepare('SELECT * FROM cliente WHERE DNI = ?');
    $st->execute([$dni]);
    return $st->fetch();
  }
  public function login($dni, $password){
    $user = $this->findByDNI($dni);
    if (!$user) return false;
    if (md5($password) === $user['Clave']) return $user;
    return false;
  }
}
