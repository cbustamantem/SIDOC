<?php

class CLASS_GRAPHICS {
	private $vlc_tipo_grafico;
	private $vlc_titulo_grafico;
	private $vlc_titulo_muestra;
	private $vlc_arreglo_datos;
	private $vlc_codigo_html;
	private $vlc_alto;
	private $vlc_ancho;	
	
	function __construct ()
    {
    	$this->vlc_tipo_grafico		="";
		$this->vlc_titulo_grafico	="";
		$this->vlc_titulo_muestra	="";
		$this->vlc_arreglo_datos	="";		
		$this->vlc_codigo_html		= FN_LEER_TPL('tpl/tpl-graficos.html');
		$this->vlc_alto="450";
		$this->vlc_ancho="600";
		
    }
    function MTD_ASIGNAR_TAMANHO_GRAFICO($vp_ancho,$vp_alto)
    {
    	$this->vlc_alto=$vp_ancho;
		$this->vlc_ancho=$vp_alto;
    }
    function MTD_ASIGNAR_TITULO_MUESTRA($vp_tipo_muestra)
    {
    	$this->vlc_titulo_muestra = $vp_tipo_muestra;    	
    }
	function MTD_ASIGNAR_TITULO_GRAFICO($vp_titulo_grafico)
    {
    	$this->vlc_titulo_grafico = $vp_titulo_grafico;
    }
	function MTD_ASIGNAR_TIPO_GRAFICO($vp_tipo_grafico)
    {
    	$this->vlc_tipo_grafico = $vp_tipo_grafico;
    	if ($vp_tipo_grafico == 'pie')
    	{
    		//$this->FN_CALCULAR_PROXIMIDAD();
    	}
    }
	function MTD_ASIGNAR_ARREGLO_DATOS($vp_arreglo_datos)
    {
    	$this->vlc_arreglo_datos = $vp_arreglo_datos;
    	/*
    	echo "<pre>";
    	print_r($this->vlc_arreglo_datos );
    	echo "</pre>";
    	*/
    }
	function FN_CALCULAR_PROXIMIDAD()
	{
		$cantidad_registros=sizeof($this->vlc_arreglo_datos);
		$contador=0;
		$suma= 0;
		$vp_columna=1;
		$vp_arreglo = $this->vlc_arreglo_datos; 
		while ($contador < $cantidad_registros)
		{
			$suma +=$vp_arreglo[$contador][$vp_columna];
			$contador++;
		}
		$contador= 0;
		while ($contador < $cantidad_registros)
		{
			//echo "<br>ARREGLO ->".$vp_arreglo[$contador][$vp_columna]." * 100 / $suma  = ";			
			$vp_arreglo[$contador][$vp_columna] = ($vp_arreglo[$contador][$vp_columna]* 100) / $suma ;
			$vp_arreglo[$contador][$vp_columna] = number_format($vp_arreglo[$contador][$vp_columna],0);
			//echo number_format($vp_arreglo[$contador][$vp_columna],0);
			$contador++;
		}
		
		// CALCULA PROXIMIDAD
		$contador= 0;
		$vp_arreglo_temp = array();
			
		while ($contador < $cantidad_registros)
		{
						
			$porcentaje_actual	= intval($vp_arreglo[$contador][$vp_columna]); 
			$porcentaje_proximo	= intval($vp_arreglo[$contador+1][$vp_columna]);
			if ($porcentaje_proximo = "")
			{
				$porcentaje_proximo =0;
			}
			$resultado =  $porcentaje_actual - $porcentaje_proximo;
			//echo "<br>ARREGLO ->".$vp_arreglo[$contador][$vp_columna]." * 100 / $suma "; 
			if ($resultado  > 3)
			{
				
				$vp_arreglo_temp[$contador][0]=$this->vlc_arreglo_datos[$contador][0];
				$vp_arreglo_temp[$contador][1]=$this->vlc_arreglo_datos[$contador][1];
			}
			else 
			{
				break;
			}
			//echo "<br>PORCENTAJE ACTUAL (".$vp_arreglo[$contador][0].") ->".$porcentaje_actual." / PROXIMO  ".$porcentaje_proximo;
			$contador++; 						
			
		}		
		$this->vlc_arreglo_datos = $vp_arreglo_temp;
		
		//return $vp_arreglo;				
	}
    function MTD_APLICAR_TEMPLATE()
    {
    	$vlf_codigo_html= $this->vlc_codigo_html;
    	$vlf_codigo_html = FN_REEMPLAZAR('{ancho}',$this->vlc_ancho,$vlf_codigo_html);
    	$vlf_codigo_html = FN_REEMPLAZAR('{alto}',$this->vlc_alto,$vlf_codigo_html);
    	$this->vlc_codigo_html =$vlf_codigo_html;
    }
    function MTD_RETORNAR_CODIGO_HTML()
    {
    	$this->MTD_APLICAR_TEMPLATE();
    	return 	$this->vlc_codigo_html;
    }
    function MTD_GENERAR_GRAFICO()
    {    	
    	/*****************************************************
		TODO LIST
		1) RECIBIR LOS PARAMETROS
		2) ASIGNAR LOS PARAMETROS
		3) ARMAR ESTRUCTURA SQL
		4) ANALIZAR DATOS
			4.1) ASIGNAR DATOS A MATRIZ
			4.2) ASIGNAR TITULOS
		5) ASIGNAR DATOS A GRAFICOS
		6) IMPRIMIR DATOS EN FORMATO JSON PARA LECTURA DEL GENERADOR DE GRAFICOS
		
		/*****************************************************/
		
		
		//============== RECEPCION DE VARIABLES =======================		
		
		/*
		##########################################################################
		# PREPARACION DE DATOS 
		##########################################################################
		*/
			
		//================ INICIALIZACION DE VARIABLES  DEL GRAFICO=================
		$data = array ();
		//=================CREACION DE VARIABLES =============
		$vp_cant_elementos = 0;
		$vp_elementos = array ();
		$vp_tit_elementos = array ();
		$vp_tit_muestras = array ();
		$vp_colores = array ();
		$vp_cant_muestras = 0;
		$vp_contador = 0;
		$vp_titulo = "";
		$vp_debug= 1;
		$vp_tipo_grafico=0;		
		$vp_data_tipo_grafico="";
		$vp_valor_minimo=0;
		$vp_valor_maximo=0;
		$vp_muestra_torta=0;
		
		/*
		##########################################################################
		# PARAMETROS ALEATORIOS
		##########################################################################
		*/
		//$cant_muestras_maximas=15;
		//$cant_muestras_minimas=5;
		//$valor_muestra_maxima=5000;
		//$valor_muestra_minima=100;
		//	int rand  ([ int $min  ], int $max  )
		/*
		##########################################################################
		# CONSULTA Y ANALISIS DE DATOS
		##########################################################################
		*/						
		$vp_tipo_grafico	= $this->vlc_tipo_grafico;
		$vp_titulo_muestra 	= $this->vlc_titulo_muiestra;
		$vp_arreglo_muestra = $this->vlc_arreglo_datos;
			
		//========================================
		// GENERA LA CANTIDAD DE FILAS
		//========================================
		$filas = sizeof($this->vlc_arreglo_datos);
		//INCIALIZACION DE VARIABLES
		$vp_rango_minimo=0;
		$vp_rango_maximo=0;
		$vp_contador_muestras = 0;
		//================================================
        // CICLO DE ASIGNAMIENTO DE VALORES A LAS MUESTRAS
        //================================================
		for($cont = 0; $cont < $filas; $cont ++)
		{
			//================================================
            // ASIGNA EL VALOR AL TITULO DE LA MUESTRA
            //================================================
			$vp_tit_muestras[$cont] = $this->vlc_arreglo_datos[$cont][0];
			//================================================
            // ASIGNA EL VALOR A LA MUESTRA
            //================================================
			$valor_consulta_datos = intval($this->vlc_arreglo_datos[$cont][1]);			
			$vp_elementos_datos[0][$cont]= $valor_consulta_datos;
			
			//-----------------------------------------
			//**** ASIGNACION DEL MINIMO ELEMENTO 1
			//-----------------------------------------			
			if ($valor_consulta_datos < $vp_rango_minimo)
			{
				$vp_rango_minimo = $valor_consulta_datos;
			}
			
			//-----------------------------------------
			//**** ASIGNACION DEL MAXIMO ELEMENTO 1
			//-----------------------------------------
			if ($valor_consulta_datos > $vp_rango_maximo)
			{
				$vp_rango_maximo = $valor_consulta_datos;
			}
			
		
		}
		$vp_contador_muestras = $cont;
	
		//--------------------------------------------------------
		//**** PREPARA LOS VALORES PARA INVOCAR AL GENERADOR JSON
		//--------------------------------------------------------
		//include_once 'includes/FN_GENERADOR_JSON.php';
		/*
		$vp_cant_elementos = 1;
		$vp_cant_muestras = $vp_contador_muestras;
		$vp_contador = 0;
		$vp_paso= $vp_rango_maximo / 10;
		$vp_titulo=$this->vlc_titulo_grafico ;
		$vp_tit_elementos = $vp_tit_muestras;
		$vp_muestra_torta=0;
		*/
		$vp_cant_elementos = 1;
		$vp_cant_muestras = $vp_contador_muestras;
		$vp_contador = 0;
		$vp_paso= $vp_rango_maximo / 10;
		$vp_titulo=$this->vlc_titulo_grafico ;
		$vp_tit_elementos[0] = $this->vlc_titulo_muestra;
		$vp_muestra_torta=0;		
		
		/*
		 *FN_GENERADOR_JSON(
		 * $vp_cant_elementos 	= Cantidad de elementos de la muestra
		 * $vp_muestra_torta 	= Valor especial para determinar si es torta
		 * $vp_rango_maximo 	= Rango maximo de la muestra para determinar el tamanho de la barra vertical	 
		 * $vp_rango_minimo		= Rango minimo de la muestra para determinar el tamanho de la barra vertical
		 * $vp_titulo,			= Titulo de la muestra
		 * $vp_tit_elementos,	= Titulo que figura como tooltiptext
		 * $vp_tipo_grafico,	= Asigna el tipo de grafico (bar,line_dots,line,bar_glass,bar_3d,pie)
		 * $vp_elementos_datos, = Arreglo que contiene los valores de las muestras
		 * $vp_tit_muestras);   = Arreglo que contiene el valor del titulo de la muestra individual
		 */
		FN_GENERADOR_JSON($vp_cant_elementos,$vp_muestra_torta,	$vp_rango_maximo,$vp_rango_minimo,$vp_titulo,$vp_tit_elementos,$vp_tipo_grafico,$vp_elementos_datos, $vp_tit_muestras);
		
						    	
    }
    

}

?>
