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
            color: #005D52;
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

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.7);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
            color: #000;
            position: relative;
        }

        .close {
            color: #aaa;
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            cursor: pointer;
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
        <form id="buscar-form">
            <label for="cedula">Cédula:</label>
            <input type="text" name="cedula" id="cedula" required>
            <input type="submit" name="buscar" value="Buscar">
        </form>

        <p>Recibirás en tu correo tu acceso a Moodle, donde vivirás una experiencia enriquecedora de aprendizaje en inglés (nivel A1).</p>

        <p>¿Tienes inconvenientes? Contáctanos: <a href="https://wa.me/593992531588">0992531588</a> o <a href="mailto:ingles@superarse.edu.ec">ingles@superarse.edu.ec</a></p>
    </div>

    <!-- Modal -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="modal-body"></div>
        </div>
    </div>

    <script>
    document.getElementById("buscar-form").addEventListener("submit", function(e) {
        e.preventDefault();
        const cedula = document.getElementById("cedula").value;

        fetch("buscar.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "cedula=" + encodeURIComponent(cedula)
        })
        .then(response => response.text())
        .then(html => {
            if (html.includes("modal-form-content")) {
                document.getElementById("modal-body").innerHTML = html;
                document.getElementById("modal").style.display = "block";
            } else {
                document.body.innerHTML = html; // Redirige si es necesario
            }
        });
    });

    // Cerrar el modal
    document.addEventListener("click", function(e) {
        if (e.target.matches(".close") || e.target.matches(".modal")) {
            document.getElementById("modal").style.display = "none";
        }
    });
    </script>

</body>
</html>
