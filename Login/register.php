<?php
// Incluir archivo de configuración para la conexión
include __DIR__ . '/../Baseto/config_db.php'; // Ajusta la ruta según tu estructura

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validación básica
    if (empty($username) || empty($email) || empty($password)) {
        echo "invalid";
        exit();
    }

    // Hash seguro de la contraseña
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sss", $username, $email, $hashedPassword);

        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "error";
        }

        $stmt->close();
    } else {
        echo "error"; // Error en la preparación de la consulta
    }

    $conn->close();
} else {
    echo "invalid"; // Método no permitido
}
?>
