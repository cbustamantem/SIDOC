<?php
class CLASS_ABM_USUARIOS
{
    private $vlc_codigo_html;
    private $vlc_nombre_usuario;
    private $vlc_apellido_usuario;
    private $vlc_email;
    private $vlc_passwd;
    private $vlc_telefono_particular;
    private $vlc_telefono_movil;
    private $vlc_direccion;    
    private $vlc_cedula;    
    private $vlc_registro_medico;
    private $vlc_db_conexion;          
    private $vlc_tratamiento;
    private $vlc_especialidad;
    
    function __construct($vp_conexion)
    {
    	$this->vlc_db_conexion =$vp_conexion;
	$this->MTD_LIMPIAR_VARIABLES();
        //$this->MTD_INICIALIZAR_PAGINA();
        
    }
    function MTD_LIMPIAR_VARIABLES()
    {
		$this->vlc_codigo_html="";	    
	    $this->vlc_nombre_usuario="";
	    $this->vlc_apellido_usuario="";
	    $this->vlc_username="";
	    $this->vlc_passwd="";	   
	    $this->vlc_telefono_particular="";
	    $this->vlc_telefono_movil="";	 	       	    	    
	    $this->vlc_cedula="";
	    $this->vlc_registro_medico="";
	    $this->vlc_tratamiento="";
	    $this->vlc_especialidad="";	    
    }
    function MTD_AGREGAR_USUARIO()
    {
    	
    	LOGGER::LOG("ABM USUARIOS: MTD Agregar ");
    	$this->MTD_RECIBIR_DATOS();
    	$vlf_resultado = "";
    	if ($this->MTD_DB_AGREGAR())
    	{
    		//$vlf_resultado = "<img src='archivos_de_disenho/imagenes/resultado_ok.png'> Se agrego correctamente el Registro";
    		LOGGER::LOG("ABM USUARIOS: MTD Agregar OK");
    		//header ( "Location: index.php?id=registro" );
    		return "0";
    	}
    	else
    	{
    		LOGGER::LOG("ABM USUARIOS: MTD Agregar FAIL");
    		return  "(Registro Medico / Email) previamente registrados";
    	}
    	
    }
    function MTD_INICIALIZAR_PAGINA ()
    {
        /*
         * TODO: 
         * VALORES DEL FORMULARIO
         * ----------------------
         * [tb_nombre_usuario]
         * [id_usuario]
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
    	LOGGER::LOG("ABM USUARIOS lectura template ");
        $vl_cod_html_base = FN_LEER_TPL('tpl/tpl-registro.html');
        /*
         * ================================
         * AGREGAR REGISTROS
         * ================================
         */
        
        if (isset($_REQUEST['MTD_AGREGAR']))
        {
        	LOGGER::LOG("ABM USUARIOS: MTD Agregar ");
            $this->MTD_RECIBIR_DATOS();
            $vlf_resultado = "";
            if ($this->MTD_DB_AGREGAR())
            {
                //$vlf_resultado = "<img src='archivos_de_disenho/imagenes/resultado_ok.png'> Se agrego correctamente el Registro";
            	LOGGER::LOG("ABM USUARIOS: MTD Agregar OK");
            	header ( "Location: index.php?id=registro" );
            }
            else
            {
            	LOGGER::LOG("ABM USUARIOS: MTD Agregar FAIL");
                $vlf_resultado = "<img src='archivos_de_disenho/imagenes/resultado_mal.png'> Atencion Ocurrio un error durante la operacion, verifique los datos";
            }
            $this->MTD_LIMPIAR_VARIABLES();
            $vl_cod_html_base = $this->MTD_APLICAR_TEMPLATE($vl_cod_html_base);
            $vl_cod_html_base = FN_REEMPLAZAR('{accion-formulario}', 'MTD_AGREGAR', $vl_cod_html_base);
            $vl_cod_html_base = FN_REEMPLAZAR('{titulo-accion-formulario}', 'Agregar usuario', $vl_cod_html_base);
            $vl_cod_html_base = FN_REEMPLAZAR('{resultado-operacion}', $vlf_resultado, $vl_cod_html_base);
           
        }
       
        
        /*	
         * ================================
         * EDITAR REGISTROS
         * ================================
         */
        elseif (isset($_GET['MTD_EDITAR']))
        {
            $this->MTD_RECIBIR_DATOS();            
            $vlp_datos_grilla = $this->MTD_DB_LISTAR(true);        
            $vlf_resultado = ""; 
            $this->MTD_RECIBIR_DATOS_DB($vlp_datos_grilla);           
            $vl_cod_html_base = $this->MTD_APLICAR_TEMPLATE($vl_cod_html_base);   
        	         
            $vl_cod_html_base = FN_REEMPLAZAR('{accion-formulario}', 'MTD_ACTUALIZAR', $vl_cod_html_base);
            $vl_cod_html_base = FN_REEMPLAZAR('{titulo-accion-formulario}', 'Actualizar usuario', $vl_cod_html_base);
            $vl_cod_html_base = FN_REEMPLAZAR('{resultado-operacion}', $vlf_resultado, $vl_cod_html_base);
         
        }
        elseif (isset($_GET['MTD_ELIMINAR']))
        {
            $this->MTD_RECIBIR_DATOS();
            $vlf_resultado = "";
            if ($this->MTD_DB_ELIMINAR())
            {
                $vlf_resultado = "<img src='archivos_de_disenho/imagenes/resultado_ok.png'> Se elimino correctamente el Registro";
            }
            else
            {
                $vlf_resultado = "<img src='archivos_de_disenho/imagenes/resultado_mal.png'> Atencion Ocurrio un error durante la operacion, verifique los datos";
            }
            $vl_cod_html_base = $this->MTD_APLICAR_TEMPLATE($vl_cod_html_base);
            $vl_cod_html_base = FN_REEMPLAZAR('{accion-formulario}', 'MTD_AGREGAR', $vl_cod_html_base);            
            $vl_cod_html_base = FN_REEMPLAZAR('{titulo-accion-formulario}', 'Agregar usuario', $vl_cod_html_base);
            $vl_cod_html_base = FN_REEMPLAZAR('{resultado-operacion}', $vlf_resultado, $vl_cod_html_base);            
        }
        else
        {
        	LOGGER::LOG("ABM USUARIOS. lectura ");
            $vl_cod_html_base = $this->MTD_APLICAR_TEMPLATE($vl_cod_html_base);
        	$vl_cod_html_base = FN_REEMPLAZAR('{accion-formulario}', 'MTD_AGREGAR', $vl_cod_html_base);
            $vl_cod_html_base = FN_REEMPLAZAR('{titulo-accion-formulario}', 'Agregar usuario', $vl_cod_html_base);
            $vl_cod_html_base = FN_REEMPLAZAR('{resultado-operacion}', '', $vl_cod_html_base);
            
        }

        $this->vlc_codigo_html = $vl_cod_html_base;
    }
   	function MTD_ACTUALIZAR_DATOS_PERSONALES()
   	{ 
   		/*
     	 * ================================
         * ACTUALIZAR REGISTROS
         * ================================
         */
   		$this->MTD_RECIBIR_DATOS();
   		$vlf_resultado = "";
   		if ($this->MTD_DB_ACTUALIZAR())
   		{
   			$vlf_resultado = "<br><br><br>Se actualizo correctamente el Registro";
   		}
   		else
   		{
   			$vlf_resultado = "<br><br><br>Atencion Ocurrio un error durante la operacion, verifique los datos";
   		}
   		$this->MTD_LIMPIAR_VARIABLES();
   		return $vlf_resultado;
   	}
    function MTD_APLICAR_TEMPLATE ($vp_codigo_html)
    {    		   
    	$vp_codigo_html = FN_REEMPLAZAR('{tb-nombre-usuario}', $this->vlc_nombre_usuario, $vp_codigo_html);
    	$vp_codigo_html = FN_REEMPLAZAR('{tb-apellido-usuario}', $this->vlc_apellido_usuario, $vp_codigo_html);    	
    	$vp_codigo_html = FN_REEMPLAZAR('{tb-email}', $this->vlc_email, $vp_codigo_html);
    	$vp_codigo_html = FN_REEMPLAZAR('{tb-passwd}', $this->vlc_passwd, $vp_codigo_html);    	     	   	    	                
        $vp_codigo_html = FN_REEMPLAZAR('{tb-telefono-movil}', $this->vlc_telefono_movil, $vp_codigo_html);
        $vp_codigo_html = FN_REEMPLAZAR('{tb-telefono-particular}', $this->vlc_telefono_particular, $vp_codigo_html);
        $vp_codigo_html = FN_REEMPLAZAR('{tb-direccion}', $this->vlc_direccion, $vp_codigo_html);
        $vp_codigo_html = FN_REEMPLAZAR('{tb-registro-medico}', $this->vlc_registro_medico, $vp_codigo_html);                
        $vp_codigo_html = FN_REEMPLAZAR('{tb-cedula}', $this->vlc_cedula, $vp_codigo_html);      

        //GRILLA DE USUARIOS
     //   $vlf_codigo_grilla_usuarios= $this->MTD_GENERAR_GRILLA();      
      //  $vp_codigo_html 		= FN_REEMPLAZAR('{grilla-datos-usuarios}', $vlf_codigo_grilla_usuarios, $vp_codigo_html);
                       
                   
        return  $vp_codigo_html;
    }
  	function MTD_RECIBIR_DATOS ()
    {      	     
		$this->vlc_nombre_usuario 				= FN_RECIBIR_VARIABLES('nombre');
		$this->vlc_apellido_usuario				= FN_RECIBIR_VARIABLES('apellido');
		$this->vlc_passwd						= FN_RECIBIR_VARIABLES('password');
		$this->vlc_telefono_particular		    = FN_RECIBIR_VARIABLES('telefono');
		$this->vlc_telefono_movil				= FN_RECIBIR_VARIABLES('telefono_celular');
		$this->vlc_direccion					= FN_RECIBIR_VARIABLES('direccion');
		$this->vlc_email						= FN_RECIBIR_VARIABLES('email');				
		$this->vlc_cedula						= FN_RECIBIR_VARIABLES('cedula');
		$this->vlc_registro_medico				= FN_RECIBIR_VARIABLES('registro_medico');		
		$this->vlc_tratamiento					= FN_RECIBIR_VARIABLES('tratamiento');
		$this->vlc_especialidad					= FN_RECIBIR_VARIABLES('especialidad');
		LOGGER::LOG("ABM USUARIOS: Recibir datos: OK");
			   
    }
 	function  MTD_RECIBIR_DATOS_DB($vp_arreglo_datos)
    {
    
        $this->vlc_id_usuario         		= $vp_arreglo_datos[0][0];
        $this->vlc_nombre_usuario			= $vp_arreglo_datos[0][1];
        $this->vlc_apellido_usuario			= $vp_arreglo_datos[0][2];        
        $this->vlc_telefono_particular		= $vp_arreglo_datos[0][3];
        $this->vlc_telefono_movil			= $vp_arreglo_datos[0][4];
        $this->vlc_direccion				= $vp_arreglo_datos[0][5];         
        $this->vlc_registro_medico			= $vp_arreglo_datos[0][6];
	    $this->vlc_cedula					= $vp_arreglo_datos[0][7];
	    $this->vlc_tratamiento				= $vp_arreglo_datos[0][8];
	    $this->vlc_especialidad				= $vp_arreglo_datos[0][9];	    	    	    	        	    	            		  		           
    }    
    function MTD_DB_LISTAR ($vp_filtrar = false)
    {  
      	if ($vp_filtrar)
        {
        
            $vlf_sql = "
            		SELECT
			id_usuario,
			nombre_usuario,
			apellido_usuario,
			telparticular,
			telmovil,
			direccion,
			registromedico,
			cedula,
			tratamiento,
			id_especialidad
			FROM usuarios
			where id_usuario =" . $_SESSION['uid'];
        }
        else
        {
            $vlf_sql = "            
			SELECT
			id_usuario,
			nombre_usuario,
			apellido_usuario,
			telparticular,
			telmovil,
			direccion,
			registromedico,
			cedula,
			tratamiento,
			id_especialidad
			FROM usuarios;";
        }
        $vlf_arreglo_datos = FN_RUN_QUERY($vlf_sql,10, $this->vlc_db_conexion );
        return $vlf_arreglo_datos;
    }
    function MTD_DB_AGREGAR ()
    {
        $resultado = false;
        $membrete=$this->vlc_tratamiento." ".$this->vlc_nombre_usuario." ".$this->vlc_apellido_usuario;        
        $vlf_sql = "INSERT INTO usuarios (        
        nombre_usuario,
        apellido_usuario,
        username,
        passwd,      
        telparticular,
        telmovil,
        direccion,           
        registromedico,  
        cedula,rol_usuario,
        tratamiento,
        id_especialidad,
        encabezado_membrete             
        ) values (
        '" . $this->vlc_nombre_usuario . "',
        '" . $this->vlc_apellido_usuario . "',
        '" . $this->vlc_email. "',
        MD5('". $this->vlc_passwd. "'),         
        '" . $this->vlc_telefono_particular. "',
        '" . $this->vlc_telefono_movil. "',
        '" . $this->vlc_direccion. "',
        '" . $this->vlc_registro_medico. "',
        '" . $this->vlc_cedula. "','usuario',
        '" . $this->vlc_tratamiento. "',
        " . $this->vlc_especialidad. ",
        '".$membrete."'        
        )";
        //echo "sql: $vlf_sql";
        $resultado = FN_RUN_NONQUERY($vlf_sql, $this->vlc_db_conexion );   
        LOGGER::LOG("ABM USUARIOS: SQL:$vlf_sql");
        return $resultado;
    }
    function MTD_DB_ACTUALIZAR ()
    {
        $resultado = false;        
        $vlf_sql = "UPDATE usuarios set 
        nombre_usuario ='" . 	$this->vlc_nombre_usuario . "',
		apellido_usuario ='" . 	$this->vlc_apellido_usuario . "',
		id_especialidad=" . 		$this->vlc_especialidad. ",
		registromedico='" . 	$this->vlc_registro_medico. "',
		cedula='" . 			$this->vlc_cedula. "',		
		telparticular='" . 		$this->vlc_telefono_particular. "',
		telmovil='" . 			$this->vlc_telefono_movil. "',
		direccion='" . 			$this->vlc_direccion. "',
		tratamiento='" . 		$this->vlc_tratamiento. "'					                  
        where id_usuario=" . 	$_SESSION['uid'];
		//cho "SQL: $vlf_sql";
        LOGGER::LOG("ABM USUARIOS: SQL:$vlf_sql");
        $resultado = FN_RUN_NONQUERY($vlf_sql, $this->vlc_db_conexion );		              
        return $resultado;
    }
    function MTD_DB_ELIMINAR ()
    {
        $resultado = false;
        $vlf_sql = "DELETE FROM usuarios  where id_usuario =" . $this->vlc_id_usuario;
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
        return $this->vlc_codigo_html;
    }
    
    function MTD_RECUPERAR_PASSWORD()
    {    	
    	$username= FN_RECIBIR_VARIABLES("direccioncorreo");
    	$sql= "SELECT nombre_usuario,apellido_usuario, username from usuarios where username='$username'";
    	$resultado=FN_RUN_QUERY($sql, 1,$this->vlc_db_conexion);
    	if ($resultado)
    	{
    		$newpassword="";
	    	$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
	    	for ($i = 0; $i < 8; $i++) {
	    		$cantidadalfabeto=58;
	    		$n = rand(0, $cantidadalfabeto -1);
	    		
	    		$pass[$i] = $alphabet[$n];
	    		$newpassword.=$pass[$i];
	    		LOGGER::LOG("PASS: N:$n  P:".$pass[$i]." C:".$cantidadalfabeto);
	    	}
	    	$password= md5($newpassword);
	    	$nombre = $resultado[0][0]." ".$resultado[0][1];
	    	$sql="update usuarios set passwd='$password' where username ='$username' limit 1";
	    	FN_RUN_NONQUERY($sql,$this->vlc_db_conexion);
	    	LOGGER::LOG("ACTUALIZANDO ELPASSWORD:");
	    	$contenidomail="<h3>Consultorio Medico </h3> <br>
	    					<b>Cambio de password </b><br>
	    					<i>Titular de la Cuenta: </i> $nombre 
	    					<i>Usuario: </i>$username
	    					<i>Contrase&ntilde;a: [".$newpassword."]       *sin los caracteres []<br>
	    			<a href='www.consultorioparaguayo.com/consultorio/'> Ingrese a su cuenta </a>

	    			obs: Ingrese en su perfil profesional para cambiar su contrase&ntilde;a
	    	";
	    	$asunto="www.consultorioparaguayo.com.py - Actualizaci&oacute;n de contrase&ntilde;a";
	    	$this->FN_NET_ENVIAR_MAIL($asunto, $username, $contenidomail);
	    	$template= "<br><br><br><h4>Operaci&oacute;n exitosa, favor verifique su correo electronico para ingresar </h4>";
    	}
    	else
    	{
    		$template="<br><br><br><h4>Atencion, la direccion ingresada no se encuentra registrada </h4>";
    	}
    	return $template;
    }
    function  MTD_MOSTRAR_RECUPERAR_PASSWORD()
    {
    	$template= $this->MTD_LEER_TPL('tpl/tpl-recuperar-password.html');
    	return $template;
    }
    function  MTD_MOSTRAR_EDITAR_DATOS_PERSONALES()
    {
    	$template= $this->MTD_LEER_TPL('tpl/tpl-editar-datos-personales.html');    	
    	$registros = $this->MTD_DB_LISTAR(true);
    	$this->MTD_RECIBIR_DATOS_DB($registros);
    	$template = FN_REEMPLAZAR("{tpl-nombre}",$this->vlc_nombre_usuario,$template);
    	$template = FN_REEMPLAZAR("{tpl-apellido}",$this->vlc_apellido_usuario,$template);
    	$template = FN_REEMPLAZAR("{tpl-registro-medico}",$this->vlc_registro_medico,$template);
    	
    	$sql="SELECT idespecializacion, nombre from especializacion";
    	$arreglo= FN_RUN_QUERY($sql, 2,$this->vlc_db_conexion);    	
    	if ($arreglo)
    	{
    		$opciones="";
    		$selected="";
    		foreach ($arreglo as $dato)
    		{
    			if ($dato[0] == $this->vlc_especialidad)
    			{
    				$selected=" selected" ;
    			}
    			else
    			{
    				$selected="";
    			}	
    			$opciones.="<option value='".$dato[0]."' $selected>".$dato[1]."</option>";
    		}
    		    		
    		$template = FN_REEMPLAZAR("{tpl-opciones-especialidad}", $opciones, $template);
    	}
    	
    	
    	$template = FN_REEMPLAZAR("{tpl-especialidad}",$this->vlc_nombre_usuario,$template);
    	
    	//Tratamiento
    	
    	$opc_dr="";
    	$opc_dra="";
    	$opc_profdr="";
    	$opc_profdra="";
    	$opc_lic="";
    	
    	if($this->vlc_tratamiento == "Dr.")
    	{
    		$opc_dr="selected";
    	}
    	elseif($this->vlc_tratamiento == "Dra.")
    	{
    		$opc_dra="selected";
    	}
    	elseif($this->vlc_tratamiento == "Prof. Dr.")
    	{
    		$opc_profdr="selected";
    	}
    	elseif($this->vlc_tratamiento == "Prof. Dra.")
    	{
    		$opc_profdra="selected";
    	}
    	elseif($this->vlc_tratamiento == "Lic.")
    	{
    		$opc_lic="selected";
    	}
    	
    	$opciones_tratamiento='<option value="Dr." '.$opc_dr.' >Dr.</option>
						<option value="Dra." '.$opc_dra.'>Dra.</option>
						<option value="Prof. Dr." '.$opc_profdr.'>Prof. Dr.</option>
						<option value="Prof. Dra." '.$opc_profdra.'>Prof. Dra.</option>
    					<option value="Lic." '.$opc_lic.'>Lic.</option>';
    	
    	$template = FN_REEMPLAZAR("{tpl-opciones-tratamiento}",$opciones_tratamiento,$template);
    	
    	$template = FN_REEMPLAZAR("{tpl-celular}",$this->vlc_telefono_movil,$template);
    	$sql="SELECT idespecializacion, nombre from especializacion";
    	$arreglo= FN_RUN_QUERY($sql, 2,$this->vlc_db_conexion);
    	if ($arreglo)
    	{
    		$opciones="";
    		foreach ($arreglo as $dato)
    		{
    			$opciones.="<option value='".$dato[0]."'>".$dato[1]."</option>";
    		}
    		$vl_cod_html_base = FN_REEMPLAZAR("{tpl-opciones-especialidad}", $opciones, $vl_cod_html_base);
    	}
    	
    	$template = FN_REEMPLAZAR("{tpl-cedula}",$this->vlc_cedula,$template);
    	$template = FN_REEMPLAZAR("{tpl-direccion}",$this->vlc_direccion,$template);
    	$template = FN_REEMPLAZAR("{tpl-nro-telefono}",$this->vlc_telefono_particular,$template);
    	
    	$template = FN_REEMPLAZAR("{tpl-nombre}",$this->vlc_nombre_usuario,$template);
    	return $template;
    }
    function  MTD_MOSTRAR_PERFIL_DOCTOR()
    {
    	LOGGER::LOG("MTD_MOSTRAR_PERFIL_DOCTOR:");
    	$template= $this->MTD_LEER_TPL('tpl/tpl-perfil-doctor.html');
    	$id_doctor = FN_RECIBIR_VARIABLES("id_doctor");
    	$arreglo= array();
    	$vlf_sql = "
    	SELECT
    	encabezado_membrete,
    	pie_membrete    	
    	FROM usuarios where id_usuario = $id_doctor;";    	
    	$arreglo = FN_RUN_QUERY($vlf_sql,2, $this->vlc_db_conexion );
    	if ($arreglo)
    	{
    		$encabezado=$arreglo[0][0];
    		$encabezado= FN_REEMPLAZAR("\n", "<br>", $encabezado);
    		$pie = $arreglo[0][1];
    		$pie = FN_REEMPLAZAR("\n", "<br>", $pie);
    		$template= FN_REEMPLAZAR("{tb-encabezado-membrete}", $encabezado,$template);
    		$template= FN_REEMPLAZAR("{tb-pie-membrete}", $pie,$template);
    	}    	
    	
    	return $template;
    }
    function  MTD_MOSTRAR_CAMBIAR_PASSWORD()
    {
    	LOGGER::LOG("MTD_MOSTRAR_CAMBIAR_PASSWORD:");
    	$template= $this->MTD_LEER_TPL('tpl/tpl-cambiar-password.html');
    	return $template;
    }
    function  MTD_CAMBIAR_PASSWORD()
    {
    	$password = FN_RECIBIR_VARIABLES('password');
    	$sql= "update usuarios set passwd= MD5('$password') where id_usuario = ".$_SESSION['uid']." limit 1;";
    	$result=false;
    	LOGGER::LOG("CAMBIAR_PASSWORD: sql:$sql");
    	$result= FN_RUN_NONQUERY($sql,$this->vlc_db_conexion);
    	return "<b> Contrase&ntilde;a cambiada exitosamente </b>";
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
    function FN_NET_ENVIAR_MAIL($vp_asunto,$remitente,$vp_contenido)
    {
    
    	$de='info@consultorioparaguayo.com.py';
    	$cabeceras="From: ".$de.">\n";
    	$tema=$vp_asunto;
    
    	$cabeceras.="MIME-version: 1.0\n";
    	$cabeceras.="Content-type: multipart/mixed; ";
    	$cabeceras.="boundary=\"Message-Boundary\"\n";
    	$cabeceras.="Content-transfer-encoding: 7BIT\n";
    
    	$body_top = "--Message-Boundary\n";
    	$body_top .= "Content-type: text/html; charset=US-ASCII\n";
    	$body_top .= "Content-transfer-encoding: 7BIT\n";
    	$body_top .= "Content-description: Mail message body\n\n";
    
    	$mensaje=$body_top.$vp_contenido;
    	LOGGER::LOG("Envio de Email a:>$remitente \nAsunto: $tema \n Contenido:$mensaje ");
    	mail($remitente, $tema, $mensaje, $cabeceras);
    }
}
?>