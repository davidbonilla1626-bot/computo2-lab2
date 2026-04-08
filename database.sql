-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS lab2_computo2;
USE lab2_computo2;

-- Crear tabla de usuarios
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NULL
);

-- Insertar un usuario por defecto
-- Ahora el login es SIN CONTRASEÑA, pero insertaremos un registro.
INSERT INTO users (username) VALUES ('fredy');
INSERT INTO users (username) VALUES ('david');

-- Crear tabla de productos (inventario / registro de datos)
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
