<?php
/*
 *****************************************************************************
 * PROGRAMA:	Reporte de marcaciones 
 * 
 * AUTOR:		Carlos B. TERA S.R.L.
 * 
 * OBJETIVO:	Obtener y filtrar los registros de los datos de las marcaciones 
 * 				
 * 
 * OBJETOS:
 ******************************************************************************
 */

class CLASS_MARCACIONES
{
	private $vlc_db_conexion;
	private $vlc_filtro_codoperacion;
	private $vlc_filtro_codpersona;
	private $vlc_filtro_nombre;
	private $vlc_filtro_fecha;
	private $vlc_filtro_codubicacion;	
		
	
	function __construct($vp_db_conexion)
	{
		$this->vlc_db_conexion =$vp_db_conexion; 
		$vlc_filtro_codoperacion="";
		$vlc_filtro_codpersona="";
		$vlc_filtro_nombre="";
		$vlc_filtro_fecha="";
		$vlc_filtro_codubicacion="";
	}
	function MTD_FILTRAR_FECHA($vp_fecha_desde, $vp_fecha_hasta)
	{
		$vlf_filtro_fecha= "ppe.Fecha between '$vp_fecha_desde' AND '$vp_fecha_hasta'";
		$this->vlc_filtro_fecha = $vlf_filtro_fecha; 
	}
	function MTD_FILTRAR_CODOPERACION($vp_cod_operacion)
	{
		$vlf_filtro_codoperacion= "ppe.CodOperacion ='$vp_cod_operacion'";
		$this->vlc_filtro_codoperacion = $vlf_filtro_codoperacion; 
	}
	function MTD_FILTRAR_CODPERSONA($vp_codpersona)
	{
		$vlf_filtro_codpersona= "ppe.CodPersona ='$vp_codpersona'";
		$this->vlc_filtro_codpersona = $vlf_filtro_codpersona; 
	}
	function MTD_FILTRAR_NOMBRE($vp_nombre)
	{
		$vlf_filtro_nombre= "ps.Nombre ='$vp_nombre'";
		$this->vlc_filtro_nombre = $vlf_filtro_nombre; 
	}
	function MTD_FILTRAR_UBICACION($vp_ubicacion)
	{
		$vlf_filtro_ubicacion= "ppe.CodUbicacion='$vp_ubicacion'";
		$this->vlc_filtro_codubicacion = $vlf_filtro_ubicacion; 
	}
	
	function MTD_LISTAR_MARCACIONES()
	{
		$where="";
		$where= $this->vlc_filtro_fecha;		
		if ($this->vlc_filtro_codoperacion != "")
		{
				$where.= " AND ".$this->vlc_filtro_codoperacion;
		}
		if ($this->vlc_filtro_codpersona!= "")
		{
				$where.= " AND ".$this->vlc_filtro_codpersona;
		}
		if ($this->vlc_filtro_codubicacion != "")
		{
				$where.= " AND ".$this->vlc_filtro_codubicacion;
		}
		if ($this->vlc_filtro_nombre != "")
		{
				$where.= " AND ".$this->vlc_filtro_nombre;
		}
		
		$vlf_sql="SELECT
		ppe.IdPersonaEvento,
		ppe.CodOperacion,
		ppe.CodPersona,
		ppe.CodCategoria,
		ppe.NumLinea,
		ppe.CodUbicacion,
		ppe.Fecha,
		ps.Nombre,
		ps.Telefono
		FROM  dbo.PersonalMark_Personas ps
		INNER JOIN PersonalMark_PersonasEventos as ppe ON ps.CodPersona= ppe.CodPersona
	        WHERE ".$where." Order By ppe.IdPersonaEvento asc, ppe.Fecha";

		
		
		/*	$vlf_sql=" SELECT idpersonaevento, codoperacion, codpersona, codcategoria, numlinea, 
	       codubicacion, fecha, nombre, telefono, id
  FROM tbl_marcaciones where ".$where;
	*/
		//echo "<BR> SQL: $vlf_sql <BR> <HR>";
		
		$vlf_datos= $this->FN_RUN_QUERY($vlf_sql,9,$this->vlc_db_conexion);
   		return $vlf_datos;	
	}	
	function FN_RUN_QUERY($vp_query, $vp_cant_columnas,$vp_db_conexion)
	{
		//========================================
		// CONEXION BASE DE DATOS
		//========================================s
		
		//$vlf_conexion = pg_connect ( $this->vlc_db_string_conexion );
		//$vp_datos = new array();
                $resultado_consulta=mssql_query($vp_query,$vp_db_conexion) or die("<br>Error en la consulta de datos");

		if (! $resultado_consulta)
		{
			
			echo "[0] Error en la consulta sql: ".$vp_query;
			exit ();
		}
		
		$cantidad_filas = mssql_num_rows( $resultado_consulta );
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
					
					$vp_datos[$fila][$columna] = mssql_result ( $resultado_consulta, $fila, $columna );
					//echo "<br> DBG > FN_RUN_QUERY> DATO F[$fila]  C[$columna]: ".$vp_datos[$fila][$columna];					
				}
			}
		}
		mssql_free_result( $resultado_consulta );
		//echo "<br> DBG > FN_RUN_QUERY> TERMINO";
		return $vp_datos;
	}
	function FN_RUN_NONQUERY($vp_query,$vp_conexion)
	{
		//$vlf_conexion = pg_connect ( $this->vlc_db_string_conexion );
		//echo "<BR>DBG > ENTRO EN NON_QUERY : $vp_query <br>";  
		$estado_consulta = false;
		$resultado_consulta=mssql_query($vp_query,$vp_conexion) or die("<br>Error en la consulta de datos");
		return $estado_consulta;
	}
}

?>
