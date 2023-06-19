<?php
session_start();
// error_reporting(0);
include_once('../includes/config.php');
include_once('../includes/functions.php');

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

if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	// Code for Booking
	if (isset($_POST['book'])) {
		$ptype = $_POST['packagetype'];
		$vtype = $_POST['vehicletype'];
		$wpoint = $_POST['washingpoint'];
		$fname = $_POST['fname'];
		$mobile = $_POST['contactno'];
		$date = $_POST['washdate'];
		$time = $_POST['washtime'];
		$message = $_POST['message'];
		$status = 'New';
		$bno = mt_rand(100000000, 999999999);
		$sql = "INSERT INTO tblcarwashbooking(bookingId,packageType,vehicleType,carWashPoint,fullName,mobileNumber,washDate,washTime,message,status) VALUES(:bno,:ptype,:vtype,:wpoint,:fname,:mobile,:date,:time,:message,:status)";
		$query = $dbh->prepare($sql);
		$query->bindParam(':bno', $bno, PDO::PARAM_STR);
		$query->bindParam(':ptype', $ptype, PDO::PARAM_STR);
		$query->bindParam(':vtype', $vtype, PDO::PARAM_STR);
		$query->bindParam(':wpoint', $wpoint, PDO::PARAM_STR);
		$query->bindParam(':fname', $fname, PDO::PARAM_STR);
		$query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
		$query->bindParam(':date', $date, PDO::PARAM_STR);
		$query->bindParam(':time', $time, PDO::PARAM_STR);
		$query->bindParam(':message', $message, PDO::PARAM_STR);
		$query->bindParam(':status', $status, PDO::PARAM_STR);
		$query->execute();
		$lastInsertId = $dbh->lastInsertId();
		if ($lastInsertId) {

			echo '<script>alert("Your booking done successfully. Booking number is "+"' . $bno . '")</script>';
			die(header("Location:./new-booking.php"));
		} else {
			echo "<script>alert('Something went wrong. Please try again.');</script>";
		}
	}

