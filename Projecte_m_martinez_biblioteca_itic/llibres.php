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
            $titol = mysqli_real_escape_string($conn, $_POST['titol']);
            $autor_id = (int) $_POST['autor_id'];
            $descripcio = mysqli_real_escape_string($conn, $_POST['descripcio']);
            $data_publicacio = $_POST['data_publicacio'];
            $preu = (float) $_POST['preu'];
            if (empty($titol) || empty($autor_id)) {
                header("Location: error.php?msg=Camps buits");
                exit();
            }
            $query = "INSERT INTO llibres (titol, autor_id, descripcio, data_publicacio, preu) VALUES ('$titol', $autor_id, '$descripcio', '$data_publicacio', $preu)";
            mysqli_query($conn, $query);
        } elseif ($accio == 'actualitzar') {
            $id = (int) $_POST['id'];
            $titol = mysqli_real_escape_string($conn, $_POST['titol']);
            $autor_id = (int) $_POST['autor_id'];
            $descripcio = mysqli_real_escape_string($conn, $_POST['descripcio']);
            $data_publicacio = $_POST['data_publicacio'];
            $preu = (float) $_POST['preu'];
            if (empty($titol) || empty($autor_id)) {
                header("Location: error.php?msg=Camps buits");
                exit();
            }
            $query = "UPDATE llibres SET titol='$titol', autor_id=$autor_id, descripcio='$descripcio', data_publicacio='$data_publicacio', preu=$preu WHERE id=$id";
            mysqli_query($conn, $query);
        } elseif ($accio == 'eliminar') {
            $id = (int) $_POST['id'];
            // Comprova si hi ha prestecs actius
            $query = "SELECT * FROM prestecs WHERE llibre_id=$id AND estat='actiu'";
            if (mysqli_num_rows(mysqli_query($conn, $query)) > 0) {
                header("Location: error.php?msg=No es pot eliminar un llibre prestat");
                exit();
            }
            $query = "DELETE FROM llibres WHERE id=$id";
            mysqli_query($conn, $query);
        }
    }
}

// Cerca i Ordenació
$cerca = isset($_GET['cerca']) ? mysqli_real_escape_string($conn, $_GET['cerca']) : '';
$ordre = isset($_GET['ordre']) ? $_GET['ordre'] : 'titol';  // titol o data_publicacio
$ordre_sql = ($ordre == 'data_publicacio') ? 'data_publicacio DESC' : 'titol ASC';

$on = $cerca ? "WHERE titol LIKE '%$cerca%' OR autors.nom LIKE '%$cerca%'" : '';
$query = "SELECT llibres.*, autors.nom AS nom_autor FROM llibres JOIN autors ON llibres.autor_id = autors.id $on ORDER BY $ordre_sql";
$result = mysqli_query($conn, $query);

// Mostra llista
echo "<h2>Llibres</h2>";
if ($es_bibliotecari) {
    // Formulari per crear
    echo "<h3>Afegir Llibre</h3>";
    echo "<form method='POST'>
        <input type='hidden' name='accio' value='crear'>
        Títol: <input name='titol' required><br>
        Autor ID: <input name='autor_id' type='number' required><br>
        Descripció: <textarea name='descripcio'></textarea><br>
        Data Publicació: <input name='data_publicacio' type='date'><br>
        Preu: <input name='preu' type='number' step='0.01'><br>
        <button>Afegir</button>
    </form>";
}
echo "<form method='GET'>Cerca: <input name='cerca'><button>Cercar</button></form>";
echo "<a href='?ordre=titol'>Ordenar per Títol</a> | <a href='?ordre=data_publicacio'>Ordenar per Data</a>";
echo "<table border='1'><tr><th>ID</th><th>Títol</th><th>Autor</th><th>Accions</th></tr>";
while ($fila = mysqli_fetch_assoc($result)) {
    echo "<tr><td>{$fila['id']}</td><td>{$fila['titol']}</td><td>{$fila['nom_autor']}</td>";
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
                Títol: <input name='titol' value='{$fila['titol']}'><br>
                Autor ID: <input name='autor_id' value='{$fila['autor_id']}'><br>
                Descripció: <textarea name='descripcio'>{$fila['descripcio']}</textarea><br>
                Data: <input name='data_publicacio' value='{$fila['data_publicacio']}' type='date'><br>
                Preu: <input name='preu' value='{$fila['preu']}'><br>
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