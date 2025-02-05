<?php include("../../../config.php"); ?>
<?php
	if(isset($_POST['subprjct_nm']) && isset($_POST['bmsnm']) && isset($_POST['joucd'])) {

		$subprjid = mysqli_real_escape_string($con, $_POST['subprjct_nm']);
		$bmsid = mysqli_real_escape_string($con, $_POST['bmsnm']);
		$joucd = mysqli_real_escape_string($con, $_POST['joucd']);

		$wrkvalqr = mysqli_query($con, "SELECT * FROM `prj_joborder_req_dtls` WHERE `sub_proj_id`='$subprjid' AND `bm`='$bmsid' AND `uniqcode`='$joucd'");
		if (mysqli_num_rows($wrkvalqr) > 0) {
			while ($fthwrkval = mysqli_fetch_object($wrkvalqr)) {
				$work = $fthwrkval->work_descp;
				$totalamt = $fthwrkval->total;
				echo $work."#".$totalamt;
			}
		}
	}
?>