<?php
function FN_GENERADOR_JSON($vp_cant_elementos, $vp_muestra_torta, $vp_rango_maximo, $vp_rango_minimo, $vp_titulo, $vp_tit_elementos, $vp_tipo_grafico, $vp_elementos_datos, $vp_tit_muestras)
{
	/*
	##########################################################################
	# GENERADOR DE CODIFICACION JSON PARA GRAFICOS OPEN-CHART
	##########################################################################
	*/
	
	include 'FN_COLORES.php';
	//ELEMENTOS DEL GRAFICO
	//--------------------------
	$chart = new open_flash_chart ( );
	$x_axis = new x_axis ( );
	$y_axis = new y_axis ( );
	$x_labels = new x_axis_labels ( );
	$vp_debug = 0;
	//echo "tipo de grafico :$vp_tipo_grafico";
	

	//================= DEBUG =============
	

	function FN_DEBUG($texto, $debug)
	{
		if ($debug == 1)
		{
			echo "<br>";
			echo "#" . $texto;
		}
	}

	//=================INICIALIZACION DE VARIABLES =============
	FN_DEBUG ( "INICIALIZACION DE VARIABLES", $vp_debug );
	
	//================== CHART
	$title = new title ( $vp_titulo );
	$chart->set_title ( $title );
	
	FN_DEBUG ( "INICIALIZACION DEL CHART", $vp_debug );
	/*
	//================== INICIALIZACION DE LOS ELEMENTOS =================
	
	*/
	//================== CARGA DE DATOS =================
	$data = array ();
	$vp_paso = $vp_rango_maximo / 10;
	$vp_contador = 0;

	
	while ( $vp_contador < $vp_cant_elementos )
	{
		//======= Tipo de Grafico ==============
		if ($vp_tipo_grafico == "bar")
		{
			$vp_elementos[$vp_contador] = new bar ( );
			$vp_elementos[$vp_contador]->set_values ( $vp_elementos_datos[$vp_contador] );
			$vp_elementos[$vp_contador]->colour = $vp_colores[$vp_contador];
			$vp_elementos[$vp_contador]->set_tooltip ( $vp_tit_elementos[$vp_contador] . ': #val#' );
			$vp_elementos[$vp_contador]->set_key ( $vp_tit_elementos[$vp_contador], 12 );
			$vp_elementos[$vp_contador]->set_showvalue ( true );
			$vp_elementos[$vp_contador]->set_hover = - 1;
		}
		else if ($vp_tipo_grafico == "line_dots")
		{
			$vp_elementos[$vp_contador] = new line_dot ( );
			$vp_elementos[$vp_contador]->set_values ( $vp_elementos_datos[$vp_contador] );
			$vp_elementos[$vp_contador]->colour = $vp_colores[$vp_contador];
			$vp_elementos[$vp_contador]->set_tooltip ( $vp_tit_elementos[$vp_contador] . ': #val#' );
			$vp_elementos[$vp_contador]->set_key ( $vp_tit_elementos[$vp_contador], 12 );
			$vp_elementos[$vp_contador]->set_showvalue ( true );
			$vp_elementos[$vp_contador]->set_hover = - 1;
		}
		else if ($vp_tipo_grafico == "line")
		{
			$vp_elementos[$vp_contador] = new line ( );
			$vp_elementos[$vp_contador]->set_values ( $vp_elementos_datos[$vp_contador] );
			$vp_elementos[$vp_contador]->colour = $vp_colores[$vp_contador];
			$vp_elementos[$vp_contador]->set_tooltip ( $vp_tit_elementos[$vp_contador] . ': #val#' );
			$vp_elementos[$vp_contador]->set_key ( $vp_tit_elementos[$vp_contador], 12 );
			$vp_elementos[$vp_contador]->set_showvalue ( true );
			$vp_elementos[$vp_contador]->set_hover = - 1;
		}
		else if ($vp_tipo_grafico == "bar_glass")
		{					
			$vp_elementos[$vp_contador] = new bar_glass ( );
			$vp_elementos[$vp_contador]->set_values ( $vp_elementos_datos[$vp_contador] );
			$vp_elementos[$vp_contador]->colour = $vp_colores[$vp_contador];
			$vp_elementos[$vp_contador]->set_tooltip ( $vp_tit_elementos[$vp_contador] . ': #val#' );
			$vp_elementos[$vp_contador]->set_key ( $vp_tit_elementos[$vp_contador], 12 );
			$vp_elementos[$vp_contador]->set_showvalue ( true );
			$vp_elementos[$vp_contador]->set_hover = - 1;
			
		}
		else if ($vp_tipo_grafico == "bar_3d")
		{
			
			$vp_elementos[$vp_contador] = new bar_3d ( );
			$vp_elementos[$vp_contador]->set_values ( $vp_elementos_datos[$vp_contador] );
			$vp_elementos[$vp_contador]->colour = $vp_colores[$vp_contador];
			$vp_elementos[$vp_contador]->set_tooltip ( $vp_tit_elementos[$vp_contador] . ': (#val#)' );
			$vp_elementos[$vp_contador]->set_key ( $vp_tit_elementos[$vp_contador], 12 );
			$vp_elementos[$vp_contador]->set_showvalue ( true );
			$vp_elementos[$vp_contador]->set_hover = - 1;
		
			//$vp_elementos[$vp_contador]->set_inner_background( '#E3F0FD', '#CBD7E6', 90 );
		}
		else if ($vp_tipo_grafico == "bar_fade")
		{
			
			$vp_elementos[$vp_contador] = new bar_fade();
			$vp_elementos[$vp_contador]->set_values ( $vp_elementos_datos[$vp_contador] );
			$vp_elementos[$vp_contador]->colour = $vp_colores[$vp_contador];
			$vp_elementos[$vp_contador]->set_tooltip ( $vp_tit_elementos[$vp_contador] . ': (#val#)' );
			$vp_elementos[$vp_contador]->set_key ( $vp_tit_elementos[$vp_contador], 12 );
			$vp_elementos[$vp_contador]->set_showvalue ( true );
			$vp_elementos[$vp_contador]->set_hover = - 1;
		
			//$vp_elementos[$vp_contador]->set_inner_background( '#E3F0FD', '#CBD7E6', 90 );
		}
		else if ($vp_tipo_grafico == "pie")
		{			
			$vp_elementos[$vp_contador] = new pie ( );
			$vp_elementos[$vp_contador]->set_values ( $vp_elementos_datos[$vp_contador] );
			$vp_elementos[$vp_contador]->colour = $vp_colores[$vp_contador];
			$vp_elementos[$vp_contador]->set_label_colour ( '#432BAF' );
			$vp_elementos[$vp_contador]->set_gradient_fill ();
			$vp_elementos[$vp_contador]->set_tooltip ( $vp_tit_elementos[$vp_contador] . ' #percent# ' );					
			$vp_elementos[$vp_contador]->set_hover = - 1;
		
		}
		
		//======= ASIGNACION DE LOS DATOS AL OBJETO ELEMENTO		
		

		//echo  $vp_tit_elementos[$vp_contador];
		FN_DEBUG ( "ASIGNACION DE LOS DATOS AL ELEMENTO: $vp_contador ", $vp_debug );
		$vp_contador ++;
	}
	//=========== ASIGNACION DE LOS ELEMENTOS AL GRAFICO ==============
	if ($vp_tipo_grafico != "pie")
	{
		$vp_contador = 0;
		while ( $vp_contador < $vp_cant_elementos )
		{
			$chart->add_element ( $vp_elementos[$vp_contador] );
			
			$vp_contador ++;
		}
	}
	else
	{
		$contador = 0;
		$vp_tamanho_arreglo = sizeof ( $vp_tit_muestras );
		//echo "Tamanho:$vp_tamanho_arreglo ";
		$datos_torta = array ();
		while ( $contador < $vp_tamanho_arreglo )
		{
			//echo "<br>Valor a asignar:". $vp_elementos_datos[$vp_muestra_torta][$vp_contador]."/".$vp_tit_muestras[$vp_contador];
			$etiqueta_torta = $vp_tit_muestras[$contador] . chr ( 13 ) . "(" . $vp_elementos_datos[$vp_muestra_torta][$contador] . ")";
			$datos_torta[$contador] = new pie_value ( $vp_elementos_datos[$vp_muestra_torta][$contador], $etiqueta_torta );
			$datos_torta[$contador]->set_label ( $etiqueta_torta, '#432BAF', 12 );
			$contador ++;
		}
		$vp_elementos[$vp_muestra_torta]->set_values ( $datos_torta );
		$chart->add_element ( $vp_elementos[$vp_muestra_torta] );
		
	//$chart->set_label($vp_tit_muestras);
	}
	
	//=============== EJE X ===============
	$x_axis->set_3d ( 5 );
	$x_axis->colour = '#909090';
	$x_axis->set_grid_colour ( '#86BF83' );
	
	//=============== ETIQUETA X =============
	$x_labels->set_colour ( '#000000' );
	// nice big font
	$x_labels->set_size ( 8 );
	// set the label text
	$x_labels->set_labels ( $vp_tit_muestras );
	
	//echo "$vp_tit_muestras[0]";
	//$x_labels->set_rotate = 'diagonal';
	//$x_labels->set_visible();
	

	$x_axis->set_labels ( $x_labels );
	
	//=============== EJE Y ===============
	

	$y_axis->set_range ( $vp_rango_minimo, $vp_rango_maximo + $vp_paso, $vp_paso );
	
	//=============== ASIGNACION DE LOS EJES  X/Y  ===============
	if ($vp_tipo_grafico != "pie")
	{
		$chart->set_x_axis ( $x_axis );
		$chart->set_y_axis ( $y_axis );
	}
	$chart->set_bg_colour ( '#FFFFFF' );
	
	$_SESSION['vs_json_graph']= $chart->toPrettyString ();
}
?>