<?php
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
    return $resultado;
}
function FN_IMPRIMIR_OPCIONES ($vp_arreglo, $vp_valor_seleccionado)
{
    $contador = 0;
    $datos= array();
    $datos=$vp_arreglo;
    $cantidad_registros = sizeof($datos);
    foreach ($datos as $k => $v)
    {    
        $vlf_valor = $v;
            $seleccionado = "";
            if ($vlf_valor == $vp_valor_seleccionado)
            {
                $seleccionado = " selected ";
            }      
                                                  
         echo "<option value='".$v."'".$seleccionado.">".$v."</option>";         
     }    
}
?>