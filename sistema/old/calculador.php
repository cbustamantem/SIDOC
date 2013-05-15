<?php
/*
 *****************************************************************************
 * PROGRAMA:	calculo de costos para emision de presupuestos
 * 
 * AUTOR:		Carlos B. TERA S.R.L.
 * 
 * OBJETIVO:	realizar todos los calculos necesarios para obtener un presupuesto 
 * 				aproximado de los servicios de la empresa El Mejor S.A.
 * 
 * OBJETOS:
 ******************************************************************************
 */

include ("includes/conexion.php");
// CARGA DE PARAMETROS

$sql= "SELECT t.rend_area_const_m2_1, 
t.rend_area_const_m2_2,
t.rend_area_const_m2_3,
t.rend_area_const_m2_4,
t.rend_area_const_hs_1,
t.rend_area_const_hs_2,
t.rend_area_const_hs_3,
t.rend_area_const_hs_4,
t.rend_area_libre_m2_1,
t.rend_area_libre_m2_2,
t.rend_area_libre_hs_1,
t.rend_area_libre_hs_2,
t.costo_por_hora,
t.max_m2_construidos,
t.max_m2_libres,
t.ins_cant_papel_toalla_x_mes,
t.ins_costo_papel_toalla,
t.ins_pres_hojas_x_paquete,
t.ins_cant_papel_higienico_x_mes,
t.ins_costo_papel_higienico,
t.ins_pres_metros_x_rollo,
t.ins_cant_jabon_liquido_x_mes,
t.ins_costo_jabon_liquido,
t.ins_pres_ml_x_cartucho
FROM bd_elmejor.tbl_parametros as t ";
	
 $result = mysql_query($sql,$conexion) or die('Error en la transaccion de datos');
 $myrow = mysql_fetch_array($result);
 


//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// DATOS USUARIOS
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$dat_usu_cant_veces_x_semana=0;
$dat_usu_m2_area_construida=0;
$dat_usu_m2_area_libre=0;
$dat_usu_cant_sanitarios=0;
$dat_usu_horas_semanales_solicitadas=0;
$dat_usu_cant_usuarios_insumos=0;
$dat_usu_ins_jabon_liquido=0;
$dat_usu_ins_papel_higienico=0;
$dat_usu_ins_papel_toalla=0;

if (isset($_POST['cant_veces']))
{
	$dat_usu_cant_veces_x_semana= $_POST['cant_veces'];
}
if (isset($_POST['m2_area_construida']))
{
	$dat_usu_m2_area_construida= $_POST['m2_area_construida'];
}
if (isset($_POST['m2_area_libre']))
{
	$dat_usu_m2_area_libre= $_POST['m2_area_libre'];
}
if (isset($_POST['cant_sanitarios']))
{
	$dat_usu_cant_sanitarios= $_POST['cant_sanitarios'];
}
if (isset($_POST['horas_semanales']))
{
	$dat_usu_horas_semanales_solicitadas= $_POST['horas_semanales'];
	$dat_usu_horas_semanales_solicitadas= $dat_usu_horas_semanales_solicitadas /24;
}
if (isset($_POST['cant_usuarios_insumos']))
{
	$dat_usu_cant_usuarios_insumos= $_POST['cant_usuarios_insumos'];
}

if (isset($_POST['ins_jabon_liquido']))
{
	$dat_usu_ins_jabon_liquido= $_POST['ins_jabon_liquido'];
}
if (isset($_POST['ins_papel_higienico']))
{
	$dat_usu_ins_papel_higienico= $_POST['ins_papel_higienico'];
}
if (isset($_POST['ins_papel_toalla']))
{
	$dat_usu_ins_papel_toalla= $_POST['ins_papel_toalla'];
}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// PARAMETROS
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

$par_calc_rend_area_const_m2[0]= $myrow[rend_area_const_m2_1];
$par_calc_rend_area_const_m2[1]= $myrow[rend_area_const_m2_2];
$par_calc_rend_area_const_m2[2]= $myrow[rend_area_const_m2_3];
$par_calc_rend_area_const_m2[3]= $myrow[rend_area_const_m2_4];

