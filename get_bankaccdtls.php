<?php include("../../config.php"); ?>

<?php
if (isset($_POST['org_nm'])) {
    $orgid = mysqli_real_escape_string($con, $_POST['org_nm']);
    $gtbacc = mysqli_query($con, "SELECT * FROM `fin_bankaccount` WHERE `orgid`='$orgid' AND status='1'");

    echo "<option value=''>Pick A Bank Account</option>";
    while ($fthbacc = mysqli_fetch_object($gtbacc)) {
      echo "<option value='".$fthbacc->id."'>".$fthbacc->accnm."</option>";
    }
  }

  if (isset($_POST['bankid'])) {
	  $bankid = mysqli_real_escape_string($con, $_POST['bankid']); 
    $fetchacc = mysqli_query($con,"SELECT * FROM `fin_bankaccount` WHERE `id`='$bankid'");
    $rowacc = mysqli_fetch_object($fetchacc);

    $fetch = mysqli_query($con,"SELECT * FROM `fin_bank` WHERE `id`='$rowacc->bnkname'");
    $row = mysqli_fetch_object($fetch);

    $locqry=mysqli_query($con,"SELECT * FROM `fin_location` WHERE `id` = ".$row->location." and `status`='1'");
    $getloc = mysqli_fetch_object($locqry);
    if ($row->branch!='') {
      $branch = $row->branch;
    }else{
      $branch = "NA";
    }
    if ($row->ifsc!='') {
      $ifsc = $row->ifsc;
    }else{
      $ifsc = "NA";
    }
    if ($rowacc->accntnum!='') {
      $accnum = $rowacc->accntnum;
    }else{
      $accnum = "NA";
    }
    if ($row->cifno!='') {
      $cifno = $row->cifno;
    }else{
      $cifno = "NA";
    }
    if ($getloc->lname!='') {
      $locid = $getloc->lname;
    }else{
      $locid = "NA";
    }
    if ($getloc->lname!='') {
      $locnm = $getloc->lname;
    }else{
      $locnm = "NA";
    }
    echo $branch.'*'.$accnum.'*'.$ifsc.'*'.$cifno.'*'.$locid.'*'.$locnm;
  }

?>