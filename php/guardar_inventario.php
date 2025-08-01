<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    require_once "conexion.php"; 

    
    $producto = trim($_POST['producto']);
    $tipo = trim($_POST['tipo']);
    $cantidad = intval($_POST['cantidad']);
    $precio = floatval($_POST['precio']); 

    
    $stmt = $conn->prepare("INSERT INTO inventario (producto, tipo, cantidad, precio, fecha) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssii", $producto, $tipo, $cantidad, $precio);

    if ($stmt->execute()) {
        header("Location: ../inventario.php");
        exit;
    } else {
        echo "Error al guardar: " . $conn->error;
    }
}
?>
