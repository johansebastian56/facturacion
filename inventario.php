<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], ['empleado', 'admin'])) {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Inventario - Aceicar</title>
  <link rel="stylesheet" href="estilos.css">
  <style>
    body {
      background: #111;
      color: white;
      font-family: 'Segoe UI', sans-serif;
      padding: 30px;
    }
    .panel {
      max-width: 900px;
      margin: auto;
      background: #1a1a1a;
      padding: 20px;
      border-radius: 15px;
      box-shadow: 0 0 10px #e30613;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      border: 1px solid #444;
      padding: 10px;
      text-align: center;
    }
    th {
      background: #e30613;
      color: white;
    }
    a.btn {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      background: #e30613;
      color: white;
      border-radius: 8px;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="panel">
    <h2>Inventario - Bienvenido <?php echo $_SESSION['usuario']; ?></h2>
    

    <table>
      <tr>
        <th>ID</th>
        <th>Producto</th>
        <th>Tipo</th>
        <th>Cantidad</th>
        <th>Precio</th>
        <th>Fecha</th>
      </tr>

      <?php
      include "php/conexion.php";
      $resultado = $conn->query("SELECT * FROM inventario ORDER BY fecha DESC");

      while ($fila = $resultado->fetch_assoc()) {
          echo "<tr>
                  <td>{$fila['id_inventario']}</td>
                  <td>{$fila['producto']}</td>
                  <td>{$fila['tipo']}</td>
                  <td>{$fila['cantidad']}</td>
                  <td>$ " . number_format($fila['precio'], 0, ',', '.') . "</td>
                  <td>{$fila['fecha']}</td>
                </tr>";
      }
      ?>
    </table>
  </div>
</body>
</html>
