<?php
function FN_HTML_ARMAR_GRILLA ($vp_titulo, $vp_datos, $vp_css_titulos, $vp_css_filas_datos, $vp_css_columnas_datos, $visualizar, $modificar, $eliminar, $lnk_visualizar, $lnk_modificar, $lnk_eliminar, $corregir = false, $lnk_corregir = 'false')
{
    // ------------------------------------------------------------------------
    $indice;
    $indiceColumna;
    $cantidadColumnas;
    $cantidadFilas;
    $eventosFila;
    $html;
    $encabezadoLista;
    $cuerpoLista;
    $opciones;
    $pieLista;
    // ------------------------------------------------------------------------
    // RESUMEN:
    // =======
    // Obtener la cantidad de columnas en la variable 
    // Armar el encabezado de la lista
    // Armar el cuerpo de la lista o grilla
    // Armar el pie de la lista
    // Componer la lista con el encabezado, cuerpo y pie
    // DESARROLLO:
    // ==========
    // Obteniendo la cantidad de columnas en la variable
    // ************************************************************	
    $cantidadColumnas = sizeof($vp_titulo);
    // Armando el encabezado de la lista
    // ************************************************************	
    $encabezadoLista = "<fieldset class='etiqueta_fieldset'><table width='100%' border='0'><tr>";
    for ($indice = 0; $indice < $cantidadColumnas; $indice ++)
        $encabezadoLista .= "<td class='" . $vp_css_titulos[$indice] . "'>" . $vp_titulo[$indice] . "</td>";
    $encabezadoLista .= "<td class='columna_opciones titulo_listado'>Opciones</td></tr></table>";
    // Armando el cuerpo de la lista
    // ************************************************************
    $cuerpoLista = "<table width='100%' border='0'>";
    $cantidadFilas = sizeof($vp_datos);
    $eventosFila = " onMouseOver='resaltarFocoFila( this )' onClick=\"examinarItem( '$lnk_visualizar', this )\">";
    for ($indice = 0; $indice < $cantidadFilas; $indice ++)
    {
        if ($indice % 2 == 0) $cuerpoLista .= "<tr class='" . $vp_css_filas_datos[0] . "'";
        else
            $cuerpoLista .= "<tr class='" . $vp_css_filas_datos[1] . "'";
        $cuerpoLista .= $eventosFila;
        for ($indiceColumna = 0; $indiceColumna < $cantidadColumnas; $indiceColumna ++)
            $cuerpoLista .= "<td class='" . $vp_css_columnas_datos[$indiceColumna] . "'>" . $vp_datos[$indice][$indiceColumna] . "</td>";
        $opciones = armarOpcionesGrilla($vp_datos[$indice][0], $visualizar, $corregir, $modificar, $eliminar, $lnk_visualizar, $lnk_corregir, $lnk_modificar, $lnk_eliminar);
        $cuerpoLista .= "<td class='columna_opciones'>" . $opciones . "</td></tr>";
    }
    // Armando el pie de la lista
    // ************************************************************		
    $pieLista = "</table></fieldset>";
    // Componiendo la lista con el encabezado, cuerpo y pie
    // ************************************************************	
    $html = $encabezadoLista . $cuerpoLista . $pieLista;
    return ($html);
}

