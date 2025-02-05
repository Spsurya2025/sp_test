
<?php 
  include("../../config.php");
  if($_POST['from_date'] != '' || $_POST['to_date'] != '' || $_POST['payee_name'] != '' || $_POST['account_num'] != '' || $_POST['transac_type'] != '' || $_POST['organisation_name'] != '' || $_POST['account_name'] != ''){
      $bnkacc = $_POST['bankaccid'];
      $from_date = $_POST['from_date'];
      $to_date = $_POST['to_date'];
      $payee_name = $_POST['payee_name'];
      $account_num = $_POST['account_num'];
      $organisation_name = $_POST['organisation_name'];
      $account_name = $_POST['account_name'];
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
      if (isset($_POST['account_name']) && $_POST['account_name'] != '') {
        $account_name = $_POST['account_name'];
        $whr_account_name .= " AND y.`bnkacc_id` = '" . $account_name . "'";
      }
      if (isset($_POST['organisation_name']) && $_POST['organisation_name'] != '') {
        $organisation_name = $_POST['organisation_name'];
        $whr_organisation_name .= " AND y.`orgnstn_id` = '" . $organisation_name . "'";
      }
      $result = mysqli_query($con,"SELECT x.*, x.id as paymntid, y.*, y.id as stmntid FROM `fin_banking_imports` x, `fin_statement_preview` y WHERE x.`preview_id`=y.`id` AND y.`status`='1' And x.`is_pay_aprvd` = '0' $whr_payee_name $whr_account_num $whr_transac_type $whr_date $whr_account_name $whr_organisation_name ORDER BY x.`id` Desc");
      $i=1;
      $output .='<thead><tr class="bg-dark"><th>#</th><th>Organisation Name</th><th>Account Name</th><th>Account Number</th><th>Bank Name</th><th>Branch Name</th><th>Upload By</th><th>Transaction Date</th><th>PR No.</th><th>Payee Name.</th><th>Transaction Type</th><th>Credit</th><th>Debit</th><th>Pending With</th></tr></thead><tbody>';
      if(mysqli_num_rows($result) >0){
        while($fetch=mysqli_fetch_object($result)){
        $bankresult = mysqli_query($con,"SELECT * FROM `fin_bankaccount` x WHERE `id`= ".$fetch->bnkacc_id);
        $fetchbank = mysqli_fetch_object($bankresult);
        if ($fetchbank->acc_type=='1') 
        {
          $tablename = "fin_bank";
        }else if($fetchbank->acc_type=='2'){
          $tablename = "fin_work_capital";
        }
        $bnkqr = mysqli_query($con, "SELECT x.*, y.organisation FROM ".$tablename." x, `prj_organisation` y WHERE x.`orgname`=y.`id` AND x.`id`= '".$fetchbank->bnkname."'");
        $bankdetails = mysqli_fetch_object($bnkqr);
        $orgns=$bankdetails->organisation ? $bankdetails->organisation:'Not Available';
        $accntname=$fetchbank->accnm ? $fetchbank->accnm:'Not Available';//account name
        $accntnumber=$fetchbank->accntnum ? $fetchbank->accntnum:'Not Available';//account name
        $bnkname = $bankdetails->bnkname ? $bankdetails->bnkname:'Not Available';
        $branchname = $bankdetails->branch ? $bankdetails->branch:'Not Available';
        $transac_dt = $fetch->transac_dt ? $fetch->transac_dt:"Not Given";
        $pr_num = $fetch->pr_num ? $fetch->pr_num:"Not Given";
        $payee_name = $fetch->payee_name ? $fetch->payee_name:"Not Given";
        $transac_type = $fetch->transac_type ? $fetch->transac_type:"Not Given";
        if($fetch->transac_type == 'Credit'){ $credit = $fetch->transac_amt;}else{$credit ='0.00' ;}
        if($fetch->transac_type == 'Debit'){ $debit =  $fetch->transac_amt;}else{$debit = '0.00' ;}
        if($fetch->is_pay_aprvd == '0'){ $pending = "Pending With Rohit Mallik And Umesh chandra rout";}elseif($fetch->is_pay_aprvd == '1'){ $pending = "Pending With Samarendra Sangram Singh"; }
        $empresult = mysqli_query($con,"SELECT fullname FROM `mstr_emp` WHERE `id`= ".$fetch->upload_by);
        $empdetails=mysqli_fetch_object($empresult);
        $output .='<tr><td>'.$i.'</td><td>'.$orgns.'</td><td>'.$accntname.'</td><td>'.$accntnumber.'</td><td>'.$bnkname.'</td><td>'.$branchname.'</td><td>'.$empdetails->fullname.'</td><td>'.$transac_dt.'</td><td>'.$pr_num.'</td><td>'.$payee_name.'</td><td>'.$transac_type.'</td><td>'.$credit.'</td><td>'.$debit.'</td><td>'.$pending.'</td></tr>';
        $i++;}
        $output .='</tbody>';
        echo $output;
      }else{
        echo $output .='<tr><td colspan="14">No Record Found</td></tr>';
      }
      
  }else{
    echo '';
  }
?>