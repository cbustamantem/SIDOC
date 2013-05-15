<?php
function FN_NET_LOGGER($vp_mensaje, $vp_debug_level =0, $vp_criticidad="")
{
     /*
      * NIVELES DE DEBUG
      * ----
      * 0 BASICO
      * 1 MEDIO
      * 2 ALTO
      * 3 MUY ALTO
      * 4
      * 5
      *
      * CRITICIDAD
      * -----------
      * WARN -> ERRORES DE ADVERTENCIA
      *
      */
	FN_FILE_LOGGER($vp_mensaje);
}
function FN_LOG($vp_message)
{
	FN_FILE_LOGGER($vp_message);
}
function FN_FILE_LOGGER($vp_mensaje)
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

?>
