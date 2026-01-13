<?php
// controladores/RegistroController.php
require_once __DIR__ . '/../clase/Conexion.php';
require_once __DIR__ . '/../modelo/Cliente.php';
require_once __DIR__ . '/../modelo/Coche.php';
require_once __DIR__ . '/../modelo/Tarea.php';
require_once __DIR__ . '/../modelo/Trabajo.php';
require_once __DIR__ . '/../modelo/Empleado.php';

class RegistroController {
    private function crearConexion(): PDO {
        $config = require __DIR__.'../clase/Conexion.php';
        $dsn = "mysql:host={$config['db_host']};dbname={$config['db_name']};charset=utf8";
        $pdo =new PDO($dsn, $config['db_user'], $config['db_pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    private function fechaActual(): string {
        return date('yyyy-mm-dd');
    }

    public function mostrarRegistro(): void {
        session_start();
        if (!isset($_SESSION['codigo'])) {
            header("Location: /__DIR__.'/../public/login.php'");
            exit;
        }

        $pdo = $this->crearConexion();
        $errores = [];
        $cliente = null;
        $coches = [];
        $coche_seleccionado = null;
        $tareas_por_tipo = [
            'Mantenimiento' => Tarea::obtenerPorTipo($pdo, 'Mantenimiento'),
            'Reparación' => Tarea::obtenerPorTipo($pdo, 'Reparación'),
            'Electrónica' => Tarea::obtenerPorTipo($pdo, 'Electrónica'),
        ];
        $mecanicos = Empleado::obtenerMecanicos($pdo);
        $mensaje = '';

        // acciones posibles de cliente buscar_dni, de coche seleccionar_coche, añadir_coche mostramos el formulario, registrar
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Buscar cliente por DNI
            if (isset($_POST['accion']) && $_POST['accion'] === 'buscar_dni') {
                if (!isset($_POST['dni_buscar'])) {
                    $errores[] = 'DNI no proporcionado';
                } else {
                    $dni_buscar = $_POST['dni_buscar'];
                    $cliente = Cliente::buscarPorDni($pdo, $dni_buscar);
                    if (!$cliente) {
                        // recargar página y mensaje que el usuario no existe 
                        header("Location: /__DIR__.'/../public/registra.php?error_noexiste=1&dni=' ". urlencode($dni_buscar));
                        exit;
                    } else {
                        $coches = Coche::obtenerPorDni($pdo, $dni_buscar);
                        // mostrar formulario con coches. Cargaremos la vista más abajo con $cliente, $coches
                    }
                }
            }

            // Seleccionar coche existente 
            if (isset($_POST['accion']) && $_POST['accion'] === 'seleccionar_coche') {
                $matricula_sel = $_POST['matricula_seleccionada'] ?? '';
                $fila = Coche::obtenerPorMatricula($pdo, $matricula_sel);
                if ($fila) {
                    $coche_seleccionado = $fila;
                    $cliente = Cliente::buscarPorDni($pdo, $fila['dni_cliente']);
                } else {
                    $errores[] = 'Coche no encontrado';
                }
            }

            // Añadir coche nuevo con el formulario en blanco
            if (isset($_POST['accion']) && $_POST['accion'] === 'nuevo_coche') {
                if (!isset($_POST['dni_cliente'])) {
                    $errores[] = 'DNI cliente no especificado';
                } else {
                    $cliente = Cliente::buscarPorDni($pdo, $_POST['dni_cliente']);
                    $coche_seleccionado = null; 
                }
            }

            // Registrar, validamos y despues guardamos los datos
            if (isset($_POST['accion']) && $_POST['accion'] === 'registrar') {
                // leemos todos los campos 
                $dni_cliente = $_POST['dni_cliente'] ?? '';
                $nombrecliente = $_POST['nombrecliente'] ?? '';
                $direccioncliente = $_POST['direccioncliente'] ?? '';
                $telfcliente = $_POST['telfcliente'] ?? '';

                $matricula = $_POST['matricula'] ?? '';
                $marca = $_POST['marca'] ?? '';
                $modelo = $_POST['modelo'] ?? '';
                $km = $_POST['km'] ?? '0';
                $matricula = strtoupper($matricula);

                $mecanico_responsable = isset($_POST['mecanico_responsable']) ? (int)$_POST['mecanico_responsable'] : 0;

                // tareas por categorias 
                $tareas_seleccionadas = [];
                if (isset($_POST['tareas_mantenimiento'])) {
                    $tareas_seleccionadas = array_merge($tareas_seleccionadas, $_POST['tareas_mantenimiento']);
                }
                if (isset($_POST['tareas_reparacion'])) {
                    $tareas_seleccionadas = array_merge($tareas_seleccionadas, $_POST['tareas_reparacion']);
                }
                if (isset($_POST['tareas_electronica'])) {
                    $tareas_seleccionadas = array_merge($tareas_seleccionadas, $_POST['tareas_electronica']);
                }

                
                // Validamos el DNI: 8 dígitos y letra mayúscula
                if (!preg_match('/^[0-9]{8}[A-Z]$/', $dni_cliente)) {
                    $errores[] = 'DNI inválido (8 dígitos y letra mayúscula)';
                }
                // Validamos el telefono 9 dígitos
                if (!preg_match('/^[0-9]{9}$/', $telfcliente)) {
                    $errores[] = 'Teléfono inválido (9 dígitos)';
                }
                // Validamos la matricula 4 dígitos + 3 letras
                if (!preg_match('/^[0-9]{4}[A-Z]{3}$/', $matricula)) {
                    $errores[] = 'Matrícula inválida (4 dígitos y 3 letras mayúsculas)';
                }
                // Validamos que al menos una tarea este seleccionada
                if (count($tareas_seleccionadas) === 0) {
                    $errores[] = 'Debe seleccionar al menos una tarea';
                }
                // Validamos que la imagen sea jpg 
                $archivo_foto = $_FILES['foto'] ?? null;
                $nombre_foto_a_guardar = '';
                $foto_subida = false;
                if ($archivo_foto && $archivo_foto['error'] !== UPLOAD_ERR_NO_FILE) {
                    
                    if ($archivo_foto['error'] !== UPLOAD_ERR_OK) {
                        $errores[] = 'Error en subida de imagen';
                    } else {
                        $finfo = finfo_open(FILEINFO_MIME_TYPE);
                        $mime = finfo_file($finfo, $archivo_foto['tmp_name']);
                        finfo_close($finfo);
                        // aceptar image/jpg 
                        if ($mime !== 'image/jpg') {
                            $errores[] = 'La imagen debe ser JPG';
                        } else {
                            $foto_subida = true;
                            // generar nombre de fichero: timestamp_matricula.jpg
                            $nombre_foto_a_guardar = time() . '_' . $matricula . '.jpg';
                            $ruta_destino = __DIR__ . '/../public/coches/' . $nombre_foto_a_guardar;
                        }
                    }
                }

                // Si no hay errores vamos a la base de datos
                if (count($errores) === 0) {
                    // Comenzamos la transacción
                    try {
                        $pdo->beginTransaction();

                        // Si el cliente existe actualizamos, si no insertamos
                        $cliente_existente = Cliente::buscarPorDni($pdo, $dni_cliente);
                        if ($cliente_existente) {
                            Cliente::actualizar($pdo, [
                                'dni' => $dni_cliente,
                                'nombrecompleto' => $nombrecliente,
                                'direccion' => $direccioncliente,
                                'telf' => $telfcliente
                            ]);
                        } else {
                            Cliente::insertar($pdo, [
                                'dni' => $dni_cliente,
                                'nombrecompleto' => $nombrecliente,
                                'direccion' => $direccioncliente,
                                'telf' => $telfcliente
                            ]);
                        }

                        // Comprobamos si el coche existe
                        $coche_existente = Coche::obtenerPorMatricula($pdo, $matricula);
                        if ($foto_subida) {
                            // si hay una foto nueva y el coche existia cambiamos la foto por la foto nueva
                            if ($coche_existente && !empty($coche_existente['foto'])) {
                                $ruta_antigua = __DIR__ . '/../public/coches/' . $coche_existente['foto'];
                                if (file_exists($ruta_antigua)) {
                                    unlink($ruta_antigua);
                                }
                            }
                            // ponemos la foto en la foto en la carpeta coches
                            move_uploaded_file($archivo_foto['tmp_name'], $ruta_destino);
                            $campo_foto = $nombre_foto_a_guardar;
                        } else {
                            // si no subimos la foto y el coche existe, mantenemos la foto antigua
                            $campo_foto = $coche_existente ? $coche_existente['foto'] : '';
                        }

                        // Insertar o actualizar coche
                        $datos_coche = [
                            'matricula' => $matricula,
                            'marca' => $marca,
                            'modelo' => $modelo,
                            'km' => (int)$km,
                            'foto' => $campo_foto,
                            'dni_cliente' => $dni_cliente
                        ];

                        if ($coche_existente) {
                            Coche::actualizar($pdo, $datos_coche);
                        } else {
                            Coche::insertar($pdo, $datos_coche);
                        }

                        // Registrar tareas en la tabla trabajo con la fecha actual
                        $fecha = $this->fechaActual();
                        foreach ($tareas_seleccionadas as $id_tarea) {
                            // nos daba error porque el id llegaba como string, lo pasamos a int
                            Trabajo::insertarTrabajo($pdo, $matricula, $mecanico_responsable, (int)$id_tarea, $fecha);
                        }

                        $pdo->commit();

                        // Redirigimos al menu con mensaje de registro correcto
                        $mensaje = 'Se han registrado correctamente las tareas para el vehículo con marca '.$marca.' modelo '.$modelo.' con matrícula '.$matricula;
                        header("Location: /_DIR_.'/../public/menu.php?mensaje='".urlencode($mensaje));
                        exit;
                    } catch (Exception $e) {
                        $pdo->rollBack();
                        $errores[] = 'Error al guardar en la base de datos: '.$e->getMessage();
                    }
                }
                // Si hay errores, cargamos las variables para mostrar el formulario de nuevo con errores
                $cliente = Cliente::buscarPorDni($pdo, $dni_cliente);
                $coches = $cliente ? Coche::obtenerPorDni($pdo, $dni_cliente) : [];
                $coche_seleccionado = [
                    'matricula' => $matricula,
                    'marca' => $marca,
                    'modelo' => $modelo,
                    'km' => $km,
                    'foto' => $campo_foto ?? ''
                ];
            }
        }

        // Si llegamos con el GET error_noexiste
        if (isset($_GET['error_noexiste']) && $_GET['error_noexiste'] == '1') {
            $dni = $_GET['dni'] ?? '';
            $errores[] = 'El usuario con DNI '.$dni.' no existe';
        }

        // Vista
        require_once __DIR__.'/../public/registra.php';
    }
}