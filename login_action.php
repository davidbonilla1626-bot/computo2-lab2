<?php
// login_action.php
session_start();
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);

    if (empty($username)) {
        $_SESSION['error'] = "Por favor, escribe un nombre.";
        header("Location: index.php");
        exit;
    }

    $stmt = $conn->prepare("SELECT id, username FROM users WHERE username = ?");
    
    if (!$stmt) {
        $_SESSION['error'] = "Error de base de datos. ¿Importaste el archivo database.sql en phpMyAdmin? (Error: " . $conn->error . ")";
        header("Location: index.php");
        exit;
    }
    
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Si encuentra al usuario, se le da acceso directo sin comparar contraseñas
    if ($result->num_rows >= 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php");
        exit;
    } else {
        $_SESSION['error'] = "El usuario '$username' no existe en la base de datos.";
        header("Location: index.php");
        exit;
    }
} else {
    // Si no es POST, redirigir al login
    header("Location: index.php");
    exit;
}
?>
