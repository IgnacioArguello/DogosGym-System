<?php
session_start();
require_once '../config/conexion.php';

$token = $_GET['token'] ?? '';
$error = '';
$valido = false;

if ($token) {
    // Verificar que el token existe y no expiró
    $stmt = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE token = ? AND token_expira > NOW()");
    $stmt->execute([$token]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        $valido = true;
    } else {
        $error = 'El enlace expiró o no es válido.';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nueva_password = trim($_POST['password']);

    // Validar contraseña
    if (!preg_match('/^(?=.*[A-Z])(?=.*[0-9]).{8,}$/', $nueva_password)) {
        $error = 'La contraseña no cumple los requisitos mínimos.';
    } else {
        $hash = password_hash($nueva_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE usuarios SET password = ?, token = NULL, token_expira = NULL WHERE token = ?");
        $stmt->execute([$hash, $token]);

        header('Location: login.php?exito=1');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dogos Gym - Nueva contraseña</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<div class="contenedor-form">
    <h1>Dogos Gym</h1>
    <h2>Nueva contraseña</h2>

    <?php if ($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if ($valido): ?>
    <form action="" method="POST">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

        <label for="password">Nueva contraseña</label>
        <input type="password" id="password" name="password" required>
        <small>Mínimo 8 caracteres, una mayúscula y un número.</small>

        <button type="submit">Guardar nueva contraseña</button>
    </form>
    <?php endif; ?>

    <a href="login.php">Volver al inicio de sesión</a>
</div>

</body>
</html>