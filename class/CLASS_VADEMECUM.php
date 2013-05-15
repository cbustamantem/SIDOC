<?php
class CLASS_VADEMECUM
{
    private $vlc_codigo_html;
	private $vlc_busqueda="";
    private $vlc_db_cn;
    function __construct ($vp_cn)
    {
    	$this->vlc_db_cn = $vp_cn;
       
        //$this->MTD_INICIALIZAR_PAGINA();
        
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
	   $producto="";
	   $producto= FN_RECIBIR_VARIABLES("producto");
       $this->vlc_codigo_html = $this->MTD_LEER_TPL('tpl/tpl-vademecum.html');
       $busqueda= FN_RECIBIR_VARIABLES("busqueda");
       $datos="";
       if ($busqueda)
       {
       	$datos= $this->MTD_BUSCAR_VADEMECUM();
       }
       elseif($producto)
       {
       		$this->vlc_codigo_html = $this->MTD_LEER_TPL('tpl/tpl-vademecum-prospecto.html');
       		$datos = $this->MTD_BUSCAR_PROSPECTO($producto);
       		
       		
       }
       else
      {
      	$datos='<table cellpadding="0" cellspacing="0" border="0" class="display" id="example2" width="100%">
	<thead>
		<tr>
			<th>Laboratorio</th>
			<th>Producto</th>
			<th>Opciones</th>			
		</tr>
	</thead>
	<tbody>
		<TR>
			<TD>--</TD>
			<TD>--</TD>
			<TD>--</TD>
		</TR>
     </tbody>	
</table>';
       }
       
       $this->vlc_codigo_html = FN_REEMPLAZAR("{tpl-datos}",$datos,$this->vlc_codigo_html);
    }
        
    function MTD_RETORNAR_CODIGO_HTML ()
    {
        return $this->vlc_codigo_html;
    }
    function MTD_RECIBIR_VARIABLES()
    {
    	
    }
    function MTD_MOSTRAR_VADEMECUM()
    {
    	$this->MTD_INICIALIZAR_PAGINA();    	    
    	return $this->vlc_codigo_html;
    	    	    
    }
    function MTD_BUSCAR_VADEMECUM()
    {
    	LOGGER::LOG("BUSCAR_VADEMECUM");
    	$tipo = FN_RECIBIR_VARIABLES("tipo_busqueda");
    	$busqueda= FN_RECIBIR_VARIABLES("busqueda");
    	LOGGER::LOG("BUSCAR_VADEMECUM > TIPO:".$tipo);
    	LOGGER::LOG("BUSCAR_VADEMECUM > Busqueda:".$busqueda);
    	$arreglo = array();
    	if ($tipo == 'todo')
    	{    		
    	   	$sql="SELECT productoCodigo as cod, lab.nombre as nombrelaboratorio, 
    	   		prod.nombre as nombreproducto , 'PROD' as tipo 
				FROM producto as prod, laboratorio as lab
				WHERE prod.laboratorioCodigo = lab.LaboratorioCodigo
				AND (prod.nombre like '%".$busqueda."%' 
					  OR prod.prospecto like '%".$busqueda."%'
					  OR lab.nombre like '%".$busqueda."%')";
    	
    	   	$arreglo = FN_RUN_QUERY($sql,3, $this->vlc_db_cn);
    	}
    	elseif ($tipo == 'laboratorio')
    	{
    		$sql="SELECT productoCodigo as cod, lab.nombre as nombrelaboratorio, 
    	   		prod.nombre as nombreproducto , 'PROD' as tipo 
				FROM producto as prod, laboratorio as lab
				WHERE prod.laboratorioCodigo = lab.LaboratorioCodigo
				AND  lab.nombre like '%".$busqueda."%'";
    	   	$arreglo = FN_RUN_QUERY($sql,3, $this->vlc_db_cn);
    	}
    	elseif ($tipo == 'producto')
    	{
    		$sql="SELECT productoCodigo as cod, lab.nombre as nombrelaboratorio,
    		prod.nombre as nombreproducto , 'PROD' as tipo
    		FROM producto as prod, laboratorio as lab
    		WHERE prod.laboratorioCodigo = lab.LaboratorioCodigo
    		AND prod.nombre like '%".$busqueda."%'";
    		
    		$arreglo = FN_RUN_QUERY($sql,3, $this->vlc_db_cn);
    	}
    	elseif ($tipo == 'prospecto')
    	{
    		$sql="SELECT productoCodigo as cod, lab.nombre as nombrelaboratorio,
    		prod.nombre as nombreproducto , 'PROD' as tipo
    		FROM producto as prod, laboratorio as lab
    		WHERE prod.laboratorioCodigo = lab.LaboratorioCodigo
    		AND prod.nombre like '%".$busqueda."%'";
    	
    		$arreglo = FN_RUN_QUERY($sql,3, $this->vlc_db_cn);
    	}
    	//$arreglo_datos= FN_RUN_QUERY($sql, 3, $this->vlc_db_cn);
    	$contador =0;
    	$html="";
    	if ($arreglo)
    	{
    		$html='<table  cellpadding="0" cellspacing="0" border="0" class="display"  id="example2" width="100%" >
    		<thead>
		<tr>
			<th>Laboratorio</th>
			<th>Producto</th>
			<th>Opciones</th>				
		</tr>
	</thead>
	<tbody>';
    		foreach ($arreglo as $datos)
    		{ 
    			$html.="<TR><TD>".$datos[1]."</TD><TD><a href='#mostrarPublicidad' class='lista-enlace' onclick='javascript:MTD_MOSTRAR_VADEMECUM_DETALLE(".$datos[0].")'>".$datos[2]."</a></TD><TD>-</TD></TR>";    					
    		}
    		$html.="</tbody></table>";
    	
    	}
    	LOGGER::LOG("BUSCAR_VADEMECUM :\n".$html);
    	return $html;
    }
    function MTD_BUSCAR_PROSPECTO($producto)
    {
    	$sql = "SELECT prospecto from producto where productoCodigo = ".$producto;
    	$arreglo= array();
    	$arreglo = FN_RUN_QUERY($sql, 1,$this->vlc_db_cn);
    	$prospecto="";
    	if ($arreglo)
    	{
    		$prospecto="<div style='width:600px; height:320px; overflow-y:scroll;'>".$arreglo[0][0]."</div>";
    		return $prospecto;    		
    	}
    	else
    	{
    		return "--";
    	}
    }
    function MTD_LISTAR_PUBLICIDAD()
    {
    	$sql="SELECT productoID";
    	
    }
    function MTD_LEER_TPL($vp_template)
    {
    	LOGGER::LOG("LEER TPL:". $vp_template);
    	if (file_exists($vp_template))
    	{
    		$fh  = fopen($vp_template, 'r');
    		$theData = fread($fh, filesize($vp_template));
    		fclose($fh);
    		// LOGGER::LOG("MTD_FORMULARIO_INVESTIGACIONES :". $theData);
    		return $theData;
    	}
    	else
    	{
    		LOGGER::LOG("LEER TPL:". $vp_template ." el archo no existe");
    		return "---";
    	}
    }
}
?>
