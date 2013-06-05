<?php
class CLASS_DOCUMENTOS
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
        	LOGGER::LOG("Agregar nuevo documento");
        	$this->MTD_AGREGAR_DOCUMENTO();
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
	   $investigacion= FN_RECIBIR_VARIABLES("documento");
       $this->vlc_codigo_html = FN_LEER_TPL('tpl/tpl-adm-documentos.html');
       $busqueda= FN_RECIBIR_VARIABLES("busqueda");
       $datos="";
       if ($busqueda)
       {
       		$datos= utf8_encode($this->MTD_BUSCAR_DOCUMENTOS());
       }
       elseif($investigacion)
       {
       		$this->vlc_codigo_html = FN_LEER_TPL('tpl/tpl-investigacion-detalle.html');
       		$datos = $this->MTD_BUSCAR_PROSPECTO($investigacion);       		
       }
       else
      {
      		$datos = $this->MTD_BUSCAR_ULTIMAS_DOCUMENTOS();
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
    function MTD_BUSCAR_DOCUMENTOS()
    {
    	LOGGER::LOG("BUSCAR_DOCUMENTOS");
    	$tipo = FN_RECIBIR_VARIABLES("tipo_busqueda");
    	$busqueda= FN_RECIBIR_VARIABLES("busqueda");
    	LOGGER::LOG("BUSCAR_DOCUMENTOS > TIPO:".$tipo);
    	LOGGER::LOG("BUSCAR_DOCUMENTOS > Busqueda:".$busqueda);
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
    			$html.="<TR><TD>".substr($datos[1],0,70)."</TD><TD><a href='index.php?id=registro&seccion=investigaciones&investigacion=".$datos[0]."'>".substr($datos[2],0,50)."</a></TD>
                ";
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
    	LOGGER::LOG("BUSCAR_DOCUMENTOS :\n".$html);
    	return utf8_decode($html);
    }
    function MTD_BUSCAR_ULTIMAS_DOCUMENTOS()
    {
    	LOGGER::LOG("BUSCAR_DOCUMENTOS");
    	$busqueda= FN_RECIBIR_VARIABLES("busqueda");    	
    	LOGGER::LOG("BUSCAR_DOCUMENTOS > Busqueda:".$busqueda);
    	$arreglo = array();
    	$sql="SELECT
iddocumento,
titulo,
descripcion,
documento,
fecha,
idsubcategoria
FROM documentos ";
    	$arreglo = FN_RUN_QUERY($sql,6, $this->vlc_db_cn);
    	//$arreglo_datos= FN_RUN_QUERY($sql, 3, $this->vlc_db_cn);
    	$contador =0;
    	$html="";
    	if ($arreglo)
    	{
    		$html='<table  cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%" >
    		<thead>
    		<tr>
            <th>#</th>
    		<th>Titulo</th>
    		<th>Descripcion</th>
    		<th>Opciones</th>
    		</tr>
    		</thead>
    		<tbody>';
    		foreach ($arreglo as $datos)
    		{
    			$html.="<TR><TD>".$datos[0]."</TD><TD>".substr($datos[1],0,70)."</TD><TD><a href='index.php?id=registro&seccion=investigaciones&investigacion=".$datos[0]."'>".substr($datos[2],0,50)."</a></TD> 
                ".'<td>
      
                  <div class="btn-group">
                    <a class="btn" href="#Editar" onclick="javascript:MTD_EDITAR_DOCUMENTO('.$datos[0].')"><i class="icon-edit"></i></a>
                    <a class="btn" href="#Eliminar" onclick="javascript:MTD_ELIMINAR_DOCUMENTO('.$datos[0].')"><i class="icon-remove-circle"></i></a>                                       
                  </div>
                
            </td>
                </TR>';
    		}
    		$html.="</tbody></table>";    		 
    	}
    	LOGGER::LOG("BUSCAR_DOCUMENTOS :\n");
    	return $html;
    }
    function MTD_SELECCION_CATEGORIAS()
    {
        $codigo_html="";
        $datos = array();
        $datos = FN_RUN_QUERY("SELECT 
                        cab.idcategoria,
                        cab.categoria,
                        sub.idsubcategoria,
                        sub.subcategoria
                        from categorias as cab
                        left join subcategorias as sub ON (cab.idcategoria = sub.idcategoria)
                        order by cab.categoria, sub.subcategoria " , 4 , $this->vlc_db_cn);
        
        $codigo_html="<select id='lst_categorias'>";
        foreach($datos as $key => $value)
        {
            $codigo_html.="<option value='".$value[0].":".$value[2]."'>".$value[1]." - ".$value[3]."</option>";
        }
        $codigo_html.="</select>";
        return $codigo_html;
    }
    function MTD_AGREGAR_DOCUMENTO()
    {
    	LOGGER::LOG("MTD_AGREGAR_DOCUMENTO :\n");
    	LOGGER::LOG("MTD_AGREGAR_DOCUMENTO : uid ".$_SESSION["uid"]);
    	LOGGER::LOG("MTD_AGREGAR_DOCUMENTO : file ".$_SESSION["investigacion_file"]);
    	LOGGER::LOG("MTD_AGREGAR_DOCUMENTO : status ".$_SESSION["investigacion_status"]);
    	$titulo="";
    	$descripcion="";
    	$archivo="";
    	$etiquetas="";
        $categoria="";
        $categorias= array();
    	$titulo=FN_RECIBIR_VARIABLES("titulo");
    	$descripcion=FN_RECIBIR_VARIABLES("descripcion");
    	$etiquetas 	=FN_RECIBIR_VARIABLES("etiquetas");
        $categoria  =FN_RECIBIR_VARIABLES("categoria");
        
        
    	if ($_SESSION["investigacion_status"] == "OK")
    	{
    		$archivo="/var/pdfflex/".$_SESSION['investigacion_file'];
            $imagen="/var/www/fundacion/thumbs/".$_SESSION['investigacion_file'];
            $imagen = FN_REEMPLAZAR("pdf","jpg",$imagen);
            FN_THUMBNAIL($archivo,$imagen);
            $imagen = FN_REEMPLAZAR("/var/www/fundacion/","",$imagen);            
    		LOGGER::LOG("MTD_AGREGAR_DOCUMENTO> uploaded {OK} ");
    		LOGGER::LOG("MTD_AGREGAR_DOCUMENTO> Titulo: $titulo" );
    		LOGGER::LOG("MTD_AGREGAR_DOCUMENTO> Descripcion: $descripcion" );
    		LOGGER::LOG("MTD_AGREGAR_DOCUMENTO> Archivo: $archivo" );
    		LOGGER::LOG("MTD_AGREGAR_DOCUMENTO> Categorias:".$categoria );
            $categorias = explode(":",$categoria);

    		$sql="INSERT INTO documentos (titulo,descripcion,rutadocumento,rutaimagen,etiquetas,idcategoria,idsubcategoria) VALUES"
    		." ('$titulo',
                '$descripcion',
                '$archivo',
                '".$imagen."',
                '".$etiquetas."',
                '".$categorias[0]."',
                '".$categorias[1]."')";
    		$resultado=FN_RUN_NONQUERY($sql,$this->vlc_db_cn);
    		LOGGER::LOG("MTD_AGREGAR_DOCUMENTO>".$sql);
    		LOGGER::LOG("MTD_AGREGAR_DOCUMENTO> Investigacion creada exitosamente");
    		return "1";
    	}
    	else if ($_SESSION["investigacion_status"] == "INVALIDO")
    	{
    		LOGGER::LOG("MTD_AGREGAR_DOCUMENTO> uploaded {INVALIDO} ");
    		return "Atencion,<br> El archivo publicado no es valido, <br> favor seleccione un documento PDF";
    	}
    	else if ($_SESSION["investigacion_status"] == "enviando")
    	{
    		LOGGER::LOG("MTD_AGREGAR_DOCUMENTO> uploaded {enviando} ");
    		return "Atencion,<br> Aun se encuentra enviando el documento,<br> favor aguarde a que finalice el proceso";
    	}
    	else
    	{
    		LOGGER::LOG("MTD_AGREGAR_DOCUMENTO>  debe seleccionar un archivo");
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
	    		LOGGER::LOG("MTD_AGREGAR_DOCUMENTO> uploaded {FAIL}");
	    	}
    	}
    	else
    	{
    		LOGGER::LOG("MTD_AGREGAR_DOCUMENTO> uploaded {FAIL} archivo invalido". $_FILES["uploadedfile"]["type"]);
    	}
    	*/
    }
    function MTD_ELIMINAR_DOCUMENTO()
    {
        LOGGER::LOG("ELIMINAR DOCUMENTO");
        $id_documento=FN_RECIBIR_VARIABLES("id_documento");
        
        $sql="DELETE  from documentos  where iddocumento= ".$id_documento." limit 1;";
        $resultado=false;
        LOGGER::LOG("ELIMINAR DOCUMENTOS: SQL:".$sql);
        $resultado= FN_RUN_NONQUERY($sql,$this->db_cn );
        if ($resultado == true)
        {
            return "0";
        }
        else
        {
            return "Error en la operacion de ELIMINAR de DOCUMENTOS";
        }
    } 
    function MTD_FORMULARIO_DOCUMENTOS()
    {
    	LOGGER::LOG("MTD_FORMULARIO_DOCUMENTOS :\n");

    	$template='tpl/tpl-abm-documentos.html';
    	if (file_exists($template)) 
    	{
    	 $fh  = fopen($template, 'r');	
    	 $theData = fread($fh, filesize($template));
    	 fclose($fh);
    	// LOGGER::LOG("MTD_FORMULARIO_DOCUMENTOS :". $theData);
    	$timestamp= time();
    	 $theData=FN_REEMPLAZAR("{tpl-timestamp}", $timestamp, $theData);
    	 $theData=FN_REEMPLAZAR("{tpl-token}", md5('unique_salt' . $timestamp), $theData);
    	 $theData=FN_REEMPLAZAR("{tpl-session-name}", session_name(), $theData);
    	 $theData=FN_REEMPLAZAR("{tpl-session-id}", session_id(), $theData);
         $theData=FN_REEMPLAZAR("{tpl-lista-categoria}", $this->MTD_SELECCION_CATEGORIAS(), $theData);

         
    	 return $theData;
    	}
    	else
    	{
            LOGGER::LOG("MTD_FORMULARIO_DOCUMENTOS : NO SE ENCONTRO TEMPLATE");
    		return "---";
    	}
    	 
    }
    function MTD_LISTAR_PUBLICIDAD()
    {
    	$sql="SELECT investigacionID";
    	
    }
}
?>
