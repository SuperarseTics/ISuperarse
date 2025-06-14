<?php
include "conexion.php"; // Incluir archivo de conexión

if (isset($_POST['cedula'])) {
    $cedula = trim($_POST['cedula']);

    // Validar cédula de 10 dígitos
    if (empty($cedula) || !preg_match('/^\d{10}$/', $cedula)) {
        echo "<script>alert('Por favor ingresa una cédula válida de 10 dígitos.');</script>";
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE cedula = ?");
        $stmt->execute([$cedula]);

        if ($row = $stmt->fetch()) {
            $ciudad = $row['ciudad'] ?? '';
            $provincia = $row['provincia'] ?? '';

            $ciudadReadonly = !empty($ciudad) ? 'readonly' : '';
            $botonTexto = (!empty($ciudad) && !empty($provincia)) ? 'Continuar' : 'Guardar';
            ?>
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
                    <input type="text" name="ciudad" value="<?= htmlspecialchars($ciudad) ?>" <?= $ciudadReadonly ?> required>

                    <label>Provincia:</label>
                    <?php if (!empty($provincia)) : ?>
                        <input type="text" name="provincia" value="<?= htmlspecialchars($provincia) ?>" readonly required>
                    <?php else: ?>
                        <select name="provincia" required>
                            <option value="">Seleccione una provincia</option>
                            <?php
                            $provincias = [
                                "Azuay", "Bolívar", "Cañar", "Carchi", "Chimborazo", "Cotopaxi", "El Oro", "Esmeraldas", "Galápagos",
                                "Guayas", "Imbabura", "Loja", "Los Ríos", "Manabí", "Morona Santiago", "Napo", "Orellana", "Pastaza",
                                "Pichincha", "Santa Elena", "Santo Domingo de los Tsáchilas", "Sucumbíos", "Tungurahua", "Zamora Chinchipe"
                            ];
                            foreach ($provincias as $prov) {
                                echo "<option value='$prov'>$prov</option>";
                            }
                            ?>
                        </select>
                    <?php endif; ?>

                    <input type="submit" value="<?= $botonTexto ?>">
                </form>
            </div>
            <?php
        } else {
            // Mostrar mensaje informativo si no se encuentra la cédula
            ?>
            <div id="modal-form-content">
                <h2>Cédula no encontrada</h2>
                <p style="color: red; font-weight: bold;">No se encontró tu número de cédula en el sistema</p>
                <p>Por favor, asegúrate de haber firmado el contrato en la Coordinación Zonal de la Senescyt asignada y de que tu cooperante sea el Instituto Tecnológico Superarse.</p>
                <p>Si firmaste el contrato la semana pasada, te pedimos regresar la próxima semana. La Senescyt actualiza los listados de becarios semanalmente, y una vez que tu información conste en ellos, el Instituto podrá continuar con el proceso de matrícula, el cual toma aproximadamente una semana adicional.</p>
                <br>
                <a href="index.php">Volver al inicio</a>
            </div>
            <?php
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error de conexión con la base de datos. Por favor, inténtelo más tarde.');</script>";
        error_log("Error en la consulta de la base de datos: " . $e->getMessage());
    }
} else {
    echo "<script>alert('Por favor ingresa una cédula válida.');</script>";
}
?>