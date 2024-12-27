<?php
include('includes/dbconnection.php');

?>
<!DOCTYPE HTML>
<html>
<head>
<title>Hotel Booking Management System | Add Room</title>

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<!-- Graph CSS -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- jQuery -->
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>


  
  
<!-- lined-icons -->
<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
<script src="js/simpleCart.min.js"> </script>
<script src="js/amcharts.js"></script>	
<script src="js/serial.js"></script>	
<!-- //lined-icons -->
<script src="js/jquery-1.10.2.min.js"></script>
   <!--pie-chart--->
<script src="js/pie-chart.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
  

<style>
.btn-group {
    border-radius: 0.375rem;
    border: 1px solid #ced4da;
}
/* //hide caret sign */
   .btn-group > .multiselect .caret {
	display: none;
   } 
	/* b{
		display: none;
	} */

</style>

</head> 
<body>
   <div class="page-container">
   <!--/content-inner-->
	<div class="left-content">
	   <div class="inner-content">
		<!-- header-starts -->
			<?php include_once('includes/header.php');?>
			<?php include_once('includes/sidebar.php');?>
				
				<!--content-->
			<div class="content">
  <div class="women_main">
	<!-- start content -->
	          <div class="grids">
					<?php 
					// echo 13456456;
					// print_r($_SESSION);
					?>
					
					<div class="container mt-3">
					  <h2>New Booking</h2></hr>
					  
					  <form  method="post" id="Bookroom" >
					  
						<div class="mb-3 mt-3">
						  <label for="name">Name:</label>
						  <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
						</div>
						<div class="mb-3 mt-3">
						  <label for="email">Email:</label>
						  <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email">
						</div>
						<div class="mb-3 mt-3">
						  <label for="phone">Phone:</label>
						  <input type="text" name="phone"  id="phone" class="form-control" required="true" maxlength="10" pattern="[0-9]+" placeholder="Enter Phone Number" >
						</div>
						
							<div class="col-md-6 mb-3 mt-3">
								<label for="room">Choose Avilable Room:</label><br>
									<select  type="text" value="" id="multiple-checkboxes"  name="choose_room[]" required="true" class="form-control" required multiple="multiple">
									<!-- <option value="">Choose Room</option> -->
										<?php 


										$sql2 = "SELECT * from   tblroom ";
										$query2 = $dbh -> prepare($sql2);
										$query2->execute();
										$result2=$query2->fetchAll(PDO::FETCH_OBJ);

										foreach($result2 as $row){?>
										
										<option value="<?php echo htmlentities($row->ID);?>">
										<?php echo htmlentities($row->RoomName).' ('.$row->RoomNo.')';?>
										</option>

										<?php } ?> 
					
																
												
											
										
											
										</select>
							</div>
							<div class="col-md-6 mb-3 mt-3">
								<div class="form-group">
									<label for="exampleInputEmail1">Price:</label> 
									<input type="text" class="form-control" name="price" value="" required='true'> </div>
								</div>
							
						
						
						<div class="mb-3 mt-3">
						  <label for="name">ID Card:</label>
						     <select  type="text" value="" class="form-control" name="idtype" required="true" class="form-control">
									<option value="">Choose ID Type</option>
									<option value="Voter Card">Voter Card</option>
									<option value="Adhar Card">Adhar Card</option>
									<option value="Driving Licence Card">Driving Licence Card</option>
									<option value="Passport">Passport</option>
								</select>
						</div>
						
						<div class="mb-3 mt-3">
						<div class="form-group">
							<label for="exampleInputEmail1">Upload Identity Card</label> 
							<input type="file" class="form-control" name="image" value="" required='true'> </div>
						</div>
						
						<div class="mb-3 mt-3">
						 <div class="form-group">
						 <label for="address">Address</label>
						 <textarea type="text" class="form-control" name="address" value=""></textarea>
						 </div> 
						
						</div>
						
						<div class="mb-3">
						  <label for="checkindate" >Checkin Date</label>
								<input  type="date" value="" class="form-control" Min="<?=date('Y-m-d')?>"  id= "checkindate" name="checkindate" required="true">
						</div>
						
						<div class="mb-3">
						  <label for="checkoutdate" >Checkout  Date</label>
								<input  type="date" value="" class="form-control" Min="<?=date('Y-m-d')?>"  id= "checkoutdate" name="checkoutdate" required="true">
						</div>
						
						<div class="form-check mb-3">
						<h5>Gender</h5>	
						 <div class="radio">
						  <label><input type="radio" value="Male" name="gender" checked>Male</label>
						</div>
						<div class="radio">
						  <label><input type="radio" value="Female" name="gender">Female</label>
						</div>
						
						</div>
						<hr>
						 <input type="submit" value="Book Now" name="submit">
					  </form>
					
			       </div>
	
				</div>

	<!-- end content -->
	
<?php include_once('includes/footer.php');?>
</div>

</div>
			<!--content-->
		</div>
</div>



				<!--//content-inner-->
			<!--/sidebar-menu-->
			
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


 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"> 


	
<script src="js/jquery.fn.gantt.js"></script>

<script src="js/menu_jquery.js"></script>
		  <!-- multiple dropdown -->
		  <!-- <link href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.2/js/bootstrap-multiselect.min.js'/>
  <link href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.2/css/bootstrap-multiselect.css'/>
  <link href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.2/css/bootstrap-multiselect.min.css'/>
  <link href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.2/js/bootstrap-multiselect.js'/>    -->

  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.js"></script> -->
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"> -->
  <!-- <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script> -->

<script>
	  $(document).ready(function() {
        $('#multiple-checkboxes').multiselect({
          includeSelectAllOption: true,
        });
    });
	
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
			var form_data = new FormData($(this)[0]);
			$('button[type=submit], input[type=submit]').prop('disabled',true);
            $('button[type=submit], input[type=submit]').val('Please wait...');

			$.ajax({
				type: "POST",
			    url : 'includes/AdminController.php',
				data : form_data,
				cache: false,
				processData: false,
                contentType: false,
				success: function (responce) {
                  var responce = JSON.parse(responce);
                  if(responce.status=='success'){
					$('button[type=submit], input[type=submit]').prop('disabled',false);
                    $('button[type=submit], input[type=submit]').val('Book Now');
					toastr["success"](responce.msg); 
					window.setTimeout(function() {
						window.location.href = 'all-booking.php';
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
		   
		   
</body>
</html>