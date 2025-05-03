<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Challenge - Home</title>
    <link rel="stylesheet" href="<?= base_url('css/index.css') ?>">
</head>

<body>
<div class="landing-container">
    <h1>Challenge - Login</h1>
    <?php if (isset($validation)): ?>
        <div style="color: red; margin-bottom: 20px;">
            <?= $validation->listErrors() ?>
        </div>
    <?php endif; ?>
    <form method="post" action="<?= base_url('login') ?>">
        <input type="text" name="username" id="username_input" class="landing-input" placeholder="Ingrese su usuario" required>
        <br>
        <input type="password" name="password" id="password_input" class="landing-input" placeholder="Ingrese su constraseña" required>
        <br>
        <button type="submit" class="landing-button">Entrar</button>
    </form>
</div>
</body>
<script>


    console.log('hola');


</script>
</html>