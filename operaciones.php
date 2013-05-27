<?php
session_start();
// --------------------------------------------------------------------------------------------------------
//-------------------------
//- DECLARA LAS VARIABLES -
//-------------------------
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
//include_once ('includes/FN_LEER_TPL.php');
include_once ('includes/FN_REEMPLAZAR.php');
include_once ('includes/FN_RECIBIR_VARIABLES.php');
include_once 'includes/FN_COLORES.php';
include_once 'includes/FN_OBTENER_DATOS_ARREGLO.php';
include_once 'includes/FN_GENERADOR_JSON.php';
include_once ('includes/FN_NET_LOGGER.php');
include_once ('includes/FN_RECIBIR_VARIABLES.php');
include_once ('includes/FN_LEER_TPL.php');
include_once ('class/LOGGER.php');
//include_once ('class/CLASS_SESSION.php');


//-----------------------------
//- CONEXION CON EL SISTEMA
//-----------------------------
//$vlf_mssql_conexion= FN_DB_MSSQL_CONEXION();
LOGGER::LOG("--- OPERACIONES --");
$vlf_mysql_conexion= FN_DB_MYSQL_CONEXION();
/*
=====================================
CONEXION CON BASE DE DATOS
=====================================
*/


//-----------------------------------------
// INICIALIZACION DE VARIABLES
//-----------------------------------------
$vl_cod_html = "";

$vl_operacion ="";
//-----------------------------------------
// ASIGNACION DE LA SECCION: MODULO DE LA SECCION
//-----------------------------------------

