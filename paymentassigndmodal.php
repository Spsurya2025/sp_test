
<?php 
  require_once('../auth.php');
  require_once("../config.php");
  if(isset($_POST['payrequestid']) && $_POST['payrequestid'] !='' && isset($_POST['bankimportid']) && $_POST['bankimportid'] !=''){
    $payrequestid = $_POST['payrequestid'];
    $bankimportid = $_POST['bankimportid'];
    if(isset($_POST['bankimportid']) && isset($_POST['payrequestid'])){
      $bimpid = $_POST['bankimportid'];
      $peid = $_POST['payrequestid'];
      $fetch = mysqli_query($con,"SELECT * FROM `fin_payment_entry` WHERE `id`='$peid'");
      $row = mysqli_fetch_object($fetch);
      if($row->pay_approval_stat=='2'){
        header("location: vwpaydetails.php?bimpid=$bimpid&peid=$peid");
        exit();
      }
    }
  }
?>
  <div class="row" style="margin: 10px;">
  <!-- Body Starts Here -->
    <form name="form" method="post" class="forms-sample" style="margin-left: 5px;">
      <legend><h5 style="color: #008787;">Uploaded Payment Details</h5></legend>
      <?php
        if (isset($bankimportid)) {
          $bimpid = $bankimportid;
          $dtlsqr = mysqli_query($con, "SELECT x.*,y.* FROM `fin_banking_imports` x, `fin_statement_preview` y WHERE x.`preview_id`=y.`id` AND x.`id`='$bimpid' AND y.`status`='1'");
          $fthimps = mysqli_fetch_object($dtlsqr);
        }
      ?>
      <fieldset>
        <div class="row">
          <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6" style="display: none;">
            <div class="form-group">
              <label for="stmnt_prvw">Statement Preview ID</label>
              <input type="text" class="form-control" name="stmnt_prvw" id="stmnt_prvw" value="<?php if (isset($bankimportid)) { echo $fthimps->preview_id; } ?>" readonly>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
            <div class="form-group">
              <label for="preqnum">Payment Request No.</label>
              <input type="text" class="form-control" name="preqnum" id="preqnum" value="<?php if (isset($bankimportid)) { echo $fthimps->pr_num; } ?>" readonly>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
            <div class="form-group">
              <label for="pay_orgnstn">Payment Under Organisation</label>
              <select class="form-control" name="pay_orgnstn" id="pay_orgnstn" readonly>
                <?php
                if (isset($bankimportid)) {
                  $orgnid = $fthimps->orgnstn_id;
                  $orgqr = mysqli_query($con, "SELECT * FROM `prj_organisation` WHERE `id`='$orgnid'");
                  $fthorg = mysqli_fetch_object($orgqr);
                  echo "<option value='".$fthorg->id."'>".$fthorg->organisation."</option>";
                }?>
              </select>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
            <div class="form-group">
              <label for="pay_bnkacc">Payment Under Bank Account</label>
              <select class="form-control" name="pay_bnkacc" id="pay_bnkacc" readonly>
                <?php
                  if (isset($bankimportid)) {
                    $bnkaccid = $fthimps->bnkacc_id;
                    $bnkqr = mysqli_query($con, "SELECT * FROM `fin_bankaccount` WHERE `id`='$bnkaccid'");
                    $fthbacc = mysqli_fetch_object($bnkqr);
                    echo "<option value='".$fthbacc->id."'>".$fthbacc->accnm."</option>";
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
            <div class="form-group">
              <label for="trnsc_type">Payment Transaction Type</label>
              <input type="text" class="form-control" name="trnsc_type" id="trnsc_type" value="<?php if (isset($bankimportid)) { echo $fthimps->transac_type; } ?>" readonly>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
            <div class="form-group">
              <label for="trnscto">Transaction To/Type</label>
              <select class="form-control" name="trnscto" id="trnscto" readonly>
              <?php
              if (isset($bankimportid) && isset($_GET['peid'])) {
                echo "<option value='".$row->trnscto."'>".$row->trnscto."</option>";
              }
              else { ?>
                <option value="">--- Select Transaction To/Type ---</option>
                <option value="">--- Select Transaction To/Type ---</option>
                <option value="supplier">Supplier</option>
                <option value="vendor">Vendor</option>
                <option value="transporter">Transporter</option>
                <option value="gst">GST</option>
                <option value="withdraw">Withdraw</option>
                <option value="collection">Collection</option>
                <option value="expense">Expense</option>
                <option value="rent">Rent</option>
                <option value="dd">DD</option>
                <option value="fd">FD</option>
                <option value="cheque">Cheque</option>
                <option value="salary_advance">Salary Advance</option>
                <option value="loan_advance">Employee Loan Advance</option>
                <option value="loan_assignment">Loan Assignment</option>
                <option value="asset_finance">Asset Finance</option>
                <option value="lc_processing">LC Processing</option>
                <option value="salary_processing">Salary Processing</option>
                <option value="bank_transfer">Bank Transfer</option>
                <option value="operator">Operator Payment</option>
                <option value="others">Others</option>
              <?php } ?>
              </select>
            </div>
            <div class="col-md-12" id="errortrnscto" style="display:none;" align="center">
               <strong style="color:red;font-size: 10px;" id="trnsctomsg"></strong>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
            <div class="form-group">
              <label for="payee_nm">Payee Name</label>
              <input type="text" class="form-control" name="payee_nm" id="payee_nm" value="<?php if (isset($bankimportid)) { echo $fthimps->payee_name; } ?>" readonly>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
            <div class="form-group">
              <label for="paidamt">Paid/Approved Amount</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-rupee"></i></span>
                <input type="text" class="form-control" name="paidamt" id="paidamt" value="<?php if (isset($bankimportid)) { echo $fthimps->transac_amt; } ?>" readonly>
              </div>
            </div>
          </div>
        </div>

        <div id="showPForm"></div>
      
        <div class="row">
          <div class="col-lg-12"> 
              <div class="form-group" style="margin-left: 15px;margin-right: 15px;">
                  <?php if($row->pay_approval_stat=='0'){ ?>
                      <input type="submit" name="cnfrm" id="cnfrm" value="APPROVE & PASS" class="btn btn-success mr-2" style="margin-top: 15px; margin-bottom: 30px; float: right;">
                      <input type="hidden" name="basefname" value="<?=$basefname?>">
                      <input type="submit" name="editfrm" id="editfrm" value="Edit & Update" class="btn btn-info mr-2" style="margin-top: 15px; margin-bottom: 30px; float: right;">
                  <?php }else if($row->pay_approval_stat=='1'){ ?>
                      <div class="alert alert-warning" align="center">
                          <strong>Initially Approved</strong>
                      </div>
                  <?php }else if($row->pay_approval_stat=='3'){ ?>
                      <div class="alert alert-danger" align="center">
                          <strong>Rejected</strong>
                      </div>
                  <?php } ?>
              </div>
          </div>
        </div>
      </fieldset>
    </form>
  <!-- //Body Ends Here -->     
  </div>
