<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname= "localhost";
$database= "db_elmejor";
$username= "elmejor";
$password= "mejor";
$conexion= mysql_connect($hostname, $username, $password) or die(mysql_error());

?>
