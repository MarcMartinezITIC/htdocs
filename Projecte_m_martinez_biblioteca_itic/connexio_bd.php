<?php
$host = 'localhost';
$bd = 'biblioteca_bd';
$usuari = 'root';
$contrasenya = '';  // Canvia si cal

$conn = mysqli_connect($host, $usuari, $contrasenya, $bd);
if (!$conn) {
    die("Connexió fallida: " . mysqli_connect_error());
}
?>