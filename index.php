<?php
// 1. Leer la URL completa de la base de datos desde las variables de entorno de Railway
$databaseUrl = getenv('MYSQL_URL');
if (!$databaseUrl) {
    die("Error: No se pudo encontrar la URL de la base de datos (MYSQL_URL). Asegúrate de que la base de datos MySQL esté añadida en Railway.");
}
// 2. Descomponer la URL para obtener cada parte
$parsed = parse_url($databaseUrl);
$server = $parsed['host'];
$username = $parsed['user'];
$password = $parsed['pass'];
$database = ltrim($parsed['path'], '/');
$port = $parsed['port'] ?? 3306; // Usa el puerto de la URL o el 3306 por defecto
// 3. Crear la conexión usando mysqli
$conn = new mysqli($server, $username, $password, $database, $port);
// 4. Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
echo "<h1>¡Conexión exitosa a la base de datos en Railway Cloud!</h1>";
echo "<p>Base de datos: " . $database . "</p>";
// 5. (Opcional) Mostrar un mensaje de bienvenida o hacer una consulta simple
$sql = "SELECT '¡Hola, mundo desde Railway!' as mensaje";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<h2>" . $row["mensaje"] . "</h2>";
    }
}
// 6. Cerrar la conexión
$conn->close();
?>