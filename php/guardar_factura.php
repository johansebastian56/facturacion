<?php
session_start();
date_default_timezone_set('America/Bogota');
require '../vendor/autoload.php';
include "conexion.php";

use Dompdf\Dompdf;
use Dompdf\Options;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], ['empleado', 'admin'])) {
    header("Location: login.php");
    exit;
}

$correo        = $_POST['correo'] ?? '';
$producto_raw  = $_POST['producto_aceite'] ?? '';
$tipo_carro    = $_POST['tipo_carro'] ?? '';
$placa         = $_POST['placa'] ?? '';
$cantidad      = intval($_POST['cantidad'] ?? 0);
$precio_total  = floatval($_POST['precio'] ?? 0);
$metodo_pago   = "Efectivo";
$pago_cliente  = floatval($_POST['pago_cliente'] ?? 0);
$fecha         = $_POST['fecha'] ?? date("Y-m-d");
$hora          = date("H:i:s");

list($producto, $aceite, $precio_unitario) = explode('|', $producto_raw);
$cambio = $pago_cliente - $precio_total;


if (empty($correo) || empty($producto) || empty($tipo_carro) || empty($placa) || empty($aceite) || $cantidad <= 0 || $precio_total <= 0) {
    echo "<script>alert('Campos obligatorios incompletos.'); window.location='../empleado.php?seccion=facturacion';</script>";
    exit;
}


$stmt_user = $conn->prepare("SELECT id_usuarios, nombre, apellido FROM usuarios WHERE correo = ?");
$stmt_user->bind_param("s", $correo);
$stmt_user->execute();
$res_user = $stmt_user->get_result();

if ($res_user->num_rows === 0) {
    echo "<script>alert('Usuario no encontrado.'); window.location='../empleado.php?seccion=facturacion';</script>";
    exit;
}
$user_data = $res_user->fetch_assoc();
$id_usuario = $user_data['id_usuarios'];
$nombre = $user_data['nombre'];
$apellido = $user_data['apellido'];

$stmt_inv = $conn->prepare("SELECT id_inventario, cantidad FROM inventario WHERE producto = ? AND tipo = ? AND cantidad >= ?");
$stmt_inv->bind_param("ssi", $producto, $aceite, $cantidad);
$stmt_inv->execute();
$res_inv = $stmt_inv->get_result();

if ($res_inv->num_rows === 0) {
    echo "<script>alert('No hay suficiente inventario.'); window.location='../empleado.php?seccion=facturacion';</script>";
    exit;
}
$inv_data = $res_inv->fetch_assoc();
$id_inventario = $inv_data['id_inventario'];


$sql = "INSERT INTO facturas 
(correo, tipo_carro, placa, aceite, cantidad, total, pago_cliente, cambio, fecha, metodo_pago, fk_id_usuarios, fk_id_inventario) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssidddsiii", $correo, $tipo_carro, $placa, $aceite, $cantidad, $precio_total, $pago_cliente, $cambio, $fecha, $metodo_pago, $id_usuario, $id_inventario);
$registrado = $stmt->execute();

if ($registrado) {
    $id_factura = $conn->insert_id;

    $empleado = $_SESSION['usuario'];
    $stmt_venta = $conn->prepare("INSERT INTO ventas (producto, tipo, cantidad_vendida, precio, total, fecha, hora, metodo_pago, empleado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt_venta->bind_param("ssidsssss", $producto, $aceite, $cantidad, $precio_unitario, $precio_total, $fecha, $hora, $metodo_pago, $empleado);
    $stmt_venta->execute();

    
    $stmt_update = $conn->prepare("UPDATE inventario SET cantidad = cantidad - ? WHERE id_inventario = ?");
    $stmt_update->bind_param("ii", $cantidad, $id_inventario);
    $stmt_update->execute();

    
    $html = '
    <!DOCTYPE html>
    <html lang="es">
    <head>
      <meta charset="UTF-8">
      <style>
        body {
          font-family: DejaVu Sans, sans-serif;
          font-size: 12px;
          color: #000;
          margin: 30px;
        }
        .header {
          display: flex;
          align-items: center;
          justify-content: space-between;
        }
        .logo {
          width: 150px;
        }
        h2 {
          text-align: center;
          color: #e30613;
          margin-bottom: 20px;
        }
        table {
          width: 100%;
          border-collapse: collapse;
          margin-top: 15px;
        }
        th, td {
          border: 1px solid #999;
          padding: 8px 10px;
          text-align: left;
        }
        th {
          background-color: #f2f2f2;
        }
        .section-title {
          margin-top: 30px;
          font-weight: bold;
          font-size: 14px;
          color: #333;
        }
      </style>
    </head>
    <body>
      <div class="header">
        <h2>Factura Electrónica - Aceicar SAS</h2>
      </div>

      <div class="section-title">Detalles del Cliente</div>
      <table>
        <tr><th>Nombre</th><td>' . $nombre . ' ' . $apellido . '</td></tr>
        <tr><th>Correo</th><td>' . $correo . '</td></tr>
        <tr><th>Fecha</th><td>' . $fecha . '</td></tr>
        <tr><th>ID Factura</th><td>' . $id_factura . '</td></tr>
      </table>

      <div class="section-title">Detalles de la Factura</div>
      <table>
        <thead>
          <tr>
            <th>Producto</th>
            <th>Tipo de carro</th>
            <th>Placa</th>
            <th>Cantidad</th>
            <th>Método de pago</th>
            <th>Total</th>
            <th>Pago cliente</th>
            <th>Cambio</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>' . $aceite . '</td>
            <td>' . $tipo_carro . '</td>
            <td>' . $placa . '</td>
            <td>' . $cantidad . '</td>
            <td>' . $metodo_pago . '</td>
            <td>$' . number_format($precio_total, 0, ',', '.') . '</td>
            <td>$' . number_format($pago_cliente, 0, ',', '.') . '</td>
            <td>$' . number_format($cambio, 0, ',', '.') . '</td>
          </tr>
        </tbody>
      </table>
    </body>
    </html>
    ';

    
    $pdf = new Dompdf();
    $pdf->loadHtml($html);
    $pdf->setPaper('A4', 'portrait');
    $pdf->render();

    $carpeta = __DIR__ . "/facturas";
    if (!is_dir($carpeta)) {
        mkdir($carpeta, 0777, true);
    }

    $ruta_pdf = $carpeta . "/factura_{$id_factura}.pdf";
    file_put_contents($ruta_pdf, $pdf->output());

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'sebaszambranoc3@gmail.com';
        $mail->Password   = 'rdso rexw vuen hqsh';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('sebaszambranoc3@gmail.com', 'Aceicar');
        $mail->addAddress($correo);

        $mail->isHTML(true);
        $mail->Subject = 'Factura electrónica - Aceicar';
        $mail->Body    = 'Gracias por tu compra. Adjuntamos tu factura.';
        $mail->addAttachment($ruta_pdf);

        $mail->send();

        $destino = ($_SESSION['rol'] === 'admin') ? '../admin.php?seccion=facturacion' : '../empleado.php?seccion=facturacion';
        echo "<script>alert(' Factura registrada y enviada al correo.'); window.location='$destino';</script>";

    } catch (Exception $e) {
        echo "<script>alert(' Error al enviar el correo: {$mail->ErrorInfo}'); window.location='../empleado.php?seccion=facturacion';</script>";
    }

} else {
    echo "<script>alert('Error al guardar la factura.'); window.location='../empleado.php?seccion=facturacion';</script>";
}
?>






