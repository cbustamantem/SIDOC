<?php
class CLASS_INVESTIGACIONES
{
    private $vlc_codigo_html;
	private $vlc_busqueda="";
    private $vlc_db_cn;
    function __construct ($vp_cn)
    {
    	$this->vlc_db_cn = $vp_cn;
       
        //$this->MTD_INICIALIZAR_PAGINA();
        if (isset($_POST['MAX_FILE_SIZE']))
        {
        	LOGGER::LOG("Agregar nueva investigacion");
        	$this->MTD_AGREGAR_INVESTIGACION();
        }
        else
       {
       	LOGGER::LOG("no agregar nada");
        }
        
    }
  
    function MTD_INICIALIZAR_PAGINA ()
    {
        /*
         * TODO: 
         * VALORES DEL FORMULARIO
         * ----------------------
         * [tb_nombre_programa]
         * [id_programa]
         * 
         * ACCIONES DEL FORMULARIO
         * -----------------------
         * frm_insertar
         * frm_actualizar
         * 
         * ETIQUETAS DEL tpl
         * ------------------------
         * {accion-formulario}
         * {titulo-accion-formulario}
         * {grilla-datos-categoria}
         * {tb-nombre-categoria}         
         */
       $historial="";
	   $investigacion="";
	   $investigacion= FN_RECIBIR_VARIABLES("investigacion");
       $this->vlc_codigo_html = FN_LEER_TPL('tpl/tpl-investigaciones.html');
       $busqueda= FN_RECIBIR_VARIABLES("busqueda");
       $datos="";
       if ($busqueda)
       {
       		$datos= utf8_encode($this->MTD_BUSCAR_INVESTIGACIONES());
       }
       elseif($investigacion)
       {
       		$this->vlc_codigo_html = FN_LEER_TPL('tpl/tpl-investigacion-detalle.html');
       		$datos = $this->MTD_BUSCAR_PROSPECTO($investigacion);       		
       }
       else
      {
      		$datos = $this->MTD_BUSCAR_ULTIMAS_INVESTIGACIONES();
       }
       $this->vlc_codigo_html = FN_REEMPLAZAR("{tpl-busqueda}", $busqueda, $this->vlc_codigo_html );
       $this->vlc_codigo_html = FN_REEMPLAZAR("{tpl-datos}",$datos,$this->vlc_codigo_html);
    }
        
