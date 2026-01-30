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
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <title>Registre - Biblioteca</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="auth-page">

    <div class="auth-container">
        <h1>Registrar-se</h1>
        <form method="POST" style="box-shadow: none; border: none; padding: 0; margin: 0;">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" required placeholder="El teu nom">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required placeholder="El teu email">

            <label for="contrasenya">Contrasenya</label>
            <input type="password" id="contrasenya" name="contrasenya" required placeholder="Crea una contrasenya">

            <label for="confirmar_contrasenya">Confirmar Contrasenya</label>
            <input type="password" id="confirmar_contrasenya" name="confirmar_contrasenya" required
                placeholder="Repeteix la contrasenya">

            <button type="submit" style="width: 100%;">Registrar-se</button>
        </form>

        <p>Ja tens compte? <a href="login.php">Inicia sessió</a></p>
    </div>

</body>

</html>