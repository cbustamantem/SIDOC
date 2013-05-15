<?php
include ('includes/FN_GENERALES.php');
include ('includes/FN_DB_CONEXION.php');
include ('class_marcaciones.php');
$vpp_db_conexion = FN_DB_CONEXION();
$vlp_marcaciones = array();
$obj_marcaciones = new CLASS_MARCACIONES($vpp_db_conexion);
$obtener_datos = false;
$vlp_filtro_codoperacion = "";
$vlp_filtro_codpersona = "";
$vlp_filtro_nombre = "";
$vlp_filtro_fecha_desde = "";
$vlp_filtro_fecha_hasta = "";
$vlp_filtro_codubicacion = "";
if (isset($_REQUEST['tb_fecha_desde']))
{
    $vlp_filtro_fecha_desde = $_REQUEST['tb_fecha_desde'];
}
if (isset($_REQUEST['tb_fecha_hasta']))
{
    $vlp_filtro_fecha_hasta = $_REQUEST['tb_fecha_hasta'];
}
if (($vlp_filtro_fecha_desde != "") && ($vlp_filtro_fecha_hasta != ""))
{
    $obj_marcaciones->MTD_FILTRAR_FECHA($vlp_filtro_fecha_desde, $vlp_filtro_fecha_hasta);
    //echo "<BR>OBTENER DATOS";
    $obtener_datos = true;
}
if (isset($_REQUEST['lst_codoperacion']))
{
    $vlp_filtro_codoperacion = $_REQUEST['lst_codoperacion'];
    if ($vlp_filtro_codoperacion != "")
    {
        $obj_marcaciones->MTD_FILTRAR_CODOPERACION($vlp_filtro_codoperacion);
    }
}
if (isset($_REQUEST['lst_codpersona']))
{
    $vlp_filtro_codpersona = $_REQUEST['lst_codpersona'];
    if ($vlp_filtro_codpersona != "")
    {
        $obj_marcaciones->MTD_FILTRAR_CODPERSONA($vlp_filtro_codpersona);
    }
    echo "<BR CODPERSONA++".$vlp_filtro_codpersona;
}
if (isset($_REQUEST['lst_nombre']))
{
    $vlp_filtro_nombre = $_REQUEST['lst_nombre'];
    if ($vlp_filtro_nombre != "")
    {
        $obj_marcaciones->MTD_FILTRAR_NOMBRE($vlp_filtro_nombre);
    }
}
if (isset($_REQUEST['lst_ubicacion']))
{    
    $vlp_filtro_codubicacion = $_REQUEST['lst_ubicacion'];
    if ($vlp_filtro_codubicacion != "")
    {
        $obj_marcaciones->MTD_FILTRAR_UBICACION($vlp_filtro_codubicacion);
    }
}
if ($obtener_datos == true)
{
    $arreglo_datos = $obj_marcaciones->MTD_LISTAR_MARCACIONES();
    $arreglo_operaciones = FN_OBTENER_DATOS_ARREGLO($arreglo_datos, 1);
    //echo "<BR> OPERACIONES </>";   print_r($arreglo_operaciones);
    $arreglo_codpersonas = FN_OBTENER_DATOS_ARREGLO($arreglo_datos, 2);
    //echo "<BR> PERSONAS </>";   print_r($arreglo_codpersonas);
    $arreglo_codubicacion = FN_OBTENER_DATOS_ARREGLO($arreglo_datos, 5);
    //echo "<BR> UBICACIONES</>";   print_r($arreglo_codubicacion);
    $arreglo_nombres = FN_OBTENER_DATOS_ARREGLO($arreglo_datos, 7);

	//ORDEN DE LOS ARREGLOS

	sort($arreglo_nombres);
	sort($arreglo_operaciones);
	sort($arreglo_codpersonas);
	sort($arreglo_codubicacion);
    //echo "<BR> NOMBRES</>";   print_r($arreglo_nombres);
}
?>

<html>
<head>
<title>Consulta de Marcaciones</title>

<link type="text/css" rel="stylesheet"	href="css/datepickercontrol_bluegray.css">
<link type="text/css" rel="stylesheet"	href="css/style.css">
<script type="text/javascript" src="javascript/datepickercontrol.js"></script>
</head>
<body>
<form id="frm_reporteador" action=" <?=$_SERVER['PHP_SELF']?>"
	method="post" onsubmit="return submitForm();">
