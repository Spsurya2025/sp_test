
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />		
<!-- // Used For Auto Typing Search-->
<script type="text/javascript">
				$(document).ready(function () {
					$('#vndrnm,#benif_acc,#org_nm,#chqno,#debtor_typ,#ddno,#ddexprsn,#loan_benif_acc,#expns_for,#prjct,#fdno,#organisation,#state_nm,#lcnumid,#account_no,#othrhd,#org_id,#year,#suplrnm,#trnsprtrnm,#prjctnm,#wdrawer_nm').selectize({
						sortField: 'text'
						});
				});
</script>
<?php include("../../config.php");?>
<?php if(isset($_POST['trnscto']) && $_POST['trnscto'] =='vendor'){?>
    <div class="row" style="margin-top: 20px;">
        <center><h4 style="text-decoration: underline; font-weight: bold; color: #37909e;">Vendor Payment Details</h4></center>
      <div class="col-lg-12">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
          <div class="form-group">
            <label for="vndrnm">Vendor Name</label><strong style="color:red;font-size: 10px;" id="vndrnmmsg"></strong>
            <select class="form-control" name="vndrnm" id="vndrnm">
              <option value="">--- Select Vendor Name ---</option>
              <?php
                $vndrqr = mysqli_query($con, "SELECT * FROM `prj_vendor` WHERE `status`='1' ORDER BY `vendor_name` asc");
                while ($fthvndr = mysqli_fetch_object($vndrqr)) {
                  echo "<option value='".$fthvndr->id."'>".$fthvndr->vendor_name."</option>";
                }
              ?>
            </select>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
          <div class="form-group">
            <label for="prjct_name">Project Name</label><strong style="color:red;font-size: 10px;" id="prjct_namemsg"></strong>
            <select class="form-control" name="prjct_name" id="prjct_name">
              <option value="">--- Select Project ---</option>
            </select>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
          <div class="form-group">
            <label for="jobodr_num">Job Order Number</label><strong style="color:red;font-size: 10px;" id="jobodr_nummsg"></strong>
            <select class="form-control" name="jobodr_num" id="jobodr_num">
              <option value="">--- Select Job Order ---</option>
            </select>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
          <div class="form-group">
            <label for="jobodr_val">Job Order Value</label>
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-rupee"></i></span>
              <input type="text" class="form-control" name="jobodr_val" id="jobodr_val" placeholder="Job Order Amount" readonly>
            </div>
          </div>
        </div>
        <div id="showSubPrj">
          
        </div>
      </div>
    </div>
<?php }elseif(isset($_POST['trnscto']) && $_POST['trnscto'] =='supplier'){?>
  <div class="row" style="margin-top: 20px;">
    <center><h4 style="text-decoration: underline; font-weight: bold; color: #37909e;">Supplier Payment Details</h4></center>
    <div class="col-lg-12">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label for="suplrnm">Supplier Name</label> <strong style="color:red;font-size: 10px;" id="suplrnmmsg"></strong>
          <select class="form-control" name="suplrnm" id="suplrnm">
            <option value="">--- Supplier Name ---</option>
            <?php
              $splrqr = mysqli_query($con, "SELECT * FROM `prj_supplier` WHERE `status`='1' ORDER BY `supplier_name` ASC");
              while ($fthsplr = mysqli_fetch_object($splrqr)) {
                echo "<option value='".$fthsplr->id."'>".$fthsplr->supplier_name."</option>";
              }
            ?>
          </select>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label for="prj_name">Project Name</label> <strong style="color:red;font-size: 10px;" id="prj_namemsg"></strong>
          <select class="form-control" name="prj_name" id="prj_name">
            <option value="">--- Select Project ---</option>
          </select>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label for="ponum">PO Number</label> <strong style="color:red;font-size: 10px;" id="ponummsg"></strong>
          <select class="form-control" name="ponum" id="ponum">
            <option value="">--- Purchase Order ---</option>
          </select>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label for="podate">PO Date</label> <strong style="color:red;font-size: 10px;" id="podatemsg"></strong>
          <input type="text" name="podate" id="podate" class="form-control" placeholder="yyyy-mm-dd" readonly>
        </div>
      </div>
    </div>
    <div class="col-lg-12">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label for="poamnt">PO Amount</label> <strong style="color:red;font-size: 10px;" id="poamntmsg"></strong>
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-rupee"></i></span>
            <input type="text" class="form-control" name="poamnt" id="poamnt" placeholder="9999.99" readonly>
          </div>
        </div>
      </div>
    <?php if ($_POST['trnsctn_typ'] != "Credit") { ?>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label for="spreq_typ">Request Type</label> <strong style="color:red;font-size: 10px;" id="spreq_typmsg"></strong>
          <select class="form-control" name="spreq_typ" id="spreq_typ">
            <option value="">--- Select Request Type ---</option>
            <option value="PR">PR Request</option>
            <option value="Transportation">Transportation Request</option>
          </select>
        </div>
      </div>
    <?php } ?>
      <div class="col-lg-12" id="prDtls" style="margin-top: 20px; display: none;">
        <div class="col-lg-12">
          <legend><h6><strong style="color: #2bc59b;">PR Details</strong></h6></legend> <strong style="color:red;font-size: 10px;" id="pr_numbrmsg"></strong>
          <div class="table-responsive">
            <table class="table table-bordered table-responsive">
              <thead>
                <tr>
                  <th>PR No. <strong style="color:red;font-size: 10px;" id="pr_numbrmsg"></strong></th>
                  <th>Sub Project</th>
                  <th>BMS</th>
                  <th>PR Amount</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <select class="form-control" name="pr_numbr" id="pr_numbr">
                      <option>--- Select PR No ---</option>
                    </select>
                  </td>
                  <td>
                    <input type="text" class="form-control" name="subprj_nm" id="subprj_nm" placeholder="Sub Project Name" readonly>
                  </td>
                  <td>
                    <input type="text" class="form-control" name="bms_name" id="bms_name" placeholder="BMS Name" readonly>
                  </td>
                  <td>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-rupee"></i></span>
                      <input type="text" name="pramnt" id="pramnt" class="form-control" placeholder="9999.99" readonly>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-lg-12" id="trnsDtls" style="margin-top: 20px; display: none;">
        <div class="col-lg-12">
          <legend><h6><strong style="color: #2bc59b;">Transportation Details</strong></h6></legend> 
          <div class="table-responsive">
            <table class="table table-bordered table-responsive">
              <thead>
                <tr>
                  <th>Transportation Reason</th><strong style="color:red;font-size: 10px;" id="trnsrsnmsg"></strong>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <select class="form-control" name="trnsrsn" id="trnsrsn">
                      <option>--- Select Transportation Reason ---</option>
                      <?php
                        $trnsqr = mysqli_query($con, "SELECT * FROM `fin_grouping_subtype` WHERE `status`='1'");
                        while ($fthtrns = mysqli_fetch_object($trnsqr)) {
                          echo "<option value='".$fthtrns->id."'>".$fthtrns->subtypenm."</option>";
                        }
                      ?>
                    </select>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php }elseif(isset($_POST['trnscto']) && $_POST['trnscto'] =='transporter'){?>
    <div class="row" style="margin-top: 20px;">
        <center><h4 style="text-decoration: underline; font-weight: bold; color: #37909e;">Transporter Payment Details</h4></center>
        <div class="col-lg-12">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <label for="trnsprtrnm">Transporter Name</label>
                <select class="form-control" name="trnsprtrnm" id="trnsprtrnm">
                  <?php
                    if (isset($_GET['prid'])) {
                      $trnsprtid = $trow->trnsprtrnm;
                      $gttnm = mysqli_query($con, "SELECT * FROM `prj_transport` WHERE `id`='$trnsprtid'");
                      $fthtnm = mysqli_fetch_object($gttnm);

                      echo "<option value='".$trow->trnsprtrnm."'>".$fthtnm->transport_name."</option>";
                    }
                  ?>
                  <option value="">--- Select Transporter Name ---</option>
                  <?php
                    $vndrqr = mysqli_query($con, "SELECT * FROM `prj_transport` WHERE `status`='1' ORDER BY `transport_name` ASC");
                    while ($fthvndr = mysqli_fetch_object($vndrqr)) {
                      echo "<option value='".$fthvndr->id."'>".$fthvndr->transport_name."</option>";
                    }
                  ?>
                </select>
              </div>
            </div>
            <!-- <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <label for="cr_lmt">Credit Limit</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-rupee"></i></span>
                  <input type="text" name="cr_lmt" id="cr_lmt" class="form-control" placeholder="9999.99" value="<?php // if (isset($_GET['prid'])) { echo $trow->cr_lmt; } ?>" readonly>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <label for="dt_cr_bal">Debit/Credit Balance</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-rupee"></i></span>
                  <input type="text" name="dt_cr_bal" id="dt_cr_bal" class="form-control" placeholder="9999.99" value="<?php // if (isset($_GET['prid'])) { echo $trow->dt_cr_bal; } ?>" readonly>
                </div>
              </div>
            </div> -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <label for="prjctnm">Project Name</label>
                <select class="form-control" name="prjctnm" id="prjctnm">
                  <option value="">--- Select Project ---</option>
                <?php
                  $prjqr = mysqli_query($con, "SELECT * FROM `prj_project` WHERE `status`='1'");
                  while ($prjnm = mysqli_fetch_object($prjqr)) {
                    echo "<option value='$prjnm->id'>".$prjnm->pname."</option>";
                  }
                ?>
                </select>
              </div>
            </div>
            <!-- </div>
            <div class="col-lg-12"> -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <label for="subprjnm">Sub Project Name</label>
                <select class="form-control" name="subprjnm" id="subprjnm">
                  <option value="">--- Select Sub Project ---</option>
                </select>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <label for="bmsnm">Billing Milestone</label>
                <select class="form-control" name="bmsnm" id="bmsnm">
                  <option value="">--- Select BMS ---</option>
                </select>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <label for="ponum">PO Number</label>
                <select class="form-control" name="ponum" id="trans_ponum">
                  <option value="">--- Select PO Number ---</option>
                </select>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <label for="place_from">Place From</label>
                <input type="text" name="place_from" id="place_from" class="form-control" placeholder="Source Place" autocomplete="off">
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <label for="place_to">Place To</label>
                <input type="text" name="place_to" id="place_to" class="form-control" placeholder="Destination Place" autocomplete="off">
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <label for="distance">Distance</label>
                <div class="input-group">
                  <input type="text" name="distance" id="distance" class="form-control" placeholder="99.99" autocomplete="off" onkeyup="calc()">
                  <span class="input-group-addon" style="font-weight: bold;">kms</span>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <label for="material_nm">material_nm</label>
                <input type="text" name="material_nm" id="material_nm" class="form-control" placeholder="material_nm Name" autocomplete="off">
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <label for="mtrl_weight">Material Weight</label>
                <div class="input-group">
                  <input type="text" name="mtrl_weight" id="mtrl_weight" class="form-control" placeholder="Weight in KG" autocomplete="off" onkeyup="calc()">
                  <span class="input-group-addon" style="font-weight: bold;">kgs</span>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <label for="service_typ">Service Type</label>
                <select class="form-control" name="service_typ" id="service_typ">
                  <option value="">--- Select Type of Service ---</option>
                  <option value="Full Truck">Full Truck</option>
                  <option value="Part Load">Part Load</option>
                  <option value="Sharing">Sharing</option>
                </select>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <label for="lry_model">Lorry Model</label>
                <input type="text" name="lry_model" id="lry_model" class="form-control" placeholder="Model Name" autocomplete="off">
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <label for="dala_typ">Dala Type</label>
                <input type="text" name="dala_typ" id="dala_typ" class="form-control" placeholder="Type of Dala" autocomplete="off">
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <label for="carrycap">Carrying Capacity</label>
                <div class="input-group">
                  <input type="text" name="carrycap" id="carrycap" class="form-control" autocomplete="off" placeholder="Carrying Capacity in KG">
                  <span class="input-group-addon" style="font-weight: bold;">kgs</span>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <label for="totalamnt">Total Amount</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-rupee"></i></span>
                  <input type="text" class="form-control" name="totalamnt" id="totalamnt" placeholder="9999.99" autocomplete="off" onkeyup="calc()">
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <label for="rateper_km">Rate Per KM</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-rupee"></i></span>
                  <input type="text" name="rateper_km" id="rateper_km" class="form-control" placeholder="Rate/km" readonly>
                  <span class="input-group-addon" style="font-weight: bold;">/km</span>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <label for="rateper_kg">Rate Per KG</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-rupee"></i></span>
                  <input type="text" name="rateper_kg" id="rateper_kg" class="form-control" placeholder="Rate/kg" readonly>
                  <span class="input-group-addon" style="font-weight: bold;">/kg</span>
                </div>
              </div>
            </div>
            <!-- <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <label for="adv_prcnt">Advance Percentage</label>
                <div class="input-group">
                  <input type="text" name="adv_prcnt" id="adv_prcnt" class="form-control" placeholder="99.99" autocomplete="off" onkeyup="calc()">
                  <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <label for="adv_amt">Advance totalamnt</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-rupee"></i></span>
                  <input type="text" class="form-control" name="adv_amt" id="adv_amt" placeholder="9999.99" readonly>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <label for="final_amnt">Final totalamnt</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-rupee"></i></span>
                  <input type="text" class="form-control" name="final_amnt" id="final_amnt" placeholder="9999.99" readonly>
                </div>
              </div>
            </div> -->
            <!-- <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <label for="trns_req_amt">Request totalamnt</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-rupee"></i></span>
                  <input type="text" class="form-control" name="trns_req_amt" id="trns_req_amt" placeholder="9999.99" autocomplete="off" readonly>
                </div>
              </div>
            </div> -->
        </div>
    </div>
<?php }elseif(isset($_POST['trnscto']) && $_POST['trnscto'] =='withdraw'){?>
  <div class="row" style="margin-top: 20px;">
    <center><h4 style="text-decoration: underline; font-weight: bold; color: #37909e;">Withdraw Payment Details</h4></center>
    <div class="col-lg-12">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label for="wdrawer_nm">Name</label><strong style="color:red;font-size: 10px;" id="wdrawer_nmmsg"></strong>
          <select class="form-control" name="wdrawer_nm" id="wdrawer_nm">
            <option value="">--- Select Name ---</option>
            <?php
              $empqr = mysqli_query($con, "SELECT * FROM `mstr_emp` WHERE `status`='1' ORDER BY `fullname` ASC");
              while ($fthemp = mysqli_fetch_object($empqr)) {
                echo "<option value='".$fthemp->id."'>".$fthemp->fullname."</option>";
              }
            ?>
          </select>
        </div>
      </div>
    </div>
  </div>
<?php }elseif(isset($_POST['trnscto']) && $_POST['trnscto'] =='collection'){?>
  <div class="row" style="margin-top: 20px;">
    <center><h4 style="text-decoration: underline; font-weight: bold; color: #37909e;">Collection Payment Details</h4></center>
    <div class="col-lg-12">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label for="debtor_typ">Debtor Type</label><strong style="color:red;font-size: 10px;" id="debtor_typmsg"></strong>
          <select class="form-control" name="debtor_typ" id="debtor_typ">
            <?php
              if (isset($_GET['prid'])) {
                $dtrid = $clctnrow->debtor_typ;
                $gtdtrnm = mysqli_query($con, "SELECT * FROM `fin_grouping_subtype` WHERE `id`='$dtrid'");
                $fthdtr = mysqli_fetch_object($gtdtrnm);
                echo "<option value='".$fthdtr->id."'>".$fthdtr->subtypenm."</option>";
              }
            ?>
            <option value="">--- Select Debtor Type ---</option>
            <?php
              $dbtrqr = mysqli_query($con, "SELECT * FROM `fin_grouping_subtype` WHERE `undergrp`='Type' AND `grptypnm`='5' AND `status`='1'");
              while ($fthdbtr = mysqli_fetch_object($dbtrqr)) {
                echo "<option value='".$fthdbtr->id."'>".$fthdbtr->subtypenm."</option>";
              }
            ?>
          </select>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label for="clientnm">Client Name</label><strong style="color:red;font-size: 10px;" id="clientnmmsg"></strong>
          <select class="form-control" name="clientnm" id="clientnm">
            <option value="">--- Select Client Name ---</option>
          </select>
        </div>
      </div>
    </div>
  </div>
<?php }elseif(isset($_POST['trnscto']) && $_POST['trnscto'] =='expense'){?>
  <div class="row" style="margin-top: 20px;">
    <center><h4 style="text-decoration: underline; font-weight: bold; color: #37909e;">Expense Payment Details</h4></center>
    <div class="col-lg-12">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label for="expns_for">Expense for</label><strong style="color:red;font-size: 10px;" id="expns_formsg"></strong>
          <select class="form-control" name="expns_for" id="expns_for">
            <option value="">--- Employee Name ---</option>
            <?php
              $empqr = mysqli_query($con, "SELECT * FROM `mstr_emp` WHERE `status`='1' ORDER BY `fullname` ASC");
              while ($fthemp = mysqli_fetch_object($empqr)) {
                echo "<option value='".$fthemp->id."'>".$fthemp->fullname."</option>";
              }
            ?>
          </select>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label for="exp_for_empcode">Employee Code</label>
          <input type="text" class="form-control" name="exp_for_empcode" id="exp_for_empcode" placeholder="Unique Employee Code" readonly>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label for="prjct">Project</label><strong style="color:red;font-size: 10px;" id="prjctmsg"></strong>
          <select class="form-control" name="prjct" id="prjct">
            <option value="">--- Project Name ---</option>
            <?php
              $prjqr = mysqli_query($con, "SELECT * FROM `prj_project` WHERE `status`='1' ORDER BY `pname` ASC");
              while ($fthprj = mysqli_fetch_object($prjqr)) {
                echo "<option value='".$fthprj->id."'>".$fthprj->pname."</option>";
              }
            ?>
          </select>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label for="sub_prjct">Sub-Project</label><strong style="color:red;font-size: 10px;" id="sub_prjctmsg"></strong>
          <select class="form-control" name="sub_prjct" id="sub_prjct">
            <option value="">--- Sub-Project Name ---</option>
          </select>
        </div>
      </div>
    </div>
    <div class="col-lg-12">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label for="bmsnm">Billing Milestone</label><strong style="color:red;font-size: 10px;" id="bmsnmmsg"></strong>
          <select class="form-control" name="bmsnm" id="bmsnm">
            <option value="">--- BMS Name ---</option>
          </select>
        </div>
      </div>
    </div>
  </div>
<?php }elseif(isset($_POST['trnscto']) && $_POST['trnscto'] =='gst'){?>
  <div class="row" style="margin-top: 20px;">
    <center><h4 style="text-decoration: underline; font-weight: bold; color: #37909e;">GST Payment Details</h4></center>
    <div class="col-lg-12">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label for="organisation">Organisation</label><strong style="color:red;font-size: 10px;" id="organisationmsg"></strong>
          <select class="form-control" name="organisation" id="organisation" onchange="getGST()">
            <option value="">--- Select Organisation ---</option>
            <?php
              $orgqr = mysqli_query($con, "SELECT * FROM `prj_organisation` WHERE `status`='1' ORDER BY `organisation` ASC");
              while ($fthorg = mysqli_fetch_object($orgqr)) {
                echo "<option value='".$fthorg->id."'>".$fthorg->organisation."</option>";
              }
            ?>
          </select>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label for="state_nm">State</label><strong style="color:red;font-size: 10px;" id="state_nmmsg"></strong>
          <select class="form-control" name="state_nm" id="state_nm" onchange="getGST()">
            <option value="">--- Select State ---</option>
            <?php
              $stateqr = mysqli_query($con, "SELECT * FROM `prj_state` WHERE `status`='1' ORDER BY `sname` ASC");
              while ($fthstate = mysqli_fetch_object($stateqr)) {
                echo "<option value='".$fthstate->id."'>".$fthstate->sname."</option>";
              }
            ?>
          </select>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label for="gstnum">GSTIN No</label><strong style="color:red;font-size: 10px;" id="gstnummsg"></strong>
          <input type="text" name="gstnum" id="gstnum" class="form-control" placeholder="GST Number" readonly>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label for="fromdate">From Date</label><strong style="color:red;font-size: 10px;" id="fromdatemsg"></strong>
          <div class='input-group date'>
            <input type="date" name="fromdate" id="fromdate" class="form-control" placeholder="yyyy-mm-dd" autocomplete="off">
            <span class="input-group-addon">
              <span class="glyphicon glyphicon-calendar"></span>
            </span>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label for="todate">To Date</label><strong style="color:red;font-size: 10px;" id="todatemsg"></strong>
          <div class='input-group date'>
            <input type="date" name="todate" id="todate" class="form-control" placeholder="yyyy-mm-dd" autocomplete="off">
            <span class="input-group-addon">
              <span class="glyphicon glyphicon-calendar"></span>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php }elseif(isset($_POST['trnscto']) && $_POST['trnscto'] =='rent'){?>
  <div class="row" style="margin-top: 20px;">
    <center><h4 style="text-decoration: underline; font-weight: bold; color: #37909e;">Rent Payment Details</h4></center>
    <div class="col-lg-12">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label for="org_id">Organisation</label><strong style="color:red;font-size: 10px;" id="org_idmsg"></strong>
          <select name="org_id" class="form-control rentdetails" id="org_id">
            <?php $orgn = mysqli_query($con,"SELECT * FROM `prj_organisation` WHERE `id` = '".$_POST['pay_orgnstn']."'");
                $roworg = mysqli_fetch_object($orgn);
                echo "<option value='".$roworg->id."'>".$roworg->organisation."</option>";
            ?>            
          </select>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <label for="year">Select Year</label><strong style="color:red;font-size: 10px;" id="yearmsg"></strong>
        <select name="year" class="form-control rentdetails" id="year">
          <?php 
            if(isset($_POST['prid'])) {
              echo "<option value='" . $srow->year ."'>" . $srow->year."</option>";
            }

            if(!isset($_POST['prid'])) {
          ?>
          <option value="">--Select--</option>

            <script type="text/javascript">
              for (i = new Date().getFullYear(); i > 2000; i--) {
                $('#year').append($('<option />').val(i).html(i));
              }
            </script>
          <?php } ?>
        </select>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <label for="month">Select Month</label><strong style="color:red;font-size: 10px;" id="monthmsg"></strong>
        <select name="month" class="form-control rentdetails" id="month">
        <?php 
          if(isset($_POST['prid'])) {
            $mnth =  $srow->month;

            if($mnth == '01') {
              $mn_nm = 'Janaury';
            }
            else if($mnth == '02') {
              $mn_nm = 'February';
            }
            else if($mnth == '03') {
              $mn_nm = 'March';
            }
            else if($mnth == '04') {
              $mn_nm = 'April';
            }
            else if($mnth == '05') {
              $mn_nm = 'May';
            }
            else if($mnth == '06') {
              $mn_nm = 'June';
            }
            else if($mnth == '07') {
              $mn_nm = 'July';
            }
            else if($mnth == '08') {
              $mn_nm = 'August';
            }
            else if($mnth == '09') {
              $mn_nm = 'September';
            }
            else if($mnth == '10') {
              $mn_nm = 'October';
            }
            else if($mnth == '11') {
              $mn_nm = 'November';
            }
            else if($mnth == '12') {
              $mn_nm = 'December';
            }
            
            echo "<option value='".$srow->month."'>".$mn_nm."</option>";

          } 

          if(!isset($_POST['prid'])) { ?>

          <option value=''>--Select--</option>
          <option value='01'>Janaury</option>
          <option value='02'>February</option>
          <option value='03'>March</option>
          <option value='04'>April</option>
          <option value='05'>May</option>
          <option value='06'>June</option>
          <option value='07'>July</option>
          <option value='08'>August</option>
          <option value='09'>September</option>
          <option value='10'>October</option>
          <option value='11'>November</option>
          <option value='12'>December</option>
        <?php } ?>
        </select>
        <span id="rentmonthdetails" style="color:red"></span>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <label for="type">Type</label><strong style="color:red;font-size: 10px;" id="typemsg"></strong>
        <select name="type" class="form-control rentdetails" id="type">
          <?php 
            if(isset($_POST['prid'])) {
              echo "<option value='" . $srow->type ."'>" . $srow->type."</option>";
            }

            if(!isset($_POST['prid'])) { 
          ?>
          <option value="">---Select---</option>
          <?php 
            $rnt_type = mysqli_query($con,"SELECT DISTINCT `rent_type` FROM `rent_approval` WHERE `status` = '1'");
            while ($typ_ftch = mysqli_fetch_object($rnt_type)) { 
              echo "<option value='".$typ_ftch->rent_type ."'>".$typ_ftch->rent_type."</option>";
            } 
          }
          ?>
        </select>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <label for="purpose">Purpose</label><strong style="color:red;font-size: 10px;" id="purposemsg"></strong>
        <select name="purpose" class="form-control rentdetails" id="purpose">
          <?php 
            if(isset($_POST['prid'])) {
              echo "<option value='".$srow->purpose."'>".$srow->purpose."</option>";
            }

            if(!isset($_POST['prid'])) { 
          ?>
          <option value="">---Select---</option>
          <?php 
            $rnt_pr = mysqli_query($con,"SELECT DISTINCT `purpose` FROM `rent_approval` WHERE `status` = '1'");
            while ($pr_ftch = mysqli_fetch_object($rnt_pr)) { 
              echo "<option value='".$pr_ftch->purpose."'>".$pr_ftch->purpose."</option>";
            }
          }
          ?>
        </select>
      </div>
    </div>
    <div class="col-lg-12" id="rent_bind">
    </div>        
  </div>
<?php }elseif(isset($_POST['trnscto']) && $_POST['trnscto'] =='dd'){?>
    <div class="row" style="margin-top: 20px;">
        <center><h4 style="text-decoration: underline; font-weight: bold; color: #37909e;">DD ASSIGN</h4></center>
      <div class="col-lg-12">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
          <div class="form-group">
            <label for="org_id">DD No.</label><strong style="color:red;font-size: 10px;" id="ddnomsg"></strong>
            <select class="form-control" name="ddno" id="ddno">
              <option value="">-- Select DD No. --</option>
              <?php
              $tdatel= date('Y-m-d');
                if (isset($_GET['bimpid'])) {
                  $orgdd = mysqli_query($con, "SELECT * FROM `fin_ddtls` WHERE '$tdatel' < `ddexpr_date` AND `scndstg_apv`='2' AND `finaldd_status`='1' AND `status`='1' AND `orgns_dd`='$fthimps->orgnstn_id' AND `dd_bnkifsc`='$fthbifsc->ifsc' AND `dd_amt`='$paidamt' ORDER BY `id` DESC");
                  $total_results = mysqli_num_rows($orgdd);
                  if($total_results>0)
                  {
                    while ($fthodd = mysqli_fetch_object($orgdd)) { 
                      echo "<option value='".$fthodd->id ."'>".$fthodd->dd_no."</option>";
                    } 
                  }else{
                    echo "<option value=''>No Records Found</option>";
                  }
                  
                }
              ?>
            </select>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
          <div class="form-group">
            <label for="org_id">Purpose</label><strong style="color:red;font-size: 10px;" id="ddpurposemsg"></strong>
            <input type="text" class="form-control" name="ddpurpose" id="ddpurpose" value="" readonly>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
          <div class="form-group">
            <label for="org_id">Expense Reasons</label>
            <select class="form-control" name="ddexprsn" id="ddexprsn">
              <option value=''>--select expense reason--</option>
                <?php 
                  $getbmsqr = mysqli_query($con, "Select id,subtypenm FROM `fin_grouping_subtype`  where `status`='1' AND lnkwith!='Indivisual'");
                   while ($fthbms = mysqli_fetch_object($getbmsqr)) { 
                    echo "<option value='".$fthbms->id."'>".$fthbms->subtypenm."</option>";
                  }  
                ?>
            </select>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
          <div class="form-group">
            <label for="org_id">Benificiary</label><strong style="color:red;font-size: 10px;" id="ddbenificiarymsg"></strong>
            <select class="form-control" name="ddbenificiary" id="ddbenificiary">
            </select>
          </div>
        </div>
        <div class="col-lg-12">
          <label for="type">Message</label><strong style="color:red;font-size: 10px;" id="ddmessagemsg"></strong>
          <textarea class="form-control" name="ddmessage" id="ddmessage"></textarea>
        </div>
      </div>
      <div class="col-lg-12" id="rent_bind">
      </div>        
    </div>
<?php }elseif(isset($_POST['trnscto']) && $_POST['trnscto'] =='fd'){?>
    <div class="row" style="margin-top: 20px;">
        <center><h4 style="text-decoration: underline; font-weight: bold; color: #37909e;">FD Assign</h4></center>
      <div class="col-lg-12">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
          <div class="form-group">
            <label for="org_id">FD No.</label><strong style="color:red;font-size: 10px;" id="fdnomsg"></strong>
            <select class="form-control" name="fdno" id="fdno">
              <option value="">-- Select FD No. --</option>
              <?php
              $tdatel= date('Y-m-d');
                if (isset($_GET['bimpid'])) {
                  $orgdd = mysqli_query($con, "SELECT * FROM `fin_fddtls` WHERE `id` NOT IN (SELECT `fd_id` FROM `fin_fdregister_status` WHERE `status`='1') AND `scnd_stgapv`='2' AND `status`='1' AND `orgnist`='$fthimps->orgnstn_id' AND `fd_banknm`='$fthbacc->accnm' AND `fd_amt` LIKE '$paidamt' ORDER BY `id` DESC");
                  $total_results = mysqli_num_rows($orgdd);
                  if($total_results>0)
                  {
                    while ($fthodd = mysqli_fetch_object($orgdd)) { 
                      echo "<option value='".$fthodd->id ."'>".$fthodd->fd_no."</option>";
                    } 
                  }else{
                    echo "<option value=''>No FD Found</option>";
                  }
                  
                }
              ?>
            </select>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
          <div class="form-group">
            <label for="org_id">Purpose</label><strong style="color:red;font-size: 10px;" id="fdpurposemsg"></strong>
            <input type="text" class="form-control" name="fdpurpose" id="fdpurpose" value="">
          </div>
        </div>
        <div class="col-lg-12">
          <label for="type">Message</label><strong style="color:red;font-size: 10px;" id="fdmessagemsg"></strong>
          <textarea class="form-control" name="fdmessage" id="fdmessage"></textarea>
        </div>
      </div>
      <div class="col-lg-12" id="rent_bind">
      </div>        
    </div>
<?php }elseif(isset($_POST['trnscto']) && $_POST['trnscto'] =='cheque'){?>
    <div class="row" style="margin-top: 20px;">
        <center><h4 style="text-decoration: underline; font-weight: bold; color: #37909e;">Cheque Assign</h4></center>
      <div class="col-lg-12">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
          <div class="form-group">
            <label for="org_id">Cheque No.</label><strong style="color:red;font-size: 10px;" id="chqnomsg"></strong>
            <select class="form-control" name="chqno" id="chqno">
              <option value="">-- Select Cheque No. --</option>
              <?php
              $tdatel= date('Y-m-d');
                if (isset($_GET['bimpid'])) {
                  $orgdd = mysqli_query($con, "SELECT * FROM `chqissueentry` WHERE '$tdatel' BETWEEN `validfrom` AND `validupto` AND `approvestatus`='0' AND `status`='1' AND `organisation`='$fthimps->orgnstn_id' AND `issuebank`='$fthbacc->bnkname' AND `amount`='$paidamt'");
                  $total_results = mysqli_num_rows($orgdd);
                  if($total_results>0)
                  {
                    while ($fthodd = mysqli_fetch_object($orgdd)) { 
                      echo "<option value='".$fthodd->id ."'>".$fthodd->chqno."</option>";
                    } 
                  }else{
                    echo "<option value=''>No Records Found</option>";
                  }
                  
                }
              ?>
            </select>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
          <div class="form-group">
            <label for="org_id">Purpose</label><strong style="color:red;font-size: 10px;" id="chqpurposemsg"></strong>
            <input type="text" class="form-control" name="chqpurpose" id="chqpurpose" value="" readonly>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
          <div class="form-group">
            <label for="org_id">Client</label>
            <select class="form-control" name="chqclient" id="chqclient">
              <option value=''>--Select Client--</option>
                
            </select>
          </div>
        </div>
        <div class="col-lg-12">
          <label for="type">Message</label><strong style="color:red;font-size: 10px;" id="chqmessagemsg"></strong>
          <textarea class="form-control" name="chqmessage" id="chqmessage"></textarea>
        </div>
      </div>
      <div class="col-lg-12" id="rent_bind">
      </div>        
    </div>
<?php }elseif(isset($_POST['trnscto']) && $_POST['trnscto'] =='salary_advance'){?>
    <div class="row" style="margin-top: 20px;">
    <center><h4 style="text-decoration: underline; font-weight: bold; color: #37909e;">Salary Advance</h4></center>
      <div class="col-lg-12">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
          <div class="form-group">
            <label for="org_id">Benificiary A/c</label><strong style="color:red;font-size: 10px;" id="benif_accmsg"></strong>
            <select class="form-control" name="benif_acc" id="benif_acc">
              <option value="">-- Select Benificiary A/c --</option>
              <?php
                $eq = "SELECT * FROM `mstr_emp` WHERE `status`='1' order by `fullname` ASC";
                $efq=mysqli_query($con,$eq);
                while ($egq = mysqli_fetch_object($efq))
                {
                  echo '<option value="'. $egq->id . '">' . $egq->fullname .'</option>';
                }
              ?>
            </select>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
          <div class="form-group">
            <label for="org_id">ESA ID</label><strong style="color:red;font-size: 10px;" id="esa_idmsg"></strong>
            <select class="form-control" name="esa_id" id="esa_id">
               
            </select>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
          <label for="type">Remarks</label><strong style="color:red;font-size: 10px;" id="sa_remarksmsg"></strong>
          <textarea class="form-control" name="sa_remarks" id="sa_remarks"></textarea>
        </div>
      </div>
      <div class="col-lg-12" id="rent_bind">
      </div>        
    </div>
<?php }elseif(isset($_POST['trnscto']) && $_POST['trnscto'] =='loan_advance'){?>
    <div class="row" style="margin-top: 20px;">
      <center><h4 style="text-decoration: underline; font-weight: bold; color: #37909e;">Loan Advance</h4></center>
      <div class="col-lg-12">
        <div class="col-lg-6">
          <div class="form-group">
            <label for="org_id">Benificiary A/c</label><strong style="color:red;font-size: 10px;" id="benif_accmsg"></strong>
            <select class="form-control" name="loan_benif_acc" id="loan_benif_acc">
              <option value="">-- Select Benificiary A/c --</option>
              <?php
                $eq = "SELECT * FROM `mstr_emp` WHERE `status`='1' order by `fullname` ASC";
                $efq=mysqli_query($con,$eq); 

                while ($egq = mysqli_fetch_object($efq))
                { 
                  echo '<option value="'. $egq->id . '">' . $egq->fullname .'</option>';
                }
              ?>
            </select>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label for="org_id">Loan ID</label><strong style="color:red;font-size: 10px;" id="loan_idmsg"></strong>
            <select class="form-control" name="loan_id" id="loan_id">
            </select>
          </div>
        </div>
        <div class="col-lg-6">
          <label for="type">Remarks</label><strong style="color:red;font-size: 10px;" id="la_remarksmsg"></strong>
          <textarea class="form-control" name="la_remarks" id="la_remarks"></textarea>
        </div>
      </div>
      <div class="col-lg-12" id="rent_bind">
      </div>        
    </div>
<?php }elseif(isset($_POST['trnscto']) && $_POST['trnscto'] =='loan_assignment'){?>
    <div class="row" style="margin-top: 20px;">
      <center><h4 style="text-decoration: underline; font-weight: bold; color: #37909e;">Loan Assignment</h4></center>
        <div class="col-lg-12">
          <div class="col-lg-6">
            <div class="form-group">
              <label for="loanid">Account No.</label><strong style="color:red;font-size: 10px;" id="account_nomsg"></strong>
              <select class="form-control getloan" name="account_no" id="account_no">
                <option value="">-- Select Acc No. --</option>
                <?php
                $tdatel= date('Y-m-d');
                if (isset($_GET['bimpid'])) {
                  $loanres = mysqli_query($con, "SELECT * FROM `fin_loan_master` WHERE `status`='1' ORDER BY `id` DESC");
                  $total_results = mysqli_num_rows($loanres);
                  if($total_results>0)
                  {
                    while ($ftholoan = mysqli_fetch_object($loanres)) { 
                    echo "<option value='".$ftholoan->loan_accntno ."'>".$ftholoan->loan_accntno."</option>";
                    } 
                  }else{
                    echo "<option value=''>No Records Found</option>";
                  }
                }
                ?>
              </select>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label for="instname">Loan Ref No.</label><strong style="color:red;font-size: 10px;" id="refnomsg"></strong>
              <input type="text" class="form-control" name="refno" id="refno" readonly>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label for="instname">Institution Name</label><strong style="color:red;font-size: 10px;" id="nbfcnamemsg"></strong>
              <input type="text" class="form-control" name="nbfcname" id="nbfcname" readonly>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label for="instname">Type</label><strong style="color:red;font-size: 10px;" id="typeidmsg"></strong>
              <select class="form-control getloan" name="typeid" id="typeid">
                <option value="">-- Select --</option>
                <option value="EMI">EMI</option>
                <option value="Cash">Cash</option>
                <option value="Others">Others</option>
              </select>
            </div>
          </div>
        </div>
        <div class="col-lg-12" id="tblemi" style="margin-top: 10px;">
          <div class="form-group" id="tableresult">
            
          </div>
        </div>
        <div class="col-lg-12" style="margin-top: 10px;" id="tblcash">
          <div class="form-group">
            <table class="table table-bordered table-condensed table-striped">
              <tbody>
                <tr>
                  <td style="color:blue;" align="center" colspan="1">
                    <label for="ltr_ctg_nm">Amount :</label>
                  </td>
                  <td style="color:blue;" align="center">
                    <input type="text" class="form-control cashsum" name="cashamt" id="cashamt">
                  </td>
                </tr>
                <tr>
                  <td style="color:blue;" align="center" colspan="1">
                    <label for="ltr_ctg_nm">Other :</label>
                  </td>
                  <td style="color:blue;" align="center" colspan="2">
                    <select class="form-control" name="other_crg_cash" id="other_crg_cash">
                    <option value="">-- Select --</option>
                    <?php
                    $getheadqr = mysqli_query($con, "SELECT `id`,`subtypenm` FROM `fin_grouping_subtype` WHERE `status`='1' AND `lnkwith`!=''");

                    while ($fthhd = mysqli_fetch_object($getheadqr)) {
                    echo "<option value='".$fthhd->id."'>".$fthhd->subtypenm."</option>";
                    }
                    ?>
                    </select>
                  </td>
                  <td style="color:blue;" align="center">
                    <input type="text" class="form-control cashsum" name="other_amt_cash" id="other_amt_cash"  value="" placeholder="Charges">
                  </td>
                </tr>
                <tr>
                  <td style="color:blue;" align="center" colspan="1">
                      <label for="ltr_ctg_nm">Total :</label>
                    </td>
                    <td style="color:blue;" align="center">
                      <input type="text" class="form-control" name="total_amt_cash" id="total_amt_cash" value="" placeholder="Total">
                    </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="col-lg-12" style="margin-top: 10px;" id="tblothr">
          <div class="form-group">
            <table class="table table-bordered table-condensed table-striped">
              <tbody>
                <tr>
                  <td style="color:blue;" align="center" colspan="1">
                    <label for="ltr_ctg_nm">Other :</label>
                  </td>
                  <td style="color:blue;" align="center" colspan="2">
                    <select class="form-control" name="other_crg" id="other_crg">
                    <option value="">-- Select --</option>
                    <?php
                    $getheadqr = mysqli_query($con, "SELECT `id`,`subtypenm` FROM `fin_grouping_subtype` WHERE `status`='1' AND `lnkwith`!=''");

                    while ($fthhd = mysqli_fetch_object($getheadqr)) {
                    echo "<option value='".$fthhd->id."'>".$fthhd->subtypenm."</option>";
                    }
                    ?>
                    </select>
                  </td>
                  <td style="color:blue;" align="center">
                    <input type="text" class="form-control othsum" name="other_amt" id="other_amt"  value="" placeholder="Charges">
                  </td>
                </tr>
                <tr>
                  <td style="color:blue;" align="center" colspan="1">
                      <label for="ltr_ctg_nm">Total :</label>
                    </td>
                    <td style="color:blue;" align="center">
                      <input type="text" class="form-control" name="total_amt_oth" id="total_amt_oth" value="" placeholder="Total">
                    </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>  
    </div>
<?php }elseif(isset($_POST['trnscto']) && $_POST['trnscto'] =='asset_finance'){?>
    <div class="row" style="margin-top: 20px;">
      <center><h4 style="text-decoration: underline; font-weight: bold; color: #37909e;">Asset Finance</h4></center>
      <div class="col-lg-12">
        <div class="col-lg-6">
          <div class="form-group">
            <label for="org_id">Benificiary A/c</label><strong style="color:red;font-size: 10px;" id="benif_accmsg"></strong>
            <select class="form-control" name="benif_acc" id="benif_acc">
                <option value="">--Select Benificiary A/c--</option>
              <?php
                $eq = "SELECT * FROM `mstr_emp` WHERE `status`='1' order by `fullname` ASC";
                $efq=mysqli_query($con,$eq); 

                while ($egq = mysqli_fetch_object($efq))
                    { 
                  echo '<option value="'. $egq->id . '">' . $egq->fullname .'</option>';
                    }
              ?>
            </select>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label for="org_id">AF ID</label><strong style="color:red;font-size: 10px;" id="af_idmsg"></strong>
               <select class="form-control" name="af_id" id="af_id">
                <option value="">Select AF ID</option>
            </select>
          </div>
        </div>
        <div class="col-lg-6">
          <label for="type">Remarks</label><strong style="color:red;font-size: 10px;" id="af_remarksmsg"></strong>
          <textarea class="form-control" name="af_remarks" id="af_remarks"></textarea>
        </div>
      </div>
      <div class="col-lg-12" id="rent_bind">
      </div>        
    </div>
<?php }elseif(isset($_POST['trnscto']) && $_POST['trnscto'] =='lc_processing'){?>
    <div class="row" style="margin-top: 20px;">
      <center><h4 style="text-decoration: underline; font-weight: bold; color: #37909e;">LC Processing</h4></center>
        <div class="col-lg-12">
          <div class="col-lg-6">
            <div class="form-group">
              <label for="org_id">LC No.</label><strong style="color:red;font-size: 10px;" id="lcnumidmsg"></strong>
              <select class="form-control" name="lcnumid" id="lcnumid">
                <option value="">-- Select LC No. --</option>
                <?php
                $tdatel= date('Y-m-d');
                if (isset($_GET['bimpid'])) {
                  /*$orgdd = mysqli_query($con, "SELECT * FROM `fin_lce` WHERE `status`='1' AND `orgid`='$fthimps->orgnstn_id' ORDER BY `id` DESC");*/
                  $orgdd = mysqli_query($con, "SELECT * FROM `fin_lce` WHERE aprv_status='2' AND `status`='1' ORDER BY `id` DESC");
                  $total_results = mysqli_num_rows($orgdd);
                  if($total_results>0)
                  {
                    while ($fthodd = mysqli_fetch_object($orgdd)) { 
                    echo "<option value='".$fthodd->id ."'>".$fthodd->lcnum."</option>";
                    } 
                  }else{
                    echo "<option value=''>No Records Found</option>";
                  }
                }
                ?>
              </select>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label for="org_id">Client</label><strong style="color:red;font-size: 10px;" id="clientmsg"></strong>
              <input type="text" class="form-control" name="client" id="client" readonly>
            </div>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="col-lg-6">
            <label for="type">Amount</label><strong style="color:red;font-size: 10px;" id="amountmsg"></strong>
            <input type="text" class="form-control" name="amount" id="amount" readonly>
          </div>
          <div class="col-lg-6">
            <label for="type">Transaction Dt:</label><strong style="color:red;font-size: 10px;" id="transc_dtmsg"></strong>
            <input type="text" class="form-control" name="transc_dt" id="transc_dt" readonly>
          </div>
        </div>
        <div class="col-lg-12" style="margin-top: 10px;">
          <div class="form-group">
            <table class="table table-bordered" id="dynamic_field">  <!--  -->
              <thead class="thead-dark">
                <tr> 
                  <th></th>
                  <th>Sl. No.</th>
                  <th>Invoice No.</th>
                  <th>Invoice Dt</th>
                  <th>Amount</th>
                </tr>
              </thead> 
              <tbody class="input_fields_wrap" id="tableresult">
                
              </tbody>
              <tfoot>
                <tr class="input_fields_wrap_tc">
                  <td style="color:blue;" align="center" colspan="2">
                    <label for="ltr_ctg_nm">Other :</label>
                  </td>
                  <td style="color:blue;" align="center">
                    <input type="text" class="form-control persum" name="other_crg[]" id="other_crg"  value="" placeholder="Charges">
                  </td>
                  <td style="color:blue;" align="center">
                    <input type="text" class="form-control persum" name="other_amt[]" id="other_amt" onkeypress="return ssd(this, event);" value="" placeholder="Amount">
                  </td>
                  <td>
                    <button type="button" class="btn btn-primary btn-xs add_field_button" name="add" id="add" style="margin-top: 5px;"><i class="fa fa-plus fa-fw"></i></button>
                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td style="color:blue;" align="right" colspan="2">
                    <label for="ltr_ctg_nm">Total :</label>
                  </td>
                  <td style="color:blue;" align="center">
                    <input type="text" class="form-control" name="total_amt" id="total_amt" value="" placeholder="Total Amount Here" readonly>
                    <input type="hidden" class="form-control" name="chkamt" id="chkamt" value="">
                    <input type="hidden" class="form-control" name="demo" id="demo" value="">
                  </td>
                  <td></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      <div class="col-lg-12" id="rent_bind">
      </div>        
    </div>
<?php }elseif(isset($_POST['trnscto']) && $_POST['trnscto'] =='salary_processing'){?>
    <div class="row" style="margin-top: 20px;">
    <center><h4 style="text-decoration: underline; font-weight: bold; color: #37909e;">Salary Processing</h4></center>
      <div class="col-lg-12">
        <div class="col-lg-6">
          <div class="form-group">
            <label for="org_id">Benificiary A/c</label>
            <select class="form-control splpr" name="benif_acc" id="benif_acc">
              <?php
                $eq = "SELECT * FROM `mstr_emp` order by `fullname` ASC";
                $efq=mysqli_query($con,$eq);
                while ($egq = mysqli_fetch_object($efq))
                {
                  echo '<option value="'. $egq->id . '">' . $egq->fullname .'</option>';
                }
              ?>
            </select>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label for="org_id">Location</label>
            <select class="form-control splpr" name="location" id="location">
              <?php
                $loc = "SELECT * FROM `hr_location` order by `lname` ASC";
                $eloc=mysqli_query($con,$loc);
                while ($elocq = mysqli_fetch_object($eloc))
                {
                  echo '<option value="'. $elocq->id . '">' . $elocq->lname .'</option>';
                }
              ?>
            </select>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label for="org_id">Year</label><strong style="color:red;font-size: 10px;" id="yearmsg"></strong>
            <select class="form-control splpr" name="year" id="year">
              <?php
                /*for($i=0;$i<=5;$i++){
                $year=date('Y',strtotime("last day of +$i year"));
                echo '<option value="'. $year . '">' . $year .'</option>';
                }*/
              ?>
              <option value="">--Select--</option>
                <script type="text/javascript">
                    for (i = new Date().getFullYear(); i > 2000; i--)
                     {
                       $('#year').append($('<option />').val(i).html(i));
                     }
                    
                </script>
            </select>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group splpr">
            <label for="org_id">Month</label><strong style="color:red;font-size: 10px;" id="yearmsg"></strong>
            <select class="form-control" name="month" id="month">
              <option value="01">January</option>
              <option value="02">February</option>
              <option value="03">March</option>
              <option value="04">April</option>
              <option value="05">May</option>
              <option value="06">June</option>
              <option value="07">July</option>
              <option value="08">August</option>
              <option value="09">September</option>
              <option value="10">October</option>
              <option value="11">November</option>
              <option value="12">December</option>
            </select>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label for="org_id">Req No.</label><strong style="color:red;font-size: 10px;" id="req_idmsg"></strong>
            <select class="form-control" name="req_id" id="req_id"></select>
          </div>
        </div>
        <div class="col-lg-6">
          <label for="type">Remarks</label><strong style="color:red;font-size: 10px;" id="orgnamemsg"></strong>
          <input type="hidden" name="orgname" id="orgname" value="<?php echo $pay_orgnstn; ?>">
          <textarea class="form-control" name="sp_remarks" id="sp_remarks"></textarea>
        </div>
      </div>
      <div class="col-lg-12" id="rent_bind">
      </div>        
    </div>
<?php }elseif(isset($_POST['trnscto']) && $_POST['trnscto'] =='bank_transfer'){?>
  <div class="row" style="margin-top: 20px;">
    <center><h4 style="text-decoration: underline; font-weight: bold; color: #37909e;">Bank Transfer</h4></center>
    <div class="col-lg-12">
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="org_id">Organization</label><strong style="color:red;font-size: 10px;" id="org_nmmsg"></strong>
        <select class="form-control splpr" name="org_nm" id="org_nm">
          <option value="">--- Select Organisation ---</option>
            <?php
              $orgnsnqr = mysqli_query($con, "SELECT * FROM `prj_organisation` WHERE `status`='1'");
              while ($fthorgnsn = mysqli_fetch_object($orgnsnqr)) {
                echo "<option value='".$fthorgnsn->id."'>".$fthorgnsn->organisation."</option>";
              }
            ?>
        </select>
      </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="org_id">Bank Allias Name</label><strong style="color:red;font-size: 10px;" id="bnkaccntmsg"></strong>
        <select class="form-control" name="bnkaccnt" id="bnkaccnt">
          <option value="">--- Select Bank Account ---</option>
        </select>
      </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="org_id">Bank Acc no.</label>
        <input type="text" class="form-control" name="accno" id="accno" readonly>
      </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="org_id">Branch</label>
        <input type="text" class="form-control" name="brnch_nm" id="brnch_nm" readonly>
      </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
      <div class="form-group splpr">
        <label for="org_id">Location</label>
        <input type="hidden" class="form-control" name="loc_id" id="loc_id">
        <input type="text" class="form-control" name="loc_nm" id="loc_nm" readonly>
      </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="org_id">IFSC Code</label>
        <input type="text" class="form-control" name="ifsc_cd" id="ifsc_cd" readonly>
      </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="org_id">CIF No/ CRN No</label>
        <input type="text" class="form-control" name="cif_no" id="cif_no" readonly>
      </div>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-6 col-xs-6">
      <label for="type">Remarks</label><strong style="color:red;font-size: 10px;" id="bnktrn_remarksmsg"></strong>
      <textarea class="form-control" name="bnktrn_remarks" id="bnktrn_remarks"></textarea>
    </div>
  </div>
  <div class="col-lg-12" id="rent_bind">
  </div>        
  </div>
<?php }elseif(isset($_POST['trnscto']) && $_POST['trnscto'] =='others'){?>
  <div class="row" style="margin-top: 30px;">
    <center><h4 style="text-decoration: underline; font-weight: bold; color: #37909e;">Other Payment Details</h4></center>
    <div class="col-lg-12">
      <input type="hidden" name="lnkwith" value="" id="lnkwith">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label for="othrhd">Head</label><strong style="color:red;font-size: 10px;" id="othrhdmsg"></strong>
          <select class="form-control" name="othrhd" id="othrhd" required>
            <option value="">-- Select Head --</option>
            <?php
              $getheadqr = mysqli_query($con, "SELECT `id`,`subtypenm` FROM `fin_grouping_subtype` WHERE `status`='1'");
              while ($fthhd = mysqli_fetch_object($getheadqr)) {
                echo "<option value='".$fthhd->id."'>".$fthhd->subtypenm."</option>";
              }
            ?>
          </select>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label for="particlr">Particular</label><strong style="color:red;font-size: 10px;" id="particlrmsg"></strong>
          <select class="form-control" name="particlr" id="particlr" required>
            <option value="">-- Select Particular --</option>
          </select>
        </div>
      </div>
    </div>
  </div>
<?php }?>
<!-- Supplier part Get clients As Per Debtor Selection -->
  <script type="text/javascript">
      $(document).ready(function(){
          $("#spreq_typ").change(function(){
              var reqtyp = $("#spreq_typ").val();
              if (reqtyp != "") {
                  if (reqtyp == "PR") {
                      $("#prDtls").show();
                      $("#trnsDtls").hide();
                  }else {
                      $("#prDtls").hide();
                      $("#trnsDtls").show();
                  }
              }else {
                $("#prDtls").hide();
                $("#trnsDtls").hide();
              }
          });
          //Get Cr Limit & Project As Per Supplier Selection
          $("#suplrnm").change(function(){
              getCrPrj();
          });
          function getCrPrj() {
              var splrid = $("#suplrnm").val();
              if (splrid != "") {
                  $.ajax({
                    url:"<?php echo SITE_URL; ?>/basic/finance/get_prj.php",
                    data:{sup_id:splrid},
                    type:'POST',
                    success:function(response) {
                      var res = $.trim(response);
                      $("#prj_name").html(res);
                    }
                  });
              }else {
                  $("#prj_name").html("<option value=''>Pick A Valid Supplier</option>");
              }
          }
          $("#prj_name").change(function(){
              var prjid = $("#prj_name").val();
              var splrid = $("#suplrnm").val();
              if (prjid != "") {
                  $.ajax({
                      url:"<?php echo SITE_URL; ?>/basic/finance/get_po.php",
                      data:{prjj:prjid,supl:splrid},
                      type:'POST',
                      success:function(response) {
                        var resp = $.trim(response);
                        $("#ponum").html(resp);
                      }
                  });
              }else {
                $("#ponum").html("<option value=''>No PO Found</option>");
              }
          });
          $("#ponum").change(function(){
              var ponm = $("#ponum").val();
              if (ponm != "") {
                $.ajax({
                  url:"<?php echo SITE_URL; ?>/basic/finance/get_po.php",
                  data:{ponum:ponm},
                  type:'POST',
                  success:function(result) {
                    var rslt = $.trim(result);
                    var poinfo = rslt.split("#");
                    
                    document.getElementById("poamnt").value = poinfo[0];
                    document.getElementById("podate").value = poinfo[1];
                  }
                });
              }else {
                  $("#poamnt").val("");
                  $("#podate").val("");
              }
          });
          $("#spreq_typ").change(function(){
              var req = $("#spreq_typ").val();
              if (req == "PR") {
                var ponm = $("#ponum").val();
                  if (ponm != "") {
                      $.ajax({
                        url:"<?php echo SITE_URL; ?>/basic/finance/get_pr.php",
                        data:{ponum:ponm},
                        type:'POST',
                        success:function(result) {
                          var resp = $.trim(result);
                          $("#pr_numbr").html(resp);
                        }
                      });
                  }else {
                      $("#pr_numbr").html("<option value=''>No PR Found</option>");
                  }
              }
          });
          $("#pr_numbr").change(function(){
              var pr = $("#pr_numbr").val();
              var ponm = $("#ponum").val();
              if (pr != "") {
                  $.ajax({
                      url:"<?php echo SITE_URL; ?>/basic/finance/get_other_pr_dtls.php",
                      data:{ponum:ponm,prnum:pr},
                      type:'POST',
                      success:function(result) {
                          var resp = JSON.parse(result);
                          $("#subprj_nm").val(resp.sbprjct);
                          $("#bms_name").val(resp.blng_mlstn);
                          $("#pramnt").val(resp.pramt);
                      }
                  });
              }else {
                  $("#subprj_nm").val("");
                  $("#bms_name").val("");
                  $("#pramnt").val("");
              }
          });
      });
  </script>
