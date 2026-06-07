<?php
session_start();
require_once '../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Buscar usuario en la base de datos
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ? AND estado = 'activo'");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar contraseña
    if ($usuario && password_verify($password, $usuario['password'])) {
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['nombre']     = $usuario['nombre'];
        $_SESSION['rol']        = $usuario['rol'];
        header('Location: ../public/dashboard.php');
        exit;
    } else {
        header('Location: login.php?error=1');
        exit;
    }
} else {
    header('Location: login.php');
    exit;
}
?>