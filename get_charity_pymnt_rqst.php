<?php include("../../config.php");setlocale(LC_MONETARY, 'en_IN'); ?>

<?php if(isset($_POST['org_id'])) {

$org_id = $_POST['org_id']; 

$yr_nm = $_POST['yr'];


        $check = mysqli_query($con,"SELECT p.*,od.*,p.id as charity_id
        FROM   prj_creditor p, fin_charity_details od
        WHERE p.group_subtype='109' AND p.cred_status = '1' AND p.id = od.creditor_id AND od.status = 1 AND p.id = $org_id AND od.to_date >= '$yr_nm' AND NOT EXISTS (SELECT * FROM fin_payment_request_charity ch WHERE od.creditor_id = ch.org_id);");

        $se = mysqli_num_rows($check);

        if($se > 0){

        ?>
  
 
    <!-- Append of irrcharity Details -->

<script type="text/javascript">

$(document).ready(function() {

  var max_fields      = 10; //Maximum input boxes allowed

  var wrapper         = $(".addLtrComm"); //Fields wrapper

  var add_button      = $("#AddLC"); //Add button ID

 

  var x = 1; //initlal text box count

  var y = 20; // for datepicker



  $(add_button).click(function(e){ //on add input button click

    e.preventDefault();

    if(x < max_fields){ //max input box allowed

      x++; //text box increment

  

      $(wrapper).append(`<div class="row" id="append6"><div class="col-lg-3"><div class="form-group"><label for="ltrcomm">Name of Person/Organization</label>
     
      <select name="org_id_irr[]" class="form-control org_id_append" data-org_id_append="`+x+`" required>
     
      <option value="">--Select--</option>

    <?php $orgn = mysqli_query($con,"SELECT p.*
    FROM   prj_creditor p, fin_charity_details od
    WHERE p.group_subtype='109' AND p.cred_status = '1' AND p.id = od.creditor_id AND od.status = 1 AND od.charity_type = 2 AND NOT EXISTS (SELECT * FROM fin_payment_request_charity ch WHERE od.creditor_id = ch.org_id);");

    while ($roworg = mysqli_fetch_object($orgn)) { 

        echo "<option value='" . $roworg->id ."'>" . $roworg->companynm."</option>";

     }?>            

      </select>
      </div></div>
      <div class="col-lg-2"><div class="form-group"><label for="commdt">Location</label><textarea class="form-control" name="" id="location_append`+x+`" disabled></textarea></div></div>
      <div class="col-lg-2"><div class="form-group"><label for="commdt">Month & Year</label><input type="text" name="year_irr[]" id="monthyear" class="form-control" value="<?php echo $_POST['yr']; ?>" disabled></div></div>
      <div class="col-lg-2"><div class="form-group"><label for="commdt">Charity Type</label><input type="text" name="charity[]" id="charity" class="form-control" value="Irregular" disabled></div></div>
      <div class="col-lg-2"><div class="form-group"><label for="commdt">Amount</label><input type="text" name="amount_irr[]" id="amount_price" class="form-control amount_price" onchange="updateTotal()" placeholder="Amount" autocomplete="off" required></div></div>
      <button class="btn btn-danger total_amount_remove" onclick="remove_amount()" id="remove_ld" style="margin-left: 15px; margin-top: 20px;">X</button></div>`);

    }

  });



  $(wrapper).on("click","#remove_ld", function(e){ //user click on remove text

    e.preventDefault(); 

    $(this).parent('#append6').remove(); x--;

  });

});

</script>

<!-- End of Append of irrcharity -->

<legend>

    <h6><strong style="color: #2bc59b;">Regular Charity Details</strong></h6>

</legend>

<div class="table-responsive">

    <table class="table table-bordered table-responsive">

        <thead>

            <tr>

            <th>Sl. No.</th>

<!-- <th><input type="checkbox" class="form-check-input" id="choose_rnt_code" name="choose_rnt_code"> Name</th> -->
<th> Name</th>

<th>Location</th>

<th>To Date - From Date</th>

<th>Charity Type</th>

<th>Charity Amount</th>


            </tr>

        </thead>

        <script>

            $(document).ready(function() {

                $('#choose_rnt_code').click(function() {

                    $('.rnt_code,.rnt_pymnt_dt,.client,.p_id,.rate').attr('disabled', false);

                    var cal_sum1 = 0;
                    var cal_sum = 0;
                    

                    $(this.form.elements).filter(':checkbox').prop('checked', this.checked);

                    if ($("#choose_rnt_code").is(":checked")) { 

                        $(".rate").each(function(){

                          var price = $('.amount_price').val();

                            cal_sum1 += +$(this).val();

                            cal_sum = parseInt(price)+cal_sum1; 

                        });

                        $(".ttl_rate").val(cal_sum.toFixed(2));
                    }else{

                        $(".ttl_rate").val('');
                        //var cal_sum = 0;

                    } 

               });

            });

        </script>

        <tbody>

            <?php 

                $org_id = $_POST['org_id']; 

                $yr_nm = $_POST['yr'];

                // $mnth_nm = $_POST['mnth_nm'];


                        $qry = mysqli_query($con,"SELECT p.*,od.*,p.id as charity_id
                        FROM   prj_creditor p, fin_charity_details od
                        WHERE p.group_subtype='109' AND p.cred_status = '1' AND p.id = od.creditor_id AND od.status = 1 AND p.id = $org_id AND od.to_date >= '$yr_nm' AND NOT EXISTS (SELECT * FROM fin_payment_request_charity ch WHERE od.creditor_id = ch.org_id);");

                        $i =1;

                        while ($fetch=mysqli_fetch_object($qry)){

                        ?>

                    <tr>

                           <td><?php echo $i; ?></td>

                        <td> <input type="checkbox" class="form-check-input" id="rnt_chk_bx<?php echo $i; ?>" name="rnt_chk_bx[]" value="<?php echo $fetch->amount; ?>"> <input type="hidden" class="form-control rnt_code" id="rnt_code<?php echo $i; ?>" name="rnt_code[]" value="<?php echo $fetch->id; ?>"  disabled><?php echo $fetch->companynm; ?></td>
                        <!-- <td>  <input type="hidden" class="form-control rnt_code" id="rnt_code<?php echo $i; ?>" name="rnt_code[]" value="<?php echo $fetch->id; ?>"  disabled><?php echo $fetch->companynm; ?></td> -->

                        <td><input type="hidden" class="form-control rnt_pymnt_dt" id="rnt_pymnt_dt<?php echo $i; ?>" name="rnt_pymnt_dt[]" value="<?php echo $fetch->bilcity; ?>"  disabled><?php echo $fetch->bilcity; ?></td>

                        <td><input type="hidden" readonly="" class="form-control client" name="client" id="client<?php echo $i; ?>" value="<?php echo $fetch->mnth_nm; ?>" disabled><?php echo $fetch->from_date; ?> => <?php echo $fetch->to_date; ?></td>

                        <td><input type="hidden" readonly="" class="form-control p_id" name="p_id" id="p_id<?php echo $i; ?>" value="<?php echo $fetch->charity_type; ?>" disabled><?php if(($fetch->charity_type) == 1){ echo "Regular Charity" ;}else if(($fetch->charity_type)== 2){echo "Irregular Charity" ;} ?></td>

                        <td><input type="hidden" readonly="" class="form-control rate" onload="myFunction()" name="rate" id="rate<?php echo $i; ?>" value="<?php echo $fetch->amount; ?>" disabled><?php echo $fetch->amount; ?></td>
                        <td><input type="hidden" readonly="" class="form-control rate" name="charity_id" id="charity_id"  value="<?php echo $fetch->id; ?>" readonly></td>

                    </tr>
                    <script>

$('#rnt_chk_bx<?php echo $i; ?>').change(function() {

    $("#choose_rnt_code"). removeAttr('checked');

    var total1 = 0;
    var total = 0;
    var total2 = 0;

    $(':checkbox:checked').each(function() {

    
    
    $('.amount_price').each(function() { total2 += parseFloat($(this).val()) || 0; });

      total1 = total1 +  +$(this).val();

      total = total1+ total2;

    });

    $(".ttl_rate").val(total.toFixed(2));

});     

</script>

 <script>
function updateTotal() {
    var total = 0;
    var total1 = 0;
    $('.amount_price').each(function() { total1 += parseFloat($(this).val()) || 0; });

    var price = $('.rate').val();

    var total = parseInt(price) + total1;

    $('#ttl_rate').val(total.toFixed(2));
}
function remove_amount() {
    var total = 0;
    var total1 = 0;

    var total_amount = $('#ttl_rate').val();
 
    $('.amount_price').each(function() { total1 = parseFloat($(this).val()) || 0; });

    var total = parseInt(total_amount) - total1;
    
    $('#ttl_rate').val(total.toFixed(2));
}

  </script>

<script>

$(document).ready(function(){

  $('#rnt_chk_bx<?php echo $i; ?>').click(function() {

    $('#rnt_code<?php echo $i; ?>,#rnt_pymnt_dt<?php echo $i; ?>,#client<?php echo $i; ?>,#p_id<?php echo $i; ?>,#sp_id<?php echo $i; ?>,#rate<?php echo $i; ?>').attr('disabled', !this.checked);

  });

});

</script>
                        <?php $i++; } 

              ?>

        </tbody>


    </table>


</div>
<button class="btn btn-primary" id="AddLC"><strong>ADD (Irregular Charity)</strong></button>
<br><br>
<div class="addLtrComm">

</div>
<div class="row">
<div class="col-12">
<div class="col-6">

</div>
<div class="3">

</div>
<div class="3">



</div>
</div>
</div>

<div class="row">
      <div class="col-lg-8"><div class="form-group">
      <label>Remarks</label>
      <textarea name="message" id="message"  class="form-control" rows="3" autocomplete="off" placeholder="Message" required=""></textarea>
    </div></div>
      <div class="col-lg-4"><div class="form-group" style="padding-top: 40px;">
      <label>Total Amount :</label>
      <input type="text" readonly="" class="ttl_rate" name="ttl_rate" id="ttl_rate" value="" style="border:none;">
      </div></div>
      </div>

      <script>

$(document).on('change', '.org_id_append', function(){
        var org_id = $(this).val();
        var org_id_append = $(this).data('org_id_append');  
console.log(org_id);
$.ajax({

  url:"payment_assign/charity_ajax.php", 

  data:{org_id : org_id},

  type:'POST',

  success:function(response) {              
      $("#location_append"+org_id_append).html(response);

  }

});

});
</script>
  <?php } 
  }
  ?>