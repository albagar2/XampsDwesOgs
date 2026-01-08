<?php ob_start(); ?>
<h1>Catálogo de juegos</h1>
<div class="grid">
<?php foreach($games as $g): ?>
  <article class="card">
    <a href="/public/index.php?c=game&a=detail&code=<?=urlencode($g['Codigo'])?>"><img src="/<?=h($g['Imagen'])?>" alt="<?=h($g['Nombre_juego'])?>"></a>
    <h3><?=h($g['Nombre_juego'])?></h3>
    <p class="muted"><?=h($g['Nombre_consola'])?> — <?=h($g['Anno'])?></p>
    <p class="price">€<?=h($g['Precio'])?></p>
    <a class="btn" href="/public/index.php?c=game&a=detail&code=<?=urlencode($g['Codigo'])?>">Ver detalles</a>
  </article>
<?php endforeach; ?>
</div>
<?php $content = ob_get_clean(); require __DIR__ . '/layout.php'; ?>
