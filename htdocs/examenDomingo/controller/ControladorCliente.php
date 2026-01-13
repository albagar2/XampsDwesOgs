<?php
require_once "Conexion.php";
include "../model/Cliente.php";
class ControladorCliente
{
    public static function obtenerCliente($dni)
    {
        try {
            $conex = new Conexion("taller_mecanico");
            $result = $conex->prepare("SELECT * FROM cliente WHERE dni = ?");
            $result->bindValue(1, $dni);
            if ($result->execute()) {
                return $result->fetch();
            }
            return null;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return null;
        }
    }

    public static function actualizarCliente($dni, $nombrecompleto, $direccion, $telf)
    {
        try {
            $conex = new Conexion("taller_mecanico");
            $result = $conex->prepare("UPDATE cliente SET nombrecompleto=?, direccion=?, telf=? WHERE dni=?");
            $result->bindValue(1, $nombrecompleto);
            $result->bindValue(2, $direccion);
            $result->bindValue(3, $telf);
            $result->bindValue(4, $dni);
            if ($result->execute()) {
                return "Cliente actualizado correctamente";
            } else {
                return "Error al actualizar el cliente";
            }
        } catch (PDOException $ex) {
            return "Error: " . $ex->getMessage();
        }
    }
}