if (isset($_POST['operacion']))
{
	$vl_operacion = FN_RECIBIR_VARIABLES('operacion');

	if ($vl_operacion == "agregar_usuario")
	{
		LOGGER::LOG("--- OPERACIONES: Agregar Usuario  --");
		include ('class/CLASS_ABM_USUARIOS.php');
		$obj_usuarios = new CLASS_ABM_USUARIOS($vlf_mysql_conexion );
		$vl_cod_html_base = $obj_usuarios->MTD_AGREGAR_USUARIO();
		MTD_RETORNAR_HTML($vl_cod_html_base);
		//$vl_cod_html_seccion= $obj_web_busqueda->MTD_REALIZAR_BUSQUEDA();		
	}
	else if($vl_operacion == "validar_usuario")
	{
		LOGGER::LOG("--- OPERACIONES: Validar usuario  --");
		$resultado = false;
		if (MTD_CHECK_LOGIN())
		{
			LOGGER::LOG("--- OPERACIONES: usuario valido--");
			MTD_RETORNAR_HTML("0");
		}
		else
		{
			LOGGER::LOG("--- OPERACIONES: usuario no valido--");
			MTD_RETORNAR_HTML("-1");
		}
			
	}
	else if($vl_operacion == "mostrar_recuperar_password")
	{
		LOGGER::LOG("--- OPERACIONES: Mostrar Recuperar Password --");
		include ('class/CLASS_ABM_USUARIOS.php');
		$obj = new CLASS_ABM_USUARIOS($vlf_mysql_conexion);	
		MTD_RETORNAR_HTML($obj->MTD_MOSTRAR_RECUPERAR_PASSWORD());			
	}
	else if($vl_operacion == "recuperar_password")
	{
		LOGGER::LOG("--- OPERACIONES: RSCAecuperar Password --");
		include ('class/CLASS_ABM_USUARIOS.php');
		$obj = new CLASS_ABM_USUARIOS($vlf_mysql_conexion);
		MTD_RETORNAR_HTML($obj->MTD_RECUPERAR_PASSWORD());
	}	
	else  
	{
		//$obj_session = new CLASS_SESSION($vlf_mysql_conexion);
		//if ($obj_session->check_session())

		
			switch ($vl_operacion)
			{
				//**************************************************
				//* SECCION : AGREGAR USUARIO
				//**************************************************
				case "agregar_categoria":


					LOGGER::LOG("--- OPERACIONES: Agregar Categoria  --");
					include ('class/CLASS_ABM_CATEGORIAS.php');
					$obj = new CLASS_ABM_CATEGORIAS($vlf_mysql_conexion );
					MTD_RETORNAR_HTML($obj->MTD_AGREGAR_CATEGORIA()); 																
				break;
				

				case "listar_categorias":
					LOGGER::LOG("--- OPERACIONES: Listar Categoria  --");
					include ('class/CLASS_ABM_CATEGORIAS.php');
					$obj = new CLASS_ABM_CATEGORIAS($vlf_mysql_conexion );					
					$vl_cod_html_base = $obj->MTD_LISTAR_CATEGORIAS();
					MTD_RETORNAR_HTML($vl_cod_html_base); 
				//$vl_cod_html_seccion= $obj_web_busqueda->MTD_REALIZAR_BUSQUEDA();
				break;

				case "eliminar_categoria":
					LOGGER::LOG("--- OPERACIONES: Eliminar Categoria  --");
					include ('class/CLASS_ABM_CATEGORIAS.php');
					$obj = new CLASS_ABM_CATEGORIAS($vlf_mysql_conexion );					
					MTD_RETORNAR_HTML($obj->MTD_ELIMINAR_CATEGORIA()); 
				//$vl_cod_html_seccion= $obj_web_busqueda->MTD_REALIZAR_BUSQUEDA();
				break;


				case "agregar_subcategoria":


					LOGGER::LOG("--- OPERACIONES: Agregar Categoria  --");
					include ('class/CLASS_ABM_SUBCATEGORIAS.php');
					$obj = new CLASS_ABM_SUBCATEGORIAS($vlf_mysql_conexion );
					MTD_RETORNAR_HTML($obj->MTD_AGREGAR_SUBCATEGORIA()); 																
				break;
				

				case "listar_subcategorias":
					LOGGER::LOG("--- OPERACIONES: Listar Categoria  --");
					include ('class/CLASS_ABM_SUBCATEGORIAS.php');
					$obj = new CLASS_ABM_SUBCATEGORIAS($vlf_mysql_conexion );					
					$vl_cod_html_base = $obj->MTD_LISTAR_SUBCATEGORIAS();
					MTD_RETORNAR_HTML($vl_cod_html_base); 
				//$vl_cod_html_seccion= $obj_web_busqueda->MTD_REALIZAR_BUSQUEDA();
				break;

				case "eliminar_subcategoria":
					LOGGER::LOG("--- OPERACIONES: Eliminar Categoria  --");
					include ('class/CLASS_ABM_SUBCATEGORIAS.php');
					$obj = new CLASS_ABM_SUBCATEGORIAS($vlf_mysql_conexion );					
					MTD_RETORNAR_HTML($obj->MTD_ELIMINAR_SUBCATEGORIA()); 
				//$vl_cod_html_seccion= $obj_web_busqueda->MTD_REALIZAR_BUSQUEDA();
				break;
				case "mostrar_abm_documentos": 				
					LOGGER::LOG("--- OPERACIONES: Mostrar ABM Documentos--");
					include ('class/CLASS_DOCUMENTOS.php');
					$obj = new CLASS_DOCUMENTOS($vlf_mysql_conexion );
					$_SESSION["investigacion_file"]="";
					$_SESSION["investigacion_status"]="";
					$vl_cod_html_base = utf8_encode( $obj->MTD_FORMULARIO_DOCUMENTOS());
					MTD_RETORNAR_HTML($vl_cod_html_base);
				break;
				case "ingresar_investigacion": 				
					LOGGER::LOG("--- OPERACIONES: ingresar_investigacion--");
					include ('class/CLASS_INVESTIGACIONES.php');
					$obj = new CLASS_INVESTIGACIONES($vlf_mysql_conexion );
					$vl_cod_html_base = utf8_encode( $obj->MTD_AGREGAR_INVESTIGACION());
					MTD_RETORNAR_HTML($vl_cod_html_base);
				break;
				case "mostrar_cambiar_contrasenha":
					LOGGER::LOG("--- OPERACIONES: Mostrar Cambiar Password --");
					include ('class/CLASS_ABM_USUARIOS.php');
					$obj = new CLASS_ABM_USUARIOS($vlf_mysql_conexion);
					MTD_RETORNAR_HTML($obj->MTD_MOSTRAR_CAMBIAR_PASSWORD());					
					break;
				case "mostrar_editar_datos_personales":
					LOGGER::LOG("--- OPERACIONES: mostrar_editar_datos_personales--");
					include ('class/CLASS_ABM_USUARIOS.php');
					$obj = new CLASS_ABM_USUARIOS($vlf_mysql_conexion);
					echo utf8_encode($obj->MTD_MOSTRAR_EDITAR_DATOS_PERSONALES());
					break;
				case "mostrar_editar_pacientes":
					LOGGER::LOG("--- OPERACIONES: mostrar_editar_pacientes--");
					include ('class/CLASS_ABM_PACIENTES.php');
					$obj = new CLASS_ABM_PACIENTES($vlf_mysql_conexion);
					echo  $obj->MTD_MOSTRAR_EDITAR_PACIENTE();
					break;
				case "mostrar_perfil_pacientes":
					LOGGER::LOG("--- OPERACIONES: mostrar_perfil_pacientes--");
					include ('class/CLASS_ABM_PACIENTES.php');
					$obj = new CLASS_ABM_PACIENTES($vlf_mysql_conexion);
					echo $obj->MTD_MOSTRAR_PERFIL_PACIENTE();
					break;			
				case "actualizar_datos_personales":
					LOGGER::LOG("--- OPERACIONES: actualizar_datos_personales --");
					include ('class/CLASS_ABM_USUARIOS.php');
					$obj = new CLASS_ABM_USUARIOS($vlf_mysql_conexion);
					echo utf8_encode($obj->MTD_ACTUALIZAR_DATOS_PERSONALES());
					break;
					
				case "cambiar_password":
					LOGGER::LOG("--- OPERACIONES: Cambiar Password --");
					include ('class/CLASS_ABM_USUARIOS.php');
					$obj = new CLASS_ABM_USUARIOS($vlf_mysql_conexion);
					MTD_RETORNAR_HTML($obj->MTD_CAMBIAR_PASSWORD());
					break;
				case "mostrar_historial":
					LOGGER::LOG("--- OPERACIONES: Mostrar Historial--");
					include ('class/CLASS_ABM_HISTORIAL.php');
					$obj = new CLASS_ABM_HISTORIAL($vlf_mysql_conexion );
					$vl_cod_html_base = utf8_encode( $obj->MTD_CONSULTAR_HISTORICO());
					MTD_RETORNAR_HTML($vl_cod_html_base);
				break;
						
							
			}
		//
	}
	
}
function MTD_CHECK_LOGIN()
{
	include_once 'includes/FN_DB_CONEXION.php';
	include_once 'includes/FN_DB_QUERY.php';
$vpp_db_conexion= FN_DB_MYSQL_CONEXION();
	
	//echo "<br>VARIABLE DE CONEXION OTORGADA:$vpp_db_string_conexion";
	$obj_session2 = new CLASS_SESSION( $vpp_db_conexion );
	
	$login=false;
	FN_LOG("Check Login "  );
	if (isset ( $_POST["usuario"] ) && isset ( $_POST["password"] ))
	{
		FN_LOG("Check Login > set variables");
		//---------LIMPIAR VARIABLES----
		$userN = FN_RECIBIR_VARIABLES( 'usuario' );
		$passN = FN_RECIBIR_VARIABLES( 'password');
		$username = $userN;
		$password = $passN;
		FN_LOG("Check Login > user $userN ");
		
		if ($username && $password)
		{		
			FN_LOG("Check Login > all variables set ");
			$failed = true;
			if ($obj_session2->check_login ( $username, $password ))
			{			
				FN_LOG("Check Login > login success for user $username");
				//header ( "Location: index.php?id=registro" );
				//echo "LOGIN-> ESTA LOGUEADO <br>";
				$login= true;				
			}
			else
			{	
				//header ( "Location: index.php?id=registro" );
				//echo "NO LOGIN";
				FN_LOG("Check Login > login fail ");
				$error = "PASSWORD";
				$login= false;
			}
			
		}
	}
	else
	{
		FN_LOG("Check Login > login fail ");
		$login=false;
	}
	return $login;
}
function MTD_RETORNAR_HTML($vp_html)
{
	//echo  FN_COMPRIMIR_HTML($vp_html);
	if ($vp_html == "")
	{
		echo "--";
	}
	else
	{
		$vp_html = FN_REEMPLAZAR("archivos_de_disenho", "composite.templates/consultorio/archivos_de_disenho", $vp_html );
		echo utf8_decode($vp_html);
	}
}
function MTD_RETORNAR_HTML2($vp_html)
{
	//echo  FN_COMPRIMIR_HTML($vp_html);
	if ($vp_html == "")
	{
		echo "--";
	}
	else
	{
		$vp_html = FN_REEMPLAZAR("archivos_de_disenho", "composite.templates/consultorio/archivos_de_disenho", $vp_html );
		echo $vp_html;
	}
}


?>