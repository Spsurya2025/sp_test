<?php require_once('../../../auth.php'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
<script type="text/javascript" charset="utf8" src="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<?php
if (isset($_GET['bimpid'])) {
  $bimpid = $_GET['bimpid'];
  $paidamt = round($_GET['paidamt']);
  $dtlsqr = mysqli_query($con, "SELECT x.*,y.* FROM `fin_banking_imports` x, `fin_statement_preview` y WHERE x.`preview_id`=y.`id` AND x.`id`='$bimpid' AND y.`status`='1'");
  $fthimps = mysqli_fetch_object($dtlsqr);
}
?>
<script type="text/javascript">
  $(document).ready(function() {
    $('.select2').select2({});
  })
  $("#lcnumid").change(function() {
    var lcnumid = $("#lcnumid").val();
    if (lcnumid != '') {
      $.ajax({
        url: "<?php echo SITE_URL; ?>/basic/finance/payment_assign/LC_processing_pay_assign/get_fin_ajax.php",
        data: {
          lcnumid: lcnumid
        },
        type: 'POST',
        success: function(response) {
          var sd = $.trim(response);
          var str = sd;
          var acc = str.split("*");


          document.getElementById("client").value = acc[4];
          document.getElementById("amount").value = acc[6];
          document.getElementById("transc_dt").value = acc[3];
        }
      });
    } else {
      $('orgnm').val('');
      document.getElementById("client").value = '';
      document.getElementById("amount").value = '';
      document.getElementById("transc_dt").value = '';
    }
  })
</script>
<script type="text/javascript">
  $("#lcnumid").change(function() {
    var lcnumid = $("#lcnumid").val();

    $.ajax({
      url: "<?php echo SITE_URL; ?>/basic/finance/payment_assign/LC_processing_pay_assign/get_inv_record.php",
      data: {
        lcnumid: lcnumid
      },
      type: 'POST',
      success: function(response) {
        var sd = $.trim(response);
        $('#tableresult').html(sd);
      }
    });
  })
</script>
<script type="text/javascript">
  var i = 0;
  $("#add").click(function() {
    ++i;
    $("#dynamic_field").append('<tr class="input_fields_wrap_tc"><div id="append' + i + '"><td style="color:blue;" align="center" colspan="2"><label for="ltr_ctg_nm">Other :</label></td><td style="color:blue;" align="center"><input type="text" class="form-control persum" name="other_crg[]" id="other_crg' + i + '"  value="" placeholder="Charges"></td><td style="color:blue;" align="center"><input type="text" class="form-control persum" name="other_amt[]" id="other_amt' + i + '"  onkeypress="return ssd(this, event);" value="" placeholder="Amount"></td><td><button type="button" class="btn btn-danger remove-tr">X</button></td><td></td></div></tr>');

    $("#other_amt" + i).keyup(function() {
      ttlamnt();
    });
  });
  $(document).on('click', '.remove-tr', function() {
    $(".remove-tr").each(function() {
      var rmvval = $("#other_amt" + i).val();
      var test = document.getElementById('demo').value;
      var chkamt = document.getElementById('chkamt').value;
      var fin_amt = parseInt(test) - parseInt(rmvval);
      $("#demo").val(fin_amt);
      var fin_amt1 = parseInt(fin_amt) + parseInt(chkamt);
      $("#total_amt").val(fin_amt1);
    });
    $(this).parents('tr').remove();
  });
</script>

<script>
  $("#other_amt").keyup(function() {
    ttlamnt();
  });

  function ttlamnt() {
    var totalsum = 0;
    $(".persum").each(function() {
      totalsum += +$(this).val();
    });
    $("#demo").val(totalsum);
    var test = document.getElementById('demo').value;
    if (test == '') {
      var tstamt = 0;
    } else {
      var tstamt = test;
    }
    var chkamt = document.getElementById('chkamt').value;
    if (chkamt == '') {
      var chkamt1 = 0;
    } else {
      var chkamt1 = chkamt;
    }
    var fin_amt = parseFloat(tstamt) + parseFloat(chkamt1);
    $("#total_amt").val(fin_amt);
  }

  function ssd(txt, evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode == 46) {
      //Check if the text already contains the . character
      if (txt.value.indexOf('.') === -1) {
        return true;
      } else {
        return false;
      }
    } else {
      if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    }
    return true;
  }
</script>
<div class="row" style="margin-top: 20px;">
  <center>
    <h4 style="text-decoration: underline; font-weight: bold; color: #37909e;">LC Processing</h4>
  </center>
  <div class="col-lg-12">
    <div class="col-lg-4">
      <div class="form-group">
        <label for="org_id">LC No.</label>
        <select class="form-control select2" name="lcnumid" id="lcnumid">
          <option value="">-- Select LC No. --</option>
          <?php
          $tdatel = date('Y-m-d');
          if (isset($_GET['bimpid'])) {
            /*$orgdd = mysqli_query($con, "SELECT * FROM `fin_lce` WHERE `status`='1' AND `orgid`='$fthimps->orgnstn_id' ORDER BY `id` DESC");*/
            $orgdd = mysqli_query($con, "SELECT * FROM `fin_lce` WHERE aprv_status='2' AND `status`='1' ORDER BY `id` DESC");
            $total_results = mysqli_num_rows($orgdd);
            if ($total_results > 0) {
              while ($fthodd = mysqli_fetch_object($orgdd)) {
                echo "<option value='" . $fthodd->id . "'>" . $fthodd->lcnum . "</option>";
              }
            } else {
              echo "<option value=''>No Records Found</option>";
            }
          }
          ?>
        </select>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="form-group">
        <label for="org_id">Client</label>
        <input type="text" class="form-control" name="client" id="client" readonly>
      </div>
    </div>
  </div>
  <div class="col-lg-12">
    <div class="col-lg-4">
      <label for="type">Amount</label>
      <input type="text" class="form-control" name="amount" id="amount" readonly>
    </div>
    <div class="col-lg-4">
      <label for="type">Transaction Dt:</label>
      <input type="text" class="form-control" name="transc_dt" id="transc_dt" readonly>
    </div>
  </div>
  <div class="col-lg-12" style="margin-top: 10px;">
    <div class="form-group">
      <table class="table table-bordered" id="dynamic_field"> <!--  -->
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
              <input type="text" class="form-control persum" name="other_crg[]" id="other_crg" value="" placeholder="Charges">
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