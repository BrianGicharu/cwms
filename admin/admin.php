<?php
session_start();

include_once("../includes/config.php");

if (file_exists(("../appConfig.json"))) {
	$config = json_decode(file_get_contents("../appConfig.json"), true);
	$db = $config['database'];
}

// initialize pdo object
try {
	$conn = new PDO("mysql:host=" . $config['host'] . ";dbname=" . "INFORMATION_SCHEMA", $config['user'], $config['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
} catch (PDOException $e) {
	die(error_log("Error: " . $e->getMessage()));
}
// Select from information schema.schemata to check if db exists
$stmt = $conn->prepare("SELECT `SCHEMA_NAME` FROM INFORMATION_SCHEMA.SCHEMATA WHERE `SCHEMA_NAME` LIKE :dbname");
$stmt->bindParam(':dbname', $db);
$stmt->execute();
$result =  $stmt->fetch(PDO::FETCH_COLUMN);
if (!$result) {
	$conn = null;
	die(header("Location:../index.php"));
}

if (isset($_POST['login'])) {
	$uname = $_POST['username'];
	$password = md5($_POST['password']);
	$sql = "SELECT UserName,Password FROM admin WHERE UserName=:uname and Password=:password";
	$query = $dbh->prepare($sql);
	$query->bindParam(':uname', $uname, PDO::PARAM_STR);
	$query->bindParam(':password', $password, PDO::PARAM_STR);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);
	if ($query->rowCount() > 0) {
		$_SESSION['alogin'] = $_POST['username'];
		header("Location:./dashboard.php");
	} else {
		echo "<script>alert('Invalid Details');</script>";
	}
}

?>

<!DOCTYPE HTML>
<html>

<head>
	<title>CWMS | Admin Sign in</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="application/x-javascript">
		addEventListener("load", function() {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<!-- Bootstrap Core CSS -->
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
	<!-- Custom CSS -->
	<link href="css/style.css" rel='stylesheet' type='text/css' />
	<link rel="stylesheet" href="css/morris.css" type="text/css" />
	<!-- Graph CSS -->
	<link href="css/font-awesome.css" rel="stylesheet">
	<link rel="stylesheet" href="css/jquery-ui.css">
	<!-- jQuery -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<!-- //jQuery -->
	<link href='https://fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css' />
	<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<!-- lined-icons -->
	<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
	<!-- //lined-icons -->
</head>

<body>
	<div class="main-wthree">
		<div class="container">
			<div class="sin-w3-agile">
				<form method="post">
					<div class="container d-flex justify-content-center">
						<h2>Sign In</h2>
					</div>
					<div class="username">
						<div class="form-group">
							<label for="name">Username</label>
							<input type="text" name="username" class="form-control" placeholder="" required="">
						</div>
					</div>
					<div class="password-agileits">
						<div class="form-group">
							<label for="password">Password</label>
							<div class="d-flex">
								<input type="password" name="password" id="passwordField" class="form-control" placeholder="" required="">
								<button type="button" class="btn btn-dark" id="showPassword">
									<i class="fa fa-eye" aria-hidden="true" id="pwdicon"></i>
								</button>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="login-w3">
						<input type="submit" class="btn btn-primary" name="login" value="Sign In">
					</div>
					<div class="clearfix"></div>
					<div class="back">
						<a href="../index.php">Back to home</a>
					</div>
				</form>
				<!-- <div class="container">
				</div> -->
			</div>
		</div>
	</div>
	<script>
		$("#showPassword").on('click', () => {
			var pwdField = $("#passwordField")
			if (pwdField.attr('type') === 'password') {
				$("#passwordField").attr('type', 'text')
				$("#pwdicon").removeClass('fa fa-eye')
				$("#pwdicon").addClass("fa fa-eye-slash")
			} else {
				$("#passwordField").attr('type', 'password')
				$("#pwdicon").removeClass("fa fa-eye-slash")
				$("#pwdicon").addClass('fa fa-eye"')
			}
		})
	</script>
</body>

</html>