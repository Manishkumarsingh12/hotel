<?php
	include('dbconnection.php');
	include_once('myfunction.php');
	
   if(isset($_POST['Login'])){
    	$username=$_POST['username'];
		$password=md5($_POST['password']);
		$sql ="SELECT ID FROM tbladmin WHERE UserName=:username and Password=:password";
		$query=$dbh->prepare($sql);
		$query-> bindParam(':username', $username, PDO::PARAM_STR);
	    $query-> bindParam(':password', $password, PDO::PARAM_STR);
		$query-> execute();
		$results=$query->fetchAll(PDO::FETCH_OBJ);
		if($query->rowCount() > 0)
	    {
		foreach ($results as $result) {
		$_SESSION['hbmsaid']=$result->ID;
	  }

		if(!empty($_POST["remember"])) {
		//COOKIES for username
		setcookie ("user_login",$_POST["username"],time()+ (10 * 365 * 24 * 60 * 60));
		//COOKIES for password
		setcookie ("userpassword",$_POST["password"],time()+ (10 * 365 * 24 * 60 * 60));
		} else {
		if(isset($_COOKIE["user_login"])) {
		setcookie ("user_login","");
		if(isset($_COOKIE["userpassword"])) {
		setcookie ("userpassword","");
				}
			  }
		}
	  $_SESSION['login']=$_POST['username'];
	  $responce=array('status'=>'success', 'msg'=>'Login Successfully');
     echo json_encode($responce);
	} else{
	  $responce=array('status'=>'wrong', 'msg'=>'Invalid Username and Password !');
     echo json_encode($responce);
	}
	
	
   }
   
   
   function sendwhatsappMessage($msgg, $phone){
    date_default_timezone_set("Asia/Kolkata");
   
  
        $mobile=$phone;
        // $mobile="7004083341";
        $message = str_replace(' ', '%20', $msgg);
      
        $completeurl="https://ziper.io/api/send.php?number=91".$mobile."&type=text&message=".$message."&instance_id=63E619BC31285&access_token=0a6e36d8f847f3feeefb53807265173f";
      
        
        $curl1 = curl_init();
        curl_setopt_array($curl1, array(
        CURLOPT_URL =>$completeurl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache"
        ),
        ));
        $SMSresponse1 = curl_exec($curl1);
        $msg=json_decode($SMSresponse1,true);
        // if($msg['status']=='error'){
          
        // }else{
             
        // }
        $err = curl_error($curl1);
        curl_close($curl1);
        if ($err) {
        // echo "<br>cURL Error #: $err";
        }else{
            return "success";
        }
   
    
} 
   
   

  if(isset($_POST['Bookroom'])){
	// echo "<pre>";
	// print_r($_POST);
	// print_r($_SESSION['session']);die;


     $booknum=mt_rand(100000000, 999999999);
	//  $rid=intval($_POST['rmid']);
	 $rid=implode(',', $_POST['choose_room']);
	 $login_user=$_SESSION['hbmsaid'];
	

     $name=$_POST['name'];
     $email=$_POST['email'];
     $phone=$_POST['phone'];
     $idtype=$_POST['idtype'];
	 $gender=$_POST['gender'];
	 $price=$_POST['price'];
	 $address=$_POST['address'];
	 $checkindate=$_POST['checkindate'];
	 $checkoutdate=$_POST['checkoutdate'];
	 $Type=1;
     $Idimage =$_FILES["image"]["name"];
	 $tmp_name = $_FILES['image']['tmp_name'];
     $allowTypes=array("png","jpeg",'jpg');
	 
		 
        $Idimage=str_replace(" ", "_", $Idimage);
		$Idimage = strtotime(date("Y-m-d h:i:s")).'_'.$Idimage;
		$extn = pathinfo($Idimage, PATHINFO_EXTENSION);
        $ext = strtolower($extn);
		$result=in_array($ext,$allowTypes);
	    if($result){
		 move_uploaded_file($tmp_name,"../identity-img/$Idimage");
	  }
  $cdate=date('Y-m-d');
  if($checkindate <  $cdate){
	$responce=array('status'=>'gdate', 'msg'=>'Check in date must be greater than current date');
	echo json_encode($responce);
} else if($checkindate > $checkoutdate){
	$responce=array('status'=>'indate', 'msg'=>'Check out date must be equal to / greater than  check in date');
	echo json_encode($responce);
} else {



	 $usql="insert into tbluser(FullName,MobileNumber,Email,status)values('$name','$phone','$email','0')";
	// echo $usql="insert into tbluser(FullName,MobileNumber,Email,status)values(:name,:phone,:email,:status)";
			$query=$dbh->prepare($usql);
			
			// $query->bindParam(':name',$name,PDO::PARAM_STR);
			// $query->bindParam(':phone',$phone,PDO::PARAM_STR);
			// $query->bindParam(':email',$email,PDO::PARAM_STR);
			// $query->bindParam(':status','0',PDO::PARAM_STR);
			$query->execute(); 
	// 		echo "<pre>";
	//  var_dump($query->debugDumpParams());
	   $LastInsertId=$dbh->lastInsertId();


if ($LastInsertId>0) {  
		$sql="insert into tblbooking(RoomId,BookingNumber,UserID,IDType,IdImage,price,Gender,Address,CheckinDate,CheckoutDate,login_user,Type)values(:rid,:booknum,:uid,:idtype,:Idimage,:price,:gender,:address,:checkindate,:checkoutdate,:login_user,:Type)";
		$query=$dbh->prepare($sql);
		$query->bindParam(':rid',$rid,PDO::PARAM_STR);
		$query->bindParam(':booknum',$booknum,PDO::PARAM_STR);

		$query->bindParam(':uid',$LastInsertId,PDO::PARAM_STR);

		$query->bindParam(':idtype',$idtype,PDO::PARAM_STR);
		$query->bindParam(':gender',$gender,PDO::PARAM_STR);
		$query->bindParam(':price',$price,PDO::PARAM_STR);
		$query->bindParam(':address',$address,PDO::PARAM_STR);
		$query->bindParam(':checkindate',$checkindate,PDO::PARAM_STR);
		$query->bindParam(':checkoutdate',$checkoutdate,PDO::PARAM_STR);
		$query->bindParam(':Idimage',$Idimage,PDO::PARAM_STR);
		$query->bindParam(':login_user',$login_user,PDO::PARAM_STR);
		$query->bindParam(':Type',$Type,PDO::PARAM_STR);

		$query->execute();

	
	   $msg='Dear '.$name.' Your room has been book successfully. Booking Number is "'.$booknum.'"';
 
	 $responce=array('status'=>'success', 'msg'=>'Your room has been book successfully. Booking Number is "'.$booknum.'"');
	 sendwhatsappMessage($msg,$phone,);
	 
	echo json_encode($responce);
  }else{
      	 $responce=array('status'=>'error', 'msg'=>'Something Went Wrong. Please try again');
        echo json_encode($responce);	
    }

  }
 }
  
