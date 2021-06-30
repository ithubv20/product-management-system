<?php
require ('fpdf/fpdf.php');
$db = new PDO('mysql:host=localhost;dbname=pms','root','');
class myPDF extends FPDF{
	function header(){
		$this->Image('assets\img\logo\pms_logo.png',140,10,20,20);
		$this->Ln(15);
		$this->SetFont('Times','B',14);
		$this->Cell(276,15,'    Product management system Quotation         '               ,0,0,'C');
		$this->Ln();
		$this->SetFont('Times','',12);
		$this->Line(0.0, 40.0, 400.0, 40.0);
		$this->Ln(20);
		$this->SetFont('Times','B',14);
		$this->Cell(276,7,'Quotation',0,0,'C');
		$this->Ln();
	}
	function footer(){
		$this->SetY(-15);
		$this->SetFont('Arial','',8);
	$this->Cell(0,10,'Page'.$this->PageNo().'/{nb}',0,0,'C');
	}
	function headerTable(){
		$this->SetFont('Times','B',12);
		$this->Cell(60,10,'QUOTE#',1,0,'C');
		$this->Cell(60,10,'ITEM',1,0,'C');
		$this->Cell(40,10,'QUANTITY',1,0,'C');
		$this->Cell(70,10,'CUSTOMER',1,0,'C');
		$this->Cell(40,10,'TOTAL AMOUNT',1,0,'C');
		$this->Ln();
	}
	function viewTable($db){
		
		$this->SetFont('Times', '',12);
		$stmt = $db->query("SELECT tbl_sales_orders.*, tbl_items.item_name FROM tbl_sales_orders INNER JOIN tbl_items ON tbl_sales_orders.item = tbl_items.id WHERE order_status = 0");
		while($data = $stmt->fetch(PDO::FETCH_OBJ)){
			$this->Cell(60,10,$data->order_number,1,0,'C');
			$this->Cell(60,10,$data->item_name,1,0,'C');
			$this->Cell(40,10,$data->order_quantity,1,0,'C');
			$this->Cell(70,10,$data->customer_name,1,0,'C');
			$this->Cell(40,10,$data->total_amount,1,0,'C');
			$this->Ln();

		}
	}

}

$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('L','A4',0);
$pdf->headerTable();
$pdf->viewTable($db);
$pdf->Output('quotation.pdf', 'I');

header('location: sellsquote.php');
?>
