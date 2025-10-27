<!DOCTYPE html>
<html lang="en">
<head>
    <title>Calculadora IVA</title>
</head>
<body>
    <h1>Calculadora d'IVA</h1>
    <form action="/exercicis_practica_php_m_martinez/Ex5/calculadoriva.php" method="post">
    
    <label>Introdueix el preu sense IVA:</label><br>
    <input type="number" name="preu"  placeholder="Ex: 10"<br><br>

    <label>Escull el tipus d'IVA:</label><br>
    <input type="radio" name="iva" value="4"> 4%<br>
    <input type="radio" name="iva" value="10"> 10%<br>
    <input type="radio" name="iva" value="21"> 21%<br><br>

    <input type="submit" value="Calcular">

    </form>
    
</body>
</html>