<!-- supplier end -->
<!-- Vendor Get project Details As Per Vendor Selection -->
  <script type="text/javascript">
    $(document).ready(function(){
        $("#vndrnm").change(function(){
            var vndrid = $(this).val();
            if (vndrid != "") {
              $.ajax({
                url:"<?php echo SITE_URL; ?>/basic/finance/prj_for_payasgn.php",
                data:{vndrnm:vndrid},
                type:'POST',
                success:function(response) {
                  var resp = JSON.parse(response);

                  $("#prjct_name").html(resp.prjnames);
                }
              });
            }
            else {
              $("#prjct_name").html("<option value=''>Pick A Valid Vendor</option>");
            }
        });
        //Get JO As Per Project Selection
        $("#prjct_name").change(function(){
            var vndr = $("#vndrnm").val();
            var prjid = $("#prjct_name").val();
            if (prjid != "") {
              $.ajax({
                url:"<?php echo SITE_URL; ?>/basic/finance/jo_for_payasgn.php",
                data:{vndrnm:vndr,prjct_name:prjid},
                type:'POST',
                success:function(response) {
                  var resp = $.trim(response);
                  $("#jobodr_num").html(resp);
                }
              });
            }
            else {
              $("#jobodr_num").html("<option value=''>Pick A Valid Project</option>");
            }
        });
        //Get JO Value & Sub-Project As Per JO Selection
        $("#jobodr_num").change(function(){
            showSbPrj();
        });
        function showSbPrj() {
          var joboid = $("#jobodr_num").val();
          if (joboid != "") {
              $.ajax({
                url:"<?php echo SITE_URL; ?>/basic/finance/joval_for_payasgn.php",
                data:{jobodr_num:joboid},
                type:'POST',
                success:function(response) {
                  var response = $.trim(response);
                  var joval = response.split("#");
                  $("#jobodr_val").val(joval[0]);
                  // Fetch of Table
                  $.ajax({
                    url:"<?php echo SITE_URL; ?>/basic/finance/subprj_for_payasgn.php",
                    data:{jonum:joboid,jo_unqcd:joval[1]},
                    type:'POST',
                    success:function(resp) {
                      var resp = $.trim(resp);
                      $("#showSubPrj").html(resp);
                    }
                  });
                }
              });
          }else {
              $("#jobodr_val").val("");
              $("#showSubPrj").html("");
          }
        }
    });
  </script>
