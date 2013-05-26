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
		  
		    if ($vlf_seccion == 'consultorio')
		    {
		        include ('CLASS_CONSULTORIO.php');
		        $obj_consultorio = new CLASS_CONSULTORIO($this->vlc_db_conexion );
		        $vlf_codigo_html_seccion = $obj_consultorio->MTD_RETORNAR_CODIGO_HTML();
		    }
		    elseif ($vlf_seccion == 'investigaciones')
		    {		    	
		    			    	
		    	include ('CLASS_INVESTIGACIONES.php');
		    	$obj_perfil = new CLASS_INVESTIGACIONES($this->vlc_db_conexion );
		    	$obj_perfil->MTD_INICIALIZAR_PAGINA();
		    	$vlf_codigo_html_seccion = $obj_perfil->MTD_RETORNAR_CODIGO_HTML();
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
	    
	    
	    $vlf_codigo_html_principal = FN_REEMPLAZAR('{tpl-contenido}', $vlf_codigo_html_seccion, $vlf_codigo_html_principal);
	   
	    //-----------------------------
	    //- RETORNO DE CODIGO HTML UP -
	    //-----------------------------
	    $this->vlc_codigo_html= $vlf_codigo_html_principal;
             
        
        
         
        //--------------------------------------------
        // REEMPLAZAZ EL CODIGO CENTRAL CON LA SECCION
        //--------------------------------------------
       // $vl_cod_html_base = FN_REEMPLAZAR('{tpl-contenido-intranet}', $vl_cod_html_seccion, $vl_cod_html_base);
        //-------------------------------------------
        // IMPRIME EL CODIGO HTML
        //-------------------------------------------
        $this->vlc_codigo_html = $vlf_codigo_html_principal;
        return $this->vlc_codigo_html;
    }
    function MTD_RETORNAR_CODIGO_HTML ()
    {
        return utf8_decode($this->vlc_codigo_html);
    }
}
?>