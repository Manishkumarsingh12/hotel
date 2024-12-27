<?php
include('includes/dbconnection.php');
if (strlen($_SESSION['hbmsuid']==0)) {
  header('location:logout.php');
  } else{

?>
<!DOCTYPE HTML>
<html>
<head>
<title>Hotel Booking Management System | Hotel :: Book Room</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />



</head>
<body>
		<!--header-->
			<div class="header head-top">
				<div class="container">
			<?php include_once('includes/header.php');?>
		</div>
</div>
<!--header-->
		<!--about-->
		
			<div class="content">
				<div class="contact">
				<div class="container">
					<h2>Book Your Room</h2>
					
				<div class="contact-grids">
					
						<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 contact-right">
							<form method="post" id="Bookroom">
					
									
								</select>
								<?php
								$uid=$_SESSION['hbmsuid'];
								$sql="SELECT * from  tbluser where ID=:uid";
								$query = $dbh -> prepare($sql);
								$query->bindParam(':uid',$uid,PDO::PARAM_STR);
								$query->execute();
								$results=$query->fetchAll(PDO::FETCH_OBJ);
								$cnt=1;
								if($query->rowCount() > 0)
								{
								foreach($results as $row)
								{               ?>
								<h5>Name</h5>
								<input type="text"  value="<?php  echo $row->FullName;?>" name="name" class="form-control" required="true" readonly="true">
								<h5>Mobile Number</h5>
								<input type="text" name="phone" class="form-control" required="true" maxlength="10" pattern="[0-9]+" value="<?php  echo $row->MobileNumber;?>" readonly="true">
								<h5>Email Address</h5>
								<input  type="email" value="<?php  echo $row->Email;?>" class="form-control" name="email" required="true" readonly="true"><?php $cnt=$cnt+1;}} ?>
								<h5>ID Type</h5>
								<select  type="text" value="" class="form-control" name="idtype" required="true" class="form-control">
									<option value="">Choose ID Type</option>
									<option value="Voter Card">Voter Card</option>
									<option value="Adhar Card">Adhar Card</option>
									<option value="Driving Licence Card">Driving Licence Card</option>
									<option value="Passport">Passport</option>
								</select>
								
							<h5>Gender</h5>	
							<div class="form-check form-check-inline">
							  <input class="form-check-input" type="radio" name="gender" id="gender">
							  <label class="form-check-label" for="gender">
								Male
							  </label>
							</div>
							<div class="form-check form-check-inline">
							  <input class="form-check-input" type="radio" name="gender" id="gender1" checked>
							  
							  <label class="form-check-label" for="gender1">
								Female
							  </label>
							</div>
								
							
							    <input  type="hidden" name="room_id"  value="<?=$_GET['rmid']?>" required>
								<h5>Address</h5>
								 <textarea type="text" rows="10" name="address" required="true"></textarea>
								 <h5>Checkin Date</h5>
								<input  type="date" value="" class="form-control" name="checkindate" required="true">
								<h5>Checkout Date</h5>
								<input  type="date" value="" class="form-control" name="checkoutdate" required="true">
								
								 <input type="submit" value="Book Now" name="submit">
						 	 </form>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		<?php include_once('includes/getintouch.php');?>
			</div>

	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/responsiveslides.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"> 


 <script>
    $(function () {
      $("#slider").responsiveSlides({
      	auto: true,
      	nav: true,
      	speed: 500,
        namespace: "callbacks",
        pager: true,
      });
    });
  </script>
			
<script>
		
	$(document).ready(function(){

		toastr.options = {


			"closeButton": false,


			"debug": false,


			"newestOnTop": false,


			"progressBar": false,


			"positionClass": "toast-top-right",


			"preventDuplicates": false,


			"onclick": null,


			"showDuration": "300",


			"hideDuration": "1000",


			"timeOut": "5000",


			"extendedTimeOut": "1000",


			"showEasing": "swing",


			"hideEasing": "linear",


			"showMethod": "fadeIn",


			"hideMethod": "fadeOut"


			}

	});			
		
		
		
		
       
	   $('#Bookroom').on("submit",function(e){
		   e.preventDefault();
			$(this).append('<input type="hidden"   name="Bookroom"/>');
			
			$('button[type=submit], input[type=submit]').prop('disabled',true);
            $('button[type=submit], input[type=submit]').val('Please wait...');

			$.ajax({
				type: "POST",
			    url : 'includes/FrontController.php',
				data : $(this).serialize(),
				success: function (responce) {
                  var responce = JSON.parse(responce);
                  if(responce.status=='success'){
					$('button[type=submit], input[type=submit]').prop('disabled',false);
                    $('button[type=submit], input[type=submit]').val('Book Now');
					toastr["success"](responce.msg); 
					window.setTimeout(function() {
						window.location.href = 'index.php';
					}, 2000);
                   				
					  
				  }else if(responce.status=='gdate'){
					$('button[type=submit], input[type=submit]').prop('disabled',false);
                    $('button[type=submit], input[type=submit]').val('Book Now');
					toastr["error"](responce.msg);   
				  }else if(responce.status=='indate'){
					$('button[type=submit], input[type=submit]').prop('disabled',false);
                    $('button[type=submit], input[type=submit]').val('Book Now');
					toastr["error"](responce.msg);  
					  
				  }else{
					$('button[type=submit], input[type=submit]').prop('disabled',false);
                    $('button[type=submit], input[type=submit]').val('Book Now');
					toastr["error"](responce.msg);  
					    
					  
				  }
				}					
			});

	   });



		</script>			
						
			
			
			
			
			<?php include_once('includes/footer.php');?>
</html><?php }  ?>
