<?php include_once 'includes/header.php' ?>
<title>Login</title>

<h2>Login</h2>
<link rel="stylesheet" href="css/form-style.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<div class = "signup-form">
 <form action="includes/login.inc.php" method="post">

  <div class="inputlabel">
   <label for = "emailaddress">Email</label>
   <input type = "text" name = "email" placeholder="Email Address">
  </div>

  <div class="inputlabel">
   <label for = "password">Password</label>
   <input type = "password" name = "password" placeholder = "Password">
  </div>

  <input type = "submit" name = "submit" value = "Login">
 </form>
</div>
<?php 
if (isset($_GET["error"])) {
    if ($_GET["error"] == "notloggedin") {
        echo "<div class='isa_error'>" . "<i class='fa fa-times-circle'></i>You must be signed in to view this content" . "</div>";
    }

    if ($_GET["error"] == "passwordincorrect") {
        echo "<div class='isa_error'>" . "<i class='fa fa-times-circle'></i>Incorrect password" . "</div>";
    }

    if ($_GET["error"] == "emptyinput") {
        echo "<div class='isa_error'>" . "<i class='fa fa-times-circle'></i>Please fill both fields before submitting" . "</div>";
    }

    if ($_GET["error"] == "emailexists") {
        echo "<div class='isa_error'>" . "<i class='fa fa-times-circle'></i>Email does not exist" . "</div>";
    }

    if ($_GET["error"] == "loggedout") {
        echo "<div class='isa_success'>" . "<i class='fa fa-check'></i>You have successfully logged out" . "</div>";
    }
}
?>
 <?php include_once "includes/footer.php"?>
