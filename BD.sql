CREATE DATABASE puntobazarv;

USE puntobazarv;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo_electronico VARCHAR (150) NULL,
    contraseña VARCHAR (255) NOT NULL
);
