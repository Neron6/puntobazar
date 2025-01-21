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
        $where_conditions = " WHERE nombre LIKE '%$buscar%' OR apellido OR domicilio LIKE '%$buscar%'";
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
    <link rel="stylesheet" href="assets/css/catalogo_clientes.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <header class="main-header">
        <h1>Punto Bazar</h1>
        <h2>Sistema de Gestión</h2>
    </header>

    <section class="search">
        <form method="POST" action="catalogo_clientes.php" class="search-form">
            <input type="text" name="buscar" placeholder="Buscar por código, nombre, apellido o teléfono" />
            <button type="submit" class="btn">Buscar</button>
        </form>
    </section>

    <section class="buttons">
        <a href="registrar_cliente.php" class="btn">Registrar Cliente</a>
    </section>

    <section class="catalogo">
        <table class="responsive-table">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Domicilio</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultado_clientes->num_rows > 0) {
                    while ($cliente = $resultado_clientes->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($cliente['codigo_cliente']) . "</td>";
                        echo "<td>" . htmlspecialchars($cliente['nombre']) . "</td>";
                        echo "<td>" . htmlspecialchars($cliente['apellido']) . "</td>";
                        echo "<td>" . htmlspecialchars($cliente['domicilio']) . "</td>";
                        echo "<td>" . htmlspecialchars($cliente['telefono']) . "</td>";
                        echo "<td>" . ($cliente['email'] ? htmlspecialchars($cliente['email']) : 'No disponible') . "</td>";
                        echo "<td>
                                <a href='modificar_clientes.php?id=" . $cliente['id'] . "' class='link'>Modificar</a> |
                                <a href='eliminar_clientes.php?id=" . $cliente['id'] . "' class='link' onclick=\"return confirm('¿Estás seguro de eliminar este cliente?')\">Eliminar</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No se encontraron resultados.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>

    <section class="buttons bottom">
        <a href="dashboard.php" class="btn">Volver al Dashboard</a>
    </section>

    <footer class="main-footer">
        <h3>© 2025 Sistema de Gestión. Punto Bazar.</h3>
    </footer>
</body>
</html>
