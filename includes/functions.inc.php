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
		$result = false:
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
	$sql = "SELECT * FROM users WHERE userEmail = ?;";
	$stmt = mysqli_stmt_init($conn);

	if(!mysqli_stmt_prepare($stmt,$sql)) {
		header("location: ../signup.php?error=statementfailed")
		exit();
	}

	mysqli_stmt_bind_param($stmt,"s",$email);
	mysqli_stmt_execute($stmt);

	$resultData = mysqli_stmt_get_result($stmt)

	if ($row = mysqli_fetch_assoc($resultData)) {
		return $row;
	}

	else {
		$result = true;
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
		header("location: ../signup.php?error=phonecontainsletters")
		exit();
	}
	return $mobilenumber;
}


function createuser($conn, $firstname, $lastname, $email, $mobilenumber, $password) {
	$sql = "INSERT INTO users (userfirstname,userlastname,useremail,usermobilephone,userpassword) VALUES (?,?,?,?,?);";
	$stmt = mysqli_stmt_init($conn)

	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("location: ../signup.php?error=statementfailed");
		exit();
	}

	$hashedpassword = password_hash($password,PASSWORD_DEFAULT);

	mysqli_stmt_bind_param($stmt,"sssss",$firstname,$lastname,$email,$mobilenumber,$hashedpassword);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	header("location: ../signup.php?error=none")
	exit();
}

/* Login Functions */
