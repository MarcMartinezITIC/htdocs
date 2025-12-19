<?php
$a="Nicolas";
$b="Nicolas@iticbcn.cat";
$c="IC01";

$conexion=mysqli_connect ("localhost","root","", "basel")
    or die("Problemas con la conexión");

$query="insert into alumnos(nombre,email,codigocurso) value('$a','$b','$c')";

mysqli_query ($conexion, "insert into alumnos (nombre, email, codigocurso) "
. "values (' $ REQUEST [nombre] ' , '$ REQUEST [email] ' , $ REQUEST [codigocurso] ) ")
or die("Problemas en el select".mysqli_error ($conexion) );

mysqli_close ($conexion);

echo "El alumno fue dado de alta.";

?>