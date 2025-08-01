<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'cliente') {
    header("Location: login.php");
    exit;
}

$usuario = $_SESSION['usuario'];
$correo = $_SESSION['correo'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel del Cliente - Aceicar</title>
  <link rel="stylesheet" href="estilos.css">
  <style>
    body {
      background-color: #111;
      color: white;
      font-family: 'Segoe UI', sans-serif;
      padding: 40px;
    }

    .panel {
      max-width: 800px;
      margin: auto;
      background: #1a1a1a;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(227, 6, 19, 0.3);
    }

    h2 {
      color: #e30613;
      text-align: center;
    }

    .facturas {
      margin-top: 30px;
    }

    .factura-item {
      background: #222;
      padding: 15px;
      margin-bottom: 15px;
      border-radius: 10px;
    }

    .btn-cerrar {
      display: inline-block;
      margin-top: 30px;
      background: #e30613;
      color: white;
      padding: 10px 20px;
      border-radius: 8px;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="panel">
    <h2>Bienvenido, <?php echo htmlspecialchars($usuario); ?></h2>

    <div class="facturas">
      <h3>Facturas:</h3>
      <?php
      include "php/conexion.php";
      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

      $sql = "SELECT * FROM facturas WHERE correo = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $correo);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
        while ($factura = $result->fetch_assoc()) {
          echo "<div class='factura-item'>";
          echo "<strong>Factura ID:</strong> {$factura['id_facturas']}<br>";
          echo "<strong>Correo:</strong> {$factura['correo']}<br>";
          echo "<strong>Tipo de carro:</strong> {$factura['tipo_carro']}<br>";
          echo "<strong>Placa:</strong> {$factura['placa']}<br>";
          echo "<strong>Aceite:</strong> {$factura['aceite']}<br>";
          echo "<strong>Cantidad:</strong> {$factura['cantidad']}<br>";
          echo "<strong>Total:</strong> $" . number_format($factura['total'], 0, ',', '.') . "<br>";
          echo "<strong>Pago del cliente:</strong> $" . number_format($factura['pago_cliente'], 0, ',', '.') . "<br>";
          echo "<strong>Cambio devuelto:</strong> $" . number_format($factura['cambio'], 0, ',', '.') . "<br>"; 
          echo "<strong>Fecha:</strong> {$factura['fecha']}<br>";
          echo "<a href='php/generar_pdf.php?id={$factura['id_facturas']}' target='_blank'> Ver PDF</a>";
          echo "</div>";
        }
      } else {
        echo "<p>No tienes facturas registradas aún.</p>";
      }
      ?>
    </div>

    <a class="btn-cerrar" href="index.php">Cerrar Sesión</a>
  </div>
</body>
</html>


