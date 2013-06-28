<?php
 // Zebra Pagination
require_once 'lib/Zebra_Pagination.php';
class CLASS_LISTADO_DOCUMENTOS
{	
	private $vlc_codigo_html;
	private $vlc_busqueda="";
    private $vlc_db_cn;
    private $paginas = 20; // Cantidad de paginas a mostrar
    private $nropaginas;

    function getNroPaginas(){
    	return $this->nropaginas;
    }

    function setNroPaginas($nropaginas){
    	$this->nropaginas = $nropaginas;
    }	
 
    function __construct ($vp_cn)
    {
    	
    	$this->vlc_db_cn = $vp_cn;       
        $this->MTD_INICIALIZAR_PAGINA();

        
    }
  
    function MTD_INICIALIZAR_PAGINA ()
    {
    	LOGGER::LOG("CLASS_LISTA_DOCUMENTOS Inicializar");
    	$codigo_html = FN_LEER_TPL("tpl/tpl-lista-docu.html");
    	$documento = FN_LEER_TPL("tpl/tpl-listadocu-contenido.html");
    	$lista_documentos="";
    	$datos = array();
    	$datos = $this->MTD_LISTAR_DOCUMENTOS();
    	foreach ($datos as $key => $value) 
    	{
			$tpl_documentos = $documento;
			$archivo = FN_REEMPLAZAR("/var/pdfflex/","",$value[7]);
			$link="visor.php?doc=".$archivo;
		
			$tpl_documentos = FN_REEMPLAZAR("{tpl-titulo-documento}",$value[1],$tpl_documentos);
			$tpl_documentos = FN_REEMPLAZAR("{tpl-link-documento}",$link,$tpl_documentos);
			$tpl_documentos = FN_REEMPLAZAR("{tpl-imagen-documento}",$value[8],$tpl_documentos);			
			$tpl_documentos = FN_REEMPLAZAR("{tpl-descripcion}",$value[2],$tpl_documentos);			
    		$lista_documentos .=$tpl_documentos;
    	}
    	$paginar = $this->getNroPaginas();
    	$codigo_html = FN_REEMPLAZAR( "{paginacion}",$paginar, $codigo_html );
    	$codigo_html = FN_REEMPLAZAR("{lista-documentos}",$lista_documentos,$codigo_html);
    	
    	$this->vlc_codigo_html = $codigo_html;
    	
	}
	
	function MTD_LISTAR_DOCUMENTOS()
	{

		$totaldocumentos = FN_CONTAR_REGISTRO('select * from documentos',$this->vlc_db_cn);

		$paginacion = new Zebra_Pagination();
		$paginacion->labels('Anterior', 'Siguiente');
		$paginacion->records($totaldocumentos);
		$paginacion->records_per_page($this->paginas);
		$busqueda="";
		$filtro=" ";
		if (isset($_GET['busqueda']))
		{
			$busqueda=FN_RECIBIR_VARIABLES("busqueda");
			$filtro="WHERE
			etiquetas like '%".$busqueda."%'
			OR
			titulo like '%".$busqueda."%'
			OR
			descripcion like '%".$busqueda."%'  " ;
		}
		$sql="
			SELECT
			iddocumento,
			titulo,
			descripcion,
			documento,
			fecha,
			idsubcategoria,
			idcategoria,
			rutadocumento,
			rutaimagen,
			etiquetas
			FROM documentos
			".$filtro."			 
 		     ";
		

		if (isset($_GET['categoria']))
		{
			$where =  " WHERE idcategoria=".FN_RECIBIR_VARIABLES('categoria');


		}
		if (isset($_GET['subcategoria']))
		{
			$where .=  " AND idsubcategoria=".FN_RECIBIR_VARIABLES('subcategoria'); 

		}
		$where .=  " ORDER BY titulo LIMIT ".((($paginacion->get_page() - 1) * 
				$this->paginas) . ', ' . $this->paginas);
		$datos = array();
		$datos = FN_RUN_QUERY($sql.$where,10,$this->vlc_db_cn);
		
		
		$this->setNroPaginas($paginacion->render(true));
		return $datos;
	}
	
	function MTD_RETORNAR_CODIGO_HTML()
	{
		return $this->vlc_codigo_html;
	}
}
