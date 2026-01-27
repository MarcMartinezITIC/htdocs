<?php
include 'header.php';
include '/Projecte_m_martinez_biblioteca_itic/config/database.php';

if (!isset($_SESSION['user_rol']) || $_SESSION['user_rol'] != 'admin') {
    header("Location: error.php?m=Accés denegat. Només administradors.");
    exit();
}


if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    mysqli_query($conn, "DELETE FROM llibres WHERE id=$id");
    header("Location: gestio.php");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titol = $_POST['titol'];
    $autor = $_POST['autor'];
    $cat = $_POST['categoria'];
    mysqli_query($conn, "INSERT INTO llibres (titol, autor, id_categoria) VALUES ('$titol', '$autor', $cat)");
}

$llibres = mysqli_query($conn, "SELECT l.*, c.nom as cat_nom FROM llibres l JOIN categories c ON l.id_categoria = c.id");
?>

<h3>Gestió de Catàleg (Admin)</h3>
<form method="POST">
    <input type="text" name="titol" placeholder="Títol" required>
    <input type="text" name="autor" placeholder="Autor" required>
    <select name="categoria">
        <option value="1">Novel·la</option>
        <option value="2">Ciència</option>
        <option value="3">Història</option>
    </select>
    <button type="submit">Afegir Llibre</button>
</form>

<table border="1" style="margin-top:20px; width:100%;">
    <tr>
        <th>ID</th>
        <th>Títol</th>
        <th>Autor</th>
        <th>Categoria</th>
        <th>Accions</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($llibres)): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['titol']; ?></td>
            <td><?php echo $row['autor']; ?></td>
            <td><?php echo $row['cat_nom']; ?></td>
            <td><a href="gestio.php?eliminar=<?php echo $row['id']; ?>" onclick="return confirm('Segur?')"> Eliminar</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>