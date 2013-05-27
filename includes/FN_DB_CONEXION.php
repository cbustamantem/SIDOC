<?php
function FN_DB_MYSQL_CONEXION()
{
	$vlf_conexion = mysql_connect("localhost","bd_sidoc","bd_sidoc") or die("No se pudo realizar la conexion");	
	// make foo the current db
	$db_selected = mysql_select_db("bd_sidoc",$vlf_conexion);
	if (!$db_selected) 
	{
	    die ('No se puede conectar a  bd_consultorio : ' . mysql_error());
	}
	
	return $vlf_conexion;
}
?>
