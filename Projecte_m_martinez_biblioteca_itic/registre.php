<?php
include 'connexio_bd.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contrasenya = $_POST['contrasenya'];
    $confirmar_contrasenya = $_POST['confirmar_contrasenya'];
    $rol = 'soci';  // Rol per defecte

    if (empty($nom) || empty($email) || empty($contrasenya) || empty($confirmar_contrasenya)) {
        header("Location: error.php?msg=Camps buits");
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: error.php?msg=Email invàlid");
        exit();
    }
    if ($contrasenya !== $confirmar_contrasenya) {
        header("Location: error.php?msg=Les contrasenyes no coincideixen");
        exit();
    }

    $query = "SELECT * FROM usuaris WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        header("Location: error.php?msg=Email ja existeix");
        exit();
    }

    $contrasenya_hash = password_hash($contrasenya, PASSWORD_DEFAULT);
    $query = "INSERT INTO usuaris (nom, email, contrasenya, rol) VALUES ('$nom', '$email', '$contrasenya_hash', '$rol')";
    if (mysqli_query($conn, $query)) {
        header("Location: login.php");
    } else {
        header("Location: error.php?msg=Registre fallit");
    }
}
?>
<form method="POST">
    Nom: <input type="text" name="nom" required><br>
    Email: <input type="email" name="email" required><br>
    Contrasenya: <input type="password" name="contrasenya" required><br>
    Confirmar Contrasenya: <input type="password" name="confirmar_contrasenya" required><br>
    <button type="submit">Registrar-se</button>
</form>