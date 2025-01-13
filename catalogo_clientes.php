<?php
session_start();
require 'conexion.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$nombre_usuario = $_SESSION['nombre'];  // Nombre del usuario logueado

// Preparar la consulta para obtener clientes, con filtros si se pasa algo desde el formulario de búsqueda
$where_conditions = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $buscar = $_POST['buscar'];
    
    // Si la búsqueda es por código de cliente
    if (is_numeric($buscar)) {
        $where_conditions = " WHERE codigo_cliente LIKE '%$buscar%'";
    }
    // Si la búsqueda es por nombre o apellido
    elseif (preg_match("/^[a-zA-Z ]*$/", $buscar)) {
        $where_conditions = " WHERE nombre LIKE '%$buscar%' OR apellido LIKE '%$buscar%'";
    }
    // Si la búsqueda es por teléfono
    elseif (is_numeric($buscar)) {
        $where_conditions = " WHERE telefono LIKE '%$buscar%'";
    }
}

// Obtener los clientes de la base de datos con los filtros
$sql_clientes = "SELECT * FROM clientes $where_conditions ORDER BY nombre ASC, apellido ASC";
$resultado_clientes = $conexion->query($sql_clientes);

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Clientes</title>
    <link rel="stylesheet" href="styles.css">  <!-- Asegúrate de tener una hoja de estilos -->
</head>
<body>
        <section class="search">
            <form method="POST" action="catalogo_usuarios.php">
                <input type="text" name="buscar" placeholder="Buscar por código, nombre, apellido o teléfono" />
                <button type="submit" class="btn">Buscar</button>
            </form>
        </section>

        <section class="buttons">
            <!-- Botón para ir al formulario de registro de nuevos clientes -->
            <a href="registrar_cliente.php" class="btn">Registrar Cliente</a>
        </section>

        <section class="catalogo">
    <table border="1">
        <thead>
            <tr>
                <th>Código Cliente</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Domicilio</th>
                <th>Teléfono</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Mostrar los resultados si hay registros
            if ($resultado_clientes->num_rows > 0) {
                while ($cliente = $resultado_clientes->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($cliente['codigo_cliente']) . "</td>";
                    echo "<td>" . htmlspecialchars($cliente['nombre']) . "</td>";
                    echo "<td>" . htmlspecialchars($cliente['apellido']) . "</td>";
                    echo "<td>" . htmlspecialchars($cliente['domicilio']) . "</td>";
                    echo "<td>" . htmlspecialchars($cliente['telefono']) . "</td>";
                    echo "<td>" . ($cliente['email'] ? htmlspecialchars($cliente['email']) : 'No disponible') . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No se encontraron resultados.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</section>
