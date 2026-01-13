<?php
class Tarea {
    public static function obtenerPorTipo(PDO $pdo, string $tipo): array {
        $stmt = $pdo->prepare('SELECT id, descripcion, precio, tipo FROM tarea WHERE tipo = :tipo');
        $stmt->execute([':tipo' => $tipo]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function obtenerTodasPorTipos(PDO $pdo): array {
        $stmt = $pdo->query("SELECT id, descripcion, precio, tipo FROM tarea ORDER BY tipo, id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function obtenerPorIds(PDO $pdo, array $ids): array {
        if (count($ids) === 0) return [];
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $pdo->prepare("SELECT id, descripcion, precio, tipo FROM tarea WHERE id IN ($placeholders)");
        $stmt->execute($ids);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}