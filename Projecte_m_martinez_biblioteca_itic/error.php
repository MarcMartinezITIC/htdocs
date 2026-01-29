<?php
include 'header.php';
$missatge_error = isset($_GET['msg']) ? $_GET['msg'] : 'Ha ocorregut un error desconegut.';
?>
<h2>Error</h2>
<p><?php echo htmlspecialchars($missatge_error); ?></p>
<a href="index.html">Tornar a l'inici</a>
</body>

</html>