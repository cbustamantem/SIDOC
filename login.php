<?php
function FN_LOGIN()
{
	include_once 'includes/FN_DB_CONEXION.php';
	include_once 'includes/FN_DB_QUERY.php';
	include_once 'includes/FN_NET_LOGGER.php';
	include_once 'class/LOGGER.php';
	include_once 'class/CLASS_SESSION.php';
	//include 'class/CLASS_PROPIEDADES_USUARIO.php';
	//include 'class/CLASS_PARAMETROS.php';
	include_once 'includes/FN_CLEAN_STRING.php';
	//include 'includes/FN_CONFIG.php';
	//include 'includes/FN_HTML.php';
	
	
	$vpp_db_conexion= FN_DB_MYSQL_CONEXION();
	
	//echo "<br>VARIABLE DE CONEXION OTORGADA:$vpp_db_string_conexion";
	$obj_session2 = new CLASS_SESSION( $vpp_db_conexion );
	
	$vlf_resultado_chequeo=false;
	FN_LOG("Check Login ");
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
				header ( "Location: index.php?id=registro" );
				//echo "LOGIN-> ESTA LOGUEADO <br>";				
			}
			else
			{	
				header ( "Location: index.php?id=registro" );
				//echo "NO LOGIN";
				FN_LOG("Check Login > login fail ");
				$error = "PASSWORD";
			}
			
		}
	}
	elseif(isset ( $_GET["registro"] ))
	{
		//$vl_cod_html_base = FN_LEER_TPL('tpl/tpl-registro.html');
		/*include ('class/CLASS_ABM_USUARIOS.php');
		$obj_usuarios = new CLASS_ABM_USUARIOS($vpp_db_conexion );
		$vl_cod_html_base = $obj_usuarios->MTD_RETORNAR_CODIGO_HTML();
		*/
		$vl_cod_html_base = FN_LEER_TPL('tpl/tpl-registro.html');
		$sql="SELECT idespecializacion, nombre from especializacion";
		$arreglo= FN_RUN_QUERY($sql, 2,$vpp_db_conexion);
		if ($arreglo)
		{
			$opciones="";
			foreach ($arreglo as $dato)
			{
				$opciones.="<option value='".$dato[0]."'>".$dato[1]."</option>";
			}
			$vl_cod_html_base = FN_REEMPLAZAR("{tpl-opciones-especialidad}", $opciones, $vl_cod_html_base);
		}
	}
	else 
	{
		$vl_cod_html_base = FN_LEER_TPL('tpl/tpl-login.html');
		if (isset($_GET['nuevo']))
		{
			$vl_cod_html_base =FN_REEMPLAZAR(" {tpl-nuevo-registro}", "$('#bubble_registrar').ShowBubblePopup();", $vl_cod_html_base );
		}
		else
		{
			$vl_cod_html_base =FN_REEMPLAZAR(" {tpl-nuevo-registro}", "", $vl_cod_html_base );
		}
	}
	return $vl_cod_html_base;
}?>