/** Descripciï¿½n	: arma el HTML de las opciones en las listas de datos
 * 
 * Argumentos	:
 * 
 * 				- <i>$id_elemento</i>:		valor numï¿½rico que representa el identificador
 * 											del elemento a tratar; por ejemplo el identificador
 * 											de una Clase cargada por el profesor.
 *  
 * 				- <i>$visualizar</i>:		valor booleano (true/false) que indica si se muestra
 * 											la opciï¿½n "visualizar". 
 * 				- <i>$visualizar</i>:		valor booleano (true/false) que indica si se muestra
 * 											la opciï¿½n "corregir".
 *  
 * 				- <i>$modificar</i>:		valor booleano (true/false) que indica si se muestra
 * 											la opciï¿½n "modificar". 
 * 
 * 				- <i>$eliminar</i>:			valor booleano (true/false) que indica si se muestra
 * 											la opciï¿½n "eliminar". 
 * 
 * 				- <i>$lnk_visualizar</i>:	cadena que se usarï¿½ como enlace (link) para la opciï¿½n
 * 											"visualizar". 
 * 
 * 				- <i>$lnk_corregir</i>:		cadena que se usarï¿½ como enlace (link) para la opciï¿½n
 * 											"corregir" 
 * 
 * 				- <i>$lnk_modificar</i>:	cadena que se usarï¿½ como enlace (link) para la opciï¿½n
 * 											"modificar".
 * 
 * 				- <i>$lnk_eliminar</i>:		cadena que se usarï¿½ como enlace (link) para la opciï¿½n
 * 											"eliminar".  
 * 
 * Ejemplo		: 	
 * 					
 *					$opciones= armarOpcionesGrilla( 
 * 														2								,
 * 														TRUE							,
 * 														FALSE							, 
 * 														TRUE							, 
 * 														FALSE							, 
 * 														"index.php?operacion=guardar"	, 
 * 														"index.php?operacion=corregir"	,
 * 														"index.php?operacion=modificar"	, 
 * 														"index.php?operacion=eliminar" 
 * 												  );
 *  					
 * 
 * 					
 * 
 * @return cadena que representa el cÃ³digo HTML
 */
