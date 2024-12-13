<?php require_once 'core/handleForms.php'; ?>
<?php require_once 'core/models.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Insert New Job</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f4f4f9;
			margin: 0;
			padding: 0;
		}

		.container {
			width: 50%;
			margin: 50px auto;
			padding: 30px;
			background-color: #fff;
			border-radius: 8px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
		}

		h1 {
			text-align: center;
			color: #333;
			margin-bottom: 20px;
		}

		form {
			display: flex;
			flex-direction: column;
		}

		p {
			margin-bottom: 15px;
		}

		label {
			font-size: 14px;
			font-weight: bold;
			margin-bottom: 5px;
		}

		input[type="text"], textarea {
			padding: 10px;
			font-size: 14px;
			border: 1px solid #ddd;
			border-radius: 5px;
			width: 100%;
			box-sizing: border-box;
		}

		textarea {
			resize: vertical;
			height: 100px;
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

		.logout-link {
			display: block;
			text-align: center;
			margin-bottom: 20px;
		}

		.logout-link a {
			text-decoration: none;
			color: #4CAF50;
			font-size: 14px;
		}

		.logout-link a:hover {
			text-decoration: underline;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="logout-link">
			<a href="logout.php">Logout</a>
		</div>
		<h1>Insert New Job!</h1>
		<form action="core/handleForms.php" method="POST">
			<p>
				<label for="Title">Title</label>   
				<input type="text" name="Title" id="Title">
			</p>
			<p>
				<label for="Position">Position</label>   
				<input type="text" name="Position" id="Position">
			</p>
			<p>
				<label for="Decription">Description</label> 
				<textarea name="Decription" id="Decription"></textarea>
			</p>
			<p>
				<label for="Location">Location</label> 
				<input type="text" name="Location" id="Location">
			</p>
			<p>
				<label for="SalaryRange">Salary Range</label> 
				<input type="text" name="SalaryRange" id="SalaryRange">
			</p>
			<p>
				<input type="submit" name="insertnewJob" value="Insert Job">
			</p>
		</form>
	</div>
</body>
</html>
