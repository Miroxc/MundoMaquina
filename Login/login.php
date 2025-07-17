<?php
session_start();

// Incluir conexión centralizada
include __DIR__ . '/../Baseto/config_db.php'; // Ajusta la ruta

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validar campos vacíos
    if (empty($username) || empty($password)) {
        echo "invalid";
        exit();
    }

    $sql = "SELECT id, password FROM usuarios WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $hash);
            $stmt->fetch();

            if (password_verify($password, $hash)) {
                // Guardar datos en sesión
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;
                echo "success";
            } else {
                echo "invalid"; // Contraseña incorrecta
            }
        } else {
            echo "invalid"; // Usuario no encontrado
        }

        $stmt->close();
    } else {
        echo "error"; // Error al preparar la consulta
    }

    $conn->close();
} else {
    echo "invalid"; // Método no permitido
}
?>
