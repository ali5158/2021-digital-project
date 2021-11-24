<?php
/* Signup Functions */


function emptyInputSignup($firstname,$lastname,$email,$mobilenumber,$password,$passwordrepeat) {
  $result;

  if (empty($firstname) || empty($lastname) || empty($email) || empty($mobilenumber) || empty($password) || empty($passwordrepeat)) {
	  $result = true;
  } 

  else {
	  $result = false;
  }

  return $result;
}


function invalidEmail($email) {
  $result;
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $result = true;
  } 

  else {
	$result = false;
  }

  return $result;
}


function passwordMatch($password,$passwordrepeat) {
  $result;
  if($password !== $passwordrepeat) {
	$result = true;
  }

  else {
	$result = false;
  }

  return $result;
}


function emailExists($conn,$email) {
  $sql = "SELECT * FROM users WHERE user_email = ?;";
  $stmt = mysqli_stmt_init($conn);

  if(!mysqli_stmt_prepare($stmt,$sql)) {
	header("location: ../signup.php?error=statementfailed");
	exit();
  }

  mysqli_stmt_bind_param($stmt,"s",$email);
  mysqli_stmt_execute($stmt);

  $resultData = mysqli_stmt_get_result($stmt);

  if ($row = mysqli_fetch_assoc($resultData)) {
	return $row;
  }

  else {
	$result = false;
	return $result;
  }

  mysqli_stmt_close($stmt);

}


function validateMobileNumber($mobilenumber) {
  $charactersToReplace = array("-","(",")"," ");
  $mobilenumber = str_replace($charactersToReplace,"",$mobilenumber);

  if(strlen($mobilenumber) !== 10) {
    if(strlen($mobilenumber) !== 11) {
	  header("location: ../signup.php?error=phonelengthinvalid");
	  exit();
	}
  }

  if (!is_numeric($mobilenumber)) {
	header("location: ../signup.php?error=phonecontainsletters");
	exit();
  }

  return $mobilenumber;
}


function createuser($conn, $firstname, $lastname, $email, $mobilenumber, $password) {
  $sql = "INSERT INTO users (user_first_name,user_last_name,user_email,user_mobile,user_password) VALUES (?,?,?,?,?);";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
	header("location: ../signup.php?error=statementfailedd");
	exit();
  }

  $hashedpassword = password_hash($password,PASSWORD_DEFAULT);

  mysqli_stmt_bind_param($stmt,"sssss",$firstname,$lastname,$email,$mobilenumber,$hashedpassword);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  header("location: ../signup.php?error=none");
  exit();

}


/* Login Functions */


function emptyInputLogin($email,$password) {
  $result;

  if (empty($email) || empty($password)) {
	$result = true;
  } 

  else {
	$result = false;
  }

  return $result;
}


function loginUser($conn,$email,$password) {
  $emailexists = emailExists($conn,$email);

  if ($emailexists === false) {
	header("location: ../login.php?error=emailexists");
	exit();
  }

  $passwordhashed = $emailexists["user_password"];
  $checkPassword = password_verify($password,$passwordhashed);

  if ($checkPassword === false) {
	header("location: ../login.php?error=passwordincorrect");
	exit();
  }

  else if ($checkPassword === true) {
	session_start();
	$_SESSION["user_id"] = $emailexists["user_id"];
	$_SESSION["user_email"] = $emailexists["user_email"];
	$_SESSION["user_first_name"] = $emailexists["user_first_name"];
	$_SESSION["is_admin"] = $emailexists["is_admin"];
	header("location: ../profile.php");
	exit();
  }
}


// Upload Functions

function emptyInputUpload($item_name,$category,$item_value,$date_lost,$user_id,$item_type,$location) {
  $result;
  if (empty($item_name) || empty($category) || empty($item_value) || empty($date_lost) || empty($user_id) || empty($item_type) || empty($location)) {
    $result = true;
  }
  else {
    $result = false;
  }
  return $result;
}

function createItem($conn,$item_name,$category,$item_value,$date_lost,$user_id,$item_type,$location) {
  $sql = "INSERT INTO items (item_name,date_lost,category_id,item_value,user_id,status_id,location_id) VALUES (?,?,?,?,?,?,?);";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
	header("location: ../upload.php?error=statementfailed");
	exit();
  }

  mysqli_stmt_bind_param($stmt,"sssssss",$item_name,$date_lost,$category,$item_value,$user_id,$item_type,$location);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  header("location: ../profile.php?error=none");
  exit();
}

//Edit Functions

function emptyInputEdit($item_name,$category,$item_value,$date_lost,$item_id,$status,$location_id) {
  $result;
  if (empty($item_name) || empty($category) || empty($item_value) || empty($date_lost) || empty($status) || empty($location_id)) {
	$result = true;
  }

  else {
	$result = false;
  }

  return $result;
}


function editItem($conn,$item_name,$category,$item_value,$date_lost,$item_id,$status_id,$location_id) {
  date_default_timezone_set("Pacific/Auckland");
  $date_found = date("Y-m-d");
  $true = 1;

  $sql = "UPDATE `items` 
		  SET `item_name` = ?, `date_lost` = ?, `category_id` = ?, `item_value` = ?, `location_id` = ?, `status_id` = ?";

  if ($status_id == "3" || $status_id == "4") {
	$sql .= ", `date_found` = ?";
  }

  $sql .= " WHERE `item_id` = ?;";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
	echo $sql;
	header("location: ../upload.php?error=statementfailed");
	exit();
  }

  if ($status_id == "3" || $status_id == "4") {
	echo "With Action:" . $sql;
	mysqli_stmt_bind_param($stmt,"ssssssss",$item_name,$date_lost,$category,$item_value,$location_id,$status_id,$date_found,$item_id);
  }

  else  {
	mysqli_stmt_bind_param($stmt,"sssssss",$item_name,$date_lost,$category,$item_value,$location_id,$status_id,$item_id);
  }

  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  header("location: ../profile.php?error=none");
  exit();

}

// Search Functions

function dateCheck($date,$headerlocation) {
  date_default_timezone_set("pacific/auckland"); 
  $today = date("Y-m-d");
  if ($date > $today) {
    header("location: " . $headerlocation);
    exit();
  }
} 

function valueCheck($item_value,$headerlocation) {
  if(preg_match('#[^0-9]#',$item_value)) {
    header("location: " . $headerlocation);
    exit();
  }
}
