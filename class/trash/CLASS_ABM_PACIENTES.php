<?php
class CLASS_ABM_PACIENTES
{
    private $vlc_codigo_html;
    private $vlc_id_paciente;
    private $vlc_nombre;
    private $vlc_apellido;
    private $vlc_telefono;
    private $vlc_telefono_celular;   
    private $vlc_cedula;    
    private $vlc_id_medico;
    private $vlc_direccion;
    private $vlc_seguro_medico;
    private $vlc_numero_contrato;
    private $vlc_fecha_nacimiento;
    private $vlc_observacion;
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
	    $this->vlc_nombre="";
	    $this->vlc_apellido="";	    
	    $this->vlc_telefono="";
	    $this->vlc_telefono_celular="";	 	       	    	    
	    $this->vlc_cedula="";
	    $this->vlc_id_medico="";
	    $this->vlc_direccion="";
	    $this->vlc_seguro_medico="";
	    $this->vlc_numero_contrato="";
	    $this->vlc_fecha_nacimiento="";
	    $this->vlc_observacion="";	    
    }
    function MTD_LISTAR_PACIENTES()
    {
    	$arreglo= $this->MTD_DB_LISTAR();
    	$template="";
    	foreach($arreglo as $registro)
    	{
    		$template .= "<tr class='odd gradeX'>";
    		$template .= "<td>". $registro[3] ."</td>";
    		$template .= "<td>". $registro[2] ."</td>";
    		$template .= "<td>". $registro[1] ."</td>";
    		$template .= "<td><a href='index.php?id=registro&seccion=historial_paciente&paciente=".$registro[0]."'><img src='archivos_de_disenho/images/bt_visualizar.png' title='Ver Historial'></a> &nbsp;
    						  <a href='#editar' onclick='javascript:MTD_MOSTRAR_EDITAR_PACIENTE(".$registro[0].")'><img src='archivos_de_disenho/images/bt_editar.png' title='Editar'></a> &nbsp;
    						  <a href='#editar' onclick='javascript:MTD_MOSTRAR_PERFIL_PACIENTE(".$registro[0].")'><img src='archivos_de_disenho/images/bt_perfil_paciente.png' title='Ver datos del paciente'></a></td></tr>";    		    		
    	}
    	return $template;
    	/*
    	 * <tr class="odd gradeX">
			<td>4.483.531</td>
			<td>Rodrigo</td>
			<td>Bustamante</td>
			<td>Santa clara</td>
			<td>36</td>
			<td><a href=""><img src="archivos_de_disenho/images/bt_visualizar.png"></a></td>
		</tr>
    	 */
    }
    function MTD_AGREGAR_PACIENTE()
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
    		LOGGER::LOG("ABM PACIENTES: MTD Agregar FAIL");
    		return  "(Registro Medico / Email) previamente registrados";
    	}
    	
    }
    function MTD_EDITAR_PACIENTE()
    {
    	 
    	LOGGER::LOG("ABM PACIENTES: MTD EDITAR ");
    	$this->MTD_RECIBIR_DATOS();
    	$vlf_resultado = "";
    	if ($this->MTD_DB_ACTUALIZAR())
    	{    		
    		LOGGER::LOG("ABM PACIENTES: MTD EDITAR OK");
    		
    		return "0";
    	}
    	else
    	{
    		LOGGER::LOG("ABM PACIENTES: MTD EDITAR FAIL");
    		return  "(Registro Medico / Email) previamente registrados";
    	}
    	 
    }
   	function MTD_MOSTRAR_EDITAR_PACIENTE()
   	{
   		LOGGER::LOG("ABM PACIENTES: MTD MOSTRAR EDITAR PACIENTES");
   		$vl_cod_html_base = $this->MTD_LEER_TPL('tpl/tpl-editar-pacientes.html');
   		$id_paciente = FN_RECIBIR_VARIABLES("id_paciente");
   		$arreglo_datos = array();
   		$arreglo_datos = $this->MTD_DB_LISTAR(true,$id_paciente);
   		$this->MTD_RECIBIR_DATOS_DB($arreglo_datos);
   		$vl_cod_html_base = $this->MTD_APLICAR_TEMPLATE($vl_cod_html_base);
   		return $vl_cod_html_base;
   		
   	}
   	function MTD_MOSTRAR_PERFIL_PACIENTE()
   	{
   		LOGGER::LOG("ABM PACIENTES: MTD MOSTRAR PERFIL PACIENTES");
   		$vl_cod_html_base = $this->MTD_LEER_TPL('tpl/tpl-perfil-pacientes.html');
   		$id_paciente = FN_RECIBIR_VARIABLES("id_paciente");
   		$arreglo_datos = array();
   		$arreglo_datos = $this->MTD_DB_LISTAR(true,$id_paciente);
   		$this->MTD_RECIBIR_DATOS_DB($arreglo_datos);
   		$vl_cod_html_base = $this->MTD_APLICAR_TEMPLATE($vl_cod_html_base);
   		return $vl_cod_html_base;
   		 
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
    
    function MTD_DB_LISTAR_ULTIMOS_PACIENTES()
    {
    	//LISTANDO ULTIMOS PACIENTES
    	$sql="SELECT q1.id_paciente, q1.fechaconsulta ,q2.nombre,q2.apellido ,q1.motivo FROM
    	(
	    	SELECT id_paciente, MAX(fecha) as fechaconsulta, motivo from visitas_paciente
	    	group by id_paciente
	    	order by MAX(fecha) desc
	    	) AS q1,
	    	(
	    	SELECT id_paciente,nombre,apellido from  pacientes where id_doctor= ".$_SESSION['uid']."
	    	) AS q2
	    	WHERE
	    	q1.id_paciente = q2.id_paciente  order by q1.fechaconsulta desc limit 5;
    	";
    	$arreglo = FN_RUN_QUERY($sql, 5,$this->vlc_db_conexion);
    	$codigo_html="";
    	if ($arreglo)
    	{
    		$codigo_html="<ul>";
    		foreach($arreglo as $registro)
    		{
    			$codigo_html.="<li><a href='index.php?id=registro&seccion=historial_paciente&paciente=".$registro[0]."'>".date("d/m/y",strtotime($registro[1]))." ".$registro[2]." ".$registro[3]." - ".substr($registro[4],0,30).".</a> </li>";
    		}
    		$codigo_html.="</ul>";    		    	
    	}
    	return $codigo_html;
    }
    function MTD_INICIALIZAR_PAGINA ()
    {
        /*
         * TODO: 
         * VALORES DEL FORMULARIO
         * ----------------------
         * [tb_nombre]
         * [id]
         * 
         * ACCIONES DEL FORMULARIO
         * -----------------------
         * frm_insertar
         * frm_actualizar
         * 
         * ETIQUETAS DEL tpl
         * ------------------------
         * {accion-formulario}
         * {titulo-accion-formulario}
         * {grilla-datos-categoria}
         * {tb-nombre-categoria}         
         */
        $vl_cod_html_base = FN_LEER_TPL('tpl/tpl-abm-pacientes.html');
    
      

        $this->vlc_codigo_html = $vl_cod_html_base;
    }
   
    function MTD_APLICAR_TEMPLATE ($vp_codigo_html)
    {    		   
    	$vp_codigo_html = FN_REEMPLAZAR('{tb-id-paciente}', $this->vlc_id_paciente, $vp_codigo_html);
    	$vp_codigo_html = FN_REEMPLAZAR('{tb-nombre}', $this->vlc_nombre, $vp_codigo_html);
    	$vp_codigo_html = FN_REEMPLAZAR('{tb-apellido}', $this->vlc_apellido, $vp_codigo_html);    	  	     	   	    	               
        $vp_codigo_html = FN_REEMPLAZAR('{tb-telefono}', $this->vlc_telefono_celular, $vp_codigo_html);
        $vp_codigo_html = FN_REEMPLAZAR('{tb-telefono-celular}', $this->vlc_telefono, $vp_codigo_html);
        $vp_codigo_html = FN_REEMPLAZAR('{tb-id-medico}', $this->vlc_id_medico, $vp_codigo_html);                
        $vp_codigo_html = FN_REEMPLAZAR('{tb-cedula}', $this->vlc_cedula, $vp_codigo_html);
        $vp_codigo_html = FN_REEMPLAZAR('{tb-direccion}', $this->vlc_direccion, $vp_codigo_html);
        $vp_codigo_html = FN_REEMPLAZAR('{tb-seguro-medico}', $this->vlc_seguro_medico, $vp_codigo_html);
        $vp_codigo_html = FN_REEMPLAZAR('{tb-nro-contrato}', $this->vlc_numero_contrato, $vp_codigo_html);
        $vp_codigo_html = FN_REEMPLAZAR('{tb-fecha-nacimiento}', $this->vlc_fecha_nacimiento, $vp_codigo_html);
        $vp_codigo_html = FN_REEMPLAZAR('{tb-observacion}', $this->vlc_observacion, $vp_codigo_html);
        //GRILLA DE USUARIOS
     //   $vlf_codigo_grillas= $this->MTD_GENERAR_GRILLA();      
      //  $vp_codigo_html 		= FN_REEMPLAZAR('{grilla-datoss}', $vlf_codigo_grillas, $vp_codigo_html);
                       
                   
        return  $vp_codigo_html;
    }
  	function MTD_RECIBIR_DATOS ()
    {      	     
    	
    	$this->vlc_id_paciente 			= FN_RECIBIR_VARIABLES('id_paciente');
		$this->vlc_nombre 				= FN_RECIBIR_VARIABLES('nombre');
		$this->vlc_apellido				= FN_RECIBIR_VARIABLES('apellido');
	
		$this->vlc_telefono		    	= FN_RECIBIR_VARIABLES('telefono');
		$this->vlc_telefono_celular		= FN_RECIBIR_VARIABLES('telefono_celular');
		$this->vlc_direccion			= FN_RECIBIR_VARIABLES('direccion');
				
		$this->vlc_cedula				= FN_RECIBIR_VARIABLES('cedula');
		$this->vlc_direccion			= FN_RECIBIR_VARIABLES('direccion');
		$this->vlc_seguro_medico		= FN_RECIBIR_VARIABLES('seguro_medico');
		$this->vlc_numero_contrato			= FN_RECIBIR_VARIABLES('nro_contrato');
		$this->vlc_fecha_nacimiento		= FN_RECIBIR_VARIABLES('fecha_nacimiento');
		$this->vlc_observacion			= FN_RECIBIR_VARIABLES('observacion');
		
		
		$this->vlc_id_medico					= $_SESSION['uid'];
		LOGGER::LOG("ABM PACIENTES: Recibir datos: OK");
			   
    }
 	function MTD_RECIBIR_DATOS_DB ($vp_arreglo_datos)
    {    
        $this->vlc_id_paciente      = $vp_arreglo_datos[0][0];
        $this->vlc_nombre			= $vp_arreglo_datos[0][1];
        $this->vlc_apellido			= $vp_arreglo_datos[0][2];        
	    $this->vlc_cedula			= $vp_arreglo_datos[0][3];
	    $this->vlc_telefono			= $vp_arreglo_datos[0][5];
	    $this->vlc_telefono_celular = $vp_arreglo_datos[0][4];
	    $this->vlc_direccion		= $vp_arreglo_datos[0][6];
	    $this->vlc_seguro_medico	= $vp_arreglo_datos[0][7];	    
	    $this->vlc_numero_contrato  = $vp_arreglo_datos[0][8];
	    $this->vlc_fecha_nacimiento	= $vp_arreglo_datos[0][9];
	    $this->vlc_observacion		= $vp_arreglo_datos[0][10];
	        	    	            		  		             
    }         
    function MTD_DB_LISTAR ($vp_filtrar = false,$id_paciente = 0)
    {
      	if ($vp_filtrar == false)
        {
        	$vlf_sql = "
        	SELECT
        	id_paciente,
        	nombre,
        	apellido,
        	cedula,
        	telparticular,
        	telmovil,
        	direccion,
        	seguro_medico,
        	nro_contrato,
        	fecha_nacimiento,
        	observacion       	
        	from pacientes
        	where id_doctor =" . $_SESSION['uid'];
        }
        else
        {
      
            $vlf_sql = "
            SELECT 
			id_paciente, 
			nombre, 
			apellido, 
			cedula,
			telparticular, 
			telmovil,
			direccion,
        	seguro_medico,
        	nro_contrato,
        	fecha_nacimiento,
        	observacion
			 
			from pacientes
			where id_doctor =" . $_SESSION['uid']." and id_paciente=".$id_paciente;
        }
        $vlf_arreglo_datos = FN_RUN_QUERY($vlf_sql,11, $this->vlc_db_conexion );
        return $vlf_arreglo_datos;
    }
    function MTD_DB_AGREGAR ()
    {
        $resultado = false;        
        $vlf_sql = "INSERT INTO pacientes (        
        nombre,
        apellido,
        telparticular,
        telmovil,          
        id_doctor,  
        cedula,
        direccion,
        seguro_medico,
        nro_contrato,
        fecha_nacimiento,
        observacion
        ) values (
        '" . $this->vlc_nombre . "',
        '" . $this->vlc_apellido . "',        
        '" . $this->vlc_telefono. "',
        '" . $this->vlc_telefono_celular. "',
        "  . $this->vlc_id_medico. ",
        '" . $this->vlc_cedula. "',
        '" . $this->vlc_direccion. "',
        '" . $this->vlc_seguro_medico. "',
        '" . $this->vlc_numero_contrato. "',
        '" . $this->vlc_fecha_nacimiento. "',
        '" . $this->vlc_observacion. "' )";
        //echo "sql: $vlf_sql";
        $resultado = FN_RUN_NONQUERY($vlf_sql, $this->vlc_db_conexion );   
        LOGGER::LOG("ABM pacientes: SQL:$vlf_sql");
        return $resultado;
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
    function MTD_DB_ACTUALIZAR ()
    {
        $resultado = false;        
        $vlf_sql = "UPDATE pacientes set 
        nombre ='" . $this->vlc_nombre. "',
		apellido ='" . $this->vlc_apellido . "',
		telparticular='" . $this->vlc_telefono. "',
		telmovil='" . $this->vlc_telefono_celular. "',
		cedula='" . $this->vlc_cedula. "',
		direccion='" . $this->vlc_direccion. "',
		seguro_medico='" . $this->vlc_seguro_medico. "',		
		nro_contrato='" . $this->vlc_numero_contrato. "',
		fecha_nacimiento='" . $this->vlc_fecha_nacimiento. "',
		observacion='" . $this->vlc_observacion. "' 
		where id_paciente=" . $this->vlc_id_paciente;
		//echo "SQL: $vlf_sql";
		LOGGER::LOG("SQL: $vlf_sql");
        $resultado = FN_RUN_NONQUERY($vlf_sql, $this->vlc_db_conexion );        
        return $resultado;
    }
    function MTD_DB_ELIMINAR ()
    {
        $resultado = false;
        $vlf_sql = "DELETE FROM pacientes  where id =" . $this->vlc_id;
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
}
?>