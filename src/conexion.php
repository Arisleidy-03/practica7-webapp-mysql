<?php
// Datos de conexión tomados de las variables de entorno del docker-compose.yml
$host     = getenv('DB_HOST');
$baseDato = getenv('DB_NAME');
$usuario  = getenv('DB_USER');
$clave    = getenv('DB_PASSWORD');

function conectar($host, $baseDato, $usuario, $clave)
{
    $dsn = "mysql:host=$host;dbname=$baseDato;charset=utf8mb4";

    $pdo = new PDO($dsn, $usuario, $clave, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    // Hora de República Dominicana para las fechas de los mensajes
    $pdo->exec("SET time_zone = '-04:00'");

    return $pdo;
}
