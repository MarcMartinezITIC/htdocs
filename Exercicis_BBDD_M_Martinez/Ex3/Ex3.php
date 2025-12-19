<!DOCTYPE html>
<html lang="ca">
<head>
    <title>Hora diaria</title>
</head>
<body>
    <?php
    $hora=date("H");
    echo "<p>Hora actual: $hora</p>";
    if ($hora >= 5 && $hora < 14) {
    echo "<h2>Bon dia!</h2>";
} elseif ($hora >= 14 && $hora < 19) {
    echo "<h2>Bona tarda!</h2>";
} else {
    echo "<h2>Bona nit!</h2>";
}
    ?>
</body>
</html>