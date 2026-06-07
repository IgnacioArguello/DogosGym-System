<?php
session_start();
require_once '../includes/verificar_rol.php';
require_once '../config/conexion.php';

verificar_rol('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id     = (int)$_POST['id'];
    $accion = trim($_POST['accion']);

    // No puede modificar su propia cuenta
    if ($id === (int)$_SESSION['id_usuario']) {
        header('Location: usuarios.php?error=1');
        exit;
    }

    // Validar que la acción sea válida
    if (!in_array($accion, ['desactivar', 'reactivar'])) {
        header('Location: usuarios.php?error=3');
        exit;
    }

    $nuevo_estado = ($accion === 'desactivar') ? 'inactivo' : 'activo';

    $stmt = $pdo->prepare("UPDATE usuarios SET estado = ? WHERE id_usuario = ?");
    $stmt->execute([$nuevo_estado, $id]);

    header('Location: usuarios.php?exito=1');
    exit;
} else {
    header('Location: usuarios.php');
    exit;
}
?>