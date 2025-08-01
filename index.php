<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Aceicar - Venta y Cambio de Aceite</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
  <style>
    
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #111;
      color: white;
      margin: 0;
      padding: 0;
    }

    
    header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background-color: #1a1a1a;
      padding: 20px 40px;
      border-bottom: 1px solid #333;
    }

    .logo {
      width: 150px;
      height: auto;
      animation: brilloRojo 3s ease-in-out infinite;
      transition: transform 0.6s ease, box-shadow 0.6s ease;
    }

    @keyframes brilloRojo {
      0%, 100% {
        box-shadow: 0 0 5px rgba(227, 6, 19, 0.4);
      }
      50% {
        box-shadow: 0 0 20px rgba(227, 6, 19, 0.9);
      }
    }

    .logo:hover {
      transform: scale(1.10);
      box-shadow: 0 0 25px rgba(227, 6, 19, 1);
    }

    .titulo {
      font-size: 28px;
      font-weight: 700;
      color: #e30613;
      flex: 1;
      text-align: center;
    }

    .botones-header a {
      margin-left: 20px;
      background-color: #e30613;
      color: white;
      padding: 10px 20px;
      text-decoration: none;
      font-weight: bold;
      border-radius: 12px;
      transition: background 0.3s ease, transform 0.2s ease;
    }

    .botones-header a:hover {
      background-color: #b05800;
      transform: scale(1.05);
    }

    
    .contenedor {
      padding: 40px;
      max-width: 1200px;
      margin: auto;
    }

    h2 {
      text-align: center;
      color: #e30613;
      margin-bottom: 40px;
    }

    .galeria {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 30px;
    }

    .item {
      background-color: #1e1e1e;
      padding: 15px;
      border-radius: 15px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .item img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 10px;
    }

    .item:hover {
      transform: scale(1.05);
      box-shadow: 0 0 10px rgba(255,255,255,0.2);
    }

    .item p {
      margin-top: 10px;
      font-size: 15px;
      color: #ccc;
    }

    
    @media (max-width: 768px) {
      header {
        flex-direction: column;
        align-items: flex-start;
      }

      .titulo {
        text-align: left;
        margin-top: 10px;
      }

      .botones-header {
        margin-top: 10px;
        width: 100%;
        display: flex;
        justify-content: flex-end;
      }

      .galeria {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>

  
  <header>
    <img src="logoaceicar2.png" alt="logoaceicar2" class="logo">
    <div class="titulo">ACEICAR - Venta y Cambio de Aceite</div>
    <div class="botones-header">
      <a href="login.php">Iniciar Sesión</a>
      <a href="register.html">Registrarse</a>
    </div>
  </header>

  
  <div class="contenedor">
    <h2>Productos Disponibles</h2>
    <div class="galeria">
      <div class="item">
        <img src="https://autopla1.b-cdn.net/wp-content/uploads/2020/09/MOBIL-SPECIAL-HD_SAE-50-Photoroom.jpg" alt="Aceite SAE 50 Mobil">
        <p>Aceite SAE 50 Mobil special HD cuarto</p>
        <p>$26,900</p>
      </div>
      <div class="item">
        <img src="https://autopla1.b-cdn.net/wp-content/uploads/2020/09/MOBIL-SPECIAL_25W-50-Photoroom.jpg" alt="Aceite 25W 50">
        <p>Aceite Mobil 25w 50 alto kilometraje – cuarto</p>
        <p>$27,900</p>
      </div>
      <div class="item">
        <img src="https://autopla1.b-cdn.net/wp-content/uploads/2024/07/10W-40-LUBRITEK-CUARTO_1-1-600x600.jpg" alt="Lubritek 10w40">
        <p>Aceite 10w 40 Lubritek – Cuarto</p>
        <p>$27,900</p>
      </div>
      <div class="item">
        <img src="https://autopla1.b-cdn.net/wp-content/uploads/2022/10/MOBIL-SUPER-2000_10W-30-Photoroom-1-600x600.jpg" alt="Mobil Super 10w30">
        <p>Aceite Mobil 10w 30 – Super 2000 – cuarto</p>
        <p>$30,900</p>
      </div>
      <div class="item">
        <img src="https://autopla1.b-cdn.net/wp-content/uploads/2023/09/Super_1000-20w-50.jpg" alt="Mobil Super 1000">
        <p>Mobil Super 1000 20w 50</p>
        <p>$30,900</p>
      </div>
      <div class="item">
        <img src="https://autopla1.b-cdn.net/wp-content/uploads/2025/02/601246AM-Mobil-Super-2000-5w30-600x600.webp" alt="Mobil 2000 5w30">
        <p>Mobil Super 2000 5w 30 CUARTO</p>
        <p>$31,900</p>
      </div>
      <div class="item">
        <img src="https://www.autoplanet.com.co/wp-content/uploads/2020/10/LUBULT-07-300x300.jpg" alt="Lubritek Ultimate">
        <p>Aceite 15W 40 Lubritek Ultimate – Cuarto</p>
        <p>$32,900</p>
      </div>
      <div class="item">
        <img src="https://www.autoplanet.com.co/wp-content/uploads/2020/10/MOBIL-SUPER-2000x1_10W-40-Photoroom-300x300.jpg" alt="Mobil 10w40">
        <p>Aceite 10w 40 Mobil 2000 – Cuarto</p>
        <p>$32,900</p>
      </div>
      <div class="item">
        <img src="https://www.autoplanet.com.co/wp-content/uploads/2020/09/600088AM_1_zqphd1-300x300.jpg" alt="Delvac 15w40">
        <p>Aceite Delvac 15w40 – Cuarto</p>
        <p>$34,900</p>
      </div>
      <div class="item">
        <img src="https://www.autoplanet.com.co/wp-content/uploads/2020/10/LUBEVO03-300x300.jpg" alt="Lubritek EVO">
        <p>Aceite 20W 50 Lubritek EVO – Cuarto</p>
        <p>$34,900</p>
      </div>
    </div>
  </div>

</body>
</html>
