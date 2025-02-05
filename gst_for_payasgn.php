<?php include("../../config.php"); ?>
<?php
	if(isset($_POST['org']) && isset($_POST['state'])) {
		$orgid = mysqli_real_escape_string($con, $_POST['org']);
		$stateid = mysqli_real_escape_string($con, $_POST['state']);
	  	$sql = mysqli_query($con,"SELECT * FROM `pur_address` WHERE `status`='1' AND `org_id`='$orgid' AND `sid`='$stateid' AND `addrss_type`='Billing Address'");
		  if (mysqli_num_rows($sql) > 0) {
		  	$fthgst = mysqli_fetch_object($sql);
		  	echo $fthgst->gst_no;
		  }
		  else {
		  	echo " ";
		  }
	}
?>