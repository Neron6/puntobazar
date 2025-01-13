<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <h2>Inicio de Sesión</h2>
    <form action="login.php" method="POST">
     <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" placeholder="Nombre" id="correo" required>

     <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" placeholder="Contraseña" id="contrasena" required>

        <button type="submit">Iniciar Sesión</button>
    </form>
        <a href="registro.php">¿No tienes cuenta? Crea Una</a>
</body>
</html>

<?php
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];          // Correo proporcionado por el usuario
    $contrasena = $_POST['contrasena'];  // Contraseña proporcionada por el usuario

    // Verificar si el correo existe en la base de datos
    $sql = "SELECT id, nombre, contrasena FROM usuarios WHERE correo_electronico = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // Obtener datos del usuario
        $usuario = $resultado->fetch_assoc();
        $nombre = $usuario['nombre'];  // Extraer el nombre del usuario

        // Verificar la contraseña
        if (password_verify($contrasena, $usuario['contrasena'])) {
            // Inicio de sesión exitoso
            session_start();
            $_SESSION['id'] = $usuario['id'];       // Guardar el ID del usuario en sesión
            $_SESSION['nombre'] = $nombre;          // Guardar el nombre del usuario en sesión

            // Redirigir al usuario a la página principal
            header("Location: dashboard.php");
            exit();
        } else {
            // Contraseña incorrecta
            echo "Contraseña incorrecta.";
        }
    } else {
        // Correo no registrado
        echo "El correo electrónico no está registrado.";
    }

    $stmt->close();
    $conexion->close();
}
?>
