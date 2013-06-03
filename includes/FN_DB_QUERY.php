<?php
	function FN_RUN_QUERY($vp_query, $vp_cant_columnas,$vp_conexion)
	{
		//========================================
		// CONEXION BASE DE DATOS
		//========================================s
		
		//$vlf_conexion = pg_connect ( $this->vlc_db_string_conexion );
		//$vp_datos = new array();
					
		$resultado_consulta = mysql_query( $vp_query,$vp_conexion);
		
		if (! $resultado_consulta)
		{
			
			echo "[0] Error en la consulta sql: <br>".$vp_query."<br> -> ERROR ->".mysql_error();
			exit ();
		}
		
		$cantidad_filas = mysql_num_rows ( $resultado_consulta );
		//echo "<BR>DGG QUERY>Consulta Realizada:$vp_query";
		//echo "<BR>DGG QUERY>Cantidad Filas:$cantidad_filas";
		if ($cantidad_filas == 0)
		{
			//echo "No se encontro ningun registro \n";
			//exit ();
			return 0;
		}
		else
		{
			//ASIGNACION DE DATOS
			
			for($fila = 0; $fila < $cantidad_filas; $fila ++)
			{
				
				for($columna = 0; $columna < $vp_cant_columnas; $columna ++)
				{
					
					$vp_datos[$fila][$columna] = mysql_result ( $resultado_consulta, $fila, $columna );
					//echo "<br> DBG > FN_RUN_QUERY> DATO F[$fila]  C[$columna]: ".$vp_datos[$fila][$columna];					
				}
			}
		}
		mysql_free_result ( $resultado_consulta );		
		return $vp_datos;
	}
	function FN_RUN_NONQUERY($vp_query,$vp_conexion)
	{

		$estado_consulta = false;
	
		$resultado_consulta = mysql_query ( $vp_query,$vp_conexion);
		
		if (mysql_error())
		{
			//ec[0] Error en la consulta sql: ".pg_last_error() ;
			$estado_consulta = false;			
		}
		else
		{
			$estado_consulta = true;		   
		}
	    
		
		return $estado_consulta;
	}

	function FN_CONTAR_REGISTRO()
	{
		$estado_consulta = 0;

		$resultado_consulta = mysql_query ( $vp_query,$vp_conexion);
		if (mysql_error())
		{
			//ec[0] Error en la consulta sql: ".pg_last_error() ;
			$estado_consulta = 0;			
		}
		else
		{
			$estado_consulta = $resultado_consulta;		   
		}
	    
		
		return $estado_consulta;
	}
?>