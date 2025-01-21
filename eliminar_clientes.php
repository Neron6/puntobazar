<?php
require 'conexion.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID de cliente no especificado.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Eliminar cliente
    $sql = "DELETE FROM clientes WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $mensaje = "Cliente eliminado con éxito.";
    } else {
        $error = "Error al eliminar cliente: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Cliente</title>
    <link rel="stylesheet" href="assets/css/eliminar_clientes.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <header class="main-header">
        <h1>Punto Bazar</h1>
        <h2>Sistema de Gestión</h2>
    </header>

    <div class="eliminar-container">
        <h2>Eliminar Cliente</h2>

        <?php if (isset($mensaje)): ?>
            <p class="success"> <?= htmlspecialchars($mensaje) ?> </p>
            <div class="acciones">
                <a href="catalogo_clientes.php" class="btn">Regresar al Catálogo</a>
            </div>
            <?php exit; ?>
        <?php elseif (isset($error)): ?>
            <p class="error"> <?= htmlspecialchars($error) ?> </p>
        <?php else: ?>
            <p class="warning">Esta acción no se puede deshacer. ¿Estás seguro de que deseas eliminar este cliente?</p>

            <form method="POST" action="" class="eliminar-form">
                <button type="submit" class="btn-danger" onclick="return confirm('Esta acción no se puede deshacer. ¿Estás seguro de eliminar este cliente?')">Eliminar</button>
                <a href="catalogo_clientes.php" class="btn">Cancelar</a>
            </form>
        <?php endif; ?>
    </div>

    <footer class="main-footer">
        <h3>© 2025 Sistema de Gestión. Punto Bazar.</h3>
    </footer>
</body>
</html>
