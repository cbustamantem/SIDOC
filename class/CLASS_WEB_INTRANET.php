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
		include_once('CLASS_SESSION.php');
		
		$vlf_session_activada= true;
		$obj_session = new CLASS_SESSION($vlf_conexion);
		
        //-----------------------------------------
        // INICIALIZACION DE VARIABLES
        //-----------------------------------------
        $vl_cod_html_base = "";
        $vl_cod_html_seccion = "";
        
        //-----------------------------------------
        // CREACION DE MENU
        //-----------------------------------------
        include_once ('CLASS_WEB_MENU_PRINCIPAL.php');
        $vl_cod_html_menu ="";
     //   $obj_menu = new CLASS_WEB_MENU_PRINCIPAL();
       // $obj_menu->MTD_INICIALIZA_MENU();
      //  $vl_cod_html_menu =$obj_menu->MTD_RETORNAR_CODIGO_HTML();  
        //-----------------------------------------
        // LECTURA DEL TPL BASE
        //-----------------------------------------
        $vl_cod_html_base = FN_LEER_TPL('tpl/tpl-intranet.html');
        $sql_membrete="SELECT encabezado_membrete from usuarios where id_usuario=".$_SESSION[uid];
        $datos_membrete = FN_RUN_QUERY($sql_membrete, 1,$this->vlc_db_conexion);
        $membrete =$datos_membrete[0][0];
        $membrete = FN_REEMPLAZAR("\n","<br>",$membrete );
        
        $vl_cod_html_base = FN_REEMPLAZAR('{tpl-membrete}', $membrete ,$vl_cod_html_base);
    	$vlf_codigo_html_principal= $vl_cod_html_base;
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
	    }	    	   
	    else
	    {
	    	LOGGER::LOG("Web: menu principal ");	    	
	    }
	    
	    //---------------------------
	    //- REEMPLAZA LAS ETIQUETAS -
	    //---------------------------
	    $vlf_codigo_html_principal = FN_REEMPLAZAR('{tpl-menu-principal}', $vl_cod_html_menu , $vlf_codigo_html_principal);
	    
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