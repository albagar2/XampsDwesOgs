<?php
// las variables las cogemos del controlador: $cliente, $coches, $coche_seleccionado, $tareas_por_tipo, $mecanicos, $errores
session_start();
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Registro de trabajo</title></head>
<body>
    <header>
        <p>Usuario: <?php echo $_SESSION['nombrecompleto']; ?> (<?php echo $_SESSION['rol']; ?>) |
           <a href="/../public/logout.php">Cerrar sesión</a> |
           <a href="/../vista/menu.php">Volver al menú</a>
        </p>
    </header>

    <h1>Registro de trabajo</h1>

    <?php if (!empty($errores)): ?>
        <div style="color:red;">
            <ul>
                <?php foreach ($errores as $e): ?>
                    <li><?php echo $e; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!--Buscamos el cliente por DNI -->
    <section>
        <h2>Buscar cliente</h2>
        <form method="post" action="/examen/public/registra.php">
            <input type="hidden" name="accion" value="buscar_dni">
            <label>DNI: <input type="text" name="dni_buscar" required></label>
            <button type="submit">Buscar</button>
        </form>
    </section>

    <?php if ($cliente): ?>
        <section>
            <h2>Cliente: <?php echo $cliente['nombrecompleto']; ?> (DNI: <?php echo $cliente['dni']; ?>)</h2>
            <p>Dirección: <?php echo $cliente['direccion']; ?> - Tel: <?php echo $cliente['telf']; ?></p>

            <h3>Vehículos del cliente</h3>
            <?php if (count($coches) === 0): ?>
                <p>Este cliente no tiene coches.</p>
            <?php else: ?>
                <table border="1">
                    <thead><tr><th>Matrícula</th><th>Marca</th><th>Modelo</th><th>Seleccionar</th></tr></thead>
                    <tbody>
                        <?php foreach ($coches as $c): ?>
                            <tr>
                                <td><?php echo $c['matricula']; ?></td>
                                <td><?php echo $c['marca']; ?></td>
                                <td><?php echo $c['modelo']; ?></td>
                                <td>
                                    <form method="post" action="/examen/public/registra.php" style="display:inline">
                                        <input type="hidden" name="accion" value="seleccionar_coche">
                                        <input type="hidden" name="matricula_seleccionada" value="<?php echo $c['matricula']; ?>">
                                        <button type="submit">Seleccionar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <form method="post" action="/examen/public/registra.php" style="margin-top:10px; display:inline">
                <input type="hidden" name="accion" value="nuevo_coche">
                <input type="hidden" name="dni_cliente" value="<?php echo $cliente['dni']; ?>">
                <button type="submit">Añadir coche nuevo</button>
            </form>
        </section>
    <?php endif; ?>

    <!-- formulario de registro del seleccionado o se ha pulsado nuevo -->
    <?php if ($cliente || $coche_seleccionado): ?>
        <section>
            <h2>Formulario de coche y tareas</h2>
            <form method="post" action="/examen/public/registra.php" >
                <input type="hidden" name="accion" value="registrar">
                <input type="hidden" name="dni_cliente" value="<?php echo $cliente['dni']; ?>">

                <fieldset>
                    <legend>Datos cliente</legend>
                    <label>Nombre completo: <input type="text" name="nombrecliente" value="<?php echo $cliente['nombrecompleto'] ?? ''; ?>" required></label><br>
                    <label>Dirección: <input type="text" name="direccioncliente" value="<?php echo $cliente['direccion'] ?? ''; ?>" required></label><br>
                    <label>Teléfono: <input type="text" name="telfcliente" value="<?php echo $cliente['telf'] ?? ''; ?>" required></label><br>
                </fieldset>

                <fieldset>
                    <legend>Datos coche</legend>
                    <label>Matrícula: <input type="text" name="matricula" value="<?php echo $coche_seleccionado['matricula'] ?? ''; ?>" required></label><br>
                    <label>Marca: <input type="text" name="marca" value="<?php echo $coche_seleccionado['marca'] ?? ''; ?>" required></label><br>
                    <label>Modelo: <input type="text" name="modelo" value="<?php echo $coche_seleccionado['modelo'] ?? ''; ?>" required></label><br>
                    <label>Kilometraje: <input type="number" name="km" value="<?php echo $coche_seleccionado['km'] ?? 0; ?>" required></label><br>
                    <label>Foto (JPG): <input type="file" name="foto" accept=".jpg"></label>
                    <?php if (!empty($coche_seleccionado['foto'])): ?>
                        <p>Foto actual: <img src="examen/public/coches<?php echo $coche_seleccionado['foto']; ?>" alt="foto" width="100"></p>
                    <?php endif; ?>
                </fieldset>

                <fieldset>
                    <legend>Tareas (seleccione al menos una)</legend>
                    <p>Mantenimiento</p>
                    <select name="tareas_mantenimiento[]" multiple size="5">
                        <?php foreach ($tareas_por_tipo['Mantenimiento'] as $t): ?>
                            <option value="<?php echo $t['id']; ?>"><?php echo $t['descripcion']; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <p>Reparación</p>
                    <select name="tareas_reparacion[]" multiple size="5">
                        <?php foreach ($tareas_por_tipo['Reparación'] as $t): ?>
                            <option value="<?php echo $t['id']; ?>"><?php echo $t['descripcion']; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <p>Electrónica</p>
                    <select name="tareas_electronica[]" multiple size="5">
                        <?php foreach ($tareas_por_tipo['Electrónica'] as $t): ?>
                            <option value="<?php echo $t['id']; ?>"><?php echo $t['descripcion']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </fieldset>

                <fieldset>
                    <legend>Mecánico responsable</legend>
                    <select name="mecanico_responsable" required>
                        <option value="">--Seleccione--</option>
                        <?php foreach ($mecanicos as $m): ?>
                            <option value="<?php echo $m['codigo']; ?>"><?php echo $m['nombrecompleto']; ?> (<?php echo $m['codigo']; ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </fieldset>

                <button type="submit">Registrar</button>
            </form>
        </section>
    <?php endif; ?>

</body>
</html>