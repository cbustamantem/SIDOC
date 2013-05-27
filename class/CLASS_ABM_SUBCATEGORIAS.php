<?php
class CLASS_ABM_SUBCATEGORIAS
{
	private $id_subcategoria;
    private $id_categoria;
	private $subcategoria;
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
    	$this->id_subcategoria="";
        $this->id_subcategoria="";
        $this->subcategoria="";	    
    } 
    function MTD_INICIALIZAR_PAGINA ()
    {
        /*
         * TODO: 
         * VALORES DEL FORMULARIO         
         */
    	LOGGER::LOG("Asignando el template:");
    	
    	$vlc_codigo_html=FN_LEER_TPL('tpl/tpl-abm-subcategorias.html');
    	$vlc_codigo_html = FN_REEMPLAZAR("{tpl-lista-subcategorias}",$this->MTD_LISTAR_SUBCATEGORIAS(),$vlc_codigo_html );
        $vlc_codigo_html = FN_REEMPLAZAR("{tpl-lista-categorias}",$this->MTD_SELECCION_CATEGORIAS(),$vlc_codigo_html );
    	$this->vlc_codigo_html= $vlc_codigo_html;
        
       
    }
    function MTD_LISTAR_SUBCATEGORIAS()
    {
    	$codigo_html="";
    	$datos=array();
    	$datos = FN_RUN_QUERY("SELECT 
                sub.idsubcategoria, 
                sub.subcategoria ,
                cab.idcategoria,
                cab.categoria 
                FROM 
                    subcategorias as sub, 
                    categorias as cab 
                WHERE sub.idcategoria = cab.idcategoria",4,$this->db_cn);
    	$encabezado= array();
    	$codigo_html='<table class=" table table-bordered " id="example">
    	<thead>
        <tr>
            <th>#</th>
            <th>Categoria</th>
            <th>Descripcion</th>            
            <th>Opciones</th>            
        </tr>
        </thead>
    	<tbody>        
        ';
        foreach ($datos as $key => $value) 
        {
        	$codigo_html.='
        	<tr >
        	<td>'.$value[0].'</td>
            <td>'.$value[3].'</td>
            <td>'.$value[1].'</td>
            <td>
      
				  <div class="btn-group">
				    <a class="btn" href="#Editar" onclick="javascript:MTD_EDITAR_SUBCATEGORIA('.$value[0].')"><i class="icon-edit"></i></a>
				    <a class="btn" href="#Eliminar" onclick="javascript:MTD_ELIMINAR_SUBCATEGORIA('.$value[0].')"><i class="icon-remove-circle"></i></a>				    				    
				  </div>
				
            </td>
            </tr>
        	';        	
        	
        }
        $codigo_html.="    </tbody> </table>";
        return $codigo_html;
    	
		
    }
    function MTD_SELECCION_CATEGORIAS()
    {
        $codigo_html="";
        $datos = array();
        $datos = FN_RUN_QUERY("SELECT idcategoria, categoria from categorias " , 2 , $this->db_cn);
        
        $codigo_html="<select id='lst_categorias'>";
        foreach($datos as $key => $value)
        {
            $codigo_html.="<option value='".$value[0]."'>".$value[1]."</option>";
        }
        $codigo_html.="</select>";
        return $codigo_html;
    }
    function MTD_AGREGAR_SUBCATEGORIA()
    {
    	LOGGER::LOG("AGREGAR SUBCATEGORIA");
    	$descripcion=FN_RECIBIR_VARIABLES("descripcion");
        $idcategoria=FN_RECIBIR_VARIABLES("idcategoria");
    	
    	$sql="INSERT INTO subcategorias (subcategoria, idcategoria) values ('".$descripcion."',$idcategoria);";
    	$resultado=false;
    	LOGGER::LOG("AGREGAR SUBCATEGORIAS: SQL:".$sql);
    	$resultado= FN_RUN_NONQUERY($sql,$this->db_cn );
    	if ($resultado == true)
    	{
    		return "0";
    	}
    	else
    	{
    		return "Error en la operacion de insercion de especialidad";
    	}
    }
    function MTD_ELIMINAR_SUBCATEGORIA()
    {
        LOGGER::LOG("ELIMINAR SUBCATEGORIA");
        $idsubcategoria=FN_RECIBIR_VARIABLES("idsubcategoria");
        
        $sql="DELETE  from subcategorias  where idsubcategoria= ".$idsubcategoria." limit 1;";
        $resultado=false;
        LOGGER::LOG("ELIMINAR SUBCATEGORIAS: SQL:".$sql);
        $resultado= FN_RUN_NONQUERY($sql,$this->db_cn );
        if ($resultado == true)
        {
            return "0";
        }
        else
        {
            return "Error en la operacion de ELIMINAR de SUBCATEGORIAS";
        }
    }
   	function MTD_RECIBIR_DATOS_DB ($vp_arreglo_datos)
    {   
    	$this->vlc_id_cliente				= $vp_arreglo_datos[0][0];
    	$this->vlc_holding					= $vp_arreglo_datos[0][1];
	    $this->vlc_empresa					= $vp_arreglo_datos[0][2];
	    $this->vlc_sucursal					= $vp_arreglo_datos[0][3]; 		    
    	$this->vlc_nombre_cliente			= $vp_arreglo_datos[0][4];
	    $this->vlc_apellido_cliente			= $vp_arreglo_datos[0][5];
	    
	}
	
	   
    function MTD_DB_ACTUALIZAR ()
    {
        $resultado = false;
        $vlf_sql = "
        UPDATE
  		clientes
		SET
		nombre_cliente 		= '".$this->vlc_nombre_cliente."', 
		apellido_cliente 	= '".$this->vlc_apellido_cliente."', 
		holding			 	= '".$this->vlc_holding."', 
		empresa		 		= '".$this->vlc_empresa."', 
		sucursal		 	= '".$this->vlc_sucursal."'		
		WHERE
  		id_cliente = ".$this->vlc_id_cliente.";";
                
        $resultado = FN_RUN_NONQUERY($vlf_sql, $this->vlc_db_cn );     
       // echo  $vlf_sql;   
        return $resultado;
    }
    
    function MTD_RETORNAR_CODIGO_HTML ()
    {
        return $this->vlc_codigo_html;
    }
}
?>