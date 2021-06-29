<?php
require ('fpdf/fpdf.php');
$db = new PDO('mysql:host=localhost;dbname=pms','root','');
class myPDF extends FPDF{
	function header(){
		$this->Image('logo.png',130,10);
		$this->Ln(15);
		$this->SetFont('Times','B',14);
		$this->Cell(276,5,'     Alipo Transporters                          EMAIL US:                      SERVICE HELPLINE CALL US:',0,0,'C');
		$this->Ln();
		$this->SetFont('Times','',12);
		$this->Cell(276,7,'P/Bag 143,Mzuzu                            alipo@gmail.com                                               +265 993 305 832',0,0,'C');
		$this->Line(0.0, 40.0, 400.0, 40.0);
		$this->Ln(20);
		$this->SetFont('Times','B',14);
		$this->Cell(276,7,'Bookings Report',0,0,'C');
		$this->Ln();
	}
	function footer(){
		$this->SetY(-15);
		$this->SetFont('Arial','',8);
	$this->Cell(0,10,'Page'.$this->PageNo().'/{nb}',0,0,'C');
	}
	function headerTable(){
		$this->SetFont('Times','B',12);
		$this->Cell(20,10,'ID',1,0,'C');
		$this->Cell(60,10,'FULL NAME',1,0,'C');
		$this->Cell(70,10,'VEHICLE(s)',1,0,'C');
		$this->Cell(40,10,'FROM DATE',1,0,'C');
		$this->Cell(40,10,'TO DATE',1,0,'C');
		$this->Cell(20,10,'AMOUNT',1,0,'C');
		$this->Cell(40,10,'STATUS',1,0,'C');
		$this->Ln();
	}
	function viewTable($db){
		$result_;
		$id=1;
		$total=0;
		$amount= 100;
		$this->SetFont('Times', '',12);
		$stmt = $db->query("SELECT tblusers.FullName,tblbooking.Vehicles,tblbooking.FromDate,tblbooking.ToDate,tblbooking.Total_Payment,tblbooking.User_Payment,tblbooking.Status,tblbooking.PostingDate,tblbooking.id  from tblbooking join tblusers on tblusers.EmailId=tblbooking.userEmail");
		while($data = $stmt->fetch(PDO::FETCH_OBJ)){
			if($data->Status==0)
					{
					$result_='Not Confirmed yet';
					} else if ($data->Status==1) {
					$result_='Confirmed';
					}
					 else{
						$result_='Cancelled';
					 }
			$this->Cell(20,10,$id,1,0,'C');
			$this->Cell(60,10,$data->FullName,1,0,'C');
			$this->Cell(70,10,$data->Vehicles,1,0,'C');
			$this->Cell(40,10,$data->FromDate,1,0,'C');
			$this->Cell(40,10,$data->ToDate,1,0,'C');
			$this->Cell(20,10,$data->Total_Payment,1,0,'C');
			$this->Cell(40,10,$result_,1,0,'C');
			$this->Ln();
			$id +=1;
			if ($data->Status==1)
			{
				$total +=$data->Total_Payment;
			}

		}
		$this->SetFont('Times','',12);
		$this->Cell(50,7,'Total Amount',0,0,'L');
		$this->SetFont('Times','B',12);
		$this->Cell(50,7,           $total,0,0,'');

	}

}

$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('L','A4',0);
$pdf->headerTable();
$pdf->viewTable($db);
$pdf->Output('bookings_report.pdf', 'I');

header('location: manage-bookings.php');
?>
