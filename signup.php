<?php include_once 'includes/header.php' ?>
<title>Sign Up</title>

<h2>Sign Up</h2>
<h4>All fields are required</h4>
<link rel="stylesheet" href="css/form-style.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<div class = "signup-form">
 <form action="includes/signup.inc.php" method="post">

  <div class="inputlabel">
   <label for = "firstname">First Name</label>
   <input type = "text" name= "firstname" placeholder= "First Name">
  </div>

  <div class="inputlabel">
   <label for = "lastname">Last Name</label>
   <input type = "text" name= "lastname" placeholder= "Last Name">
  </div>

  <div class="inputlabel">
   <label for = "mobilenumber">Mobile Number</label>
   <input type = "text" name = "mobilenumber" placeholder="0-9, '-', '()'">
  </div>

  <div class = "inputlabel">
   <label for = "emailaddress">Email Address</label>
   <input type = "text" name = "email" placeholder="0-9, '-', '()'">
  </div>

  <div class="inputlabel">
   <label for = "password">Password</label>
   <input type = "password" name = "password" placeholder = "Password">
  </div>

  <div class="inputlabel">
   <label for = "passwordrepeat">Repeat Password</label>
   <input type = "password" name = "passwordrepeat" placeholder = "Repeat Password">
  </div>

  <input type = "submit" name = "submit" value = "Sign up">
 </form>
</div>

<?php 
if (isset($_GET["error"])) {

    if ($_GET["error"] == "emptyinput") {
        echo "<div class='isa_error'>" . "<i class='fa fa-times-circle'></i>Fill all input fields" . "</div>";
    }

    else if ($_GET["error"] == "none") {
        echo "<div class='isa_success'>" . "<i class='fa fa-check'></i>Account successfully created" . "</div>";
    }

    else if ($_GET["error"] == "invalidemail") {
        echo "<div class='isa_error'>" . "<i class='fa fa-times-circle'></i>Your email is invalid" . "</div>";
    }

    else if ($_GET["error"] == "passwordsdontmatch") {
        echo "<div class='isa_error'>" . "<i class='fa fa-times-circle'></i>Passwords do not match" . "</div>";
    }

    else if ($_GET["error"] == "emailexists") {
        echo "<div class='isa_error'>" . "<i class='fa fa-times-circle'></i>This email has been taken" . "</div>";
    }
    
    else if ($_GET["error"] == "usernameexists") {
        echo "<div class='isa_error'>" . "<i class='fa fa-times-circle'></i>This email has been taken" . "</div>";
    }

    else if ($_GET["error"] == "statementfailed") {
        echo "<div class='isa_error'>" . "<i class='fa fa-times-circle'></i>Backend completely fucked ggwp" . "</div>";
    }

    else if ($_GET["error"] == "phonelengthinvalid") {
        echo "<div class='isa_error'>" . "<i class='fa fa-times-circle'></i>Mobile number must be 10 digits long" . "</div>";
    }
    else if ($_GET["error"] == "phonecontainsletters") {
        echo "<div class='isa_error'>" . "<i class='fa fa-times-circle'></i>Mobile number must only contain 0-9, '-', '(' or ')'" . "</div>";
    }

}
?>