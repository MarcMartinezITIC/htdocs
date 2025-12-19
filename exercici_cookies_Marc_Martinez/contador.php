<?php
$comptador = 1;

if (isset($_COOKIE['comptador'])) {
    $comptador = $_COOKIE['comptador'] + 1;
}

setcookie("comptador", $comptador, time() + (86400 * 30));
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Comptador de Visites</title>
</head>
<body>
    <h3>Has visitat aquesta pàgina <?php echo $comptador; ?> vegades.</h3>

    <?php
    if ($comptador >= 10) {
        echo "<p><strong>Oferta exclusiva només per a tu!</strong> Utilitza el codi <b>BOTIGA50</b> per obtenir un 50% de descompte en les teves primeres compres a la botiga.</p>";
    } elseif ($comptador >= 5) {
        echo "<p><strong>Oferta exclusiva!</strong> Utilitza el codi <b>BOTIGA20</b> per obtenir un 20% de descompte en les teves primeres compres a la botiga.</p>";
    }
    ?>

    <form action="#" method="post">
        <label for="codi_descompte">Codi de descompte:</label>
        <input type="text" id="codi_descompte" name="codi_descompte">
        <button type="submit">Comprar</button>
    </form>
</body>
</html>
