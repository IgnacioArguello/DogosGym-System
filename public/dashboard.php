<?php
session_start();

// Si no está logueado, redirigir al login
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../auth/login.php');
    exit;
}

// Evitar que el navegador guarde la página en caché
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dogos Gym - Panel Principal</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<div class="contenedor">
    <h1>Dogos Gym</h1>
    <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?></h2>
    <p>Panel principal del sistema.</p>
    <a href="../auth/logout.php">Cerrar sesión</a>
</div>

</body>
</html>