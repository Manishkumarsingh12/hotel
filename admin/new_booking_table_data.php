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
$sql="SELECT tbluser.*,tblbooking.BookingNumber,tblbooking.Status,tblbooking.BookingDate from tblbooking join tbluser on tblbooking.UserID=tbluser.ID where tblbooking.Status is null ";


$query = $dbh -> prepare($sql); //query
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$totalData=$query->rowCount();  //num rows


$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {  

$sql="SELECT tbluser.*,tblbooking.BookingNumber,tblbooking.Status,tblbooking.BookingDate from tblbooking join tbluser on tblbooking.UserID=tbluser.ID where tblbooking.Status is null ";
		
	// ORDER BY `admission_date` DESC
		$sql.=" AND (`BookingNumber` LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR `FullName` LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR `Email` LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR `MobileNumber` LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR `BookingDate` LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" ) ";
}
	

	$query = $dbh -> prepare($sql); //query
$query->execute();

$totalFiltered=$query->rowCount();  

$sql.="ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

// echo "<br>".$sql;
$query = $dbh -> prepare($sql); //query
$query->execute();

$results=$query->fetchAll(PDO::FETCH_OBJ);
$data = array();
$count=1;
// while($row=$query->fetchAll(PDO::FETCH_OBJ) ) {  // preparing an array
foreach($results as $row){      
	$nestedData=array();


	$admdate=date("d-M-Y", strtotime($date));

	
	$nestedData[] = $count;
	$nestedData[] =$row->BookingNumber;
	$nestedData[] = $row->FullName;
	$nestedData[] = $row->Email;
	$nestedData[] = $row->MobileNumber;
	
	$nestedData[] ='<span class="badge badge-primary">'.$row->BookingDate.'</span>';
	if(!empty($row->Status)){
		$nestedData[] ='<span class="badge badge-primary">'.$row->Status.'</span>';
	}else{
		$nestedData[] ='<span class="badge badge-primary">Not Updated Yet</span>';
	}
	
	// $nestedData[] = $row->BookingDate;
	
	$Action='<td class="d-none d-sm-table-cell"><a href="view-booking-detail.php?bookingid='.$row->BookingNumber.'"><i class="fa fa-eye" aria-hidden="true"></i></a></td>';
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
