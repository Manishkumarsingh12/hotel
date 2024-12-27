<?php
include('includes/dbconnection.php');

$requestData= $_REQUEST;

$count = 1 ;
$status = '';
$Action = '';
// $select_table = 'enquiry';
$columns = array( 
// datatable column index  => database column name
	0 =>'BookingNumber',
	1 =>'BookingNumber',
	2 =>'FullName',
	3 =>'Email',
	4 =>'MobileNumber',
	5 =>'BookingDate',
	6 =>'Status',
	);

// if(!empty($_POST['custom']['classtype']) || !empty($_POST['custom']['section']) ){
//     $classtype = $_POST['custom']['classtype'];
//     $section = $_POST['custom']['section'];
// }


$sql="SELECT tbluser.*,tblbooking.BookingNumber,tblbooking.ID as `bid` ,tblbooking.Status,tblbooking.BookingDate from tblbooking join tbluser on tblbooking.UserID=tbluser.ID where 1   ";

$query = $dbh -> prepare($sql); //query
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$totalData=$query->rowCount();  //num rows


$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {  


$sql="SELECT tbluser.*,tblbooking.BookingNumber,tblbooking.ID,tblbooking.Status,tblbooking.BookingDate from tblbooking join tbluser on tblbooking.UserID=tbluser.ID where 1  ";//LIMIT $offset, $no_of_records_per_page
		
	// ORDER BY `admission_date` DESC
		$sql.=" AND (`BookingNumber` LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR `FullName` LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR `Email` LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR `MobileNumber` LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR `BookingDate` LIKE '%".$requestData['search']['value']."%' ";

		$sql.=" )";
}
	// echo $sql;

	$query = $dbh -> prepare($sql); //query
$query->execute();

$totalFiltered=$query->rowCount();  

$sql.="ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

$query = $dbh -> prepare($sql); //query
$query->execute();

$results=$query->fetchAll(PDO::FETCH_OBJ);
$data = array();
$count=1;
// while($row=$query->fetchAll(PDO::FETCH_OBJ) ) {  // preparing an array
foreach($results as $row){   
	$nestedData=array();
	// print_r($row);

	$admdate=date("d-M-Y", strtotime($date));

	
	$nestedData[] = $count;
	$nestedData[] =$row->BookingNumber;
	$nestedData[] = $row->FullName;
	$nestedData[] = $row->Email;
	$nestedData[] = $row->MobileNumber;
	$nestedData[] = $row->BookingDate;
	$nestedData[] = !empty($row->Status) ? '<span class="badge badge-primary">'.$row->Status.'</span>'  : '<span class="badge badge-primary">Not Updated Yet</span>';
	
	$Action='<center><td class="d-none d-sm-table-cell"><a href="hotel_Invoice.php?bookingid='.htmlentities ($row->bid).'&user_id='.htmlentities ($row->ID).'" target="_blank"><i class="fa fa-clipboard" aria-hidden="true"></i></a></td>';
	$Action.='<td class="d-none d-sm-table-cell"><a href="view-booking-detail.php?bookingid='.htmlentities ($row->BookingNumber).'"> <i class="fa fa-eye" aria-hidden="true"></i></a></td></center>';
	$nestedData[] = $Action;

	

	
	$data[] = $nestedData;
	$count ++;
}

$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>
