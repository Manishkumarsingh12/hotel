<?php

session_start();

error_reporting(0);

include('includes/dbconnection.php');

if (strlen($_SESSION['hbmsaid']==0)) {

  header('location:logout.php');

  } else{

   



?>

<!DOCTYPE HTML>

<html>

<head>

<title>Hotel Booking Management System | Booking Between Dates Report</title>



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

<script src="js/simpleCart.min.js"> </script>

<script src="js/amcharts.js"></script>	

<script src="js/serial.js"></script>	

<script src="js/light.js"></script>	

<!-- //lined-icons -->

<script src="js/jquery-1.10.2.min.js"></script>

   <!--pie-chart--->



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

					
                    <div class="row">    
                        <div class="col-md-3"> 
                        <div class="progressbar-heading grids-heading">

                            <h2>Sales Report</h2>

                            </div>
                        </div>   
                        <div class="col-md-3">    
                            <div class="form-group"> <label for="exampleInputEmail1">From Date:</label>  <input type="date" class="form-control" id="fromdate" name="fromdate" max="<?=date('Y-m-d')?>" value="<?=date('Y-m-01',strtotime('-1 month'))?>" > </div> 
                        </div>
                        <div class="col-md-3">         

                            <div class="form-group"> <label for="exampleInputEmail1">To Date:</label>  <input type="date" class="form-control" id="todate" name="todate" max="<?=date('Y-m-d')?>" value="<?=date('Y-m-d')?>"> </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"> 
                           <b>Total Amount: <span id="total_amt"></span></b>
                        </div>   
                    </div>

					<div class="panel panel-widget forms-panel">

						<div class="forms">

							<div class="form-grids widget-shadow" data-example-id="basic-forms"> 

								<!-- <div class="form-title">

									<h4>Booking Between Dates Report :</h4>

								</div> -->

								<div class="form-body">
                                   
									

						    <!-- <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination"> -->
						    <table id="table-grid" class="table table-bordered table-striped table-vcenter ">	
                                <thead>

                                    <tr>

                                        <th style="width: 5%;">S.No</th>

                                        <th>Booking Number</th>

                                        <th>Name</th>

                                      
                                        
                                        <th class="d-none d-sm-table-cell">Amount</th>
                                        <th class="d-none d-sm-table-cell">Booking Date</th>

                                        <!-- <th class="d-none d-sm-table-cell">Status</th> -->

                                        <th class="d-none d-sm-table-cell" style="width: 15%;">Action</th>

                                       </tr>

                                </thead>

                        
                            </table>



								</div>

							</div>

						</div>

					</div>

			

	

				</div>



	<!-- end content -->

<?php include_once('includes/datatable_links.php');?>
<?php include_once('includes/footer.php');?>

</div>



</div>

			<!--content-->

		</div>

</div>
<script>



	 $(document).ready(function(){
 			function custom_params() {
                let new_form_data = {
                // section : $("#search_sect").val(),
                fromdate:$('#fromdate').val(),
                todate:$('#todate').val(),
	            }	    
				// globalThis.new_form_data;
	            return new_form_data;
	            }  
        	
			var dataTable = $("#table-grid").DataTable({
                    "lengthMenu": [ [5, 25, 50, 100, 500, -1], [5, 25, 50, 100, 500, 'All'] ],
                    'order':[4,'DESC'],
                    dom: 'Blfrtip',

                    "pageLength":25,
                    buttons: [
                    'copy', 'csv', 'excel', 'print'
                    ],
					"processing": true,
					"serverSide": true,
                    "scrollX": true,
					"ajax":{
						'url' :"sales-reports-table-data.php", // json datasource
						'type': "post",  // method  , by default get
						'data': function(d){
						// ClassType: classtype,
                        d.custom = custom_params() 

						},
						/* 'data': {
								orderType: ordertype,
						}, */
						error: function(response){  // error handling
							$(".grid-error").html("");
							$("#grid").append('<tbody class="grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
							$("#grid_processing").css("display","none");
							
						}
						
					}
			});
			$('#fromdate').on( "change", function() {
			    $('#table-grid').DataTable().ajax.reload();
				 show_total_amount();
			});
            $('#todate').on( "change", function() {
			$('#table-grid').DataTable().ajax.reload();
			    show_total_amount();
			});
	

			});


			function show_total_amount(){
				var fromdate=$('#fromdate').val();
                var todate=$('#todate').val();
				// var custom_date = window.new_form_data;
                // console.log(custom_date.fromdate);
				$('#total_amt').text('');
				    // var data_string = 'fromdate='+ custom_date.fromdate +'&todate='+ custom_date.todate +'&Total_Room_booking_price='+1;
				    var data_string = 'fromdate='+ fromdate +'&todate='+ todate +'&Total_Room_booking_price='+1;
					$.ajax({
						url: "includes/AdminController.php",
						type: "POST",
						data: data_string,
						// contentType: false,
						// cache: false,
						// processData: false,
						success: function(responce) {
							var result = JSON.parse(responce);
							console.log(result);
							if (result){
								$('#total_amt').text(result);
							}else{
								$('#total_amt').text('');
							}	
						}
					})
			}
			show_total_amount();



		</script>	
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

   <!-- /Bootstrap Core JavaScript -->

   <!-- real-time -->

<script language="javascript" type="text/javascript" src="js/jquery.flot.js"></script>


<!-- /real-time -->

<script src="js/jquery.fn.gantt.js"></script>

   



		   <script src="js/menu_jquery.js"></script>

</body>

</html><?php }  ?>