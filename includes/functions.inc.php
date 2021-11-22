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
function dateCheck($date_lost) {
	exit();
}



function createItem($conn,$item_name,$category,$item_value,$date_lost,$user_id) {
	$sql = "INSERT INTO items (item_name,date_lost,category_id,item_value,user_id) VALUES (?,?,?,?,?);";
	$stmt = mysqli_stmt_init($conn);

	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("location: ../upload.php?error=statementfailed");
		exit();
	}


	mysqli_stmt_bind_param($stmt,"sssss",$item_name,$date_lost,$category,$item_value,$user_id);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	header("location: ../upload.php?error=none");
	exit();
}
// Profile Functions

function archiveItem($conn,$action,$item) {

	$sql = "UPDATE `items` SET `is_" . $action . "` = '1' WHERE `items`.`item_id` = $item";
	$stmt = mysqli_stmt_init($conn);

	if (!mysqli_stmt_prepare($stmt,$sql)) {
		header("location: ../profile.php?error=statementfailed");
		exit();
	}

	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);

	if ($action === "found") {
		$date_found = date("y-m-d");
		$sql = "UPDATE `items` SET `date_found` = '" . $date_found . "' WHERE `items`.`item_id` = '" . $item ."'";
		echo $sql;
		echo "<br>";
		echo "Item:" . $item . "<br>";
		echo "Date Found " . $date_found;
		$stmt = mysqli_stmt_init($conn);

		if (!mysqli_stmt_prepare($stmt,$sql)) {
			header("location: ../profile.php?error=statementfailed");
			exit();
		}	

		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}

	header("location: ../profile.php?error=none");
	exit();
}

function editItem($conn,$item_name,$category,$item_value,$date_lost,$item_id,$status_id,$location_id) {

	date_default_timezone_set("Pacific/Auckland");
	$date_found = date("Y-m-d");
	$true = 1;

	$sql = "UPDATE `items` SET `item_name` = ?, `date_lost` = ?, `category_id` = ?, `item_value` = ?, `location_id` = ?, `status_id` = ?";

	if ($status_id == "3") {
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

function validateValue($value,$operator) {
	if (strpos($value,'<') !== false) {
		$operator = '<';
	}

	elseif (strpos($value,'>') !== false ) {
		$operator = '>';
	}

	elseif (strpos($value,'=') !== false ) {
		$operator = "=";
	}

	elseif (isset($value)) {
		$operator = "";
	}

	else {
		header("location: items.php?error=invalidvalue");
		exit();
	}

}