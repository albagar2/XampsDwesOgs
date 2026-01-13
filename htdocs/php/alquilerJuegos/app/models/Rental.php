<?php
class Rental {
  private $pdo;
  public function __construct($pdo){ $this->pdo = $pdo; }
  public function rent($codJuego, $dni){
    $fecha = new DateTime();
    $st = $this->pdo->prepare('INSERT INTO alquiler (Cod_juego,DNI_cliente,Fecha_alquiler,Fecha_devol) VALUES (?,?,?,NULL)');
    return $st->execute([$codJuego,$dni,$fecha->format('Y-m-d')]);
  }
  public function userRentals($dni){
    $st = $this->pdo->prepare('SELECT a.*, j.Nombre_juego, j.Precio FROM alquiler a JOIN juegos j ON a.Cod_juego=j.Codigo WHERE a.DNI_cliente = ? AND a.Fecha_devol IS NULL');
    $st->execute([$dni]);
    return $st->fetchAll();
  }
  public function returnGame($id){
    $fecha = new DateTime();
    $st = $this->pdo->prepare('UPDATE alquiler SET Fecha_devol = ? WHERE id = ?');
    return $st->execute([$fecha->format('Y-m-d'), $id]);
  }
  public function allRented(){
    $st = $this->pdo->query('SELECT a.*, j.Nombre_juego, j.Precio, c.Nombre, c.Apellidos FROM alquiler a JOIN juegos j ON a.Cod_juego=j.Codigo JOIN cliente c ON a.DNI_cliente=c.DNI WHERE a.Fecha_devol IS NULL');
    return $st->fetchAll();
  }
}
