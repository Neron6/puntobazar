<?php
require 'conexion.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID de cliente no especificado.");
}

// Obtener los datos actuales del cliente
$sql = "SELECT * FROM clientes WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    die("Cliente no encontrado.");
}

$cliente = $resultado->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo_cliente = strtoupper($_POST['codigo_cliente']); // Convertir a mayúsculas
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $domicilio = $_POST['domicilio'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'] ?? null;

    $sql = "UPDATE clientes SET codigo_cliente = ?, nombre = ?, apellido = ?, domicilio = ?, telefono = ?, email = ? WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssssssi", $codigo_cliente, $nombre, $apellido, $domicilio, $telefono, $email, $id);

    if ($stmt->execute()) {
        $mensaje = "Cliente actualizado con éxito.";
    } else {
        $error = "Error al actualizar cliente: " . $stmt->error;
    }
}

$stmt->close();
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Cliente</title>
    <link rel="stylesheet" href="assets/css/modificar_clientes.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <header class="main-header">
        <h1>Punto Bazar</h1>
        <h2>Sistema de Gestión</h2>
    </header>

    <div class="modificar-container">
        <h2>Modificar Cliente</h2>

        <?php if (isset($mensaje)): ?>
            <p class="success"> <?= htmlspecialchars($mensaje) ?> </p>
        <?php elseif (isset($error)): ?>
            <p class="error"> <?= htmlspecialchars($error) ?> </p>
        <?php endif; ?>

        <form method="POST" action="" class="modificar-form">
            <label for="codigo_cliente">Código de Cliente:</label>
            <input type="text" name="codigo_cliente" id="codigo_cliente" value="<?= htmlspecialchars($cliente['codigo_cliente']) ?>" style="text-transform: uppercase;" required>

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($cliente['nombre']) ?>" required>

            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" id="apellido" value="<?= htmlspecialchars($cliente['apellido']) ?>" required>

            <label for="domicilio">Domicilio:</label>
            <input type="text" name="domicilio" id="domicilio" value="<?= htmlspecialchars($cliente['domicilio']) ?>" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" id="telefono" value="<?= htmlspecialchars($cliente['telefono']) ?>" required>

            <label for="email">Correo Electrónico (opcional):</label>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($cliente['email']) ?>">

            <button type="submit" class="btn" onclick="return confirm('¿Estás seguro de actualizar los datos del cliente?')">Actualizar</button>
        </form>

        <div class="acciones">
            <a href="catalogo_clientes.php" class="btn">Regresar al Catálogo</a>
        </div>
    </div>

    <footer class="main-footer">
        <h3>© 2025 Sistema de Gestión. Punto Bazar.</h3>
    </footer>
</body>
</html>
