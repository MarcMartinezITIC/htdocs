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
            <div class="password-wrapper">
                <input type="password" id="contrasenya" name="contrasenya" required placeholder="Crea una contrasenya">
                <button type="button" class="password-toggle" onclick="togglePassword('contrasenya')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            </div>

            <label for="confirmar_contrasenya">Confirmar Contrasenya</label>
            <div class="password-wrapper">
                <input type="password" id="confirmar_contrasenya" name="confirmar_contrasenya" required
                    placeholder="Repeteix la contrasenya">
                <button type="button" class="password-toggle" onclick="togglePassword('confirmar_contrasenya')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            </div>

            <button type="submit" style="width: 100%; margin-top: 10px;">Registrar-se</button>
        </form>

        <div class="auth-switch">
            <p>¿Ja tens compte?</p>
            <a href="login.php">Inicia sessió</a>
        </div>
    </div>

    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>
</body>

</html>