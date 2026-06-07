<?php
session_start();
require_once '../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    // Verificar si el email existe
    $stmt = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = ? AND estado = 'activo'");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        header('Location: recuperar_password.php?error=1');
        exit;
    }

    // Generar token único
    $token = bin2hex(random_bytes(32));
    $expira = date('Y-m-d H:i:s', strtotime('+15 minutes'));

    // Guardar token en la base de datos
    $stmt = $pdo->prepare("UPDATE usuarios SET token = ?, token_expira = ? WHERE email = ?");
    $stmt->execute([$token, $expira, $email]);

    header('Location: recuperar_password.php?exito=' . $token);
    exit;
} else {
    header('Location: recuperar_password.php');
    exit;
}
?>