<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dogos Gym - Recuperar contraseña</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<div class="contenedor-form">
    <h1>Dogos Gym</h1>
    <h2>Recuperar contraseña</h2>

    <?php if (isset($_GET['error'])): ?>
        <p class="error">El email ingresado no está registrado.</p>
    <?php endif; ?>

    <?php if (isset($_GET['exito'])): ?>
        <p class="exito">Se generó el enlace de recuperación. 
        <a href="nueva_password.php?token=<?php echo $_GET['exito']; ?>">
            Hacer clic aquí para restablecer
        </a></p>
    <?php endif; ?>

    <form action="procesar_recuperar.php" method="POST">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <button type="submit">Enviar enlace</button>
    </form>

    <a href="login.php">Volver al inicio de sesión</a>
</div>

</body>
</html>