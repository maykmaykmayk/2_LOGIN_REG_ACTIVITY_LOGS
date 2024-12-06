<?php
require_once 'dbConfig.php';
require_once 'models.php';

if (isset($_POST['insertApplicantBtn'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $contact_info = $_POST['contact_info'];
 
    $function = addApplicant($pdo, $first_name, $last_name, $age, $gender, $email, $contact_info);

    if($function){
        $_SESSION['message'] = "Successfully inserted applicant!";
            header("Location: ../index.php");

            if($function['statusCode'] == "200") {
                $_SESSION['message'] = $function['message'];
                header('Location: ../index.php');
            } else {
                $_SESSION['message'] = "Error " . $function['statusCode'] . ": " . $function['message'];
                header('Location: ../index.php');
        }
    }
}

if(isset($_POST['editApplicantBtn'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $contact_info = $_POST['contact_info'];
    $applicantID = $_GET['applicantID'];

    $function = editApplicant($pdo, $first_name, $last_name, $age, $gender, $email, $contact_info, $applicantID);

    if($function['statusCode'] == "200") {
        $_SESSION['message'] = $function['message'];
        header('Location: ../index.php');
    } else {
        $_SESSION['message'] = "Error " . $function['statusCode'] . ": " . $function['message'];
        header('Location: ../index.php');
    }
}

if(isset($_POST['deleteApplicantBtn'])) {
    $function = deleteApplicantByID($pdo, $_GET['applicantID']);

    if($function['statusCode'] == "200") {
        $_SESSION['message'] = $function['message'];
        header('Location: ../index.php');
    } else {
        $_SESSION['message'] = "Successfully Deleted " . $function['statusCode'] . ": " . $function['message'];
        header('Location: ../index.php');
    }
}

if (isset($_GET['searchBtn'])) {
    $searchForApplicant = searchForApplicant($pdo, $_GET['searchInput']);
    foreach ($searchForApplicant as $row) {
        echo "<try>
                <td>{$row['applicantID']}</td>
				<td>{$row['first_name']}</td>
				<td>{$row['last_name']}</td>
				<td>{$row['age']}</td>
				<td>{$row['gender']}</td>
				<td>{$row['email']}</td>
				<td>{$row['contact_info']}</td>
                </tr>";
    }
}

if (isset($_POST['insertNewUserBtn'])) {
	$username = trim($_POST['username']);
	$first_name = trim($_POST['first_name']);
	$last_name = trim($_POST['last_name']);
	$user_password = trim($_POST['user_password']);
	$confirm_password = trim($_POST['confirm_password']);

	if (!empty($username) && !empty($first_name) && !empty($last_name) && 
		!empty($user_password) && !empty($confirm_password)) {

		if ($user_password == $confirm_password) {

			$insertQuery = insertNewUser($pdo, $username, $first_name, $last_name, 
				password_hash($user_password, PASSWORD_DEFAULT));

			if ($insertQuery['status'] == '200') {
				$_SESSION['message'] = $insertQuery['message'];
				$_SESSION['status'] = $insertQuery['status'];
				header("Location: ../login.php");
			}

			else {
				$_SESSION['message'] = $insertQuery['message'];
				$_SESSION['status'] = $insertQuery['status'];
				header("Location: ../register.php");
			}

		}
		else {
			$_SESSION['message'] = "Please make sure both passwords are equal";
			$_SESSION['status'] = "400";
			header("Location: ../register.php");
		}

	}

	else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = "400";
		header("Location: ../register.php");
	}
}

if (isset($_POST['loginUserBtn'])) {
	$username = trim($_POST['username']);
	$user_password = trim($_POST['user_password']);

	if (!empty($username) && !empty($user_password)) {

		$loginQuery = checkIfUserExists($pdo, $username);

		if ($loginQuery['status'] == '200') {
			$usernameFromDB = $loginQuery['userInfoArray']['username'];
			$passwordFromDB = $loginQuery['userInfoArray']['user_password'];

			if (password_verify($user_password, $passwordFromDB)) {
				$_SESSION['username'] = $usernameFromDB;
				header("Location: ../index.php");
			}
		}

		else {
			$_SESSION['message'] = $loginQuery['message'];
			$_SESSION['status'] = $loginQuery['status'];
			header("Location: ../login.php");
		}
	}

	else {
		$_SESSION['message'] = "Please make sure no input fields are empty";
		$_SESSION['status'] = "400";
		header("Location: ../login.php");
		exit;
	}
}

if (isset($_GET['logoutUserBtn'])) {
	unset($_SESSION['username']);
	header("Location: ../login.php");
	exit;
}
?>