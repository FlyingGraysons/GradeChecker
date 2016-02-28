<?php

function encryptPassword($password) {
	return $mysqli->real_escape_string(crypt($password, $config['salt']));
}

session_start();
if (!isset($_SESSION['loggedIn'])) {
		$_SESSION['loggedIn'] = false;
		$_SESSION['username'] = "";
		$_SESSION['student'] = "";
}

$_SESSION['error'] = NULL;

if (isset($_POST['password']) && isset($_POST['username'])) {
	$config = include('php/config.php'); // change this for digital ocean to config.php

	// Initializes and returns a mysqli object that represents our mysql database
	$mysqli = new mysqli($config['hostname'],
		$config['username'],
		$config['password'],
		$config['databaseName']);

	if (mysqli_connect_errno()) {
		$_SESSION['error'] = "There seems to be a problem with the database. Reload the page or try again later.";
	} else {

		// sanitize params
		foreach ($_POST as $key => $value) {
			$_POST[$key] = escapeshellcmd($mysqli->real_escape_string($value));
		}

		// actually check database
		$_POST['username'] = strtolower($_POST['username']);
		$result = mysqli_query($mysqli, "SELECT * FROM `users` WHERE `username` = \"{$_POST['username']}\"");
		if (mysqli_num_rows($result) == 1) {
			// output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				if ($row['password'] == encryptPassword($_POST['password'])) {
						$_SESSION['loggedIn'] = true;
						$_SESSION['username'] = $_POST['username'];
						$_SESSION['student'] = $row['student'];
						$_SESSION['error'] = NULL;
					}
		}} else {
			$_SESSION['error'] ='Incorrect username or password';
		}
	}
}

if (!$_SESSION['loggedIn']): ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Log In</title>

		<!-- Bootstrap core CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="general.css">


		<!-- Custom styles for this template -->
		<style>
			body {
				padding-top: 40px;
				padding-bottom: 40px;
				background-color: #eee;
			}

			.form-signin {
				max-width: 330px;
				padding: 15px;
				margin: 0 auto;
			}
			.form-signin .form-signin-heading,
			.form-signin .checkbox {
				margin-bottom: 10px;
			}
			.form-signin .checkbox {
				font-weight: normal;
			}
			.form-signin .form-control {
				position: relative;
				height: auto;
				-webkit-box-sizing: border-box;
					 -moz-box-sizing: border-box;
								box-sizing: border-box;
				padding: 10px;
				font-size: 16px;
			}
			.form-signin .form-control:focus {
				z-index: 2;
			}
			.form-signin input[type="text"] {
				margin-bottom: -1px;
				border-bottom-right-radius: 0;
				border-bottom-left-radius: 0;
			}
			.form-signin input[type="password"] {
				margin-bottom: 10px;
				border-top-left-radius: 0;
				border-top-right-radius: 0;
			}
		</style>
	</head>

	<body>

		<div class="container">

			<form class="form-signin" name="logInForm" method="post">
				<h2 class="form-signin-heading">Please sign in</h2>
				<input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
				<input type="password" name="password" class="form-control" placeholder="Password" required>
				<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
				<a class="btn btn-lg btn-danger btn-block" href="register.php">Register</a>
			</form>

			<?php
			if (isset($_SESSION['error'])) {
				echo "<div class='alert alert-danger alert-dismissible form-signin text-center' role='alert'><strong>Error:</strong>&nbsp;&nbsp;{$_SESSION['error']}</div>";
			}
			 ?>

			 <?php include('about.php') ?>
			 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
			 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		</div> <!-- /container -->
	</body>
</html>


<?php
exit();
endif;
?>
