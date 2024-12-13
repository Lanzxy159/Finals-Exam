<?php require_once 'core/handleForms.php'; ?>
<?php require_once 'core/models.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        a {
            color: #4CAF50;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            width: 60%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        form p {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }

        table a {
            color: #4CAF50;
            text-decoration: none;
        }

        table a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <a href="logout.php">Logout</a>
    <a href="applicant_index.php">Back</a>
    <h1>Apply Job!</h1>
    <?php $getJobID = getJobID($pdo, $_GET['id']); ?>

    <form action="core/handleForms.php" method="POST">
        <p>
            <label for="">Title</label>
            <input type="text" name="Title" value="<?php echo $getJobID['title']; ?>" >
        </p>
        <p>
            <label for="">Position</label>
            <input type="text" name="position" value="<?php echo $getJobID['position']; ?>" readonly >
        </p>
        <p>
            <input type="hidden" name="job_post_id" value="<?php echo $getJobID['job_post_id'];?>" >
        </p>
        <p>
            <label for="">Posted by</label>
            <input type="text" name="hr_id" value="<?php echo $getJobID['hr_id']; ?>" hidden >
        </p>

        <p>
            <label for="">Application Message why should we hire you?</label>
            <input type="text" name="ApplicationMessage">
        </p>
        <p>
            <label for="">Salary Range</label>
            <input type="text" name="SalaryRange" value="<?php echo $getJobID['salary_range']; ?>" readonly>
        </p>
        <p>
            <input type="submit" name="apply_job">
        </p>
    </form>

    <?php
    $getApplicant = getApplicant($pdo, $_GET['id'], $_SESSION['user_id']);
    if ($getApplicant):
    ?>
        <table>
            <tr>
                <th>Title</th>
                <th>Position</th>
                <th>Status</th>
                <th>Application Message</th>
                <th>Updated at</th>
            </tr>
            <tr>
                <td><?php echo ($getApplicant['title']); ?></td>
                <td><?php echo ($getApplicant['position']); ?></td>
                <td><?php echo ($getApplicant['status']); ?></td>
                <td><?php echo ($getApplicant['application_message']); ?></td>
                <td><?php echo ($getApplicant['updated_at']); ?></td>
            </tr>
        </table>
    <?php
    endif;
    ?>

</body>
</html>
