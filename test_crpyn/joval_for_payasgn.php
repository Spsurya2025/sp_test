<?php include("../config.php"); ?>
<?php
	if(isset($_POST['jobodr_num'])) {

		$joid = mysqli_real_escape_string($con, $_POST['jobodr_num']);

		// Total Job Order Value
		$jovalqr = mysqli_query($con, "SELECT x.*,y.total FROM `prj_joborder_req` x, `prj_joborder_req_dtls` y WHERE x.`uniqval`=y.`uniqcode` AND x.`jon`='$joid'");
		if (mysqli_num_rows($jovalqr) > 0) {
			$totaljoval = 0;
			while ($fthjoval = mysqli_fetch_object($jovalqr)) {
				$totaljoval += $fthjoval->total;
			}
		}
		else {
			$totaljoval = 'NA';
		}

		// Job Order Unique Code
		$joucqr = mysqli_query($con, "SELECT `uniqval` FROM `prj_joborder_req` WHERE `jon`='$joid'");
		$fthuc = mysqli_fetch_object($joucqr);
		$jounqcd = $fthuc->uniqval;

		echo $totaljoval."#".$jounqcd;
	}
?>
