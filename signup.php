<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (isset($_POST['submit'])) {
  $fname = $_POST['fname'];
  $mobno = $_POST['mobno'];
  $email = $_POST['email'];
  $password = md5($_POST['password']);
  $ret = "select Email from tbluser where Email=:email";
  $query = $dbh->prepare($ret);
  $query->bindParam(':email', $email, PDO::PARAM_STR);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_OBJ);
  if ($query->rowCount() == 0) {
    $sql = "Insert Into tbluser(FullName,MobileNumber,Email,Password)Values(:fname,:mobno,:email,:password)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':fname', $fname, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':mobno', $mobno, PDO::PARAM_INT);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();
    if ($lastInsertId) {

      echo "<script>alert('You have successfully registered with us');</script>";
    } else {

      echo "<script>alert('Something went wrong.Please try again');</script>";
    }
  } else {

    echo "<script>alert('Email-id already exist. Please try again');</script>";
  }
}
?>
<!DOCTYPE HTML>
<html>

<head>
  <title>Hotel Booking Management System | Hotel :: Sign Up</title>
  <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
  <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />

  <script type="application/x-javascript">
    addEventListener("load", function() {
      setTimeout(hideURLbar, 0);
    }, false);

    function hideURLbar() {
      window.scrollTo(0, 1);
    }
  </script>
  <script src="js/jquery-1.11.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/responsiveslides.min.js"></script>
  <script>
    $(function() {
      $("#slider").responsiveSlides({
        auto: true,
        nav: true,
        speed: 500,
        namespace: "callbacks",
        pager: true,
      });
    });
  </script>

</head>

<body>
  <!--header-->
  <div class="header head-top">
    <div class="container">
      <?php include_once('includes/header.php'); ?>
    </div>
  </div>
  <!--header-->
  <!--about-->

  <div class="content">
    <div class="contact">
      <div class="container">

        <h2>REGISTERED With Us</h2>
        <br> <br>
        <div class="contact-grids">

          <div class="col-md-6 contact-right" style="background-color: #ebedf1; padding:15px;">
            <form name="RegForm" onsubmit="return FormValidation()" method="post">
              <div class="form-group">
                <label for="fname" class="control-label">Full Name</label>
                <input type="text" value="" name="fname" id="fname" class="form-control">
              </div>
              <div class="form-group">
                <label for="mobno" class="control-label">Mobile Number</label>
                <input type="text" name="mobno" id="mobno" class="form-control" maxlength="10" pattern="[0-9]+">
              </div>
              <div class="form-group">
                <label for="email" class="control-label">Email Address</label>
                <input type="email" class="form-control" value="" name="email" id="email">
              </div>
              <div class="form-group">
                <label for="password" class="control-label">Password</label>
                <input type="password" value="" class="form-control" name="password" id="password">
              </div>
              <br>
              <a href="signin.php" style="color: red">Signin</a>
              <br>
              <input type="submit" value="Sign Up" name="submit" class="btn btn-primary">
            </form>
          </div>

          <div class="col-md-6 contact-right mb-5">
            <h3 class="text-center">Our Location </h3>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d112111.24378243957!2d76.97252145!3d28.585482650000014!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d1a9af30ebbc5%3A0xcfd2bc5a1783218!2sSouth%20West%20Delhi%2C%20Delhi!5e0!3m2!1sen!2sin!4v1688460364036!5m2!1sen!2sin" width="650" height="370" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
    <?php include_once('includes/getintouch.php'); ?>
  </div>
  <?php include_once('includes/footer.php'); ?>

</html>


<!-- form Validation -->

<script>
  function FormValidation() {
    var name = document.forms.RegForm.fname.value;
    var email = document.forms.RegForm.email.value;
    var mobno = document.forms.RegForm.mobno.value;
    var password = document.forms.RegForm.password.value;

    var regEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var regMobNo = /^\d{10}$/;
    var regName = /\d+$/g;

    if (name.trim() === "" || regName.test(name)) {
      alert("Please enter your name.");
      document.forms.RegForm.fname.focus();
      return false;
    }

    if (email.trim() === "" || !regEmail.test(email)) {
      alert("Please enter a valid email address.");
      document.forms.RegForm.email.focus();
      return false;
    }

    if (mobno.trim() === "" || !regMobNo.test(mobno)) {
      alert("Please enter 10 digit mobile number.");
      document.forms.RegForm.mobno.focus();
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