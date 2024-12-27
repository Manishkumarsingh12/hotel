<?php

session_start();

error_reporting(0);

include('includes/dbconnection.php');

if (strlen($_SESSION['hbmsaid'] == 0)) {

    header('location:logout.php');
} else {

    if (isset($_POST['submit'])) {







        $bookingid = $_GET['bookingid'];

        $status = $_POST['status'];

        $remark = $_POST['remark'];





        $sql = "update tblbooking set Status=:status,Remark=:remark where BookingNumber=:bookingid";

        $query = $dbh->prepare($sql);

        $query->bindParam(':status', $status, PDO::PARAM_STR);

        $query->bindParam(':remark', $remark, PDO::PARAM_STR);

        $query->bindParam(':bookingid', $bookingid, PDO::PARAM_STR);



        $query->execute();



        echo '<script>alert("Remark has been updated")</script>';

        echo "<script>window.location.href ='new-booking.php'</script>";
        //  echo "<script>window.location.href ='booking-bwdates-reports-details.php'</script>";

    }

?>

    <!DOCTYPE HTML>

    <html>

    <head>

        <title>Hotel Booking Management System | View Booking</title>



        <script type="application/x-javascript">
            addEventListener("load", function() {
                setTimeout(hideURLbar, 0);
            }, false);

            function hideURLbar() {
                window.scrollTo(0, 1);
            }
        </script>

        <!-- Bootstrap Core CSS -->

        <link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />

        <!-- Custom CSS -->

        <link href="css/style.css" rel='stylesheet' type='text/css' />

        <!-- Graph CSS -->

        <link href="css/font-awesome.css" rel="stylesheet">

        <!-- jQuery -->

        <link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css' />

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
            
        </script>

    </head>

    <body>

        <div class="page-container">

            <!--/content-inner-->

            <div class="left-content">

                <div class="inner-content">

                    <!-- header-starts -->

                    <?php include_once('includes/header.php'); ?>
                    <?php include_once('includes/sidebar.php'); ?>


                    <!--content-->

                    <div class="content">

                        <div class="women_main">

                            <!-- start content -->

                            <div class="grids">

                                <div class="progressbar-heading grids-heading">

                                    <h2>View Package</h2>

                                </div>

                                <div class="panel panel-widget forms-panel">

                                    <div class="forms">

                                        <div class="form-grids widget-shadow" data-example-id="basic-forms">

                                            <div class="form-title">

                                                <h4>View Package</h4>

                                            </div>

                                            <div class="form-body">

                                                <?php



                                                $pid = $_GET['pid'];

                                                $sql = "SELECT * From `tblpackage` where `id`=:pid";

                                                $query = $dbh->prepare($sql);
                                                $query->bindParam(':pid', $pid, PDO::PARAM_STR);
                                                $query->execute();
                                                // echo "<pre>";
                                                //  var_dump($query->debugDumpParams());
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);



                                                $cnt = 1;

                                                if ($query->rowCount() > 0) {

                                                    foreach ($results as $row) {               ?>

                                                        <table border="1" class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">


                                                            <tr>

                                                                <th colspan="4" style="color: blue;font-weight: bold;font-size: 15px">Package Detail:</th>

                                                            </tr>

                                                            <tr>

                                                                <th>Package Name</th>

                                                                <td><?php echo $row->package_name; ?></td>

                                                                <th>Package Price</th>

                                                                <td><?php echo $row->package_price; ?></td>

                                                            </tr>





                                                            <tr>
                                                                <th>Status</th>

                                                                <td><?php echo ($row->status=='1') ? 'Active' : 'Deactive' ; ?></td>

                                                                <th>Create At</th>

                                                                <td><?php echo $row->create_date; ?></td>

                                                            </tr>

                                                           




                                                            <!-- ------------------------------------------------------------------- -->
                                                            <?php
                                                            $roodids = explode(',', $row->room);
                                                            // print_r($roodids);
                                                            foreach ($roodids as $roomid) {

                                                                $sql1 = "SELECT tblroom.RoomName,tblroom.MaxAdult,tblroom.MaxChild,tblroom.RoomDesc,tblroom.NoofBed,tblroom.Image,tblroom.RoomFacility ,tblcategory.CategoryName,tblcategory.Description,tblcategory.Price  from `tblroom` join tblcategory on tblcategory.ID=tblroom.RoomType  where tblroom.ID=:roomid ";

                                                                $query2 = $dbh->prepare($sql1);
                                                                $query2->bindParam(':roomid', $roomid, PDO::PARAM_STR);

                                                                $query2->execute();
                                                                // echo "<pre>";
                                                                //  var_dump($query2->debugDumpParams());
                                                                //  echo "</pre>";
                                                                $ress2 = $query2->fetchAll(PDO::FETCH_OBJ);
                                                                // echo "<pre>";
                                                                // print_r($ress);
                                                                //  echo "</pre>";
                                                                if ($query2->rowCount() > 0) {

                                                                    foreach ($ress2 as $ress) {?>
                                                                
                                                                        <tr>

                                                                            <th colspan="4" style="color: blue;font-weight: bold;font-size: 15px"> Room Detail:</th>

                                                                        </tr>
                                                                        <tr>
                                                                            <th>Room Type</th>

                                                                            <td><?php echo $ress->CategoryName; ?></td>

                                                                            <th>Room Price(perday)</th>

                                                                            <td>&#x20b9; <?php echo $ress->Price; ?></td>

                                                                        </tr>



                                                                        <tr>



                                                                            <th>Room Name</th>

                                                                            <td><?php echo $ress->RoomName; ?></td>

                                                                            <th>Room Description</th>

                                                                            <td><?php echo $ress->RoomDesc; ?></td>

                                                                        </tr>

                                                                        <tr>



                                                                            <th>Max Adult</th>

                                                                            <td><?php echo $ress->MaxAdult; ?></td>

                                                                            <th>Max Child</th>

                                                                            <td><?php echo $ress->MaxChild; ?></td>

                                                                        </tr>

                                                                        <tr>
                                                                            <th>No.of Bed</th>

                                                                            <td><?php echo $ress->NoofBed; ?></td>

                                                                            <th>Room Image</th>

                                                                            <td><img src="images/<?php echo $ress->Image; ?>" width="100" height="100" value="<?php echo $row->Image; ?>"></td>

                                                                        </tr>
                                                                        <tr>
                                                                            <th>Room Facility</th>

                                                                            <td><?php echo $ress->RoomFacility; ?></td>

                                                                            <th>Booking Date</th>

                                                                            <td><?php echo $ress->BookingDate; ?></td>

                                                                        </tr>
                                                <?php
                                                                    }
                                                                }
                                                            
                                                            
                                                            }
                                                                if(!empty($row->images) ){?>
                                                                    <!-- package Images -->
                                                                    <tr>
                                                                        <th>Package Images:</th>

                                                                        <td colspan='3'>
                                                                            <?php
                                                                            $multi_images = explode(',', $row->images);
                                                                            // print_r($roodids);
                                                                            $y=1;
                                                                            foreach($multi_images as $img) {
                                                                                if(!empty($img) && file_exists("images/packages/".trim($img))){
                                                                                ?>
                                                                                  <img src="images/packages/<?=trim($img)?>" width="100" height="100" >

                                                                        <?php  }
                                                                    if($y=='5'){
                                                                        echo "<br>";
                                                                    }
                                                                    $y++;
                                                                    } ?>
                                                                    
                                                                    
                                                                        </td>
                                                                    </tr>
                                                                    <!-- //package Images -->
                                                                <?php
                                                                }
                                                                    ?>


                                                            


                                                        </table>
                                                    <?php }
                                                    }?>    
                                            </div>
                                            <?php include_once('includes/footer.php'); ?>

                                        </div>



                                    </div>

                                    <!--content-->

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

                            <!--//content-inner-->

                            <!--/sidebar-menu-->

                            




                            <script src="js/menu_jquery.js"></script>
                            <script src="js/pages/be_tables_datatables.js"></script>

    </body>

    </html>
    <?php }  ?>