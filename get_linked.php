<?php require_once('../../config.php'); ?>

<?php
  if(isset($_POST['headdid'])) {
    $othrhead = $_POST['headdid'];
    $sql = mysqli_query($con,"SELECT `lnkwith` FROM `fin_grouping_subtype` WHERE `id`='$othrhead'");
    $res = mysqli_fetch_object($sql);
    $lnkwith = $res->lnkwith;
    echo $lnkwith;
  }
?>