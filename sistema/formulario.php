<html>
<head>
	<title>  </title>
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
<form action="calculador.php" method="POST">
<div align="center">
<table>
	<tr>
		<td align="left" class="cpst-texto-detalle"> Cantidad de veces a la semana </td>
		<td align="left"> <input type="text" name="cant_veces" class="cpst-input"> </td>
	</tr>
	<tr>
		<td align="left" class="cpst-texto-detalle"> Metros cuadrados de area construida </td>
		<td align="left" class="cpst-texto-detalle"> <select name="m2_area_construida" class="cpst-input">
			<option value="50"> 50 m2 </option>
			<option value="100"> 100 m2 </option>
			<option value="150"> 150 m2 </option>		
			<option value="200"> 200 m2 </option>
			<option value="250"> 250 m2 </option>
			<option value="300"> 300 m2 </option>
			<option value="350"> 350 m2 </option>
			<option value="400"> 400 m2 </option>
			<option value="450"> 450 m2 </option>
			<option value="500"> 500 m2 </option>
			<option value="550"> 550 m2 </option>
			<option value="600"> 600 m2 </option>
			<option value="650"> 650 m2 </option>
			<option value="700"> 700 m2 </option>
			<option value="750"> 750 m2 </option>
			<option value="800"> 800 m2 </option>
			<option value="850"> 850 m2 </option>
			<option value="900"> 900 m2 </option>
			<option value="950"> 950 m2 </option>
			<option value="1000"> 1000 m2 </option>
			</select>
			</td>
	</tr>
	<tr>
		<td align="left" class="cpst-texto-detalle"> Metros cuadrados de area libre </td>
		<td align="left"> <select name="m2_area_libre" class="cpst-input">
			<option value="0"> --------- </option>
			<option value="50"> 50 m2 </option>
			<option value="100"> 100 m2 </option>
			<option value="150"> 150 m2 </option>		
			<option value="200"> 200 m2 </option>
			<option value="250"> 250 m2 </option>
			<option value="300"> 300 m2 </option>
			<option value="350"> 350 m2 </option>
			<option value="400"> 400 m2 </option>
			<option value="450"> 450 m2 </option>
			<option value="500"> 500 m2 </option>
			<option value="550"> 550 m2 </option>
			<option value="600"> 600 m2 </option>
			<option value="650"> 650 m2 </option>
			<option value="700"> 700 m2 </option>
			<option value="750"> 750 m2 </option>
			<option value="800"> 800 m2 </option>
			<option value="850"> 850 m2 </option>
			<option value="900"> 900 m2 </option>
			<option value="950"> 950 m2 </option>
			<option value="1000"> 1000 m2 </option>
			<option value="1050"> 1050 m2 </option>
			<option value="1100"> 1100 m2 </option>
			<option value="1150"> 1150 m2 </option>		
			<option value="1200"> 1200 m2 </option>
			<option value="1250"> 1250 m2 </option>
			<option value="1300"> 1300 m2 </option>
			<option value="1350"> 1350 m2 </option>
			<option value="1400"> 1400 m2 </option>
			<option value="1450"> 1450 m2 </option>
			<option value="1500"> 1500 m2 </option>
			<option value="1550"> 1550 m2 </option>
			<option value="1600"> 1600 m2 </option>
			<option value="1650"> 1650 m2 </option>
			<option value="1700"> 1700 m2 </option>
			<option value="1750"> 1750 m2 </option>
			<option value="1800"> 1800 m2 </option>
			<option value="1850"> 1850 m2 </option>
			<option value="1900"> 1900 m2 </option>
			<option value="1950"> 1950 m2 </option>
			<option value="2000"> 2000 m2 </option>
			
			</select>
			</td>
	</tr>	
	<tr>
		<td align="left" class="cpst-texto-detalle"> Cantidad de sanitarios </td>
		<td align="left"> <input type="text" name="cant_sanitarios" class="cpst-input">	</td>
	</tr>
	<tr>
		<td align="left" class="cpst-texto-detalle"> Horas semanales solicitadas</td>
		<td align="left">  <select name="horas_semanales" class="cpst-input">
					<option value="2"> 2 Horas</option>
					<option value="4"> 4 Horas</option>
					<option value="6"> 6 Horas</option>
					<option value="8"> 8 Horas</option>
					<option value="10"> 10 Horas</option>
					<option value="12"> 12 Horas</option>
					<option value="14"> 14 Horas</option>
					<option value="16"> 16 Horas</option>
					<option value="18"> 18 Horas</option>
					<option value="20"> 20 Horas</option>
					<option value="22"> 22 Horas</option>
					<option value="24"> 24 Horas</option>
					<option value="26"> 26 Horas</option>
					<option value="28"> 28 Horas</option>
					<option value="30"> 30 Horas</option>
					<option value="32"> 32 Horas</option>
					<option value="34"> 34 Horas</option>
					<option value="36"> 36 Horas</option>
					<option value="38"> 38 Horas</option>
					<option value="40"> 40 Horas</option>
					<option value="42"> 42 Horas</option>
					<option value="44"> 44 Horas</option>
					<option value="46"> 46 Horas</option>
					<option value="48"> 48 Horas</option>
				</select>									
		</td>
	</tr>
	<tr>
		<td align="left" class="cpst-texto-detalle"> Insumos sanitarios</td>
		<td align="left" class="cpst-texto-detalle"><input type="checkbox" name="ins_jabon_liquido" value="1" class="cpst-input">  Jabon liquido 	 <br>
			 <input type="checkbox" name="ins_papel_higienico" value="1"> Papel higienico <br>
			 <input type="checkbox" name="ins_papel_toalla" value="1"> Papel toalla </td>
	</tr>
	<tr>
		<td align="left" class="cpst-texto-detalle"> Cantidad de usuarios de insumos sanitarios </td>
		<td align="left"> <input type="text" name="cant_usuarios_insumos" class="cpst-input">	</td>
	</tr>
	<tr>
		<td colspan="2" align="center"><br><br><input type="submit" value="Solicitar Presupuesto" class="cpst-boton"> </td>
	</tr>
		
		
</table>
</div>
</form>
</body>
<?php

?>