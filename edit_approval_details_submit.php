
<?php 
  include("../../config.php");
?>
 <?php
    if (isset($_POST['id'])) {
      $prid = $_POST['id'];
      $splrqr = mysqli_query($con, "SELECT x.*,y.supplier_name,z.pname FROM `fin_payment_request_supplier` x, `prj_supplier` y, `prj_project` z WHERE x.`splrnm`=y.`id` AND x.`prjctnm`=z.`id` AND x.`payreq_id`='$prid'");
      $fthsplr = mysqli_fetch_object($splrqr);
    }
   $output .='<div class="table-responsive"><table class="table table-bordered"><thead><tr><th>Sl. No.</th><th>PO No.</th><th>Project</th><th>PO Amount</th><th>Request Amounts</th><th>Paid</th><th>Payment Pending</th><th>Inprocess Amount</th><th>Balance</th></tr></thead>';
   $po_nm = $fthsplr->po_num;
   $po_details = mysqli_query($con,"SELECT * FROM `prj_po_order` WHERE `status`='1' AND `po_no`='$po_nm'");
   $i = 1;
   $alltotal = 0;
   while($pr_ftch= mysqli_fetch_object($po_details)) {
     $gtpnm = mysqli_query($con, "SELECT * FROM `prj_project` WHERE `id`='$pr_ftch->prj_id'");
     $fthpnm = mysqli_fetch_object($gtpnm);
     $inprocessamount = mysqli_query($con, "SELECT SUM(final_req_amt) as sum_pay FROM fin_payment_request_supplier where po_num = '".$po_nm."' and `status`='1'");
     $processamt = mysqli_fetch_object($inprocessamount);
     $paidamount = mysqli_query($con, "SELECT SUM(pr_paid_amnt) as paid_sum FROM fin_payment_entry_supplier where ponum = '".$po_nm."' and `status`='1'");
     $paidamt = mysqli_fetch_object($paidamount);
     $poid = $pr_ftch->id;
     if($paidamt->paid_sum != ''){ $paidamount = $paidamt->paid_sum;}else{ $paidamount = "0.00";}
     if($paidamt->paid_sum != ''){ $pendingamt =  $processamt->sum_pay-$paidamt->paid_sum;}else{ $pendingamt =$processamt->sum_pay-'0.00';}
    $proces = $processamt->sum_pay - $paidamt->paid_sum; $process= number_format((float)$proces, 2, '.', '');
    $balanc = $pr_ftch->total_sum_all-$processamt->sum_pay; $balance = number_format((float)$balance, 2, '.', '');
    $output .='<tbody><tr><td>'.$i.'</td><td>'.$po_nm.'</td><td>'.$fthpnm->pname.'</td><td>'.$pr_ftch->total_sum_all.'</td><td>&#x20B9;'.$fthsplr->ttl_reqamt.'</td><td>&#x20B9;'.$paidamount.'</td><td>&#x20B9;'.$pendingamt.'</td><td>&#x20B9;'.$process.'</td><td>&#x20B9;'.$balance.'</td></tr></tbody>';
     $i++; unset($sum_ttl); }
      $output .='</table></div><form role="form" method="POST" action="" id="approval_section"><div class="col-lg-5 col-md-5 col-sm-6 col-xm-12"><div class="form-group"><label class="control-label">Request Amount</label><strong style="color:red;font-size: 10px;"></strong><input type="text" class="form-control input-lg" value="&#x20B9;'.$fthsplr->ttl_reqamt.'" readonly></div></div><div class="col-lg-5 col-md-5 col-sm-6 col-xm-12"><div class="form-group"><label class="control-label">New Request Amount</label><strong style="color:red;font-size: 10px;" id="new_request_amountmsg"></strong><strong style="color:red;font-size: 10px;"></strong><input type="number" class="form-control input-lg" name="new_request_amount" id="new_request_amount" place="Enter New Request Amount" autocomplete="off"></div></div><div class="col-lg-2 col-md-2 col-sm-6 col-xm-12"><div class="form-group"><div><button type="submit" class="btn btn-primary" style="margin-top: 26px;" id="new_payment_submit">Submit</button></div></div></div></form>';
   echo $output;
  ?>
  <script type="text/javascript">
     $('#new_payment_submit').click(function(e) { 
      var new_request_amount = $("#new_request_amount").val();
      if(new_request_amount == ''){
          $("#new_request_amountmsg").html("! Please Enter New Amount");
          $("#new_request_amountmsg").delay(4000).fadeOut();
          $('#new_request_amount').css("border","1px solid #ec1313");
          $('#new_request_amount').focus();
          return false;
      }else{
        alert();
        $.ajax({
               url:"payment_assign/payassign_submitpage.php",
               data:$("#paymentassignform").serialize(),//all form data
               type:'POST',
               success:function(response) {
                  if(response == 1){
                    alert('Successfully Assignd');
                    $('#paymentassignModal').hide();
                    setTimeout(function(){
                       window.location.reload();
                    }, 2000);
                  }else if(response == 2){
                    alert('Please Try Again');
                    location.reload();
                  }
               },
              error: function(jqXHR, textStatus, errorThrown) {
                 console.log(textStatus, errorThrown);
              }
            });
      }
    });
  </script>