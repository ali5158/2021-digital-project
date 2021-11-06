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
   <input type = "text" name= "first_name" placeholder= "First Name">
  </div>

  <div class="inputlabel">
   <label for = "lastname">Last Name</label>
   <input type = "text" name= "last_name" placeholder= "Last Name">
  </div>

  <div class="inputlabel">
   <label for = "mobilenumber">Mobile Number</label>
   <input type = "text" name = "mobilenumber" placeholder="0-9, '-', '()'">
  </div>

  <div class = "inputlabel">
   <label for = "emailaddress">Email Address</label>
   <input type = "text" name = "emailaddress" placeholder="0-9, '-', '()'">
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

 <?php include_once "includes/footer.php"?>