<!-- End Vendor of Get project Details As Per Vendor Selection -->
<!-- transporter section  Get Sub-Project, BMS & Po Number As Per Project Selection-->
<script type="text/javascript">
    $(document).ready(function(){
      $("#prjctnm").change(function(){
        var prjctid = $(this).val();
        if (prjctid != "") {
          $.ajax({
            url:"<?php echo SITE_URL; ?>/basic/finance/sp_bms_po_frpayasgn.php",
            data:{prjctnm:prjctid},
            type:'POST',
            success:function(response) {
              var resp = JSON.parse(response);
              $("#subprjnm").html(resp.subprjs);
              $("#bmsnm").html(resp.tbms);
              $("#trans_ponum").html(resp.pos);
            }
          });
        }
        else {
          $("#subprjnm").html("<option value=''>Pick A Valid Project</option>");
          $("#bmsnm").html("<option value=''>Pick A Valid Project</option>");
          $("#trans_ponum").html("<option value=''>Pick A Valid Project</option>");
        }
      });
    });
    function calc() {
      var distance = 0;
      var weight = 0;
      var total_amt = 0;
      var adv_prcnt = 0;
      var rateper_km = 0;
      var rateper_kg = 0;
      var adv_amt = 0;
      var remain_amt = 0;
      distance = Number($("#distance").val());
      weight = Number($("#mtrl_weight").val());
      total_amt = Number($("#totalamnt").val());
      rateper_km = (total_amt / distance).toFixed(2);
      rateper_kg = (total_amt / weight).toFixed(2);
      $("#rateper_km").val(parseFloat(rateper_km));
      $("#rateper_kg").val(parseFloat(rateper_kg));
    }
