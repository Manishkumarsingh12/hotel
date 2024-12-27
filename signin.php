<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

?>
<!DOCTYPE HTML>
<html>
<head>
<title>Hotel Booking Management System | Hotel :: Login Page</title>
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

      <h2>If you have an account with us, please log in.</h2>

      <div class="contact-grids">

        <div class="col-md-6 col-sm-6 col-md-offset-3 col-sm-offset-3 contact-right" style="background-color: #ebedf1;">
          <form name="RegForm" onsubmit="return FormValidation()" method="post" id="Loginform">

            <h5>Email Address</h5>
            <input type="email" class="form-control" value="" name="email">

            <h5>Password</h5>
            <input type="password" value="" class="form-control" name="password">
            <br />
            <a href="forgot-password.php">Forgot your password?</a>
            <br />
            <input type="submit" value="Login" name="login">
          </form>

        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>

		<?php include_once('includes/getintouch.php');?>
			</div>
			
	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<script src="js/jquery-1.11.1.min.js"  ></script>
	<script src="js/bootstrap.js" ></script>
	<script src="js/responsiveslides.min.js" ></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" media="all">

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
		
		
		
		
       
	   $('#Loginform').on("submit",function(e){
		   e.preventDefault();
			$(this).append('<input type="hidden"   name="Login"/>');
			
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
                    $('button[type=submit], input[type=submit]').val('LOGIN');
					toastr["success"](responce.msg); 
					window.setTimeout(function() {
						window.location.href = 'index.php';
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
			
			
			
			<?php include_once('includes/footer.php');?>
</html>


<!-- Form Validation -->

<script>
    function FormValidation() {
        var email = document.forms.RegForm.email.value;
        var password = document.forms.RegForm.password.value;

        var regEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

        if (email.trim() === "" || !regEmail.test(email)) {
            alert("Please enter a valid email address.");
            document.forms.RegForm.email.focus();
            return false;
        }

        if (password.trim() === "") {
            alert("Please enter your password.");
            document.forms.RegForm.password.focus();
            return false;
        }

        return true;
    }
</script>