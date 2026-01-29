<?php
include 'header.php';
include 'connexio_bd.php';
if (!isset($_SESSION['usuari_id'])) {
    header("Location: login.php");
    exit();
}

$es_bibliotecari = ($_SESSION['usuari_rol'] == 'bibliotecari');
$usuari_id = $_SESSION['usuari_id'];

// Gestiona creació de prestec (per socis)
if (!$es_bibliotecari && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accio']) && $_POST['accio'] == 'prestar') {
    $llibre_id = (int) $_POST['llibre_id'];
    // Comprova si disponible
    $query = "SELECT * FROM llibres WHERE id=$llibre_id AND estat='disponible'";
    if (mysqli_num_rows(mysqli_query($conn, $query)) == 0) {
        header("Location: error.php?msg=Llibre no disponible");
        exit();
    }
    $query = "INSERT INTO prestecs (usuari_id, llibre_id) VALUES ($usuari_id, $llibre_id)";
    mysqli_query($conn, $query);
    $query = "UPDATE llibres SET estat='prestat' WHERE id=$llibre_id";
    mysqli_query($conn, $query);
}

// Gestiona retorn (per bibliotecaris)
if ($es_bibliotecari && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accio']) && $_POST['accio'] == 'retornar') {
    $id = (int) $_POST['id'];
    $llibre_id = (int) $_POST['llibre_id'];
    $query = "UPDATE prestecs SET estat='retornat', data_retorn=CURDATE() WHERE id=$id";
    mysqli_query($conn, $query);
    $query = "UPDATE llibres SET estat='disponible' WHERE id=$llibre_id";
    mysqli_query($conn, $query);
}

// Mostra prestecs
$on = $es_bibliotecari ? "" : "WHERE usuari_id=$usuari_id";
$query = "SELECT prestecs.*, usuaris.nom AS nom_usuari, llibres.titol AS titol_llibre FROM prestecs 
          JOIN usuaris ON prestecs.usuari_id = usuaris.id 
          JOIN llibres ON prestecs.llibre_id = llibres.id $on";
$result = mysqli_query($conn, $query);

echo "<h2>Prestecs</h2>";
if (!$es_bibliotecari) {
    // Formulari per prestar (llista de llibres disponibles)
    echo "<h3>Prestar un Llibre</h3>";
    $query_llibres = "SELECT id, titol FROM llibres WHERE estat='disponible'";
    $result_llibres = mysqli_query($conn, $query_llibres);
    echo "<form method='POST'>
        <input type='hidden' name='accio' value='prestar'>
        Llibre: <select name='llibre_id'>";
    while ($llibre = mysqli_fetch_assoc($result_llibres)) {
        echo "<option value='{$llibre['id']}'>{$llibre['titol']}</option>";
    }
    echo "</select><br>
        <button>Prestar</button>
    </form>";
}
echo "<table border='1'><tr><th>ID</th><th>Usuari</th><th>Llibre</th><th>Data Prestec</th><th>Estat</th><th>Accions</th></tr>";
while ($fila = mysqli_fetch_assoc($result)) {
    echo "<tr><td>{$fila['id']}</td><td>{$fila['nom_usuari']}</td><td>{$fila['titol_llibre']}</td><td>{$fila['data_prestec']}</td><td>{$fila['estat']}</td>";
    if ($es_bibliotecari && $fila['estat'] == 'actiu') {
        echo "<td>
            <form method='POST'>
                <input type='hidden' name='accio' value='retornar'>
                <input type='hidden' name='id' value='{$fila['id']}'>
                <input type='hidden' name='llibre_id' value='{$fila['llibre_id']}'>
                <button>Retornar</button>
            </form>
        </td>";
    } else {
        echo "<td></td>";
    }
    echo "</tr>";
}
echo "</table>";
?>
</body>

</html>