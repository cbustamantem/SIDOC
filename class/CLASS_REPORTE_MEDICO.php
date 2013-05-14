<?php
class CLASS_REPORTE_MEDICO  extends FPDF
{
	// Page header
	public $encabezado="";
	public $pie="";
	function Header()
	{
		// Logo
		//$this->Image('logo.png',10,6,30);
		// Arial bold 15
		$this->SetFont('Arial','IB',8);
		
		$this->SetY(5);
		$this->SetX(5);		
		$this->MultiCell(110,4,$this->encabezado,0,'L');
		
		$this->SetY(5);
		$this->SetX(100);
		$this->MultiCell(110,4,$this->encabezado,0,'L');

		$this->SetY(5);
		$this->SetX(200);
		$this->MultiCell(110,4,$this->encabezado,0,'L');
		
		$this->SetLineWidth(0.2);
		$this->Line(5, 21, 290, 21);
		$this->SetLineWidth(0.5);
		$this->Line(5, 20, 290, 20);
		// Move to the right
		/*
		$this->Cell(20);
		// Title
		$this->Cell(100,10,$this->encabezado,0,0,'C');
		$this->Cell(30);
		// Title
		$this->Cell(70,10,$this->encabezado,0,0,'C');
	
		/*/ 
		//$this->Ln(10);
		
		
		
		 
	}
	function SetDash($black=false, $white=false)
	{
		if($black and $white)
			$s=sprintf('[%.3f %.3f] 0 d', $black*$this->k, $white*$this->k);
		else
			$s='[] 0 d';
		$this->_out($s);
	}
	// Page footer
	function Footer()
	{
		// Position at 1.5 cm from bottom
		$this->SetY(-35);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// Page number
		$this->SetX(5);
		$this->MultiCell(110,4,$this->pie,0,'L');
		$this->SetY(-35);
		$this->SetX(100);
		$this->MultiCell(110,4,$this->pie,0,'L');
		
		$this->SetY(-35);
		$this->SetX(200);
		$this->MultiCell(110,4,$this->pie,0,'L');
		//$this->Cell(105,-30,$this->pie,0,0,'C');
		//$this->Cell(135,-30,$this->pie,0,0,'C');
	}

	function GENERAR_REPORTE()
	{
		
		
	}		

}

?>