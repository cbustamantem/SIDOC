<?
session_start();
/*

              Datos de la Etiqueta
=#= ini-instrucciones-cmp =#=
Función:			Sistema de Gestion de Documentos
Instrucciones:		No es necesario pasar parametros
Desarrollado por:	Carlos Bustamante
e-mail:				cbustamantem@gmail.com
Creado:				13/05/2013
Modificado:			13/05/2013
=#= fin-instrucciones-cmp =#=
*/

function formulario_sistema_medico()
{
	
	// --------------------------------------------------------------------------------------------------------
	//-------------------------
	//- DECLARA LAS VARIABLES -
	//-------------------------
	
	global $bd, $composite_cod_sitio, $cmp, $orden_idioma;
	$vlf_codigo_html_principal = "";
	$vlf_codigo_html_seccion = "";
	$vlf_codigo_html_menu = "";
	$vlf_tpl = "tpl/tpl_frm_principal.html";
	//print_r($cmp);
	
	//-------------------------------------
	//- INCLUYE LAS FUNCIONES PRINCIPALES -
	//-------------------------------------
	include_once ('includes/FN_CONFIGURACION.php');
	include_once ('includes/FN_DB_CONEXION.php');
	include_once ('includes/FN_DB_QUERY.php');
	include_once ('includes/FN_HTML_ARMAR_GRILLA.php');
	include_once ('includes/FN_HTML_ARMAR_LISTA.php');
	include_once ('includes/FN_HTML_EDITORCONTENIDO.php');
	include_once ('includes/FN_LEER_TPL.php');
	include_once ('includes/FN_REEMPLAZAR.php');
	include_once ('includes/FN_RECIBIR_VARIABLES.php');
	include_once 'includes/FN_COLORES.php';
	include_once 'includes/FN_OBTENER_DATOS_ARREGLO.php';
	include_once 'includes/FN_GENERADOR_JSON.php';
	include_once ('includes/FN_NET_LOGGER.php');
	include_once ('includes/FN_RECIBIR_VARIABLES.php');
	include_once ('includes/FN_SUBIR_ARCHIVO.php');
	include_once ('class/LOGGER.php');
	include_once ('class/CLASS_SESSION.php');
	include_once ('class/CLASS_WEB_INTRANET.php');
	include_once ('class/CLASS_WEB_MENU_PRINCIPAL.php');
	include_once ('class/CLASS_WEB_RUTA.php');
	include_once ('class/CLASS_LISTADO_DOCUMENTOS.php');
	include_once('login.php');
	
	//-----------------------------
	//- CONEXION CON EL SISTEMA
	//-----------------------------
	//$vlf_mssql_conexion= FN_DB_MSSQL_CONEXION();
	$vlf_mysql_conexion= FN_DB_MYSQL_CONEXION();
	//$resultest = FN_RUN_QUERY("select * from clientes",6,$vlf_mysql_conexion);
	FN_NET_LOGGER("INCICIO SISTEMA");
	//
	//-----------------------------
	//- LECTURA DEL TPL PRINCIPAL
	//-----------------------------
	$vlf_codigo_html_principal = FN_LEER_TPL('tpl/tpl-index-frame.html');
	$vlf_codigo_html_contenido = FN_LEER_TPL('tpl/tpl-index-contenido.html');
	$vl_cod_html_login 	   = "";
	

	$obj_session = new CLASS_SESSION($vlf_mysql_conexion);
	// -> se va a la seccion admin
	$vlf_session_activada = $obj_session->MTD_START();
	if ($vlf_session_activada == true)
	{ 

		$vl_cod_html_login 	   =FN_LEER_TPL('tpl/tpl-index-loggedin.html');
		$username=$_SESSION['username'];
		$vl_cod_html_login = FN_REEMPLAZAR("{username}",$username,$vl_cod_html_login );

		if ($_SESSION['rol_usuario'] == "administrador")
		{

			$vlf_codigo_html_principal= FN_REEMPLAZAR("{tpl-link-administracion}",' <li><a id="btn_involucrate" href="index.php?seccion=administracion&administracion=1" title="ADMINISTRACION">ADMINISTRACION</a></li>',$vlf_codigo_html_principal);
		}
		else
		{
			$vlf_codigo_html_principal= FN_REEMPLAZAR("{tpl-link-administracion}",' ',$vlf_codigo_html_principal);
		}			
	}
	else
	{
		$vl_cod_html_login 	   =FN_LEER_TPL('tpl/tpl-index-login.html');
		$vlf_codigo_html_principal= FN_REEMPLAZAR("{tpl-link-administracion}",'',$vlf_codigo_html_principal);
	}
	//---------------------------
	// MENU PRINCIPAL 
	//---------------------------	
    $obj_menu = new CLASS_WEB_MENU_PRINCIPAL($vlf_mysql_conexion);        

    //---------------------------
	// RUTA
	//---------------------------
	$vl_cod_html_ruta ="";
    $obj_ruta = new CLASS_WEB_RUTA($vlf_mysql_conexion);    
    $vl_cod_html_ruta =$obj_ruta->MTD_RETORNAR_CODIGO_HTML();  

    //LOGICA SITIO
    $body="n/n";
    $body = FN_LEER_TPL('tpl/tpl-lista-docu.html');
    if (isset($_GET['documento']))
    {
    	//TODO: mostrar el documento
    	$obj_listado = new CLASS_LISTADO_DOCUMENTOS($vlf_mysql_conexion);
    	$body = $obj_listado->MTD_RETORNAR_CODIGO_HTML();
    }
    else if(isset($_GET['busqueda']))
   	{
   			//TODO: mostrar el documento
    	$obj_listado = new CLASS_LISTADO_DOCUMENTOS($vlf_mysql_conexion);
    	$body = $obj_listado->MTD_RETORNAR_CODIGO_HTML();
   		//TODO: mostrar resultados de busqueda
   	}
   	else if( (isset($_GET['categoria'])) &&   (! isset($_GET['subcategoria'])) )
   	{
   			//TODO: mostrar el documento
    	$obj_listado = new CLASS_LISTADO_DOCUMENTOS($vlf_mysql_conexion);
    	$body = $obj_listado->MTD_RETORNAR_CODIGO_HTML();
   		//TODO: mostrar categorias
   	}
   	else if( (isset($_GET['categoria'])) &&   (isset($_GET['subcategoria'])) )
   	{
   			//TODO: mostrar el documento
    	$obj_listado = new CLASS_LISTADO_DOCUMENTOS($vlf_mysql_conexion);
    	$body = $obj_listado->MTD_RETORNAR_CODIGO_HTML();
   		//TODO: mostrar subcategorias
   	}
   	else if(isset($_GET['administracion']))
   	{
   		if ($_SESSION['rol_usuario'] == "administrador")
		{

	   		LOGGER::LOG("Seccion administracion ");
	   		//TODO: mostrar subcategorias	   		
			if ($vlf_session_activada == true)
			{
				$obj_intranet = new CLASS_WEB_INTRANET ($vlf_mysql_conexion);
				$body= $obj_intranet->MTD_RETORNAR_CODIGO_HTML ();
			}
		}
		else
		{
			 header ( "Location: index.php" );
			//$vlf_codigo_html_principal  = FN_LOGIN();
		}
	}

   	else if(isset($_GET['salir']))
   	{
   		LOGGER::LOG("Seccion SALIR ");
   		$obj_session->logout();
		 header ( "Location: index.php" );
   	}
   	else
   	{
   		//TODO: mostrar index
   		$obj_listado = new CLASS_LISTADO_DOCUMENTOS($vlf_mysql_conexion);
    	$body = $obj_listado->MTD_RETORNAR_CODIGO_HTML();
   		//$vlf_session_activada = $obj_session->MTD_START();
   		

   	}

   
	//------------------------------
	// APLICAR CONTENIDO
	//-------------------------------
	$vlf_codigo_html_principal = FN_REEMPLAZAR("{tpl-contenido}",$vlf_codigo_html_contenido,$vlf_codigo_html_principal);	
	$vlf_codigo_html_principal = FN_REEMPLAZAR("{tpl-menu-principal}",$obj_menu->MTD_RETORNAR_CODIGO_HTML(),$vlf_codigo_html_principal);	
	$vlf_codigo_html_principal = FN_REEMPLAZAR("{tpl-ruta}",$vl_cod_html_ruta,$vlf_codigo_html_principal);	
	$vlf_codigo_html_principal = FN_REEMPLAZAR("{tpl-login}",$vl_cod_html_login,$vlf_codigo_html_principal);	
	$vlf_codigo_html_principal = FN_REEMPLAZAR("{tpl-body}",$body,$vlf_codigo_html_principal);

	
	return $vlf_codigo_html_principal;
	
}
?>