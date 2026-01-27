<?php
include '/Projecte_m_martinez_biblioteca_itic/main/header.php';
include '/Projecte_m_martinez_biblioteca_itic/main/bliblioteca.sql';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM usuaris WHERE email='$email'");
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nom'] = $user['nom'];
        $_SESSION['user_rol'] = $user['rol'];
        header("Location: index.php");
    } else {
        header("Location: error.php?m=Dades incorrectes");
    }
}
?>
<form method="POST">
    <h3>Identifica't</h3>
    Email: <input type="email" name="email"><br>
    Password: <input type="password" name="password"><br>
    <button type="submit">Entrar</button>
</form>