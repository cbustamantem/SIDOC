<?php
class CLASS_PUBLICACION_DATOS
{
    private $vlc_codigo_html;
    private $vlc_id_cliente;
    private $vlc_db_conexion;  
    private $vlc_nombre_archivo;        
    private $vlc_arreglo_datos_xls;
    
    function __construct($vp_conexion)
    {
    	$this->vlc_db_conexion =$vp_conexion;
		$this->MTD_LIMPIAR_VARIABLES();
        $this->MTD_INICIALIZAR_PAGINA();
        
    }
    function MTD_LIMPIAR_VARIABLES()
    {
		$this->vlc_codigo_html="";	    	   
	    $this->vlc_id_cliente="";
	    $this->vlc_descripcion_rol_usuario="";
	    $this->vlc_nombre_archivo="";
	    $this->vlc_arreglo_datos_xls = array();   
    }
   
    function MTD_INICIALIZAR_PAGINA ()
    {
        /*
         * TODO: 
         * VALORES DEL FORMULARIO
         * ----------------------
         * [tb_nombre_usuario]
         * [id_usuario]
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
        $vl_cod_html_base = FN_LEER_TPL('tpl/tpl-publicacion-datos.html');
        /*
         * ================================
         * AGREGAR REGISTROS
         * ================================
         */
        if (isset($_REQUEST['MTD_AGREGAR']))
        {
            $this->MTD_RECIBIR_DATOS();
            $this->MTD_OBTENER_DATOS_XLS();            
            $vlf_resultado = "";
            
            if ($this->MTD_DB_AGREGAR())
            {
		$this->MTD_DB_ELIMINAR_TOTALES(); 
                $vlf_resultado = "<img src='archivos_de_disenho/imagenes/resultado_ok.png'> Se agrego correctamente el Registro";
            }
            else
            {
                $vlf_resultado = "<img src='archivos_de_disenho/imagenes/resultado_mal.png'> Atencion Ocurrio un error durante la operacion, verifique los datos";
            }
            $this->MTD_LIMPIAR_VARIABLES();
            $vl_cod_html_base = $this->MTD_APLICAR_TEMPLATE($vl_cod_html_base);
            $vl_cod_html_base = FN_REEMPLAZAR('{accion-formulario}', 'MTD_AGREGAR', $vl_cod_html_base);
            $vl_cod_html_base = FN_REEMPLAZAR('{titulo-accion-formulario}', 'Publicar Datos', $vl_cod_html_base);
            $vl_cod_html_base = FN_REEMPLAZAR('{resultado-operacion}', $vlf_resultado, $vl_cod_html_base);
           
        }        
        else
        {
        
            $vl_cod_html_base = $this->MTD_APLICAR_TEMPLATE($vl_cod_html_base);
        	$vl_cod_html_base = FN_REEMPLAZAR('{accion-formulario}', 'MTD_AGREGAR', $vl_cod_html_base);
            $vl_cod_html_base = FN_REEMPLAZAR('{titulo-accion-formulario}', 'Agregar usuario', $vl_cod_html_base);
            $vl_cod_html_base = FN_REEMPLAZAR('{resultado-operacion}', '', $vl_cod_html_base);
        }
        $vl_cod_html_grilla = $this->MTD_GENERAR_GRILLA();
        $vl_cod_html_base = FN_REEMPLAZAR('{grilla-datos-usuarioes}', $vl_cod_html_grilla, $vl_cod_html_base);
        $this->vlc_codigo_html = $vl_cod_html_base;
    }
    function MTD_GENERAR_GRILLA ()
    {
        $vlf_codigo_html_grilla;
        $vlp_datos_grilla = $this->MTD_DB_LISTAR();
        $vp_titulo = array();
        $vp_titulo[0] = "Id";
        $vp_titulo[1] = "Nombre";
        $vp_titulo[2] = "Apellido";
        $vp_titulo[3] = "Usuario";
        $vp_titulo[4] = "Holding";
        $vp_css_titulos = array();
        $vp_css_titulos[0] = "columna_id titulo_listado";
        $vp_css_titulos[1] = "columna_fecha titulo_listado";
        $vp_css_titulos[2] = "columna_fecha titulo_listado";
        $vp_css_titulos[3] = "columna_fecha titulo_listado";
        $vp_css_titulos[4] = "columna_fecha titulo_listado";
        $vp_css_filas_datos = array();
        $vp_css_filas_datos[0] = "texto columna_id";
        $vp_css_filas_datos[1] = "texto columna_fecha";
        $vp_css_filas_datos[2] = "texto columna_fecha";
        $vp_css_filas_datos[3] = "texto columna_fecha";
        $vp_css_filas_datos[4] = "texto columna_fecha";
        $vp_css_columnas_datos = array();
        $vp_css_columnas_datos[0] = "columna_id";
        $vp_css_columnas_datos[1] = "columna_fecha";
        $vp_css_columnas_datos[2] = "columna_fecha";
        $vp_css_columnas_datos[3] = "columna_fecha";
        $vp_css_columnas_datos[4] = "columna_fecha";
        $visualizar = true;
        $modificar = true;
        $eliminar = true;
        $lnk_visualizar = "#";
        $lnk_modificar = "index.php?id=area-de-clientes&seccion=administracion-usuarios&MTD_EDITAR=true";
        $lnk_eliminar = "index.php?id=area-de-clientes&seccion=administracion-usuarios&MTD_ELIMINAR=true";
        $corregir = false;
        $lnk_corregir = "";
        //$vlp_planes_clases
        $vlf_codigo_html_grilla = FN_HTML_ARMAR_GRILLA2($vp_titulo, $vlp_datos_grilla, $vp_css_titulos, $vp_css_filas_datos, $vp_css_columnas_datos, $visualizar, $modificar, $eliminar, $lnk_visualizar, $lnk_modificar, $lnk_eliminar, $corregir, $lnk_corregir);
        return $vlf_codigo_html_grilla;
    }
    function MTD_APLICAR_TEMPLATE ($vp_codigo_html)
    {    		   
    	$vp_codigo_html = FN_REEMPLAZAR('{tb-nombre-usuario}', $this->vlc_nombre_usuario, $vp_codigo_html);
    	$vp_codigo_html = FN_REEMPLAZAR('{tb-apellido-usuario}', $this->vlc_apellido_usuario, $vp_codigo_html);    	
    	$vp_codigo_html = FN_REEMPLAZAR('{tb-username}', $this->vlc_username, $vp_codigo_html);
    	$vp_codigo_html = FN_REEMPLAZAR('{tb-passwd}', $this->vlc_passwd, $vp_codigo_html);
    	$vp_codigo_html = FN_REEMPLAZAR('{tb-holding}', $this->vlc_holding, $vp_codigo_html);
    	$vp_codigo_html = FN_REEMPLAZAR('{tb-email}', $this->vlc_email, $vp_codigo_html);
    	$vp_codigo_html = FN_REEMPLAZAR('{tb-empresa}', $this->vlc_empresa, $vp_codigo_html);    	
    	$vp_codigo_html = FN_REEMPLAZAR('{tb-sucursal}', $this->vlc_sucursal, $vp_codigo_html);    	    	                
        $vp_codigo_html = FN_REEMPLAZAR('{tb-telefono-movil}', $this->vlc_telefono_movil, $vp_codigo_html);
        $vp_codigo_html = FN_REEMPLAZAR('{tb-telefono-empresa}', $this->vlc_telefono_empresa, $vp_codigo_html);
        $vp_codigo_html = FN_REEMPLAZAR('{tb-direccion}', $this->vlc_direccion, $vp_codigo_html);
        $vp_codigo_html = FN_REEMPLAZAR('{tb-ciudad}', $this->vlc_ciudad, $vp_codigo_html);                
        $vp_codigo_html = FN_REEMPLAZAR('{tb-id-usuario}', $this->vlc_id_usuario, $vp_codigo_html);

         //LISTA DE CLIENTES
        $vlf_arreglo_clientes 		= $this->MTD_DB_LISTAR_CLIENTES();        
        $vlf_codigo_lista_clientes 	= FN_HTML_ARMAR_LISTA_ST($vlf_arreglo_clientes,'Lista de clientes','lst_clientes',$this->vlc_id_cliente);
        $vp_codigo_html 			= FN_REEMPLAZAR('{lista-clientes}', $vlf_codigo_lista_clientes, $vp_codigo_html);
                       
                   
        return  $vp_codigo_html;
    }
  	function MTD_RECIBIR_DATOS()
    {      	     
		
		$this->vlc_id_cliente					= FN_RECIBIR_VARIABLES('lst_clientes');
		
		$nombre_archivo = $_FILES['tb_archivo']['name'];
		$tipo_archivo = $_FILES['tb_archivo']['type'];
		$tamano_archivo = $_FILES['tb_archivo']['size'];
		//compruebo si las características del archivo son las que deseo
		//echo "<br> Archivo:[$nombre_archivo] extension:[$tipo_archivo] tamanho:[$tamano_archivo]<br>";
		if (!(($tipo_archivo == "application/vnd.ms-excel") && ($tamano_archivo < 100000))) 
		{
		    //echo "La extensión o el tamaño de los archivos no es correcta. <br><br><table><tr><td><li>Se permiten archivos .gif o .jpg<br><li>se permiten archivos de 100 Kb máximo.</td></tr></table>";
		}
		else
		{
		    if (move_uploaded_file($_FILES['tb_archivo']['tmp_name'], "archivos/".$nombre_archivo))
		    {
		    	$this->vlc_nombre_archivo = $nombre_archivo;
		       ///echo "El archivo ha sido cargado correctamente.";
		    }
		    else
		    {
		       echo "Ocurrió algún error al subir el fichero. No pudo guardarse.";
		    }
		} 
			   
    }
 	function MTD_RECIBIR_DATOS_DB ($vp_arreglo_datos)
    {
    		/*id_usuario, 
			nombre_usuario, 
			apellido_usuario, 
			username, 
			passwd, 
			holding, 
			empresa, 
			sucursal, 
			fecha_nacimiento, 
			telefono_empresa, 
			telefono_movil, 
			direccion, 
			ciudad, 
			email, 
			id_rol_usuario*/
          	    	            		  		              
    }
   
