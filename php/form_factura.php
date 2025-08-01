<?php include "php/conexion.php"; ?>

<h2 style="text-align:center; color:#e30613;">Crear Factura</h2>

<form action="php/guardar_factura.php" method="POST" id="factura-form" style="max-width:600px; margin:auto; display:flex; flex-direction:column; gap:10px; background:#1a1a1a; padding:30px; border-radius:12px; box-shadow:0 0 20px rgba(0,0,0,0.3);">

  <style>
    form label {
      color: #fff;
      font-weight: bold;
      margin-top: 10px;
    }

    form select,
    form input[type="text"],
    form input[type="number"] {
      padding: 10px;
      border-radius: 8px;
      border: 1px solid #555;
      background-color: #222;
      color: white;
      font-size: 15px;
    }

    form select:focus,
    form input:focus {
      outline: none;
      border-color: #e30613;
      box-shadow: 0 0 5px #e30613;
    }

    button[type="submit"],
    button[type="button"] {
      background-color: #e30613;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 10px;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button[type="submit"]:hover,
    button[type="button"]:hover {
      background-color: #b0000c;
    }

    #cambio_texto {
      color: #0f0;
      font-weight: bold;
    }
  </style>

  <!-- Cliente -->
  <label>Cliente:</label>
  <select name="correo" required>
    <option value="">Selecciona un cliente</option>
    <?php
    $clientes = $conn->query("SELECT correo, nombre FROM usuarios WHERE rol = 'cliente'");
    while ($cliente = $clientes->fetch_assoc()) {
      echo "<option value=\"{$cliente['correo']}\">{$cliente['nombre']} ({$cliente['correo']})</option>";
    }
    ?>
  </select>

  <!-- Vehículo -->
  <label>Tipo de carro:</label>
  <input type="text" name="tipo_carro" required>

  <label>Placa del vehículo:</label>
  <input type="text" name="placa" required>

  <!-- Aceite -->
  <label>Producto (Aceite):</label>
  <select name="producto_aceite" id="producto_aceite" required onchange="actualizarTotal()">
    <option value="">Selecciona producto</option>
    <?php
    $productos = $conn->query("SELECT producto, tipo, precio FROM inventario WHERE cantidad > 0");
    while ($row = $productos->fetch_assoc()) {
      $val = "{$row['producto']}|{$row['tipo']}|{$row['precio']}";
      echo "<option value=\"$val\">{$row['producto']} ({$row['tipo']}) - $" . number_format($row['precio'], 0, ',', '.') . "</option>";
    }
    ?>
  </select>

  <label>Cantidad:</label>
  <input type="number" name="cantidad" id="cantidad" value="1" min="1" onchange="actualizarTotal()" required>

  <!-- Total automático -->
  <label>Total a pagar:</label>
  <input type="text" id="precio_visible" readonly>
  <input type="hidden" name="precio" id="precio">

  <!-- Método de pago -->
  <label>Método de pago:</label>
  <select name="metodo_pago" id="metodo_pago" required onchange="togglePagoCliente()">
    <option value="">Seleccione método</option>
    <option value="Efectivo">Efectivo</option>
    <option value="Nequi">Nequi</option>
    <option value="Daviplata">Daviplata</option>
    <option value="Bancolombia">Bancolombia</option>
  </select>

  <!-- Pago efectivo -->
  <div id="pago-efectivo" style="display:none;">
    <label>Pago del cliente:</label>
    <input type="number" step="1000" name="pago_cliente" id="pago_cliente">
    <button type="button" onclick="calcularCambio()">Calcular Cambio</button>
    <p id="cambio_texto"></p>
  </div>

  <input type="hidden" name="cambio" id="cambio_final" value="0">
  <input type="hidden" name="fecha" value="<?php echo date('Y-m-d'); ?>">

  <button type="submit">Registrar Factura</button>
</form>

<script>
function togglePagoCliente() {
  const metodo = document.getElementById("metodo_pago").value;
  const pagoDiv = document.getElementById("pago-efectivo");
  pagoDiv.style.display = (metodo === "Efectivo") ? "block" : "none";
  if (metodo !== "Efectivo") {
    document.getElementById("pago_cliente").value = "";
    document.getElementById("cambio_texto").innerText = "";
  }
}

function calcularCambio() {
  const total = parseFloat(document.getElementById("precio").value) || 0;
  const pago = parseFloat(document.getElementById("pago_cliente").value) || 0;
  const cambio = pago - total;
  document.getElementById("cambio_texto").innerText = "Cambio: $" + cambio.toLocaleString("es-CO");
  document.getElementById("cambio_final").value = cambio;
}

function extraerPrecio(valor) {
  if (!valor || valor === "No aplica") return 0;
  const partes = valor.split("|");
  const precio = parseFloat(partes[2]);
  return isNaN(precio) ? 0 : precio;
}

function actualizarTotal() {
  const cantidad = parseInt(document.getElementById("cantidad").value) || 0;
  const precioUnidad = extraerPrecio(document.getElementById("producto_aceite").value);
  const total = cantidad * precioUnidad;
  document.getElementById("precio_visible").value = "$" + total.toLocaleString("es-CO");
  document.getElementById("precio").value = total;
}
</script>



