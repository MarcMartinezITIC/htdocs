<?php
include 'header.php';
?>

<main style="padding: 20px; text-align: center;">
    <h2>Biblioteca ITIC</h2>

    <?php if (isset($_SESSION['user_id'])): ?>
        <div style="background: #e8f4fd; padding: 20px; border-radius: 8px;">
            <p>Hola <strong><?php echo $_SESSION['user_nom']; ?></strong>!</p>
            <p>Com a <strong><?php echo $_SESSION['user_rol']; ?></strong>, ja pots gestionar els teus llibres</p>

            <?php if ($_SESSION['user_rol'] == 'admin'): ?>
                <p>Tens accés al panell d'administració</p>
                <a href="gestio.php"
                    style="button; padding: 10px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;">Anar
                    a Gestió</a>
            <?php else: ?>
                <p>Pots consultar el cataleg</p>
                <a href="cataleg.php"
                    style="button; padding: 10px; background: #28a745; color: white; text-decoration: none; border-radius: 5px;">Veure
                    Catàleg</a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div style="background: #fff3cd; padding: 20px; border-radius: 8px;">
            <p>No has iniciat sessió.</p>
            <p>Per gestionar i veure el cataleg registret</p>
            <a href="login.php">Fes login</a> o <a href="registre.php">Crea un compte nou</a>
        </div>
    <?php endif; ?>
</main>

<footer style="margin-top: 50px; font-size: 0.8em; color: gray;">
    <p>&copy;Projecte</p>
</footer>

</body>

</html>