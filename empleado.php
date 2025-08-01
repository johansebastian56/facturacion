<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'empleado') {
    header("Location: login.php");
    exit;
}

$nombre = $_SESSION['usuario'];
$seccion = $_GET['seccion'] ?? 'inicio';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel del Empleado - Aceicar</title>
  <link rel="stylesheet" href="estilos.css">
  <style>
    body {
      display: flex;
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #111;
      color: white;
    }

    aside {
      width: 220px;
      background: #1a1a1a;
      height: 100vh;
      padding: 20px;
      box-shadow: 2px 0 10px rgba(0,0,0,0.2);
    }

    aside h2 {
      color: #e30613;
      text-align: center;
    }

    .menu a {
      display: block;
      background-color: #e30613;
      color: white;
      padding: 12px;
      text-align: center;
      margin: 10px 0;
      border-radius: 6px;
      text-decoration: none;
      font-weight: bold;
    }

    .menu a:hover {
      background-color: #b0000b;
    }

    main {
      flex: 1;
      padding: 40px;
    }

    .bienvenida {
      text-align: center;
    }

    .bienvenida img {
      max-width: 1000px;
      margin-top: 10px;
      border-radius: 48px;
    }
  </style>
</head>
<body>
  <aside>
    <h2>ACEICAR</h2>
    <div class="menu">
      <a href="?seccion=inicio">Inicio</a>
      <a href="?seccion=facturacion">Facturación</a>
      <a href="?seccion=inventario">Inventario</a>
      <a href="?seccion=agregar_inventario">Agregar Inventario</a>
      <a href="?seccion=registro_ventas">Registro de ventas</a>

      <a href="index.php">Cerrar sesión</a>
    </div>
  </aside>

  <main>
    <?php if ($seccion === 'inicio'): ?>
      <div class="bienvenida">
        <h2>Bienvenido, <?php echo htmlspecialchars($nombre); ?></h2>
        <p>Selecciona una opción del menú para comenzar.</p>
        <img src="https://i.gifer.com/19q1.gif" alt="Bienvenida">
      </div>

    <?php elseif ($seccion === 'facturacion'): ?>
      <?php include "php/form_factura.php"; ?>

    <?php elseif ($seccion === 'inventario'): ?>
      <?php include "inventario.php"; ?>

    <?php elseif ($seccion === 'agregar_inventario'): ?>
      <?php include "php/agregar_inventario.php"; ?>
      
      <?php elseif ($seccion === 'registro_ventas'): ?>
        <?php include "php/ventas.php"; ?>



    <?php else: ?>
      <p>Sección no encontrada.</p>
    <?php endif; ?>
  </main>
</body>
</html>

