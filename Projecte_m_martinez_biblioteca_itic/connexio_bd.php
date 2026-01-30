<?php
$host = 'localhost';
$bd = 'biblioteca_bd';
$usuari = 'root';
$contrasenya = '';

$conn = mysqli_connect($host, $usuari, $contrasenya, $bd);
if (!$conn) {
    die("Connexió fallida: " . mysqli_connect_error());
}
?>