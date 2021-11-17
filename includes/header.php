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
	 	<img src ="assets/img/riccarton-crest-with-text.png" class="normal">
	 	<img src ="assets/img/riccarton-crest.png" class="small-screen">
	 </div>
	 <div class="navbar">
			<?php
			if (session_status() == PHP_SESSION_NONE) {
  					session_start();
			}

			if (isset($_SESSION["is_admin"])) {
				if ($_SESSION["is_admin"] === 1) {
					echo "<a href = 'admin.php'>Admin</a>";
				}
			}

			if (isset($_SESSION["user_email"])) {
				echo "<a href = 'profile.php'>My Items</a>";
				echo "<a href = 'items.php'>Search</a>";
				echo "<a href = 'upload.php'>Upload Item</a>";
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