$par_calc_rend_area_const_hs[0]= $myrow[rend_area_const_hs_1];
$par_calc_rend_area_const_hs[1]= $myrow[rend_area_const_hs_2];
$par_calc_rend_area_const_hs[2]= $myrow[rend_area_const_hs_3];
$par_calc_rend_area_const_hs[3]= $myrow[rend_area_const_hs_4];


/*
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
================================= 	Calculos		========================================
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

-----------------------------------------------------------------------------
Cantidad de horas semanales para limpieza areas construidas
-----------------------------------------------------------------------------
*/
echo "<hr><h2><u> CALCULOS </u></h2>";
if ($dat_usu_m2_area_construida <= $par_calc_rend_area_const_m2[0])
{
	$calc_limp_area_construida= $par_calc_rend_area_const_hs[0] * $dat_usu_cant_veces_x_semana;
}
else if ($dat_usu_m2_area_construida <= $par_calc_rend_area_const_m2[1])
{
	$calc_limp_area_construida=($dat_usu_m2_area_construida / $par_calc_rend_area_const_hs[1]) * $dat_usu_cant_veces_x_semana;
}
else if($dat_usu_m2_area_construida  <= $par_calc_rend_area_const_m2[2])
{
	$calc_limp_area_construida=($dat_usu_m2_area_construida/ $par_calc_rend_area_const_hs[2]) * $dat_usu_cant_veces_x_semana;
}
else if ($dat_usu_m2_area_construida <=$par_calc_rend_area_const_m2[3])
{
	$calc_limp_area_construida=($dat_usu_m2_area_construida / $par_calc_rend_area_const_hs[3])* $dat_usu_cant_veces_x_semana;;
}

$calc_limp_area_construida= round($calc_limp_area_construida/24,2);

echo "<br> <b>CANTIDAD DE HORAS SEMANALES AREAS CONSTRUIDAS =</b> $calc_limp_area_construida";

/*
-----------------------------------------------------------------------------
Cantidad de horas semanales para limpieza areas libres
-----------------------------------------------------------------------------
*/
//PARAMETROS
//****************************************
$par_calc_rend_area_libre_m2[0]= $myrow[rend_area_libre_m2_1];
$par_calc_rend_area_libre_m2[1]= $myrow[rend_area_libre_m2_2];

$par_calc_rend_area_libre_hs[0]= $myrow[rend_area_libre_hs_1];
$par_calc_rend_area_libre_hs[1]= $myrow[rend_area_libre_hs_2];
//****************************************

if ($dat_usu_m2_area_libre <= $par_calc_rend_area_libre_m2[0])
{
	
	$calc_limp_area_libre=($dat_usu_m2_area_libre / $par_calc_rend_area_libre_m2[0]) * $dat_usu_cant_veces_x_semana;
}
else if($dat_usu_m2_area_libre <= $par_calc_rend_area_libre_m2[1])
{
	
	$calc_limp_area_libre=($dat_usu_m2_area_libre/$par_calc_rend_area_libre_m2[1]) * $dat_usu_m2_area_construida;
}

	$calc_limp_area_libre= round($calc_limp_area_libre /24,2);
	
	echo "<br> <b>CANTIDAD DE HORAS SEMANALES AREAS LIBRES =</b> $calc_limp_area_libre";

/*
-----------------------------------------------------------------------------
Cantidad de horas semnales para mantenimiento de limpieza
-----------------------------------------------------------------------------
*/
	$calc_horas_semanales_solicitadas= $dat_usu_horas_semanales_solicitadas;
	
	echo "<br> <b>HORAS SEMANALES PARA MANTENIMIENTO DE LIMPIEZA =</b> $calc_horas_semanales_solicitadas";
/*
-----------------------------------------------------------------------------
Total de horas semanales
-----------------------------------------------------------------------------
*/
	$calc_horas_semanales_total= $calc_limp_area_construida + $calc_limp_area_libre + $calc_horas_semanales_solicitadas;
	//$calc_horas_semanales_total=3.37;
	echo "<br><HR> <b>TOTAL DE HORAS SEMANALES=</b> $calc_horas_semanales_total";
	
