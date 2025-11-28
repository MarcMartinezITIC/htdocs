<!DOCTYPE html>
<html lang="ca">
<head>
    <title>Exericici_1</title>
</head>
<body>
    <form action="/exercicis_practica_php_m_martinez/Ex1/resposta.php" method="POST">
    Nom: <input type="text" name="nom"> <br> <br>
    Cognom: <input type="text" name="cognom"> <br> <br>
    E-mail: <input type="email" name="email"> <br> <br>
    Genere: <br>
    <input type="radio" name="genere" value="Home">Home
    <input type="radio" name="genere" value="Dona">Dona
    <input type="radio" name="genere" value="altre"> Altre <br> <br>
    Missatge: <br>
    <textarea name="missatge" rows="5" cols="40" placeholder="Escriu el teu missatge"></textarea>
    <br>
    <input type="submit">
    </form>
</body>
</html>