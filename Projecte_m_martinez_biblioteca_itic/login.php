<?php
include 'connexio_bd.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contrasenya = $_POST['contrasenya'];

    if (empty($email) || empty($contrasenya)) {
        header("Location: error.php?msg=Camps buits");
        exit();
    }

    $query = "SELECT * FROM usuaris WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    $usuari = mysqli_fetch_assoc($result);

    if ($usuari && password_verify($contrasenya, $usuari['contrasenya'])) {
        $_SESSION['usuari_id'] = $usuari['id'];
        $_SESSION['usuari_nom'] = $usuari['nom'];
        $_SESSION['usuari_rol'] = $usuari['rol'];
        header("Location: panell.php");
    } else {
        header("Location: error.php?msg=Credencials invàlides");
    }
}
?>
<form method="POST">
    Email: <input type="email" name="email" required><br>
    Contrasenya: <input type="password" name="contrasenya" required><br>
    <button type="submit">Iniciar sessió</button>
</form>