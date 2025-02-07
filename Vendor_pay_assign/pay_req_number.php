<?php include("../../../config.php"); ?>
<?php
      $trnscto = $_POST['trnscto'];

	//$querys = mysqli_query($con, "SELECT x.pr_num FROM `fin_all_pay_request` x LEFT JOIN fin_payment_entry y ON (x.pr_num = y.preqnum) WHERE x.request_for = '$trnscto' AND x.payreq_status = '1' AND y.preqnum IS NULL ");
	echo "SELECT x.pr_num FROM fin_all_pay_request x LEFT JOIN fin_payment_entry y ON x.pr_num = y.preqnum WHERE x.request_for = '$trnscto' AND x.payreq_status = '1' AND (y.preqnum IS NULL OR (y.preqnum IS NOT NULL AND y.pay_approval_stat = 6))";
	$querys = mysqli_query($con, "SELECT x.pr_num FROM fin_all_pay_request x LEFT JOIN fin_payment_entry y ON x.pr_num = y.preqnum WHERE x.request_for = '$trnscto' AND x.payreq_status = '1' AND (y.preqnum IS NULL OR (y.preqnum IS NOT NULL AND y.pay_approval_stat = 6))");
	if (mysqli_num_rows($querys) > 0) {
		echo "<option value=''>--- Paymnet Request Number ---</option>";
		while ($sfetch = mysqli_fetch_object($querys)) {
			echo "<option value='$sfetch->pr_num'>" . $sfetch->pr_num . "</option>";
		}
	} else {
		echo "<option value='0'>No Request Number Found</option>";
	}

?>