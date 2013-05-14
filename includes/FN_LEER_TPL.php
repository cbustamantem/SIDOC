<?php
FUNCTION FN_LEER_TPL ($vp_tpl)
{
    global $bd, $composite_cod_sitio, $cmp, $orden_idioma;
    
    $vlf_codigo_html=""; 
    //$ourFileName = "testFile.txt";
    /*
    $vlf_datos_tpl = fopen($vp_tpl, 'r') or die("No se puede leer el tpl: $vp_tpl");
    
    while (! feof($vlf_datos_tpl))
    {
        $vlf_codigo_html= $vlf_codigo_html.fgets($vlf_datos_tpl);           
    }
    fclose($vlf_datos_tpl);    
    return $vlf_codigo_html;
	*/
   $vlf_codigo_html= leer_tpl_de_etiqueta_o_formularios_programas('formularios-programas','sistema-medico',$vp_tpl);
       
    return  $vlf_codigo_html;
}
?>