if(isset($_POST['Contactus'])){
	 
    $name=$_POST['name'];
    $phone=$_POST['phone'];
    $email=$_POST['email'];
    $message=$_POST['message'];

	$sql="insert into tblcontact(Name,MobileNumber,Email,Message)values(:name,:phone,:email,:message)";
	$query=$dbh->prepare($sql);
	$query->bindParam(':name',$name,PDO::PARAM_STR);
	$query->bindParam(':phone',$phone,PDO::PARAM_STR);
	$query->bindParam(':email',$email,PDO::PARAM_STR);
	$query->bindParam(':message',$message,PDO::PARAM_STR);
	$query->execute();
    $LastInsertId=$dbh->lastInsertId();
	   if ($LastInsertId>0) {
		   $responce=array('status'=>'success', 'msg'=>'Your message was sent successfully!.');
           echo json_encode($responce);
	  }else{
		   $responce=array('status'=>'success', 'msg'=>'Something Went Wrong. Please try again.');
           echo json_encode($responce);
		}
}


 if(isset($_POST['Profile'])){
	$uid=$_SESSION['hbmsuid'];
    $AName=$_POST['fname'];
	$mobno=$_POST['mobno'];
	$sql="update tbluser set FullName=:name,MobileNumber=:mobilenumber where ID=:uid";
     $query = $dbh->prepare($sql);
     $query->bindParam(':name',$AName,PDO::PARAM_STR);
     $query->bindParam(':mobilenumber',$mobno,PDO::PARAM_STR);
     $query->bindParam(':uid',$uid,PDO::PARAM_STR);
     $query->execute();
     $responce=array('status'=>'success', 'msg'=>'Profile has been updated!.');
     echo json_encode($responce);	 
	 
 }
 
 if(isset($_POST['chngpwd'])){
	$email=$_POST['email'];
	$mobile=$_POST['mobile'];
	$newpassword=md5($_POST['newpassword']);
	$sql ="SELECT Email FROM tbluser WHERE Email=:email and MobileNumber=:mobile";
	$query= $dbh -> prepare($sql);
	$query-> bindParam(':email', $email, PDO::PARAM_STR);
	$query-> bindParam(':mobile', $mobile, PDO::PARAM_STR);
	$query-> execute();
	$results = $query -> fetchAll(PDO::FETCH_OBJ);
	if($query -> rowCount() > 0)
	{
	$con="update tbluser set Password=:newpassword where Email=:email and MobileNumber=:mobile";
	$chngpwd1 = $dbh->prepare($con);
	$chngpwd1-> bindParam(':email', $email, PDO::PARAM_STR);
	$chngpwd1-> bindParam(':mobile', $mobile, PDO::PARAM_STR);
	$chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
	$chngpwd1->execute();
	$responce=array('status'=>'success', 'msg'=>'Your Password succesfully changed.');
     echo json_encode($responce);	 
	}
	else {
		$responce=array('status'=>'error', 'msg'=>'Email id or Mobile no is invalid');
       echo json_encode($responce);
	}
  } 

