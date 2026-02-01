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

    $login_successful = false;

    if ($usuari) {
        // 1. Comprova si la contrasenya és un hash vàlid
        if (password_verify($contrasenya, $usuari['contrasenya'])) {
            $login_successful = true;
        }
        // 2. Si no, comprova si és text pla (per a usuaris antics)
        elseif ($contrasenya === $usuari['contrasenya']) {
            // Si es correcte l'actualitzarem en hash
            $nou_hash = password_hash($contrasenya, PASSWORD_DEFAULT);
            $update_query = "UPDATE usuaris SET contrasenya='$nou_hash' WHERE id=" . (int) $usuari['id'];
            mysqli_query($conn, $update_query);
            $login_successful = true;
        }
    }

    if ($login_successful) {
        $_SESSION['usuari_id'] = $usuari['id'];
        $_SESSION['usuari_nom'] = $usuari['nom'];
        $_SESSION['usuari_rol'] = $usuari['rol'];
        header("Location: panell.php");
        exit();
    } else {
        header("Location: error.php?msg=Credencials invàlides");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <title>Iniciar Sessió - Biblioteca</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="auth-page">

    <div class="auth-container">
        <h1>Benvingut</h1>
        <?php if (isset($_GET['msg'])): ?>
            <div class="error"><?php echo htmlspecialchars($_GET['msg']); ?></div>
        <?php endif; ?>

        <form method="POST" style="box-shadow: none; border: none; padding: 0; margin: 0;">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required placeholder="El teu email">

            <label for="contrasenya">Contrasenya</label>
            <div class="password-wrapper">
                <input type="password" id="contrasenya" name="contrasenya" required placeholder="La teva contrasenya">
                <button type="button" class="password-toggle" onclick="togglePassword('contrasenya')"
                    title="Mostra/Amaga contrasenya">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            </div>

            <button type="submit" style="width: 100%; margin-top: 10px;">Iniciar sessió</button>
        </form>

        <div class="auth-switch">
            <p>¿Encara no tens compte?</p>
            <a href="registre.php">Crea un compte gratuït</a>
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