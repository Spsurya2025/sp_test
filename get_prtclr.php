<?php 
  require_once('../../config.php');
  if(isset($_POST['othrhead'])) {
    $othrhead = $_POST['othrhead'];
    $sql = mysqli_query($con,"SELECT `lnkwith`, `col_nm` FROM `fin_grouping_subtype` WHERE `id`='$othrhead'");
    $res = mysqli_fetch_object($sql);
    $lnkwith=$res->lnkwith;
    $col_nm=$res->col_nm;
?>
  <option value=''>--- Pick A Particular Name ---</option>";
<?php
    if($col_nm != '') {
      // if($othrhead==11 || $othrhead==12 || $othrhead==70 || $othrhead==73 || $othrhead==108)$where=" WHERE group_subtype=$othrhead";
      // else $where="";
      //==========updated 31/01/2023=============
      if($othrhead==1 || $othrhead==2 || $othrhead==3 || $othrhead==10 || $othrhead==38 || $othrhead==65 || $othrhead==66 || $othrhead==67 || $othrhead==78)$where="";
      else $where=" WHERE group_subtype=$othrhead";
      //==========updated 31/01/2023=============
      $qury=mysqli_query($con,"SELECT `id`, $col_nm FROM $lnkwith".$where);
      while($row = mysqli_fetch_object($qury)){
        echo "<option value='".$row->id."'>".$row->$col_nm."</option>";
      }
    }
    else {
      echo "<option value='0'>NA</option>";
    }
  }
?>