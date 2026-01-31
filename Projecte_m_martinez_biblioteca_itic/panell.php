<?php
include 'header.php';
include 'connexio_bd.php';
if (!isset($_SESSION['usuari_id'])) {
    header("Location: login.php");
    exit();
}

echo "<h2>Panell</h2>";
if ($_SESSION['usuari_rol'] == 'bibliotecari') {
    echo "<p class='panel-welcome'>Panell del bibliotecari: Gestiona llibres i autors.</p>";
} else {
    echo "<p class='panel-welcome'>Panell del soci: Presta llibres i veu prestecs.</p>";
}
?>
</body>

</html>