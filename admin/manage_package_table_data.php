<?php
include('includes/dbconnection.php');

$requestData= $_REQUEST;

$count = 1 ;
$status = '';
$Action = '';
// $select_table = 'enquiry';
$columns = array( 
// datatable column index  => database column name
	0 =>'id',
	1 =>'package_name',
	2 =>'package_price',
	3 =>'package_price',
	4 =>'Status',
	5 =>'modify_date',
	6 =>'Status',
	);

// if(!empty($_POST['custom']['classtype']) || !empty($_POST['custom']['section']) ){
//     $classtype = $_POST['custom']['classtype'];
//     $section = $_POST['custom']['section'];
// }


$sql="SELECT * from tblpackage where  1 ";
// AND FIND_IN_SET(`tblroom`.`id`,cast(`tblpackage`.`room` as char)) > 0)  ";

$query = $dbh -> prepare($sql); //query
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$totalData=$query->rowCount();  //num rows


$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {  


    $sql="SELECT * from tblpackage where  1 AND FIND_IN_SET(`tblroom`.`id`,cast(`tblpackage`.`room` as char)) > 0)  ";
		
	// ORDER BY `admission_date` DESC
		$sql.=" AND (`package_name` LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR `package_price` LIKE '%".$requestData['search']['value']."%' ";
		$sql.=" OR `modify_date` LIKE '%".$requestData['search']['value']."%' ";
	

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


	$admdate=date("d-M-Y", strtotime($date));

	
	$nestedData[] = $count;
	$nestedData[] =$row->package_name;
	$nestedData[] = $row->package_price;

	
	$nestedData[] = !empty($row->status) ? '<span class="badge badge-primary">Active</span>'  : '<span class="badge badge-primary">Not Updated Yet</span>';
	$nestedData[] = $row->modify_date;
	// $Action='<center><td class="d-none d-sm-table-cell"><a href="add-package.php?edit_id='.htmlentities ($row->id).'"  title="Edit Package"><i class="lnr lnr-pencil"></i></a></td>';
	$Action='  <td class="d-none d-sm-table-cell"><a href="view-package-detail.php?pid='.htmlentities ($row->id).'" target="_blank" title="View Package"> <i class="fa fa-eye" aria-hidden="true"></i></a></td></center>';
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
