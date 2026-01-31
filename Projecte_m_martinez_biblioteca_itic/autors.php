<?php
include 'header.php';
include 'connexio_bd.php';
if (!isset($_SESSION['usuari_id'])) {
    header("Location: login.php");
    exit();
}

$es_bibliotecari = ($_SESSION['usuari_rol'] == 'bibliotecari');

// CRUD
if ($es_bibliotecari && $_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['accio'])) {
        $accio = $_POST['accio'];
        if ($accio == 'crear') {
            $nom = mysqli_real_escape_string($conn, $_POST['nom']);
            $biografia = mysqli_real_escape_string($conn, $_POST['biografia']);
            $custom_id = (int) $_POST['custom_id'];

            if (empty($nom)) {
                header("Location: error.php?msg=Camps buits");
                exit();
            }

            // Si es posa un ID manual, l'utilitzem
            if (!empty($custom_id) && $custom_id > 0) {
                // Comprovem si ja existeix
                $check = mysqli_query($conn, "SELECT id FROM autors WHERE id=$custom_id");
                if (mysqli_num_rows($check) > 0) {
                    header("Location: error.php?msg=ID ja existent");
                    exit();
                }
                $query = "INSERT INTO autors (id, nom, biografia) VALUES ($custom_id, '$nom', '$biografia')";
            } else {
                $query = "INSERT INTO autors (nom, biografia) VALUES ('$nom', '$biografia')";
            }
            mysqli_query($conn, $query);

        } elseif ($accio == 'actualitzar') {
            $old_id = (int) $_POST['original_id'];
            $new_id = (int) $_POST['id'];
            $nom = mysqli_real_escape_string($conn, $_POST['nom']);
            $biografia = mysqli_real_escape_string($conn, $_POST['biografia']);

            if (empty($nom)) {
                header("Location: error.php?msg=Camps buits");
                exit();
            }

            // Si canvia l'ID, comprovem duplicats
            if ($old_id != $new_id) {
                $check = mysqli_query($conn, "SELECT id FROM autors WHERE id=$new_id");
                if (mysqli_num_rows($check) > 0) {
                    header("Location: error.php?msg=Nou ID ja existent");
                    exit();
                }
            }

            $query = "UPDATE autors SET id=$new_id, nom='$nom', biografia='$biografia' WHERE id=$old_id";
            if (!mysqli_query($conn, $query)) {
                header("Location: error.php?msg=Error al actualitzar ID (Clau Prestat?)");
                exit();
            }

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

// Calcular següent ID
$row_id = mysqli_fetch_assoc(mysqli_query($conn, "SELECT MAX(id) + 1 as next_id FROM autors"));
$next_id = $row_id['next_id'] ? $row_id['next_id'] : 1;

// Mostrar llista
$query = "SELECT * FROM autors";
$result = mysqli_query($conn, $query);

echo "<h2>Autors</h2>";
if ($es_bibliotecari) {
    // Formulari
    echo "<h3>Afegir Autor</h3>";
    echo "<form method='POST'>
        <input type='hidden' name='accio' value='crear'>
        ID (Opcional): <input name='custom_id' type='number' value='$next_id' placeholder='Auto'><br>
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
            <br><br>
            <form method='POST' style='display:inline;'>
                <input type='hidden' name='accio' value='actualitzar'>
                <input type='hidden' name='original_id' value='{$fila['id']}'>
                ID: <input name='id' type='number' value='{$fila['id']}' style='width:60px'><br>
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