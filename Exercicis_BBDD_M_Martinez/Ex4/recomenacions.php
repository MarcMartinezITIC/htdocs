<?php
if (isset($_POST['musica'])) {
    $musica = $_POST['musica'];

    if ($musica == "rock") {
        echo "<p> Et recomano escoltar: ACDC, Red Hot Chili Peppers, The Beatles</p>";
    } elseif ($musica == "pop") {
        echo "<p>El recomano Michael Jackson, Madonna,Lady Gaga, Shakira</p>";
    } elseif ($musica == "heavy-metal") {
        echo "<p>El recomano Metalica, Guns n' Roses, Iron Maiden, Black Sabbath</p>";
    } elseif ($musica == "nu-metal") {
        echo "<p>Et Recomano Linkin Park, Limp Bizkit, Korn, System of a Down.</p>";
    }
} else {
    echo "<p>Selecciona un estil i fes clic a 'Enviar'.</p>";
}
?>