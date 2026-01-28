<?php
include 'header.php';
include 'db.php';

// Control d'accés: Redirecció si no està logat [cite: 27, 94]
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Lògica de cerca i ordenació [cite: 49, 56]
$search = $_GET['search'] ?? '';
$sql = "SELECT l.*, c.nom as cat_nom FROM llibres l 
        JOIN categories c ON l.id_categoria = c.id 
        WHERE l.titol LIKE '%$search%' 
        ORDER BY l.titol ASC"; // Ordenació alfabètica [cite: 57]

$resultat = mysqli_query($conn, $sql);
?>

<h3>Catàleg de Llibres</h3>

<form method="GET" style="margin-bottom: 20px;">
    <input type="text" name="search" placeholder="Cerca pel títol..." value="<?php echo htmlspecialchars($search); ?>">
    <button type="submit">Buscar</button>
</form>

<table border="1" style="width:100%; border-collapse: collapse;">
    <tr style="background: #ddd;">
        <th>Títol</th>
        <th>Autor</th>
        <th>Categoria</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($resultat)): ?>
        <tr>
            <td>
                <?php echo $row['titol']; ?>
            </td>
            <td>
                <?php echo $row['autor']; ?>
            </td>
            <td>
                <?php echo $row['cat_nom']; ?>
            </td>
        </tr>
    <?php endwhile; ?>
</table>