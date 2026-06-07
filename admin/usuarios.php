<?php
session_start();
require_once '../includes/verificar_rol.php';
require_once '../config/conexion.php';

verificar_rol('admin');

header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Obtener todos los usuarios
$stmt = $pdo->query("SELECT id_usuario, nombre, email, rol, estado FROM usuarios ORDER BY nombre ASC");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dogos Gym - Gestión de Usuarios</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<div class="contenedor">
    <h1>Dogos Gym</h1>
    <h2>Gestión de Usuarios</h2>

    <?php if (isset($_GET['exito'])): ?>
        <p class="exito">Cambio realizado con éxito.</p>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <p class="error">
            <?php
            switch ($_GET['error']) {
                case '1': echo 'No podés modificar tu propia cuenta desde aquí.'; break;
                case '2': echo 'Rol inválido.'; break;
                default:  echo 'Ocurrió un error. Intentá de nuevo.';
            }
            ?>
        </p>
    <?php endif; ?>

    <table class="tabla-usuarios">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $u): ?>
            <tr>
                <td><?php echo htmlspecialchars($u['nombre']); ?></td>
                <td><?php echo htmlspecialchars($u['email']); ?></td>
                <td><?php echo htmlspecialchars($u['rol']); ?></td>
                <td><?php echo ucfirst($u['estado']); ?></td>
                <td>
                    <?php if ($u['id_usuario'] !== (int)$_SESSION['id_usuario']): ?>
                        <a href="editar_rol.php?id=<?php echo $u['id_usuario']; ?>" class="btn-tabla btn-editar">Editar rol</a>

                        <?php if ($u['estado'] === 'activo'): ?>
                            <button class="btn-tabla btn-danger"
                                onclick="abrirModal(<?php echo $u['id_usuario']; ?>, '<?php echo htmlspecialchars($u['nombre']); ?>', 'desactivar')">
                                Desactivar
                            </button>
                        <?php else: ?>
                            <button class="btn-tabla btn-success"
                                onclick="abrirModal(<?php echo $u['id_usuario']; ?>, '<?php echo htmlspecialchars($u['nombre']); ?>', 'reactivar')">
                                Reactivar
                            </button>
                        <?php endif; ?>
                    <?php else: ?>
                        <span style="color:#888; font-size:13px;">Tu cuenta</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br>
    <a href="../public/dashboard.php">Volver al inicio</a>
</div>

<!-- Modal de confirmación -->
<div id="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
     background:rgba(0,0,0,0.5); justify-content:center; align-items:center;">
    <div style="background:#fff; padding:30px; border-radius:8px; max-width:380px; width:90%; text-align:center;">
        <h3 id="modal-titulo" style="margin-bottom:15px;">¿Confirmar acción?</h3>
        <p id="modal-texto" style="margin-bottom:25px; color:#444;"></p>
        <form action="procesar_estado.php" method="POST">
            <input type="hidden" name="id" id="modal-id">
            <input type="hidden" name="accion" id="modal-accion">
            <div style="display:flex; gap:10px; justify-content:center;">
                <button type="button" onclick="cerrarModal()"
                    style="padding:10px 20px; background:#aaa; color:#fff; border:none; border-radius:4px; cursor:pointer;">
                    Cancelar
                </button>
                <button type="submit" id="modal-boton"
                    style="padding:10px 20px; color:#fff; border:none; border-radius:4px; cursor:pointer;">
                    Confirmar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function abrirModal(id, nombre, accion) {
    document.getElementById('modal-id').value = id;
    document.getElementById('modal-accion').value = accion;

    const boton = document.getElementById('modal-boton');
    if (accion === 'desactivar') {
        document.getElementById('modal-texto').innerText = '¿Desactivar a "' + nombre + '"? Esta acción puede revertirse.';
        boton.innerText = 'Desactivar';
        boton.style.background = '#cc0000';
    } else {
        document.getElementById('modal-texto').innerText = '¿Reactivar a "' + nombre + '"?';
        boton.innerText = 'Reactivar';
        boton.style.background = '#007700';
    }

    document.getElementById('modal').style.display = 'flex';
}

function cerrarModal() {
    document.getElementById('modal').style.display = 'none';
}
</script>

</body>
</html>