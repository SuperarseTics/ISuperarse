<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Instituto Superior Tecnológico Superarse</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('assets/fondos2/FORMATOS BECA SENESCYT_Mesa de trabajo 1.jpg');
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-position: center;
            color: #fff;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1, h3 {
            color: black;
            text-align: center;
            margin: 20px 10px 0;
        }

        h2 {
            color: #005D52;
            text-align: center;
            margin-top: 20px;
        }

        p {
            font-size: 1.1em;
            line-height: 1.6;
            color: #000;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
            max-width: 700px;
            width: 90%;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
            color: #000;
            text-align: left;
        }

        input[type="text"],
        input[type="email"],
        select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #ffcc00;
            color: #000;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        input[type="submit"]:hover {
            background-color: #e6b800;
        }

        a {
            color: #005D52
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            h1, h2, h3 {
                font-size: 1.2em;
            }

            p {
                font-size: 1em;
            }
        }
    </style>
</head>
<body>

    <h1>Instituto Superior Tecnológico Superarse</h1>
    <h3>Programa de becas de Inglés nivel A1 "Because He Is Nice"</h3>

    <div class="container">
        <h2>Estimado/a estudiante:</h2>
        <p>El Instituto Superior Tecnológico Superarse te da la más cordial bienvenida al programa de beca "Because He Is Nice".</p>
        <p>Para iniciar, completa tu registro y únete al grupo oficial de WhatsApp, donde compartiremos información clave durante el programa.</p>

        <h2>Buscar por cédula</h2>
        <form method="POST">
            <label for="cedula">Cédula:</label>
            <input type="text" name="cedula" id="cedula" required>
            <input type="submit" name="buscar" value="Buscar">
        </form>

        <p>Recibirás en tu correo tu acceso a Moodle, donde vivirás una experiencia enriquecedora de aprendizaje en inglés (nivel A1).</p>

        <p>¿Tienes inconvenientes? Contáctanos: <a href="https://wa.me/593992531588">0992531588</a> o <a href="mailto:ingles@superarse.edu.ec">ingles@superarse.edu.ec</a></p>
    </div>

    <?php
    include "conexion.php";

    if (isset($_POST['buscar'])) {
        $cedula = $_POST['cedula'];
        $sql = "SELECT * FROM usuarios WHERE cedula='$cedula'";
        $res = $conexion->query($sql);
        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            ?>
            <div class="container">
                <form action="procesar.php" method="POST">
                    <input type="hidden" name="cedula" value="<?= $row['cedula'] ?>">
                    <label>Nombres:</label>
                    <input type="text" name="nombres" value="<?= $row['nombres'] ?>" readonly>

                    <label>Apellidos:</label>
                    <input type="text" name="apellidos" value="<?= $row['apellidos'] ?>" readonly>

                    <label>Correo:</label>
                    <input type="email" name="correo" value="<?= $row['correo'] ?>" readonly>

                    <label>Ciudad:</label>
                    <input type="text" name="ciudad" required>

                    <label>Provincia:</label>
                    <select name="provincia" required>
                        <option value="">Seleccione una provincia</option>
                        <option>Azuay</option>
                        <option>Bolívar</option>
                        <option>Cañar</option>
                        <option>Carchi</option>
                        <option>Chimborazo</option>
                        <option>Cotopaxi</option>
                        <option>El Oro</option>
                        <option>Esmeraldas</option>
                        <option>Galápagos</option>
                        <option>Guayas</option>
                        <option>Imbabura</option>
                        <option>Loja</option>
                        <option>Los Ríos</option>
                        <option>Manabí</option>
                        <option>Morona Santiago</option>
                        <option>Napo</option>
                        <option>Orellana</option>
                        <option>Pastaza</option>
                        <option>Pichincha</option>
                        <option>Santa Elena</option>
                        <option>Santo Domingo de los Tsáchilas</option>
                        <option>Sucumbíos</option>
                        <option>Tungurahua</option>
                        <option>Zamora Chinchipe</option>
                    </select>

                    <input type="submit" value="Guardar">
                </form>
            </div>
            <?php
        } else {
            echo "<script>
                if (confirm('Usted no está registrado con el Instituto Superarse. ¿Desea contactar a SENESCYT?')) {
                    window.location.href = 'https://siau.senescyt.gob.ec/because-he-is-nice/';
                } else {
                    window.location.href = 'index.php';
                }
            </script>";
        }
    }
    ?>
</body>
</html>
