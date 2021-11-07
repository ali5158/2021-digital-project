<?php include_once 'includes/header.php' ?>
<title>Login</title>

<h2>Login</h2>
<link rel="stylesheet" href="css/form-style.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<div class = "signup-form">
 <form action="includes/login.inc.php" method="post">

  <div class="inputlabel">
   <label for = "emailaddress">Email</label>
   <input type = "text" name = "emailaddress" placeholder="Email Address">
  </div>

  <div class="inputlabel">
   <label for = "password">Password</label>
   <input type = "password" name = "password" placeholder = "Password">
  </div>

  <input type = "submit" name = "submit" value = "user login">
 </form>
</div>

 <?php include_once "includes/footer.php"?>