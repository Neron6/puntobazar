<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Gestión</title>
    <link rel="stylesheet" href="assets/css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <header class="main-header">
        <h1>Punto Bazar</h1>
        <h2>Sistema de Gestión</h2>
    </header>

    <div class="container login-container">
        <h2>Iniciar Sesión</h2>

        <?php if (isset($error)): ?>
            <p class="error"> <?= htmlspecialchars($error) ?> </p>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="nombre">Nombre de Usuario:</label>
            <input type="text" name="nombre" id="nombre" placeholder="Nombre de usuario" required>

            <label for="contrasena">Contraseña:</label>
            <input type="password" name="contrasena" id="contrasena" placeholder="Contraseña" required>

            <button type="submit" class="button">Iniciar Sesión</button>
        </form>

        <div class="acciones">
            <a href="registro.php">¿No tienes cuenta? Regístrate</a>
        </div>
    </div>

    <footer class="main-footer">
        <h3>© 2025 Sistema de Gestión. Punto Bazar.</h3>
    </footer>
</body>
</html>

<?php
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'] ?? null; // Puede ser null si no se proporciona
    $nombre = $_POST['nombre']; // Nombre del usuario como campo obligatorio
    $contrasena = $_POST['contrasena'];

    // Verificar si el usuario ingresó un correo
    if ($correo) {
        // Buscar al usuario por correo
        $sql = "SELECT id, nombre, contrasena FROM usuarios WHERE correo = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $correo);
    } else {
        // Buscar al usuario por nombre
        $sql = "SELECT id, nombre, contrasena FROM usuarios WHERE nombre = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $nombre);
    }

    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($contrasena, $usuario['contrasena'])) {
            session_start();
            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }

    $stmt->close();
    $conexion->close();
}
?>
