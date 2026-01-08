<?php ob_start(); $isEdit = !empty($game); ?>
<h1><?= $isEdit ? 'Editar' : 'Nuevo' ?> juego</h1>
<form method="post" class="form">
  <label>Código <input name="Codigo" required value="<?=htmlspecialchars($game['Codigo'] ?? '')?>" <?= $isEdit ? 'readonly' : ''?>></label>
  <label>Nombre <input name="Nombre_juego" required value="<?=htmlspecialchars($game['Nombre_juego'] ?? '')?>"></label>
  <label>Consola <input name="Nombre_consola" required value="<?=htmlspecialchars($game['Nombre_consola'] ?? '')?>"></label>
  <label>Año <input name="Anno" type="number" required value="<?=htmlspecialchars($game['Anno'] ?? '')?>"></label>
  <label>Precio <input name="Precio" type="number" required value="<?=htmlspecialchars($game['Precio'] ?? '')?>"></label>
  <label>Alguilado (SI/NO) <input name="Alguilado" value="<?=htmlspecialchars($game['Alguilado'] ?? 'NO')?>"></label>
  <label>Imagen (ruta) <input name="Imagen" value="<?=htmlspecialchars($game['Imagen'] ?? '')?>"></label>
  <label>Descripción <textarea name="descripcion"><?=htmlspecialchars($game['descripcion'] ?? '')?></textarea></label>
  <div class="actions"><button class="btn">Guardar</button></div>
</form>
<?php $content = ob_get_clean(); require __DIR__ . '/../layout.php'; ?>
