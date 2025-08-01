<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar Sesión - Aceicar</title>
  <link rel="stylesheet" href="estilos.css">
  <style>
    body {
      background-color: #111;
      color: white;
      font-family: 'Segoe UI', sans-serif;
    }
    main {
      max-width: 400px;
      margin: 60px auto;
      background: #1a1a1a;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(227, 6, 19, 0.3);
    }
    h2 {
      text-align: center;
      color: #e30613;
      margin-bottom: 25px;
    }
    input, button {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border-radius: 8px;
      border: none;
      background: #333;
      color: white;
    }
    button {
      background: #e30613;
      cursor: pointer;
      font-weight: bold;
    }
    button:hover {
      background: #b0000b;
    }
  </style>  
</head>
<body>
  <main>
    <h2>Iniciar Sesión</h2>
    <form action="php/validar_login.php" method="POST">
      <input type="email" name="correo" placeholder="Correo electrónico" required>
      <input type="password" name="clave" placeholder="Contraseña" required>
      <button type="submit">Ingresar</button>
    </form>
    <p style="text-align: center;">¿No tienes cuenta? <a href="register.html" style="color: #e30613;">Regístrate</a></p>
  </main>
</body>
</html>
