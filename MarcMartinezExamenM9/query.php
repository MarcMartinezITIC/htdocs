<!DOCTYPE html>
<head>
    <title>Resultat</title>
</head>
<body>
    
</body>
<?php
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "database.sql";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("No s'ha establert la conexio " . $conn->connect_error);
}
echo "Conectat correctament";
$genere = $_POST['genere'];

$sql = "SELECT ll.titol, ll.genere,autor,au.nom,au.pais FROM llibres INNER JOIN autors ON au.id=ll.id_autor AND WHERE genere == '$genere'";
$result = mysqli_query($conn, $sql);
echo "<h1>Llibres del genere $genere</h1>";
if (mysqli_num_rows($result) ==  $genere ) {
    echo "<table border='1'>";
    echo "<table><tr><th>Titol</th><th>Autor</th><th>Pais</th>Any_presentacio</tr>";
    
}


mysqli_close($conn);
?>
</html>