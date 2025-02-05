<?php include("../../../config.php"); ?>
<?php
if (isset($_POST['vndrnm']) && isset($_POST['prjct_name'])) {
	$vndrid = mysqli_real_escape_string($con, $_POST['vndrnm']);
	$prjctid = mysqli_real_escape_string($con, $_POST['prjct_name']);

	$joqr = mysqli_query($con, "SELECT * FROM `prj_joborder_req` WHERE `vendor`='$vndrid' AND `proj_id`='$prjctid' AND `jon`!=''");
	if (mysqli_num_rows($joqr) > 0) {
		echo "<option value=''>--- Pick A JO ---</option>";
		while ($fthjo = mysqli_fetch_object($joqr)) {
			echo "<option value='$fthjo->jon'>" . $fthjo->jon . "</option>";
		}
	} else {
		echo "<option value=''>No JO Found</option>";
	}
}
?>