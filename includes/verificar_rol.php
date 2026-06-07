<?php
/**
 * Verifica que el usuario esté logueado y tenga el rol requerido.
 * Si no cumple, redirige según el caso.
 *
 * @param string $rol_requerido  'admin' o 'usuario'
 */
function verificar_rol($rol_requerido = 'admin') {
    if (!isset($_SESSION['id_usuario'])) {
        header('Location: ../auth/login.php');
        exit;
    }
 
    if ($_SESSION['rol'] !== $rol_requerido) {
        header('Location: ../public/acceso_denegado.php');
        exit;
    }
}
?>