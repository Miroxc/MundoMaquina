<?php
// Incluir archivo de conexión
include __DIR__ . '/../Baseto/config_db.php'; // ajusta la ruta según dónde esté tu archivo

$mensaje = "";
$mostrarModalDuplicado = false;

// Eliminar vehículo
if (isset($_GET['eliminar'])) {
    $id_eliminar = intval($_GET['eliminar']);
    $conn->query("DELETE FROM vehiculos WHERE id = $id_eliminar");
    header("Location: admin_vehiculos.php");
    exit();
}

// Agregar vehículo
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["patente"])) {
    $patente = strtoupper(trim($_POST["patente"]));
    $marca = trim($_POST["marca"]);
    $modelo = trim($_POST["modelo"]);
    $estado = trim($_POST["estado"]);

    // Procesar imagen subida
    $ruta_imagen = "";
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = $_FILES['imagen']['name'];
        $tmpArchivo = $_FILES['imagen']['tmp_name'];
        $ext = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));
        $extPermitidas = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($ext, $extPermitidas)) {
            $nombreNuevo = uniqid('img_') . "." . $ext;
            $carpetaDestino = "uploads/";

            if (!is_dir($carpetaDestino)) {
                mkdir($carpetaDestino, 0755, true);
            }

            $rutaCompleta = $carpetaDestino . $nombreNuevo;

            if (move_uploaded_file($tmpArchivo, $rutaCompleta)) {
                $ruta_imagen = $rutaCompleta;
            }
        }
    }

    // Verificar duplicados
    $sql_check = "SELECT * FROM vehiculos WHERE patente = ? AND marca = ? AND modelo = ? AND estado = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ssss", $patente, $marca, $modelo, $estado);
    $stmt_check->execute();
    $resultado = $stmt_check->get_result();

    if ($resultado->num_rows > 0) {
        header("Location: admin_vehiculos.php?error=duplicado");
        exit();
    } else {
        $sql = "INSERT INTO vehiculos (patente, marca, modelo, estado, imagen) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $patente, $marca, $modelo, $estado, $ruta_imagen);

        if ($stmt->execute()) {
            header("Location: admin_vehiculos.php?mensaje=exito");
            exit();
        } else {
            $mensaje = "❌ Error al agregar: " . $stmt->error;
        }
        $stmt->close();
    }
    $stmt_check->close();
}

// Mensajes desde URL
if (isset($_GET['error']) && $_GET['error'] === 'duplicado') {
    $mostrarModalDuplicado = true;
}

if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'exito') {
    $mensaje = "✅ Vehículo agregado correctamente.";
}

// Obtener vehículos
$vehiculos = [];
$result = $conn->query("SELECT * FROM vehiculos ORDER BY id DESC");
while ($fila = $result->fetch_assoc()) {
    $vehiculos[] = $fila;
}

$conn->close();

include 'admin_vehiculos_view.php';
?>
