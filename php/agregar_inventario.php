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
  <title>Agregar Producto - Inventario</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      background-color: #111;
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      color: white;
    }

    main {
      max-width: 500px;
      margin: 60px auto;
      background: #1a1a1a;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.4);
    }

    h2 {
      color: #e30613;
      text-align: center;
      margin-bottom: 30px;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    form input[type="text"],
    form input[type="number"] {
      padding: 12px;
      border-radius: 8px;
      border: 1px solid #444;
      background-color: #222;
      color: white;
      font-size: 15px;
      transition: border 0.3s, box-shadow 0.3s;
    }

    form input:focus {
      outline: none;
      border-color: #e30613;
      box-shadow: 0 0 5px #e30613;
    }

    button[type="submit"] {
      background-color: #e30613;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 10px;
      font-weight: bold;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button[type="submit"]:hover {
      background-color: #b0000c;
    }

    a {
      color: #e30613;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }

    p {
      text-align: center;
      margin-top: 20px;
    }
  </style>
</head>
<body>

  <main>
    <h2>Agregar Producto al Inventario</h2>

    <form action="php/guardar_inventario.php" method="POST">
      <input type="text" name="producto" placeholder="Nombre del producto" required>
      <input type="text" name="tipo" placeholder="Tipo (aceite, filtro...)" required>
      <input type="number" name="cantidad" placeholder="Cantidad" min="1" required>
      <input type="number" name="precio" placeholder="Precio unitario (ej: 26900)" step="1" min="1" required>
      <button type="submit">Guardar</button>
    </form>

    <p>
      <a href="inventario.php">← Volver al Inventario</a>
    </p>
  </main>

</body>
</html>
