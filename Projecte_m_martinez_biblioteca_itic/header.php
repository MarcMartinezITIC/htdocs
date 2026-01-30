<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <title>Aplicació de Biblioteca</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <?php
        session_start();
        if (isset($_SESSION['usuari_id'])) {
            echo "<h1>Benvingut, " . $_SESSION['usuari_nom'] . " (" . $_SESSION['usuari_rol'] . ")</h1>";
            echo "<a href='logout.php'>Tancar sessió</a>";
        } else {
            echo "<h1>Aplicació de Biblioteca</h1>";
        }
        ?>
        <nav>
            <a href="panell.php">Panell</a> |
            <a href="llibres.php">Llibres</a> |
            <a href="autors.php">Autors</a> |
            <a href="prestecs.php">Prestecs</a>
        </nav>
    </header>