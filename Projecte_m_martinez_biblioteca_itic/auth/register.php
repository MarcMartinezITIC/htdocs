<?php
include '/Projecte_m_martinez_biblioteca_itic/main/header.php';
include '/Projecte_m_martinez_biblioteca_itic/main/bliblioteca.sql';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuaris (nom, email, password, rol) VALUES ('$nom', '$email', '$pass', 'lector')";

    if (mysqli_query($conn, $sql)) {
        header("Location: login.php");
    } else {
        header("Location: error.php?m=L'email ja existeix");
    }
}
?>
<form method="POST">
    <h3>Crea el teu compte</h3>
    Nom: <input type="text" name="nom" required><br>
    Email: <input type="email" name="email" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit">Registrar-se</button>
</form>