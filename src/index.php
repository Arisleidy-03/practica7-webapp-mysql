<?php
require_once 'conexion.php';

$conectado = false;
$version   = '';
$mensajes  = [];
$error     = '';
$aviso     = '';

try {
    $pdo       = conectar($host, $baseDato, $usuario, $clave);
    $conectado = true;

    // Guardar un mensaje nuevo
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = trim($_POST['nombre'] ?? '');
        $texto  = trim($_POST['texto'] ?? '');

        if ($nombre === '' || $texto === '') {
            $aviso = 'Escribe tu nombre y un mensaje.';
        } else {
            $sql = $pdo->prepare('INSERT INTO mensajes (nombre, texto) VALUES (?, ?)');
            $sql->execute([mb_substr($nombre, 0, 50), mb_substr($texto, 0, 255)]);

            header('Location: /');
            exit;
        }
    }

    $version  = $pdo->query('SELECT VERSION()')->fetchColumn();
    $mensajes = $pdo->query('SELECT nombre, texto, creado_en FROM mensajes ORDER BY id DESC')->fetchAll();
} catch (PDOException $e) {
    $error = $e->getMessage();
}

function fecha($valor)
{
    return date('d/m/Y \a \l\a\s g:i a', strtotime($valor));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libro de visitas</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <header>
        <p class="etiqueta">Práctica 7 &middot; PHP y MySQL</p>
        <h1>Libro de visitas</h1>
        <p>Deja un mensaje. Todo lo que escribas se guarda en la base de datos.</p>
    </header>

    <?php if ($conectado): ?>
        <form method="post">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" maxlength="50" required>

            <label for="texto">Mensaje</label>
            <textarea id="texto" name="texto" rows="3" maxlength="255" required></textarea>

            <?php if ($aviso): ?>
                <p class="aviso"><?= htmlspecialchars($aviso) ?></p>
            <?php endif; ?>

            <button type="submit">Guardar mensaje</button>
        </form>

        <section>
            <h2><?= count($mensajes) ?> <?= count($mensajes) === 1 ? 'mensaje' : 'mensajes' ?></h2>

            <?php foreach ($mensajes as $m): ?>
                <article>
                    <p class="texto"><?= htmlspecialchars($m['texto']) ?></p>
                    <p class="autor"><?= htmlspecialchars($m['nombre']) ?> &middot; <?= fecha($m['creado_en']) ?></p>
                </article>
            <?php endforeach; ?>
        </section>
    <?php else: ?>
        <section class="error">
            <h2>No hay conexión con la base de datos</h2>
            <p><?= htmlspecialchars($error) ?></p>
        </section>
    <?php endif; ?>

    <footer>
        <?php if ($conectado): ?>
            MySQL <?= htmlspecialchars($version) ?> &middot; servidor <?= htmlspecialchars($host) ?> &middot; base <?= htmlspecialchars($baseDato) ?>
        <?php endif; ?>
        <span>Arisleidy Melo &middot; 2025-1044</span>
    </footer>
</body>
</html>
