<?php
$session_name = session_name();
if (!isset($_POST[$session_name])) {
	exit;
} else {
	session_id($_POST[$session_name]);
	session_start();
}
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/
include_once ("includes/FN_NET_LOGGER.php");
// Define a destination
// Relative to the root
$_SESSION['investigacion_status']="enviando";
$verifyToken = md5('unique_salt' . $_POST['timestamp']);
FN_NET_LOGGER("Upload Archivo:".$_FILES['Filedata']['tmp_name']);
$targetFolder = '/var/www/consultorio/investigaciones/';  // Relative to the root
$archivo= $_SESSION['uid']."_".time().".pdf";
$_SESSION['investigacion_file']=$archivo;

FN_NET_LOGGER("Upload Archivo: Fie: ".$archivo);
if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $targetFolder;
	//$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
	$targetFile =  str_replace('//','/',$targetPath) . $archivo;
	
	$fileTypes = array('pdf'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	if (in_array($fileParts['extension'],$fileTypes)) 
	{
		if (move_uploaded_file($tempFile,$targetFile))
		{ 
			$_SESSION['investigacion_status'] ="OK";
			FN_NET_LOGGER("Upload Archivo: OK ".$_SESSION['investigacion_file']);
		}
		else
		{
			$_SESSION['investigacion_status'] ="FAIL";
			FN_NET_LOGGER("Upload Archivo: FAIL");
		}		
	} 
	else 
	{
		$_SESSION["investigacion_status"] ="INVALIDO";
		FN_NET_LOGGER("Upload Archivo: INVALIDO");
		echo 'Archivo invalido.';
	}
	
	
	

}

?>
