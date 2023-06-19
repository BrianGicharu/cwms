<?php
include_once("../includes/config.php");
?>
<div class="copyrights">
	<p>&copy;<?php echo date('Y'); ?>
		<?php
		$q = "SELECT businessName FROM `businessInfo`;";
		$stmt = $dbh->query($q);
		echo "PCLKE Kenya All Rights Reserved <strong><i style='color:brown;'>0725200738</i></strong> &nbsp;| <a href='#'>{$stmt->fetch(PDO::FETCH_COLUMN)}</a>";
		?>
	</p>
</div>