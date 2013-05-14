<?php
class CLASS_ABM_PERFIL
{
    private $vlc_codigo_html;
    private $vlc_nombre_cliente;
    private $vlc_apellido_cliente;
    private $vlc_holding;
    private $vlc_empresa;
    private $vlc_sucursal;
    private $vlc_id_cliente;
    private $vlc_db_cn;
    function __construct ($vp_cn)
    {
    	$this->vlc_db_cn = $vp_cn;
        $this->MTD_LIMPIAR_VARIABLES();
                     
    }
    function MTD_LIMPIAR_VARIABLES()
    {
    	$this->vlc_codigo_html = "";
        $this->vlc_codigo_html="";
	    $this->vlc_nombre_cliente="";
	    $this->vlc_apellido_cliente="";
	    $this->vlc_holding="";
	    $this->vlc_empresa="";
	    $this->vlc_sucursal="";
	    $this->vlc_id_cliente="";				
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
    	LOGGER::LOG("Asignando el template:");
    	
    	$vlc_codigo_html=FN_LEER_TPL('tpl/tpl-perfil.html');
    	$vlc_codigo_html= FN_REEMPLAZAR("{tpl-doctor}",$_SESSION['nombre_usuario']." ".$_SESSION['apellido_usuario'], $vlc_codigo_html);
    	$vlc_codigo_html= FN_REEMPLAZAR("{tpl-especialidades}",$this->MTD_LISTAR_ESPECIALIDADES(), $vlc_codigo_html);
    	
    	$membrete = $this->MTD_DB_LISTAR_MEMBRETE();
    	$vlc_codigo_html= FN_REEMPLAZAR("{tpl-encabezado-membrete}",$membrete[0][0], $vlc_codigo_html);
    	$vlc_codigo_html= FN_REEMPLAZAR("{tpl-pie-membrete}",$membrete[0][1], $vlc_codigo_html);
    	$this->vlc_codigo_html= $vlc_codigo_html;
        
       
    }
    function MTD_ACTUALIZAR_MEMBRETE()
    {
    	LOGGER::LOG("ACTUALIZAR MEMBRETE");
    	$encabezado="";
    	$pie="";
    	$encabezado = FN_RECIBIR_VARIABLES ("encabezado");
    	$pie		= FN_RECIBIR_VARIABLES ("pie");
    	$sql ="UPDATE usuarios set encabezado_membrete='$encabezado' , pie_membrete='$pie'  where id_usuario=".$_SESSION['uid']." limit 1";
    	$resultado = false;
    	LOGGER::LOG("ACTUALIZAR MEMBRETE > SQL: ".$sql);
    	$resultado = FN_RUN_NONQUERY($sql,$this->vlc_db_cn);
    	
    	if ($resultado == true)
    	{
    		return "0";
    	}
    	else
    	{
    		return "Error en la operacion de actualizar membrete";
    	}
    	
    }
    function MTD_AGREGAR_ESPECIALIDAD()
    {
    	LOGGER::LOG("AGREGAR ESPECIALIDAD");
    	$anho=FN_RECIBIR_VARIABLES("anho");
    	$especialidad=FN_RECIBIR_VARIABLES("especialidad");
    	$sql="INSERT INTO especialidades (anho,especialidad,id_doctor) values
    	('".$anho."','".$especialidad."',".$_SESSION['uid'].");";
    	$resultado=false;
    	LOGGER::LOG("AGREGAR ESPECIALIDAD: SQL:".$sql);
    	$resultado= FN_RUN_NONQUERY($sql,$this->vlc_db_cn );
    	if ($resultado == true)
    	{
    		return "0";
    	}
    	else
    	{
    		return "Error en la operacion de insercion de especialidad";
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
	function MTD_DB_LISTAR_MEMBRETE()
	{
		$resultado = array();
		$sql = "SELECT encabezado_membrete, pie_membrete from usuarios where id_usuario = ".$_SESSION['uid'];
		$resultado= FN_RUN_QUERY($sql, 2,$this->vlc_db_cn);
		return $resultado;
	}
    function MTD_DB_LISTAR_ESPECIALIDAD($vp_filtrar = false)
    {
    	$vlf_sql=" 
    		SELECT
    		id_especialidad,
    		anho, 
			especialidad						
			FROM especialidades 
    		WHERE id_doctor =".$_SESSION['uid'];
        if ($vp_filtrar)
        {
            $vlf_sql .= "where id_cliente=" . $this->vlc_id_cliente;
        }
       
        $vlf_arreglo_datos = FN_RUN_QUERY($vlf_sql,6, $this->vlc_db_cn );
        return $vlf_arreglo_datos;
    }
    function MTD_DB_AGREGAR ()
    {
        $resultado = false;
        $vlf_sql = "
        INSERT INTO clientes
    	( 
    	nombre_cliente, 
			apellido_cliente, 
			holding, 
			empresa, 
			sucursal
			)
		VALUES
    	('".		
		$this->vlc_nombre_cliente . "','".
		$this->vlc_apellido_cliente . "','". 
		$this->vlc_holding . "','".
		$this->vlc_empresa. "','".
		$this->vlc_sucursal. "');";
                
        $resultado = FN_RUN_NONQUERY($vlf_sql, $this->vlc_db_cn );
        //echo "sql: $vlf_sql";        
        return $resultado;
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
