<?php
include "conexion.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$cedula = $_POST['cedula'] ?? '';
$ciudad = $_POST['ciudad'] ?? '';
$provincia = $_POST['provincia'] ?? '';

if (!$cedula || !$ciudad || !$provincia) {
    die("Faltan datos requeridos.");
}

// 1. Obtiene los links ya asignados al usuario
$stmt = $pdo->prepare("SELECT link_whatsapp_id, link_moodle_id FROM usuarios WHERE cedula = ?");
$stmt->execute([$cedula]);
$usuario = $stmt->fetch();

if ($usuario && $usuario['link_whatsapp_id'] && $usuario['link_moodle_id']) {
    // 2. Actualiza ciudad y provincia
    $stmt = $pdo->prepare("UPDATE usuarios SET ciudad = ?, provincia = ? WHERE cedula = ?");
    $stmt->execute([$ciudad, $provincia, $cedula]);

    // 3. Obtiene los enlaces
    $stmt = $pdo->prepare("SELECT enlace FROM links_whatsapp WHERE id = ?");
    $stmt->execute([$usuario['link_whatsapp_id']]);
    $whatsapp_link = $stmt->fetchColumn();

    $stmt = $pdo->prepare("SELECT enlace FROM links_moodle WHERE id = ?");
    $stmt->execute([$usuario['link_moodle_id']]);
    $moodle_link = $stmt->fetchColumn();

    // 4. Obtiene informaci籀n adicional del usuario
    $stmt = $pdo->prepare("SELECT grupo, fecha_acceso_aulas, fecha_inicio_zoom, hora_clases, profesor,contrasenia FROM usuarios WHERE cedula = ?");
    $stmt->execute([$cedula]);
    $info_usuario = $stmt->fetch();

    $grupo = $info_usuario['grupo'];
    $fecha_acceso_aulas = $info_usuario['fecha_acceso_aulas'];
    $fecha_inicio_zoom = $info_usuario['fecha_inicio_zoom'];
    $hora_clases = $info_usuario['hora_clases'];
    $profesor = $info_usuario['profesor'];
    $contrasenia = $info_usuario['contrasenia'];
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registro exitoso - Instituto Superarse</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <style>
            body {
                font-family: Arial, sans-serif;
                background-image: url('assets/fondos2/FORMATOS BECA SENESCYT_Mesa de trabajo 1.jpg');
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
                margin: 0;
                padding: 0;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .container {
                background-color: rgba(255, 255, 255, 0.95);
                padding: 30px 20px;
                border-radius: 15px;
                max-width: 700px;
                width: 90%;
                text-align: center;
                color: #000;
                box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            }

            h2 {
                color: #005D52;
                margin-bottom: 20px;
            }

            p {
                font-size: 1.1em;
                margin: 15px 0;
            }

            a {
                color: #005D52;
                font-weight: bold;
                text-decoration: none;
                display: inline-block;
                transition: transform 0.3s ease;
            }
            
            .boton {
                display: inline-block;
                padding: 10px 20px;
                font-size: 16px;
                color: white;
                background-color: #005D52;
                text-decoration: none;
                border-radius: 5px;
                text-align: center;
            }

            .boton:hover {
                background-color: #0056b3;
            }

            a:hover {
                text-decoration: underline;
                transform: scale(1.1) translateY(-5px)
            }

            strong {
                color: #000;
            }

            @media (max-width: 768px) {
                .container {
                    padding: 20px;
                }

                p {
                    font-size: 1em;
                }

                h2 {
                    font-size: 1.4em;
                }
            }

            @media (max-width: 480px) {
                h2 {
                    font-size: 1.2em;
                }

                p {
                    font-size: 0.95em;
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h2>¡Registro completado exitosamente!</h2>
            <p><a href="<?= $whatsapp_link ?>" target="_blank" class="boton"><i class="bi bi-whatsapp"></i> Entrar al grupo de WhatsApp <i class="bi bi-whatsapp"></i></a></p>
            <p>Tu usuario para ingresar al Aula Virtual es: <strong><?= htmlspecialchars($cedula) ?></strong></p>
            <p>Tu contraseña es: <strong><?= htmlspecialchars($contrasenia) ?></strong></p>
            <p><em>En algunas ocasiones, el sistema solicitará que cambies tu contraseña por motivos de seguridad. Si no es el caso, puedes continuar utilizando la misma contraseña que se te proporcionó inicialmente.</em></p>
            <p>Tu grupo es: <strong><?= htmlspecialchars($grupo) ?></strong></p>
            <p><a href="<?= $moodle_link ?>" target="_blank" class="boton">Entrar a Moodle</a></p>

            <hr>

            <p><strong>Fecha de acceso a aulas:</strong> <?= htmlspecialchars($fecha_acceso_aulas) ?></p>
            <p><strong>Fecha de inicio en Zoom:</strong> <?= htmlspecialchars($fecha_inicio_zoom) ?></p>
            <p><strong>Horario de clases:</strong> <?= htmlspecialchars($hora_clases) ?></p>
            <p><em>Recuerda que las clases se imparten una vez por semana.</em></p>
            <p><strong>Profesor/a asignado/a:</strong> <?= htmlspecialchars($profesor) ?></p>

            <hr>

            <p>Para más información visita nuestra página web: <br>
                <a href="https://superarse.edu.ec/" target="_blank" class="boton">Instituto Superarse</a></p>
                
            <video src="assets/videos/becaIngles.mp4" width="50%" height="75%" autoplay playsinline controls></video>

            <p>Siguenos en nuestro Tiktok <br><a href="https://www.tiktok.com/@becasuperarse" target="_blank" class="boton"><i class="bi bi-tiktok"></i> @becasuperarse <i class="bi bi-tiktok"></i></a></p>
            <br>
            <p><h2>Tutorial de ingreso a Moodle</h2></p>
            <video src="assets/videos/tutorialMoodle.mp4" width="50%" height="75%" controls></video>
            <br>
            <p><h2>Tutorial de ingreso a Zoom</h2></p>
            <video src="assets/videos/tutorialZoom.mp4" width="50%" height="75%" controls></video>
        </div>
    </body>
    </html>
    <?php
} else {
    echo "<p>No se encontraron los links asignados para este usuario.</p>";
}
?>

