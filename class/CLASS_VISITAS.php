<?php
class CLASS_VISITAS
{
	private $id_categoria;
	private $categoria;
	private $codigo_html;
	private $db_cn;

	function __construct ($vp_cn)
    {
    	$this->db_cn = $vp_cn;
        $this->MTD_LIMPIAR_VARIABLES();
        $this->MTD_INICIALIZAR_PAGINA ();
                     
    }
    function MTD_LIMPIAR_VARIABLES()
    {
    	$this->id_categoria="";
        $this->categoria="";	    
    } 
    function MTD_INICIALIZAR_PAGINA ()
    {
        /*
         * TODO: 
         * VALORES DEL FORMULARIO         
         */
    	LOGGER::LOG("Asignando el template:");
    	
    	$vlc_codigo_html=FN_LEER_TPL('tpl/tpl-adm-documentos-visitas.html');
    	$vlc_codigo_html = FN_REEMPLAZAR("{tpl-lista-visitas}",$this->MTD_LISTAR_VISITAS(),$vlc_codigo_html );
    	$this->vlc_codigo_html= $vlc_codigo_html;            
    }
    function MTD_LISTAR_VISITAS()
    {
    	$codigo_html="";
    	$datos=array();
        $id_documento =FN_RECIBIR_VARIABLES("id_documento");
    	$datos = FN_RUN_QUERY("SELECT dv.id_visita,usu.nombre_usuario,usu.apellido_usuario,dv.fechahora from documentos_visitas as dv
            INNER JOIN usuarios as usu ON (dv.id_usuario = usu.id_usuario) 
            WHERE id_documento=".$id_documento,4,$this->db_cn);
    	$encabezado= array();
    	$codigo_html='<table class=" table table-bordered " id="example">
    	<thead>
        <tr>
            <th>#</th>
            <th>Usuario </th>            
            <th>Fecha / Hora</th>            
        </tr>
        </thead>
    	<tbody>        
        ';
        foreach ($datos as $key => $value) 
        {
        	$codigo_html.='
        	<tr >
        	<td>'.$value[0].'</td>
            <td>'.$value[1].' '.$value[2].'</td>
            <td>'.$value[3].'</td>
            </tr>
        	';        	
        	
        }
        $codigo_html.="    </tbody> </table>";
        return $codigo_html;
    	
		
    }
    
   
    function MTD_RETORNAR_CODIGO_HTML ()
    {
        return $this->vlc_codigo_html;
    }
}
?>