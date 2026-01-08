<?php
class Cliente {
    //Buscamos el cliente segun su dni
    public static function buscarPorDni(PDO $pdo, string $dni): ?array {
        $stmt = $pdo->prepare('SELECT * FROM cliente WHERE dni = :dni');
        $stmt->execute([':dni' => $dni]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fila ?: null;
    }

    // añadimos un cliente con los valores ingresados en el formulario
    public static function insertar(PDO $pdo, array $datos): bool {
        $stmt = $pdo->prepare('INSERT INTO cliente (dni, nombrecompleto, direccion, telf) VALUES 
        (:dni, :nombrecompleto, :direccion, :telf)');
        return $stmt->execute([
            ':dni' => $datos['dni'],
            ':nombrecompleto' => $datos['nombrecompleto'],
            ':direccion' => $datos['direccion'],
            ':telf' => $datos['telf']
        ]);
    }

    // actualizamos un cliente que ya se encuentra en la base de datos
    public static function actualizar(PDO $pdo, array $datos): bool {
        $stmt = $pdo->prepare('UPDATE cliente SET nombrecompleto = :nombrecompleto, 
        direccion = :direccion, telf = :telf WHERE dni = :dni');
        return $stmt->execute([
            ':nombrecompleto' => $datos['nombrecompleto'],
            ':direccion' => $datos['direccion'],
            ':telf' => $datos['telf'],
            ':dni' => $datos['dni']
        ]);
    }
}