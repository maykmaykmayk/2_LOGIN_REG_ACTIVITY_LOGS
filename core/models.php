<?php

require_once 'dbConfig.php';

function getAllApplicant($pdo) {
    $sql = "SELECT * FROM applicant_information
            ORDER BY applicantID ASC";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();

    if($executeQuery) {
        $response = array(
            "statusCode" => "200",
            "querySet" => $stmt -> fetchAll()
        );
    } else {
        $response = array(
            "statusCode" => "400",
            "message" => "Failed to get applicant!"
        );
    }
    return $response;
}


function getApplicantByID($pdo, $applicantID){
    $sql = "SELECT * FROM applicant_information WHERE applicantID = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$applicantID]);

    if($executeQuery) {
        $response = array(
            "statusCode" => "200",
            "querySet" => $stmt -> fetch()
        );
    } else {
        $response = array(
            "statusCode" => "400",
            "message" => "Failed to get applicant " . $applicantID . "!"
        );
    }
    return $response;
}

function searchForApplicant($pdo, $searchQuery) {

    $sql = "SELECT * FROM applicant_information WHERE
            CONCAT(first_name, last_name, age, gender, email, contact_info, date_added)
            LIKE ?";

    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute(["%".$searchQuery."%"]);
    if($executeQuery) {
        $response = array(
            "statusCode" => "200",
            "querySet" => $stmt -> fetchAll()
    );
        } else {
        $response = array(
            "statusCode" => "400",
            "message" => "Failed to search applicant!"
        );
    }
    return $response;
}

function editApplicant($pdo, $first_name, $last_name, $age, $gender, $email, $contact_info, $applicantID) {
    $response = array();

    $query = "UPDATE applicant_information
            SET first_name = ?,
                last_name = ?,
                age = ?,
                gender = ?,
                email = ?,
                contact_info = ?
            WHERE applicantID = ?";
    $stmt = $pdo->prepare($query);
    $executeQuery = $stmt->execute([$first_name, $last_name, $age, $gender, $email, $contact_info, $applicantID]);

    if ($executeQuery) {
        $sqlFetch = "SELECT * FROM applicant_information WHERE applicantID = ?";
        $stmtFetch = $pdo->prepare($sqlFetch);
        $stmtFetch->execute([$applicantID]);
        $applicant = $stmtFetch->fetch();

        if ($applicant) {
            insertAnActivityLog(
                $pdo, $_SESSION['username'], "EDIT",
                $applicant['applicantID'],
                $applicant['first_name'],
                $applicant['last_name'],
                $applicant['age'],
                $applicant['gender'],
                $applicant['email'],
                $applicant['contact_info']
            );
        }

        $response = array(
            "statusCode" => "200",
            "message" => "Application " . $applicantID . " edited successfully!"
        );
    } else {
        $response = array(
            "statusCode" => "400",
            "message" => "Failed to edit application " . $applicantID . "!"
        );
    }

    return $response;
}


function deleteApplicantByID($pdo, $applicantID) {
    $response = array();

    $sqlFetch = "SELECT * FROM applicant_information WHERE applicantID = ?";
    $stmtFetch = $pdo->prepare($sqlFetch);
    $stmtFetch->execute([$applicantID]);
    $applicant = $stmtFetch->fetch();

    if ($applicant) {
        $sqlDelete = "DELETE FROM applicant_information WHERE applicantID = ?";
        $stmtDelete = $pdo->prepare($sqlDelete);
        $deleteQuery = $stmtDelete->execute([$applicantID]);

        if ($deleteQuery) {
            insertAnActivityLog($pdo,$_SESSION['username'], "DELETE",
                $applicant['applicantID'], 
                $applicant['first_name'], 
                $applicant['last_name'], 
                $applicant['age'],
                $applicant['gender'],
                $applicant['email'],
                $applicant['contact_info']
            );
        

            $response = array(
                "statusCode" => "200",
                "message" => "Deleted the applicant successfully and activity log inserted!"
            );
        } else {
            $response = array(
                "statusCode" => "400",
                "message" => "Failed to delete the applicant!"
            );
        }
    } else {
        $response = array(
            "statusCode" => "404",
            "message" => "Applicant not found!"
        );
    }

    return $response;
}

