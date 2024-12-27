<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');


?>
<!DOCTYPE HTML>
<html>
<head>
<title>Hotel Booking Management System | Hotel :: Forgot Password Page</title>
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
					
					<h2>Reset Your Password.</h2>
					
				<div class="contact-grids">
					
						<div class="col-md-6 contact-right">
							<form method="post" name="chngpwd" id="chngpwd" onSubmit="return valid();">
								
								<h5>Email Address</h5>
								<input type="email" placeholder="Email address" class="form-control" value="" name="email" required="true">
								<h5>Mobile Number</h5>
								<input type="text" placeholder="Mobile Number" class="form-control" name="mobile" required="true">
								<h5>New Password</h5>
								<input type="password" placeholder="New Password" name="newpassword" required="true" class="form-control">
								<h5>Confirm Password</h5>
								<input type="password" placeholder="Confirm Password" name="confirmpassword" required="true" class="form-control">
								<br />
								<a href="signin.php" style="color: red">Signin</a>
								<br/>
								 <input type="submit" value="Reset" name="submit">
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
	<script type="text/javascript">
	function valid()
	{
	if(document.chngpwd.newpassword.value!= document.chngpwd.confirmpassword.value)
	{
	alert("New Password and Confirm Password Field do not match  !!");
	document.chngpwd.confirmpassword.focus();
	return false;
	}
	return true;
	}
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
		
		
		
		
       
	   $('#chngpwd').on("submit",function(e){
		   e.preventDefault();
			$(this).append('<input type="hidden"   name="chngpwd"/>');
			
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
                    $('button[type=submit], input[type=submit]').val('RESET');
					toastr["success"](responce.msg); 
					$('#chngpwd')[0].reset();	
					// window.setTimeout(function() {
						// window.location.href = 'profile.php';
					// }, 2000);		
					  
				  }else if(responce.status=='error'){
					$('button[type=submit], input[type=submit]').prop('disabled',false);
                    $('button[type=submit], input[type=submit]').val('RESET');
					toastr["error"](responce.msg); 
                   $('#chngpwd')[0].reset();						
				  }
				}					
			});

	   });



		</script>			
			
			
			
			
			
			
			<?php include_once('includes/footer.php');?>
</html>
