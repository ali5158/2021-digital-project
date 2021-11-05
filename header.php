<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<link rel = "stylesheet" href="css/header-style.css">
</head>
<body>
	<div class ="header">
	 <div class="rhslogo">
	 	<img src ="assets/img/riccarton-crest-with-text.png">
	 </div>
	 <div class="navbar">
			<?php
				if (isset($_SESSION["useremail"])) {
					echo "<a href= 'profile.php'>Profile</a>";
					echo "<a href= 'items.php'>Items</a>";
					echo "<a href= 'upload.php'>Upload Item</a>";
					echo "<a href = 'includes/logout.inc.php'>Logout</a>";
				}
				else {
					echo "<a href = 'signup.php'>Sign Up</a>";
					echo "<a href = 'login.php'>Login</a>";
				}
				?>

	 </div>
	</div>

<div class="wrapper">