/*
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
================================= 	Costos Totales		========================================
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
-----------------------------------------------------------------------------
Costo de la Mano de obra+ Cargas sociales
-----------------------------------------------------------------------------
Costo por Hora	6451
Maximo de M2 construidos	1000,00
Maximo de M2 areas libres	2000
*/
//PARAMETROS
//****************************************

	$par_cal_costo_por_hora	= $myrow[costo_por_hora];
	$par_cal_max_m2_construidos = $myrow[max_m2_construidos];
	$par_cal_max_m2_libres = $myrow[max_m2_libres];
//****************************************
	echo "<hr><h2><u> COSTOS TOTALES </u></h2>";
	$calc_cost_mano_obra_social = ($calc_horas_semanales_total * 4.33 * $par_cal_costo_por_hora * 24 )*1.3;
	echo "<br><b>COSTO DE LA MANO DE OBRA + CARGAS SOCIALES=</b> ";
	echo number_format($calc_cost_mano_obra_social, 2, ',', '.');
	
	
//************************************
// Papel toalla  por usuario por mes
//************************************
	$par_calc_ins_cant_papel_toalla_x_mes= 	$myrow[ins_cant_papel_toalla_x_mes];
	$par_calc_ins_costo_papel_toalla = 		$myrow[ins_costo_papel_toalla];
	$par_calc_ins_pres_hojas_x_paquete =	$myrow[ins_pres_hojas_x_paquete];

/*
-----------------------------------------------------------------------------
Costo de la Mano de obra+ Cargas sociales
-----------------------------------------------------------------------------

-----------------------------------------------------------------------------
Costo papel toalla
-----------------------------------------------------------------------------
*/
	$calc_costo_total_papel_toalla_x_usuario_x_mes=0;
	if ($dat_usu_ins_papel_toalla == 1)
	{
		$calc_cant_total_papel_toalla_x_usuario_x_mes = $par_calc_ins_cant_papel_toalla_x_mes * $dat_usu_cant_usuarios_insumos;
		$calc_costo_total_papel_toalla_x_usuario_x_mes = ($calc_cant_total_papel_toalla_x_usuario_x_mes / $par_calc_ins_pres_hojas_x_paquete ) * $par_calc_ins_costo_papel_toalla;
		
		echo "<br><b>---------------- COSTO INSUMOS:</b>";
		echo "<br>......................................Costo papel toalla:";
		$calc_costo_total_papel_toalla_x_usuario_x_mes =round($calc_costo_total_papel_toalla_x_usuario_x_mes,2);
		echo number_format($calc_costo_total_papel_toalla_x_usuario_x_mes,2,',','.');
	}
	
/*	
-----------------------------------------------------------------------------
Costo papel higienico
-----------------------------------------------------------------------------
*/
//************************************
// Papel higienico por usuario por mes
//************************************
	$calc_costo_total_papel_higienico_x_usuario_x_mes=0;
	
	if ($dat_usu_ins_papel_higienico == 1)
	{
		$par_calc_ins_cant_papel_higienico_x_mes= $myrow[ins_cant_papel_higienico_x_mes]; 
		$par_calc_ins_costo_papel_higienico = 	$myrow[ins_costo_papel_higienico];
		$par_calc_ins_pres_metros_x_rollo = 	$myrow[ins_pres_metros_x_rollo];
		
		$calc_cant_total_papel_higienico_x_usuario_x_mes = $par_calc_ins_cant_papel_higienico_x_mes * $dat_usu_cant_usuarios_insumos;
		$calc_costo_total_papel_higienico_x_usuario_x_mes = ($calc_cant_total_papel_higienico_x_usuario_x_mes / $par_calc_ins_pres_metros_x_rollo ) * $par_calc_ins_costo_papel_higienico;
		
		echo "<br>......................................Costo papel higienico:";
		$calc_costo_total_papel_higienico_x_usuario_x_mes =round($calc_costo_total_papel_higienico_x_usuario_x_mes,2);
		echo number_format($calc_costo_total_papel_higienico_x_usuario_x_mes,2,',','.');
	}
	
	
