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
    private $vlc_db_cn;          

    
    function __construct($vp_conexion)
    {
    	$this->vlc_db_cn =$vp_conexion;
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
    function MTD_INICIALIZAR_PAGINA_ADM()
    {
       $historial="";
       $investigacion="";
       $investigacion= FN_RECIBIR_VARIABLES("documento");
       $this->vlc_codigo_html = FN_LEER_TPL('tpl/tpl-adm-usuarios.html');
       $busqueda= FN_RECIBIR_VARIABLES("busqueda");
       $datos="";
       if ($busqueda)
       {
            $datos= utf8_encode($this->MTD_BUSCAR_USUARIOS());
       }
      else
      {
            $datos = $this->MTD_BUSCAR_LISTA_USUARIOS_ADM();
       }
       $this->vlc_codigo_html = FN_REEMPLAZAR("{tpl-busqueda}", $busqueda, $this->vlc_codigo_html );
       $this->vlc_codigo_html = FN_REEMPLAZAR("{tpl-datos}",$datos,$this->vlc_codigo_html);
        
    }
     function MTD_BUSCAR_USUARIOS()
    {
        LOGGER::LOG("BUSCAR_USUARIOS");
        $tipo = FN_RECIBIR_VARIABLES("tipo_busqueda");
        $busqueda= FN_RECIBIR_VARIABLES("busqueda");
        LOGGER::LOG("BUSCAR_USUARIOS > TIPO:".$tipo);
        LOGGER::LOG("BUSCAR_USUARIOS > Busqueda:".$busqueda);
        $arreglo = array();
        $sql="SELECT 
                id_usuario, 
                nombre_usuario, 
                apellido_usuario FROM usuarios 
                WHERE
                nombre_usuario like '%$busqueda%' or apellido_usuario like '%$busqueda%';";
        $arreglo = FN_RUN_QUERY($sql,3, $this->vlc_db_cn);      
        //$arreglo_datos= FN_RUN_QUERY($sql, 3, $this->vlc_db_cn);
        $contador =0;
        $html="";
        if ($arreglo)
        {
            $html='<table  cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%" >
            <thead>
            <tr>
            <th>Titulo</th>
            <th>Descripcion</th>            
            </tr>
            </thead>
            <tbody>';
            foreach ($arreglo as $datos)
            {
                $html.="<TR><TD>".substr($datos[1],0,70)."</TD><TD><a href=''>".substr($datos[2],0,50)."</a></TD>
                ";
            }
            $html.="</tbody></table>";
             
        }
        else
        {
            $html='<table  cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%" >
            <thead>
            <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            </tr>
            </thead>
            <tbody>
            <TR><TD >No se encontraron registros</TD><TD></TD></TR>';
            
            $html.="</tbody></table>";
             
        }
        LOGGER::LOG("BUSCAR_USUARIOS :\n".$html);
        return utf8_decode($html);
    }
    function MTD_BUSCAR_LISTA_USUARIOS_ADM()
    {
        LOGGER::LOG("BUSCAR_USUARIOS");
        $busqueda= FN_RECIBIR_VARIABLES("busqueda");        
        LOGGER::LOG("BUSCAR_USUARIOS > Busqueda:".$busqueda);
        $arreglo = array();
        $sql="SELECT 
                id_usuario, 
                nombre_usuario,                
                apellido_usuario,
                perf.perfil  
                FROM usuarios 
                LEFT JOIN perfiles_usuarios as perf ON (usuarios.perfil_usuario = perf.id_perfil) ";
        $arreglo = FN_RUN_QUERY($sql,4, $this->vlc_db_cn);
        //$arreglo_datos= FN_RUN_QUERY($sql, 3, $this->vlc_db_cn);
        $contador =0;
        $html="";
        if ($arreglo)
        {
            $html='<table  cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%" >
            <thead>
            <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Perfil</th>
            <th>Opciones</th>
            </tr>
            </thead>
            <tbody>';
            foreach ($arreglo as $datos)
            {
                $html.="<TR><TD>".$datos[0]."</TD>
                <TD>".substr($datos[1],0,70)."</TD>
                <TD>".substr($datos[2],0,70)."</TD>                
                <TD><a href='index.php?=".$datos[0]."'>".substr($datos[3],0,50)."</a></TD> 
                ".'<td>
      
                  <div class="btn-group">
                    <a class="btn" title="Editar" href="#Editar" onclick="javascript:MTD_EDITAR_PERFIL('.$datos[0].')"><i class="icon-edit"></i></a>
                    <a class="btn" title="Eliminar" href="#Eliminar" onclick="javascript:MTD_ELIMINAR_PERFIL('.$datos[0].')"><i class="icon-remove-circle"></i></a>
                    <a class="btn" title="Editar" href="#Perfil" onclick="javascript:MTD_MOSTRAR_PERFILES('.$datos[0].')"><i class="icon-check"></i></a>                                       
                    <a class="btn" title="Cambiar Password" href="#Password" onclick="javascript:MTD_MOSTRAR_CAMBIAR_CONTRASENHA('.$datos[0].')"><i class="icon-cog"></i></a>
                  </div>
                
            </td>
                </TR>';
            }
            $html.="</tbody></table>";           
        }
        LOGGER::LOG("BUSCAR_USUARIOS :\n");
        return $html;
    }
    function MTD_INICIALIZAR_PAGINA_REGISTRO ()
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
    function MTD_ELIMINAR_PERFIL()
    { 
        /*
         * ================================
         * ACTUALIZAR REGISTROS
         * ================================
         */
        $this->MTD_RECIBIR_DATOS();
        $vlf_resultado = "";

        if ($this->MTD_DB_ELIMINAR())
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
        $this->vlc_id_usuario                 = FN_RECIBIR_VARIABLES('id_usuario');

        if ($this->vlc_id_usuario == "")
        {
            $this->vlc_id_usuario=$_SESSION["uid"];
        }
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
	    $this->vlc_cedula					= $vp_arreglo_datos[0][7];	
	    	    	    	    	        	    	            		
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
			cedula			
			FROM usuarios
			where id_usuario =".$this->vlc_id_usuario;
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
			cedula			
			FROM usuarios;";
        }
        $vlf_arreglo_datos = FN_RUN_QUERY($vlf_sql,7, $this->vlc_db_cn );
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
        cedula,rol_usuario    
        ) values (
        '" . $this->vlc_nombre_usuario . "',
        '" . $this->vlc_apellido_usuario . "',
        '" . $this->vlc_email. "',
        MD5('". $this->vlc_passwd. "'),         
        '" . $this->vlc_telefono_particular. "',
        '" . $this->vlc_telefono_movil. "',
        '" . $this->vlc_direccion. "',        
        '" . $this->vlc_cedula. "','usuario'    
        )";
        //echo "sql: $vlf_sql";
        $resultado = FN_RUN_NONQUERY($vlf_sql, $this->vlc_db_cn );   
        LOGGER::LOG("ABM USUARIOS: SQL:$vlf_sql");
        return $resultado;
    }
    function MTD_DB_ACTUALIZAR ()
    {
        $resultado = false;        
        $vlf_sql = "UPDATE usuarios set 
        nombre_usuario ='" . 	$this->vlc_nombre_usuario . "',
		apellido_usuario ='" . 	$this->vlc_apellido_usuario . "',				
		cedula='" . 			$this->vlc_cedula. "',		
		telparticular='" . 		$this->vlc_telefono_particular. "',
		telmovil='" . 			$this->vlc_telefono_movil. "',
		direccion='" . 			$this->vlc_direccion. "'			                 
        where id_usuario=" . 	$this->vlc_id_usuario;
		//cho "SQL: $vlf_sql";
        LOGGER::LOG("ABM USUARIOS: SQL:$vlf_sql");
        $resultado = FN_RUN_NONQUERY($vlf_sql, $this->vlc_db_cn );		              
        return $resultado;
    }
    function MTD_DB_ELIMINAR ()
    {
        $resultado = false;
        $vlf_sql = "DELETE FROM usuarios  where id_usuario =" . $this->vlc_id_usuario;
        $resultado = FN_RUN_NONQUERY($vlf_sql, $this->vlc_db_cn );
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
    	$resultado=FN_RUN_QUERY($sql, 1,$this->vlc_db_cn);
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
	    	FN_RUN_NONQUERY($sql,$this->vlc_db_cn);
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
        if (FN_RECIBIR_VARIABLES("id_usuario") == "")
        {
            $this->vlc_id_usuario= $_SESSION["uid"];
        }
        else
        {
            $this->vlc_id_usuario=FN_RECIBIR_VARIABLES("id_usuario");
        }
    	$registros = $this->MTD_DB_LISTAR(true);
    	$this->MTD_RECIBIR_DATOS_DB($registros);
        $template = FN_REEMPLAZAR("{tpl-id-usuario}",FN_RECIBIR_VARIABLES("id_usuario"),$template);
    	$template = FN_REEMPLAZAR("{tpl-nombre}",$this->vlc_nombre_usuario,$template);
    	$template = FN_REEMPLAZAR("{tpl-apellido}",$this->vlc_apellido_usuario,$template);    	
    	
    	$template = FN_REEMPLAZAR("{tpl-celular}",$this->vlc_telefono_movil,$template);
    	
    	
    	$template = FN_REEMPLAZAR("{tpl-cedula}",$this->vlc_cedula,$template);
    	$template = FN_REEMPLAZAR("{tpl-direccion}",$this->vlc_direccion,$template);
    	$template = FN_REEMPLAZAR("{tpl-nro-telefono}",$this->vlc_telefono_particular,$template);
    	
    	$template = FN_REEMPLAZAR("{tpl-nombre}",$this->vlc_nombre_usuario,$template);
    	return $template;
    }
    function MTD_MOSTRAR_AGREGAR_USUARIO()
    {
        LOGGER::LOG("MTD_MOSTRAR_AGREGAR_USUARIO:");   
        $template= $this->MTD_LEER_TPL('tpl/tpl-registro.html');
        return $template;
    }
    function MTD_MOSTRAR_PERFILES()
    {
        LOGGER::LOG("MTD_MOSTRAR_perfiles usuarios");
        $id_usuario = FN_RECIBIR_VARIABLES("id_usuario");
        $html= FN_LEER_TPL("tpl/tpl-abm-usuarios-perfiles.html");
        $html= FN_REEMPLAZAR("{tpl-lista-perfiles}", $this->MTD_SELECCION_PERFILES(),$html);
        $html= FN_REEMPLAZAR("{tpl-id-usuario}", $id_usuario,$html);
        return $html;        
    }
    function MTD_SELECCION_PERFILES()
    {
        LOGGER::LOG("MOSTRAR SELECCION PERFILES");
        $codigo_html="";
        $datos = array();
        $datos = FN_RUN_QUERY("SELECT 
                        id_perfil,
                        perfil
                        from perfiles_usuarios
                        " , 2 , $this->vlc_db_cn);
        
        $codigo_html="<select id='lst_perfiles'>";

       
        foreach($datos as $key => $value)
        {
            $seleccion="";
            if (!$value[2])
            {
                $value[2]="0";
            }
                        
            

            $codigo_html.="<option value='".$value[0]."'  >".$value[1]."</option>";
        }
        $codigo_html.="</select>";
        return $codigo_html;
    }
    function MTD_ACTUALIZAR_PERFIL_USUARIO()
    {
        LOGGER::LOG("ACTUALIZAR PERFIL USUARIO");
        $id_usuario = FN_RECIBIR_VARIABLES("id_usuario");
        $perfil     = FN_RECIBIR_VARIABLES("perfil");

        $sql= "update usuarios set perfil_usuario=".$perfil." where id_usuario=".$id_usuario." limit 1";
        LOGGER::LOG("ACTUALIZAR PERFIL USUARIO SQL: ".$sql);
        FN_RUN_NONQUERY($sql,$this->vlc_db_cn);
        LOGGER::LOG("ACTUALIZAR PERFIL USUARIO");
        return "<h1> perfil actualizado exitosamente </h1>";
    }
    function  MTD_MOSTRAR_CAMBIAR_PASSWORD()
    {
        $id_usuario= FN_RECIBIR_VARIABLES("id_usuario");
        if (!$id_usuario)
        {
            $id_usuario="";
        }
    	LOGGER::LOG("MTD_MOSTRAR_CAMBIAR_PASSWORD:");
    	$template= $this->MTD_LEER_TPL('tpl/tpl-cambiar-password.html');
        $template= FN_REEMPLAZAR("{tpl-id-usuario}",$id_usuario,$template);
    	return $template;
    }
    function  MTD_CAMBIAR_PASSWORD()
    {
        $id_usuario = FN_RECIBIR_VARIABLES('id_usuario'); 
    	$password = FN_RECIBIR_VARIABLES('password');
        if (!$id_usuario)
        {
            $id_usuario = $_SESSION["uid"];
        }

        if ($id_usuario != $_SESSION["uid"])
        {
            if ($_SESSION["rol_usuario"] != "administrador")
            {
                return (" Error al procesar el cambio de password");
            }
        }

        $sql= "update usuarios set passwd= MD5('$password') where id_usuario = ".$id_usuario." limit 1;";
    	$result=false;
    	LOGGER::LOG("CAMBIAR_PASSWORD: sql:$sql");
    	$result= FN_RUN_NONQUERY($sql,$this->vlc_db_cn);
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