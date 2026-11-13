-- Se ejecuta automáticamente la primera vez que se crea el contenedor de MySQL
SET NAMES utf8mb4;
SET time_zone = '-04:00';

CREATE TABLE IF NOT EXISTS mensajes (
    id        INT AUTO_INCREMENT PRIMARY KEY,
    nombre    VARCHAR(50)  NOT NULL,
    texto     VARCHAR(255) NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO mensajes (nombre, texto) VALUES
    ('Arisleidy', 'Hola mundo');