/*	
-----------------------------------------------------------------------------
Costo jabon liquido
-----------------------------------------------------------------------------
*/
//************************************
// Jabon liquido por usuario por mes
//************************************
	$calc_costo_total_jabon_liquido_x_usuario_x_mes=0;
	if ($dat_usu_ins_jabon_liquido == 1)
	{
		$par_calc_ins_cant_jabon_liquido_x_mes= $myrow[ins_cant_jabon_liquido_x_mes];
		$par_calc_ins_costo_jabon_liquido = $myrow[ins_costo_jabon_liquido];
		$par_calc_ins_pres_ml_x_cartucho = $myrow[ins_pres_ml_x_cartucho];
		
		$calc_cant_total_jabon_liquido_x_usuario_x_mes = $par_calc_ins_cant_jabon_liquido_x_mes * $dat_usu_cant_usuarios_insumos;
		$calc_costo_total_jabon_liquido_x_usuario_x_mes = ($calc_cant_total_jabon_liquido_x_usuario_x_mes / $par_calc_ins_pres_ml_x_cartucho  ) * $par_calc_ins_costo_jabon_liquido;
		
		echo "<br>......................................Costo jabon liquido:";
		$calc_costo_total_jabon_liquido_x_usuario_x_mes  =round($calc_costo_total_jabon_liquido_x_usuario_x_mes,2);
		echo number_format($calc_costo_total_jabon_liquido_x_usuario_x_mes ,2,',','.');	
	}	
	
	
/*	
-----------------------------------------------------------------------------	
Costo de insumos de sanitarios	
-----------------------------------------------------------------------------
*/
	$calc_costo_total_insumos_x_mes = $calc_costo_total_papel_toalla_x_usuario_x_mes + 	$calc_costo_total_papel_higienico_x_usuario_x_mes+ 	$calc_costo_total_jabon_liquido_x_usuario_x_mes;
	
	echo "<br><b>COSTO DE INSUMOS SANITARIOS = </b> ";
	echo number_format($calc_costo_total_insumos_x_mes, 2, ',', '.');
	
	
/*	
-----------------------------------------------------------------------------	
Costo de productos	
-----------------------------------------------------------------------------
*/
	$calc_costo_productos = $calc_cost_mano_obra_social * 0.1;
	echo "<br><b>COSTO DE PRODUCTOS= </b> ";
	echo number_format($calc_costo_productos , 2, ',', '.');
	
/*	
-----------------------------------------------------------------------------	
Costo de maquinas	
-----------------------------------------------------------------------------
*/
	$calc_costo_maquinas = $calc_costo_total_insumos_x_mes * 0.1;
	echo "<br><b>COSTO DE MAQUINAS= </b> ";
	echo number_format($calc_costo_maquinas , 2, ',', '.');

/*	
-----------------------------------------------------------------------------	
Costo de supervision	
-----------------------------------------------------------------------------
*/
	$calc_costo_supervision = $calc_costo_productos * 0.1;
	echo "<br><b>COSTO DE SUPERVISION= </b> ";
	echo number_format($calc_costo_supervision  , 2, ',', '.');
	
/*	
-----------------------------------------------------------------------------	
Costo de fiscalizacion
-----------------------------------------------------------------------------
*/
	$calc_costo_fiscalizacion = $calc_costo_maquinas * 0.1;
	echo "<br><b>COSTO DE FISCALIZACION= </b> ";
	echo number_format($calc_costo_fiscalizacion  , 2, ',', '.');
	
/*	
-----------------------------------------------------------------------------	
Costo Total
-----------------------------------------------------------------------------
*/
	$calc_cost_total=
		$calc_cost_mano_obra_social +
		$calc_costo_total_insumos_x_mes +
		$calc_costo_productos +
		$calc_costo_maquinas +
		$calc_costo_supervision +
		$calc_costo_fiscalizacion ;
		
		echo "<br><b>COSTO TOTAL= </b> ";
	echo number_format($calc_cost_total  , 2, ',', '.');
		
?>