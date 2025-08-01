<?php
include "conexion.php";
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}


if (isset($_GET['eliminar'])) {
    $idEliminar = intval($_GET['eliminar']);
    $conn->query("DELETE FROM facturas WHERE id_facturas = $idEliminar");
    header("Location: admin.php?seccion=editar_factura");
    exit;
}


$modo_edicion = false;
if (isset($_GET['editar'])) {
    $idEditar = intval($_GET['editar']);
    $factura = $conn->query("SELECT * FROM facturas WHERE id_facturas = $idEditar")->fetch_assoc();
    $modo_edicion = true;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
    $id_factura = intval($_POST['id_facturas']);
    $tipo_carro = $_POST['tipo_carro'];
    $placa = $_POST['placa'];
    $aceite = $_POST['aceite'];
    $cantidad = intval($_POST['cantidad']);
    $metodo_pago = $_POST['metodo_pago'];
    $total = floatval($_POST['total']);
    $pago_cliente = $metodo_pago === "Efectivo" ? floatval($_POST['pago_cliente']) : $total;
    $cambio = $pago_cliente - $total;

    $stmt = $conn->prepare("UPDATE facturas SET tipo_carro=?, placa=?, aceite=?, cantidad=?, metodo_pago=?, total=?, pago_cliente=?, cambio=? WHERE id_facturas=?");
    $stmt->bind_param("sssisdssi", $tipo_carro, $placa, $aceite, $cantidad, $metodo_pago, $total, $pago_cliente, $cambio, $id_factura);
    $stmt->execute();

    echo "<script>alert('Factura actualizada correctamente'); window.location='admin.php?seccion=editar_factura';</script>";
    exit;
}


$facturas = $conn->query("SELECT * FROM facturas ORDER BY fecha DESC, id_facturas DESC");
?>

<h2 style="color:#e30613; text-align:center;">Editar / Eliminar Facturas</h2>

<?php if ($modo_edicion): ?>
<form method="POST" style="width:60%; margin:auto; background:#1a1a1a; color:white; padding:20px; border-radius:10px; margin-bottom:20px;">
    <input type="hidden" name="id_facturas" value="<?= $factura['id_facturas'] ?>">

    <label>Tipo de carro:</label><br>
    <input type="text" name="tipo_carro" value="<?= htmlspecialchars($factura['tipo_carro']) ?>" required><br><br>

    <label>Placa:</label><br>
    <input type="text" name="placa" value="<?= htmlspecialchars($factura['placa']) ?>" required><br><br>

    <label>Producto (aceite):</label><br>
    <input type="text" name="aceite" value="<?= htmlspecialchars($factura['aceite']) ?>" required><br><br>

    <label>Cantidad:</label><br>
    <input type="number" name="cantidad" value="<?= $factura['cantidad'] ?>" required><br><br>

    <label>Total:</label><br>
    <input type="number" name="total" step="1000" value="<?= $factura['total'] ?>" required><br><br>

    <label>Método de pago:</label><br>
    <select name="metodo_pago" required onchange="togglePago(this.value)">
        <option value="Efectivo" <?= $factura['metodo_pago'] === "Efectivo" ? "selected" : "" ?>>Efectivo</option>
        <option value="Nequi" <?= $factura['metodo_pago'] === "Nequi" ? "selected" : "" ?>>Nequi</option>
        <option value="Daviplata" <?= $factura['metodo_pago'] === "Daviplata" ? "selected" : "" ?>>Daviplata</option>
        <option value="Bancolombia" <?= $factura['metodo_pago'] === "Bancolombia" ? "selected" : "" ?>>Bancolombia</option>
    </select><br><br>

    <div id="pago_div" style="display:<?= $factura['metodo_pago'] === "Efectivo" ? "block" : "none" ?>;">
        <label>Pago del cliente:</label><br>
        <input type="number" name="pago_cliente" value="<?= $factura['pago_cliente'] ?>"><br><br>
    </div>

    <button type="submit" name="guardar" style="background:#e30613; color:white; padding:10px 20px;">Guardar cambios</button>
    <a href="admin.php?seccion=editar_factura" style="color:white; margin-left:10px;">Cancelar</a>
</form>

<script>
function togglePago(valor) {
    document.getElementById("pago_div").style.display = (valor === "Efectivo") ? "block" : "none";
}
</script>
<?php endif; ?>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; background:#1a1a1a; color:white; border-collapse:collapse;">
  <tr style="background:#e30613;">
    <th>ID</th>
    <th>Cliente</th>
    <th>Carro</th>
    <th>Placa</th>
    <th>Producto</th>
    <th>Cantidad</th>
    <th>Total</th>
    <th>Pago</th>
    <th>Cambio</th>
    <th>Fecha</th>
    <th>Acciones</th>
  </tr>
  <?php while ($f = $facturas->fetch_assoc()): ?>
  <tr>
    <td><?= $f['id_facturas'] ?></td>
    <td><?= $f['correo'] ?></td>
    <td><?= $f['tipo_carro'] ?></td>
    <td><?= $f['placa'] ?></td>
    <td><?= $f['aceite'] ?></td>
    <td><?= $f['cantidad'] ?></td>
    <td>$<?= number_format($f['total'], 0, ',', '.') ?></td>
    <td>$<?= number_format($f['pago_cliente'], 0, ',', '.') ?></td>
    <td>$<?= number_format($f['cambio'], 0, ',', '.') ?></td>
    <td><?= $f['fecha'] ?></td>
    <td>
      <a href="?seccion=editar_factura&editar=<?= $f['id_facturas'] ?>" style="color:#00ccff;"> Editar</a> 
      <a href="?seccion=editar_factura&eliminar=<?= $f['id_facturas'] ?>" onclick="return confirm('¿Seguro que deseas eliminar esta factura?')" style="color:#e30613;">🗑 Eliminar</a>
    </td>
  </tr>
  <?php endwhile; ?>
</table>

