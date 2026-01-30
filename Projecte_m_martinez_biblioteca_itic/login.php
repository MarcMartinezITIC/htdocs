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
            <input type="password" id="contrasenya" name="contrasenya" required placeholder="La teva contrasenya">

            <button type="submit" style="width: 100%;">Iniciar sessió</button>
        </form>

        <p>No tens compte? <a href="registre.php">Registra't aquí</a></p>
    </div>

</body>

</html>