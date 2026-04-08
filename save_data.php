<?php
// save_data.php
session_start();
require_once 'db.php';

// Validar inicio de sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar los datos ingresados
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $quantity = trim($_POST['quantity']);
    $price = trim($_POST['price']);

    if (empty($name) || empty($description) || $quantity === "" || $price === "") {
        $_SESSION['error'] = "Todos los campos son obligatorios.";
        header("Location: dashboard.php");
        exit;
    }

    if (!is_numeric($quantity) || $quantity < 1) {
        $_SESSION['error'] = "La cantidad debe ser un número mayor o igual a 1.";
        header("Location: dashboard.php");
        exit;
    }

    if (!is_numeric($price) || $price < 0) {
        $_SESSION['error'] = "El precio debe ser un número mayor a 0.";
        header("Location: dashboard.php");
        exit;
    }

    // Insertar en la base de datos
    $stmt = $conn->prepare("INSERT INTO products (name, description, quantity, price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssid", $name, $description, $quantity, $price);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Los datos han sido guardados y validados correctamente.";
    } else {
        $_SESSION['error'] = "Ocurrió un error al guardar los datos.";
    }

    $stmt->close();
    header("Location: dashboard.php");
    exit;

} else {
    header("Location: dashboard.php");
    exit;
}
?>
