<?php
// index.php
session_start();

// Si el usuario ya está logueado, redirigir al dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso - Laboratorio 2</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Registro de Datos</h2>
    <p style="text-align:center; color: var(--text-muted); margin-bottom: 1.5rem;">Ingresa tu nombre para comenzar</p>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="error-msg">
            <?php 
                echo htmlspecialchars($_SESSION['error']); 
                unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>

    <form action="login_action.php" method="POST">
        <div class="form-group">
            <label for="username">Nombre / Identificador</label>
            <input type="text" id="username" name="username" required autocomplete="off" placeholder="Ej: juan">
        </div>
        <button type="submit">Entrar al Sistema</button>
    </form>
</div>

</body>
</html>
