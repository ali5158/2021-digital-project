<?php
require_once "includes/header.php";
require_once "includes/dbh.inc.php";

$user_id = $_POST["user"];

$sql = "SELECT * FROM `users` WHERE user_id = " . $user_id;
$userinfo = mysqli_query($conn,$sql);
$userinfo = mysqli_fetch_array($userinfo,MYSQLI_ASSOC);
$user_first_name = $userinfo["user_first_name"];
$user_name = $user_first_name . " " . $userinfo["user_last_name"];
$user_email = $userinfo["user_email"];

echo "<h2>" . $user_first_name . "'s information</h2>";
echo "<h3> Name: " . $user_name;
echo "<h3> Email: " . $user_email;
