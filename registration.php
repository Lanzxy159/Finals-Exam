<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 500px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .message {
            text-align: center;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 16px;
        }

        .message.success {
            background-color: #d4edda;
            color: #155724;
        }

        .message.error {
            background-color: #f8d7da;
            color: #721c24;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"], input[type="password"], input[type="file"], select {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        p {
            text-align: center;
        }

        a {
            color: #4CAF50;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php  
        if (isset($_SESSION['message']) && isset($_SESSION['status'])) {
            $messageClass = ($_SESSION['status'] == "200") ? "success" : "error";
            echo "<div class='message $messageClass'>{$_SESSION['message']}</div>";
        }
        unset($_SESSION['message']);
        unset($_SESSION['status']);
        ?>

        <h1>Register Here!</h1>
        <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
            <p>
                <label for="role">Role:</label>
                <select name="role" id="role" required onchange="toggleFields()">
                    <option value="hr">HR</option>
                    <option value="applicant">Applicant</option>
                </select>
            </p>

            <p>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>
            </p>

            <p>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </p>

            <p>
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" required>
            </p>

            <p id="positionField">
                <label for="position">Position:</label>
                <input type="text" name="position" id="position">
            </p>

            <p id="resumeField" style="display:none;">
                <label for="resume">Resume (PDF):</label>
                <input type="file" name="resume" id="resume" accept=".pdf">
            </p>

            <p>
                <input type="submit" name="insertNewUserBtn" value="Submit">
            </p>
        </form>

    </div>

    <script>
        function toggleFields() {
            const role = document.getElementById('role').value;
            const positionField = document.getElementById('positionField');
            const resumeField = document.getElementById('resumeField');
            if (role === 'hr') {
                positionField.style.display = 'block';
                resumeField.style.display = 'none';
            } else if (role === 'applicant') {
                positionField.style.display = 'none'; 
                resumeField.style.display = 'block';  
            }
        }

        window.onload = function() {
            toggleFields(); 
        };
    </script>
</body>
</html>
