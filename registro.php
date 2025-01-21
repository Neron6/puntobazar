<!-- Formulario general-->
<!DOCTYPE html>
<html lang="es">
<header>
    <h1>Punto Bazar</h1>
    <h2>Sistema de gestión</h2>
</header>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuarios</title>
    <link rel="stylesheet" href="assets/css/registro.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
<div class="registro-container">
    <h2>Registro de Usuarios</h2>
    <form action="registro.php" method="POST" class="form-registro">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" placeholder="Nombre" id="nombre" required>

        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" placeholder="Contraseña" id="contrasena" required>

        <button type="submit" class="btn-registrar">Registrar</button>
    </form>
    <div class="link-login">
        <a href="login.php">¿Ya tienes cuenta? Inicia Sesión</a>
    </div>
</div>
</body>
    <footer>
        <h3>© 2025 Sistema de Gestión. Punto Bazar.</h3>
    </footer>
</html>



<!-- Lógica de programación en PHP-->

<?php
require 'conexion.php';

//Se establecen variables locales en el condicional, El if abarca toda la instrucción
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'] ?? null;
    $contrasena = $_POST['contrasena'];

    $passhash = password_hash($contrasena, PASSWORD_BCRYPT);

    //SQL. Se inserta al usuario
    $sql = "INSERT INTO usuarios (nombre, correo_electronico, contrasena) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sss", $nombre, $correo, $passhash);

    if ($stmt->execute()) {
        echo "Usuario registrado con exito.";
        header("Location: ../login.php");
        
    } else {
        echo "Error: " . $conexion->error;
    }

    $stmt->close();
    $conexion->close();
}
?>
