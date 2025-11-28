<?php
$con=mysqli_connect ("localhost", "root", "", "mibd")
    or die ("Error conexion ".mysqli_error());
$SQL="SELECT id, name FROM mitabla; ";
$registros=mysqli_query ($con, $SQL)
    or die (mysql_error () );
echo "<table border=1> <tr> <td>id <td>nombre";
while ($registro=mysqli_fetch_row ($registros) ) {
    echo "<tr><td>". $registro [0] ."<td>". $registro[1];
}
echo "</table>";

?>