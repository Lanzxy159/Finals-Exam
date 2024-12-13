<?php 
require_once 'dbConfig.php';

function checkIfUserExists($pdo, $username) {
    $response = array();

    $sqlHr = "SELECT * FROM hr WHERE username = ?";
    $stmtHr = $pdo->prepare($sqlHr);
    if ($stmtHr->execute([$username]) && $stmtHr->rowCount() > 0) {
        $userInfoArray = $stmtHr->fetch();
        $response = array(
            "result" => true,
            "status" => "200",
            "userInfoArray" => $userInfoArray,
            "table" => "hr" 
        );
    } else {
        $sqlApp = "SELECT * FROM applicant WHERE username = ?";
        $stmtApp = $pdo->prepare($sqlApp);
        if ($stmtApp->execute([$username]) && $stmtApp->rowCount() > 0) {
            $userInfoArray = $stmtApp->fetch();
            $response = array(
                "result" => true,
                "status" => "200",
                "userInfoArray" => $userInfoArray,
                "table" => "applicant"  
            );
        } else {
            $response = array(
                "result" => false,
                "status" => "400",
                "message" => "User doesn't exist in either HR or Applicant database"
            );
        }
    }

    return $response;
}


// JOB POSTS//
function searchForAJob($pdo, $searchQuery) {
	
	$sql = "SELECT * FROM job_post WHERE 
			CONCAT(title,position,description,location,salary_range,hr_id) 
			LIKE ?";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute(["%".$searchQuery."%"]);
	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}




function insertnewJob($pdo,$Title,$Decription,$Position,$Location,$SalaryRange, $user_id) {
	
	$sql = "INSERT INTO job_post (title,description,position,location,salary_range,hr_id) VALUES(?,?,?,?,?,?)";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$Title,$Decription,$Position,$Location,$SalaryRange, $user_id]);
	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}


//Applicants//

function getJobID($pdo, $id) {
	$sql = "SELECT * from job_post WHERE job_post_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$id]);

	if ($executeQuery) {
		return $stmt->fetch();
	}
}

function getApplicant($pdo, $jobPostId, $applicantId) {
    $sql = "SELECT * FROM job_applicants WHERE job_post_id = ? AND applicant_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$jobPostId, $applicantId]);

    if ($executeQuery) {
        return $stmt->fetch();
    }
}
function update_status($pdo, $changerole, $job_post_id, $applicant_id) {
    $sql = "UPDATE job_applicants SET status = ? WHERE job_post_id = ? AND applicant_id = ?";
    try {
        $stmt = $pdo->prepare($sql);
        $executeQuery = $stmt->execute([$changerole, $job_post_id, $applicant_id]);
        if ($executeQuery) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        // Handle the error (log it or return false)
        return false;
    }
}

function getAllApplicants($pdo, $jobPostId) {
    $sql = "SELECT ja.*, a.name as name
    FROM job_applicants ja
    JOIN applicant a on ja.applicant_id = a.user_id
    WHERE job_post_id= ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$jobPostId]);

    if ($executeQuery) {
        return $stmt->fetch();
    }
}


function apply_job($pdo,$Applicant_id,$Title,$position,$job_posted_id,$hr_id, $ApplicationMessage) {
	
	$sql = "INSERT INTO job_applicants (applicant_id,title,position,job_post_id,hr_id,application_message) VALUES(?,?,?,?,?,?)";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$Applicant_id,$Title,$position,$job_posted_id,$hr_id, $ApplicationMessage]);
	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}














function getAllJob($pdo) {
	$sql = "SELECT * FROM job_post 
			ORDER BY created_at DESC";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();
	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}












function insertNewUserHr($pdo, $username, $password, $name, $position) {
	$response = array();
	$checkIfUserExists = checkIfUserExists($pdo, $username); 

	if (!$checkIfUserExists['result']) {
		$sql = "INSERT INTO hr (username, password, name, position) 
		VALUES (?,?,?,?)";

		$stmt = $pdo->prepare($sql);
		if ($stmt->execute([$username, $password, $name, $position])) {
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
function insertNewUserApplicant($pdo, $username, $password, $name, $resume) {
    $response = array();
    $checkIfUserExists = checkIfUserExists($pdo, $username); 

    if (!$checkIfUserExists['result']) {

        $sql = "INSERT INTO applicant (username, password, name, resume) VALUES (?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);

        if (empty($resume)) {
            $resume = null;
        }

        if ($stmt->execute([$username, $password, $name, $resume])) {
            $response = array(
                "status" => "200",
                "message" => "User successfully inserted!"
            );
        } else {
            $response = array(
                "status" => "400",
                "message" => "An error occurred with the query!"
            );
        }
    } else {
        $response = array(
            "status" => "400",
            "message" => "User already exists!"
        );
    }

    return $response;
}


?>