CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,        
    codigo_cliente VARCHAR(20) NOT NULL,        
    nombre VARCHAR(100) NOT NULL,               
    apellido VARCHAR(100) NOT NULL,             
    domicilio TEXT NOT NULL,                    
    telefono VARCHAR(15),                       
    email VARCHAR(150),                         
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
);
