<?php

$con=mysqli_connect ("localhost", "root","")
    or die (mysql_error());

mysqli_query ($con, "Create Database mibd")
    or die (mysql_error());
echo "Base de datos creada con exito";
mysqli_select_db ($con, "mibd")
    or die (mysql_error());
mysqli_query ($con, "CREATE TABLE mitabla (id integer, name varchar (20))")
    or die (mysql_error());
echo "Tabla creada con exito";
mysqli_query ($con, "INSERT INTO mitabla VALUES (1,'pedro')")
    or die (mysql_error ());
echo "Insercion realizada correctamente";
?>