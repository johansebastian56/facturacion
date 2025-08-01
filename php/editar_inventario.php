<?php
session_start();
include "php/conexion.php";

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}


if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $conn->query("DELETE FROM inventario WHERE id_inventario = $id");
    header("Location: admin.php?seccion=editar_inventario");
    exit;
}

$modo_edicion = false;
if (isset($_GET['editar'])) {
    $id = intval($_GET['editar']);
    $producto = $conn->query("SELECT * FROM inventario WHERE id_inventario = $id")->fetch_assoc();
    $modo_edicion = true;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
    $id       = intval($_POST['id']);
    $prod     = $_POST['producto'];
    $tipo     = $_POST['tipo'];
    $cantidad = intval($_POST['cantidad']);
    $precio   = floatval($_POST['precio']);

    $stmt = $conn->prepare("UPDATE inventario SET producto=?, tipo=?, cantidad=?, precio=? WHERE id_inventario=?");
    $stmt->bind_param("ssidi", $prod, $tipo, $cantidad, $precio, $id);
    $stmt->execute();

    echo "<script>alert('Producto actualizado'); window.location='admin.php?seccion=editar_inventario';</script>";
    exit;
}


$inventario = $conn->query("SELECT * FROM inventario ORDER BY id_inventario ASC");
?>

<h2 style="color:#e30613; text-align:center;">Editar / Eliminar Inventario</h2>

<?php if ($modo_edicion): ?>
<form method="POST" style="width:60%; margin:auto; background:#1a1a1a; color:white; padding:20px; border-radius:10px; margin-bottom:20px;">
    <input type="hidden" name="id" value="<?= $producto['id_inventario'] ?>">
    <label>Producto:</label><br>
    <input type="text" name="producto" value="<?= htmlspecialchars($producto['producto']) ?>" required><br><br>

    <label>Tipo:</label><br>
    <input type="text" name="tipo" value="<?= htmlspecialchars($producto['tipo']) ?>" required><br><br>

    <label>Cantidad:</label><br>
    <input type="number" name="cantidad" value="<?= $producto['cantidad'] ?>" required><br><br>

    <label>Precio:</label><br>
    <input type="number" step="0.01" name="precio" value="<?= $producto['precio'] ?>" required><br><br>

    <button type="submit" name="guardar" style="background:#e30613; color:white; padding:10px 20px; border:none; cursor:pointer;">Guardar Cambios</button>
    <a href="admin.php?seccion=editar_inventario" style="margin-left:10px; color:white;">Cancelar</a>
</form>
<?php endif; ?>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; background:#1a1a1a; color:white; border-collapse:collapse;">
  <tr style="background:#e30613;">
    <th>ID</th>
    <th>Producto</th>
    <th>Tipo</th>
    <th>Cantidad</th>
    <th>Precio</th>
    <th>Acciones</th>
  </tr>
  <?php while ($item = $inventario->fetch_assoc()): ?>
  <tr>
    <td><?= $item['id_inventario'] ?></td>
    <td><?= $item['producto'] ?></td>
    <td><?= $item['tipo'] ?></td>
    <td><?= $item['cantidad'] ?></td>
    <td>$<?= number_format($item['precio'], 0, ',', '.') ?></td>
    <td>
      <a href="admin.php?seccion=editar_inventario&editar=<?= $item['id_inventario'] ?>" style="color:#00ccff;"> Editar</a> 
      <a href="admin.php?seccion=editar_inventario&eliminar=<?= $item['id_inventario'] ?>" onclick="return confirm('¿Eliminar este producto del inventario?')" style="color:#e30613;">🗑 Eliminar</a>
    </td>
  </tr>
  <?php endwhile; ?>
</table>