<table border="0">
	<tr>
		<td align="left"><label> Fecha desde </label></td>
		<td align="left" colspan="5"><input type="text" name="tb_fecha_desde"
			id="tb_fecha_desde" size="13" class="flatedit" datepicker="true"
			datepicker_format="MM/DD/YYYY"
			<?
if ($vlp_filtro_fecha_desde != "")
{
    echo "value='$vlp_filtro_fecha_desde'";
}
?>> </input></td>
	</tr>
	<tr>
		<td align="left"><label> Fecha hasta </label></td>
		<td align="left"><input type="text" name="tb_fecha_hasta"
			id="tb_fecha_hasta" size="13" class="flatedit" datepicker="true"
			datepicker_format="MM/DD/YYYY"
			<?
if ($vlp_filtro_fecha_hasta != "")
{
    echo "value='$vlp_filtro_fecha_hasta'";
}
?>> </input></td>
		<td align="left" colspan="4"><input type="submit" name="Enviar_Fecha"
			value="Obtener Datos"></td>
	</tr>
</table>
<table class="sample">
	<tr>
		<td align="left"><label> Id Persona</label></td>
		<td align="left"><label> Operaci&oacute;n</label> <br>		
		<select name="lst_codoperacion">
			<option value="">---------</option>
			<?
			   FN_IMPRIMIR_OPCIONES($arreglo_operaciones, $vlp_filtro_codoperacion);
            ?>
					</select></td>
		<td align="left"><label> Cod. Persona</label> <br>
		<select name="lst_codpersona">
			<option value="">---------</option>
			<?
                FN_IMPRIMIR_OPCIONES($arreglo_codpersonas, $vlp_filtro_codpersona);
            ?>
					</select></td>
		<td align="left"><label> Categoria</label></td>
		<td align="left"><label> Numero Linea</label></td>
		<td align="left"><label> Cod. Ubicaci&oacute;n</label> <br>
		<select name="lst_ubicacion">
			<option value="">---------</option>
			<?
                FN_IMPRIMIR_OPCIONES($arreglo_codubicacion, $vlp_filtro_codubicacion);
            ?>
					</select></td>
		<td align="left"><label> Fecha</label></td>
		<td align="left"><label> Nombre </label> <br>
		<select name="lst_nombre">
			<option value="">---------</option>
			<?
                FN_IMPRIMIR_OPCIONES($arreglo_nombres, $vlp_filtro_nombre);
             ?>						
					</select></td>
	
	
		
		
		<td align="left"><label> Tel. Particular</label></td>		
	</tr>
	<!-- CICLO ITERATIVO PARA VISUALIZAR DATOS -->
	<?
	$contador=0;
	$cantidad_registros= sizeof($arreglo_datos);
	$estilo1=" style='background:#F0F0FF;'";
	$estilo2=" style='background:#9DB7CE;'";
    while ($contador < $cantidad_registros)
    {
        if ($contador % 2)
        {
            echo "<TR".$estilo1.">";
        }
        else 
        {
            echo "<TR".$estilo2.">";
        }
        echo '<td align="left">';
        echo $arreglo_datos[$contador][0];
        echo '</td>';
        echo '<td align="left" >';
        echo $arreglo_datos[$contador][1];
        echo '</td>';
        echo '<td align="left">';
        echo $arreglo_datos[$contador][2];
        echo '</td>';
        echo '<td align="left">';
        echo $arreglo_datos[$contador][3];
        echo '</td>';
        echo '<td align="left">';
        echo $arreglo_datos[$contador][4];
        echo '</td>';
        echo '<td align="left">';
        echo $arreglo_datos[$contador][5];
        echo '</td>';
        echo '<td align="left">';
        echo $arreglo_datos[$contador][6];
        echo '</td>';
        echo '<td align="left">';
        echo $arreglo_datos[$contador][7];
        echo '</td>';               
        echo '<td align="left">';
        echo $arreglo_datos[$contador][8];
        echo '</td>';
       
        echo '</tr>';
        $contador++;        
    }
	?>
	
</table>
</form>
</body>
</html>
<?
//print_r($arreglo_datos);
?>
					
