<?php ob_start(); function daysLate($fecha){ $due = (new DateTime($fecha))->modify('+7 days'); $now=new DateTime(); if($now>$due){ $diff=$now->diff($due); return $diff->days; } return 0; } ?>
<h1><?=htmlspecialchars($game['Nombre_juego'])?></h1>
<div class="detail">
  <img src="/<?=htmlspecialchars($game['Imagen'])?>" alt="<?=htmlspecialchars($game['Nombre_juego'])?>">
  <div class="meta">
    <p><strong>Consola:</strong> <?=htmlspecialchars($game['Nombre_consola'])?></p>
    <p><strong>Año:</strong> <?=htmlspecialchars($game['Anno'])?></p>
    <p><strong>Precio:</strong> €<?=htmlspecialchars($game['Precio'])?> (alquiler 1 semana)</p>
    <p><?=nl2br(htmlspecialchars($game['descripcion']))?></p>
    <?php if($rented): ?>
      <p class="bad">Actualmente alquilado.</p>
    <?php else: ?>
      <a class="btn" href="/public/index.php?c=rental&a=rent&code=<?=urlencode($game['Codigo'])?>">Alquilar</a>
    <?php endif; ?>
  </div>
</div>
<?php $content = ob_get_clean(); require __DIR__ . '/layout.php'; ?>
