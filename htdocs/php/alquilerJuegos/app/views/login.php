<?php ob_start(); ?>
<h1>Iniciar sesión</h1>
<?php if(!empty($error)): ?><div class="error"><?=htmlspecialchars($error)?></div><?php endif; ?>
<form method="post" action="/public/index.php?c=auth&a=login" class="form">
  <label>DNI <input name="dni" required></label>
  <label>Contraseña <input name="pass" type="password" required></label>
  <div class="actions">
    <button class="btn">Entrar</button>
  </div>
</form>
<?php $content = ob_get_clean(); require __DIR__ . '/layout.php'; ?>
