<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dogos Gym - Iniciar Sesión</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<div class="contenedor-form">
    <h1>Dogos Gym</h1>
    <h2>Iniciar Sesión</h2>

    <?php if (isset($_GET['error'])): ?>
        <p class="error">Credenciales inválidas. Intentá de nuevo.</p>
    <?php endif; ?>

    <form action="procesar_login.php" method="POST">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Iniciar Sesión</button>
    </form>

    <a href="registro.php">¿No tenés cuenta? Registrate</a>
</div>

</body>
</html>