if(isset($_POST['Add_facility'])){
// echo "<pre>";
// print_r($_REQUEST);
// print_r($_FILES);
$hbmsaid=$_SESSION['hbmsaid'];
 $ftitle=$_POST['ftitle'];
 $facdes=$_POST['facdes'];

$img=trim($_FILES["image"]["name"]);

 $extension = trim(substr($img,strlen($img)-4,strlen($img)));
 // $extension =".png";

$allowed_extensions = array(".jpg",".jpeg",".png",".gif");

if(in_array($extension,$allowed_extensions)){
	$img=md5($img).time().$extension;

		if(move_uploaded_file($_FILES["image"]["tmp_name"],"../images/".$img)){
			$sql="insert into tblfacility(FacilityTitle,Description,Image)values(:ftitle,:facdes,:img)";

		  $query=$dbh->prepare($sql);

		  $query->bindParam(':ftitle',$ftitle,PDO::PARAM_STR);

		  $query->bindParam(':facdes',$facdes,PDO::PARAM_STR);

		  $query->bindParam(':img',$img,PDO::PARAM_STR);

		  $query->execute();
   		$LastInsertId=$dbh->lastInsertId();

   		if ($LastInsertId>0){
       	$response['status']="success";
			  $response['message']="Facility has been added";
      }else{

         	$response['status']="error";
			    $response['message']="Something Went Wrong Please try again";
      }
		}else{
		 	$response['status']="error";
			$response['message']="Image not Uploaded ";
		}
  echo json_encode($response);
		

}else{

		
  $response['status']="error";
		$response['message']="Facility image has Invalid format. Only jpg / jpeg/ png /gif format allowed";
		echo json_encode($response); die;
	
}
}
if(isset($_POST['Add_room']))
  {

$hbmsaid=$_SESSION['hbmsaid'];
 $roomtype=$_POST['roomtype'];
 $room_no=$_POST['room_no'];
 $roomname=$_POST['roomname'];
 $maxadult=$_POST['maxadult'];
 $maxchild=$_POST['maxchild'];
 $roomfac = implode(',', $_POST['roomfac']);
 $roomdes=$_POST['roomdes'];
 $nobed=$_POST['nobed'];

 if(!empty($room_no) && (checkRoomNoAbility($room_no)=='1')){
	$response['status']="error";
	$response['message']="This Room no is already issued ";
	echo json_encode($response); die;
}
 
 
$img=$_FILES["image"]["name"];
$extension = substr($img,strlen($img)-4,strlen($img));
$allowed_extensions = array(".jpg","jpeg",".png",".gif");
if(!in_array($extension,$allowed_extensions))
{
$response['status']="error";
		$response['message']="Facility image has Invalid format. Only jpg / jpeg/ png /gif format allowed";
		echo json_encode($response); die;
	
}
else
{

$img=md5($img).time().$extension;
 if(move_uploaded_file($_FILES["image"]["tmp_name"],"../images/".$img)){

		$sql="insert into tblroom(RoomType,RoomNo,RoomName,MaxAdult,MaxChild,RoomDesc,NoofBed,Image,RoomFacility)values(:roomtype,:room_no,:roomname,:maxadult,:maxchild,:roomdes,:nobed,:img,:roomfac)";
		$query=$dbh->prepare($sql);
		$query->bindParam(':roomtype',$roomtype,PDO::PARAM_STR);
		$query->bindParam(':room_no',$room_no,PDO::PARAM_STR);
		$query->bindParam(':roomname',$roomname,PDO::PARAM_STR);
		$query->bindParam(':maxadult',$maxadult,PDO::PARAM_STR);
		$query->bindParam(':maxchild',$maxchild,PDO::PARAM_STR);
		$query->bindParam(':roomdes',$roomdes,PDO::PARAM_STR);
		$query->bindParam(':nobed',$nobed,PDO::PARAM_STR);
		$query->bindParam(':roomfac',$roomfac,PDO::PARAM_STR);
		$query->bindParam(':img',$img,PDO::PARAM_STR);
		 $query->execute();

		   $LastInsertId=$dbh->lastInsertId();
		   if ($LastInsertId>0) {
		     	$response['status']="success";
					  $response['message']="New Room has been added";
		  }
		  else
		    {
		         
		         	$response['status']="error";
					    $response['message']="Something Went Wrong Please try again";
		    }
		  }else{
		  		$response['status']="error";
		     	$response['message']="Image not Uploaded ";

		  }

		echo json_encode($response); die;
}
}


