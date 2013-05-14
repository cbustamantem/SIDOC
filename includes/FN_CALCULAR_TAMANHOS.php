<?php
function FN_CALCULAR_TAMANHO($vp_arreglo,$vp_columna)
	{
		/*ASE 
		WHEN  SUM(l.tamanho) < 1024 THEN
		  CONCAT (SUM(l.tamanho),' B')
		WHEN  SUM(l.tamanho) < 1000000 THEN
		  CONCAT (FORMAT((SUM(l.tamanho)/1024),0),' KB')
		ELSE
		   CONCAT (FORMAT(((SUM(l.tamanho)/1024)/1024),2),' MB') 
		END*/
		$cantidad_registros = sizeof($vp_arreglo);
		$contador=0;
		while ($contador < $cantidad_registros)
		{
			 $tamanho= $vp_arreglo[$contador][$vp_columna];
			 if ($tamanho < 1024)
			 {
			 	 $tamanho_formateado= number_format($tamanho,0)." B"; 
			 }
			 elseif ($tamanho < 1024000)
			 {
			 	$tamanho = $tamanho /1024;
			 	 $tamanho_formateado= number_format($tamanho,0)." KB"; 
			 }
			 else
			 {
			 	 $tamanho = $tamanho /1024;
			 	 $tamanho = $tamanho /1024;
			 	 $tamanho_formateado= number_format($tamanho,0)." MB"; 
			 }
			 $vp_arreglo[$contador][$vp_columna]=$tamanho_formateado;
			 $contador++;
		}
		return $vp_arreglo;
	}
function FN_CALCULAR_TAMANHO_TIEMPO($vp_arreglo,$vp_columna)
{
	/*ASE 
	WHEN  SUM(l.tamanho) < 1024 THEN
	  CONCAT (SUM(l.tamanho),' B')
	WHEN  SUM(l.tamanho) < 1000000 THEN
	  CONCAT (FORMAT((SUM(l.tamanho)/1024),0),' KB')
	ELSE
	   CONCAT (FORMAT(((SUM(l.tamanho)/1024)/1024),2),' MB') 
	END*/
	$cantidad_registros = sizeof($vp_arreglo);
	$contador=0;
	while ($contador < $cantidad_registros)
	{
		 $tamanho= $vp_arreglo[$contador][$vp_columna];
		 if ($tamanho < 60)
		 {
		 	 $tamanho_formateado= number_format($tamanho,0)." seg."; 
		 }
		 elseif ($tamanho < 3600)
		 {
		 	$tamanho = $tamanho /60;
		 	 $tamanho_formateado= number_format($tamanho,0)." min"; 
		 }
		 else
		 {
		 	 $tamanho = $tamanho /3600;		 	 
		 	 $tamanho_formateado= number_format($tamanho,0)." horas"; 
		 }
		 $vp_arreglo[$contador][$vp_columna]=$tamanho_formateado;
		 $contador++;
	}
	return $vp_arreglo;
}
	
?>