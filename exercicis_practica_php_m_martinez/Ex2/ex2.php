<!DOCTYPE html>
<html lang="en">
<head>
<title>Conversio Monetaria</title>
</head>
<body>
    <h1>Conversio de € a $</h1>

    <form action="/exercicis_practica_php_m_martinez/Ex2/conversor.php" method="post">
    <label>Quantitat:</label>
    <input type="number" name="quantitat" required> <br><br>

    <label>Conversió:</label>
    <select name="conversio">
    <option value="euro_dollar">Euros a Dòlars</option>
    <option value="dollar_euro">Dòlars a Euros</option>
    </select>

    <br><br>
    <input type="submit" value="Convertir">
</form>
    

    
</body>
</html>