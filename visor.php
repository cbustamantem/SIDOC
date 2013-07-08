<?php
session_start();
/* This section can be removed if you would like to reuse the PHP example outside of this PHP sample application */
require_once("php/lib/config.php");
require_once("php/lib/common.php");
include_once ('includes/FN_CONFIGURACION.php');
include_once ('includes/FN_DB_CONEXION.php');
include_once ('includes/FN_DB_QUERY.php');
include_once ('class/LOGGER.php');
include_once ('class/CLASS_SESSION.php');
include_once ('includes/FN_REEMPLAZAR.php');
include_once ('includes/FN_RECIBIR_VARIABLES.php');
$vlf_mysql_conexion= FN_DB_MYSQL_CONEXION();
$obj_session = new CLASS_SESSION($vlf_mysql_conexion);
$vlf_session_activada = $obj_session->MTD_START();
if ($vlf_session_activada == true)
{ 
	
}
else
{
	echo "<h1> Atencion, deber&aacute; ingresar para visualizar el documento</h1><a href='index.php'>Click aqui para continuar </a>";
	exit;
}
$configManager = new Config();

if($configManager->getConfig('admin.password')==null){
	$url = 'setup.php';
	header("Location: $url");
	exit;
}

if (isset($_GET['cod']))
{
	$id_doc = FN_RECIBIR_VARIABLES("cod");
	$sql= "INSERT INTO  documentos_visitas 
			(id_documento, id_usuario,fechahora) 
			VALUES ($id_doc ,".$_SESSION["uid"]." ,NOW());";
	FN_RUN_NONQUERY($sql,$vlf_mysql_conexion);
}
//registrar visita

?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
        <title>Visor de documentos</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style type="text/css" media="screen">
			html, body	{ height:100%; }
			body { margin:0; padding:0; overflow:auto; }
			#flashContent { display:none; }
        </style>

		<link rel="stylesheet" type="text/css" href="css/flexpaper.css" />
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/flexpaper.js"></script>
		<script type="text/javascript" src="js/flexpaper_handlers.js"></script>
    </head>
    <body>
    <div style="">
		<div id="documentViewer" class="flexpaper_viewer" style="width:auto;margin:0px 0px 0px 0px;height:100%;"></div>

	        <script type="text/javascript">
		        function getDocumentUrl(document){
					return "php/services/view.php?doc={doc}&format={format}&page={page}".replace("{doc}",document);
		        }

		        function getDocQueryServiceUrl(document){
		        	return "php/services/swfsize.php?doc={doc}&page={page}".replace("{doc}",document);
		        }

		        var startDocument = "<?php if(isset($_GET["doc"])){echo $_GET["doc"];}else{?>Paper.pdf<?php } ?>";

	            $('#documentViewer').FlexPaperViewer(
				 { config : {

						 DOC : escape(getDocumentUrl(startDocument)),
						 Scale : 0.6,
						 ZoomTransition : 'easeOut',
						 ZoomTime : 0.5,
						 ZoomInterval : 0.2,
						 FitPageOnLoad : true,
						 FitWidthOnLoad : true,
						 FullScreenAsMaxWindow : false,
						 ProgressiveLoading : false,
						 MinZoomSize : 0.2,
						 MaxZoomSize : 5,
						 SearchMatchAll : false,

						 InitViewMode : 'Portrait',
						 RenderingOrder : '<?php echo ($configManager->getConfig('renderingorder.primary') . ',' . $configManager->getConfig('renderingorder.secondary')) ?>',

						 ViewModeToolsVisible : true,
						 ZoomToolsVisible : true,
						 NavToolsVisible : true,
						 CursorToolsVisible : true,
						 SearchToolsVisible : true,
						 PrintToolsVisible : false,

  						 DocSizeQueryService : 'php/services/swfsize.php?doc=' + startDocument,
						 jsDirectory : 'js/',
						 localeDirectory : 'locale/',

						 JSONDataType : 'jsonp',
						 key : '<?php echo $configManager->getConfig('licensekey') ?>',

  						 localeChain: 'es_ES',
		   				 EnablePrinting : false,
		   				 PrintToolsVisible : false,
		   				 ReadOnly : true,
		   				 PrintEnabled : false
						 }}
			    );
	        </script>
<!--        <div style="width:760px;margin-top:10px;padding-left:10px; padding-top:10px; padding-bottom:10px; font-family:Verdana;font-size:10pt;background-color:#EFEFEF; border:1px solid #999;-webkit-box-shadow: rgba(0, 0, 0, 0.246094) 0px 2px 4px 0px;font-family:'District Thin', helvetica, arial;font-weight:lighter;">You are viewing a document in FlexPaper using Adobe Flash. Consider purchasing a commercial license with support for <a href="http://flexpaper.devaldi.com/download.jsp?ref=FlexPaper">Adaptive UI </a> to maximize your browser coverage and reach devices such as the Apple iPad. <br/><br/>With <a href="http://flexpaper.devaldi.com/download.jsp?ref=FlexPaper">AdaptiveUI enabled</a>, the viewer adjust automatically to the visitors capabilities and supports rendering documents as flash, html4 and html5. The viewer gracefully degrades between all formats.<br/><br/>For more information on browser coverage please <a href="http://flexpaper.devaldi.com/docs_html_flash_html5.jsp?ref=FlexPaper">see our documentation</a>.</div>
        </div>-->
   </body>
</html>
