<?php

 if (isset($_POST["submit"])) {
 	$firstname = $_POST["firstname"];
 	$lastname = $_POST["lastname"];
 	$email = $_POST["email"];
 	$mobilenumber = $_POST["mobilenumber"];
 	$password = $_POST["password"];
 	$passwordrepeat = $_POST["passwordrepeat"];

 	require_once 'dbh.inc.php';
 	require_once 'functions.inc.php';
 }

 if (emptyInput)