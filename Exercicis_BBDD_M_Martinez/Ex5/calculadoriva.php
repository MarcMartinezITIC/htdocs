<?php
if (isset($_POST['preu']) && isset($_POST['iva'])) {
    $preu = $_POST['preu'];
    $iva = $_POST['iva'];
    
    $preu_final = $preu + ($preu * $iva / 100);

    echo "<p>Preu sense IVA: $preu €</p>";
    echo "<p>IVA: $iva %</p>";
    echo "<h3>Preu amb IVA: $preu_final €</h3>";
}
?>