<?php
	include('dbconnection.php');
	
   if(isset($_POST['Login'])){
    $email=$_POST['email'];
    $password=md5($_POST['password']);
	$sql ="SELECT ID FROM tbluser WHERE Email=:email and Password=:password";
    $query=$dbh->prepare($sql);
    $query->bindParam(':email',$email,PDO::PARAM_STR);
	$query-> bindParam(':password', $password, PDO::PARAM_STR);
	$query-> execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);
	if($query->rowCount() > 0){
	foreach ($results as $result) {
	$_SESSION['hbmsuid']=$result->ID;
	}
	$_SESSION['login']=$_POST['email'];
	
	 $responce=array('status'=>'success', 'msg'=>'Login Successfully');
     echo json_encode($responce);
	 
   }else{
	 $responce=array('status'=>'wrong', 'msg'=>'Invalid Username and Password !');
     echo json_encode($responce);	    
    }
   }

  if(isset($_POST['Bookroom'])){
     $booknum=mt_rand(100000000, 999999999);
	//  $rid=intval($_GET['rmid']);
	 $uid=$_SESSION['hbmsuid'];
     $rid=intval($_POST['room_id']);
     $idtype=$_POST['idtype'];
	 $gender=$_POST['gender'];
	 $address=$_POST['address'];
	 $checkindate=$_POST['checkindate'];
	 $checkoutdate=$_POST['checkoutdate'];
   
 $cdate=date('Y-m-d');
if($checkindate <  $cdate){
	$responce=array('status'=>'gdate', 'msg'=>'Check in date must be greater than current date');
	echo json_encode($responce);
} else if($checkindate > $checkoutdate){
	$responce=array('status'=>'indate', 'msg'=>'Check out date must be equal to / greater than  check in date');
	echo json_encode($responce);
} else {
	$sql="insert into tblbooking(RoomId,BookingNumber,UserID,IDType,Gender,Address,CheckinDate,CheckoutDate)values(:rid,:booknum,:uid,:idtype,:gender,:address,:checkindate,:checkoutdate)";
	$query=$dbh->prepare($sql);
	$query->bindParam(':rid',$rid,PDO::PARAM_STR);
	$query->bindParam(':booknum',$booknum,PDO::PARAM_STR);
	$query->bindParam(':uid',$uid,PDO::PARAM_STR);
	$query->bindParam(':idtype',$idtype,PDO::PARAM_STR);
	$query->bindParam(':gender',$gender,PDO::PARAM_STR);
	$query->bindParam(':address',$address,PDO::PARAM_STR);
	$query->bindParam(':checkindate',$checkindate,PDO::PARAM_STR);
	$query->bindParam(':checkoutdate',$checkoutdate,PDO::PARAM_STR);
	 $query->execute();

   $LastInsertId=$dbh->lastInsertId();
   if ($LastInsertId>0) {  
	 $responce=array('status'=>'success', 'msg'=>'Your room has been book successfully. Booking Number is "'.$booknum.'"');
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

?>