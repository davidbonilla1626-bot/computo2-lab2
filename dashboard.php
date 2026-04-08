<?php
// dashboard.php
session_start();
require_once 'db.php';

// Validar que el usuario haya hecho login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Obtener datos ordenados
$result = $conn->query("SELECT * FROM products ORDER BY name ASC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Registro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="dashboard-container">
    <div class="header">
        <h2>Registro Activo: <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
        <a href="logout.php" class="btn btn-danger">Salir</a>
    </div>

    <!-- Mensajes de estado -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="success-msg">
            <?php 
                echo htmlspecialchars($_SESSION['success']); 
                unset($_SESSION['success']);
            ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="error-msg">
            <?php 
                echo htmlspecialchars($_SESSION['error']); 
                unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>

    <!-- Formulario para ingresar nuevos datos -->
    <div style="background: white; padding: 1.5rem; border-radius: 8px; border: 1px solid var(--border); margin-bottom: 2rem;">
        <h3 style="margin-bottom: 1rem;">Agregar un nuevo registro</h3>
        <form action="save_data.php" method="POST" class="form-grid">
            <div class="form-group full-width">
                <label for="name">Nombre del Elemento</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group full-width">
                <label for="description">Descripción / Notas</label>
                <textarea id="description" name="description" rows="3" required></textarea>
            </div>

            <div class="form-group">
                <label for="quantity">Cantidad</label>
                <input type="number" id="quantity" name="quantity" min="1" required>
            </div>

            <div class="form-group">
                <label for="price">Valor ($)</label>
                <input type="number" id="price" name="price" min="0" step="0.01" required>
            </div>

            <div class="form-group full-width" style="margin-top: 1rem;">
                <button type="submit">Guardar Datos</button>
            </div>
        </form>
    </div>

    <!-- Tabla para mostrar datos ordenados -->
    <h3>Datos Registrados Recientes</h3>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Elemento</th>
                    <th>Notas</th>
                    <th>Cant.</th>
                    <th>Valor</th>
                    <th>Fecha Registro</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td>$<?php echo number_format($row['price'], 2); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($row['created_at'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted);">
                            No hay datos registrados aún.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
