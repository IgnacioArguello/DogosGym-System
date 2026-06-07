<?php
session_start();
require_once '../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre   = trim($_POST['nombre']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validar contraseña: mínimo 8 caracteres, una mayúscula y un número
    if (!preg_match('/^(?=.*[A-Z])(?=.*[0-9]).{8,}$/', $password)) {
        header('Location: registro.php?error=2');
        exit;
    }

    // Verificar si el email ya existe
    $stmt = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        header('Location: registro.php?error=1');
        exit;
    }

    // Encriptar contraseña y guardar usuario
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$nombre, $email, $hash]);

    header('Location: registro.php?exito=1');
    exit;
} else {
    header('Location: registro.php');
    exit;
}
?>