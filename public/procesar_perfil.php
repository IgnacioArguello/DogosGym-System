<?php
session_start();
require_once '../config/conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../auth/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre    = trim($_POST['nombre']);
    $telefono  = trim($_POST['telefono']);
    $direccion = trim($_POST['direccion']);

    // Validar nombre obligatorio
    if (empty($nombre)) {
        header('Location: perfil.php?error=1');
        exit;
    }

    // Validar teléfono: solo números, entre 7 y 15 dígitos (si se ingresó)
    if (!empty($telefono) && !preg_match('/^[0-9]{7,15}$/', $telefono)) {
        header('Location: perfil.php?error=2');
        exit;
    }

    // Validar dirección: máximo 200 caracteres
    if (strlen($direccion) > 200) {
        header('Location: perfil.php?error=3');
        exit;
    }

    // Actualizar datos en la base de datos
    $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, telefono = ?, direccion = ? WHERE id_usuario = ?");
    $stmt->execute([$nombre, $telefono, $direccion, $_SESSION['id_usuario']]);

    // Actualizar nombre en la sesión
    $_SESSION['nombre'] = $nombre;

    header('Location: perfil.php?exito=1');
    exit;
} else {
    header('Location: perfil.php');
    exit;
}
?>