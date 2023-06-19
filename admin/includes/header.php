<div class="header-main d-flex">

	<div class="logo-w3-agile bg-dark left-chamfer">
		<h2 class="text-white no-decoration">
			<a href="dashboard.php">
				<?php
				$q = "SELECT businessName FROM `businessInfo`;";
				$stmt = $dbh->query($q);
				echo "{$stmt->fetch(PDO::FETCH_COLUMN)} Car Wash";
				?>
			</a>
		</h2>
	</div>

	<div class="profile_details w3l">
		<ul>
			<li class="dropdown profile_details_drop">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					<div class="profile_img">
						<span class="prfil-img"><img src="images/User-icon.png" alt=""> </span>
						<div class="user-name">
							<p>Welcome</p>
							<span>Administrator</span>
						</div>
						<i class="fa fa-angle-down"></i>
						<i class="fa fa-angle-up"></i>
						<div class="clearfix"></div>
					</div>
				</a>
				<ul class="dropdown-menu drp-mnu">
					<li> <a href="change-password.php"><i class="fa fa-lock"></i> Setting</a> </li>
					<li> <a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a> </li>
				</ul>
			</li>
		</ul>
	</div>

	<div class="clearfix"> </div>
</div>