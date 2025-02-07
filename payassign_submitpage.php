<?php include("../../config.php");?>
<?php
if(isset($_POST['pay_bnkacc'])) // Add query
{
	$bnkimprt_id = mysqli_real_escape_string($con, $_POST['bimpid']);
    $statement_id = mysqli_real_escape_string($con, $_POST['stmnt_prvw']);
    $bankacc_id = mysqli_real_escape_string($con, $_POST['bankacc_id']);
    $trnsc_type = mysqli_real_escape_string($con, $_POST['trnsc_type']);
    $orgnsn_name = mysqli_real_escape_string($con, $_POST['pay_orgnstn']);
    $trnscto = mysqli_real_escape_string($con, $_POST['trnscto']);
    $payee_nm = mysqli_real_escape_string($con, $_POST['payee_nm']);
    $paid_amnt = mysqli_real_escape_string($con, $_POST['paidamt']);
    $created_on = date('Y-m-d H:i:s');
    // Main Payment Entry Table Insertion
    $insqry = mysqli_query($con, "INSERT INTO `fin_payment_entry` (`bnkimprt_id`, `statement_id`, `bankacc_id`, `preqnum`, `trnsc_type`, `orgnsn_name`, `trnscto`, `payee_nm`, `pay_assgn_stat`, `pay_approval_stat`, `status`) VALUES ('$bnkimprt_id', '$statement_id', '$bankacc_id', '', '$trnsc_type', '$orgnsn_name', '$trnscto', '$payee_nm', '1', '0', '1')");   
    $pentry_last_id = mysqli_insert_id($con); 
    if($insqry){
  	  if($trnscto == "vendor"){ // If Transaction Type is 'Vendor'
          $vndrnm = mysqli_real_escape_string($con, $_POST['vndrnm']);
          $prjct_name = mysqli_real_escape_string($con, $_POST['prjct_name']);
          $jobodr_num = mysqli_real_escape_string($con, $_POST['jobodr_num']);
          $jobodr_val = mysqli_real_escape_string($con, $_POST['jobodr_val']);
          $subprjct_nm = mysqli_real_escape_string($con, $_POST['subprjct_nm  ']);
          $bmsnm = mysqli_real_escape_string($con, $_POST['bmsnm']);
          $wrk_dscrptn = mysqli_real_escape_string($con, $_POST['wrk_dscrptn']);
          $subprjct_val = mysqli_real_escape_string($con, $_POST['subprjct_val']);
          $vndrinqr = mysqli_query($con, "INSERT INTO `fin_payment_entry_vendor` (`payent_id`, `pay_rqst_id`, `vndrnm`, `prjct_name`, `jobodr_num`, `jobodr_val`, `subprjct_nm`, `bmsnm`, `wrk_dscrptn`, `subprjct_val`, `rqst_amt`, `paid_amnt`, `status`) VALUES ('$pentry_last_id', '0', '$vndrnm', '$prjct_name', '$jobodr_num', '$jobodr_val', '$subprjct_nm', '$bmsnm', '$wrk_dscrptn', '$subprjct_val', '0', '$paid_amnt', '1')");
          $updates = mysqli_query($con, "UPDATE fin_payment_entry SET preqnum='$rqstno' WHERE id='$pentry_last_id'");
      }else if ($trnscto == "supplier") { // If Transaction Type is 'Supplier'
          $suplrnm = mysqli_real_escape_string($con, $_POST['suplrnm']);
          $prj_name = mysqli_real_escape_string($con, $_POST['prj_name']);
          $ponum = mysqli_real_escape_string($con, $_POST['ponum']);
          $podate = mysqli_real_escape_string($con, $_POST['podate']);
          $poamnt = mysqli_real_escape_string($con, $_POST['poamnt']);
          $spreq_typ = mysqli_real_escape_string($con, $_POST['spreq_typ']);
          if ($spreq_typ == "PR") {
            $pr_numbr = mysqli_real_escape_string($con, $_POST['pr_numbr']);
            $subprj_nm = mysqli_real_escape_string($con, $_POST['subprj_nm']);
            $bms_name = mysqli_real_escape_string($con, $_POST['bms_name']);
            $pramnt = mysqli_real_escape_string($con, $_POST['pramnt']);
            $trnsrsn = '';
            $pr_paid_amnt = $paid_amnt;
          }else {
            $pr_numbr = '';
            $subprj_nm = '';
            $bms_name = '';
            $pramnt = '';
            $trnsrsn = mysqli_real_escape_string($con, $_POST['trnsrsn']);
            $trns_paid_amnt = $paid_amnt;
          }
          $splrqr = mysqli_query($con, "INSERT INTO `fin_payment_entry_supplier` (`payent_id`, `pay_rqst_id`, `suplrnm`, `prj_name`, `ponum`, `podate`, `poamnt`, `pr_numbr`, `subprj_nm`, `bms_name`, `pramnt`, `pr_request_amt`, `pr_paid_amnt`, `trnsrsn`, `trns_rqst_amt`, `trns_paid_amnt`, `status`) VALUES ('$pentry_last_id', '0', '$suplrnm', '$prj_name', '$ponum', '$podate', '$poamnt', '$pr_numbr', '$subprj_nm', '$bms_name', '$pramnt', '0', '$pr_paid_amnt', '$trnsrsn', '0', '$trns_paid_amnt', '1')");
          $updates = mysqli_query($con, "UPDATE fin_payment_entry SET preqnum='$rqstno' WHERE id='$pentry_last_id'");
      }else if ($trnscto == "transporter") { // If Transaction Type is 'Transporter'
          $trnsprtrnm = mysqli_real_escape_string($con, $_POST['trnsprtrnm']);
          $prjctnm = mysqli_real_escape_string($con, $_POST['prjctnm']);
          $subprjnm = mysqli_real_escape_string($con, $_POST['subprjnm']);
          $bmsnm = mysqli_real_escape_string($con, $_POST['bmsnm']);
          $ponum = mysqli_real_escape_string($con, $_POST['ponum']);
          $place_from = mysqli_real_escape_string($con, $_POST['place_from']);
          $place_to = mysqli_real_escape_string($con, $_POST['place_to']);
          $distance = mysqli_real_escape_string($con, $_POST['distance']);
          $material_nm = mysqli_real_escape_string($con, $_POST['material_nm']);
          $mtrl_weight = mysqli_real_escape_string($con, $_POST['mtrl_weight']);
          $service_typ = mysqli_real_escape_string($con, $_POST['service_typ']);
          $lry_model = mysqli_real_escape_string($con, $_POST['lry_model']);
          $dala_typ = mysqli_real_escape_string($con, $_POST['dala_typ']);
          $carrycap = mysqli_real_escape_string($con, $_POST['carrycap']);
          $totalamnt = mysqli_real_escape_string($con, $_POST['totalamnt']);
          $rateper_km = mysqli_real_escape_string($con, $_POST['rateper_km']);
          $rateper_kg = mysqli_real_escape_string($con, $_POST['rateper_kg']);
          $trnsptqr = mysqli_query($con, "INSERT INTO `fin_payment_entry_transporter` (`payent_id`, `pay_rqst_id`, `trnsprtrnm`, `prjctnm`, `subprjnm`, `bmsnm`, `ponum`, `place_from`, `place_to`, `distance`, `material_nm`, `mtrl_weight`, `service_typ`, `lry_model`, `dala_typ`, `carrycap`, `totalamnt`, `rateper_km`, `rateper_kg`, `adv_prcnt`, `adv_amt`, `final_amnt`, `trns_req_amt`, `paidamnt`, `status`) VALUES ('$pentry_last_id', '0', '$trnsprtrnm', '$prjctnm', '$subprjnm', '$bmsnm', '$ponum', '$place_from', '$place_to', '$distance', '$material_nm', '$mtrl_weight', '$service_typ', '$lry_model', '$dala_typ', '$carrycap', '$totalamnt', '$rateper_km', '$rateper_kg', '0', '0', '0', '0', '$paid_amnt', '1')");
          $updates = mysqli_query($con, "UPDATE fin_payment_entry SET preqnum='$rqstno' WHERE id='$pentry_last_id'");
      }else if ($trnscto == "gst") { // If Transaction Type is 'GST'
          $organisation = mysqli_real_escape_string($con, $_POST['organisation']);
          $state_nm = mysqli_real_escape_string($con, $_POST['state_nm']);
          $gstnum = mysqli_real_escape_string($con, $_POST['gstnum']);
          $fromdate = mysqli_real_escape_string($con, $_POST['fromdate']);
          $todate = mysqli_real_escape_string($con, $_POST['todate']);
          $gsttqr = mysqli_query($con, "INSERT INTO `fin_payment_entry_gst` (`payent_id`, `pay_rqst_id`, `organisation`, `state_nm`, `gstnum`, `gst_req_amt`, `fromdate`, `todate`, `paid_gst_amt`, `status`) VALUES ('$pentry_last_id', '0', '$organisation', '$state_nm', '$gstnum', '0', '$fromdate', '$todate', '$paid_amnt', '1')");
          $updates = mysqli_query($con, "UPDATE fin_payment_entry SET preqnum='$rqstno' WHERE id='$pentry_last_id'");
      }else if ($trnscto == "withdraw") { // If Transaction Type is 'Withdraw'
          $wdrawer_nm = mysqli_real_escape_string($con, $_POST['wdrawer_nm']);
          $ownrwdqr = mysqli_query($con, "INSERT INTO `fin_payment_entry_owner_withdraw` (`payent_id`, `pay_rqst_id`, `wdrawer_nm`, `withdrw_req_amt`, `paid_wd_amt`, `status`) VALUES ('$pentry_last_id', '0', '$wdrawer_nm', '0', '$paid_amnt', '1')");
          $updates = mysqli_query($con, "UPDATE fin_payment_entry SET preqnum='$rqstno' WHERE id='$pentry_last_id'");
      }else if ($trnscto == "collection") { // If Transaction Type is 'Collection'
          $debtor_typ = mysqli_real_escape_string($con, $_POST['debtor_typ']);
          $clientnm = mysqli_real_escape_string($con, $_POST['clientnm']);
          $ownrwdqr = mysqli_query($con, "INSERT INTO `fin_payment_entry_collection` (`payent_id`, `pay_rqst_id`, `debtor_typ`, `clientnm`, `col_req_amt`, `paid_col_amt`, `status`) VALUES ('$pentry_last_id', '0', '$debtor_typ', '$clientnm', '0', '$paid_amnt', '1')");
          $updates = mysqli_query($con, "UPDATE fin_payment_entry SET preqnum='$rqstno' WHERE id='$pentry_last_id'");
      }else if ($trnscto == "rent") {
        $orgnstn = mysqli_real_escape_string($con, $_POST['org_id']);
        $rent_yr = mysqli_real_escape_string($con, $_POST['year']);
        $preqnum = mysqli_real_escape_string($con, $_POST['preqnum']);//request number
        $rnt_month = mysqli_real_escape_string($con, $_POST['month']);
        $rent_typ = mysqli_real_escape_string($con, $_POST['type']);
        $purpose = mysqli_real_escape_string($con, $_POST['purpose']);
        $prjct = mysqli_real_escape_string($con, $_POST['p_id']);
        $sub_prj = mysqli_real_escape_string($con, $_POST['sp_id']);
        // Details data to payment entry table
        $rentpaymententry = mysqli_query($con, "INSERT INTO `fin_payment_entry_rent` (`payent_id`, `pay_rqst_id`, `orgnstn`, `rent_yr`, `rnt_month`, `rent_typ`, `purpose`, `rnt_code`, `rnt_dt`, `client`, `prjct`, `sub_prj`, `rent_req_amt`, `paid_rent_amt`, `status`) VALUES ('$pentry_last_id', '0', '$orgnstn', '$rent_yr', '$rnt_month', '$rent_typ', '$purpose', '$rnt_code', '$rnt_dt', '', '$prjct', '$sub_prj', '0', '$paid_amnt', '1')");
        if($rentpaymententry){
          // rent code details inserting code
          $rentpaymentid= mysqli_insert_id($con);
          $count = count($_POST['rnt_code']);
          for($i = 0; $i < $count; $i++) {
            $rnt_code = mysqli_real_escape_string($con, $_POST['rnt_code'][$i]);
            $rnt_pymnt_dt = mysqli_real_escape_string($con, $_POST['rnt_pymnt_dt'][$i]);
            $client = mysqli_real_escape_string($con, $_POST['client'][$i]);
            $rate = mysqli_real_escape_string($con, $_POST['rate'][$i]);
            $rentdetailsentry = mysqli_query($con, "INSERT INTO `fin_payment_entry_rentdetails` (`rent_id`, `rent_code`, `owner_name`, `rent_amount`, `payment_assign_date`) VALUES ('$rentpaymentid','$rnt_code','$client', '$rate', '$rnt_pymnt_dt')");
            if($rentdetailsentry){
              $currentdate = date('d-m-y');
              /*$payrequestdetails = mysqli_query($con, "SELECT * FROM `fin_payment_request_rent` WHERE org_id = '$orgnstn' AND year ='$rent_yr' AND month ='$rnt_month' AND type ='$rent_typ' AND purpose ='$purpose' AND payment_status = '0'");
              $getreq = mysqli_fetch_object($payrequestdetails);
              $payreq_id = $getreq->payreq_id;
              $rentdeatils = mysqli_query($con, "SELECT * FROM `fin_payment_request_rent_details` WHERE payreq_id = '$payreq_id'");
              $getrent = mysqli_fetch_object($rentdeatils);*/
              //$rnt_code = $getrent->rnt_code;
              // Update emi paid status
              $updates=mysqli_query($con,"UPDATE rent_emi_details SET paid_status = '1',payment_date ='$currentdate' WHERE rent_code = '$rnt_code' AND year ='$rent_yr' AND month ='$rnt_month' AND rent_type ='$rent_typ' AND purpose ='$purpose'"); //For payment status
              /*if($updates){
                $updat=mysqli_query($con,"UPDATE fin_payment_request_rent SET payment_status = '1' WHERE org_id = '$orgnstn' AND year ='$rent_yr' AND month ='$rnt_month' AND type ='$rent_typ' AND purpose ='$purpose'");
              }*/
            }
          } 
        }
        $updates = mysqli_query($con, "UPDATE fin_payment_entry SET preqnum='$rqstno' WHERE id='$pentry_last_id'");
      }else if ($trnscto == "dd") { 
        $ddno = mysqli_real_escape_string($con, $_POST['ddno']);
        $ddpurpose = mysqli_real_escape_string($con, $_POST['ddpurpose']);
        $ddexprsn = mysqli_real_escape_string($con, $_POST['ddexprsn']);
        $ddbenificiary = mysqli_real_escape_string($con, $_POST['ddbenificiary']);
        $ddmessage = mysqli_real_escape_string($con, $_POST['ddmessage']);
        $empsqdd = mysqli_query($con, "INSERT INTO `fin_payment_entry_dd` (`payent_id`, `pay_rqst_id`, `req_no`, `req_by`, `empcode`, `ddno`, `purpose`, `exprsn`, `benificiary`, `dd_message`, `dd_rqst_amt`, `paid_amnt`, `status`) VALUES ('$pentry_last_id', '0', '', '', '', '$ddno', '$ddpurpose', '$ddexprsn', '$ddbenificiary', '$ddmessage', '0', '$paid_amnt', '1')");
        $updates = mysqli_query($con, "UPDATE fin_payment_entry SET preqnum='$rqstno' WHERE id='$pentry_last_id'");
      }else if ($trnscto == "fd") { 
        $fdno = mysqli_real_escape_string($con, $_POST['fdno']);
        $fdpurpose = mysqli_real_escape_string($con, $_POST['fdpurpose']);
        $fdmessage = mysqli_real_escape_string($con, $_POST['fdmessage']);
        $empsqfd = mysqli_query($con, "INSERT INTO `fin_payment_entry_fd` (`payent_id`, `pay_rqst_id`, `req_no`, `req_by`, `empcode`, `fdno`, `fdpurpose`, `fd_message`, `fd_rqst_amt`, `paid_amnt`, `status`) VALUES ('$pentry_last_id', '0', '', '', '', '$fdno', '$fdpurpose', '$fdmessage', '0', '$paid_amnt', '1')");
        $updates = mysqli_query($con, "UPDATE fin_payment_entry SET preqnum='$rqstno' WHERE id='$pentry_last_id'");
      }else if ($trnscto == "cheque") {
        $chqno = mysqli_real_escape_string($con, $_POST['chqno']);
         $chqpurpose = mysqli_real_escape_string($con, $_POST['chqpurpose']);
         $chqclient = mysqli_real_escape_string($con, $_POST['chqclient']);
         $chqmessage = mysqli_real_escape_string($con, $_POST['chqmessage']);
         $empsqchq = mysqli_query($con, "INSERT INTO `fin_payment_entry_chq` (`payent_id`, `pay_rqst_id`, `req_no`, `req_by`, `empcode`, `chqno`, `purpose`, `chqclient`, `chqmessage`, `chq_rqst_amt`, `paid_amnt`, `status`) VALUES ('$pentry_last_id', '0', '', '', '', '$chqno', '$chqpurpose', '$chqclient', '$chqmessage', '0', '$paid_amnt', '1')");
         $updates = mysqli_query($con, "UPDATE fin_payment_entry SET preqnum='$rqstno' WHERE id='$pentry_last_id'");
      }else if ($trnscto == "salary_advance") { // If Transaction Type is 'Salary Advance'
         $statement_id = mysqli_real_escape_string($con, $_POST['stmnt_prvw']);
         $bankacc_id = mysqli_real_escape_string($con, $_POST['bankacc_id']);
         $trnsc_type = mysqli_real_escape_string($con, $_POST['trnsc_type']);
         $orgnsn_name = mysqli_real_escape_string($con, $_POST['pay_orgnstn']);
         $trnscto = mysqli_real_escape_string($con, $_POST['trnscto']);
         $payee_nm = mysqli_real_escape_string($con, $_POST['payee_nm']);
         $paid_amnt = mysqli_real_escape_string($con, $_POST['paidamt']);
         $benif_acc = mysqli_real_escape_string($con, $_POST['benif_acc']);
         $sa_remarks = mysqli_real_escape_string($con, $_POST['sa_remarks']);
         $esa_id = mysqli_real_escape_string($con, $_POST['esa_id']);
         $sadqr = mysqli_query($con, "SELECT `early_sal_req_id` FROM `hr_earlysalary_emi_details` WHERE `esadv_id`='$esa_id'");
         $sadtls = mysqli_fetch_object($sadqr);
         $early_sal_req_id = $sadtls->early_sal_req_id;
         $updates=mysqli_query($con,"UPDATE fin_payment_entry SET preqnum='$early_sal_req_id' WHERE id = '$pentry_last_id'");
         $empsqsa = mysqli_query($con, "INSERT INTO `fin_payment_entry_sal_adv` (`payent_id`, `early_sal_req_id`, `fullname_id`, `purpose`, `message`, `esadv_id`, `esalapproved_amount`, `amount_paid`, `status`) VALUES ('$pentry_last_id', '', '$benif_acc', '', '$sa_remarks', '$esa_id', '', '$paid_amnt', '1')");
         $updates = mysqli_query($con, "UPDATE fin_payment_entry SET preqnum='$rqstno' WHERE id='$pentry_last_id'");
      }else if ($trnscto == "loan_advance") {
        $benif_acc = mysqli_real_escape_string($con, $_POST['benif_acc']);
        $la_remarks = mysqli_real_escape_string($con, $_POST['la_remarks']);
        $loan_id = mysqli_real_escape_string($con, $_POST['loan_id']);
        $loanadqr = mysqli_query($con, "SELECT `req_id` FROM `hr_advanceloan_request` WHERE `loan_id`='$loan_id'");
        $ladtls = mysqli_fetch_object($loanadqr);
        $req_id = $ladtls->req_id;
        $loanapvamt = mysqli_query($con, "SELECT `approved_amount` FROM `hr_advanceloan_cheque_details` WHERE `req_id`='$req_id'");
        $laapmdtls = mysqli_fetch_object($loanapvamt);
        $approved_amount = $laapmdtls->approved_amount;
        $updates=mysqli_query($con,"UPDATE fin_payment_entry SET preqnum='$req_id' WHERE id = '$pentry_last_id'");
        $empsqla = mysqli_query($con, "INSERT INTO `fin_payment_entry_loan_adv` (`payent_id`, `req_id`, `fullname_id`, `purpose`, `message`, `l_amount`, `loan_id`, `status`) VALUES ('$pentry_last_id', '$req_id', '$benif_acc', '', '$la_remarks', '$paid_amnt', '$loan_id', '1')");
        $updates = mysqli_query($con, "UPDATE fin_payment_entry SET preqnum='$rqstno' WHERE id='$pentry_last_id'");
      }else if ($trnscto == "asset_finance") {
        $benif_acc = mysqli_real_escape_string($con, $_POST['benif_acc']);
        $af_remarks = mysqli_real_escape_string($con, $_POST['af_remarks']);
        $af_id = mysqli_real_escape_string($con, $_POST['af_id']);
        $loanadqr = mysqli_query($con, "SELECT `af_req_id` FROM `hr_assetfinance_request` WHERE `astfinl_id`='$af_id'");
        $ladtls = mysqli_fetch_object($loanadqr);
        $af_req_id = $ladtls->af_req_id;
        $empsqaf = mysqli_query($con, "INSERT INTO `fin_payment_entry_asset_fin` (`payent_id`, `af_req_id`, `name_id`, `afl_amount`, `purpose`, `message`, `astfinl_id`, `status`) VALUES ('$pentry_last_id', '', '$benif_acc', '$paid_amnt', '', '$af_remarks', '$af_id', '1')");
        $updates=mysqli_query($con,"UPDATE fin_payment_entry SET preqnum='$af_req_id' WHERE id = '$pentry_last_id'");
      }else if ($trnscto == "lc_processing") { // If Transaction Type is 'LC Processing'
        $lcnumid = mysqli_real_escape_string($con, $_POST['lcnumid']);
        $client = mysqli_real_escape_string($con, $_POST['client']);
        $amount = mysqli_real_escape_string($con, $_POST['amount']);
        $transc_dt = mysqli_real_escape_string($con, $_POST['transc_dt']);
        $total_amt = mysqli_real_escape_string($con, $_POST['total_amt']);
        $empsqlcp = mysqli_query($con, "INSERT INTO `fin_payment_entry_lc` (`payent_id`, `lc_id`, `client_id`, `transc_amt`, `transc_dt`, `total_amt`) VALUES ('$pentry_last_id', '$lcnumid', '$client', '$amount', '$transc_dt', '$total_amt')");
        $last_id = mysqli_insert_id($con);
        $crgnumber = count($_POST['other_crg']);
        for($i=0; $i<$crgnumber; $i++)  
        {  
          $other_crg = $_POST['other_crg'][$i];
          $other_amt = $_POST['other_amt'][$i];
          $oth_entry = mysqli_query($con,"INSERT INTO `fin_payment_entry_lc_oth_charg`(`lcp_id`,`other_crg` ,`other_amt`) VALUES ('$last_id', '$other_crg','$other_amt')");
        } 
        $invnumber = count($_POST['chkinv']);
        for($i=0; $i<$invnumber; $i++)  
        {  
          $chkinv = $_POST['chkinv'][$i];
          $prexpld = explode("/", $chkinv);
          $inv_no = $prexpld[0];

          $inv_entry = mysqli_query($con,"INSERT INTO `fin_payment_entry_lc_inv_charg`(`lcp_id`,`inv_no`) VALUES ('$last_id', '$inv_no')");
        } 
        $updates=mysqli_query($con,"UPDATE fin_payment_entry SET preqnum='$af_req_id' WHERE id = '$pentry_last_id'");
      }else if ($trnscto == "salary_processing") { // If Transaction Type is 'Collection'
          $benif_acc = mysqli_real_escape_string($con, $_POST['benif_acc']);
          $location = mysqli_real_escape_string($con, $_POST['location']);
          $month = mysqli_real_escape_string($con, $_POST['month']);
          $year = mysqli_real_escape_string($con, $_POST['year']);
          $req_id = mysqli_real_escape_string($con, $_POST['req_id']);
          $orgname = mysqli_real_escape_string($con, $_POST['orgname']);
          $sp_remarks = mysqli_real_escape_string($con, $_POST['sp_remarks']);
          $monthyr = $year.'-'.$month;
          echo "INSERT INTO `fin_payment_entry_sal_pro` (`payent_id`, `sp_req_id`, `benif_acc`, `orgname`, `location`, `month`, `sp_amount`,`sp_remarks`, `status`) VALUES ('$pentry_last_id', '$req_id', '$benif_acc', '$orgname', '$location', '$monthyr','$paid_amnt', '$sp_remarks', '1')";
          $empsqaf = mysqli_query($con, "INSERT INTO `fin_payment_entry_sal_pro` (`payent_id`, `sp_req_id`, `benif_acc`, `orgname`, `location`, `month`, `sp_amount`,`sp_remarks`, `status`) VALUES ('$pentry_last_id', '$req_id', '$benif_acc', '$orgname', '$location', '$monthyr','$paid_amnt', '$sp_remarks', '1')");
          $updates = mysqli_query($con, "UPDATE fin_payment_entry SET preqnum='$rqstno' WHERE id='$pentry_last_id'");
      }else if ($trnscto == "loan_assignment") {
        $typeid = mysqli_real_escape_string($con, $_POST['typeid']);
        $loanid = mysqli_real_escape_string($con, $_POST['refno']);
        $account_no =  mysqli_real_escape_string($con, $_POST['account_no']);
        $nbfc_name = mysqli_real_escape_string($con, $_POST['nbfcname']);
        if ($typeid=="EMI") {
          $other_crg_emi = mysqli_real_escape_string($con, $_POST['other_crg_emi']);
          $other_amt_emi = mysqli_real_escape_string($con, $_POST['other_amt_emi']);
          $total_amt = mysqli_real_escape_string($con, $_POST['total_amt']);
          $chkeminumb = count($_POST['chkemi']);
          for($i=0; $i<$chkeminumb; $i++)  
          {  
            $chkemi = $_POST['chkemi'][$i];
            $prexpld = explode("/", $chkemi);
            $loan_id = $prexpld[0];
            $emi_dt = $prexpld[1];
            $emi_amt = $prexpld[2];
            $emi_interest = $prexpld[3];
            $emi_principal = $prexpld[4];
            $emi_total = $prexpld[5];
            $emi_outstanding = $prexpld[6];
            $emi_entry = mysqli_query($con,"INSERT INTO `fin_payment_entry_term_loan`(`payent_id`,`acc_no`,`loan_id`,`emi_dt`,`emi_amt`,`emi_interest`,`emi_principal`,`emi_total`,`emi_outstanding`) VALUES ('$pentry_last_id','$account_no','$loan_id','$emi_dt', '$emi_amt', '$emi_interest', '$emi_principal', '$emi_total', '$emi_outstanding')");
         } 
          $oth_entry = mysqli_query($con,"INSERT INTO `fin_payment_entry_term_loan_oth`(`payent_id`,`acc_no`,`nbfc_name`,`loan_id`,`pay_type`,`tot_amt`,`oth_char`,`othr_amt`) VALUES ('$pentry_last_id','$account_no','$nbfc_name','$loanid','EMI','$total_amt','$other_crg_emi','$other_amt_emi')");
        }elseif ($typeid=="Cash") {
          $cashamt = mysqli_real_escape_string($con, $_POST['cashamt']);
          $other_crg_cash = mysqli_real_escape_string($con, $_POST['other_crg_cash']);
          $other_amt_cash = mysqli_real_escape_string($con, $_POST['other_amt_cash']);
          $total_amt_cash = mysqli_real_escape_string($con, $_POST['total_amt_cash']);
          $oth_entry = mysqli_query($con,"INSERT INTO `fin_payment_entry_term_loan_oth`(`payent_id`,`acc_no`,`nbfc_name`,`loan_id`,`pay_type`,`tot_amt`,`cash_amt`,`oth_char`,`othr_amt`) VALUES ('$pentry_last_id','$account_no','$nbfc_name','$loanid','Cash','$total_amt_cash','$cashamt','$other_crg_cash','$other_amt_cash')");
        }elseif ($typeid=="Others") {
          $other_crg = mysqli_real_escape_string($con, $_POST['other_crg']);
          $other_amt = mysqli_real_escape_string($con, $_POST['other_amt']);
          $total_amt_oth = mysqli_real_escape_string($con, $_POST['total_amt_oth']);
          $oth_entry = mysqli_query($con,"INSERT INTO `fin_payment_entry_term_loan_oth`(`payent_id`,`acc_no`,`nbfc_name`,`loan_id`,`pay_type`,`tot_amt`,`oth_char`,`othr_amt`) VALUES ('$pentry_last_id','$account_no','$nbfc_name','$loanid','Others','$total_amt_oth','$other_crg','$other_amt')");
        }
        $updates = mysqli_query($con, "UPDATE fin_payment_entry SET preqnum='$rqstno' WHERE id='$pentry_last_id'");
      }else if ($trnscto == "bank_transfer") { // If Transaction Type is 'bank transfer'
          $org_nm = mysqli_real_escape_string($con, $_POST['org_nm']);
          $bnkaccnt = mysqli_real_escape_string($con, $_POST['bnkaccnt']);
          $bnktrn_remarks = mysqli_real_escape_string($con, $_POST['bnktrn_remarks']);
          $empid = mysqli_real_escape_string($con, $_POST['empid']);
          $othersqr = mysqli_query($con, "INSERT INTO `fin_payment_entry_bank_trans` (`payent_id`, `org_nm`, `bnkaccnt`,`paid_amnt`, `bnktrn_remarks`, `created_by`) VALUES ('$pentry_last_id', '$org_nm', '$bnkaccnt', '$paid_amnt', '$bnktrn_remarks', '$empid')");
          $updates = mysqli_query($con, "UPDATE fin_payment_entry SET preqnum='$rqstno' WHERE id='$pentry_last_id'");
      }else if ($trnscto == "others") { // If Transaction Type is 'Others'
          $othrhd = mysqli_real_escape_string($con, $_POST['othrhd']);
          $particlr = mysqli_real_escape_string($con, $_POST['particlr']);
          $othersqr = mysqli_query($con, "INSERT INTO `fin_payment_entry_others` (`payent_id`, `pay_rqst_id`, `othrhd`, `particlr`, `othr_req_amt`, `paid_othr_amt`, `status`) VALUES ('$pentry_last_id', '0', '$othrhd', '$particlr', '0', '$paid_amnt', '1')");
          $updates = mysqli_query($con, "UPDATE fin_payment_entry SET preqnum='$rqstno' WHERE id='$pentry_last_id'");
      }else if ($trnscto == "Operator")
      {
        $optrcode = $_POST['optrcode'];
        $arrData = explode("#",$optrcode);
        $slid = $arrData[0];
        //$optrcode = mysqli_real_escape_string($con, $_POST['optrcode'.$slid]);
        $actual_optrcode = $arrData[1];
        $txtoptrname = mysqli_real_escape_string($con, $_POST['txtoptrname'.$slid]);
        $txtbankno = mysqli_real_escape_string($con, $_POST['txtbankno'.$slid]);
        $txtbankifsc = mysqli_real_escape_string($con, $_POST['txtbankifsc'.$slid]);
        $totrqstmonth = mysqli_real_escape_string($con, $_POST['totrqstmonth'.$slid]);
        $ratepermonth = mysqli_real_escape_string($con, $_POST['ratepermonth'.$slid]);
        $monthpaid = mysqli_real_escape_string($con, $_POST['monthpaid'.$slid]);
        $amntpaid = mysqli_real_escape_string($con, $_POST['nettotamount']);
        $sqlqry = mysqli_query($con, "SELECT `rqstno` FROM `prj_optr_payrqst` WHERE `operatorid`='$actual_optrcode' AND `optr_acntno`='$txtbankno' ORDER BY id DESC");
        $getrqstno = mysqli_fetch_object($sqlqry);
        $rqstno = $getrqstno->rqstno;
        $updates = mysqli_query($con, "UPDATE fin_payment_entry SET preqnum='$rqstno' WHERE id='$pentry_last_id'");
        if($updates){
          echo "<script>alert('Data saved successfully')</script>";
        }
        else{
          echo "<script>alert('Data not saved successfully')</script>";
        }
        $updates = mysqli_query($con, "UPDATE fin_payment_entry SET preqnum='$rqstno' WHERE id='$pentry_last_id'");
      }
      if($updates){
        echo 1;
      }
      else{
        echo 2;
      }
    } 
    
}
?>