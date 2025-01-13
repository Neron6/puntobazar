<?php
session_start();
require 'conexion.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$nombre_usuario = $_SESSION['nombre'];  // Nombre del usuario logueado

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo_cliente = $_POST['codigo_cliente'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $domicilio = $_POST['domicilio'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];  // Email es opcional

    // Consulta para insertar el nuevo cliente en la base de datos
    $sql = "INSERT INTO clientes (codigo_cliente, nombre, apellido, domicilio, telefono, email) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssssss", $codigo_cliente, $nombre, $apellido, $domicilio, $telefono, $email);

    if ($stmt->execute()) {
        echo "<p>Cliente registrado exitosamente.</p>";
    } else {
        echo "<p>Error al registrar el cliente: " . $conexion->error . "</p>";
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
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Registrar Cliente</h1>
        </header>

        <section class="form">
            <form method="POST" action="login.php">
                <label for="codigo_cliente">Código:</label>
                <input type="text" name="codigo_cliente" id="codigo_cliente" required>

                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" required>

                <label for="apellido">Apellido:</label>
                <input type="text" name="apellido" id="apellido" required>

                <label for="domicilio">Domicilio:</label>
                <input type="text" name="domicilio" id="domicilio" required>

                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefono" id="telefono" required>

                <label for="email">Email (opcional):</label>
                <input type="email" name="email" id="email">

                <button type="submit" class="btn">Registrar Cliente</button>
            </form>
        </section>
    </div>
</body>
</html>
