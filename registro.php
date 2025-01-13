<!-- Formulario general-->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <h2>Registro de Usuarios</h2>
    <form action="registro.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" placeholder="Nombre" id="nombre" required>

        <label for="correo">Email (opcional):</label>
        <input type="email" name="correo" placeholder="Email" id="correo">

        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" placeholder="Contraseña" id="contrasena" required>

        <button type="submit">Registrar</button>
    </form>
    <a href="login.php">¿Ya tienes cuenta? Inicia Sesión</a>
</body>
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
