<?php
session_start();
require_once '../config/conexion.php';

// Si no está logueado, redirigir al login
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../auth/login.php');
    exit;
}

header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Obtener datos actuales del usuario
$stmt = $pdo->prepare("SELECT nombre, email, telefono, direccion FROM usuarios WHERE id_usuario = ?");
$stmt->execute([$_SESSION['id_usuario']]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dogos Gym - Mi Perfil</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<div class="contenedor-form">
    <h1>Dogos Gym</h1>
    <h2>Mi Perfil</h2>

    <?php if (isset($_GET['exito'])): ?>
        <p class="exito">Perfil actualizado correctamente.</p>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <p class="error">
            <?php
            switch ($_GET['error']) {
                case '1': echo 'El nombre es obligatorio.'; break;
                case '2': echo 'El teléfono solo puede contener números (7 a 15 dígitos).'; break;
                case '3': echo 'La dirección no puede superar los 200 caracteres.'; break;
                default:  echo 'Ocurrió un error. Intentá de nuevo.';
            }
            ?>
        </p>
    <?php endif; ?>

    <form action="procesar_perfil.php" method="POST">

        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>

        <label for="telefono">Teléfono</label>
        <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($usuario['telefono'] ?? ''); ?>">

        <label for="direccion">Dirección</label>
        <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($usuario['direccion'] ?? ''); ?>">

        <label>Email</label>
        <input type="text" value="<?php echo htmlspecialchars($usuario['email']); ?>" disabled>
        <small>El email no puede modificarse.</small>

        <button type="submit">Guardar</button>
    </form>

    <a href="../public/dashboard.php">Volver al inicio</a>
</div>

<script src="../js/funciones.js"></script>
</body>
</html>