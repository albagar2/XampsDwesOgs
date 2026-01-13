<?php

class Trabajo {
    public static function insertarTrabajo(PDO $pdo, string $matricula, int $cod_mecanico, int $id_tarea, string $fecha): bool {
        $stmt = $pdo->prepare('INSERT INTO trabajo (matricula, cod_mecanico, id_tarea, fecha) 
        VALUES (:matricula, :cod_mecanico, :id_tarea, :fecha)');
        return $stmt->execute([
            ':matricula' => $matricula,
            ':cod_mecanico' => $cod_mecanico,
            ':id_tarea' => $id_tarea,
            ':fecha' => $fecha
        ]);
    }
}