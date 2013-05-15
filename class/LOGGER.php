<?php
class LOGGER 
{
	public static function LOG($vp_mensaje)
	{
		global $vg_path_app;
		//VERIFICA LA FECHA DEL DÍA
		$vf_fecha=date("m-d-y");
		//ARMA LA ESTAMPA DE TIEMPO
		//$vf_estampa_tiempo=date('l jS \of F Y h:i:s A');
		$vf_estampa_tiempo=date("D M j G:i:s T Y");
		//INGRESA EL LOG
		$vf_nombre_archivo = "/var/www/fundacion/logs/logs_".$vf_fecha.".log";
	
		$vf_file_handler = fopen("$vf_nombre_archivo", 'a');
	
		fwrite($vf_file_handler, $vf_estampa_tiempo.": ".$vp_mensaje."\n");
		fclose($vf_file_handler);
	}
	

}

?>