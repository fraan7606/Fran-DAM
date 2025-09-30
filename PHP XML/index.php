<?php
$xmlFile = 'tareas.xml';

// Si el archivo no existe, créalo con la estructura base
if (!file_exists($xmlFile)) {
    $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><tareas></tareas>');
    $xml->asXML($xmlFile);
}

// Cargar tareas existentes desde el XML
$xml = simplexml_load_file($xmlFile);
$tareas = [];
foreach ($xml->tarea as $tarea) {
    $tareas[] = (string)$tarea;
}

// Agregar nueva tarea si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['nueva_tarea'])) {
    $nuevaTarea = trim($_POST['nueva_tarea']);
    if ($nuevaTarea !== '') {
        $xml->addChild('tarea', htmlspecialchars($nuevaTarea));
        $xml->asXML($xmlFile);
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Tareas Simple</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
        <h1>Lista de Tareas</h1>
        <ul>
            <?php foreach ($tareas as $tarea): ?>
                <li><?= htmlspecialchars($tarea) ?></li>
            <?php endforeach; ?>
        </ul>
        <form method="post">
            <input type="text" name="nueva_tarea" placeholder="Nueva tarea" required>
            <button type="submit">Agregar</button>
        </form>
    </div>
</body>
</html>
<?php
// Fin del archivo