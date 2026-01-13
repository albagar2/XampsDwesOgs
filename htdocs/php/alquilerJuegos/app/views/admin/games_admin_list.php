<?php ob_start(); ?>
<h1>Administración de juegos</h1>
<p><a class="btn" href="/public/index.php?c=admin&a=add">Añadir juego</a></p>
<table class="table">
  <thead><tr><th>Código</th><th>Nombre</th><th>Consola</th><th>Año</th><th>Precio</th><th>Acciones</th></tr></thead>
  <tbody>
    <?php foreach($games as $g): ?>
    <tr>
      <td><?=htmlspecialchars($g['Codigo'])?></td>
      <td><?=htmlspecialchars($g['Nombre_juego'])?></td>
      <td><?=htmlspecialchars($g['Nombre_consola'])?></td>
      <td><?=htmlspecialchars($g['Anno'])?></td>
      <td>€<?=htmlspecialchars($g['Precio'])?></td>
      <td>
        <a class="btn small" href="/public/index.php?c=admin&a=edit&code=<?=urlencode($g['Codigo'])?>">Editar</a>
        <a class="btn small danger" href="/public/index.php?c=admin&a=delete&code=<?=urlencode($g['Codigo'])?>" onclick="return confirm('¿Borrar?')">Borrar</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php $content = ob_get_clean(); require __DIR__ . '/layout.php'; ?>
