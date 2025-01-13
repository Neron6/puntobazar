<?php
session_start();  // Asegúrate de que la sesión esté iniciada

// Verificar si el usuario está logueado y si la variable 'nombre' existe
if (!isset($_SESSION['id']) || !isset($_SESSION['nombre'])) {
    // Si no está logueado, redirigir al login
    header("Location: login.php");
    exit();
}

$nombre_usuario = $_SESSION['nombre'];  // Asignar el nombre del usuario desde la sesión

require 'conexion.php';

// Obtener el número total de clientes registrados
$sql_clientes = "SELECT COUNT(*) AS total_clientes FROM clientes";
$resultado_clientes = $conexion->query($sql_clientes);

if ($resultado_clientes === false) {
    echo "Error en la consulta SQL: " . $conexion->error;
} else {
    $clientes_data = $resultado_clientes->fetch_assoc();
    $total_clientes = $clientes_data['total_clientes'];
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema de Clientes</title>
    <link rel="stylesheet" href="styles.css">  <!-- Asegúrate de tener una hoja de estilos -->
</head>
<body>
    <div class="container">
        <header>
            <h1>Bienvenido, <?php echo htmlspecialchars($nombre_usuario); ?>!</h1>
        </header>

        <section class="dashboard">
            <div class="card">
                <h2>Total de Clientes Registrados</h2>
                <p><?php echo $total_clientes; ?></p>
            </div>

            <div class="buttons">
                <a href="catalogo_usuarios.php" class="btn">Ver Catálogo de Clientes</a>
                <a href="logout.php" class="btn">Cerrar Sesión</a>
            </div>
        </section>
    </div>
</body>
</html>