</script>
<!-- end -->
<!-- GST section -->
<script>
  //Get GST No. As Per Organisation & State Selection
  function getGST() {
    var organisation = $("#organisation").val();
    var state_nm = $("#state_nm").val();
    if (organisation != "" && state_nm != "") {
      $.ajax({
        url:"<?php echo SITE_URL; ?>/basic/finance/payment_assign/gst_for_payasgn.php",
        data:{org:organisation,state:state_nm},
        type:'POST',
        success:function(response) {
          var resp = $.trim(response);
          $("#gstnum").val(resp);
        }
      });
    }
    else {
      $("#gstnum").val("");
    }
  }
</script>
<!-- GST section -->
<!-- collection section -->
<script type="text/javascript">
  $(document).ready(function(){
    $("#debtor_typ").change(function(){
      getClients();
    });
  });
  function getClients() {
    var dbtrid = $("#debtor_typ").val();
    if (dbtrid != "") {
      $.ajax({
        url:"<?php echo SITE_URL; ?>/basic/finance/clients_for_payasgn.php",
        data:{debtor_typ:dbtrid,clnt:''},
        type:'POST',
        success:function(response) {
          var resp = $.trim(response);
          $("#clientnm").html(resp);
        }
      });
    }
    else {
      $("#clientnm").html("<option value=''>Select Valid Debtor</option>");
    }
  }
