<?php
// db.php
$servername = "localhost";
$username = "root";       
$password = "";           // Contraseña en blanco por defecto en XAMPP
$dbname = "lab2_computo2";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
