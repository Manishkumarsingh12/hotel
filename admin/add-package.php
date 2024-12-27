<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['hbmsaid'] == 0)) {
    header('location:logout.php');
} else {

?>
    <!DOCTYPE HTML>
    <html>

    <head>
        <title>Hotel Booking Management System | Add Room</title>

        <script type="application/x-javascript">
            addEventListener("load", function() {
                setTimeout(hideURLbar, 0);
            }, false);

            // function hideURLbar() {
            //     window.scrollTo(0, 1);  //after reload page comes on starting screen
            //     // alert(12);
            // }
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

        <!-- jQuery library -->
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

     
        <script src="multiselect/jquery.multiselect.js"></script>
        <link rel="stylesheet" href="multiselect/jquery.multiselect.css"> -->

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>

        <script type="text/javascript">
            // $(document).ready(function() {
            //     $('#demo-pie-1').pieChart({
            //         barColor: '#3bb2d0',
            //         trackColor: '#eee',
            //         lineCap: 'round',
            //         lineWidth: 8,
            //         onStep: function(from, to, percent) {
            //             $(this.element).find('.pie-value').text(Math.round(percent) + '%');
            //         }
            //     });

            //     $('#demo-pie-2').pieChart({
            //         barColor: '#fbb03b',
            //         trackColor: '#eee',
            //         lineCap: 'butt',
            //         lineWidth: 8,
            //         onStep: function(from, to, percent) {
            //             $(this.element).find('.pie-value').text(Math.round(percent) + '%');
            //         }
            //     });

            //     $('#demo-pie-3').pieChart({
            //         barColor: '#ed6498',
            //         trackColor: '#eee',
            //         lineCap: 'square',
            //         lineWidth: 8,
            //         onStep: function(from, to, percent) {
            //             $(this.element).find('.pie-value').text(Math.round(percent) + '%');
            //         }
            //     });


            // });
        </script>
        <style>
            button.multiselect {
                background-color: initial;
                border: 1px solid #ced4da;
            }
        </style>
    </head>

    <body>
        <div class="page-container">
            <!--/content-inner-->
            <div class="left-content">
                <div class="inner-content">
                    <!-- header-starts -->
                    <?php include_once('includes/header.php'); ?>

                    <!--content-->
                    <div class="content">
                        <div class="women_main">
                            <!-- start content -->
                            <div class="grids">
                                <div class="progressbar-heading grids-heading">
                                    <h2>Create Package</h2>
                                </div>
                                <div class="panel panel-widget forms-panel">
                                    <div class="forms">
                                        <div class="form-grids widget-shadow" data-example-id="basic-forms">
                                            <div class="form-title">
                                                <h4>Create Package</h4>
                                            </div>
                                            <div class="form-body">

                                            <?php if(isset($edit_id)){  ?>
                                                <form method="post" enctype="multipart/form-data">
                                                    <!-- <div class="form-group"> <label for="exampleInputEmail1">Room Type or Category</label> <select type="text" name="roomtype" id="roomtype" value="" class="form-control" required="true">
                                                            <option value="">Choose Room Type</option>
                                                            <?php

                                                            $sql2 = "SELECT * from   tblcategory ";
                                                            $query2 = $dbh->prepare($sql2);
                                                            $query2->execute();
                                                            $result2 = $query2->fetchAll(PDO::FETCH_OBJ);

                                                            foreach ($result2 as $row) {
                                                            ?>
                                                                <option value="<?php echo htmlentities($row->ID); ?>"><?php echo htmlentities($row->CategoryName); ?></option>
                                                            <?php } ?>


                                                        </select> </div> -->
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">

                                                                <label for="exampleInputEmail1">Package Name</label> <input type="text" class="form-control" name="packname" value="" required='true'>
                                                            </div>
                                                        </div>


                                                        <div class="col-md-12 mb-3 mt-3">
                                                            <label for="room">Choose Avilable Room:</label><br>
                                                            <select type="text" value="" id="multiple-checkboxes" name="choose_room[]" required="true" class="form-control" multiple="multiple">
                                                                <!-- <option value="">Choose Room</option> -->
                                                                <?php


                                                                $sql2 = "SELECT * from   tblroom ";
                                                                $query2 = $dbh->prepare($sql2);
                                                                $query2->execute();
                                                                $result2 = $query2->fetchAll(PDO::FETCH_OBJ);

                                                                foreach ($result2 as $row) { ?>

                                                                    <option value="<?php echo htmlentities($row->ID); ?>">
                                                                        <?php echo htmlentities($row->RoomName); ?>
                                                                    </option>

                                                                <?php } ?>

                                                            </select>
                                                        </div>

                                                        <div class="col-md-12" style="margin-top:20px">

                                                            <div class="form-group"> <label for="exampleInputEmail1"> Price of per day</label> <input type="number" class="form-control" name="totalPrice" value="" required='true'> </div>
                                                        </div>

                                                    </div>
                                                    <div class="row form-group">


                                                    </div>


                                                    <div class=" row form-group">
                                                        <div class="col-md-12">
                                                            <label for="exampleInputEmail1">Upload Multiple Room Images</label>
                                                            <input type="file" class="form-control" name="images[]" value="" required='true' multiple>
                                                        </div>
                                                    </div>
                                                    <div class=" row form-group">
                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn btn-default btn-lg" name="submit">Submit</button>
                                                        </div>
                                                    </div>
                                                </form>



                                           <?php }else{ ?>
                                            <form method="post" enctype="multipart/form-data">
                                                    <!-- <div class="form-group"> <label for="exampleInputEmail1">Room Type or Category</label> <select type="text" name="roomtype" id="roomtype" value="" class="form-control" required="true">
                                                            <option value="">Choose Room Type</option>
                                                            <?php

                                                            $sql2 = "SELECT * from   tblcategory ";
                                                            $query2 = $dbh->prepare($sql2);
                                                            $query2->execute();
                                                            $result2 = $query2->fetchAll(PDO::FETCH_OBJ);

                                                            foreach ($result2 as $row) {
                                                            ?>
                                                                <option value="<?php echo htmlentities($row->ID); ?>"><?php echo htmlentities($row->CategoryName); ?></option>
                                                            <?php } ?>


                                                        </select> </div> -->
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">

                                                                <label for="exampleInputEmail1">Package Name</label> <input type="text" class="form-control" name="packname" value="" required='true'>
                                                            </div>
                                                        </div>


                                                        <div class="col-md-12 mb-3 mt-3">
                                                            <label for="room">Choose Avilable Room:</label><br>
                                                            <select type="text" value="" id="multiple-checkboxes" name="choose_room[]" required="true" class="form-control" multiple="multiple">
                                                                <!-- <option value="">Choose Room</option> -->
                                                                <?php


                                                                $sql2 = "SELECT * from   tblroom ";
                                                                $query2 = $dbh->prepare($sql2);
                                                                $query2->execute();
                                                                $result2 = $query2->fetchAll(PDO::FETCH_OBJ);

                                                                foreach ($result2 as $row) { ?>

                                                                    <option value="<?php echo htmlentities($row->ID); ?>">
                                                                        <?php echo htmlentities($row->RoomName); ?>
                                                                    </option>

                                                                <?php } ?>

                                                            </select>
                                                        </div>

                                                        <div class="col-md-12" style="margin-top:20px">

                                                            <div class="form-group"> <label for="exampleInputEmail1"> Price of per day</label> <input type="number" class="form-control" name="totalPrice" value="" required='true'> </div>
                                                        </div>

                                                    </div>
                                                    <div class="row form-group">


                                                    </div>


                                                    <div class=" row form-group">
                                                        <div class="col-md-12">
                                                            <label for="exampleInputEmail1">Upload Multiple Room Images</label>
                                                            <input type="file" class="form-control" name="images[]" value="" required='true' multiple>
                                                        </div>
                                                    </div>
                                                    <div class=" row form-group">
                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn btn-default btn-lg" name="submit">Submit</button>
                                                        </div>
                                                    </div>
                                                </form>





                                          <?php  } ?>

                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <!-- end content -->

                            <?php include_once('includes/footer.php'); ?>
                        </div>

                    </div>
                    <!--content-->
                </div>
            </div>
            <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script> -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
            <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" media="all">
            <script>
                $(document).ready(function() {});
                "use strict";
                $(document).ready(function() {
                    $('form').on('submit', function(e) {
                        e.preventDefault();
                        var action = "Add_Package";
                        $(this).append("<input type='hidden' name=" + action + " >");
                        var data_string = new FormData(this);
                        $("button[type='submit']").html("please wait...");
                        $('button[type="submit"]').attr("disabled", true);

                        // alert(name);

                        $.ajax({
                            url: "includes/AdminController.php",
                            type: "POST",
                            data: data_string,
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function(responce) {
                                var result = JSON.parse(responce);
                                // alert(responce);
                                console.log(responce);
                                if (result.status == "success") {
                                    // alert('success');
                                    toastr.success(result.message);
                                    setTimeout(function() {
                                        // window.location.href='dashboard.php?option=';
                                        $('form')[0].reset();
                                    }, 3000);

                                } else {
                                    toastr.error(result.message);
                                }
                                $('button[type="submit"]').html(' Add Room');
                                $('button[type="submit"]').attr("disabled", false);
                            }
                        })
                    });

                });
            </script>
            <!--//content-inner-->
            <!--/sidebar-menu-->
            <?php include_once('includes/sidebar.php'); ?>
            <div class="clearfix"></div>
        </div>
        <!-- <script>
            var toggle = true;

            $(".sidebar-icon").click(function() {
                if (toggle) {
                    $(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
                    $("#menu span").css({
                        "position": "absolute"
                    });
                } else {
                    $(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
                    setTimeout(function() {
                        $("#menu span").css({
                            "position": "relative"
                        });
                    }, 400);
                }

                toggle = !toggle;
            });
        </script> -->
        <script>
            // $('#multiple-checkboxes').multiselect({
            //     columns: 4,
            //     placeholder: 'Select Languages',
            //     search: true,
            //     selectAll: true
            // });
            $(document).ready(function() {
                $('#multiple-checkboxes').multiselect({
                    includeSelectAllOption: true,
                    //   columns: 4,
                    //     placeholder: 'Select Languages',
                    //     search: true,
                    //     selectAll: true
                });
            });
        </script>
        <!--js -->
        <!-- <script src="js/jquery.nicescroll.js"></script> -->
        <script src="js/scripts.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>
        <!-- /Bootstrap Core JavaScript -->
        <!-- real-time -->
        <script language="javascript" type="text/javascript" src="js/jquery.flot.js"></script>
        <script type="text/javascript">
            // $(function() {

            //             // We use an inline data source in the example, usually data would
            //             // be fetched from a server

            //             var data = [],
            //                 totalPoints = 300;

            //             function getRandomData() {

            //                 if (data.length > 0)
            //                     data = data.slice(1);

            //                 // Do a random walk

            //                 while (data.length < totalPoints) {

            //                     var prev = data.length > 0 ? data[data.length - 1] : 50,
            //                         y = prev + Math.random() * 10 - 5;

            //                     if (y < 0) {
            //                         y = 0;
            //                     } else if (y > 100) {
            //                         y = 100;
            //                     }

            //                     data.push(y);
            //                 }

            //                 // Zip the generated y values with the x values

            //                 var res = [];
            //                 for (var i = 0; i < data.length; ++i) {
            //                     res.push([i, data[i]])
            //                 }

            //                 return res;
            //             }

            //             // Set up the control widget

            //             var updateInterval = 30;
            //             $("#updateInterval").val(updateInterval).change(function() {
            //                 var v = $(this).val();
            //                 if (v && !isNaN(+v)) {
            //                     updateInterval = +v;
            //                     if (updateInterval < 1) {
            //                         updateInterval = 1;
            //                     } else if (updateInterval > 2000) {
            //                         updateInterval = 2000;
            //                     }
            //                     $(this).val("" + updateInterval);
            //                 }
            //             });
        </script>

        <script src="js/menu_jquery.js">
        </script>
    </body>

    </html><?php }  ?>