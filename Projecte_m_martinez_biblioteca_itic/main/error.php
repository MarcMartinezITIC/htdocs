<?php include 'header.php'; ?>
<div style="color: red; padding: 20px;">
    <h2>Error detectat</h2>
    <p>
        <?php
        $e = $_GET['m'] ?? 'Error desconegut';
        echo htmlspecialchars($e);
        ?>
    </p>
    <a href="index.html">Tornar a l'inici</a>
</div>