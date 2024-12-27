<?php
include('includes/dbconnection.php');
if (strlen($_SESSION['hbmsuid']==0)) {
  header('location:logout.php');
  } else{
  ?>
<!DOCTYPE HTML>
<html>
<head>
<title>Hotel Booking Management System | Hotel :: Profile</title>
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
					
					<h2>View Your Profile !!!!!!</h2>
					
				<div class="contact-grids">
					
						<div class="col-md-6 contact-right">
							<form method="post" id="Profile">
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
								<h5>Full Name</h5>
								<input type="text" value="<?php  echo $row->FullName;?>" name="fname" required="true" class="form-control">
								<h5>Mobile Number</h5>
								<input type="text" name="mobno" class="form-control" required="true" maxlength="10" pattern="[0-9]+" value="<?php  echo $row->MobileNumber;?>">
								<h5>Email Address</h5>
								<input type="email" class="form-control" value="<?php  echo $row->Email;?>" name="email" required="true" readonly='true'>
								<h5>Registration Date</h5>
								<input type="text" value="<?php  echo $row->RegDate;?>" class="form-control" name="password" readonly="true">
								<br /><?php $cnt=$cnt+1;}} ?>
								
								<br/>
								 <input type="submit" value="Update" name="submit">
						 	 </form>

						</div>
						<div class="col-md-6 contact-right">
							
						 	 <img src="images/img.jpg" width="400" height="400" />

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
		
		
		
		
       
	   $('#Profile').on("submit",function(e){
		   e.preventDefault();
			$(this).append('<input type="hidden"   name="Profile"/>');
			
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
                    $('button[type=submit], input[type=submit]').val('UPDATE');
					toastr["success"](responce.msg); 
					window.setTimeout(function() {
						window.location.href = 'profile.php';
					}, 2000);		
					  
				  }else if(responce.status=='error'){
					$('button[type=submit], input[type=submit]').prop('disabled',false);
                    $('button[type=submit], input[type=submit]').val('UPDATE');
					toastr["error"](responce.msg); 
                   $('#Profile')[0].reset();						
				  }
				}					
			});

	   });



		</script>				
							
			
			
			
			
			
			
			
			<?php include_once('includes/footer.php');?>
</html><?php }  ?>