if(isset($_POST['Add_category'])){
// echo "<pre>";
// print_r($_REQUEST);
// print_r($_FILES);


$hbmsaid=$_SESSION['hbmsaid'];

 $cname=$_POST['cname'];

 $catdes=$_POST['catdes'];

 $price=$_POST['price'];



$sql="insert into tblcategory(CategoryName,Description,Price)values(:cname,:catdes,:price)";

$query=$dbh->prepare($sql);

$query->bindParam(':cname',$cname,PDO::PARAM_STR);

$query->bindParam(':catdes',$catdes,PDO::PARAM_STR);

$query->bindParam(':price',$price,PDO::PARAM_STR);

 $query->execute();



   $LastInsertId=$dbh->lastInsertId();

   if ($LastInsertId>0){

   	$response['status']="success";
		 $response['message']="New Category has been added";



  }else{

        	$response['status']="error";
					    $response['message']="Something Went Wrong Please try again";

    }


		echo json_encode($response); die;


}
if(isset($_POST['manage_facility_delete'])){

	
	$rid=intval($_POST['id']);
	
	$sql="delete from tblfacility where ID=:rid";
	
	$query=$dbh->prepare($sql);
	
	$query->bindParam(':rid',$rid,PDO::PARAM_STR);
	
	$result=$query->execute();
	if($result){
		$response['status']="success";
		 $response['message']="Delete Sucessfully";
	}else{
		$response['status']="error";
		$response['message']="Something Went Wrong Please try again";
	}
	echo json_encode($response); die;
	
	
	}

