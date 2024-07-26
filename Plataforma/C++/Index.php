<?php
$servername = "localhost";
$username = "root"; // Usuario por defecto
$password = ""; // Contraseña por defecto es vacía
$dbname = "ado";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
echo "Conectado exitosamente a la base de datos<br>";

// Verificar que los datos del formulario estén establecidos
if (isset($_POST['Nombre']) && isset($_POST['email']) && isset($_POST['Pass'])) {
    $Nombre = $_POST['Nombre'];
    $email = $_POST['email'];
    $Pass = $_POST['Pass'];

    // Preparar la declaración SQL
    $stmt = $conn->prepare("INSERT INTO registro (Nonmbe, Correo, Contraseña) VALUES (?, ?, ?)");
    if ($stmt === false) {
        die("Error preparando la consulta: " . $conn->error);
    }


    // Vincular parámetros
    $stmt->bind_param("sss", $Nombre, $email, $Pass);

    // Ejecutar la declaración
    if ($stmt->execute()) {
        // Redirigir a la página principal después de un registro exitoso
        header("Location: ../Html/Menu.html");
        exit();
    } else {
        echo "Error de Registro: " . $stmt->error;
    }

    // Cerrar la declaración
    $stmt->close();
} else {
    echo "Todos los campos son obligatorios.";
}

// Cerrar la conexión
$conn->close();
?>

