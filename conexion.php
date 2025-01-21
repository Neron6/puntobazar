<?php
//datos del usuario para la conexión a la BD
//Se establecen variables de conexión

$host = "localhost"; //servidor de la base de datos
$usuario = "barba";
$password = "SqTsn6Qj";
$base_datos = "puntobazarv";

//Se crea la conexión. Se establece la variable de la conexión
$conexion = new mysqli($host, $usuario, $password, $base_datos);

//Verificar la conexión con condicional
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
} else {
    "Conexión exitosa.";
}
?>
