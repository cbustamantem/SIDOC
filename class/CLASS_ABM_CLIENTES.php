<?php
class CLASS_ABM_CLIENTES
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
        $this->MTD_INICIALIZAR_PAGINA();               
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
        $vl_cod_html_base = FN_LEER_TPL('tpl/tpl-abm-clientes.html');
        /*
         * ================================
         * AGREGAR REGISTROS
         * ================================
         */
        if (isset($_REQUEST['MTD_AGREGAR']))
        {
            $this->MTD_RECIBIR_DATOS();
            $vlf_resultado = "";
            if ($this->MTD_DB_AGREGAR())
            {
                $vlf_resultado = "<img src='archivos_de_disenho/imagenes/resultado_ok.png'> Se agrego correctamente el Registro";
            }
            else
            {
                $vlf_resultado = "<img src='archivos_de_disenho/imagenes/resultado_mal.png'> Atencion Ocurrio un error durante la operacion, verifique los datos";
            }
            $this->MTD_LIMPIAR_VARIABLES();
            $vl_cod_html_base = $this->MTD_APLICAR_TEMPLATE($vl_cod_html_base);
            $vl_cod_html_base = FN_REEMPLAZAR('{accion-formulario}', 'MTD_AGREGAR', $vl_cod_html_base);
            $vl_cod_html_base = FN_REEMPLAZAR('{titulo-accion-formulario}', 'Agregar Cliente', $vl_cod_html_base);
            $vl_cod_html_base = FN_REEMPLAZAR('{resultado-operacion}', $vlf_resultado, $vl_cod_html_base);
           
        }
        /*
         * ================================
         * ACTUALIZAR REGISTROS
         * ================================
         */
        elseif (isset($_REQUEST['MTD_ACTUALIZAR']))
        {
            $this->MTD_RECIBIR_DATOS();
            $vlf_resultado = "";
            if ($this->MTD_DB_ACTUALIZAR())
            {
                $vlf_resultado = "<img src='archivos_de_disenho/imagenes/resultado_ok.png'> Se actualizo correctamente el Registro";
            }
            else
            {
                $vlf_resultado = "<img src='archivos_de_disenho/imagenes/resultado_mal.png'> Atencion Ocurrio un error durante la operacion, verifique los datos";
            }
           	$vl_cod_html_base = $this->MTD_APLICAR_TEMPLATE($vl_cod_html_base);
            $vl_cod_html_base = FN_REEMPLAZAR('{accion-formulario}', 'MTD_AGREGAR', $vl_cod_html_base);
            $vl_cod_html_base = FN_REEMPLAZAR('{titulo-accion-formulario}', 'Agregar Cliente', $vl_cod_html_base);
            $vl_cod_html_base = FN_REEMPLAZAR('{resultado-operacion}', $vlf_resultado, $vl_cod_html_base);
        }
        /*
         * ================================
         * EDITAR REGISTROS
         * ================================
         */
        elseif (isset($_GET['MTD_EDITAR']))
        {
            $this->MTD_RECIBIR_DATOS();            
            $vlp_datos_grilla = $this->MTD_DB_LISTAR(true);
            $vlf_resultado = ""; 
            $this->MTD_RECIBIR_DATOS_DB($vlp_datos_grilla);           
            $vl_cod_html_base = $this->MTD_APLICAR_TEMPLATE($vl_cod_html_base);   
        	         
            $vl_cod_html_base = FN_REEMPLAZAR('{accion-formulario}', 'MTD_ACTUALIZAR', $vl_cod_html_base);
            $vl_cod_html_base = FN_REEMPLAZAR('{titulo-accion-formulario}', 'Actualizar Cliente', $vl_cod_html_base);
            $vl_cod_html_base = FN_REEMPLAZAR('{resultado-operacion}', $vlf_resultado, $vl_cod_html_base);
         
        }
        elseif (isset($_GET['MTD_ELIMINAR']))
        {
            $this->MTD_RECIBIR_DATOS();
            $vlf_resultado = "";
            if ($this->MTD_DB_ELIMINAR())
            {
                $vlf_resultado = "<img src='archivos_de_disenho/imagenes/resultado_ok.png'> Se elimino correctamente el Registro";
            }
            else
            {
                $vlf_resultado = "<img src='archivos_de_disenho/imagenes/resultado_mal.png'> Atencion Ocurrio un error durante la operacion, verifique los datos";
            }
            $this->MTD_LIMPIAR_VARIABLES();
            $vl_cod_html_base = $this->MTD_APLICAR_TEMPLATE($vl_cod_html_base);
            $vl_cod_html_base = FN_REEMPLAZAR('{accion-formulario}', 'MTD_AGREGAR', $vl_cod_html_base);
            $vl_cod_html_base = FN_REEMPLAZAR('{titulo-accion-formulario}', 'Agregar Cliente', $vl_cod_html_base);            
            //FN_REEMPLAZAR('{titulo-accion-formulario}', 'Agregar Cliente', $vl_cod_html_base);
            $vl_cod_html_base = FN_REEMPLAZAR('{resultado-operacion}', $vlf_resultado, $vl_cod_html_base);            
        }
        else
        {
        
            $vl_cod_html_base = $this->MTD_APLICAR_TEMPLATE($vl_cod_html_base);
        	$vl_cod_html_base = FN_REEMPLAZAR('{accion-formulario}', 'MTD_AGREGAR', $vl_cod_html_base);
            $vl_cod_html_base = FN_REEMPLAZAR('{titulo-accion-formulario}', 'Agregar Cliente', $vl_cod_html_base);
            $vl_cod_html_base = FN_REEMPLAZAR('{resultado-operacion}', '', $vl_cod_html_base);
        }
        $vl_cod_html_grilla = $this->MTD_GENERAR_GRILLA();
        $vl_cod_html_base = FN_REEMPLAZAR('{grilla-datos-clientes}', $vl_cod_html_grilla, $vl_cod_html_base);
        $this->vlc_codigo_html = $vl_cod_html_base;
    }
    function MTD_GENERAR_GRILLA ()
    {
        $vlf_codigo_html_grilla;
        $vlp_datos_grilla = $this->MTD_DB_LISTAR();
        $vp_titulo = array();
        $vp_titulo[0] = "Id";
        $vp_titulo[1] = "Holding";
        $vp_titulo[2] = "Empresa";
        $vp_titulo[3] = "Sucursal";        
        $vp_css_titulos = array();
        $vp_css_titulos[0] = "columna_id titulo_listado";
        $vp_css_titulos[1] = "columna_fecha titulo_listado";
        $vp_css_titulos[2] = "columna_fecha titulo_listado";
        $vp_css_titulos[3] = "columna_fecha titulo_listado";
        $vp_css_filas_datos = array();
        $vp_css_filas_datos[0] = "texto columna_id";
        $vp_css_filas_datos[1] = "texto columna_fecha";
        $vp_css_filas_datos[2] = "texto columna_fecha";
        $vp_css_filas_datos[3] = "texto columna_fecha";
        $vp_css_columnas_datos = array();
        $vp_css_columnas_datos[0] = "columna_id";
        $vp_css_columnas_datos[1] = "columna_fecha";
        $vp_css_columnas_datos[2] = "columna_fecha";
        $vp_css_columnas_datos[3] = "columna_fecha";
        $visualizar = true;
        $modificar = true;
        $eliminar = true;
        $lnk_visualizar = "#";
        $lnk_modificar = "index.php?id=area-de-clientes&seccion=clientes&MTD_EDITAR=true";
        $lnk_eliminar = "index.php?id=area-de-clientes&seccion=clientes&MTD_ELIMINAR=true";
        $corregir = false;
        $lnk_corregir = "";
        //$vlp_planes_clases
        $vlf_codigo_html_grilla = FN_HTML_ARMAR_GRILLA2($vp_titulo, $vlp_datos_grilla, $vp_css_titulos, $vp_css_filas_datos, $vp_css_columnas_datos, $visualizar, $modificar, $eliminar, $lnk_visualizar, $lnk_modificar, $lnk_eliminar, $corregir, $lnk_corregir);
        return $vlf_codigo_html_grilla;
    }
    function MTD_APLICAR_TEMPLATE ($vp_codigo_html)
    {
    	list($dia,$mes,$anho) = split("/",$this->vlc_fecha_inicio_contrato);
     	$vp_codigo_html = FN_REEMPLAZAR('{tb-nombre-cliente}'	, $this->vlc_nombre_cliente, $vp_codigo_html);
    	$vp_codigo_html = FN_REEMPLAZAR('{tb-apellido-cliente}'	, $this->vlc_apellido_cliente	, $vp_codigo_html);
    	$vp_codigo_html = FN_REEMPLAZAR('{tb-holding}'	, $this->vlc_holding, $vp_codigo_html);
    	$vp_codigo_html = FN_REEMPLAZAR('{tb-empresa}'		, $this->vlc_empresa	, $vp_codigo_html);
    	$vp_codigo_html = FN_REEMPLAZAR('{tb-sucursal}'	, $this->vlc_sucursal, $vp_codigo_html);
    	$vp_codigo_html = FN_REEMPLAZAR('{tb-id-cliente}'			, $this->vlc_id_cliente, $vp_codigo_html);
    	               
        return  $vp_codigo_html;
        
    }
	
    function MTD_RECIBIR_DATOS ()
    {    	        
	    $this->vlc_nombre_cliente	= FN_RECIBIR_VARIABLES('tb_nombre_cliente') ;
	    $this->vlc_apellido_cliente	= FN_RECIBIR_VARIABLES('tb_apellido_cliente');
	    $this->vlc_holding			= FN_RECIBIR_VARIABLES('tb_holding');
	    $this->vlc_empresa			= FN_RECIBIR_VARIABLES('tb_empresa');
	    $this->vlc_sucursal			= FN_RECIBIR_VARIABLES('tb_sucursal');
	    $this->vlc_id_cliente		= FN_RECIBIR_VARIABLES('tb_id_cliente');			        
        if (isset($_GET['codigo']))
        {
            $this->vlc_id_cliente = $_GET['codigo'];
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
    function MTD_DB_LISTAR ($vp_filtrar = false)
    {
    	$vlf_sql=" 
    		SELECT
    		id_cliente,
    		holding, 
			empresa, 
			sucursal,			 
			nombre_cliente, 
			apellido_cliente 
			
			FROM clientes ";
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