</script>
<!-- end collection -->
<!-- expense section -->
<script type="text/javascript">
  $(document).ready(function(){
    //Get Sub-Project & BMS As Per Project Selection
    $("#prjct").change(function(){
      var prjctid = $(this).val();
      if (prjctid != "") {
        $.ajax({
          url:"<?php echo SITE_URL; ?>/basic/finance/get_subprj_bms.php",
          data:{prjctnm:prjctid},
          type:'POST',
          success:function(response) {
            var resp = JSON.parse(response);

            $("#sub_prjct").html(resp.sbprjnm);
            $("#bmsnm").html(resp.blng_ms);
          }
        });
      }
      else {
        $("#sub_prjct").html("<option value=''>Pick A Valid Project</option>");
        $("#bmsnm").html("<option value=''>Pick A Valid Project</option>");
      }
    });
    //Get Employee Code As Per Employee Selection
    $("#expns_for").change(function(){
      var emid = $("#expns_for").val();
      if (emid != "") {
        $.ajax({
          url:"<?php echo SITE_URL; ?>/basic/finance/get_empcode.php",
          data:{empnm:emid},
          type:'POST',
          success:function(response) {
            var rslt = $.trim(response);
            document.getElementById("exp_for_empcode").value = rslt;
          }
        });
      }
    });
  });