if(isset($_POST['Add_Package'])){
	// echo "<pre>";
	// print_r($_POST);
	// print_r($_FILES);
	$package_name=$_POST['packname'];
	$package_price=$_POST['totalPrice'];
	$choose_room=$_POST['choose_room'];

	 $sql="SELECT * FROM `tblpackage` where `package_name`='$package_name' ";
		// $result2=$query2->fetchAll(PDO::FETCH_OBJ);
	// print_r($result2);

	// $result2 = $dbh->prepare($sql); 
	// $result2->execute(); 
	// echo "<br>no of rows:".$number_of_rows = $result2->fetchColumn(); 
	$nRows = $dbh->query($sql)->fetchColumn(); 
    if(!$nRows > 0){
	
		if(!empty($choose_room)){
			$rooms=implode(',',$choose_room);
		}
		foreach($_FILES['images']['name'] as $key => $img){

			$name=explode('.',$img);
			$ext=pathinfo($img,PATHINFO_EXTENSION);
			$num=substr($name[0],0,4);                   //take four letter of name
			$image_name=$num.'_'.date("Ymd-His").'_'.rand(111,999).'.'.$ext;
			$mul_img2[]=$image_name;
			$move_img=move_uploaded_file($_FILES['images']['tmp_name'][$key],"../images/packages/".$image_name);
		}

		// print_r($mul_img2);
		if($move_img){
			$image_n = implode(', ', $mul_img2);

			$sql="insert into tblpackage(package_name,package_price,room,images,create_date,modify_date)values(:package_name,:package_price,:room,'$image_n',now(),now())";
			$query=$dbh->prepare($sql);
			$query->bindParam(':package_name',$package_name,PDO::PARAM_STR);
			$query->bindParam(':package_price',$package_price,PDO::PARAM_STR);
			$query->bindParam(':room',$rooms,PDO::PARAM_STR);
			
			$result=$query->execute();

			if($result){
				$response['status']="success";
				$response['message']="Package Created sucessfully";
			}else{
				$response['status']="error";
				$response['message']="Something Went Wrong Please try again";
			}
		}else{
			$response['status']="error";
			$response['message']="Problems on Image uploading";

		}	
	}else{
		$response['status']="error";
		$response['message']="These Package is already Exist";
	}	
	echo json_encode($response); die;
	
}	
	
if(isset($_POST['CheckRoomBookNo'])){
	 $room_no=$_POST['room_no'];
	if(!empty($room_no)){
		echo json_encode(checkRoomNoAbility($room_no));
	}else{
		echo json_encode(0);
	}
	// $sql="SELECT `RoomNo` FROM `tblroom` where `RoomNo`='$room_no' ";
	// $query=$dbh->query($sql);
	// if($query->rowCount() > 0){
	// 	echo json_encode(1);
	// }else{
	//     echo json_encode(0);
	// }
}
if(isset($_POST['updateCheckRoomBookNo'])){
	$room_no=$_POST['room_no'];
	$RoomID=$_POST['RoomID'];
   if(!empty($room_no)){
	   echo json_encode(checkRoomNoAbility($room_no,$RoomID));
   }else{
	   echo json_encode(0);
   }

}
if(isset($_POST['Total_Room_booking_price'])){
	
	$fromdate=$_POST['fromdate'];
	$todate=$_POST['todate'];
	// echo "<br>".'12345';
	$sql="SELECT * from tblbooking  where  RoomId!='' AND bookingDate Between '".$fromdate." 00:00:00' AND '".$todate." 23:59:59'  ";

	$query = $dbh -> prepare($sql);
	$query->execute();
	$result=$query->fetchAll(PDO::FETCH_ASSOC);
	// print_r($result);
	if($query->rowCount()>0){
		foreach($result as $r){
			$total_price[] = getPricebyRoomId($r['RoomId']);
		}
    }	

	if($total_price){

		echo json_encode(number_format(array_sum($total_price),'2','.',''));
	}else{
		echo json_encode(0);
	}





}
?>