function addApplicant($pdo, $first_name, $last_name, $age, $gender, $email, $contact_info) {

    $response = array();

    $query = "INSERT INTO applicant_information (first_name, last_name, age, gender, email, contact_info) VALUES (?, ?, ?, ?, ?, ?)";
    
    $statement = $pdo -> prepare($query);
    $executeQuery = $statement -> execute([$first_name, $last_name, $age, $gender, $email, $contact_info]);

        if ($executeQuery) {
            $findInsertedItemSQL = "SELECT * FROM applicant_information ORDER BY date_added DESC LIMIT 1";
            $stmtfindInsertedItemSQL = $pdo->prepare($findInsertedItemSQL);
            $stmtfindInsertedItemSQL->execute();
            $getApplicantByID = $stmtfindInsertedItemSQL->fetch();
    
            $insertAnActivityLog = insertAnActivityLog($pdo, $_SESSION['username'],
            "INSERT",
            $getApplicantByID['applicantID'], 
            $getApplicantByID['first_name'], 
            $getApplicantByID['last_name'], 
            $getApplicantByID['age'],
            $getApplicantByID['gender'],
            $getApplicantByID['email'],
            $getApplicantByID['contact_info']
        );

         if ($insertAnActivityLog) {
			$response = array(
				"status" =>"200",
				"message"=>"Applicant addedd successfully!"
			);
		}

		else {
			$response = array(
				"status" =>"400",
				"message"=>"Insertion of activity log failed!"
			);
		}
		
	}

	else {
		$response = array(
			"status" =>"400",
			"message"=>"Insertion of data failed!"
		);

	}

	return $response;
		return true;
	}

function checkIfUserExists($pdo, $username) {
	$response = array();
	$sql = "SELECT * FROM user_accounts WHERE username = ?";
	$stmt = $pdo->prepare($sql);

	if ($stmt->execute([$username])) {

		$userInfoArray = $stmt->fetch();

		if ($stmt->rowCount() > 0) {
			$response = array(
				"result"=> true,
				"status" => "200",
				"userInfoArray" => $userInfoArray
			);
		}

		else {
			$response = array(
				"result"=> false,
				"status" => "400",
				"message"=> "User doesn't exist from the database"
			);
		}
	}

	return $response;

}

function getAllUsers($pdo) {
	$sql = "SELECT * FROM user_accounts";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();

	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

function insertAnActivityLog($pdo, $username, $operation, $applicantID, $first_name, $last_name, $age, $gender, $email, $contact_info) {
    $sql = "INSERT INTO activity_logs (username, operation, applicantID, first_name, last_name, age, gender, email, contact_info, date_added) 
            VALUES(?,?,?,?,?,?,?,?,?, NOW())";

    $stmt = $pdo->prepare($sql);

    $executeQuery = $stmt->execute([$username, $operation, $applicantID, $first_name, $last_name, $age, $gender, $email, $contact_info]);
    return $executeQuery;
}


function getAllActivityLogs($pdo) {
	$sql = "SELECT * FROM activity_logs";
	$stmt = $pdo->prepare($sql);
	if ($stmt->execute()) {
		return $stmt->fetchAll();
	}
}

function insertNewUser($pdo, $username, $first_name, $last_name, $user_password) {
	$response = array();
	$checkIfUserExists = checkIfUserExists($pdo, $username); 

	if (!$checkIfUserExists['result']) {

		$sql = "INSERT INTO user_accounts (username, first_name, last_name, user_password) 
		VALUES (?,?,?,?)";

		$stmt = $pdo->prepare($sql);

		if ($stmt->execute([$username, $first_name, $last_name, $user_password])) {
			$response = array(
				"status" => "200",
				"message" => "User successfully inserted!"
			);
		}

		else {
			$response = array(
				"status" => "400",
				"message" => "An error occured with the query!"
			);
		}
	}

	else {
		$response = array(
			"status" => "400",
			"message" => "User already exists!"
		);
	}

	return $response;
}