function armarOpcionesGrilla($id_elemento, $visualizar, $corregir, $modificar, $eliminar, $lnk_visualizar, $lnk_corregir, $lnk_modificar, $lnk_eliminar)
{
	// ----------------------------------------------------------------------------------------------------
	

	$html;
	
	// ----------------------------------------------------------------------------------------------------	
	

	$html = "<table width='100%' cellspacing='0' cellpadding='0'><tr>";
	
	if ($visualizar == TRUE)
		$html .= "<td><a href='" . $lnk_visualizar . "&codigo=$id_elemento'><img src='archivos_de_disenho/imagenes/bt_visualizar.png' border='0'/></a></td>";
	
	if ($corregir == TRUE)
		$html .= "<td><a href='" . $lnk_corregir . "&codigo=$id_elemento'><img src='archivos_de_disenho/imagenes/lapiz.gif' border='0'/></a></td>";
	
	if ($modificar == TRUE)
		$html .= "<td><a href='" . $lnk_modificar . "&codigo=$id_elemento'><img src='archivos_de_disenho/imagenes/bt_editar.png' border='0'/></a></td>";
	
	if ($eliminar == TRUE)
		$html .= "<td><a href=\"javascript:eliminarItem( '$lnk_eliminar', $id_elemento )\"><img src='archivos_de_disenho/imagenes/bt_eliminar.png' border='0'/></a></td>";
	
	$html .= "</tr></table>";
	
	return ($html);
}
function FN_HTML_ARMAR_GRILLA2 ($vp_titulo, $vp_datos, $vp_css_titulos, $vp_css_filas_datos, $vp_css_columnas_datos, $visualizar, $modificar, $eliminar, $lnk_visualizar, $lnk_modificar, $lnk_eliminar, $corregir = false, $lnk_corregir = 'false')
{
    // ------------------------------------------------------------------------
    $indice;
    $indiceColumna;
    $cantidadColumnas;
    $cantidadFilas;
    $eventosFila;
    $html;
    $encabezadoLista;
    $cuerpoLista;
    $opciones;
    $pieLista;
    // ------------------------------------------------------------------------
    // RESUMEN:
    // =======
    // Obtener la cantidad de columnas en la variable 
    // Armar el encabezado de la lista
    // Armar el cuerpo de la lista o grilla
    // Armar el pie de la lista
    // Componer la lista con el encabezado, cuerpo y pie
    // DESARROLLO:
    // ==========
    // Obteniendo la cantidad de columnas en la variable
    // ************************************************************	
    $cantidadColumnas = sizeof($vp_titulo);
    // Armando el encabezado de la lista
    // ************************************************************	
    $encabezadoLista = "<table width='500' border='0' id='table' class='sortable' style='background:#FFFFFF;'>
    <thead>
			<tr>				
    ";
    for ($indice = 0; $indice < $cantidadColumnas; $indice ++)
    {
        $encabezadoLista .= "<th><h3>" . $vp_titulo[$indice] . "</h3></th>";
    }    
    $encabezadoLista .= "<th><h3>Opciones</h3></th>";
    $encabezadoLista .= "</tr>
		</thead>";
    // Armando el cuerpo de la lista
    // ************************************************************
    $cuerpoLista = "<tbody>";
    $cantidadFilas = sizeof($vp_datos);
    $eventosFila = "";
    for ($indice = 0; $indice < $cantidadFilas; $indice ++)
    {
        if ($indice % 2 == 0) $cuerpoLista .= "<tr> ";
        else
            $cuerpoLista .= "<tr> ";
        $cuerpoLista .= $eventosFila;
        for ($indiceColumna = 0; $indiceColumna < $cantidadColumnas; $indiceColumna ++)
            $cuerpoLista .= "<td class='cpst-texto-contenido'>" . $vp_datos[$indice][$indiceColumna] . "</td>";
        $opciones = armarOpcionesGrilla($vp_datos[$indice][0], $visualizar, $corregir, $modificar, $eliminar, $lnk_visualizar, $lnk_corregir, $lnk_modificar, $lnk_eliminar);
        $cuerpoLista .= "<td>" . $opciones . "</td></tr>";
    }
    // Armando el pie de la lista
    // ************************************************************		
    $pieLista = "</tbody></table>";
    $pieLista .='<div id="controls">
		<div id="perpage">
			<select onchange="sorter.size(this.value)">
			<option value="5">5</option>
				<option value="10" selected="selected">10</option>
				<option value="20">20</option>
				<option value="50">50</option>
				<option value="100">100</option>
			</select>
			<span>Registros por Pagina</span>
		</div>
		<div id="navigation">
			<img src="archivos_de_disenho/imagenes/first.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1,true)" />
			<img src="archivos_de_disenho/imagenes/previous.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1)" />
			<img src="archivos_de_disenho/imagenes/next.gif" width="16" height="16" alt="First Page" onclick="sorter.move(1)" />
			<img src="archivos_de_disenho/imagenes/last.gif" width="16" height="16" alt="Last Page" onclick="sorter.move(1,true)" />
		</div>
		<div id="text"> <span id="currentpage"></span>  <span id="pagelimit"></span></div>
	</div>
	<script type="text/javascript">
  var sorter = new TINY.table.sorter("sorter");
	sorter.head = "head";
	sorter.asc = "asc";
	sorter.desc = "desc";
	sorter.even = "evenrow";
	sorter.odd = "oddrow";
	sorter.evensel = "evenselected";
	sorter.oddsel = "oddselected";
	sorter.paginate = true;
	sorter.currentid = "currentpage";
	sorter.limitid = "pagelimit";
	sorter.init("table");
  </script>
	';
    
    // Componiendo la lista con el encabezado, cuerpo y pie
    // ************************************************************	
    $html = $encabezadoLista . $cuerpoLista . $pieLista;
    return ($html);
}
function FN_HTML_ARMAR_GRILLA3 ($vp_titulo, $vp_datos, $vp_css_titulos, $vp_css_filas_datos, $vp_css_columnas_datos, $visualizar, $modificar, $eliminar, $lnk_visualizar, $lnk_modificar, $lnk_eliminar, $corregir = false, $lnk_corregir = 'false')
{
    // ------------------------------------------------------------------------
    $indice;
    $indiceColumna;
    $cantidadColumnas;
    $cantidadFilas;
    $eventosFila;
    $html;
    $encabezadoLista;
    $cuerpoLista;
    $opciones;
    $pieLista;
    // ------------------------------------------------------------------------
    // RESUMEN:
    // =======
    // Obtener la cantidad de columnas en la variable 
    // Armar el encabezado de la lista
    // Armar el cuerpo de la lista o grilla
    // Armar el pie de la lista
    // Componer la lista con el encabezado, cuerpo y pie
    // DESARROLLO:
    // ==========
    // Obteniendo la cantidad de columnas en la variable
    // ************************************************************	
    $cantidadColumnas = sizeof($vp_titulo);
    // Armando el encabezado de la lista
    // ************************************************************	
    $encabezadoLista = "<table width='500' border='0' id='table' class='sortable' style='background:#FFFFFF;'>
    <thead>
			<tr>				
    ";
    for ($indice = 0; $indice < $cantidadColumnas; $indice ++)
    {
        $encabezadoLista .= "<th><h3>" . $vp_titulo[$indice] . "</h3></th>";
    }    
    $encabezadoLista .= "";
    $encabezadoLista .= "</tr>
		</thead>";
    // Armando el cuerpo de la lista
    // ************************************************************
    $cuerpoLista = "<tbody>";
    $cantidadFilas = sizeof($vp_datos);
    $eventosFila = "";
    for ($indice = 0; $indice < $cantidadFilas; $indice ++)
    {
        if ($indice % 2 == 0) $cuerpoLista .= "<tr> ";
        else
            $cuerpoLista .= "<tr> ";
        $cuerpoLista .= $eventosFila;
        for ($indiceColumna = 0; $indiceColumna < $cantidadColumnas; $indiceColumna ++)
            $cuerpoLista .= "<td class='cpst-texto-contenido'>" . $vp_datos[$indice][$indiceColumna] . "</td>";
        //$opciones = armarOpcionesGrilla($vp_datos[$indice][0], $visualizar, $corregir, $modificar, $eliminar, $lnk_visualizar, $lnk_corregir, $lnk_modificar, $lnk_eliminar);
        $cuerpoLista .= "</tr>";
    }
    // Armando el pie de la lista
    // ************************************************************		
    $pieLista = "</tbody></table>";
    $pieLista .='<div id="controls">
		<div id="perpage">
			<select onchange="sorter.size(this.value)">
			<option value="5">5</option>
				<option value="10" selected="selected">10</option>
				<option value="20">20</option>
				<option value="50">50</option>
				<option value="100">100</option>
			</select>
			<span>Registros por Pagina</span>
		</div>
		<div id="navigation">
			<img src="archivos_de_disenho/imagenes/first.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1,true)" />
			<img src="archivos_de_disenho/imagenes/previous.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1)" />
			<img src="archivos_de_disenho/imagenes/next.gif" width="16" height="16" alt="First Page" onclick="sorter.move(1)" />
			<img src="archivos_de_disenho/imagenes/last.gif" width="16" height="16" alt="Last Page" onclick="sorter.move(1,true)" />
		</div>
		<div id="text"> <span id="currentpage"></span>  <span id="pagelimit"></span></div>
	</div>
	<script type="text/javascript">
  var sorter = new TINY.table.sorter("sorter");
	sorter.head = "head";
	sorter.asc = "asc";
	sorter.desc = "desc";
	sorter.even = "evenrow";
	sorter.odd = "oddrow";
	sorter.evensel = "evenselected";
	sorter.oddsel = "oddselected";
	sorter.paginate = true;
	sorter.currentid = "currentpage";
	sorter.limitid = "pagelimit";
	sorter.init("table");
  </script>
	';
    
    // Componiendo la lista con el encabezado, cuerpo y pie
    // ************************************************************	
    $html = $encabezadoLista . $cuerpoLista . $pieLista;
    return ($html);
}
?>