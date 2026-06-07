<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dogos Gym - Registro</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<div class="contenedor-form">
    <h1>Dogos Gym</h1>
    <h2>Crear cuenta</h2>

    <?php if (isset($_GET['error'])): ?>
        <p class="error">
            <?php
            switch($_GET['error']) {
                case '1': echo 'El email ya está registrado.'; break;
                case '2': echo 'La contraseña no cumple los requisitos mínimos.'; break;
                default:  echo 'Ocurrió un error. Intentá de nuevo.';
            }
            ?>
        </p>
    <?php endif; ?>

    <?php if (isset($_GET['exito'])): ?>
        <p class="exito">Registro exitoso. Ya podés iniciar sesión.</p>
    <?php endif; ?>

    <form action="procesar_registro.php" method="POST">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required>
        <small>Mínimo 8 caracteres, una mayúscula y un número.</small>

        <button type="submit">Registrarse</button>
    </form>

    <a href="login.php">¿Ya tenés cuenta? Iniciá sesión</a>
</div>

</body>
</html>