    function MTD_RETORNAR_CODIGO_HTML ()
    {
        return $this->vlc_codigo_html;
    }
    function MTD_RECIBIR_VARIABLES()
    {
    	
    }
    function MTD_BUSCAR_INVESTIGACIONES()
    {
    	LOGGER::LOG("BUSCAR_INVESTIGACIONES");
    	$tipo = FN_RECIBIR_VARIABLES("tipo_busqueda");
    	$busqueda= FN_RECIBIR_VARIABLES("busqueda");
    	LOGGER::LOG("BUSCAR_INVESTIGACIONES > TIPO:".$tipo);
    	LOGGER::LOG("BUSCAR_INVESTIGACIONES > Busqueda:".$busqueda);
    	$arreglo = array();
    	$sql="SELECT idinvestigaciones,nombre,descripcion,archivo,autores FROM investigaciones WHERE
    	 nombre like '%$busqueda%' or descripcion like '%$busqueda%';";
    	$arreglo = FN_RUN_QUERY($sql,4, $this->vlc_db_cn);    	
    	//$arreglo_datos= FN_RUN_QUERY($sql, 3, $this->vlc_db_cn);
    	$contador =0;
    	$html="";
   		if ($arreglo)
    	{
    		$html='<table  cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%" >
    		<thead>
    		<tr>
    		<th>Titulo</th>
    		<th>Descripcion</th>    		
    		</tr>
    		</thead>
    		<tbody>';
    		foreach ($arreglo as $datos)
    		{
    			$html.="<TR><TD>".substr($datos[1],0,70)."</TD><TD><a href='index.php?id=registro&seccion=investigaciones&investigacion=".$datos[0]."'>".substr($datos[2],0,50)."</a></TD></TR>";
    		}
    		$html.="</tbody></table>";
    		 
    	}
    	else
    	{
    		$html='<table  cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%" >
    		<thead>
    		<tr>
    		<th>Titulo</th>
    		<th>Descripcion</th>
    		</tr>
    		</thead>
    		<tbody>
    		<TR><TD >No se encontraron registros</TD><TD></TD></TR>';
    		
    		$html.="</tbody></table>";
    		 
    	}
    	LOGGER::LOG("BUSCAR_INVESTIGACIONES :\n".$html);
    	return utf8_decode($html);
    }
    function MTD_BUSCAR_ULTIMAS_INVESTIGACIONES()
    {
    	LOGGER::LOG("BUSCAR_INVESTIGACIONES");
    	$busqueda= FN_RECIBIR_VARIABLES("busqueda");    	
    	LOGGER::LOG("BUSCAR_INVESTIGACIONES > Busqueda:".$busqueda);
    	$arreglo = array();
    	$sql="SELECT idinvestigaciones,nombre,descripcion,archivo,autores FROM investigaciones limit 50";
    	$arreglo = FN_RUN_QUERY($sql,5, $this->vlc_db_cn);
    	//$arreglo_datos= FN_RUN_QUERY($sql, 3, $this->vlc_db_cn);
    	$contador =0;
    	$html="";
    	if ($arreglo)
    	{
    		$html='<table  cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%" >
    		<thead>
    		<tr>
    		<th>Titulo</th>
    		<th>Descripcion</th>
    		
    		</tr>
    		</thead>
    		<tbody>';
    		foreach ($arreglo as $datos)
    		{
    			$html.="<TR><TD>".substr($datos[1],0,70)."</TD><TD><a href='index.php?id=registro&seccion=investigaciones&investigacion=".$datos[0]."'>".substr($datos[2],0,50)."</a></TD></TR>";
    		}
    		$html.="</tbody></table>";    		 
    	}
    	LOGGER::LOG("BUSCAR_INVESTIGACIONES :\n".$html);
    	return $html;
    }
    function MTD_AGREGAR_INVESTIGACION()
    {
    	LOGGER::LOG("MTD_AGREGAR_INVESTIGACION :\n");
    	LOGGER::LOG("MTD_AGREGAR_INVESTIGACION : uid ".$_SESSION["uid"]);
    	LOGGER::LOG("MTD_AGREGAR_INVESTIGACION : file ".$_SESSION["investigacion_file"]);
    	LOGGER::LOG("MTD_AGREGAR_INVESTIGACION : status ".$_SESSION["investigacion_status"]);
    	$titulo="";
    	$descripcion="";
    	$archivo="";
    	$autores="";
    	$titulo=FN_RECIBIR_VARIABLES("titulo");
    	$descripcion=FN_RECIBIR_VARIABLES("descripcion");
    	$autores 	=FN_RECIBIR_VARIABLES("autores");
    	if ($_SESSION["investigacion_status"] == "OK")
    	{
    		$archivo="investigaciones/".$_SESSION['investigacion_file'];
    		LOGGER::LOG("MTD_AGREGAR_INVESTIGACION> uploaded {OK} ");
    		LOGGER::LOG("MTD_AGREGAR_INVESTIGACION> Titulo: $titulo" );
    		LOGGER::LOG("MTD_AGREGAR_INVESTIGACION> Descripcion: $descripcion" );
    		LOGGER::LOG("MTD_AGREGAR_INVESTIGACION> Archivo: $archivo" );
    		LOGGER::LOG("MTD_AGREGAR_INVESTIGACION> Autores: $autores" );
    		$sql="INSERT INTO investigaciones (nombre,descripcion,archivo,id_doctor,autores) VALUES"
    		." ('$titulo','$descripcion','$archivo',".$_SESSION['uid'].",'".$autores."')";
    		$resultado=FN_RUN_NONQUERY($sql,$this->vlc_db_cn);
    		LOGGER::LOG("MTD_AGREGAR_INVESTIGACION>".$sql);
    		LOGGER::LOG("MTD_AGREGAR_INVESTIGACION> Investigacion creada exitosamente");
    		return "1";
    	}
    	else if ($_SESSION["investigacion_status"] == "INVALIDO")
    	{
    		LOGGER::LOG("MTD_AGREGAR_INVESTIGACION> uploaded {INVALIDO} ");
    		return "Atencion,<br> El archivo publicado no es valido, <br> favor seleccione un documento PDF";
    	}
    	else if ($_SESSION["investigacion_status"] == "enviando")
    	{
    		LOGGER::LOG("MTD_AGREGAR_INVESTIGACION> uploaded {enviando} ");
    		return "Atencion,<br> Aun se encuentra enviando el documento,<br> favor aguarde a que finalice el proceso";
    	}
    	else
    	{
    		LOGGER::LOG("MTD_AGREGAR_INVESTIGACION>  debe seleccionar un archivo");
    		return "Atencion,<br> Debera seleccionar un archivo <br>para ingresar la investigacion";
    	}
    	/*$archivo = "investigaciones/_".$_SESSION['uid']."_".$_FILES["uploadedfile"]["name"];
    	if ($_FILES["uploadedfile"]["type"] == "application/pdf")
    	{
	    	if (FN_SUBIR_ARCHIVO("/var/www/consultorio/investigaciones/", "uploadedfile", $_SESSION['uid']))
	    	{
	    		
	    	}
	    	else
	    	{
	    		LOGGER::LOG("MTD_AGREGAR_INVESTIGACION> uploaded {FAIL}");
	    	}
    	}
    	else
    	{
    		LOGGER::LOG("MTD_AGREGAR_INVESTIGACION> uploaded {FAIL} archivo invalido". $_FILES["uploadedfile"]["type"]);
    	}
    	*/
    }
    function MTD_BUSCAR_PROSPECTO($investigacion)
    {
    	$sql = "SELECT inv.idinvestigaciones,
    					inv.nombre,
    					inv.descripcion,
    					inv.archivo,
    					d.encabezado_membrete,
    					inv.autores 
    	FROM investigaciones  as inv, usuarios as d where inv.id_doctor= d.id_usuario
    	AND inv.idinvestigaciones = ".$investigacion;
    	$arreglo= array();
    	$arreglo = FN_RUN_QUERY($sql, 6,$this->vlc_db_cn);
    	$datos="";
    	if ($arreglo)
    	{
    		$datos="<h3>".$arreglo[0][1]."</h3>";
    		$datos.="<i>Publicado por:</i> <b><br> ".$arreglo[0][4]."</b>";
    		$datos.="<br><i>Autores:</i> <b><br> ".$arreglo[0][5]."</b>";
    		$datos.="<br>".$arreglo[0][2]."<br>";
    		$datos.="<br><a href='".$arreglo[0][3]."' target='_blank'>ver documento</a><br>";
    		return $datos;
    	
    		
    		//return $arreglo[0][0];    		
    	}
    	else
    	{
    		return "--";
    	}
    }
    function MTD_FORMULARIO_INVESTIGACIONES()
    {
    	LOGGER::LOG("MTD_FORMULARIO_INVESTIGACIONES :\n");
    	$template='tpl/tpl-abm-investigaciones.html';
    	if (file_exists($template)) 
    	{
    	 $fh  = fopen($template, 'r');	
    	 $theData = fread($fh, filesize($template));
    	 fclose($fh);
    	// LOGGER::LOG("MTD_FORMULARIO_INVESTIGACIONES :". $theData);
    	$timestamp= time();
    	 $theData=FN_REEMPLAZAR("{tpl-timestamp}", $timestamp, $theData);
    	 $theData=FN_REEMPLAZAR("{tpl-token}", md5('unique_salt' . $timestamp), $theData);
    	 $theData=FN_REEMPLAZAR("{tpl-session-name}", session_name(), $theData);
    	 $theData=FN_REEMPLAZAR("{tpl-session-id}", session_id(), $theData);
    	 return $theData;
    	}
    	else
    	{
    		return "---";
    	}
    	 
    }
    function MTD_LISTAR_PUBLICIDAD()
    {
    	$sql="SELECT investigacionID";
    	
    }
}
?>
