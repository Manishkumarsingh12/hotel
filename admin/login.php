<?php
	include('includes/dbconnection.php');

	?>
<!DOCTYPE HTML>
<html>
<head>
<title>Hotel Booking Management System | login page</title>

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<!-- Graph CSS -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- jQuery -->
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<!-- lined-icons -->
<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />

<!-- //lined-icons -->
<script src="js/jquery-1.10.2.min.js"></script>

</head> 
<body>
	<p style="padding-top: 20px;padding-left: 20px"><a href="../index.php"><i class="fa fa-home" aria-hidden="true" style="font-size: 30px;padding-right: 10px"></i>Back Home!!!</a></p>
   <div class="page-container">
   <!--/content-inner-->
   
	<div class="left-content" >
	   <div class="inner-content" >
		
			<div class="content">
				<h3 style="color: red;font-family: cursive; text-align: center;">Hotel Booking Management Sytem</h3>
	<div class="women_main">
		<!-- start content -->
	<div class="registration">
		
	<div class="registration_class" style="margin-left: auto;
    margin-right: auto;
    width: 50%;">

		<h2>Please sign in</h2>
		 <div class="registration_form">
		 <!-- Form -->
			<form method="post" id="Loginform">
				<div>
					<label>
						<input placeholder="Username" type="text" required="true" name="username" style="border:solid #000 1px;" value="<?php if(isset($_COOKIE["user_login"])) { echo $_COOKIE["user_login"]; } ?>">
					</label>
				</div>
				<div>
					<label>
						<input placeholder="password" type="Password" name="password" required="true" style="border:solid #000 1px;" value="<?php if(isset($_COOKIE["userpassword"])) { echo $_COOKIE["userpassword"]; } ?>">
					</label>
				</div>	
				<div class="checkbox checkbox-primary" style="padding-left: 20px">
                <input type="checkbox" id="remember" name="remember"  <?php if(isset($_COOKIE["user_login"])) { ?> checked <?php } ?> />
                <label for="keep_me_logged_in">Keep me signed in</label>
              </div>					
				<div class="bottom" style="text-align:center">
					<input type="submit" value="sign in" name="login">
				    <br><br>
					<a href="forgot-password.php">forgot your password</a>
				</div>
			</form>
			<!-- /Form -->
			</div>
	</div>
	<div class="clearfix"></div>
	</div>

	<!-- end content -->

</div>
</div>
	<!--content-->
		</div>
</div>
				
							  <div class="clearfix"></div>	
							</div>
							<script>
							var toggle = true;
										
							$(".sidebar-icon").click(function() {                
							  if (toggle)
							  {
								$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
								$("#menu span").css({"position":"absolute"});
							  }
							  else
							  {
								$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
								setTimeout(function() {
								  $("#menu span").css({"position":"relative"});
								}, 400);
							  }
											
											toggle = !toggle;
										});
							</script>
<!--js -->
<script src="js/jquery.nicescroll.js"></script>
<script src="js/scripts.js"></script>
<!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.min.js"></script>
   <!-- /Bootstrap Core JavaScript -->
   <!-- real-time -->
<script language="javascript" type="text/javascript" src="js/jquery.flot.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" media="all">
	
	<!-- /real-time -->
<script src="js/jquery.fn.gantt.js"></script>
 <script src="js/menu_jquery.js"></script>


	<script type="text/javascript">
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
			
		
		
		
		
	  
	   $('#Loginform').on("submit",function(e){
		   e.preventDefault();
			$(this).append('<input type="hidden"   name="Login"/>');
			
			$('button[type=submit], input[type=submit]').prop('disabled',true);
            $('button[type=submit], input[type=submit]').val('Please wait...');

			$.ajax({
				type: "POST",
			    url : 'includes/AdminController.php',
				data : $(this).serialize(),
				success: function (responce) {
                  var responce = JSON.parse(responce);
                  if(responce.status=='success'){
					$('button[type=submit], input[type=submit]').prop('disabled',false);
                    $('button[type=submit], input[type=submit]').val('LOGIN');
					toastr["success"](responce.msg); 
					window.setTimeout(function() {
						window.location.href = 'dashboard.php';
					}, 2000);
                   // location.href="index.php";					
					  
				  }else if(responce.status=='wrong'){
					$('button[type=submit], input[type=submit]').prop('disabled',false);
                    $('button[type=submit], input[type=submit]').val('LOGIN');
					toastr["error"](responce.msg);   
				  }
				}					
			});

	   });	
		


	</script>

</body>
</html>