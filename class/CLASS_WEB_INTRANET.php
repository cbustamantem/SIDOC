<?php
class CLASS_WEB_INTRANET
{
    private $vlc_codigo_html;
    private $vlc_db_conexion;
    function __construct ($vp_conexion)
    {
        $this->vlc_codigo_html = "";
        $this->vlc_db_conexion = $vp_conexion;
        $this->MTD_INICIALIZAR_PAGINA();
        
    }
    function MTD_INICIALIZAR_PAGINA ()
    {
    
			
		//include_once('login.php');
		//include_once('CLASS_SESSION.php');
		
		$vlf_session_activada= true;
		//$obj_session = new CLASS_SESSION($vlf_conexion);
		
        //-----------------------------------------
        // INICIALIZACION DE VARIABLES
        //-----------------------------------------
        $vlf_codigo_html_principal = "";
        $vl_cod_html_seccion = "";
        
        //-----------------------------------------
      	//- DETERMINA LA SECCION DEL AREA A MOSTRAR -
	    //-------------------------------------------    
	    $vlf_seccion = "login";
	    LOGGER::LOG("Web: ");
	    if (isset($_REQUEST['seccion']))
	    {
	        $vlf_seccion = $_REQUEST['seccion'];
		  
		    if ($vlf_seccion == 'categorias')
		    {
		    	LOGGER::LOG("Web: seccion categorias");
		        include ('CLASS_ABM_CATEGORIAS.php');
		        $obj_seccion = new CLASS_ABM_CATEGORIAS($this->vlc_db_conexion );
		        $this->vlc_codigo_html  = $obj_seccion->MTD_RETORNAR_CODIGO_HTML();
		    }
		    elseif ($vlf_seccion == 'subcategorias')
		    {
		    	LOGGER::LOG("Web: seccion subcategorias");
		        include ('CLASS_ABM_SUBCATEGORIAS.php');
		        $obj_seccion = new CLASS_ABM_SUBCATEGORIAS($this->vlc_db_conexion );
		        $this->vlc_codigo_html  = $obj_seccion->MTD_RETORNAR_CODIGO_HTML();
		    }

		    elseif ($vlf_seccion == 'documentos')
		    {		    	
		    			    	
		    	include ('CLASS_DOCUMENTOS.php');
		    	$obj_perfil = new CLASS_DOCUMENTOS($this->vlc_db_conexion );
		    	$obj_perfil->MTD_INICIALIZAR_PAGINA();
		    	$this->vlc_codigo_html = $obj_perfil->MTD_RETORNAR_CODIGO_HTML();
		    }
		    elseif ($vlf_seccion == 'usuarios')
		    {		    			    			    	
		    	include ('CLASS_ABM_USUARIOS.php');
		    	$obj_usuarios = new CLASS_ABM_USUARIOS($this->vlc_db_conexion );
		    	$obj_usuarios->MTD_INICIALIZAR_PAGINA_ADM();
		    	$this->vlc_codigo_html = $obj_usuarios->MTD_RETORNAR_CODIGO_HTML();
		    }
		    elseif ($vlf_seccion == 'perfiles')
		    {		    			    			    	
		    	include ('CLASS_ABM_PERFILES.php');
		    	$obj_perfil = new CLASS_ABM_PERFILES($this->vlc_db_conexion );		    
		        $this->vlc_codigo_html  = $obj_perfil->MTD_RETORNAR_CODIGO_HTML();
		    }
		    elseif ($vlf_seccion == 'visitas')
		    {		    			    			    	
		    	include ('CLASS_VISITAS.php');
		    	$obj_visitas = new CLASS_VISITAS($this->vlc_db_conexion );		    
		        $this->vlc_codigo_html  = $obj_visitas->MTD_RETORNAR_CODIGO_HTML();
		    }
		    elseif ($vlf_seccion == 'salir')
		    {
		 		$obj_session->logout();
		 		header ( "Location: index.php" );
		    }
		    else
		    {
		 		LOGGER::LOG("Web: menu principal ");	    	   	
		    }


	    }	    	   
	    else
	    {
	    	LOGGER::LOG("Web: menu principal ");	    	
	    }
	    
	    
	    //-----------------------------
	    //- RETORNO DE CODIGO HTML UP -
	    //-----------------------------
	   // $this->vlc_codigo_html= $vlf_codigo_html_principal;
             
        
        
         
        //--------------------------------------------
        // REEMPLAZAZ EL CODIGO CENTRAL CON LA SECCION
        //--------------------------------------------
       // $vl_cod_html_base = FN_REEMPLAZAR('{tpl-contenido-intranet}', $vl_cod_html_seccion, $vl_cod_html_base);
        //-------------------------------------------
        // IMPRIME EL CODIGO HTML
        //-------------------------------------------
       // $this->vlc_codigo_html = $vlf_codigo_html_principal;
        //return $this->vlc_codigo_html;
    }
    function MTD_RETORNAR_CODIGO_HTML ()
    {
        return utf8_decode($this->vlc_codigo_html);
    }
}
?>