<?php include("../../../config.php"); ?>

<?php   // && isset($_POST['org'])        
	if(isset($_POST['prjj']) && isset($_POST['supl'])) {  // org:org

	$prjid = mysqli_real_escape_string($con, $_POST['prjj']);
	$splrid = mysqli_real_escape_string($con, $_POST['supl']);
	// $org = mysqli_real_escape_string($con, $_POST['org']);
	$sql = mysqli_query($con,"SELECT * FROM `prj_po_order` WHERE `status`='1' AND `prj_id`='$prjid' AND `supl_name`='$splrid'");
	  if(mysqli_num_rows($sql) > 0){
	    echo "<option value=''>--- Select PO ---</option>";
	    while($row = mysqli_fetch_object($sql)) {
	      echo "<option value='".$row->po_no."'>".$row->po_no."</option>";
	    }
	  }else {
	  	echo "<option value=''>No PO Found</option>";
	  }
	}
?>
<?php
	if(isset($_POST['ponum'])){
	  $ponum = mysqli_real_escape_string($con, $_POST['ponum']);
	  $po_qry = mysqli_query($con,"SELECT * FROM `prj_po_order` WHERE `status`='1' AND `po_no`='$ponum'");
		$po_ftch = mysqli_fetch_object($po_qry);
	 echo $po_ftch->total_sum_all.'#'.date('Y-m-d', strtotime($po_ftch->created_on)).'#'.$po_ftch->transport_total.'#'.$po_ftch->inspection_total;
	}
?>