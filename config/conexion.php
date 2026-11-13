<?php
// --- DETECCIÓN AUTOMÁTICA DE ENTORNO ---

// Detectar si estamos en local (XAMPP) o producción
$es_local = (
    $_SERVER['SERVER_NAME'] === 'localhost' ||
    $_SERVER['SERVER_ADDR'] === '127.0.0.1' ||
    $_SERVER['SERVER_ADDR'] === '::1' ||
    strpos($_SERVER['HTTP_HOST'], 'localhost') !== false
);

if ($es_local) {
    // ========== CONFIGURACIÓN LOCAL (XAMPP) ==========
    $nombre_bd = "makadb";
    $servidor_ip = "localhost";
    $usuario_bd  = "root";
    $password_bd = ""; // XAMPP por defecto no tiene password
    $puerto      = 3306;
} else {
    // ========== CONFIGURACIÓN PRODUCCIÓN ==========
    // Credenciales en config/credentials.php (git-ignored); ver credentials.example.php
    $credentialsFile = __DIR__ . '/credentials.php';
    if (!file_exists($credentialsFile)) {
        die("Falta config/credentials.php (copia credentials.example.php y llénalo).");
    }
    $prod        = (require $credentialsFile)['production'];
    $nombre_bd   = $prod['db_name'];
    $servidor_ip = $prod['db_host'];
    $usuario_bd  = $prod['db_user'];
    $password_bd = $prod['db_password'];
    $puerto      = $prod['db_port'] ?? 3306;
}

// DSN (Data Source Name)
$dsn = "mysql:host=$servidor_ip;port=$puerto;dbname=$nombre_bd;charset=utf8mb4";

try {
    // Crear la instancia de PDO
    $pdo = new PDO($dsn, $usuario_bd, $password_bd);
    
    // Configurar PDO para que lance excepciones en caso de error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    //echo "¡Conexión exitosa a la base de datos!";

    // --- Ejemplo de cómo usar la conexión ---
    // $stmt = $pdo->query("SELECT * FROM tu_tabla");
    // while ($fila = $stmt->fetch()) {
    //     print_r($fila);
    // }

} catch (PDOException $e) {
    // Capturar cualquier error de conexión
    die("Error de conexión: " . $e->getMessage());
}
