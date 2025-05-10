<?php
include "conexion.php";

$cedula = $_POST['cedula'];
$ciudad = $_POST['ciudad'];
$provincia = $_POST['provincia'];

// 1. Obtiene los links ya asignados al usuario
$usuario = $conexion->query("SELECT link_whatsapp_id, link_moodle_id FROM usuarios WHERE cedula = '$cedula'")->fetch_assoc();

if ($usuario && $usuario['link_whatsapp_id'] && $usuario['link_moodle_id']) {
    $conexion->query("UPDATE usuarios SET ciudad='$ciudad', provincia='$provincia' WHERE cedula='$cedula'");

    $whatsapp_link = $conexion->query("SELECT enlace FROM links_whatsapp WHERE id={$usuario['link_whatsapp_id']}")->fetch_assoc()['enlace'];
    $moodle_link = $conexion->query("SELECT enlace FROM links_moodle WHERE id={$usuario['link_moodle_id']}")->fetch_assoc()['enlace'];

    $info_usuario = $conexion->query("SELECT grupo, fecha_acceso_aulas, fecha_inicio_zoom, hora_clases, profesor FROM usuarios WHERE cedula='$cedula'")->fetch_assoc();
    $grupo = $info_usuario['grupo'];
    $fecha_acceso = $info_usuario['fecha_acceso_aulas'];
    $fecha_zoom = $info_usuario['fecha_inicio_zoom'];
    $hora_clases = $info_usuario['hora_clases'];
    $profesor = $info_usuario['profesor'];
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
            <p>Tu usuario para ingresar al Aula Virtual es: <strong><?= $cedula ?></strong></p>
            <p>Tu contraseña temporal es: <strong>Superarse.2025</strong></p>
            <p><em>Recuerda cambiar tu contraseña en tu primer inicio de sesión.</em></p>
            <p>Tu grupo es: <strong><?= $grupo ?></strong></p>
            <p><a href="<?= $moodle_link ?>" target="_blank" class="boton">Entrar a Moodle</a></p>

            <!-- Información adicional -->
            <p>Fecha de acceso a las aulas: <strong><?= $fecha_acceso ?></strong></p>
            <p>Inicio de clases por Zoom: <strong><?= $fecha_zoom ?></strong></p>
            <p>Hora de clases: <strong><?= $hora_clases ?></strong></p>
            <p>Profesor asignado: <strong><?= $profesor ?></strong></p>

            <p>Para más información visita nuestra página web:<br> 
                <a href="https://superarse.edu.ec/" target="_blank" class="boton">Instituto Superarse</a></p>

            <video src="assets/videos/becaIngles.mp4" width="50%" height="75%" autoplay playsinline controls></video>

            <p>Siguenos en nuestro Tiktok <br><a href="https://www.tiktok.com/@becasuperarse" target="_blank" class="boton"><i class="bi bi-tiktok"></i> @becasuperarse <i class="bi bi-tiktok"></i></a></p>
            <br>
            <p><h2>Tutorial de ingreso a Moodle</h2></p>
            <video loop src="assets/videos/tutorialMoodle.mp4" width="50%" height="75%" controls></video>
            <br>
            <p><h2>Tutorial de ingreso a Zoom</h2></p>
            <video loop src="assets/videos/tutorialZoom.mp4" width="50%" height="75%" controls></video>
        </div>
    </body>
    </html>
    <?php
} else {
    echo "<p>No se encontraron los links asignados para este usuario.</p>";
}
?>
