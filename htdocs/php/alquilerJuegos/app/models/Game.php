<?php
class Game {
  private $pdo;
  public function __construct($pdo){ $this->pdo = $pdo; }
  public function all(){
    $st = $this->pdo->query('SELECT * FROM juegos');
    return $st->fetchAll();
  }
  public function find($code){
    $st = $this->pdo->prepare('SELECT * FROM juegos WHERE Codigo = ?');
    $st->execute([$code]);
    return $st->fetch();
  }
  public function isRented($code){
    $st = $this->pdo->prepare('SELECT * FROM alquiler WHERE Cod_juego = ? AND Fecha_devol IS NULL');
    $st->execute([$code]);
    return (bool)$st->fetch();
  }
  public function add($data){
    $st = $this->pdo->prepare('INSERT INTO juegos (Codigo,Nombre_juego,Nombre_consola,Anno,Precio,Alguilado,Imagen,descripcion) VALUES (?,?,?,?,?,?,?,?)');
    return $st->execute([$data['Codigo'],$data['Nombre_juego'],$data['Nombre_consola'],$data['Anno'],$data['Precio'],$data['Alguilado'],$data['Imagen'],$data['descripcion']]);
  }
  public function update($code,$data){
    $st = $this->pdo->prepare('UPDATE juegos SET Nombre_juego=?,Nombre_consola=?,Anno=?,Precio=?,Alguilado=?,Imagen=?,descripcion=? WHERE Codigo=?');
    return $st->execute([$data['Nombre_juego'],$data['Nombre_consola'],$data['Anno'],$data['Precio'],$data['Alguilado'],$data['Imagen'],$data['descripcion'],$code]);
  }
  public function delete($code){
    $st = $this->pdo->prepare('DELETE FROM juegos WHERE Codigo = ?');
    return $st->execute([$code]);
  }
}
