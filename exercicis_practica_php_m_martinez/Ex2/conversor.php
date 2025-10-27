<?php
if (isset($_POST['quantitat']) && isset($_POST['conversio'])) {
    $quantitat = $_POST['quantitat'];
    $conversio = $_POST['conversio'];

    $dollar_euro = 1.1;

    if ($conversio == "eur_usd") {
        $resultat = $quantitat * $euro_dollar;
        echo "<p>$quantitat € són $resultat $.</p>";
    } else {
        $resultat = $quantitat * $dollar_euro;
        echo "<p>$quantitat $ són $resultat €.</p>";
    }
} else {
    echo "<p>No s'han rebut dades</p>";
}
?>
