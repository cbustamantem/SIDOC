<?php
//LIMITA LA CANTIDAD DE CARACTERES AGREGANDO UN STRING ..
function FN_STRING_LIMITE($vp_caracter,$vp_limite, $vp_caracter_limitante="..")
{
  $cantidad = 0;
  $cantidad = strlen($vp_caracter);
  if($cantidad >= $vp_limite)
  {
    $vp_caracter= substr($vp_caracter,0,$vp_limite).$vp_caracter_limitante;
  }
  return $vp_caracter;
}
function FN_DEPURAR_ARREGLO2($arreglo)
{
    echo "<pre>";
    print_r($arreglo);
    echo "</pre>";
}
function FN_DEPURAR_ARREGLO($array,$vp_level=0)
{
    $contador=0;
    $levelcount=0;
    $padding="";
    $arreglos=$vp_levelcount;
    
    if ($vp_level == 0)
    {
        $buf = "\n Debuggin array -> registros (".sizeof($array).") level ($vp_level) \n";
        $buf .= "Array \n";
        $buf .= "{ \n";
    }
    $levelcount=0;
    $padding="";
    $nombres_arreglo = array_keys($array); 
    if ($vp_level > 0)
    {
        while ($levelcount < $vp_level)
        {
            $padding.= "\t";
            $levelcount++;
        }
    }
    $contador_arreglos=0;
    foreach($array as $key => $value)
    {
        if(is_array($value))
        {
            $vp_level_actual= $vp_level + 1;
	    $levelcount=0;
	    $padding="";
	    $nombres_arreglo = array_keys($array);
	    if ($vp_level > 0)
	    {
	        while ($levelcount < $vp_level)
	        {
	            $padding.= "\t";
	            $levelcount++;
	        }
	    }
            if ($contador_arreglos > 0)
            {
                $buf .= "$padding     )  \n";
            }
            $buf .= "$padding     [".$nombres_arreglo[$contador]."] \n";
            $buf .= "$padding     ( \n";
            $buf .=FN_DEPURAR_ARREGLO($value,$vp_level_actual);
            $contador_arreglos++;
        }
        else
        {             
            $buf .= "$padding [".$nombres_arreglo[$contador]."] => $value \n";
        }
        $contador++;
    }
    
    if ($vp_level == 0)
    {
        $buf .= "$padding     )  \n";
        $buf .= "} \n";
    }
    
    return $buf;
}
function FN_FORMAT_PRECIO($vp_precio)
{
    global $vg_conf_moneda;
    $precio=$vg_conf_moneda.' '.number_format($vp_precio,0,'','.');
    return $precio;
}

?>
