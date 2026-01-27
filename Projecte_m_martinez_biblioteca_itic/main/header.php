<?php
session_start();
?>
<header style="background: #f4f4f4; padding: 10px; border-bottom: 1px solid #ccc;">
    <h1>Biblioteca Virtual</h1>
    <nav>
        <a href="index.php">Inici</a> |
        <?php if (isset($_SESSION['user_id'])): ?>
            Benvingut, <strong><?php echo $_SESSION['user_nom']; ?></strong> (<?php echo $_SESSION['user_rol']; ?>) |
            <a href="cataleg.php">Catàleg</a> |
            <?php if ($_SESSION['user_rol'] == 'admin'): ?>
                <a href="gestio_llibres.php">Gestió (CRUD)</a> |
            <?php endif; ?>
            <a href="logout.php">Sortir</a>
        <?php else: ?>
            <a href="login.php">Login</a> | <a href="registre.php">Registre</a>
        <?php endif; ?>
    </nav>
</header>