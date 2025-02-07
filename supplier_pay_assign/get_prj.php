<?php include("../../../config.php"); ?>

<?php
	if(isset($_POST['sup_id'])) { 

		$suplier_id = $_POST['sup_id'];

		// Getting Project Details
		$sql_fetchs = mysqli_query($con,"SELECT x.*,y.`pname` FROM `prj_po_order` x,`prj_project` y WHERE x.`status`='1' AND x.`prj_id`=y.`id` AND x.`supl_name`='$suplier_id' GROUP BY y.`pname`");
		if (mysqli_num_rows($sql_fetchs) > 0) {
			echo "<option value=''>--- Pick A Project ---</option>";
			while ($row = mysqli_fetch_object($sql_fetchs)) { 
				echo "<option value='" .$row->prj_id."'>" .$row->pname."</option>";
			}
		}
		else {
			echo "<option value=''>NO Project Found</option>";
		}
	}
?>