<?php 
require_once('../../../auth.php'); 
require_once('../../../config.php'); ?>
<?php
if ($_POST['lcnumid'] != '') {
  $lcnumid = $_POST['lcnumid'];

  $sl = 1;

  $fin_lcasgn = mysqli_query($con, " SELECT * FROM `fin_lcasgn` WHERE lcnumid='$lcnumid' AND aprv_status='2' ");

  if ($fin_lcasgn->num_rows > 0) {
    while ($data_fin_lcasgn = mysqli_fetch_object($fin_lcasgn)) {

      $lcasgnid = $data_fin_lcasgn->id;

      $sqk = mysqli_query($con, "SELECT x.*, x.id as lcasgnid, y.`lcnumid`, y.`created_on`, y.`created_by`, z.`fullname` FROM `fin_lcasgn_dtls` AS x LEFT JOIN `fin_lcasgn` AS y ON x.`lcasgnid`=y.`id` LEFT JOIN `mstr_emp` AS z  ON y.`created_by`=z.`id` WHERE y.`lcnumid`='$lcnumid' AND x.`lcasgnid`='$lcasgnid' ORDER BY x.`id` DESC");

      $cntdt = mysqli_num_rows($sqk);
      if ($cntdt > 0) {
        // $sl = 1;
        while ($data = mysqli_fetch_object($sqk)) {
          $PO_uniq_id = $data->PO_uniq_id;
          $prj_dispatch_id = $data->prj_dispatch_id;
          $invcamnt = $data->invcamnt;
          $lcasgnid = $data->lcasgnid;

          $sqlquery = mysqli_query($con, "SELECT IPM.unique_id, IPM.po_no, Prj_dis.inv_no, Prj_dis.invc_dte FROM `prj_dispatch_initial_po_material` AS IPM LEFT JOIN `prj_dispatch` Prj_dis ON IPM.`unique_id`=Prj_dis.`unique_id` LEFT JOIN fin_lcasgn_dtls x ON x.PO_uniq_id = Prj_dis.unique_id WHERE IPM.unique_id='" . $PO_uniq_id . "' AND  Prj_dis.id='" . $prj_dispatch_id . "' AND x.id NOT IN ( SELECT inv_no FROM fin_payment_entry_lc_inv_charg ) ");


          $datda = mysqli_fetch_object($sqlquery);


          if ($sqlquery->num_rows > 0) {
            echo "<tr><td><input type='checkbox' name='chkinv[]' id='chkinv' value='" . $lcasgnid . "/" . $invcamnt . "'></td>";
            echo "<td>" . $sl++ . "</td>";
            echo "<td>" . $datda->inv_no . "</td>";
            echo "<td>" . $datda->invc_dte . "</td>";
            echo "<td>" . $invcamnt . "</td></tr>";
          } else {
            echo "<tr> <td colspan='4' style='color:red; text-align:center;'>NO INVOICE FOUND</td> </tr>";
          }
        }
      }
    }
  } else {
    echo "<tr> <td colspan='4' style='color:red; text-align:center;'>NO INVOICE FOUND</td> </tr>";
  }
}

?>
<script type="text/javascript">
  $('input:checkbox').change(function() {
    var total = 0;
    $('input:checkbox:checked').each(function() {
      var a = $(this).val();
      var b = a.split("/");
      total += parseFloat(b[1]);
    });


    $("#chkamt").val(total.toFixed(2));
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
    $("#total_amt").val(fin_amt.toFixed(2));
  });
</script>