<?php ob_start(); ?>
<h1>Mis alquileres</h1>
<?php if(empty($rentals)): ?><p>No tienes alquileres activos.</p><?php else: ?>
<table class="table">
  <thead><tr><th>Juego</th><th>Fecha alquiler</th><th>Precio</th><th>Acciones</th></tr></thead>
  <tbody>
    <?php foreach($rentals as $r): ?>
    <tr>
      <td><?=htmlspecialchars($r['Nombre_juego'])?></td>
      <td><?=htmlspecialchars($r['Fecha_alquiler'])?></td>
      <td>€<?=htmlspecialchars($r['Precio'])?></td>
      <td><a class="btn small" href="/public/index.php?c=rental&a=ret&id=<?=urlencode($r['id'])?>">Devolver</a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>
<?php $content = ob_get_clean(); require __DIR__ . '/layout.php'; ?>
