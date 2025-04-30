<?php
include "conexion.php"; // Asegúrate de que este archivo conecte bien a tu BD

if (isset($_POST['cedula'])) {
    $cedula = $_POST['cedula'];

    // Consulta en la base de datos
    $sql = "SELECT * FROM usuarios WHERE cedula = '$cedula'";
    $res = $conexion->query($sql);

    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        ?>
        <!-- Este contenido se inyectará dentro del modal del index.php -->
        <div id="modal-form-content">
            <h2>Completa tu información</h2>
            <form action="procesar.php" method="POST">
                <input type="hidden" name="cedula" value="<?= htmlspecialchars($row['cedula']) ?>">

                <label>Nombres:</label>
                <input type="text" name="nombres" value="<?= htmlspecialchars($row['nombres']) ?>" readonly>

                <label>Apellidos:</label>
                <input type="text" name="apellidos" value="<?= htmlspecialchars($row['apellidos']) ?>" readonly>

                <label>Correo:</label>
                <input type="email" name="correo" value="<?= htmlspecialchars($row['correo']) ?>" readonly>

                <label>Ciudad:</label>
                <input type="text" name="ciudad" required>

                <label>Provincia:</label>
                <select name="provincia" required>
                    <option value="">Seleccione una provincia</option>
                    <?php
                    $provincias = [
                        "Azuay","Bolívar","Cañar","Carchi","Chimborazo","Cotopaxi","El Oro","Esmeraldas","Galápagos",
                        "Guayas","Imbabura","Loja","Los Ríos","Manabí","Morona Santiago","Napo","Orellana","Pastaza",
                        "Pichincha","Santa Elena","Santo Domingo de los Tsáchilas","Sucumbíos","Tungurahua","Zamora Chinchipe"
                    ];
                    foreach ($provincias as $prov) {
                        echo "<option value='$prov'>$prov</option>";
                    }
                    ?>
                </select>

                <input type="submit" value="Guardar">
            </form>
        </div>
        <?php
    } else {
        // Si no se encuentra la cédula, muestra alerta con redirección
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
