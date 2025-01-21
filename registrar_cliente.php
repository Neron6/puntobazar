<?php
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo_cliente = strtoupper($_POST['codigo_cliente']); // Convertir a mayúsculas
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $domicilio = $_POST['domicilio'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'] ?? null;

    $sql = "INSERT INTO clientes (codigo_cliente, nombre, apellido, domicilio, telefono, email) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssssss", $codigo_cliente, $nombre, $apellido, $domicilio, $telefono, $email);

    if ($stmt->execute()) {
        $mensaje = "Cliente registrado con éxito.";
    } else {
        $error = "Error al registrar cliente: " . $stmt->error;
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
    <title>Registrar Cliente</title>
    <link rel="stylesheet" href="assets/css/registrar_cliente.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <header class="main-header">
        <h1>Punto Bazar</h1>
        <h2>Sistema de Gestión</h2>
    </header>

    <div class="registro-container">
        <h2>Registro de Clientes</h2>

        <?php if (isset($mensaje)): ?>
            <p class="success"> <?= htmlspecialchars($mensaje) ?> </p>
        <?php elseif (isset($error)): ?>
            <p class="error"> <?= htmlspecialchars($error) ?> </p>
        <?php endif; ?>

        <form method="POST" action="" class="registro-form">
            <label for="codigo_cliente">Código de Cliente:</label>
            <input type="text" name="codigo_cliente" id="codigo_cliente" placeholder="Código de Cliente" required>

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" placeholder="Nombre" required>

            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" id="apellido" placeholder="Apellido" required>

            <label for="domicilio">Domicilio:</label>
            <input type="text" name="domicilio" id="domicilio" placeholder="Domicilio" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" id="telefono" placeholder="Teléfono" required>

            <label for="email">Correo Electrónico (opcional):</label>
            <input type="email" name="email" id="email" placeholder="Correo Electrónico">

            <button type="submit" class="btn">Registrar Cliente</button>
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