    function MTD_DB_LISTAR_CLIENTES()
    {
    	
    	$vlf_sql="SELECT id_cliente, holding from clientes";
    	$vlf_arreglo_datos = FN_RUN_QUERY($vlf_sql,2, $this->vlc_db_conexion );
        return $vlf_arreglo_datos;
    }
    function MTD_DB_LISTAR ($vp_filtrar = false)
    {  
      	if ($vp_filtrar)
        {
            $vlf_sql = "
            SELECT 
			id_usuario, 
			nombre_usuario, 
			apellido_usuario, 
			username,
			holding, 
			passwd,  
			empresa, 
			sucursal, 			
			telefono_empresa, 
			telefono_movil, 
			direccion, 
			ciudad, 
			email, 
			rol_usuario,
			id_cliente 
			from usuarios
			where id_usuario =" . $this->vlc_id_usuario;
        }
        else
        {
            $vlf_sql = "
            SELECT 
			id_usuario, 
			nombre_usuario, 
			apellido_usuario, 
			username, 			
			holding, 
			passwd, 
			empresa, 
			sucursal, 			
			telefono_empresa, 
			telefono_movil, 
			direccion, 
			ciudad, 
			email, 
			rol_usuario,
			id_cliente 
			from usuarios";
        }
        $vlf_arreglo_datos = FN_RUN_QUERY($vlf_sql,15, $this->vlc_db_conexion );
        return $vlf_arreglo_datos;
    }
    function MTD_DB_AGREGAR ()
    {
        $resultado = false;       
        if ($this->vlc_arreglo_datos_xls != 0)
        {
	        $cantidad_registros = sizeof($this->vlc_arreglo_datos_xls);
	        $cantidad_registros =  $cantidad_registros  - 2;
	        $contador=1;
	        $this->MTD_DB_ELIMINAR();
	        while ($contador < $cantidad_registros)
	        { 
		        $vlf_sql = "INSERT INTO resultados_contables (id_cliente, cta_cta, cta_nivel, cta_nombre, cta_asentable, cta_int, debe, haber, total, sub, nivel, tipo)              
		         values (
		        " . $this->vlc_id_cliente. ",
		        '" . $this->vlc_arreglo_datos_xls[$contador][0] . "',
		        " .  $this->vlc_arreglo_datos_xls[$contador][1] . ",
		        '" . $this->vlc_arreglo_datos_xls[$contador][2] . "',
		        '" . $this->vlc_arreglo_datos_xls[$contador][3] . "',
		        '" . $this->vlc_arreglo_datos_xls[$contador][4] . "',
		         " . $this->vlc_arreglo_datos_xls[$contador][5] . ",
		         " . $this->vlc_arreglo_datos_xls[$contador][6] . ",
		         " . $this->vlc_arreglo_datos_xls[$contador][7] . ",
		        '" . $this->vlc_arreglo_datos_xls[$contador][8] . "',
		        '" . $this->vlc_arreglo_datos_xls[$contador][9] . "',		        
		        '" . $this->vlc_arreglo_datos_xls[$contador][10] . "'
		        )";
		        
		        $resultado = FN_RUN_NONQUERY($vlf_sql, $this->vlc_db_conexion );
		        //echo "<br>sql: $vlf_sql  ->$resultado ";
		        $contador++;

	        }
        }        
        return $resultado;
    }
    function MTD_DB_ELIMINAR()
    {
    	$sql="delete from resultados_contables where id_cliente = ".$this->vlc_id_cliente;
		$resultado = FN_RUN_NONQUERY($sql, $this->vlc_db_conexion );
		return $resultado;
    }
    function MTD_DB_ELIMINAR_TOTALES()
    {
        $sql="delete from resultados_contables where id_cliente = ".$this->vlc_id_cliente ." and cta_nombre like '%TOTAL..%'";
                $resultado = FN_RUN_NONQUERY($sql, $this->vlc_db_conexion );
                return $resultado;
    }

