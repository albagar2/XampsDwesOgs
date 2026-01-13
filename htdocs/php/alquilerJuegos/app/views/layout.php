<?php
function h($s){ return htmlspecialchars($s, ENT_QUOTES); }
$user = $_SESSION['user'] ?? null;
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Alquiler Juegos</title>
  <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
<header class="nav">
  <div class="container">
    <a class="brand" href="/public/index.php?c=game&a=index">Alquiler Juegos</a>
    <nav>
      <a href="/public/index.php?c=game&a=index">Juegos</a>
      <?php if($user): ?>
        <a href="/public/index.php?c=rental&a=my">Mis alquileres</a>
        <?php if($user['Tipo']==='admin'): ?>
          <a href="/public/index.php?c=admin&a=list">Admin</a>
        <?php endif; ?>
        <a href="/public/index.php?c=auth&a=logout">Salir (<?=h($user['Nombre'])?>)</a>
      <?php else: ?>
        <a href="/public/index.php?c=auth&a=index">Entrar</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
<main class="container">
  <?php if(!empty($flash)): ?><div class="flash"><?=h($flash)?></div><?php endif; ?>
  <?= $content ?? '' ?>
</main>
<footer class="container footer">
  <small>Proyecto de ejemplo - Alquiler de juegos</small>
</footer>
</body>
</html>
