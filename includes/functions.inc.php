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
	echo $mobilenumber;

	if(strlen($mobilenumber) !== 10) {
		if(strlen($mobilenumber) !== 11) {
			//header("location: ../signup.php?error=phonelengthinvalid");
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
		header("location: ../profile.php");
		exit();
	}
}

// Upload Functions

function createItem($conn,$item_name,$category,$item_value,$date_lost) {
	$sql = "INSERT INTO items (item_name,date_lost,category_id,item_value) VALUES (?,?,?,?);";
	$stmt = mysqli_stmt_init($conn);

	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("location: ../upload.php?error=statementfailed");
		exit();
	}


	mysqli_stmt_bind_param($stmt,"ssss",$item_name,$date_lost,$category,$item_value);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	header("location: ../upload.php?error=none");
	exit();

}