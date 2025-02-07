<?php include("../../../config.php"); ?>
<?php
	if(isset($_POST['subprjct_nm']) && isset($_POST['joucd'])) {
		$spid = mysqli_real_escape_string($con, $_POST['subprjct_nm']);
		$joucd = mysqli_real_escape_string($con, $_POST['joucd']);
		$bmsqr = mysqli_query($con, "SELECT prj_joborder_req.`joborder_type`,prj_joborder_req_dtls.* FROM prj_joborder_req JOIN prj_joborder_req_dtls ON prj_joborder_req.`uniqval` = prj_joborder_req_dtls.`uniqcode` WHERE prj_joborder_req_dtls.`sub_proj_id`= '$spid' AND prj_joborder_req_dtls.`uniqcode`='$joucd'");
		if (mysqli_num_rows($bmsqr) > 0) {
			echo "<option value=''>--- Pick A BMS ---</option>";
			while ($fthbms = mysqli_fetch_object($bmsqr)) {
				$bmsid = $fthbms->bm;
				if ($fthbms->joborder_type == 2 || $fthbms->joborder_type == 3  || $fthbms->joborder_type == 6) {
                    $table = 'prj_sub_bms_rate';
                } else {
                    $table = 'prj_sub_bms';
                }
				$bmsnmqr = mysqli_query($con, "SELECT sub_bms FROM ".$table." WHERE `id`='$bmsid'");
				while($bmsnm = mysqli_fetch_object($bmsnmqr)){
					$bmsnmae= $bmsnm->sub_bms;
				}
				echo "<option value='$bmsid'>".$bmsnmae."</option>";
			}
		}
		else {
			echo "<option value=''>No BMS Found</option>";
		}
	}
?>