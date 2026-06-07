<?php
session_start();
require_once '../includes/verificar_rol.php';
require_once '../config/conexion.php';

verificar_rol('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id  = (int)$_POST['id'];
    $rol = trim($_POST['rol']);

    // No puede modificar su propia cuenta
    if ($id === (int)$_SESSION['id_usuario']) {
        header('Location: usuarios.php?error=1');
        exit;
    }

    // Validar que el rol sea válido
    $roles_validos = ['admin', 'usuario'];
    if (!in_array($rol, $roles_validos)) {
        header('Location: usuarios.php?error=2');
        exit;
    }

    $stmt = $pdo->prepare("UPDATE usuarios SET rol = ? WHERE id_usuario = ?");
    $stmt->execute([$rol, $id]);

    header('Location: usuarios.php?exito=1');
    exit;
} else {
    header('Location: usuarios.php');
    exit;
}
?>