<?php
class Coche {
    //Para coger los coches por el dni del cliente con un select where el sni del cliente sea dni
    public static function obtenerPorDni(PDO $pdo, string $dni): array {
        $stmt = $pdo->prepare('SELECT matricula, marca, modelo, km, foto FROM coche WHERE dni_cliente = :dni');
        $stmt->execute([':dni' => $dni]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Select para obtener todos los coches con un where que sea matricula
    public static function obtenerPorMatricula(PDO $pdo, string $matricula): ?array {
        $stmt = $pdo->prepare('SELECT * FROM coche WHERE matricula = :matricula');
        $stmt->execute([':matricula' => $matricula]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fila ?: null;
    }

    // Para insertar el insert into y todos los valores
    public static function insertar(PDO $pdo, array $datos): bool {
        $stmt = $pdo->prepare('INSERT INTO coche (matricula, marca, modelo, km, foto, dni_cliente) 
        VALUES (:matricula, :marca, :modelo, :km, :foto, :dni_cliente)');
        return $stmt->execute([
            ':matricula' => $datos['matricula'],
            ':marca' => $datos['marca'],
            ':modelo' => $datos['modelo'],
            ':km' => $datos['km'],
            ':foto' => $datos['foto'],
            ':dni_cliente' => $datos['dni_cliente']
        ]);
    }


    // Para actualizar el update y le pasamos todos los parametros
    public static function actualizar(PDO $pdo, array $datos): bool {
        $stmt = $pdo->prepare('UPDATE coche SET marca = :marca, modelo = :modelo,
         km = :km, foto = :foto, dni_cliente = :dni_cliente WHERE matricula = :matricula');
        return $stmt->execute([
            ':marca' => $datos['marca'],
            ':modelo' => $datos['modelo'],
            ':km' => $datos['km'],
            ':foto' => $datos['foto'],
            ':dni_cliente' => $datos['dni_cliente'],
            ':matricula' => $datos['matricula']
        ]);
    }
}