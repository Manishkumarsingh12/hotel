
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css"> -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>-->
 <!-- <script src="https://code.jquery.com/ui/1.9.2/jquery-ui.min.js"></script>  -->
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">     


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script> -->
<?php	
include('includes/dbconnection.php');
include('includes/myfunction.php');
if (isset($_GET['bookingid']) && ($_GET['user_id'])) {
	$bookid=$_GET['bookingid'];
	$user_id=$_GET['user_id'];
// 	include('tcpdf/tcpdf.php');


// ini_set("memory_limit","-1"); 
// 	$pdf = new TCPDF();
// 	$pdf->SetMargins(10, 12,10, true);
	
// 	$pdf->AddPage('P', 'A4');
	
// 
$html.='<html>
	<head>
		<meta charset="utf-8" />
		

		<style>
			.invoice-box {

				max-width:100%;
				padding: 30px;
				border:1px solid black;
			
				font-size: 12px;
				line-height: 24px;
				font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
				color: #555;
				margin:10px;
			}
			

			.invoice-box table {
				width: 100%;
				line-height: 30px;
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				padding-left:20px;
				padding-right:20px;
				vertical-align: top;
			}
			.right{

				text-align:right;

			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 30px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				padding:0 40px 0 40px;
				border-bottom: 1px solid #eee;

			}
			.invoice-box table tr.item-dark td {
				border-top: 1px solid black;
				padding:0 40px 0 40px;
				border-bottom: 1px solid black;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

		
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}
			@media print {
			  img{
			  	margin:10px;
			  }
			}
		</style>
	</head>';

// if(isset($_REQUEST['Export_PDF_manage_payment'])) {

// 	$user_id = ($_REQUEST['user_id']) ? $_REQUEST['user_id'] : '';
// 	$tid = ($_REQUEST['tid']) ? $_REQUEST['tid'] : '';

	$filename = "manage_payment_each_" . date('dmYHis') . ".pdf";
	// $sql="SELECT * from  tbluser where `ID`='$user_id'   ";
	// $query = $dbh -> prepare($sql); //query
	// $query->execute();
	// $users_row=$query->fetchAll(PDO::FETCH_OBJ);
	// $totalData=$query->rowCount();  //num rows	
$sql="SELECT tbluser.*,tblbooking.BookingNumber,tblbooking.RoomId,tblbooking.ID,tblbooking.Status,tblbooking.BookingDate,tblbooking.CheckoutDate,tblbooking.CheckinDate from tblbooking join tbluser on tblbooking.UserID=tbluser.ID where `tblbooking`.`ID`='$bookid' AND `tbluser`.`ID`='$user_id'  ";
			   
$query = $dbh -> prepare($sql); //query
$query->execute();
$users_row=$query->fetch(PDO::FETCH_ASSOC);
// $totalData=$query->rowCount();  //num rows
// echo "<pre>"; print_r($users_row); echo "</pre>";
// $now =date('Y-m-d',strtotime($users_row['CheckoutDate'])); // or your date as well
$now =strtotime($users_row['CheckoutDate']); // or your date as well
// $your_date = date('Y-m-d',strtotime($users_row['CheckinDate']));
$your_date = strtotime($users_row['CheckinDate']);
$datediff = $now - $your_date;

$stayNightDays=round($datediff / (60 * 60 * 24));
		$html.='<body>
		
				<div class="invoice-box" style="border:1px solid black;">
		<table cellpadding="0" cellspacing="0">
						<tr class="top">
							<td colspan="6">
								<table>
									<tr>
										<td class="title">
											<img src="'.getCompanyDetails()['Logo_path'].'" style="width:110px; height:110px ;border-radius:7px max-width: 300px" />
										</td>

										<td class="right" style="margin-top:20px">
											Booking No:  #'.$users_row['BookingNumber'].'<br />
											Date: '.date('d-m-Y ' ,strtotime($users_row['BookingDate'])).'<br />
										
										</td>
									</tr>
								</table>
							</td>
						</tr>';
		$html.='<tr class="top">
		<td colspan="6">
			<table>
				<tr>
				<td>
					<span  style="font-size:30px"><b>'.getCompanyDetails()['CompanyName'].'</b></span><br/>
					<span style="margin-top:0px;">
					Address: '.getCompanyDetails()['Address'].' <br>
					Email: '.getCompanyDetails()['Email'].' <br>
					Contact : '.getCompanyDetails()['Address'].' <br>
					Pin :'.getCompanyDetails()['Pin'].'</span>
					
				</td>

				<td class="right">
					<span> </span><br/>
					Bill to :<br>
					<span>'.$users_row['FullName'].'<br />
					
					'.$users_row['Email'].'
					'.$users_row['MobileNumber'].'
					</span>
				</td>
				</tr>
			</table>
		</td>
	</tr>';		
				
	
						
if(!empty($users_row['RoomId'])){

	$html.=			'<tr class="heading" style="background-color:#ededed">
							<td>Sl No.</td>
							<td class="">Room</td>
							
							<td class="right">Stay nights</td>
							<td class="right">price</td>
							<td class="right">Other Charges</td>
							<td class="right">Total</td>
						</tr>';
	$i=1;
	foreach(explode(',',$users_row['RoomId']) as $r){

		$sql="SELECT * from  tblroom where `ID`='$r'  ";
				
		$query = $dbh -> prepare($sql); //query
		$query->execute();
		$row=$query->fetch(PDO::FETCH_ASSOC);

			

			$html.='		<tr class="item">
								<td>'.$i.'</td>

								<td class=""> '.$row['RoomName'].'</td>
								
								<td class="right"> '.$stayNightDays.'</td>
								<td class="right"> '.getRoomPrice_bytype($row['RoomType']).'</td>
								<td class="right"> 0.00</td>
								<td class="right">'.number_format(getRoomPrice_bytype($row['RoomType']),2,'.','').'</td>
							</tr>';

					$total[]=getRoomPrice_bytype($row['RoomType']);


	$i++;

	}
    $html.='		<tr class="item-dark" >
							<td colspan=5>Total</td>
							<td class="right" >'.number_format(array_sum($total),2,'.','').'</td>
						</tr>';



}
						


		

		$html.='		</table>';
		$html.='<br><br>Note: This is a Computer generated pay receipt does not require signature. ';

				
		$html.=	'</div>	</body>';
	// 	if($count !=$totalpage){
	// 		$html.='<br pagebreak="true"/><tcpdf method="AddPage" />';
	// 	}	
	// 	$count++;
	// 	}//while 
	// }
	// echo $html;die;
// }

$html.='</html>';
echo $html;?>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="js/print/jQuery.print.js"></script>
<script type='text/javascript'>
	 jQuery(function($) { 'use strict';
		$("#page-container").print({
			globalStyles: true,
			mediaPrint: false,
			stylesheet: null,
			noPrintSelector: ".no-print",
			iframe: true,
			append: null,
			prepend: null,
			manuallyCopyFormValues: true,
			deferred: $.Deferred(),
			//timeout: 750,
			title:'',
			doctype: '<!doctype html>'
		});
	});
</script>
<?php

// $pdf->lastPage();
// $pdf->AddPage();

// $pdf->writeHTML($html, true, false, true, false, '');
// ob_end_clean();
// // $pdf->Output('D');
// $pdf->Output($filename,'D');
die;



}


