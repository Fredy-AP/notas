<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "letras_db";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Manejar solicitud POST para guardar una nueva letra
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['letra'])) {
    // Obtener la letra desde el formulario
    $letra = $conn->real_escape_string($_POST['letra']); // Escapar la entrada para prevenir inyección SQL

    // Preparar la consulta SQL para insertar la letra
    $sql = "INSERT INTO letras (letra) VALUES ('$letra')";

    // Ejecutar la consulta y verificar el resultado
    if ($conn->query($sql) === TRUE) {
        // Si la inserción fue exitosa, devolver respuesta JSON
        echo json_encode(['status' => 'success']);
    } else {
        // Si hubo un error en la inserción, devolver respuesta JSON con el mensaje de error
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
}

// Manejar solicitud GET para obtener todas las letras guardadas
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Preparar la consulta SQL para obtener todas las letras
    $sql = "SELECT * FROM letras";

    // Ejecutar la consulta y obtener el resultado
    $result = $conn->query($sql);

    // Crear un array para almacenar las letras
    $letras = array();

    // Verificar si se encontraron resultados
    if ($result->num_rows > 0) {
        // Recorrer los resultados y almacenar cada letra en el array
        while ($row = $result->fetch_assoc()) {
            $letras[] = $row;
        }
    }

    // Devolver las letras como JSON
    echo json_encode($letras);
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
