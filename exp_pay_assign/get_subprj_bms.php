<?php include("../../../config.php"); ?>
<?php
	if(isset($_POST['prjctnm'])) {

		$prjid = mysqli_real_escape_string($con, $_POST['prjctnm']);

		// Getting Sub Project
	  $sql = mysqli_query($con,"SELECT id,spname FROM `prj_subproject` WHERE `status`='1' AND `pid`='$prjid'");

	  if(mysqli_num_rows($sql) > 0) {
	    $sbprj = "<option value=''>--- Pick Sub Project ---</option>";
	    while($row = mysqli_fetch_object($sql)) {
	      $sbprj .= "<option value='".$row->id."'>".$row->spname."</option>";
	    }
	  }

	  else {
	  	$sbprj = "<option value=''>No Sub Project Found</option>";
	  }


	  // Getting BMS
	  $bmsqr = mysqli_query($con, "SELECT id,sub_bms FROM `prj_sub_bms` WHERE `project_id`='$prjid'");

	  if (mysqli_num_rows($bmsqr) > 0) {
	  	$bmss = "<option value=''>--- Pick BMS ---</option>";
	  	while ($getbms = mysqli_fetch_object($bmsqr)) {
	  		$bmss .= "<option value='".$getbms->id."'>".$getbms->sub_bms."</option>";
	  	}
	  }

	  else {
	  	$bmss = "<option value=''>No BMS Found</option>";
	  }

	  $final_list = ['sbprjnm' => $sbprj, 'blng_ms' => $bmss];
	  echo json_encode($final_list);
	}
?>
