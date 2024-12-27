<?php
include('includes/dbconnection.php');

$requestData= $_REQUEST;

$count = 1 ;
$status = '';
$Action = '';
// $select_table = 'enquiry';
$columns = array( 
// datatable column index  => database column name
	0 =>'FacilityTitle',
	1 =>'FacilityTitle',
	2 =>'Description',
	3 =>'Description',
	4 =>'CreationDate',

	);

// if(!empty($_POST['custom']['classtype']) || !empty($_POST['custom']['section']) ){
//     $classtype = $_POST['custom']['classtype'];
//     $section = $_POST['custom']['section'];
// }
$sql="SELECT * from tblfacility  where 1  ";

$query = $dbh -> prepare($sql); //query
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$totalData=$query->rowCount();  //num rows


$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {  

$sql="SELECT * from tblfacility where 1  ";//order by CreationDate desc
		
	// ORDER BY `admission_date` DESC
		$sql.=" AND (`FacilityTitle` LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR `Description` LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR `CreationDate` LIKE '%".$requestData['search']['value']."%' ";

		$sql.=" )";
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
foreach($results as $row){   
	$nestedData=array();


	// $admdate=date("d-M-Y", strtotime($date));

	
	$nestedData[] = $count;
	$nestedData[] =$row->FacilityTitle;
	$nestedData[] = $row->Description;
	$nestedData[] = '<td class="d-none d-sm-table-cell"><img src="images/'.$row->Image.'" width="100" height="100"></td>';
	$nestedData[] = $row->CreationDate;
	// $nestedData[] = $row->BookingDate;
	
	$Action='<a href="javascript:void(0)" class="facility_del" data-id="'.$row->ID.'" >Delete</a>';
	// $Action='<a href="javascript:confirm("Do you really want to Delete ?")" >Delete</a>';
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