</script>
<!-- expense section -->
<!-- rent section -->
<script type="text/javascript">
    function getMonthName(monthNumber) {
      const date = new Date();
      date.setMonth(monthNumber - 1);
      return date.toLocaleString('en-US', { month: 'long' });
    }
    $(document).ready(function () {
        $(".rentdetails").change(function(){
          if($(this).val() != ''){
            var org = $("#org_id").val();
            var yr = $("#year").val();
            var mnth = $("#month").val();
            var typ = $("#type").val();
            var prps = $("#purpose").val();
            if(org !='' && yr !='' && mnth !='' && typ !='' && prps !=''){
              $.ajax({
                url:"<?php echo SITE_URL; ?>/basic/finance/payment_assign/get_rnt_pymnt_rqst.php",
                data:{org_id:org,yr_nm:yr,mnth_nm:mnth,type:typ,purpose:prps},
                type:'POST',
                success:function(response){
                  var resp = $.trim(response);
                  $("#rent_bind").html(resp);
                }
              })
            }
          }else {
            $("#rent_bind").html('');
          }
      
        });
        $("#month").change(function(){
          var month = $("#month").val();
          var previous = getMonthName(month-1);
          $("#rentmonthdetails").html("<span>Rent for "+previous+" month</span>");
        });
    });
