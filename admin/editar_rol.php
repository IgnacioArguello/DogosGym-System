<?php
session_start();
require_once '../includes/verificar_rol.php';
require_once '../config/conexion.php';

verificar_rol('admin');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// No puede editar su propia cuenta
if ($id === (int)$_SESSION['id_usuario']) {
    header('Location: usuarios.php?error=1');
    exit;
}

$stmt = $pdo->prepare("SELECT id_usuario, nombre, rol FROM usuarios WHERE id_usuario = ?");
$stmt->execute([$id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    header('Location: usuarios.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dogos Gym - Editar Rol</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<div class="contenedor-form">
    <h1>Dogos Gym</h1>
    <h2>Gestión de Usuarios</h2>

    <p><strong>Usuario:</strong> <?php echo htmlspecialchars($usuario['nombre']); ?></p>
    <p><strong>Rol actual:</strong> <?php echo htmlspecialchars($usuario['rol']); ?></p>

    <form action="procesar_rol.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $usuario['id_usuario']; ?>">

        <label for="rol">Nuevo rol</label>
        <select id="rol" name="rol">
            <option value="admin"   <?php if ($usuario['rol'] === 'admin')   echo 'selected'; ?>>admin</option>
            <option value="usuario" <?php if ($usuario['rol'] === 'usuario') echo 'selected'; ?>>usuario</option>
        </select>

        <button type="submit">Guardar cambios</button>
    </form>

    <a href="usuarios.php">Volver al listado</a>
</div>

</body>
</html>