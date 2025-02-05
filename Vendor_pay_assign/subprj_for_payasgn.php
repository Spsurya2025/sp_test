<?php include("../../../config.php"); ?>

<!-- Form Validation -->
<script type="text/javascript">
  $(document).ready(function() {

    $("#paysbmt").click(function() {

      var subprjct_nm = $("#subprjct_nm").val();
      var bmsnm = $("#bmsnm").val();
      var req_amt = $("#req_amt").val();
      var tds_cent = $("#tds_cent").val();

      // Checking for Blank Fields.
      var numbers = /^[0-9]+\.?[0-9]*$/;

      if (subprjct_nm == '') {

        $('#subprjct_nm').css("border", "2px solid #ec1313");
        alert("Pick Sub-Project");
        $('#subprjct_nm').focus();
        return false;
      } else if (bmsnm == '') {
        $('#subprjct_nm').css("border", "2px solid #ec1313");

        $('#bmsnm').css("border", "2px solid #ec1313");
        alert("Pick The Billing Milestone");
        $('#bmsnm').focus();
        return false;
      } else if (req_amt == '') {
        $('#subprjct_nm, #bmsnm').css("border", "2px solid #ec1313");

        $('#req_amt').css("border", "2px solid #ec1313");
        alert("Provide The Request Amount");
        $('#req_amt').focus();
        return false;
      } else if (tds_cent == '') {
        $('#subprjct_nm, #bmsnm, #req_amt').css("border", "2px solid #ec1313");

        $('#tds_cent').css("border", "2px solid #ec1313");
        alert("Select TDS Percentage");
        $('#tds_cent').focus();
        return false;
      } else {
        return true;
      }
    });
  });
</script>
<!-- End of Form Validation -->

<!-- Get BMS Details As Per Sub-Project Selection -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#subprjct_nm").change(function() {
      var spid = $(this).val();
      if (spid != "") {
        $.ajax({
          url: "<?php echo SITE_URL; ?>/basic/finance/payment_assign/Vendor_pay_assign/bms_for_payasgn.php",
          data: {
            subprjct_nm: spid,
            joucd: <?php echo $_POST['jo_unqcd']; ?>
          },
          type: 'POST',
          success: function(response) {
            var resp = $.trim(response);
            $("#bmsnm").html(resp);
          }
        });
      } else {
        $("#bmsnm").html("<option value=''>Pick A Valid Sub-Project</option>");
      }
    });
  });
</script>
<!-- End of Get BMS Details As Per Sub-Project Selection -->

<!-- Get BMS Value As Per BMS Selection -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#bmsnm").change(function() {
      var subprj = $("#subprjct_nm").val();
      var blngmsid = $("#bmsnm").val();
      if (subprj != "" && blngmsid != "") {
        $.ajax({
          url: "<?php echo SITE_URL; ?>/basic/finance/payment_assign/Vendor_pay_assign/bms_val_for_payasgn.php",
          data: {
            subprjct_nm: subprj,
            bmsnm: blngmsid,
            joucd: <?php echo $_POST['jo_unqcd']; ?>
          },
          type: 'POST',
          success: function(response) {
            var resp = $.trim(response);
            var workval = resp.split("#");

            $("#wrk_dscrptn").val(workval[0]);
            $("#subprjct_val").val(workval[1]);
          }
        });
      } else {
        $("#wrk_dscrptn").val('');
        $("#subprjct_val").val('');
      }
    });
  });
</script>
<!-- End of Get BMS Value As Per BMS Selection -->

<!-- Payable Amount Calculation -->
<!-- <script type="text/javascript">
	function payReq() {
		var ttl_tds = 0;
		var fnl_payment = 0;

		var subprjct_val = $("#subprjct_val").val();
		var req_amt = $("#req_amt").val();
		var tds_cent = $("#tds_cent").val();

			ttl_tds = ((req_amt * tds_cent)/100).toFixed(2);
			fnl_payment = (req_amt - ttl_tds).toFixed(2);

			$("#tds_val").val(ttl_tds);
			$("#payable_amt").val(fnl_payment);
	}
</script> -->
<!-- End of Payable Amount Calculation -->

<div class="col-lg-12">
  <legend>
    <h6><strong style="color: #2bc59b;">Sub Project Details</strong></h6>
  </legend>
  <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Sub Project</th>
          <th>BMS</th>
          <th>Work Desc (Alias)</th>
          <th>Value</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <select class="form-control" name="subprjct_nm" id="subprjct_nm">
              <option value="">-Sub-Project-</option>
              <?php
              if (isset($_POST['jonum']) && isset($_POST['jo_unqcd'])) {

                $jouc = mysqli_real_escape_string($con, $_POST['jo_unqcd']);

                $spqr = mysqli_query($con, "SELECT * FROM `prj_joborder_req_dtls` WHERE `uniqcode`='$jouc' GROUP BY `sub_proj_id`");
                if (mysqli_num_rows($spqr) > 0) {
                  while ($getsp = mysqli_fetch_object($spqr)) {
                    $spid = $getsp->sub_proj_id;
                    $spnmqr = mysqli_query($con, "SELECT * FROM `prj_subproject` WHERE `id`='$spid'");
                    $getspnm = mysqli_fetch_object($spnmqr);
                    echo "<option Value='" . $spid . "'>" . $getspnm->spname . "</option>";
                  }
                } else {
                  echo "<option value=''>No Records Found</option>";
                }
              }
              ?>
            </select>
          </td>
          <td>
            <select class="form-control" name="bmsnm" id="bmsnm">
              <option value="">-BMS-</option>
            </select>
          </td>
          <td>
            <input type="text" class="form-control" name="wrk_dscrptn" id="wrk_dscrptn" placeholder="Work Description" value="<?php if (isset($_POST['prqid'])) {
                                                                                                                                echo $vsprow->wrk_dscrptn;
                                                                                                                              } ?>" readonly>
          </td>
          <td>
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-rupee"></i></span>
              <input type="text" class="form-control" name="subprjct_val" id="subprjct_val" value="<?php if (isset($_POST['prqid'])) {
                                                                                                      echo $vsprow->subprjct_val;
                                                                                                    } ?>" placeholder="Sub-Project Value" readonly>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>