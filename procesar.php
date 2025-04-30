<?php
include "conexion.php";

$cedula = $_POST['cedula'];
$ciudad = $_POST['ciudad'];
$provincia = $_POST['provincia'];

$whatsapp = $conexion->query("SELECT id FROM links_whatsapp WHERE id NOT IN (SELECT link_whatsapp_id FROM usuarios WHERE link_whatsapp_id IS NOT NULL) ORDER BY RAND() LIMIT 1")->fetch_assoc();
$moodle = $conexion->query("SELECT id FROM links_moodle WHERE id NOT IN (SELECT link_moodle_id FROM usuarios WHERE link_moodle_id IS NOT NULL) ORDER BY RAND() LIMIT 1")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro exitoso - Instituto Superarse</title>
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
        }

        a:hover {
            text-decoration: underline;
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
        <?php
        if ($whatsapp && $moodle) {
            $sql = "UPDATE usuarios SET ciudad='$ciudad', provincia='$provincia', 
                    link_whatsapp_id={$whatsapp['id']}, link_moodle_id={$moodle['id']} 
                    WHERE cedula='$cedula'";

            if ($conexion->query($sql) === TRUE) {
                $whatsapp_link = $conexion->query("SELECT enlace FROM links_whatsapp WHERE id={$whatsapp['id']}")->fetch_assoc()['enlace'];
                $moodle_link = $conexion->query("SELECT enlace FROM links_moodle WHERE id={$moodle['id']}")->fetch_assoc()['enlace'];
                $grupo_result = $conexion->query("SELECT grupo FROM usuarios WHERE cedula='$cedula'");
                $grupo_row = $grupo_result->fetch_assoc();
                $grupo = $grupo_row['grupo'];

                echo "<h2>¡Registro completado exitosamente!</h2>";
                echo "<p><a href='$whatsapp_link' target='_blank'>Entrar al grupo de WhatsApp</a></p>";
                echo "<p>Tu usuario para ingresar al Aula Virtual es: <strong>$cedula</strong></p>";
                echo "<p>Tu contraseña temporal es: <strong>Superarse.2025</strong></p>";
                echo "<p><em>Recuerda cambiar tu contraseña en tu primer inicio de sesión.</em></p>";
                echo "<p>Tu grupo es: <strong>$grupo</strong></p>";
                echo "<p><a href='$moodle_link' target='_blank'>Entrar a Moodle</a></p>";
                echo "<p>Para más información visita nuestra página web: 
                      <a href='https://superarse.edu.ec/' target='_blank'>Instituto Superarse</a></p>";
            } else {
                echo "<p>Error al guardar los datos. Por favor, intenta nuevamente.</p>";
            }
        } else {
            echo "<p>No hay más enlaces disponibles. Comunícate con soporte.</p>";
        }
        ?>
    </div>
</body>
</html>
