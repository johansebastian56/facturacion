<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$seccion = $_GET['seccion'] ?? 'facturacion';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel Administrador - Aceicar</title>
  <link rel="stylesheet" href="estilos.css">
  <style>
    body {
      margin: 0;
      min-height: 100vh;
      display: flex;
      font-family: Arial, sans-serif;
    }
    .sidebar {
      width: 220px;
      background: #1a1a1a;
      color: white;
      height: 350hv;
      padding: 20px;
      box-sizing: border-box;
    }
    .sidebar h2 {
      color: #e30613;
      text-align: center;
      margin-bottom: 30px;
    }
    .sidebar a {
      display: block;
      padding: 10px;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      margin-bottom: 10px;
      background: #333;
    }
    .sidebar a:hover {
      background: #e30613;
    }
    .content {
      flex: 1;
      padding: 30px;
      background: #000000ff;
      overflow-y: auto;
    }
    label{
      color:white;
    }
    #cambio_texto {
  color: white;
  font-weight: bold;
}

  </style>
</head>
<body>

  <div class="sidebar">
    <h2>Admin</h2>
    <a href="?seccion=facturacion"> Facturar</a>
    <a href="?seccion=inventario"> Ver Inventario</a>
    <a href="?seccion=agregar_inventario"> Agregar Inventario</a>
    <a href="?seccion=registro_ventas"> Ventas</a>
    <a href="?seccion=ventas_empleados"> Ventas por Empleado</a>
    <a href="?seccion=editar_factura"> Editar/Eliminar Facturas</a>
    <a href="?seccion=editar_inventario"> Editar/Eliminar Inventario</a>
    <a href="index.php"> Cerrar Sesión</a>
  </div>

  <div class="content">
    <?php
    if ($seccion === 'facturacion') {
        include "php/form_factura.php";

    } elseif ($seccion === 'inventario') {
        include "inventario.php";

    } elseif ($seccion === 'agregar_inventario') {
        include "php/agregar_inventario.php";

    } elseif ($seccion === 'registro_ventas') {
        include "php/ventas.php";

    } elseif ($seccion === 'ventas_empleados') {
        include "php/ventas_empleado.php"; 

    } elseif ($seccion === 'editar_factura') {
        include "php/editar_factura.php"; 

    } elseif ($seccion === 'editar_inventario') {
        include "php/editar_inventario.php"; 

    } else {
        echo "<h3>Sección no encontrada.</h3>";
    }
    ?>
  </div>

</body>
</html>