    function MTD_OBTENER_DATOS_XLS()
    {
    	error_reporting(0);
    	include_once 'Excel/reader.php';
		//$filename= fopen("test.xls","r");
		$filename= "archivos/".$this->vlc_nombre_archivo;
		$reader=new Spreadsheet_Excel_Reader();
		$reader->setUTFEncoder('iconv');
		$reader->setOutputEncoding('UTF-8');
		
		$reader->read($filename);
		//As data is internally written in UTF-16 encoding, we should specify what should be output encoding. Here comes an issue: this class uses iconv() or mb_convert_encoding() for conversion between encodings. So at least one of hose two should be enabled in PHP. In this case setUTFEncoder() specifies iconv(). We can change the output encoding to windows-1251 for example:
		$reader->setOutputEncoding('CP-1251');
		//Displaying output data
		//N//ow let's output the data read. Information about sheets is stored in boundsheets variable. Here's a code for displaying each sheet's name:
		
		 foreach ($reader->boundsheets as $k=>$sheet)
		 {
		    //echo "\n$k: $sheet";
		 }
		
		// Data of the sheets is stored in sheets variable. For every sheet, a two dimensional array holding table is created. Here's how to print all data.
		$vlf_datos_arreglo= array();
		$contador_columnas=0;
		$contador_filas=0;
		 foreach($reader->sheets as $k=>$data)
		 {
		    //echo "\n\n  wtf is this ->".$reader->boundsheets[$k]."\n\n";
		    	
		    foreach($data['cells'] as $row)
		    {
			$contador_filas=0;
		        foreach($row as $cell)
		        {
				$vlf_datos_arreglo[$contador_columnas][$contador_filas]=$cell;
				$contador_filas++;
				//echo "$cell\t";		
		        }
			$contador_columnas++;
		        //echo "\n";
		    }
		    
		 }
		 $this->vlc_arreglo_datos_xls = $vlf_datos_arreglo;
		 //echo "<pre>";
		 //print_r($this->vlc_arreglo_datos_xls);
		 //echo "</pre>";
    }
	function MTD_RETORNAR_RUTA_PROFUNDIDAD()
	{
		$vlf_ruta_profundida="
		Inicio,index.php;
		Fichas, #;
		Categorias de Reclamos, index.php?seccion=categorias";
		return $vlf_ruta_profundida;
	}
    function MTD_RETORNAR_CODIGO_HTML ()
    {
        return $this->vlc_codigo_html;
    }
}
?>
