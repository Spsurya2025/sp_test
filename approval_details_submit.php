<?php 
  require_once('../../auth.php');
  require_once('../../config.php');
  setlocale(LC_MONETARY, 'en_IN');
  include('../../workflownotif.php');
?>
<?php 
	if(isset($_POST['aprvpayreq']) && $_POST['aprvpayreq'] == 'aprvpayreq') {
	  $payreqid = $_POST['rowid'];
    $allpayreqid = $_POST['requestid'];//request id
    $reqaprvlmsg = $_POST['approval_message'];
    $reqaprvstg = $_POST['nextstage'];
    $ttlaprvstg = $_POST['totalstage'];
    $reqfor = $_POST['requesttype'];
    $stat_msg_by = $_POST['session_id'];
    $created_on = date('Y-m-d H:i:s');
    if ($ttlaprvstg == $reqaprvstg) {
       $payreq_status = 3;
    }else{
       $payreq_status = 2;
    }
    $sql = mysqli_query($con, "INSERT INTO `fin_payreq_aprvl_msg` (`payreqid`, `allpayreqid`, `reqaprvlmsg`, `reqaprvstg`,`payreq_status`, `stat_msg_by`, `created_on`) VALUES ('$payreqid', '$allpayreqid', '$reqaprvlmsg', '$reqaprvstg','$payreq_status','$stat_msg_by', '$created_on')");
    if($sql){
     	$newnxtstg = $reqaprvstg + 1;
        if ($ttlaprvstg == $reqaprvstg) {
           $updstat = mysqli_query($con, "UPDATE `fin_all_pay_request` SET `current_aprvl_stage`='$reqaprvstg', `nxt_aprvl_stage`='$newnxtstg',`payreq_status`='3' WHERE `id`='$allpayreqid'");
        }else{
           $updstat = mysqli_query($con, "UPDATE `fin_all_pay_request` SET `current_aprvl_stage`='$reqaprvstg', `nxt_aprvl_stage`='$newnxtstg', `payreq_status`='2' WHERE `id`='$allpayreqid'");
        }
        /*notification */
        if ($reqfor == "Supplier")
        {
          $supplierdetails = mysqli_query($con, "SELECT * FROM `fin_all_pay_request` WHERE `pay_request_id` = '".$payreqid."'");
         $final_req = mysqli_fetch_object($supplierdetails);
         $final_req_amt = $final_req->payreq_amt;
         $maxamount = mysqli_query($con, "SELECT * FROM `fin_payaprv_amount_supplier` WHERE `minamt` < '".$final_req_amt."' AND `maxamt` > '".$final_req_amt."'");
         $se = mysqli_num_rows($maxamount);
         if($se > 0)
         {
           $totalstg = mysqli_fetch_object($maxamount);
           $amid = $totalstg->id;
           if($ttlaprvstg == $reqaprvstg)
           {
             $supplierdetails = mysqli_query($con, "SELECT * FROM `fin_payreq_aprvl_msg` WHERE `payreqid` = '".$payreqid."' AND `payreq_status` = '3'");
             $final_req = mysqli_fetch_object($supplierdetails);
             $last_id = $final_req->payreqid;
             $empdetails = mysqli_query($con, "SELECT * FROM `mstr_emp` WHERE `id`='".$final_req->stat_msg_by."'");
             $empdtls = mysqli_fetch_object($empdetails);
             $empname = $empdtls->fullname;//Action Done by this person
             $requestbydtls = mysqli_query($con, "SELECT * FROM `fin_all_pay_request` WHERE `pay_request_id`='".$payreqid."'");
             $requestby = mysqli_fetch_object($requestbydtls);
             $requestbyid = $requestby->payreq_by_id;
             $notificationmsg = "Supplier Request Amount of: RS ".$requestby->payreq_amt." Final Approved By ".$empname;
             sendWfnotification($con,$notificationmsg,$last_id,"Supplier",'','',$requestbyid,"finance/mngmypayreq.php",'');
           }
           else{
             $splrsql = mysqli_query($con, "SELECT x.*, y.fullname FROM `fin_payaprv_emp_supplier` x, `mstr_emp` y WHERE x.`empnm`=y.`id` AND x.`amtid`='$amid' AND x.`stage`='".$newnxtstg."' ORDER BY x.`id` ASC");
             $emplid = array();
             foreach ($splrsql as $key => $value){
               $emplid[] = $value['empnm'];
             }
             $employeeid = implode(",", $emplid);
             $last_id = $final_req->payreq_id;
             $notificationmsg = "Payment Request for Supplier having Request Amount of: RS ".$final_req_amt." Approved By ".$_SESSION['ERP_SESS_FULLNAME']. " is pending for Next stage approval";
             sendWfnotification($con,$notificationmsg,$last_id,"Supplier",'','',$employeeid,"finance/payapproval_supplier.php",'');
           }
         }
        }  
        /*notification */  
        if($_POST['get_types']=='pendings'){
             echo 2;
        }else{
             echo 1;
        }
    }
  }
?>