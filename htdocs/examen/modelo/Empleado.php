<?php
class Empleado {
    private int $codigo;
    private string $clave;
    private string $nombrecompleto;
    private int $telf;
    private string $rol;

    public function __construct(array $fila) {
        $this->codigo = (int)$fila['codigo'];
        $this->clave = $fila['clave'];
        $this->nombrecompleto = $fila['nombrecompleto'];
        $this->telf = (int)$fila['telf'];
        $this->rol = $fila['rol'];
    }

    public function getCodigo(): int { return $this->codigo; }
    public function getClave(): string { return $this->clave; }
    public function getNombreCompleto(): string { return $this->nombrecompleto; }
    public function getRol(): string { return $this->rol; }

    //En el modelo para obtener el empleado por codigo
    public static function obtenerPorCodigo(PDO $pdo, int $codigo): ?Empleado {
        $stmt = $pdo->prepare('SELECT * FROM empleado WHERE codigo = :codigo');
        $stmt->execute([':codigo' => $codigo]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($fila) {
            return new Empleado($fila);
        }
        return null;
    }

    // Obtenemos la lista de mecánicos 
    public static function obtenerMecanicos(PDO $pdo): array {
        $stmt = $pdo->query("SELECT codigo, nombrecompleto, rol FROM empleado WHERE 
        FIND_IN_SET('mecanico',rol) OR rol='mecanico' OR rol LIKE '%mecanico%'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //en el login encontrar el empleado por codigo
    public function buscarPorCodigo($conexion, $codigo) {
        $sql = "SELECT * FROM empleado WHERE codigo = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$codigo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}