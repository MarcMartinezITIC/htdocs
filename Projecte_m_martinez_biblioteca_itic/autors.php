<?php
include 'header.php';
include 'connexio_bd.php';
if (!isset($_SESSION['usuari_id'])) {
    header("Location: login.php");
    exit();
}

$es_bibliotecari = ($_SESSION['usuari_rol'] == 'bibliotecari');

// Gestiona accions CRUD
if ($es_bibliotecari && $_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['accio'])) {
        $accio = $_POST['accio'];
        if ($accio == 'crear') {
            $nom = mysqli_real_escape_string($conn, $_POST['nom']);
            $biografia = mysqli_real_escape_string($conn, $_POST['biografia']);
            if (empty($nom)) {
                header("Location: error.php?msg=Camps buits");
                exit();
            }
            $query = "INSERT INTO autors (nom, biografia) VALUES ('$nom', '$biografia')";
            mysqli_query($conn, $query);
        } elseif ($accio == 'actualitzar') {
            $id = (int) $_POST['id'];
            $nom = mysqli_real_escape_string($conn, $_POST['nom']);
            $biografia = mysqli_real_escape_string($conn, $_POST['biografia']);
            if (empty($nom)) {
                header("Location: error.php?msg=Camps buits");
                exit();
            }
            $query = "UPDATE autors SET nom='$nom', biografia='$biografia' WHERE id=$id";
            mysqli_query($conn, $query);
        } elseif ($accio == 'eliminar') {
            $id = (int) $_POST['id'];
            // Comprova si hi ha llibres relacionats
            $query = "SELECT * FROM llibres WHERE autor_id=$id";
            if (mysqli_num_rows(mysqli_query($conn, $query)) > 0) {
                header("Location: error.php?msg=No es pot eliminar autor amb llibres relacionats");
                exit();
            }
            $query = "DELETE FROM autors WHERE id=$id";
            mysqli_query($conn, $query);
        }
    }
}

// Mostra llista
$query = "SELECT * FROM autors";
$result = mysqli_query($conn, $query);

echo "<h2>Autors</h2>";
if ($es_bibliotecari) {
    // Formulari per crear
    echo "<h3>Afegir Autor</h3>";
    echo "<form method='POST'>
        <input type='hidden' name='accio' value='crear'>
        Nom: <input name='nom' required><br>
        Biografia: <textarea name='biografia'></textarea><br>
        <button>Afegir</button>
    </form>";
}
echo "<table border='1'><tr><th>ID</th><th>Nom</th><th>Accions</th></tr>";
while ($fila = mysqli_fetch_assoc($result)) {
    echo "<tr><td>{$fila['id']}</td><td>{$fila['nom']}</td>";
    if ($es_bibliotecari) {
        echo "<td>
            <form method='POST' style='display:inline;'>
                <input type='hidden' name='accio' value='eliminar'>
                <input type='hidden' name='id' value='{$fila['id']}'>
                <button>Eliminar</button>
            </form>
            <form method='POST' style='display:inline;'>
                <input type='hidden' name='accio' value='actualitzar'>
                <input type='hidden' name='id' value='{$fila['id']}'>
                Nom: <input name='nom' value='{$fila['nom']}'><br>
                Biografia: <textarea name='biografia'>{$fila['biografia']}</textarea><br>
                <button>Actualitzar</button>
            </form>
        </td>";
    }
    echo "</tr>";
}
echo "</table>";
?>
</body>

</html>