</script>
<!-- rent section end-->
<!-- salary advance -->
<script type="text/javascript">
    $(document).on('change', '#benif_acc', function(){
      var benif_acc = $(this).val();
        if (benif_acc != "") {
          $.ajax({
            url:"<?php echo SITE_URL; ?>/basic/finance/get_fin_ajax.php",
            data:{benif_acc_sa:benif_acc},
            type:'GET',
            success:function(response) {
              var resp = $.trim(response);
              document.getElementById("esa_id").value = resp;
              $("#esa_id").html(resp);
            }
          });
        }
        else {
          $("#esa_id").val("<option value='0'>No Result Found</option>");
        }
    });
</script>
<!-- salary advance end -->
<!-- loan advance -->
<script type="text/javascript">
    $(document).on('change', '#loan_benif_acc', function(){
      var benif_acc = $(this).val();
        if (benif_acc != "") {
          $.ajax({
            url:"<?php echo SITE_URL; ?>/basic/finance/get_fin_ajax.php",
            data:{benif_acc_sa:benif_acc},
            type:'GET',
            success:function(response) {
              var resp = $.trim(response);
              document.getElementById("loan_id").value = resp;
              $("#loan_id").html(resp);
            }
          });
        }
        else {
          $("#loan_id").val("<option value='0'>No Result Found</option>");
        }
    });
