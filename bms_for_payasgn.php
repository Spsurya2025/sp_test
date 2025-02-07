<?php include("../../config.php"); ?>
<?php
	if(isset($_POST['subprjct_nm']) && isset($_POST['joucd'])) {
		$spid = mysqli_real_escape_string($con, $_POST['subprjct_nm']);
		$joucd = mysqli_real_escape_string($con, $_POST['joucd']);
		$bmsqr = mysqli_query($con, "SELECT prj_joborder_req.`joborder_type`,prj_joborder_req_dtls.* FROM prj_joborder_req JOIN prj_joborder_req_dtls ON prj_joborder_req.`uniqval` = prj_joborder_req_dtls.`uniqcode` WHERE prj_joborder_req_dtls.`sub_proj_id`= '$spid' AND prj_joborder_req_dtls.`uniqcode`='$joucd'");
		if (mysqli_num_rows($bmsqr) > 0) {
			echo "<option value=''>--- Pick A BMS ---</option>";
			while ($fthbms = mysqli_fetch_object($bmsqr)) {
				$bmsid = $fthbms->bm;
				echo $fthbms->joborder_type;
				if($fthbms->joborder_type == '1'){
					$table = 'prj_sub_bms';
				}elseif($fthbms->joborder_type == '2'){
					$table = 'prj_sub_bms_rate';
				}
				$bmsnmqr = mysqli_query($con, "SELECT * FROM ".$table." WHERE `id`='$bmsid'");
				$bmsnm = mysqli_fetch_object($bmsnmqr);
				echo "<option value='$bmsid'>".$bmsnm->sub_bms."</option>";
			}
		}
		else {
			echo "<option value=''>No BMS Found</option>";
		}
	}
?>