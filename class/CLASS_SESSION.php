<?php
class CLASS_SESSION 
{
	private $message = '';
	private $query_error = 'ERROR: something went wrong when accessing the database. Please consult your webmaster';
	private $vlc_db_conexion;
	private $vlc_db_string_conexion;
	private $vlc_logged_in;
	
	
	
	function CLASS_SESSION($vp_conexion)
	{ //constructor		
		//$this->vlc_db_string_conexion = $vpp_db_string_conexion;
		$this->vlc_db_conexion = $vp_conexion;				
	}
	function MTD_START()
	{
	
		//echo "CHKSESSION-> ingreso en start<br>";		
		$this->vlc_logged_in=false;
		$resultado=false;		
		if (! isset ( $_SESSION['uid'] ))
		{ //fills session with empty values
			//echo "CHKSESSION-> seteo default <br>";	
			LOGGER::LOG("Sessions -> Default");
			$this->set_session_defaults ();
		}
		
		if (isset ( $_SESSION['logged_in']))
		{ //already logged in
			//echo "CHKSESSION-> chequea sesion<br>";			
		
			//$this->FN_FILE_LOGGER("Session -> logged in");
			LOGGER::LOG("Sessions -> logged_in");
				$this->vlc_logged_in= $this->check_session ();
				//echo "CHKSESSION-> chequeo sesion con resultado: $resultado <br>";
		}
		//$this->vlc_db_conexion = $vpp_db_conexion;
		
		$resultado = $this->vlc_logged_in;
		
		return $resultado;		
	}
	function check_login($username, $password)
	{

		$sql_check_login="SELECT u.username,u.passwd,u.id_usuario,u.rol_usuario, u.nombre_usuario, u.apellido_usuario FROM usuarios as u WHERE u.username= '$username' AND u.passwd = MD5('$password')";
		//echo "FUK SQL: $sql_check_login";
		$arreglo_datos= FN_RUN_QUERY($sql_check_login,6,$this->vlc_db_conexion );
		//print_r($arreglo_datos);
		if ($arreglo_datos[0][0] ==  $username)
		{
			//echo "<BR> ENTRO AL ASIGNAMIENTO DE LAS SESION";
			$this->set_session ( $arreglo_datos, true );
			
			return true;
		}
		else
		{
			$this->failed = true;
			$this->logout ();
			$this->message .= 'incorrect username of password. please try again';
			return false;
		}
	}
	
	function logout()
	{
		$this->set_session_defaults ();
		setcookie (session_id(), "", time() - 3600);
		session_unset();
		session_destroy();				
		session_write_close();
		$_SESSION = array();		
		return false;
	}
	
	function set_session($vp_db_datos, $init = true)
	{
		LOGGER::LOG("Sessions -> set data session ");
		//echo "<BR> INGRESO A SESSION (INICIALIZACION:$init)";
		$uid = $vp_db_datos[0][2];
		//echo "<BR> USER ID=".$uid; 
		//90 days for the cookie
		$vlf_estado_query = false;
		setcookie ( "user", htmlspecialchars ( $vp_db_datos[0][0] ), time () + 2400 );
		session_register ( "user" );
		if ($init)
		{
			//echo "<BR> ASIGNAMIENTO INICIAL DE SESION";
			$session = session_id();
			$ip = $_SERVER['REMOTE_ADDR'];
			$newtoken = $this->token (); // generate a new token
			$sql_update_session = "UPDATE usuarios SET session='{$session}', token='{$newtoken}', ip='{$ip}' WHERE id_usuario=$uid";
			$vlf_estado_query = FN_RUN_NONQUERY ( $sql_update_session,$this->vlc_db_conexion  );
			//echo "<br> DBG > ASIGNO INICIALMENTE SESION:$session IP:$ip TOKEN:$newtoken :";
			//echo "<BR> DBG > CON ESTE SQL:$sql_update_session";
			//$update = mysql_query ( $sql_update_session ) or die ( mysql_error () );
		}
		setcookie ( "uid", htmlspecialchars ($uid  ), time () + 2400 );
		setcookie ( "id_colaborador", htmlspecialchars ($uid  ), time () + 2400 );
		setcookie ( "alias", htmlspecialchars ( $vp_db_datos[0][0] ), time () + 2400 );
		setcookie ( "token", $SESSION['token'], time () + 2400 );
		setcookie ( "logged_in", true, time () + 2400 );
		$logged_string = "$REMOTE_ADDR";
		
		//REALIZA LOG
		//$sql_log = "INSERT INTO log (user,tipo,seccion) VALUES ('$userN','Login','IP:$logged_string')";		
		//$result2 = mysql_query ( $sql_log ) or die ( mysql_error () );
				
		session_register ( "uid" );
		session_register ( "id_usuario" );		
		session_register ( "alias" );
		session_register ( "token" );
		session_register ( "logged_in" );
				
		$_SESSION['id_colaborador'] = htmlspecialchars ($uid);
		$_SESSION['uid'] = htmlspecialchars ($uid);
		$_SESSION['user'] = htmlspecialchars ( $vp_db_datos[0][0] );
		$_SESSION['alias'] = htmlspecialchars ( $vp_db_datos[0][0] );
		$_SESSION['token'] = $newtoken;
		$_SESSION['session']=$session;
		$_SESSION['username']=$vp_db_datos[0][0];
		$_SESSION['rol_usuario']=$vp_db_datos[0][3];			
		$_SESSION['nombre_usuario']=$vp_db_datos[0][4];
		$_SESSION['apellido_usuario']=$vp_db_datos[0][5];
		$_SESSION['ip']=$ip;
		$_SESSION['logged_in'] = true;	
		
	}
	
