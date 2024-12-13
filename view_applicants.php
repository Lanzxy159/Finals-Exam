<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicants</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
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

        a {
            color: #4CAF50;
            text-decoration: none;
            margin: 10px;
            font-size: 16px;
        }

        a:hover {
            text-decoration: underline;
        }

        .logout-link,
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        form select, form input[type="submit"] {
            padding: 8px;
            margin: 5px;
            font-size: 14px;
        }

        .button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .button:hover {
            background-color: #45a049;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="logout-link">
            <a href="logout.php" class="button">Logout</a>
        </div>
        <div class="back-link">
            <a href="hr_index.php" class="button">Back</a>
        </div>

        <h1>Applicants for Job Post</h1>

        <?php 
        $getAllApplicants = getAllApplicants($pdo, $_GET['id']); 
        if ($getAllApplicants): 
        ?>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Title</th>
                    <th>Position</th>
                    <th>Status</th>
                    <th>Application Message</th>
                    <th>Updated at</th>
                    <th>Resume</th>
                </tr>
                <tr>
                    <td><?php echo ($getAllApplicants['name']); ?></td>
                    <td><?php echo ($getAllApplicants['title']); ?></td>
                    <td><?php echo ($getAllApplicants['position']); ?></td>
                    <td>
                        <form action="core/handleForms.php" method="POST">
                            <select name="role">
                                <option value="Accepted">Accept</option>
                                <option value="Rejected">Reject</option>
                            </select>
                            <input type="hidden" name="job_post_id" value="<?php echo ($getAllApplicants['job_post_id']); ?>">
                            <input type="hidden" name="applicant_id" value="<?php echo ($getAllApplicants['applicant_id']); ?>">
                            <input type="submit" name="updatestatus" value="Update" style="background-color: #4CAF50; color: white; padding: 5px 10px; border: none; border-radius: 5px;">
                        </form>
                    </td>
                    <td><?php echo ($getAllApplicants['application_message']); ?></td>
                    <td><?php echo ($getAllApplicants['updated_at']); ?></td>
                    <td>
                    </td>
                </tr>
            </table>
        <?php 
        else: 
            echo "<p>No applicants found for this job post.</p>";
        endif; 
        ?>
    </div>
</body>
</html>
