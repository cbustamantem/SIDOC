<?php
function FN_OBTENER_DATOS_ARREGLO ($vp_arreglo, $vp_campo)
{
    $contador = 0;
    $cantidad_registros = sizeof($vp_arreglo);
    
    while ($contador < $cantidad_registros)
    {
        $arr_datos[$contador] = $vp_arreglo[$contador][$vp_campo];
        
        $contador++;
    }
   
    //$arr_datos = array_unique($arr_datos);
    //$arr_datos = asort($arr_datos);	
    $resultado= array_iunique($arr_datos);
    sort($resultado);    
    return $resultado;
}
function array_iunique ($a)
{
    $n = array();    
    foreach ($a as $k => $v)
    {
        if (! in_iarray($v, $n))
        {
            $n[$k] = $v;            
        }        
    }
    return $n;
}
function in_iarray ($str, $a)
{
    foreach ($a as $v)
    {
        if (strcasecmp($str, $v) == 0)
        {
            return true;
        }
    }
    return false;
}
?>