<?php include("../../../config.php"); ?>
<?php
	if(isset($_POST['prjctnm'])) {

		$prjid = mysqli_real_escape_string($con, $_POST['prjctnm']);

		// Getting Sub Project
	  $sql = mysqli_query($con,"SELECT * FROM `prj_subproject` WHERE `status`='1' AND `pid`='$prjid'");

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
	  $bmsqr = mysqli_query($con, "SELECT * FROM `prj_sub_bms` WHERE `project_id`='$prjid'");

	  if (mysqli_num_rows($bmsqr) > 0) {
	  	$bmss = "<option value=''>--- Pick BMS ---</option>";
	  	while ($getbms = mysqli_fetch_object($bmsqr)) {
	  		$bmss .= "<option value='".$getbms->id."'>".$getbms->sub_bms."</option>";
	  	}
	  }

	  else {
	  	$bmss = "<option value=''>No BMS Found</option>";
	  }


	  // Getting PO List
	  $poqr = mysqli_query($con, "SELECT * FROM `prj_po_order` WHERE `prj_id`='$prjid' AND `status`='1'");

	  if (mysqli_num_rows($poqr) > 0) {
	  	$polist = "<option value=''>--- Pick PO ---</option>";
	  	while ($getpo = mysqli_fetch_object($poqr)) {
	  		$polist .= "<option value='".$getpo->po_no."'>".$getpo->po_no."</option>";
	  	}
	  }

	  else {
	  	$polist = "<option value=''>No PO Found</option>";
	  }

	  $final_list = ['subprjs' => $sbprj, 'tbms' => $bmss, 'pos' => $polist];
	  echo json_encode($final_list);
	}
?>
