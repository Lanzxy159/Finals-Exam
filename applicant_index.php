<?php require_once 'core/dbConfig.php'; ?>
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

        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
        }

        input[type="text"] {
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 300px;
            margin-right: 10px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
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

        td a {
            color: #4CAF50;
        }

        td a:hover {
            text-decoration: underline;
        }

        p {
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="logout.php">Logout</a>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET">
            <input type="text" name="searchInput" placeholder="Search here">
            <input type="submit" name="searchBtn" value="Search">
        </form>

        <p><a href="hr_index.php">Clear Search Query</a></p>
        <p><a href="insertnewjob.php">Add Job post</a></p>

        <table>
            <tr>
                <th>Title</th>
                <th>Position</th>
                <th>Location</th>
                <th>Salary Range</th>
                <th>Created by</th>
                <th>Created at</th>
                <th>Action</th>
            </tr>
            <?php if (!isset($_GET['searchBtn'])) { ?>
                <?php $getAllJob = getAllJob($pdo); ?>
                <?php foreach ($getAllJob as $row) { ?>
                    <tr>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['position']; ?></td>
                        <td><?php echo $row['location']; ?></td>
                        <td><?php echo $row['salary_range']; ?></td>
                        <td><?php echo $row['hr_id']; ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                        <td>
                            <a href="apply_job.php?id=<?php echo $row['job_post_id']; ?>">Apply Job/View Status</a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <?php $searchForAJob =  searchForAJob($pdo, $_GET['searchInput']); ?>
                <?php foreach ($searchForAJob as $row) { ?>
                    <tr>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['position']; ?></td>
                        <td><?php echo $row['location']; ?></td>
                        <td><?php echo $row['salary_range']; ?></td>
                        <td><?php echo $row['hr_id']; ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                        <td>
                            <a href="apply_job.php?id=<?php echo $row['job_post_id']; ?>">Apply Job/View Status</a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>    
        </table>
    </div>
</body>
</html>
