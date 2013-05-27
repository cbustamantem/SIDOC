<?php
class CLASS_ABM_CATEGORIAS
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
    	
    	$vlc_codigo_html=FN_LEER_TPL('tpl/tpl-abm-categorias.html');
    	$vlc_codigo_html = FN_REEMPLAZAR("{tpl-lista-categorias}",$this->MTD_LISTAR_CATEGORIAS(),$vlc_codigo_html );
    	$this->vlc_codigo_html= $vlc_codigo_html;
        
       
    }
    function MTD_LISTAR_CATEGORIAS()
    {
    	$codigo_html="";
    	$datos=array();
    	$datos = FN_RUN_QUERY("SELECT idcategoria, categoria from categorias",2,$this->db_cn);
    	$encabezado= array();
    	$codigo_html='<table class=" table table-bordered " id="example">
    	<thead>
        <tr>
            <th>#</th>
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
            <td>'.$value[1].'</td>
            <td>
      
				  <div class="btn-group">
				    <a class="btn" href="#Editar" onclick="javascript:MTD_EDITAR_CATEGORIA('.$value[0].')"><i class="icon-edit"></i></a>
				    <a class="btn" href="#Eliminar" onclick="javascript:MTD_ELIMINAR_CATEGORIA('.$value[0].')"><i class="icon-remove-circle"></i></a>				    				    
				  </div>
				
            </td>
            </tr>
        	';        	
        	
        }
        $codigo_html.="    </tbody> </table>";
        return $codigo_html;
    	
		
    }
    function MTD_AGREGAR_CATEGORIA()
    {
    	LOGGER::LOG("AGREGAR CATEGORIA");
    	$descripcion=FN_RECIBIR_VARIABLES("descripcion");
    	
    	$sql="INSERT INTO categorias (categoria) values ('".$descripcion."');";
    	$resultado=false;
    	LOGGER::LOG("AGREGAR CATEGORIAS: SQL:".$sql);
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
    function MTD_ELIMINAR_CATEGORIA()
    {
        LOGGER::LOG("ELIMINAR CATEGORIA");
        $idcategoria=FN_RECIBIR_VARIABLES("idcategoria");
        
        $sql="DELETE  from categorias  where idcategoria= ".$idcategoria." limit 1;";
        $resultado=false;
        LOGGER::LOG("ELIMINAR CATEGORIAS: SQL:".$sql);
        $resultado= FN_RUN_NONQUERY($sql,$this->db_cn );
        if ($resultado == true)
        {
            return "0";
        }
        else
        {
            return "Error en la operacion de ELIMINAR de CATEGORIAS";
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
	function MTD_LISTAR_ESPECIALIDADES()
	{
		$arreglo_especialidades = $this->MTD_DB_LISTAR_ESPECIALIDAD();
		$html_especialidades="";
		if ($arreglo_especialidades)
		{
			$html_especialidades="<ul class='lista_especialidad'>";
			foreach($arreglo_especialidades as $especialidad)
			{
				$html_especialidades.="<li><a href='#' onclick='javascript:MTD_ELIMINAR_ESPECIALIDAD($especialidad[0])'><img title='Eliminar Especialidad' src='archivos_de_disenho/images/bt_eliminar.png'></a>".$especialidad[1]." ".$especialidad[2]."</li>";
			}
			$html_especialidades.="</u>";
		}
		return $html_especialidades;
		
	} 
	function MTD_ELIMINAR_ESPECIALIDAD()
	{
		LOGGER::LOG("ELIMNAR ESPECIALIDAD 22 " );
		$id_especialidad="";
		$id_especialidad= FN_RECIBIR_VARIABLES("idespecialidad");
		LOGGER::LOG("ELIMNAR ESPECIALIDAD  id: ".$id_especialidad);
		$sql = "DELETE from especialidades where id_especialidad = $id_especialidad and id_doctor= ".$_SESSION['uid']." limit 1";
		$resultado = false;
		LOGGER::LOG("ELIMNAR ESPECIALIDAD SQL: ".$sql);
		$resultado = FN_RUN_NONQUERY($sql, $this->vlc_db_cn);
		if ($resultado == true)
		{
			return "0";
		}
		else 
		{
			return "-1";
		}
				
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
    function MTD_DB_ELIMINAR ()
    {
        $resultado = false;
        $vlf_sql = "DELETE FROM clientes  where id_cliente =" . $this->vlc_id_cliente;
        $resultado = FN_RUN_NONQUERY($vlf_sql, $this->vlc_db_cn );
        return $resultado;
    }
    function MTD_RETORNAR_CODIGO_HTML ()
    {
        return $this->vlc_codigo_html;
    }
}
?>