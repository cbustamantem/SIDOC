<?php
class CLASS_HISTORIAL
{
    private $vlc_codigo_html;

    private $vlc_db_cn;
    function __construct ($vp_cn)
    {
    	$this->vlc_db_cn = $vp_cn;
       
        $this->MTD_INICIALIZAR_PAGINA();
        
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
       $historial="";
       $historial=FN_RECIBIR_VARIABLES("historial");
	   if ($historial)
	   {
		   	$this->vlc_codigo_html=$this->MTD_MOSTRAR_REPORTE($historial);
		   	
	   }
	   else 
	   {    	
	       $this->vlc_codigo_html = FN_LEER_TPL('tpl/tpl-historial.html');
	       include ('CLASS_ABM_HISTORIAL.php');
	       $obj = new CLASS_ABM_HISTORIAL($this->vlc_db_cn );
	       $listado_visitas= $obj->MTD_LISTAR_VISITAS();
	       $paciente = FN_RECIBIR_VARIABLES('paciente');
	       $nombre_paciente="";
	       $datos_paciente = array();
	       if ($paciente > 0)
	       {
	       	$datos_paciente = FN_RUN_QUERY("SELECT nombre, apellido from pacientes where id_paciente=$paciente",2,$this->vlc_db_cn);
	        $nombre_paciente= $datos_paciente[0][0]." ".$datos_paciente[0][1];
	       } 
	       $this->vlc_codigo_html = FN_REEMPLAZAR("{tpl-nombre-paciente}", $nombre_paciente,  $this->vlc_codigo_html );
	       $this->vlc_codigo_html = FN_REEMPLAZAR("{tpl-listado-visitas}", $listado_visitas,  $this->vlc_codigo_html );
	       $this->vlc_codigo_html = FN_REEMPLAZAR("{tpl-paciente}", FN_RECIBIR_VARIABLES("paciente"),  $this->vlc_codigo_html );
	   }
    }
    function MTD_MOSTRAR_REPORTE($vp_historial)
    {
    	include ('fpdf.php');
    	include ('CLASS_REPORTE_MEDICO.php');
    	include ('CLASS_ABM_PERFIL.php');
    	$perfil = NEW CLASS_ABM_PERFIL($this->vlc_db_cn);
    	
    	$membrete= array();
    	$membrete= $perfil->MTD_DB_LISTAR_MEMBRETE();
    	$pdf = new CLASS_REPORTE_MEDICO();
    	$pdf->encabezado= $membrete[0][0];
    	$pdf->pie= $membrete[0][1];
    	LOGGER::LOG("GENERANDO REPORTE: encabezado; ".$membrete[0][0]);
    	LOGGER::LOG("GENERANDO REPORTE: Historial; ".$vp_historial);
    	// Instanciation of inherited class    	
    	$pdf->AddPage("L","A4");    	
    	// RECUADROS    	
    	$pdf->SetDash(0.5, 0.5); //4mm on, 2mm off
    	$pdf->Rect(5, 24, 90,150);    	
    	
    	//linea de corte
    	$pdf->Line(98, 5, 98, 195);
    	$pdf->Rect(100, 24, 95, 150);
    	
    	$pdf->Rect(200, 24, 95, 150);
    	
    	//linea de corte
    	$pdf->Line(198, 5, 198, 199);
    	
    	
    	$pdf->SetDash(); //restore no dash
    	
    	$pdf->AliasNbPages();
    	
    	$pdf->SetFont('Times','',12);
    	//for($i=1;$i<=40;$i++)
    		//$pdf->Cell(0,10,'Printing line number '.$i,0,1);
    	
    	
    	//CONTENIDO
    	$pdf->SetY(25);
    	$pdf->SetX(5);
    	$pdf->SetFont('Arial','B',16);
    	$pdf->Cell(80,10,"Rp)",0,0,'L');
    	
    
    	$pdf->SetFont('Arial','i',10);    	
    	// Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    	include ('CLASS_ABM_HISTORIAL.php');
    	include ('CLASS_ABM_PACIENTES.php');
    	$obj = new CLASS_ABM_HISTORIAL($this->vlc_db_cn );
    	$obj_paciente = new CLASS_ABM_PACIENTES($this->vlc_db_cn);
    	$datos_pacciente= $obj_paciente->MTD_DB_LISTAR(true,FN_RECIBIR_VARIABLES("paciente"));
    	$pdf->SetY(35);
    	$pdf->SetX(5);    	
    	$pdf->MultiCell(90,10,"Paciente: ".utf8_decode($datos_pacciente[0][1])." ".$datos_pacciente[0][2] ,0,'L');
    	$pdf->Line(5, 45, 95, 45);
    	
    	$pdf->SetY(35);
    	$pdf->SetX(101);
    	$pdf->MultiCell(90,10,"Paciente: ".utf8_decode($datos_pacciente[0][1])." ".$datos_pacciente[0][2] ,0,'L');
    	$pdf->Line(100, 45, 195, 45);
    	
    	$pdf->SetY(35);
    	$pdf->SetX(200);
    	$pdf->MultiCell(90,10,"Paciente: ".utf8_decode($datos_pacciente[0][1])." ".$datos_pacciente[0][2] ,0,'L');
    	$pdf->Line(200, 45, 295, 45);
    	
    	$pdf->SetY(50);
    	$pdf->SetX(5);
    	// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=false)
    	//$pdf->Cell(100,60,$texto,1,1,'L',false);
    	
    	    	    	    
    	$obj->MTD_RECIBIR_DATOS();
    	$arreglo = array();
    	$arreglo = $obj->MTD_DB_LISTAR($vp_historial);    	
    	$pdf->MultiCell(90,10,utf8_decode($arreglo[0][5]),0,'L');
    	
    	
    	
    	$pdf->SetY(20);
    	$pdf->SetX(100);
    	$pdf->SetFont('Arial','B',16);
    	$pdf->Cell(60,20,"Indicaciones",0,0,'L');
    	$pdf->SetY(50);
    	$pdf->SetX(100);
    	$pdf->SetFont('Arial','i',10);
    	$pdf->MultiCell(95,10,utf8_decode($arreglo[0][6]),0,'L');
    	
    	
    	$pdf->SetY(25);
    	$pdf->SetX(200);
    	$pdf->SetFont('Arial','B',16);
    	$pdf->Cell(80,10,"Estudios",0,0,'L');
    	
    	$pdf->SetY(50);
    	$pdf->SetX(200);
    	$pdf->SetFont('Arial','i',10);
    	$pdf->MultiCell(95,10,utf8_decode($arreglo[0][4]),0,'L');
    	
    	
    	    	  
    	return $pdf->Output();
    	
    }
    
    function MTD_RETORNAR_CODIGO_HTML ()
    {
        return $this->vlc_codigo_html;
    }
}
?>
