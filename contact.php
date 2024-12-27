<?php
 include('includes/dbconnection.php');

?>
<!DOCTYPE HTML>
<html>
<head>
<title>Hotel Booking Management System | Hotel :: Contact Us</title>
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
					<h2>contact us</h2>
				<div class="contact-grids">
					<br>
					<div class="col-md-6 contact-left">
						<?php
						$sql="SELECT * from tblpage where PageType='aboutus'";
						$query = $dbh ->prepare($sql);
						$query->execute();
						$results=$query->fetchAll(PDO::FETCH_OBJ);
						$cnt=1;
						if($query->rowCount() > 0)
						{
						foreach($results as $row){ 
						?>
						<p><?php  echo htmlentities($row->PageDescription);?>.</p>
						<?php $cnt=$cnt+1;}} ?>
						<?php
						$sql="SELECT * from tblpage where PageType='contactus'";
						$query = $dbh -> prepare($sql);
						$query->execute();
						$results=$query->fetchAll(PDO::FETCH_OBJ);

						$cnt=1;
						if($query->rowCount() > 0)
						{
						foreach($results as $row)
						{               ?>
							<address>
								<p><?php  echo htmlentities($row->PageTitle);?></p>
								<p><?php  echo htmlentities($row->PageDescription);?></p>
								
								<p>Telephone : +<?php  echo htmlentities($row->MobileNumber);?></p>
							
								<p>E-mail : <?php  echo htmlentities($row->Email);?></p>
							</address><?php $cnt=$cnt+1;}} ?>
					</div>
						<div class="col-md-6 contact-right">
							<form method="post" id="contact-us">
								<h5>Name</h5>
								<input type="text"  type="text" value="" name="name" required="true">
								<h5>Mobile Number</h5>
								<input type="text" name="phone" required="true" maxlength="10" pattern="[0-9]+">
								<h5>Email Address</h5>
								<input type="text" type="email" value="" name="email" required="true">
								<h5>Message</h5>
								 <textarea rows="10" name="message" required="true"></textarea>
								 <input type="submit" value="send" name="submit">
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
		
		
		
		
       
	   $('#contact-us').on("submit",function(e){
		   e.preventDefault();
			$(this).append('<input type="hidden"   name="Contactus"/>');
			
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
                    $('button[type=submit], input[type=submit]').val('Send');
					toastr["success"](responce.msg); 
					$('#contact-us')[0].reset();		
					  
				  }else if(responce.status=='error'){
					$('button[type=submit], input[type=submit]').prop('disabled',false);
                    $('button[type=submit], input[type=submit]').val('Send');
					toastr["error"](responce.msg); 
                   $('#contact-us')[0].reset();						
				  }
				}					
			});

	   });



		</script>				
			
			
	<?php include_once('includes/footer.php');?>
</html>
