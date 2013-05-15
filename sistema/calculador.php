<html>
<head>
	<style>
	.cpst-titulo-principal{
		font-family:"Trebuchet MS";
		color:#30704E;
		font-size:18px;
		border-bottom:#CCCCCC dashed 1px;
	}
	.cpst-titulo-secundario{
		font-family:"Trebuchet MS";
		color: #A5CB68;
		font-size:18px;
	}
	.cpst-titulo-terciario{
		font-family: "Trebuchet MS";
		color: #A5CB68;
		font-weight:bold;
	}
	.cpst-texto-contenido{
		text-align:left;
		font-family: "Trebuchet MS";
		color:#888888;
		font-size:13px;
	}
	.cpst-texto-detalle{
		font-family: Tahoma, Arial, sans-serif;
		color: #454545;
		font-size:12px;
	}
	.cpst-texto-detalle2{
		font-family: Tahoma, Arial, sans-serif;
		color: #454545;
		font-size:12px;
		background:#EBEBEB;
		text-align:right;
	}
	a.cpst-link:link{ color:#F5811E; font-family:"Trebuchet MS"; font-size:13px; text-decoration:none;}
	a.cpst-link:visited{ color: #F5811E; font-family:"Trebuchet MS"; font-size:13px; text-decoration:none;}
	a.cpst-link:active{ color: #F5811E;  font-family:"Trebuchet MS"; font-size:13px; text-decoration:none;}
	a.cpst-link:hover{ color: #F5811E; border-bottom:#666666 dashed 1px; font-family:"Trebuchet MS"; font-size:13px;}
	.cpst-correcto{
		background-color:#009900;
		color:#FFFFFF;
		font-family:Verdana, Arial, Helvetica, sans-serif;
		font-size:12px;
	}
	.cpst-advertencia{
		background-color:#FFFF99;
		color:#000000;
		font-family:Verdana, Arial, Helvetica, sans-serif;
		font-size:12px;
	}
	.cpst-atencion{
		background-color:#FF0000;
		color:#FFFFFF;
		font-family:Verdana, Arial, Helvetica, sans-serif;
		font-size:12px;
	}
	.cpst-boton{
		border:1px #000000 solid;
		background-color:#CCCCCC;
		font-family:Arial, Helvetica, sans-serif;
		font-size:12px;
		cursor:pointer;
	}
	.cpst-input{
		border:1px #000000 solid;
		font-family:Arial, Helvetica, sans-serif;
		font-size:12px;
	}
	.cpst-check{
		cursor:pointer;
	}
	.cpst-tabla{
		border:1px solid #030035;
		background: #fff;
		color: #454545;
		font-family: Tahoma, Arial, sans-serif;
		font-size:11px;
	}
	.cpst-tabla-encabezado1{
		background-color:#030035;
		color:#99c1f5;
		font-family:Verdana, Arial, Helvetica, sans-serif;
		font-size:12px;
	}
	.clst-color-oscuro{
		background-color:#030035;
	}
	.clst-color-claro{
		background-color:#99c1f5;
	}
	.clst-color-fondo-documento-en-admin{
		color:#ffffff;
	}
</style>
</head>
<body>
<div align="center">
<table>


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
t.ins_pres_ml_x_cartucho,
t.sfp_hs_semanales1,
t.sfp_hs_semanales2,
t.sfp_hs_semanales3,
t.sfp_supervision1,
t.sfp_supervision2,
t.sfp_supervision3,
t.sfp_fiscalizacion1,
t.sfp_fiscalizacion2,
t.sfp_fiscalizacion3,
t.sfp_productos1,
t.sfp_productos2,
t.sfp_productos3
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
//echo "<hr><h2><u> CALCULOS </u></h2>";
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
	$calc_limp_area_construida=($dat_usu_m2_area_construida / $par_calc_rend_area_const_hs[3])* $dat_usu_cant_veces_x_semana;
}

$calc_limp_area_construida= $calc_limp_area_construida/24;

echo "
<tr>
<td class='cpst-texto-detalle'>
	Cantidad de horas semanales en areas construidas
</td>
<td class='cpst-texto-detalle2'>";
echo number_format($calc_limp_area_construida, 2, ',', '.');
echo"
	
</td>
</tr>
";

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
	$calc_limp_area_libre=($dat_usu_m2_area_libre / $par_calc_rend_area_libre_hs[0]) ;
	$calc_limp_area_libre=  $calc_limp_area_libre * $dat_usu_cant_veces_x_semana;
}
else if($dat_usu_m2_area_libre <= $par_calc_rend_area_libre_m2[1])
{
	
	//$calc_limp_area_libre=($dat_usu_m2_area_libre / $par_calc_rend_area_libre_hs[1]) * $dat_usu_m2_area_construida;
	$calc_limp_area_libre=($dat_usu_m2_area_libre / $par_calc_rend_area_libre_hs[1]) ;
	$calc_limp_area_libre=  $calc_limp_area_libre * $dat_usu_cant_veces_x_semana;
}
    $calc_limp_area_libre = $calc_limp_area_libre /24;
	//$calc_limp_area_libre= round($calc_limp_area_libre,2);
	echo "
		<tr>
		<td class='cpst-texto-detalle'>
			Cantidad de horas semanales en areas libres
		</td>
		<td class='cpst-texto-detalle2'>";
		echo number_format($calc_limp_area_libre, 2, ',', '.');
		echo "
		</td>
		</tr>
		";
	//echo "<br> <b>CANTIDAD DE HORAS SEMANALES AREAS LIBRES =</b> $calc_limp_area_libre";

/*
-----------------------------------------------------------------------------
Cantidad de horas semnales para mantenimiento de limpieza
-----------------------------------------------------------------------------
*/
	$calc_horas_semanales_solicitadas= $dat_usu_horas_semanales_solicitadas;
		echo "
		<tr>
		<td class='cpst-texto-detalle'>
			Cantidad de horas semanales para mantenimiento de limpieza</td>
		<td class='cpst-texto-detalle2'>";
		echo number_format($calc_horas_semanales_solicitadas, 2, ',', '.');
		echo "
		</td>
		</tr>
		";
	//echo "<br> <b>HORAS SEMANALES PARA MANTENIMIENTO DE LIMPIEZA =</b> $calc_horas_semanales_solicitadas";
/*
-----------------------------------------------------------------------------
Total de horas semanales
-----------------------------------------------------------------------------
*/
	$calc_horas_semanales_total= $calc_limp_area_construida + $calc_limp_area_libre + $calc_horas_semanales_solicitadas;
	//$calc_horas_semanales_total=3.37;
	echo "
		<tr>
		<td class='cpst-texto-detalle' aling='left'>
			<b>Total de Horas Semanales</b></td>
		<td class='cpst-texto-detalle2'>";
		echo number_format($calc_horas_semanales_total, 2, ',', '.');
		echo "	 
		</td>
		</tr>
		";
	//echo "<br><HR> <b>TOTAL DE HORAS SEMANALES=</b> $calc_horas_semanales_total";
	
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
echo "
		<tr>
			<td class='cpst-texto-detalle' aling='center' colspan='2'>
				<br><b>Costos Totales</b> <br>
				....................................
			</td>		
		</tr>
		";
	    $calc_cost_mano_obra_social = ($calc_horas_semanales_total * 4.33 * $par_cal_costo_por_hora * 24 )*1.3;
		echo "
		<tr>
		<td class='cpst-texto-detalle' aling='left'>
			Costo de la mano de obra + cargas sociales</td>
		<td class='cpst-texto-detalle2'>";
		echo number_format($calc_cost_mano_obra_social, 0, ',', '.');
		echo "</td></tr>";

//	echo "<br><b>COSTO DE LA MANO DE OBRA + CARGAS SOCIALES=</b> ";
	
	
	
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
		
		
		//echo "<br><b>---------------- COSTO INSUMOS:</b>";
		//echo "<br>......................................Costo papel toalla:";
		$calc_costo_total_papel_toalla_x_usuario_x_mes =round($calc_costo_total_papel_toalla_x_usuario_x_mes,2);
		//echo number_format($calc_costo_total_papel_toalla_x_usuario_x_mes,2,',','.');
		echo "
		<tr>
		<td class='cpst-texto-detalle' aling='left'>
			<li>Papel Toalla</li></td>
		<td class='cpst-texto-detalle2'>";			 
		echo number_format($calc_costo_total_papel_toalla_x_usuario_x_mes,2,',','.');
		echo "</td>
		</tr>
		";
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
	
		
		//echo "<br>......................................Costo papel higienico:";
		$calc_costo_total_papel_higienico_x_usuario_x_mes =round($calc_costo_total_papel_higienico_x_usuario_x_mes,2);
		
				echo "
		<tr>
		<td class='cpst-texto-detalle' aling='left'>
			<li>Papel Higienico</li></td>
		<td class='cpst-texto-detalle2'>";			 
		echo number_format($calc_costo_total_papel_higienico_x_usuario_x_mes,0,',','.');
		echo "</td>
		</tr>
		";
		
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
		
		//echo "<br>......................................Costo jabon liquido:";
		$calc_costo_total_jabon_liquido_x_usuario_x_mes  =round($calc_costo_total_jabon_liquido_x_usuario_x_mes,2);

		echo "
		<tr>
		<td class='cpst-texto-detalle' aling='left'>
			<li>Jabon Liquido</li></td>
		<td class='cpst-texto-detalle2'>";			 
		echo number_format($calc_costo_total_jabon_liquido_x_usuario_x_mes ,0,',','.');
		echo "</td>
		</tr>
		";	
	}	
	
	
/*	
-----------------------------------------------------------------------------	
Costo de insumos de sanitarios	
-----------------------------------------------------------------------------
*/
	$calc_costo_total_insumos_x_mes = $calc_costo_total_papel_toalla_x_usuario_x_mes + 	$calc_costo_total_papel_higienico_x_usuario_x_mes+ 	$calc_costo_total_jabon_liquido_x_usuario_x_mes;
	
	echo "
		<tr>
			<td class='cpst-texto-detalle' aling='center' >
				Costos totales de insumos sanitarios
			</td>		
			<td class='cpst-texto-detalle2'>";
	echo number_format($calc_costo_total_insumos_x_mes,0, ',', '.');			
	echo"		</td>
		</tr>
		";	
	//echo "<br><b>COSTO DE INSUMOS SANITARIOS = </b> ";

	
	
/*	
-----------------------------------------------------------------------------	
Costo de productos	
-----------------------------------------------------------------------------
*/
	
	$par_calc_sfp_hs_semanales1 = $myrow[sfp_hs_semanales1];
	$par_calc_sfp_hs_semanales2 = $myrow[sfp_hs_semanales2];
	$par_calc_sfp_hs_semanales3 = $myrow[sfp_hs_semanales3];

	$par_calc_sfp_supervision1 = $myrow[sfp_supervision1];
	$par_calc_sfp_supervision2 = $myrow[sfp_supervision2];
	$par_calc_sfp_supervision3 = $myrow[sfp_supervision3];
	
    $par_calc_sfp_fiscalizacion1 = $myrow[sfp_fiscalizacion1];
    $par_calc_sfp_fiscalizacion2 = $myrow[sfp_fiscalizacion2];
    $par_calc_sfp_fiscalizacion3 = $myrow[sfp_fiscalizacion3];
    
    $par_calc_sfp_productos1 = $myrow[sfp_productos1];
    $par_calc_sfp_productos2 = $myrow[sfp_productos2];
    $par_calc_sfp_productos3 = $myrow[sfp_productos3];
	
	//$calc_costo_productos = $calc_cost_mano_obra_social * 0.1;
	//echo "<br><b>COSTO DE PRODUCTOS= </b> ";
	//$calc_cost_mano_obra_social
	//$calc_horas_semanales_total
	
	
	/*SI({Total de horas semanales}<=$'$par_calc_sfp_hs_semanales2;
	{COSTO DE MANO DE OBRA + CARGA SOCIAL}*$par_calc_sfp_productos2;

	SI({Total de horas semanales}<=$par_calc_sfp_hs_semanales3;
		$Calculos.B8*$par_calc_sfp_productos3;0))
*/
    if ($calc_horas_semanales_total <= $par_calc_sfp_hs_semanales2)
    {
        $calc_costo_productos= $calc_cost_mano_obra_social * $par_calc_sfp_productos2;
    }
	else if ($calc_horas_semanales_total <= $par_calc_sfp_hs_semanales3)
    {
        $calc_costo_productos= $calc_cost_mano_obra_social * $par_calc_sfp_productos3;
    }
	
	echo "
		<tr>
			<td class='cpst-texto-detalle' aling='center' >
				Costos de los productos
			</td>		
			<td class='cpst-texto-detalle2'>";
	echo number_format($calc_costo_productos , 0, ',', '.');			
	echo"		</td>
		</tr>
		";	
	
/*	
-----------------------------------------------------------------------------	
Costo de maquinas	
-----------------------------------------------------------------------------
*/
	
	$calc_costo_maquinas = $calc_cost_mano_obra_social * 0.05;
	
	//echo "<br><b>COSTO DE MAQUINAS= </b> ";
	
	echo "
		<tr>
			<td class='cpst-texto-detalle' aling='center' >
				Costos de las maquinas
			</td>		
			<td class='cpst-texto-detalle2'>";
	echo number_format($calc_costo_maquinas ,0, ',', '.');			
	echo"		</td>
		</tr>
		";	
	

/*	
-----------------------------------------------------------------------------	
Costo de supervision	
-----------------------------------------------------------------------------
SI({Total de horas semanales}<=$par_calc_sfp_hs_semanales1;
	$par_calc_sfp_supervision1
SI({Total de horas semanales}<=$par_calc_sfp_hs_semanales2;
	$par_calc_sfp_supervision2;
SI({Total de horas semanales}<=$par_calc_sfp_hs_semanales3;
	$par_calc_sfp_supervision3;;0)))

//$calc_cost_mano_obra_social
	//$calc_horas_semanales_total

*/
    $calc_costo_supervision=0;
	if ($calc_horas_semanales_total <= $par_calc_sfp_hs_semanales1)
	{
	    	$calc_costo_supervision = $par_calc_sfp_supervision1;
	}
	else if ($calc_horas_semanales_total <= $par_calc_sfp_hs_semanales2)
	{
	    	$calc_costo_supervision = $par_calc_sfp_supervision2;
	}
    else if ($calc_horas_semanales_total <= $par_calc_sfp_hs_semanales3)
	{
	    	$calc_costo_supervision = $par_calc_sfp_supervision3;
	}
	echo "
		<tr>
			<td class='cpst-texto-detalle' aling='center' >
				Costos de supervision
			</td>		
			<td class='cpst-texto-detalle2'>";
	echo number_format($calc_costo_supervision  , 0, ',', '.');			
	echo"		</td>
		</tr>
		";	
	
	
/*	
-----------------------------------------------------------------------------	
Costo de fiscalizacion
-----------------------------------------------------------------------------
*/
	//$calc_costo_fiscalizacion = $calc_costo_maquinas * 0.1;
	//echo "<br><b>COSTO DE FISCALIZACION= </b> ";
	$calc_costo_fiscalizacion =0;
	if ($calc_horas_semanales_total <= $par_calc_sfp_hs_semanales1)
	{
	    	$calc_costo_fiscalizacion  = $par_calc_sfp_fiscalizacion1;
	}
	else if ($calc_horas_semanales_total <= $par_calc_sfp_hs_semanales2)
	{
	    	$calc_costo_fiscalizacion  = $par_calc_sfp_fiscalizacion2;
	}
	else if ($calc_horas_semanales_total <= $par_calc_sfp_hs_semanales3)
	{
	    	$calc_costo_fiscalizacion  = $par_calc_sfp_fiscalizacion3;
	}

	echo "
		<tr>
			<td class='cpst-texto-detalle' aling='center' >
				Costos de fiscalizaci&oacute;n
			</td>		
			<td class='cpst-texto-detalle2'>";
	echo number_format($calc_costo_fiscalizacion  , 0, ',', '.');			
	echo"		</td>
		</tr>
		";
	
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
		
		//echo "<br><b>COSTO TOTAL= </b> ";
		
		echo "
		<tr>
			<td colspan='2'>
				&nbsp
			</td>
		</tr>
		<tr>
			<td colspan='2'>
				<hr>
			</td>
		</tr>
		<tr>
			<td class='cpst-texto-detalle' aling='center' >
				<b>Costo total</b>
			</td>		
			<td class='cpst-texto-detalle2'> <b> Gs. ";
		echo number_format($calc_cost_total  , 0, ',', '.');			
		echo"		</b></td>
		</tr>
		";
	
		
?>



</table>
</body>
</html>
