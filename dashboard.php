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
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <header class="main-header">
        <h1>Punto Bazar</h1>
        <h2>Sistema de Gestión</h2>
    </header>

    <div class="container">
        <h2>Bienvenido, <?= htmlspecialchars($nombre_usuario); ?>!</h2>

        <div class="dashboard-card">
            <h3>Total de Clientes Registrados</h3>
            <p class="number"><?= htmlspecialchars($total_clientes); ?></p>
        </div>

        <div class="acciones">
            <a href="catalogo_clientes.php" class="button">Ver Catálogo de Clientes</a>
            <a href="logout.php" class="button button-danger">Cerrar Sesión</a>
        </div>
    </div>

    <footer class="main-footer">
        <h3>© 2025 Sistema de Gestión. Punto Bazar.</h3>
    </footer>
</body>
</html>
