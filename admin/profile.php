<?php

session_start();

error_reporting(0);

include('includes/dbconnection.php');
include('includes/myfunction.php');

if (strlen($_SESSION['hbmsaid']==0)) {

  header('location:logout.php');

  } else{

    if(isset($_POST['submit'])){
		// echo "<pre>";
		// print_r($_POST);
		// print_r($_FILES);
		// echo "<pre>";

		// die;

    $adminid=$_SESSION['hbmsaid'];

    $CompanyName=$_POST['CompanyName'];
    $AName=$_POST['adminname'];

	$mobno=$_POST['mobilenumber'];

	$email=$_POST['email'];
	$Address=$_POST['Address'];
	$Pin=$_POST['Pin'];
	$State=$_POST['State'];
//   $Logo=$_POST['Logo'];

     $img_name=$_FILES['Logo']['name'];

  


	if(!empty($img_name)){

		$extension=pathinfo($img_name,PATHINFO_EXTENSION);
		$img=explode('.',$img_name);
		$full_imageName=$img[0].'_'.date('YmdHis').'.'.$extension;
		
		if(!move_uploaded_file($_FILES['Logo']['tmp_name'],"images/admin/".$full_imageName)){
			echo '<script>alert("Image not uploaded")</script>';
		}
			
		
		$sql="update tbladmin set CompanyName=:CompanyName, AdminName=:adminname,MobileNumber=:mobilenumber,Email=:email,Address=:Address,Pin=:Pin,State=:State,Logo=:full_imageName where ID=:aid";

        $query = $dbh->prepare($sql);
        $query->bindParam(':adminname',$AName,PDO::PARAM_STR);
		$query->bindParam(':full_imageName',$full_imageName,PDO::PARAM_STR);
	}else{
		$sql="update tbladmin set CompanyName=:CompanyName, AdminName=:adminname,MobileNumber=:mobilenumber,Email=:email,Address=:Address,Pin=:Pin,State=:State where ID=:aid";

        $query = $dbh->prepare($sql);
        $query->bindParam(':adminname',$AName,PDO::PARAM_STR);
	}
     $query->bindParam(':CompanyName',$CompanyName,PDO::PARAM_STR);
     $query->bindParam(':adminname',$AName,PDO::PARAM_STR);

     $query->bindParam(':email',$email,PDO::PARAM_STR);

     $query->bindParam(':mobilenumber',$mobno,PDO::PARAM_STR);

     $query->bindParam(':aid',$adminid,PDO::PARAM_STR);
	 $query->bindParam(':Address',$Address,PDO::PARAM_STR);
	 $query->bindParam(':Pin',$Pin,PDO::PARAM_STR);
	 $query->bindParam(':State',$State,PDO::PARAM_STR);

    $query->execute();
	// echo "<pre>";
	//  var_dump($query->debugDumpParams());
    echo '<script>alert("Profile has been updated")</script>';

     echo "<script>window.location.href ='profile.php'</script>";



  }

  ?>

<!DOCTYPE HTML>

<html>

<head>

<title>Hotel Booking Management System | Profile</title>



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

<script src="js/pie-chart.js" type="text/javascript"></script>

 <script type="text/javascript">



        $(document).ready(function () {

            $('#demo-pie-1').pieChart({

                barColor: '#3bb2d0',

                trackColor: '#eee',

                lineCap: 'round',

                lineWidth: 8,

                onStep: function (from, to, percent) {

                    $(this.element).find('.pie-value').text(Math.round(percent) + '%');

                }

            });



            $('#demo-pie-2').pieChart({

                barColor: '#fbb03b',

                trackColor: '#eee',

                lineCap: 'butt',

                lineWidth: 8,

                onStep: function (from, to, percent) {

                    $(this.element).find('.pie-value').text(Math.round(percent) + '%');

                }

            });



            $('#demo-pie-3').pieChart({

                barColor: '#ed6498',

                trackColor: '#eee',

                lineCap: 'square',

                lineWidth: 8,

                onStep: function (from, to, percent) {

                    $(this.element).find('.pie-value').text(Math.round(percent) + '%');

                }

            });



           

        });



    </script>

</head> 

<body>

   <div class="page-container">

   <!--/content-inner-->

	<div class="left-content">

	   <div class="inner-content">

		<!-- header-starts -->

			<?php include_once('includes/header.php');?>

				

				<!--content-->

			<div class="content">

<div class="women_main">

	<!-- start content -->

	<div class="grids">

					<div class="progressbar-heading grids-heading">

						<h2>Admin Profile</h2>

					</div>

					<div class="panel panel-widget forms-panel">

						<div class="forms">

							<div class="form-grids widget-shadow" data-example-id="basic-forms"> 

								<div class="form-title">

									<h4>Admin Profile :</h4>

								</div>

								<div class="form-body">

									<?php



$sql="SELECT * from  tbladmin";

$query = $dbh -> prepare($sql);

$query->execute();

$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;

if($query->rowCount() > 0)

{

foreach($results as $row)

{               ?>

									<form method="post" enctype="multipart/form-data">

									 <div class="form-group"> <label for="exampleInputEmail1">Company Name</label> <input type="text" class="form-control"  name="CompanyName" value="<?php  echo $row->CompanyName;?>" required='true'> </div> 
									 <div class="form-group"> <label for="exampleInputEmail1">Admin Name</label> <input type="text" class="form-control"  name="adminname" value="<?php  echo $row->AdminName;?>" required='true'> </div> 

									 <div class="form-group"> <label for="exampleInputEmail1">User Name</label> <input type="text" class="form-control" name="username" value="<?php  echo $row->UserName;?>" readonly="true"> </div>

									 <div class="form-group"> <label for="exampleInputEmail1">Email</label> <input type="email" class="form-control" name="email" value="<?php  echo $row->Email;?>" required='true'> </div>

									 <div class="form-group"> <label for="exampleInputEmail1">Contact Number</label> <input type="text" class="form-control" name="mobilenumber" value="<?php  echo $row->MobileNumber;?>" required='true' maxlength='10'> </div>
									 <div class="form-group"> <label for="exampleInputEmail1">Address</label> <input type="text" class="form-control" name="Address" value="<?php  echo $row->Address;?>" required='true' > </div>
									 <div class="form-group"> <label for="exampleInputEmail1">Pin Code</label> <input type="text" class="form-control" name="Pin" value="<?php  echo $row->Pin;?>" required='true' maxlength='6'> </div>
									 <div class="form-group"> <label for="exampleInputEmail1">State</label> <input type="text" class="form-control" name="State" value="<?php  echo $row->State;?>" required='true' > </div>

									 <div class="row">
										<div  class="col-md-6" style="padding-left:0px !important">
											<div class="form-group"> <label for="exampleInputEmail1">Logo</label>
											<input type="file" class="form-control" name="Logo"   > </div>


											<div class="form-group"> <label for="exampleInputEmail1">Admin Registration Date</label> <input type="text" class="form-control" id="email2" name="" value="<?php  echo $row->AdminRegdate;?>" readonly="true"> </div>
										</div>	
										<div  class="col-md-4" style="margin-left:20px;">
										<!-- <label>Logo</label> -->
										<img src="<?=getCompanyDetails()['Logo_path']?>" title="<?=getCompanyDetails()['CompanyName']?>" style="width:130px; height:130px ;border-radius:20px max-width: 300px" />
										</div>
									 </div>	

									<?php $cnt=$cnt+1;}} ?>

									   

									   <button type="submit" class="btn btn-default" name="submit">Submit</button> </form> 

								</div>

							</div>

						</div>

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

			<?php include_once('includes/sidebar.php');?>

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

	<script type="text/javascript">



	$(function() {



		// We use an inline data source in the example, usually data would

		// be fetched from a server



		var data = [],

			totalPoints = 300;



		function getRandomData() {



			if (data.length > 0)

				data = data.slice(1);



			// Do a random walk



			while (data.length < totalPoints) {



				var prev = data.length > 0 ? data[data.length - 1] : 50,

					y = prev + Math.random() * 10 - 5;



				if (y < 0) {

					y = 0;

				} else if (y > 100) {

					y = 100;

				}



				data.push(y);

			}



			// Zip the generated y values with the x values



			var res = [];

			for (var i = 0; i < data.length; ++i) {

				res.push([i, data[i]])

			}



			return res;

		}



		// Set up the control widget



		var updateInterval = 30;

		$("#updateInterval").val(updateInterval).change(function () {

			var v = $(this).val();

			if (v && !isNaN(+v)) {

				updateInterval = +v;

				if (updateInterval < 1) {

					updateInterval = 1;

				} else if (updateInterval > 2000) {

					updateInterval = 2000;

				}

				$(this).val("" + updateInterval);

			}

		});



		var plot = $.plot("#placeholder", [ getRandomData() ], {

			series: {

				shadowSize: 0	// Drawing is faster without shadows

			},

			yaxis: {

				min: 0,

				max: 100

			},

			xaxis: {

				show: false

			}

		});



		function update() {



			plot.setData([getRandomData()]);



			// Since the axes don't change, we don't need to call plot.setupGrid()



			plot.draw();

			setTimeout(update, updateInterval);

		}



		update();



		// Add the Flot version string to the footer



		$("#footer").prepend("Flot " + $.plot.version + " &ndash; ");

	});



	</script>

<!-- /real-time -->

<script src="js/jquery.fn.gantt.js"></script>

    <script>



		$(function() {



			"use strict";



			$(".gantt").gantt({

				source: [{

					name: "Sprint 0",

					desc: "Analysis",

					values: [{

						from: "/Date(1320192000000)/",

						to: "/Date(1322401600000)/",

						label: "Requirement Gathering", 

						customClass: "ganttRed"

					}]

				},{

					name: " ",

					desc: "Scoping",

					values: [{

						from: "/Date(1322611200000)/",

						to: "/Date(1323302400000)/",

						label: "Scoping", 

						customClass: "ganttRed"

					}]

				},{

					name: "Sprint 1",

					desc: "Development",

					values: [{

						from: "/Date(1323802400000)/",

						to: "/Date(1325685200000)/",

						label: "Development", 

						customClass: "ganttGreen"

					}]

				},{

					name: " ",

					desc: "Showcasing",

					values: [{

						from: "/Date(1325685200000)/",

						to: "/Date(1325695200000)/",

						label: "Showcasing", 

						customClass: "ganttBlue"

					}]

				},{

					name: "Sprint 2",

					desc: "Development",

					values: [{

						from: "/Date(1326785200000)/",

						to: "/Date(1325785200000)/",

						label: "Development", 

						customClass: "ganttGreen"

					}]

				},{

					name: " ",

					desc: "Showcasing",

					values: [{

						from: "/Date(1328785200000)/",

						to: "/Date(1328905200000)/",

						label: "Showcasing", 

						customClass: "ganttBlue"

					}]

				},{

					name: "Release Stage",

					desc: "Training",

					values: [{

						from: "/Date(1330011200000)/",

						to: "/Date(1336611200000)/",

						label: "Training", 

						customClass: "ganttOrange"

					}]

				},{

					name: " ",

					desc: "Deployment",

					values: [{

						from: "/Date(1336611200000)/",

						to: "/Date(1338711200000)/",

						label: "Deployment", 

						customClass: "ganttOrange"

					}]

				},{

					name: " ",

					desc: "Warranty Period",

					values: [{

						from: "/Date(1336611200000)/",

						to: "/Date(1349711200000)/",

						label: "Warranty Period", 

						customClass: "ganttOrange"

					}]

				}],

				navigate: "scroll",

				scale: "weeks",

				maxScale: "months",

				minScale: "days",

				itemsPerPage: 10,

				onItemClick: function(data) {

					alert("Item clicked - show some details");

				},

				onAddClick: function(dt, rowId) {

					alert("Empty space clicked - add an item!");

				},

				onRender: function() {

					if (window.console && typeof console.log === "function") {

						console.log("chart rendered");

					}

				}

			});



			$(".gantt").popover({

				selector: ".bar",

				title: "I'm a popover",

				content: "And I'm the content of said popover.",

				trigger: "hover"

			});



			prettyPrint();



		});



    </script>

		   <script src="js/menu_jquery.js"></script>

</body>

</html><?php }  ?>