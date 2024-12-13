<?php

require_once 'dbConfig.php';
require_once 'models.php';

if (isset($_POST['loginUserBtn'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {

        $loginQuery = checkIfUserExists($pdo, $username);

        // Check if the user exists in either hr or applicant table
        if ($loginQuery['result']) {
            $userIDFromDB = $loginQuery['userInfoArray']['user_id'];
            $usernameFromDB = $loginQuery['userInfoArray']['username'];
            $passwordFromDB = $loginQuery['userInfoArray']['password'];
            $roleFromDB = $loginQuery['table'];  // Get the table to determine the role (hr or applicant)

            // Check if the password matches
            if (password_verify($password, $passwordFromDB)) {
                // Set session variables
                $_SESSION['user_id'] = $userIDFromDB;
                $_SESSION['username'] = $usernameFromDB;
                
                // Redirect based on the role
                if ($roleFromDB == 'hr') {
                    header("Location: ../hr_index.php");
                } elseif ($roleFromDB == 'applicant') {
                    header("Location: ../applicant_index.php");  // Redirect to applicant page
                }
                exit();
            } else {
                $_SESSION['message'] = "Username/password invalid";
                $_SESSION['status'] = "400";
                header("Location: ../login.php");
                exit();
            }
        } else {
            $_SESSION['message'] = "Username not found";
            $_SESSION['status'] = "400";
            header("Location: ../login.php");
            exit();
        }
    } else {
        $_SESSION['message'] = "Please make sure there are no empty input fields";
        $_SESSION['status'] = '400';
        header("Location: ../login.php");
        exit();
    }
}

if (isset($_POST['insertNewUserBtn'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $name = trim($_POST['name']);
    $role = trim($_POST['role']); 

    // Check if the username already exists in the database
    $checkIfUserExists = checkIfUserExists($pdo, $username); 

    if ($checkIfUserExists['result']) {
        $_SESSION['message'] = "Username already exists!";
        $_SESSION['status'] = '400';
        header("Location: ../registration.php");
        exit();
    }

    // For HR, position is required; for Applicant, resume is required
    if ($role == 'hr') {
        $position = trim($_POST['position']);  // Position is needed for HR
        $resume = null;  // No resume for HR
    } elseif ($role == 'applicant') {
        $position = null;  // No position for Applicant
        $resume = $_FILES['resume'];  // Resume is needed for Applicants
    }

    // Validate input fields
    if (!empty($username) && !empty($password) && !empty($name) && !empty($role) && (($role == 'hr' && !empty($position)) || ($role == 'applicant' && isset($resume)))) {
        // Hash the password before storing
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // For HR, insert HR-related data
        if ($role == 'hr') {
            $insertQuery = insertNewUserHr($pdo, $username, $hashedPassword, $name, $position);
        }
        // For Applicant, insert Applicant-related data and handle resume upload
        elseif ($role == 'applicant') {
            // If resume is provided, handle file upload
            if ($resume['error'] == 0) {  // Check for upload errors
                $resumePath = 'uploads/' . basename($resume['name']);  // Set the destination path for the uploaded file
                
                if (move_uploaded_file($resume['tmp_name'], $resumePath)) {
                    // File uploaded successfully, now insert applicant data into the database
                    $insertQuery = insertNewUserApplicant($pdo, $username, $hashedPassword, $name, $resumePath);  // Save the file path in DB
                } else {
                    $_SESSION['message'] = "Failed to upload resume!";
                    $_SESSION['status'] = '400';
                    header("Location: ../registration.php");
                    exit();
                }
            } else {
                // If no resume is uploaded, insert user with NULL for resume
                $insertQuery = insertNewUserApplicant($pdo, $username, $hashedPassword, $name, null);  // Save NULL for resume if no file is uploaded
            }
        } else {
            // If an invalid role is selected
            $_SESSION['message'] = "Invalid role selected!";
            $_SESSION['status'] = '400';
            header("Location: ../registration.php");
            exit();
        }

        // Handle the result of the insertion
        $_SESSION['message'] = $insertQuery['message'];
        if ($insertQuery['status'] == '200') {
            $_SESSION['status'] = $insertQuery['status'];
            header("Location: ../login.php");
        } else {
            $_SESSION['status'] = $insertQuery['status'];
            header("Location: ../registration.php");
        }
    } else {
        $_SESSION['message'] = "Please make sure there are no empty input fields";
        $_SESSION['status'] = '400';
        header("Location: ../registration.php");
    }
}



// JOBS TABLE//

if (isset($_POST['insertnewJob'])) {
    $Title = $_POST['Title'];
    $Decription = $_POST['Decription'];
    $Location = $_POST['Location'];
    $SalaryRange = $_POST['SalaryRange'];
    $Position = $_POST['Position'];

	if ($insertnewJob) {
		$_SESSION['message'] = "Successfully inserted!";
		header("Location: ../hr_index.php");
	}

	if (!empty($Title) && !empty($Decription) && !empty($Location) && !empty($SalaryRange)&& !empty($Position)){
		$insertnewJob = insertnewJob($pdo,$Title,$Decription,$Position,$Location,$SalaryRange, $_SESSION['user_id']);
		$_SESSION['status'] =  $insertnewJob['status']; 
		$_SESSION['message'] =  $insertnewJob['message']; 
		header("Location: ../hr_index.php");
	}

	else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = '400';
		header("Location: ../insertnewjob.php");
	}

}


//APPLY APPLICANTS//


if (isset($_POST['apply_job'])) {
    $Applicant_id = $_SESSION['user_id'];
    $Title = $_POST['Title'];
    $position = $_POST['position'];
    $job_posted_id = $_POST['job_post_id'];
    $hr_id = $_POST['hr_id'];
    $ApplicationMessage = $_POST['ApplicationMessage'];

	if ($apply_job) {
		$_SESSION['message'] = "Successfully inserted!";
		header("Location: ../applicant_index.php");
	}

	if (!empty($Applicant_id) && !empty($Title) && !empty($position) && !empty($job_posted_id)&& !empty($hr_id) && !empty($ApplicationMessage)) {
		$apply_job = apply_job($pdo,$Applicant_id,$Title,$position,$job_posted_id,$hr_id, $ApplicationMessage);
		$_SESSION['status'] =  $apply_job['status']; 
		$_SESSION['message'] =  $apply_job['message']; 
		header("Location: ../applicant_index.php");
	}

	else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = '400';
		header("Location: ../applicant_index.php");
	}

}
// Update Applicants //
if (isset($_POST['updatestatus'])) {
    $changerole = htmlspecialchars($_POST['role']);
    $job_post_id = $_POST['job_post_id'];
    $applicant_id = $_POST['applicant_id'];

    if (!empty($changerole) && !empty($job_post_id) && !empty($applicant_id)) {
        // Call the update_status function
        $update_status = update_status($pdo, $changerole, $job_post_id, $applicant_id);

        // Handle success or failure
        if ($update_status) {
            $_SESSION['message'] = "Status updated successfully!";
            $_SESSION['status'] = '200';  // Success status code
            header("Location: ../hr_index.php");  // Redirect to the applicant index page
            exit;
        } else {
            $_SESSION['message'] = "Failed to update status.";
            $_SESSION['status'] = '400';  // Error status code
            header("Location: ../hr_index.php");  // Redirect back to the applicant index page
            exit;
        }
    } else {
        $_SESSION['message'] = "Please ensure all fields are filled out.";
        $_SESSION['status'] = '400'; 
        header("Location: ../hr_index.php"); 
        exit;
    }
}





?>