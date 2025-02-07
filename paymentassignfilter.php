
<?php 
  include("../../config.php");
  if(($_POST['from_date'] != '' || $_POST['to_date'] != '' || $_POST['payee_name'] != '' || $_POST['account_num'] != '' || $_POST['transac_type'] != '' || $_POST['parameter'] != '') && $_POST['parameter'] == 'initial'){
      $bnkacc = $_POST['bankaccid'];
      $from_date = $_POST['from_date'];
      $to_date = $_POST['to_date'];
      $payee_name = $_POST['payee_name'];
      $account_num = $_POST['account_num'];
      if (isset($_POST['payee_name']) && $_POST['payee_name'] != '') {
        $payee_name = $_POST['payee_name'];
        $whr_payee_name .= " AND x.`payee_name` = '" . $payee_name . "'";
      }
      if (isset($_POST['account_num']) && $_POST['account_num'] != '') {
        $account_num = $_POST['account_num'];
        $whr_account_num .= " AND x.`account_num` = '" . $account_num . "'";
      }
      if (isset($_POST['transac_type']) && $_POST['transac_type'] != '') {
        $transac_type = $_POST['transac_type'];
        $whr_transac_type .= " AND x.`transac_type` = '" . $transac_type . "'";
      }
      if ((isset($_POST['from_date']) && $_POST['from_date'] != '') && (isset($_POST['to_date']) && $_POST['to_date'] != '')) {
        $whr_date .= " AND transac_dt BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."'";
      }
      $result = mysqli_query($con,"SELECT x.*, x.id as paymntid, y.*, y.id as stmntid FROM `fin_banking_imports` x, `fin_statement_preview` y WHERE x.`preview_id`=y.`id` AND y.`status`='1' AND y.`bnkacc_id`='".$bnkacc."' $whr_payee_name AND x.`is_pay_aprvd`='0' $whr_account_num $whr_transac_type $whr_date ORDER BY x.`transac_dt` ASC");
      $i=1;
      $output .='<table class="table table-striped table-bordered" id="assgnPays"><thead><tr class="bg-dark"><th>#</th><th>Transaction Date</th><th>PR No.</th><th>Payee Name.</th><th>Account No.</th><th>Transaction Type</th><th>Deposits</th><th>Withdrawals</th><th>Operations</th></tr></thead><tbody>';
      while($fetch=mysqli_fetch_object($result)){
        $transactiondate = $fetch->transac_dt ? $fetch->transac_dt:"Not Given";
        $prnum = $fetch->pr_num ? $fetch->pr_num:"Not Given";
        $payee_name = $fetch->payee_name ? $fetch->payee_name:"Not Given";
        $account_num = $fetch->account_num ? $fetch->account_num:"Not Given";
        $transac_type = $fetch->transac_type ? $fetch->transac_type:"Not Given";
        $chckqr = mysqli_query($con, "SELECT * FROM `fin_payment_entry` WHERE `statement_id`='$fetch->stmntid' AND `bnkimprt_id`='$fetch->paymntid' AND `status`='1'");
        $fthpay = mysqli_fetch_object($chckqr);
        $empid = $_POST['sessionid'];
        $output .='<tr><td>'.$i.'</td><td>'.$transactiondate.'</td><td>'.$prnum.'</td><td>'.$payee_name.'</td><td>'.$account_num.'</td><td>'.$transac_type.'</td><td>&#8377; 0.00</td><td>'.$fetch->transac_amt.'</td><td>';
        if($empid==20 || $empid==87){
          if(mysqli_num_rows($chckqr) == 0) {
            $output .='<button type="button" name="assigns" id="assigns" class="btn btn-danger btn-xs" onclick="window.open("payassign.php?bimpid="'.$fetch->paymntid.'", "_blank", "width=600, height=500")"><strong>Assign</strong></button>   <button type="button" class="btn btn-danger btn-xs" onclick="openpaymentassignModal('.$fetch->paymntid.')">Assign modal</button>';
          }else{
            $output .='<button type="button" name="assignd" id="assignd" class="btn btn-success btn-xs" onclick="window.open();"><strong>Assigned</strong></button>  <button type="button"  name="assignd" id="assignd" class="btn btn-success btn-xs" onclick="openpaymentassigndModal('.$fetch->paymntid.','.$fthpay->id.')"><strong>Assigned Modal</strong></button>';
          }
        }
        $output .='</td></tr>';
      $i++;}
      $output .='</tbody></table>';
      echo $output;
  }else if(($_POST['from_date'] != '' || $_POST['to_date'] != '' || $_POST['payee_name'] != '' || $_POST['account_num'] != '' || $_POST['transac_type'] != '' || $_POST['parameter'] != '') && $_POST['parameter'] == 'confirmation'){
    $bnkacc = $_POST['bankaccid'];
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    $payee_name = $_POST['payee_name'];
    $account_num = $_POST['account_num'];
    if (isset($_POST['payee_name']) && $_POST['payee_name'] != '') {
      $payee_name = $_POST['payee_name'];
      $whr_payee_name .= " AND x.`payee_nm` = '" . $payee_name . "'";
    }
    if (isset($_POST['account_num']) && $_POST['account_num'] != '') {
      $account_num = $_POST['account_num'];
      $whr_account_num .= " AND y.`account_num` = '" . $account_num . "'";
    }
    if (isset($_POST['transac_type']) && $_POST['transac_type'] != '') {
      $transac_type = $_POST['transac_type'];
      $whr_transac_type .= " AND x.`transac_type` = '" . $transac_type . "'";
    }
    if ((isset($_POST['from_date']) && $_POST['from_date'] != '') && (isset($_POST['to_date']) && $_POST['to_date'] != '')) {
      $whr_date .= " AND transac_dt BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."'";
    }
    $result = mysqli_query($con, "SELECT x.*, x.id as payentid, y.*, y.id as bnkimpid, z.* FROM `fin_payment_entry` x, `fin_banking_imports` y, `fin_statement_preview` z WHERE x.`bnkimprt_id`=y.`id` AND x.`statement_id`=z.`id` AND x.`pay_approval_stat`='1' AND z.`status`='1' $whr_payee_name $whr_account_num $whr_transac_type $whr_date AND z.`bnkacc_id`='$bnkacc' ORDER BY y.`transac_dt` ASC");
    $i=1;
    $output .='<table class="table table-striped table-bordered" id="cnfrmPays"><thead><tr class="bg-dark"><th>#</th><th>Transaction Date</th><th>PR No.</th><th>Payee Name.</th><th>Account No.</th><th>Transaction Type</th><th>Deposits</th><th>Withdrawals</th><th>Operations</th></tr></thead><tbody>';
      while($fetch=mysqli_fetch_object($result)){
        $transactiondate = $fetch->transac_dt ? $fetch->transac_dt:"Not Given";
        $prnum = $fetch->pr_num ? $fetch->pr_num:"Not Given";
        $payee_name = $fetch->payee_name ? $fetch->payee_name:"Not Given";
        $account_num = $fetch->account_num ? $fetch->account_num:"Not Given";
        $transac_type = $fetch->transac_type ? $fetch->transac_type:"Not Given";
        $empid = $_POST['sessionid'];
        $output .='<tr><td>'.$i.'</td><td>'.$transactiondate.'</td><td>'.$prnum.'</td><td>'.$payee_name.'</td><td>'.$account_num.'</td><td>'.$transac_type.'</td><td>&#8377; 0.00</td><td>'.$fetch->transac_amt.'</td><td>';
        if($empid == 43){
          $accid = $_GET['accid'];
          $output .='<a href="vwpaydetails.php?bimpid='.$fetch->bnkimpid.'&peid='.$fetch->payentid.'&accid='.$accid.'&rvw" style="text-decoration: none;" class="btn btn-primary btn-xs"><b>Review</b></a>';
        }
      $output .='</td></tr>';
      $i++;}
      $output .='</tbody></table>';
      echo $output;
  }else if(($_POST['from_date'] != '' || $_POST['to_date'] != '' || $_POST['payee_name'] != '' || $_POST['account_num'] != '' || $_POST['transac_type'] != '' || $_POST['parameter'] != '') && $_POST['parameter'] == 'final'){
    $bnkacc = $_POST['bankaccid'];
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    $payee_name = $_POST['payee_name'];
    $account_num = $_POST['account_num'];
    if (isset($_POST['payee_name']) && $_POST['payee_name'] != '') {
      $payee_name = $_POST['payee_name'];
      $whr_payee_name .= " AND x.`payee_nm` = '" . $payee_name . "'";
    }
    if (isset($_POST['account_num']) && $_POST['account_num'] != '') {
      $account_num = $_POST['account_num'];
      $whr_account_num .= " AND y.`account_num` = '" . $account_num . "'";
    }
    if (isset($_POST['transac_type']) && $_POST['transac_type'] != '') {
      $transac_type = $_POST['transac_type'];
      $whr_transac_type .= " AND x.`trnsc_type` = '" . $transac_type . "'";
    }
    if ((isset($_POST['from_date']) && $_POST['from_date'] != '') && (isset($_POST['to_date']) && $_POST['to_date'] != '')) {
      $whr_date .= " AND transac_dt BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."'";
    }
    $result = mysqli_query($con, "SELECT x.*, x.id as payentid, y.*, y.id as bnkimpid, z.* FROM `fin_payment_entry` x, `fin_banking_imports` y, `fin_statement_preview` z WHERE x.`bnkimprt_id`=y.`id` AND x.`statement_id`=z.`id` AND x.`pay_approval_stat`='2' AND z.`status`='1' $whr_payee_name $whr_account_num $whr_transac_type $whr_date AND z.`bnkacc_id`='$bnkacc' ORDER BY y.`transac_dt` ASC");
    $output .='<table class="table table-striped table-bordered" id="fnlPays"><thead><tr class="bg-dark"><th>#</th><th>Transaction Date</th><th>PR No.</th><th>Payee Name</th><th>Account No.</th><th>Transaction Type</th><th>Deposits</th><th>Withdrawals</th><th>Running Balance</th><th>Operations</th></tr></thead><tbody>';
    while($fetch=mysqli_fetch_object($result)){
        $transactiondate = $fetch->transac_dt ? $fetch->transac_dt:"Not Given";
        $prnum = $fetch->pr_num ? $fetch->pr_num:"Not Given";
        $payee_name = $fetch->payee_name ? $fetch->payee_name:"Not Given";
        $account_num = $fetch->account_num ? $fetch->account_num:"Not Given";
        $transac_type = $fetch->transac_type ? $fetch->transac_type:"Not Given";
        if ($fetch->transac_type == "Credit"){
          $deposit = $fetch->transac_amt;
          $withdraw = '0.00';
          $curr_amt = $open_bal + $fetch->transac_amt;  
          $open_bal = number_format($curr_amt,2);
        }else if ($fetch->transac_type == "Debit"){ 
          $deposit = '0.00';
          $withdraw = $fetch->transac_amt;
          $curr_amt = $open_bal - $fetch->transac_amt;
          $open_bal = number_format($curr_amt,2); 
        }
        $output .='<tr><td>'.$i.'</td><td>'.$transactiondate.'</td><td>'.$prnum.'</td><td>'.$payee_name.'</td><td>'.$account_num.'</td><td>'.$transac_type.'</td><td>&#8377;'.$deposit.'</td><td>&#8377;'.$withdraw.'</td><td>'.$open_bal.'</td><td nowrap><a href="vwpaydetails.php?bimpid='.$fetch->bnkimpid.'&peid='.$fetch->payentid.'" style="text-decoration: none;" class="btn btn-primary btn-xs"><b>View</b></a></td></tr>';
    $i++;}
    $output .='</tbody></table>';
    echo $output;
  }else{
    echo 5;
  }
?>