	function check_remembered($cookie)
	{
		$vlf_sql = "";
		//$vlf_db_datos= new array();
		$serializedArray = $cookie;
		$serializedArray = stripslashes ( $serializedArray );
		list ( $username, $token ) = unserialize ( $serializedArray );
		
		if (empty ( $username ) or empty ( $token ))
		{
			return;
		}
		else
		{
			$username = $username;
			$token = $token;
			$ip = $_SERVER['REMOTE_ADDR'];
			$vlf_sql = "SELECT username,passwd,session,token,ip FROM usuarios WHERE username = '{$username}' AND token ='{$token}' AND ip = '{$ip}'";
			$vlf_db_datos = FN_RUN_QUERY ( $vl_sql, 5 ,$this->vlc_db_conexion );
			
			if ($vlf_db_datos[0][0] == $username)
			{
				$this->set_session ( $vlf_db_datos, false, false );
			}
			else
			{
				$this->set_session ( $vlf_db_datos, true, true );
			}
		}
	}
	
	function token()
	{
		// generate a random token
		for($i = 1; $i < 33; $i ++)
		{
			$seed .= chr ( rand ( 0, 255 ) );
		}
		return md5 ( $seed );
	}
	
	function  check_session()
	{		
		//echo "<BR>USER:".$_SESSION['user']." -  TOKEN:".$_SESSION['token']." - logged in:".$_SESSION['logged_in']." - Alias:".$_SESSION['alias']." - UID:".$_SESSION['uid']." - Nombre Completo:".$_SESSION['vs_nombre_usuario'];
		$uid 		= $_SESSION['uid'];
		$username 	= $_SESSION['user'];
		$token 		= $_SESSION['token'];
		$session 	= session_id ();
		$ip 		= $_SERVER['REMOTE_ADDR'];
		$sql_chk_session = "SELECT username,token,session,ip,id_usuario FROM usuarios WHERE id_usuario= $uid AND token='$token' AND session='$session' AND ip='$ip'";
		//echo "<br>SQL CHECK SESSION: $sql_chk_session";
		$vlf_db_datos = FN_RUN_QUERY ( $sql_chk_session, 3 ,$this->vlc_db_conexion );	
		LOGGER::LOG("Session query: $sql_chk_session");	
		//echo "<BR> CHEQUEO DE SESION>";\
		//echo "SQL CHECK SESSION: $sql_chk_session";
		
		if ($vlf_db_datos <> 0)
		{			
			if (($vlf_db_datos[0][0] == $username) && ($vlf_db_datos[0][1] == $token) && ($vlf_db_datos[0][2] == $session))
			{
				LOGGER::LOG("Sessions -> Session chequed for :$username from $ip" );
				//---RECHECK PASSWD							
				return true;
			}
			else
			{
				LOGGER::LOG("Sessions -> Session rejected for :$username from $ip" );
				$this->logout ();
				return false;
			}
		}
		else
		{
			LOGGER::LOG("Session Logout");
			//echo "LOGOUT";
			$this->logout ();
			return false;
		}
	}
	
	function set_session_defaults()
	{		
		unset ( $_SESSION['logged_in'] );
		unset ( $_SESSION['uid'] );
		unset ( $_SESSION['user'] );
		unset ( $_SESSION['alias'] );
		unset ( $_SESSION['cookie'] );
		unset ( $_SESSION['remember'] );
		unset ( $_SESSION['user'] );
		unset ( $_SESSION['token'] );
		unset ( $_SESSION['vs_nombre_usuario'] );
		unset ( $_SESSION['vs_permisos_asignados'] );
		unset ( $_SESSION['nombre_usuario'] );
		unset ( $_SESSION['apellido_usuario'] );
		unset ( $_SESSION['sesion'] );
		unset (	$_SESSION['vs_menues_habilitados'] );
		
		$_SESSION['logged_in'] = false;
		$_SESSION['uid'] = 0;
		$_SESSION['user'] = '';
		$_SESSION['alias'] = '';
		$_SESSION['cookie'] = 0;
		$_SESSION['remember'] = false;
		$_SESSION['token'] ='';
		$_SESSION['session_id'] ='';
		$_SESSION['username'] ='';
		$_SESSION['nombre_usuario'] ='';
		$_SESSION['apellido_usuario'] ='';
		$_SESSION['especialidad'] ='';
		
	
	}
	
	function fn_clean_id($_var_clean_id)
	{
		$ID_PATTERN = "[0-9]";
		if (is_numeric ( $_var_clean_id ))
		{
			return $_var_clean_id;
		}
		else
		{
			return null;
		}
	}
	function FN_FILE_LOGGER($vp_mensaje)
	{
		global $vg_path_app;
		//VERIFICA LA FECHA DEL DÍA
		$vf_fecha=date("m-d-y");
		//ARMA LA ESTAMPA DE TIEMPO
		//$vf_estampa_tiempo=date('l jS \of F Y h:i:s A');
		$vf_estampa_tiempo=date("D M j G:i:s T Y");
		//INGRESA EL LOG
		$vf_nombre_archivo = "/var/www/consultorio/logs/consultorio_".$vf_fecha.".log";
	
		$vf_file_handler = fopen("$vf_nombre_archivo", 'a');
	
		fwrite($vf_file_handler, $vf_estampa_tiempo.": ".$vp_mensaje."\n");
		fclose($vf_file_handler);
	}

}
?>
