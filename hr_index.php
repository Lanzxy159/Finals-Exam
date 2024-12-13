<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 1200px;
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
        }

        a:hover {
            text-decoration: underline;
        }

        .search-form input[type="text"] {
            padding: 10px;
            margin-right: 10px;
            font-size: 16px;
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .search-form input[type="submit"] {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .search-form input[type="submit"]:hover {
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
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .action-links a {
            margin-right: 10px;
            color: #007bff;
        }

        .action-links a:hover {
            color: #0056b3;
        }

        .logout-link {
            float: right;
            margin-bottom: 20px;
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="logout.php" class="logout-link">Logout</a>

        <!-- Search Form -->
        <div class="search-form">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET">
                <input type="text" name="searchInput" placeholder="Search here">
                <input type="submit" name="searchBtn" value="Search">
            </form>
        </div>

        <p><a href="hr_index.php">Clear Search Query</a></p>
        <p><a href="insertnewjob.php">Add Job Post</a></p>

        <table>
            <tr>
                <th>Title</th>
                <th>Position</th>
                <th>Location</th>
                <th>Salary Range</th>
                <th>Created by</th>
                <th>Created at</th>
                <th>Actions</th>
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
                        <td class="action-links">
                            <a href="view_applicants.php?id=<?php echo $row['job_post_id']; ?>">View Applicants</a>
                            <a href="edit.php?id=<?php echo $row['job_post_id']; ?>">Edit</a>
                            <a href="delete.php?id=<?php echo $row['job_post_id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <?php $searchForAJob = searchForAJob($pdo, $_GET['searchInput']); ?>
                <?php foreach ($searchForAJob as $row) { ?>
                    <tr>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['position']; ?></td>
                        <td><?php echo $row['location']; ?></td>
                        <td><?php echo $row['salary_range']; ?></td>
                        <td><?php echo $row['hr_id']; ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                        <td class="action-links">
                            <a href="edit.php?id=<?php echo $row['job_post_id']; ?>">Edit</a>
                            <a href="delete.php?id=<?php echo $row['job_post_id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </table>
    </div>
</body>
</html>
