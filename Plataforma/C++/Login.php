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
if (isset($_POST['email1']) && isset($_POST['Pass1'])) {
    $email = $_POST['email1'];
    $Pass = $_POST['Pass1'];

    // Preparar la declaración SQL
    $stmt = $conn->prepare("SELECT * FROM registro WHERE Correo = ? AND Contraseña = ?");
    if ($stmt === false) {
        die("Error preparando la consulta: " . $conn->error);
    }

    // Vincular parámetros
    $stmt->bind_param("ss", $email, $Pass);

    // Ejecutar la declaración
    $stmt->execute();

    // Obtener el resultado
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Usuario encontrado, redirigir a la página principal
         header("Location: ../Html/Menu.html");
        exit();
    } else {
        // Usuario no encontrado, mostrar mensaje de error
        echo'<script type "text/javascript">
        alert("Correo o Contraseña Incorrectos");
        window.location.href="../Index.html";
        </script>';
    }

    // Cerrar la declaración
    $stmt->close();
} else {
    echo "Todos los campos son obligatorios.";
}

// Cerrar la conexión
$conn->close();
?>
