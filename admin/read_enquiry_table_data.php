<?php
include('includes/dbconnection.php');

$requestData= $_REQUEST;

$count = 1 ;
$status = '';
$Action = '';
// $select_table = 'enquiry';
$columns = array( 
// datatable column index  => database column name
	0 =>'Name',
	1 =>'Name',
	2 =>'Email',
	3 =>'MobileNumber',
	4 =>'EnquiryDate',
	
	);

// if(!empty($_POST['custom']['classtype']) || !empty($_POST['custom']['section']) ){
//     $classtype = $_POST['custom']['classtype'];
//     $section = $_POST['custom']['section'];
// }
$sql="SELECT * from tblcontact where IsRead='1' ";


$query = $dbh -> prepare($sql); //query
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$totalData=$query->rowCount();  //num rows


$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {  

$sql="SELECT * from tblcontact where IsRead='1' " ;
		
	// ORDER BY `admission_date` DESC
		$sql.=" AND (`Name` LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR `Email` LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR `MobileNumber` LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR `EnquiryDate` LIKE '%".$requestData['search']['value']."%' ";
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


	// $admdate=date("d-M-Y", strtotime($date));

	
	$nestedData[] = $count;
	$nestedData[] =$row->Name;
	$nestedData[] = $row->Email;
	$nestedData[] = $row->MobileNumber;

	
	$nestedData[] ='<span class="badge badge-primary">'.$row->EnquiryDate.'</span>';

	
	// $nestedData[] = $row->BookingDate;
	
	$Action='<td><a href="view-enquiry.php?viewid='.htmlentities($row->ID).'" target="_blank">View Details</a></td>';
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
