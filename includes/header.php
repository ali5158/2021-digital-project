<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel = "stylesheet" href="css/header-style.css">
</head>
<body>
	<div class ="header">

	 <div class="rhslogo">
	 	<img src ="assets/img/riccarton-crest-with-text.png" class="normal">
	 	<img src ="assets/img/riccarton-crest.png" class="small-screen">
	 </div>
	 <div id = "navbar">
	 <nav>
	 	<ul>
			<?php
			if (session_status() == PHP_SESSION_NONE) {
  					session_start();
			}

			if (isset($_SESSION["is_admin"])) {
			  if ($_SESSION["is_admin"] === 1) {
			    echo "<li><a href = '#'>Admin</a>";
				echo   "<ul>";
				echo     "<li><a href = 'items_result.php?type=allitems'>View all items</a></li>";
				echo     "<li><a href = 'admin.php'>View Reports</a></li>";
				echo   "</ul>";
				echo "</li>";
				}
			}

			if (isset($_SESSION["user_email"])) {
				echo "<li><a href = 'profile.php'>My Items</a></li>";
				echo "<li><a href = 'items.php'>Search</a></li>";

				echo "<li><a href = '#'>Upload Item</a>";
				echo   "<ul>";
				echo     "<li><a href = 'upload.php?type=lost'>Lost</a></li>";
				echo     "<li><a href = 'upload.php?type=found'>Found</a></li>";
				echo   "</ul>";
				echo "</li>";

				echo "<li><a href = 'includes/logout.inc.php'>Logout</a></li>";
			}

			else {
				echo "<li><a href = 'signup.php'>Sign Up</a></li>";
				echo "<li><a href = 'login.php'>Login</a></li>";
			}

			?>
		</ul>
	 </nav>
	</div>
	</div>

<div class="wrapper">