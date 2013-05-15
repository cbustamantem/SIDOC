<?
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
	include_once('login.php');
	
	//-----------------------------
	//- CONEXION CON EL SISTEMA
	//-----------------------------
	//$vlf_mssql_conexion= FN_DB_MSSQL_CONEXION();
	$vlf_mysql_conexion= FN_DB_MYSQL_CONEXION();
	//$resultest = FN_RUN_QUERY("select * from clientes",6,$vlf_mysql_conexion);
	
	//
	//-----------------------------
	//- LECTURA DEL TPL PRINCIPAL
	//-----------------------------
	$vlf_codigo_html_principal = FN_LEER_TPL('tpl/tpl-index-frame.html');
	$vlf_codigo_html_contenido = FN_LEER_TPL('tpl/tpl-index-contenido.html');
	$vlf_codigo_html_menu 	   = FN_LEER_TPL('tpl/tpl-index-menu.html');
	

	$obj_session = new CLASS_SESSION($vlf_mysql_conexion);
	// -> se va a la seccion admin
	$vlf_session_activada = $obj_session->MTD_START();
	if ($vlf_session_activada == true)
	{
		$obj_intranet = new CLASS_WEB_INTRANET ($vlf_mysql_conexion);
		$vlf_codigo_html_principal = $obj_intranet->MTD_RETORNAR_CODIGO_HTML ();
	}
	else
	{
		//$vlf_codigo_html_principal  = FN_LOGIN();
	}
	
	//------------------------------
	// APLICAR CONTENIDO
	//-------------------------------
	$vlf_codigo_html_principal = FN_REEMPLAZAR("{tpl-contenido}",$vlf_codigo_html_contenido,$vlf_codigo_html_principal);	
	$vlf_codigo_html_principal = FN_REEMPLAZAR("{tpl-menu-principal}",$vlf_codigo_html_menu,$vlf_codigo_html_principal);	
	
	return $vlf_codigo_html_principal;
	
}
?>