?>
	<!DOCTYPE HTML>
	<html>

	<head>
		<title>CWMS | Add Car Washing Booking</title>
		<script type="application/x-javascript">
			addEventListener("load", function() {
				setTimeout(hideURLbar, 0);
			}, false);

			function hideURLbar() {
				window.scrollTo(0, 1);
			}
		</script>
		<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
		<link href="../css/style.css" rel='stylesheet' type='text/css' />
		<link href="./css/app.css" rel='stylesheet' type='text/css' />
		<link href="css/style.css" rel='stylesheet' type='text/css' />
		<link rel="stylesheet" href="css/morris.css" type="text/css" />
		<link href="css/font-awesome.css" rel="stylesheet">
		<script src="js/jquery-2.1.4.min.js"></script>
		<link href='/fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css' />
		<link href='/fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css' />
		<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
		<style>
			tr,
			td,
			th {
				border: 1px solid #202C45;
				padding-left: 10px;
				padding-right: 10px;
				padding-top: 5px;
				padding-bottom: 5px;
			}

			table {
				border: 1px solid #202C45;
				border-radius: 2px solid transparent;
			}

			tr:nth-child(even) {
				background-color: #cccccc;
			}

			.errorWrap {
				padding: 10px;
				margin: 0 0 20px 0;
				background: #fff;
				border-left: 4px solid #dd3d36;
				-webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
				box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
			}

			.succWrap {
				padding: 10px;
				margin: 0 0 20px 0;
				background: #fff;
				border-left: 4px solid #5cb85c;
				-webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
				box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
			}
		</style>

	</head>

	<body>
		<div class="page-container">
			<!--/content-inner-->
			<div class="left-content">
				<div class="mother-grid-inner">
					<!--header start here-->
					<?php include('includes/header.php'); ?>

					<div class="clearfix"> </div>
				</div>
				<!--heder end here-->
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>Add Car Washing Booking </li>
				</ol>
				<!--grid-->
				<div class="grid-form">

					<!---->
					<div class="grid-form1">
						<h3>Add Car Washing Booking</h3>
						<div class="container">
							<div class="section-header text-center">
								<p>Washing Plan</p>
								<h2>Choose Your Plan</h2>
							</div>

							<div class="text-center">
								<h5>
									Our Pricing
								</h5>
								<div class="justify-content-center">
									<table id="my-table">
										<?php
										$wash_services = getTable("tblwashservice");
										if (count($wash_services) > 0) { ?>
											<th>
												<h4>SERVICE</h4>
											</th>
											<th>
												<h4>SALOON (KSHS)</h4>
											</th>
											<th>
												<h4>SUV 4*4 (KSHS)</h4>
											</th>
											<?php foreach ($wash_services as $service) { ?>
												<tr id=<?php $service; ?>>
													<?php
													foreach ($service as $key => $column) {
														if ($key === 'id') {
														} else {
															echo "<td>$column</td>";
														}
													}
													?>
												</tr>
											<?php } ?>
										<?php } ?>
									</table>
								</div>
				
								<div class="container" style="padding:20px;">
									<button type="button" class="btn btn-custom" id="bookNow" data-toggle="modal" data-target="#myModal">
										Book Now
									</button>
								</div>
							</div>
						</div>
					</div>
					<!--//grid-->
					<!--Model-->
					<div class="modal fade" id="myModal" role="dialog">
						<div class="modal-dialog">
							<?php
							$services = getTableCol('service', 'tblwashservice');
							?>
							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title">Car Wash Booking</h4>
								</div>
								<div class="modal-body">
									<form method="post">
										<p>
											<select name="packagetype" required class="form-control">
												<option value="">Package Type</option>
												<?php
												foreach ($services as $record) { ?>
													<option value="<?php echo $record['id']; ?>">
														<?php echo $record['service']; ?>
													</option>
												<?php } ?>
											</select>
										</p>
										<p>
											<select name="vehicletype" required class="form-control">
												<option value="">Vehicle Type</option>
												<?php
												$vehicles = getTable('tblvehicletypes');
												foreach ($vehicles as $vehicle) { ?>
													<option value="<?php echo $vehicle['id']; ?>">
														<?php echo $vehicle['vehicle_name']; ?>
													</option>
												<?php } ?>
											</select>
										</p>
										<p>
											<select name="washingpoint" required class="form-control">
												<option value="">Select Washing Point</option>
												<?php $sql = "SELECT * from tblwashingpoints";
												$query = $dbh->prepare($sql);
												$query->execute();
												$results = $query->fetchAll(PDO::FETCH_OBJ);
												foreach ($results as $result) { ?>
													<option value="<?php echo htmlentities($result->id); ?>">
														<?php echo htmlentities($result->washingPointName); ?>
														(<?php echo htmlentities($result->washingPointAddress); ?>)
													</option>
												<?php } ?>
											</select>
										</p>
										<p>
											<input type="text" name="fname" class="form-control" required placeholder="Full Name">
										</p>
										<p>
											<input type="text" name="contactno" class="form-control" pattern="[0-9]{10}" title="10 numeric characters only" required placeholder="Mobile No.">
										</p>
										<p>
											Wash Date <br /><input type="date" name="washdate" required class="form-control">
										</p>
										<p>
											Wash Time <br /><input type="time" name="washtime" required class="form-control">
										</p>
										<p>
											<textarea name="message" class="form-control" placeholder="Message if any"></textarea>
										</p>
										<p>
										<div class="d-flex justify-content-between">
											<span>
												<input type="radio" name="payOption" value="mpesa">
												MPesa
											</span>
											<span>
												<input type="radio" name="payOption" value="cash">
												<i class="fa fa-dollar-sign"></i>
												Cash
											</span>
											<span>
												<input type="radio" name="payOption" value="debit" disabled>
												<i class="fa fa-credit-card"></i>
												Debit/ ATM Card
											</span>
										</div>
										</p>
										<p>
											<input type="submit" class="btn btn-custom" name="book" value="Book Now">
										</p>
									</form>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								</div>
							</div>

						</div>
					</div>
					<!-- script-for sticky-nav -->
					<script>
						$(document).ready(function() {
							var navoffeset = $(".header-main").offset().top;
							$(window).scroll(function() {
								var scrollpos = $(window).scrollTop();
								if (scrollpos >= navoffeset) {
									$(".header-main").addClass("fixed");
								} else {
									$(".header-main").removeClass("fixed");
								}
							});

						});
					</script>
					<!-- /script-for sticky-nav -->
					<!--inner block start here-->
					<div class="inner-block">

					</div>
					<!--inner block end here-->
					<!--copy rights start here-->
					<?php include('includes/footer.php'); ?>
					<!--COPY rights end here-->
				</div>
			</div>
			<!--//content-inner-->
			<!--/sidebar-menu-->
			<?php include('includes/sidebarmenu.php'); ?>
			<div class="clearfix"></div>
		</div>
		<script>
			var toggle = true;

			$(".sidebar-icon").click(function() {
				if (toggle) {
					$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
					$("#menu span").css({
						"position": "absolute"
					});
				} else {
					$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
					setTimeout(function() {
						$("#menu span").css({
							"position": "relative"
						});
					}, 400);
				}

				toggle = !toggle;
			});
		</script>
		<!--js -->
		<script src="js/jquery.nicescroll.js"></script>
		<script src="js/scripts.js"></script>
		<!-- Bootstrap Core JavaScript -->
		<script src="js/bootstrap.min.js"></script>
		<!-- /Bootstrap Core JavaScript -->

	</body>

	</html>
<?php } ?>