</script>
<!-- loan advance end -->
<!-- loan assignment section -->
<script type="text/javascript">
  $(document).ready(function() {
      $('#tblemi').hide();
      $('#tblcash').hide();
      $('#tblothr').hide();
  });
  $("#account_no").change(function(){
    var account_no = $("#account_no").val();
    if( account_no != '')
    {
      $.ajax(
      {
        url:"<?php echo SITE_URL; ?>/basic/finance/get_fin_ajax.php",
        data:{account_no:account_no},
        type:'POST',
        success:function(response)
        {
          var sd = $.trim(response);
          var str = sd;
          var acc=str.split("*");
          document.getElementById("nbfcname").value = acc[0];
          document.getElementById("refno").value = acc[1];
        }
      });
    }else{
      document.getElementById("nbfcname").value = '';
    }
  });
  $(".getloan").change(function(){
    var account_no = $("#account_no").val();
    var typeid = $("#typeid").val();
    if (typeid =='EMI') {
      $('#tblcash').hide();
      $('#tblothr').hide();
    }else if (typeid =='Cash') {
      $('#tblcash').show();
      $('#tblemi').hide();
      $('#tblothr').hide();
    }else if (typeid =='Others') {
      $('#tblcash').hide();
      $('#tblemi').hide();
      $('#tblothr').show();
    }

    if( account_no != '' && typeid =='EMI')
    {
      $.ajax(
      {
        url:"<?php echo SITE_URL; ?>/basic/finance/get_loan_emi_record.php",
        data:{account_no:account_no},
        type:'POST',
        success:function(response)
        {
          $('#tblemi').show();
          var sd = $.trim(response);
          $('#tableresult').html(sd);
        }
      });
    }else{
      $('#tblemi').hide();
      document.getElementById("tableresult").value = '';
    }
  });
  $(".cashsum").keyup(function(){   
    var totalsum= 0;
    $(".cashsum").each(function() 
    {
      totalsum += +$(this).val();
    });
    $("#total_amt_cash").val(totalsum);
    });
    $(".othsum").keyup(function(){ 
      totalothsum = $(this).val();  
    $("#total_amt_oth").val(totalothsum);
  });
</script>
<!-- loan assignment end -->
<!-- Salary Processing details -->
<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('change', '.splpr', function(){
      var benif_acc = $("#benif_acc").val();
      var orgid = $("#orgname").val();
      var location = $("#location").val();
      var month = $("#month").val();
      var year = $("#year").val();
      if (year != "") {
        $.ajax({
          url:"<?php echo SITE_URL; ?>/basic/finance/get_fin_ajax.php", // dont move this file inside payment assign folder
          data:{benif_acc:benif_acc,location:location,month:month,year:year,orgid:orgid},
          type:'GET',
          success:function(response) {
            var resp = $.trim(response);
            document.getElementById("req_id").value = resp;
            $("#req_id").html(resp);
          }
        });
      }
      else {
        $("#req_id").val("<option value=''>No Result Found</option>");
      }
    });
  });
</script>
<!-- Salary Processing details end -->
<!-- Bank Transfer details -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#org_nm").change(function() {
      var org_nm = $("#org_nm").val();
      if(org_nm != "") {
        $.ajax({
          url:"<?php echo SITE_URL; ?>/basic/finance/payment_assign/get_bankaccdtls.php",
          data:{org_nm:org_nm},
          type:'POST',
          success:function(response) {
            var resp = $.trim(response);
            $("#bnkaccnt").html(resp);
          }
        });
      }
      else {
        $("#bnkaccnt").html('<option value="">Pick A Valid Organisation</option>');
      }
    });
    $("#bnkaccnt").change(function() {
      var bnkaccnt = $(this).val();
      if(bnkaccnt != "") {
        $.ajax({
          url:"<?php echo SITE_URL; ?>/basic/finance/get_bankaccdtls.php",
          data:{bankid:bnkaccnt},
          type:'POST',
          success:function(response) 
          {
            var sd = $.trim(response);
            var str = sd;
            var dprtinfo = str.split("*");
            document.getElementById("brnch_nm").value = dprtinfo[0];
            document.getElementById("accno").value = dprtinfo[1];
            document.getElementById("ifsc_cd").value = dprtinfo[2];
            document.getElementById("cif_no").value = dprtinfo[3];
            document.getElementById("loc_id").value = dprtinfo[4];
            document.getElementById("loc_nm").value = dprtinfo[5];
          }
        });
      }
      else {
       //$("#bnkaccnt").html('<option value="">Pick A Valid Organisation</option>');
      }
    });
  });
</script>
<!-- Bank Transfer details end -->
<!-- Others Section -->
<script type="text/javascript">
  $("#othrhd").change(function(){
    var headdid = $("#othrhd").val();
    if (headdid != "") {
      $.ajax({
        url:"<?php echo SITE_URL; ?>/basic/finance/payment_assign/get_prtclr.php",
        data:{othrhead:headdid},
        type:'POST',
        success:function(response) {
          var rslt = $.trim(response);
          $("#particlr").html(rslt);
          getlinkedname(headdid);
        }
      });
    }
    else {
      $("#particlr").html("<option value=''>Pick A Valid Head</option>");
    }
  });
  function getlinkedname(headdid){
    var headdid = $("#othrhd").val();
    if (headdid != "") {
      $.ajax({
        url:"<?php echo SITE_URL; ?>/basic/finance/payment_assign/get_linked.php",
        data:{headdid:headdid},
        type:'POST',
        success:function(response) {
          $("#lnkwith").val(response);
        }
      });
    }
  }
</script>
<!-- Others Section End-->
<!-- Asset  Finanace -->
<script type="text/javascript">
$(document).ready(function(){
    $(document).on('change', '#benif_acc', function(){
      var benif_acc_af = $(this).val();
        if (benif_acc_af != "") {
          $.ajax({
            url:"<?php echo SITE_URL; ?>/basic/finance/get_fin_ajax.php",
            data:{benif_acc_af:benif_acc_af},
            type:'GET',
            success:function(response) {
              var resp = $.trim(response);
              document.getElementById("af_id").value = resp;
              $("#af_id").html(resp);
            }
          });
        }
        else {
          $("#af_id").val("<option value=''>No Result Found</option>");
        }
    });
  });
</script>
<!-- Asset  Finanace End-->


