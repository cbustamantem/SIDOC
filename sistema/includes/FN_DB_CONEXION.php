<?php
function FN_DB_CONEXION()
{

	$vlf_conexion = mssql_connect("192.168.12.201","tera","infinito") or die("No se pudo realizar la conexion");
	return $vlf_conexion;
}
?>
