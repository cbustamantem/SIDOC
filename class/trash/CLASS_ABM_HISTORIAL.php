<?php
class CLASS_ABM_HISTORIAL
{
    private $vlc_codigo_html;
    private $vlc_fecha;
    private $vlc_motivo;
    private $vlc_diagnostico;
    private $vlc_estudios;   
    private $vlc_tratamiento;
    private $vlc_indicaciones;
    private $vlc_id_paciente;
    private $vlc_db_conexion;          
    
    function __construct($vp_conexion)
    {
    	$this->vlc_db_conexion =$vp_conexion;
		$this->MTD_LIMPIAR_VARIABLES();
        //$this->MTD_INICIALIZAR_PAGINA();        
    }
    function MTD_LIMPIAR_VARIABLES()
    {
		$this->vlc_codigo_html="";	    
	    $this->vlc_fecha="";
	    $this->vlc_motivo="";	    
	    $this->vlc_diagnostico="";
	    $this->vlc_estudios="";	 	       	    	    
	    $this->vlc_tratamiento="";
	    $this->vlc_indicaciones="";
	    $this->vlc_id_paciente= FN_RECIBIR_VARIABLES("paciente");	    
    }
    function MTD_LISTAR_VISITAS()
    {
    	
    	$arreglo= $this->MTD_DB_LISTAR();
    	$template="";
    	foreach($arreglo as $registro)
    	{
    		$template .= "<tr class='odd gradeX'>";
    		$template .= "<td>". $registro[1] ."</td>";
    		$template .= "<td>". substr($registro[2],0,36).".." ."</td>";
    		$template .= "<td>". substr($registro[3],0,36).".."."</td>";
    		$template .= "<td>
    						<a title='Ver historial' href='#verHistorico' onclick='javascript:MTD_MOSTRAR_HISTORIAL(".$this->vlc_id_paciente.",".$registro[0].")'><img src='archivos_de_disenho/images/bt_visualizar.png'></a>&nbsp;&nbsp;
    						<a title='Imprimir historial' href='index.php?id=registro&seccion=historial_paciente&paciente=".$this->vlc_id_paciente."&historial=".$registro[0]."' target='_blank'><img src='archivos_de_disenho/images/imprimir.png'></a>
    							</td></tr>";    		    	
    	}
    	return $template;
    }
    function MTD_AGREGAR_HISTORIAL()
    {    	
    	LOGGER::LOG("ABM PACIENTES: MTD Agregar ");
    	$this->MTD_RECIBIR_DATOS();
    	$vlf_resultado = "";
    	if ($this->MTD_DB_AGREGAR())
    	{
    		//$vlf_resultado = "<img src='archivos_de_disenho/imagenes/resultado_ok.png'> Se agrego correctamente el Registro";
    		LOGGER::LOG("ABM PACIENTES: MTD Agregar OK");
    		//header ( "Location: index.php?id=registro" );
    		return "0";
    	}
    	else
    	{
    		LOGGER::LOG("ABM USUARIOS: MTD Agregar FAIL");
    		return  "(Registro Medico / Email) previamente registrados";
    	}    	
    }
    function MTD_ACTUALIZAR_PACIENTE()
    {
    	$this->MTD_RECIBIR_DATOS();
    	$vlf_resultado = "";
    	if ($this->MTD_DB_ACTUALIZAR())
    	{
    		$vlf_resultado = "<img src='archivos_de_disenho/imagenes/resultado_ok.png'> Se actualizo correctamente el Registro";
    	}
    	else
    	{
    		$vlf_resultado = "<img src='archivos_de_disenho/imagenes/resultado_mal.png'> Atencion Ocurrio un error durante la operacion, verifique los datos";
    	}
    	
    }
    function MTD_INICIALIZAR_PAGINA ()
    {
        /*
         * TODO: 
         * VALORES DEL FORMULARIO
         * ----------------------
         * [tb_fecha]
         * [id]
         *      
         */
		$paciente = FN_RECIBIR_VARIABLES('paciente');
	   	$nombre_paciente="";
	   	$datos_paciente = array();
	   	if ($paciente > 0)
	   	{
	   		$datos_paciente = FN_RUN_QUERY("SELECT nombre, apellido from pacientes where id_paciente=$paciente",2,$this->vlc_db_conexion);
	   		$nombre_paciente= $datos_paciente[0][0]." ".$datos_paciente[0][1];
	   	}
	    
    	$this->vlc_id_paciente = FN_RECIBIR_VARIABLES("paciente");
        $vl_cod_html_base = FN_LEER_TPL('tpl/tpl-abm-historial.html');
        $vl_cod_html_base = FN_REEMPLAZAR("{tpl-nombre-paciente}", $nombre_paciente,  $vl_cod_html_base);
        $vl_cod_html_base = FN_REEMPLAZAR("{tpl-id-paciente}", FN_RECIBIR_VARIABLES("paciente"),  $vl_cod_html_base);      
        $this->vlc_codigo_html = $vl_cod_html_base;
    }
    function MTD_CONSULTAR_HISTORICO()
    {
    	
    	$id_historial = FN_RECIBIR_VARIABLES('historial');
    	$paciente = FN_RECIBIR_VARIABLES('paciente');
    	LOGGER::LOG("Consulta Historial id: $id_historial paciente:$paciente");
    	$nombre_paciente="";
    	$datos_paciente = array();
    	if ($paciente > 0)
    	{
    		$datos_paciente = FN_RUN_QUERY("SELECT nombre, apellido from pacientes where id_paciente=$paciente",2,$this->vlc_db_conexion);
    		$nombre_paciente= $datos_paciente[0][0]." ".$datos_paciente[0][1];
    	}
    	
    	$this->vlc_id_paciente = FN_RECIBIR_VARIABLES("paciente");
    	$vl_cod_html_base = $this->MTD_LEER_TPL('tpl/tpl-consulta-historial.html');
    	$vl_cod_html_base = FN_REEMPLAZAR("{tpl-nombre-paciente}", $nombre_paciente,  $vl_cod_html_base);
    	$vl_cod_html_base = FN_REEMPLAZAR("{tpl-id-paciente}", FN_RECIBIR_VARIABLES("paciente"),  $vl_cod_html_base);
    	$this->vlc_codigo_html = $vl_cod_html_base;
    	$arreglo_datos=$this->MTD_DB_LISTAR($id_historial);
    	$this->MTD_RECIBIR_DATOS_DB($arreglo_datos);
    	$this->vlc_codigo_html= $this->MTD_APLICAR_TEMPLATE($this->vlc_codigo_html);
    	return $this->vlc_codigo_html;
    }
    function MTD_APLICAR_TEMPLATE ($vp_codigo_html)
    {    		   
    	
    	$vp_codigo_html = FN_REEMPLAZAR('{tpl-fecha}', $this->vlc_fecha, $vp_codigo_html);
    	$vp_codigo_html = FN_REEMPLAZAR('{tpl-motivo}', $this->vlc_motivo, $vp_codigo_html);    	  	     	   	    	               
        $vp_codigo_html = FN_REEMPLAZAR('{tpl-estudios}', $this->vlc_estudios, $vp_codigo_html);
        $vp_codigo_html = FN_REEMPLAZAR('{tpl-diagnostico}', $this->vlc_diagnostico, $vp_codigo_html);
        $vp_codigo_html = FN_REEMPLAZAR('{tpl-indicaciones}', $this->vlc_indicaciones, $vp_codigo_html);                
        $vp_codigo_html = FN_REEMPLAZAR('{tpl-tratamientos}', $this->vlc_tratamiento, $vp_codigo_html);                             
        return  $vp_codigo_html;
    }
  	function MTD_RECIBIR_DATOS ()
    {      	     
		$this->vlc_fecha 				= FN_RECIBIR_VARIABLES('fecha');
		$this->vlc_motivo				= FN_RECIBIR_VARIABLES('motivo');	
		$this->vlc_diagnostico		    = FN_RECIBIR_VARIABLES('diagnostico');
		$this->vlc_estudios				= FN_RECIBIR_VARIABLES('estudios');					
		$this->vlc_tratamiento			= FN_RECIBIR_VARIABLES('tratamientos');
		$this->vlc_indicaciones			= FN_RECIBIR_VARIABLES('indicaciones');
		$this->vlc_id_paciente			= FN_RECIBIR_VARIABLES('id_paciente');
		if ($this->vlc_id_paciente == "")
		{
			$this->vlc_id_paciente			= FN_RECIBIR_VARIABLES('paciente');
		}
		
		LOGGER::LOG("ABM PACIENTES: Recibir datos: OK");			   
    }
 	function MTD_RECIBIR_DATOS_DB ($vp_arreglo_datos)
    {    		
      	 $this->vlc_fecha 				= $vp_arreglo_datos[0][1];
		$this->vlc_motivo				= $vp_arreglo_datos[0][2];	
		$this->vlc_diagnostico		    = $vp_arreglo_datos[0][3];
		$this->vlc_estudios				= $vp_arreglo_datos[0][4];					
		$this->vlc_tratamiento			= $vp_arreglo_datos[0][5];
		$this->vlc_indicaciones			= $vp_arreglo_datos[0][6];
		if ($this->vlc_id_paciente == "")
		{
			$this->vlc_id_paciente			= FN_RECIBIR_VARIABLES('paciente');
		}	            		  		             
    }    
    function MTD_DB_LISTAR ($vp_id = 0)
    {  
    	
    	
    	$where="";
    	if ($vp_id >0)
    	{
    		$where=" AND id_visita=$vp_id ";
    	}
      	$vlf_sql = "
        	SELECT
        	id_visita,
        	fecha,
        	motivo,
        	diagnostico,
        	estudios,
        	tratamientos,
        	indicaciones      	
        	from visitas_paciente        	
        	where id_paciente=" . $this->vlc_id_paciente .$where. " order by fecha desc";
        $vlf_arreglo_datos = FN_RUN_QUERY($vlf_sql,7, $this->vlc_db_conexion );
        
        return $vlf_arreglo_datos;
    }
    function MTD_DB_AGREGAR ()
    {
        $resultado = false;        
        $vlf_sql = "INSERT INTO visitas_paciente (        
        fecha,
        motivo,
        diagnostico,
        estudios,          
        tratamientos, 
        indicaciones, 
        id_paciente
        ) values (
        now(),
        '" . $this->vlc_motivo . "',        
        '" . $this->vlc_diagnostico. "',
        '" . $this->vlc_estudios. "',
        '" . $this->vlc_tratamiento. "',
        '" . $this->vlc_indicaciones. "',
        " . $this->vlc_id_paciente. "        
        )";
        //echo "sql: $vlf_sql";
        $resultado = FN_RUN_NONQUERY($vlf_sql, $this->vlc_db_conexion );   
        LOGGER::LOG("ABM pacientes: SQL:$vlf_sql");
        return $resultado;
    }
    function MTD_DB_ACTUALIZAR ()
    {
        $resultado = false;        
        $vlf_sql = "UPDATE usuarios set 
        fecha ='" . $this->vlc_fecha . "',
		apellido ='" . $this->vlc_motivo . "',
		username='" . $this->vlc_username. "',
		passwd='" . $this->vlc_passwd. "',
		holding='" . $this->vlc_holding. "',
		empresa='" . $this->vlc_empresa. "',
		sucursal='" . $this->vlc_sucursal. "',		
		diagnostico_particular='" . $this->vlc_diagnostico. "',
		estudios='" . $this->vlc_estudios. "',
		direccion='" . $this->vlc_direccion. "',
		ciudad='" . $this->vlc_ciudad. "',
		email='" . $this->vlc_email. "'			                    
        where id=" . $this->vlc_id;
		//echo "SQL: $vlf_sql";
        $resultado = FN_RUN_NONQUERY($vlf_sql, $this->vlc_db_conexion );        
        return $resultado;
    }
    function MTD_DB_ELIMINAR ()
    {
        $resultado = false;
        $vlf_sql = "DELETE FROM usuarios  where id =" . $this->vlc_id;
        $resultado = FN_RUN_NONQUERY($vlf_sql, $this->vlc_db_conexion );
        return $resultado;
    }
	function MTD_RETORNAR_RUTA_PROFUNDIDAD()
	{
		$vlf_ruta_profundida="
		Inicio,index.php;
		Fichas, #;
		Categorias de Reclamos, index.php?seccion=categorias";
		return $vlf_ruta_profundida;
	}
    function MTD_RETORNAR_CODIGO_HTML ()
    {
    	return $this->MTD_APLICAR_TEMPLATE($this->vlc_codigo_html);
        
    }
    function MTD_LEER_TPL($vp_template)
    {
    	LOGGER::LOG("LEER TPL:". $vp_template);
    	if (file_exists($vp_template))
    	{
    		$fh  = fopen($vp_template, 'r');
    		$theData = fread($fh, filesize($vp_template));
    		fclose($fh);
    		// LOGGER::LOG("MTD_FORMULARIO_INVESTIGACIONES :". $theData);
    		return $theData;
    	}
    	else
    	{
    		LOGGER::LOG("LEER TPL:". $vp_template ." el archo no existe");
    		return "---";
    	}
    }
}
?>