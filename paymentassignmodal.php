<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />		
<!-- // Used For Auto Typing Search-->
<script type="text/javascript">
				$(document).ready(function () {
					$('#trnscto').selectize({
						sortField: 'text'
						});
				});
</script>
<style>
.modal-body { 
    max-height:500px; 
    overflow-y:auto;
}
</style>

<?php 
  include("../../config.php");
  if(isset($_POST['bankimportid']) && $_POST['bankimportid'] !=''){
    $bimpid = $_POST['bankimportid'];
    $dtlsqr = mysqli_query($con, "SELECT x.*,y.* FROM `fin_banking_imports` x, `fin_statement_preview` y WHERE x.`preview_id`=y.`id` AND x.`id`='$bimpid' AND y.`status`='1'");
    $fthimps = mysqli_fetch_object($dtlsqr);
    //organisation section
    $orgnid = $fthimps->orgnstn_id;
    $orgqr = mysqli_query($con, "SELECT * FROM `prj_organisation` WHERE `id`='$orgnid'");
    $fthorg = mysqli_fetch_object($orgqr);
    //bank details
    $bnkaccid = $fthimps->bnkacc_id;
    $bnkqr = mysqli_query($con, "SELECT * FROM `fin_bankaccount` WHERE `id`='$bnkaccid'");
    $fthbacc = mysqli_fetch_object($bnkqr);
  }
?>
<script type="text/javascript">
    $("#trnscto").change(function() {
       var trnscto = $("#trnscto").val();
       var trnsctn_typ = $("#trnsc_type").val(); //transaction type like credit or debit
       var paidamt = $("#paidamt").val(); //payment amount
       var pay_bnkacc = $("#pay_bnkacc").val(); //bank account id
       var pay_orgnstn = $("#pay_orgnstn").val(); //Organisation
       var bankiportid = $("#bimpid").val(); //bank file import id
        if(trnscto == "vendor" || trnscto == "supplier" || trnscto == "transporter" || trnscto == "gst" || trnscto == "withdraw" || trnscto == "collection" || trnscto == "expense" || trnscto == "rent" || trnscto == "dd" || trnscto == "fd" || trnscto == "cheque" || trnscto == "salary_advance" || trnscto == "loan_advance" || trnscto == "loan_assignment" || trnscto == "asset_finance" ||trnscto == "lc_processing" || trnscto == "salary_processing" || trnscto == "bank_transfer" || trnscto == "operator" || trnscto == "others") {
          $.ajax({
               url:"<?php echo SITE_URL; ?>/basic/finance/payment_assign/payassign_ajaxpage.php",
               data:{trnscto:trnscto,trnsctn_typ:trnsctn_typ,paidamt:paidamt,pay_bnkacc:pay_bnkacc,pay_orgnstn:pay_orgnstn,bankiportid:bankiportid},
               type:'POST',
               success:function(response) {
                  var resp = $.trim(response);
                  $("#showPForm").html(resp);
               },
              error: function(jqXHR, textStatus, errorThrown) {
                 console.log(textStatus, errorThrown);
              }
          });
        }
    });
    // payment submit section
    $('#payasgn').click(function(e) { 
      var pay_orgnstn = $("#pay_orgnstn").val();
      var trnscto = $("#trnscto").val();
      if(pay_orgnstn == ''){
          $("#pay_orgnstnmsg").html("! Please Select Tender");
          $("#errorpay_orgnstn").show().delay(2000).fadeOut();
          $('#pay_orgnstn').css("border","1px solid #ec1313");
          $('#pay_orgnstn').focus();
          return false;
      }else if(trnscto == '') {
          $("#trnsctomsg").html("! Please Select Transaction To");
          $("#trnsctomsg").delay(2000).fadeOut();
          $('#trnscto').css("border","1px solid #ec1313");
          $('#trnscto').focus();
          return false;
      }else if(trnscto != ''){
        if(trnscto == 'supplier'){
          var suplrnm = $("#suplrnm").val();
          var prj_name = $("#prj_name").val();
          var ponum = $("#ponum").val();
          var trnsc_type = $("#trnsc_type").val();
          var spreq_typ = $("#spreq_typ").val();
          var pr_numbr = $("#pr_numbr").val();
          if(suplrnm =='') {
            $("#suplrnmmsg").html("! Pick Supplier Name");
            $("#suplrnmmsg").delay(4000).fadeOut();
            $('#suplrnm').css("border","1px solid #ec1313");
            $('#suplrnm').focus();
            return false;
          }else if (prj_name =='') {
            $("#prj_namemsg").html("! Select Project Name");
            $("#prj_namemsg").delay(4000).fadeOut();
            $('#prj_name').css("border","1px solid #ec1313");
            $('#prj_name').focus();
            return false;
          }else if (ponum =='') {
            $("#ponummsg").html("! Select PO Number");
            $("#ponummsg").delay(4000).fadeOut();
            $('#ponum').css("border","1px solid #ec1313");
            $('#ponum').focus();
            return false;
          }else if(trnsc_type != "Credit" && spreq_typ == ''){
            $("#spreq_typmsg").html("! Select Request Type");
            $("#spreq_typmsg").delay(4000).fadeOut();
            $('#spreq_typ').css("border","1px solid #ec1313");
            $('#spreq_typ').focus();
            return false;
          }else if(trnsc_type != "Credit" && pr_numbr == ''){
            $("#pr_numbrmsg").html("! Select Pr Number");
            $("#pr_numbrmsg").delay(4000).fadeOut();
            $('#pr_numbr').css("border","1px solid #ec1313");
            $('#pr_numbr').focus();
            return false;
          }else {
            $.ajax({
               url:"<?php echo SITE_URL; ?>/basic/finance/payment_assign/payassign_submitpage.php",
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
        }
        else if(trnscto == 'vendor'){
          var vendornm = $("#vndrnm").val();
          var prjnm = $("#prjct_name").val();
          var jobodrnum = $("#jobodr_num").val();
          var subprjct_nm = $("#subprjct_nm").val();
          var bmsnm = $("#bmsnm").val();
          var wrk_dscrptn = $("#wrk_dscrptn").val();
          var subprjct_val = $("#subprjct_val").val();
          if(vendornm =='') {
            $("#vndrnmmsg").html("! Pick Vendor Name");
            $("#vndrnmmsg").delay(4000).fadeOut();
            $('#vndrnm').css("border","1px solid #ec1313");
            $('#vndrnm').focus();
            return false;
          }else if (prjnm =='') {
            $("#prjct_namemsg").html("! Pick Project Name");
            $("#prjct_namemsg").delay(4000).fadeOut();
            $('#prjct_name').css("border","1px solid #ec1313");
            $('#prjct_name').focus();
            return false;
          }else if (jobodrnum =='') {
            $("#jobodr_nummsg").html("! Pick Job Order");
            $("#jobodr_nummsg").delay(4000).fadeOut();
            $('#jobodr_num').css("border","1px solid #ec1313");
            $('#jobodr_num').focus();
            return false;
          }else if (jobodrnum !='' && subprjct_nm =='') {
            $("#subprjct_nmmsg").html("! Pick Sub Project");
            $("#subprjct_nmmsg").delay(4000).fadeOut();
            $('#subprjct_nm').css("border","1px solid #ec1313");
            $('#subprjct_nm').focus();
            return false;
          }else if (jobodrnum !='' && bmsnm =='') {
            $("#bmsnmmsg").html("! Pick BMS");
            $("#bmsnmmsg").delay(4000).fadeOut();
            $('#bmsnm').css("border","1px solid #ec1313");
            $('#bmsnm').focus();
            return false;
          }else if (jobodrnum !='' && wrk_dscrptn =='') {
            $("#wrk_dscrptnmsg").html("! Request Amount Is Required");
            $("#wrk_dscrptnmsg").delay(4000).fadeOut();
            $('#wrk_dscrptn').css("border","1px solid #ec1313");
            $('#wrk_dscrptn').focus();
            return false;
          }else if (jobodrnum !='' && subprjct_val =='') {
            $("#subprjct_valmsg").html("! Pick BMS");
            $("#subprjct_valmsg").delay(4000).fadeOut();
            $('#subprjct_val').css("border","1px solid #ec1313");
            $('#subprjct_val').focus();
            return false;
          }else {
            $.ajax({
               url:"<?php echo SITE_URL; ?>/basic/finance/payment_assign/payassign_submitpage.php",
               data:$("#paymentassignform").serialize(),
               type:'POST',
               success:function(response) {
                  if(response == 1){
                    alert('Successfully Assignd');
                    location.reload();
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
        }
        else if(trnscto == 'transporter'){
          var trnsprtrnm = $("#trnsprtrnm").val();
          var prjctnm = $("#prjctnm").val();
          var place_from = $("#place_from").val();
          var place_to = $("#place_to").val();
          var distance = $("#distance").val();
          var material_nm = $("#material_nm").val();
          var mtrl_weight = $("#mtrl_weight").val();
          var service_typ = $("#service_typ").val();
          var lry_model = $("#lry_model").val();
          var carrycap = $("#carrycap").val();
          var totalamnt = $("#totalamnt").val();
          if(trnsprtrnm =='') {
            $('#payreqfor').css("border","1px solid #D3D3D3");
            $('#trnsprtrnm').css("border","2px solid #ec1313");
            alert("Pick The Transporter Name");
            $('#trnsprtrnm').focus();
            return false;
          }else if (prjctnm =='') {
            $('#payreqfor, #trnsprtrnm').css("border","1px solid #D3D3D3");
            $('#prjctnm').css("border","2px solid #ec1313");
            alert("Pick A Project Name");
            $('#prjctnm').focus();
            return false;
          }else if (place_from =='') {
            $('#payreqfor, #trnsprtrnm, #prjctnm').css("border","1px solid #D3D3D3");
            $('#place_from').css("border","2px solid #ec1313");
            alert("Mention The Source Place Name");
            $('#place_from').focus();
            return false;
          }else if (place_to =='') {
            $('#payreqfor, #trnsprtrnm, #prjctnm, #place_from').css("border","1px solid #D3D3D3");
            $('#place_to').css("border","2px solid #ec1313");
            alert("Mention The Destination Place Name");
            $('#place_to').focus();
            return false;
          }else if (distance =='') {
            $('#payreqfor, #trnsprtrnm, #prjctnm, #place_from, #place_to').css("border","1px solid #D3D3D3");
            $('#distance').css("border","2px solid #ec1313");
            alert("Mention Total distance");
            $('#distance').focus();
            return false;
          }else if (material_nm =='') {
            $('#payreqfor, #trnsprtrnm, #prjctnm, #place_from, #place_to, #distance').css("border","1px solid #D3D3D3");
            $('#material_nm').css("border","2px solid #ec1313");
            alert("Mention The material_nm Name");
            $('#material_nm').focus();
            return false;
          }else if (mtrl_weight =='') {
            $('#payreqfor, #trnsprtrnm, #prjctnm, #place_from, #place_to, #distance, #material_nm').css("border","1px solid #D3D3D3");
            $('#mtrl_weight').css("border","2px solid #ec1313");
            alert("Provide material_nm Weight");
            $('#mtrl_weight').focus();
            return false;
          }else if (service_typ =='') {
            $('#payreqfor, #trnsprtrnm, #prjctnm, #place_from, #place_to, #distance, #material_nm, #mtrl_weight').css("border","1px solid #D3D3D3");
            $('#service_typ').css("border","2px solid #ec1313");
            alert("Select Service Type");
            $('#service_typ').focus();
            return false;
          }else if (lry_model =='') {
            $('#payreqfor, #trnsprtrnm, #prjctnm, #place_from, #place_to, #distance, #material_nm, #mtrl_weight, #service_typ').css("border","1px solid #D3D3D3");
            $('#lry_model').css("border","2px solid #ec1313");
            alert("Mention The Lorry Model");
            $('#lry_model').focus();
            return false;
          }else if (carrycap =='') {
            $('#payreqfor, #trnsprtrnm, #prjctnm, #place_from, #place_to, #distance, #material_nm, #mtrl_weight, #service_typ, #lry_model').css("border","1px solid #D3D3D3");
            $('#carrycap').css("border","2px solid #ec1313");
            alert("Mention The Lorry Carrying Capacity");
            $('#carrycap').focus();
            return false;
          }else if (totalamnt =='') {
            $('#payreqfor, #trnsprtrnm, #prjctnm, #place_from, #place_to, #distance, #material_nm, #mtrl_weight, #service_typ, #lry_model, #carrycap').css("border","1px solid #D3D3D3");
            $('#totalamnt').css("border","2px solid #ec1313");
            alert("Mention The Total totalamnt");
            $('#totalamnt').focus();
            return false;
          }else if (adv_prcnt =='') {
            $('#payreqfor, #trnsprtrnm, #prjctnm, #place_from, #place_to, #distance, #material_nm, #mtrl_weight, #service_typ, #lry_model, #carrycap, #totalamnt').css("border","1px solid #D3D3D3");
            $('#adv_prcnt').css("border","2px solid #ec1313");
            alert("Mention The Advance Percentage");
            $('#adv_prcnt').focus();
            return false;
          }else if (trns_req_amt =='') {
            $('#payreqfor, #trnsprtrnm, #prjctnm, #place_from, #place_to, #distance, #material_nm, #mtrl_weight, #service_typ, #lry_model, #carrycap, #totalamnt, #adv_prcnt').css("border","1px solid #D3D3D3");
            $('#trns_req_amt').css("border","2px solid #ec1313");
            alert("Mention The Request totalamnt");
            $('#trns_req_amt').focus();
            return false;
          }else {
            $.ajax({
               url:"<?php echo SITE_URL; ?>/basic/finance/payment_assign/payassign_submitpage.php",
               data:$("#paymentassignform").serialize(),
               type:'POST',
               success:function(response) {
                  if(response == 1){
                    alert('Successfully Assignd');
                    location.reload();
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
        }
        else if(trnscto == 'gst'){
            var organisation = $("#organisation").val();
            var state_nm = $("#state_nm").val();
            var gstnum = $("#gstnum").val();
            var fromdate = $("#fromdate").val();
            var todate = $("#todate").val();
            if(organisation =='') {
              $("#organisationmsg").html("! Select Organisation");
              $("#organisationmsg").delay(4000).fadeOut();
              $('#organisation').css("border","1px solid #ec1313");
              $('#organisation').focus();
              return false;
            }else if(state_nm =='') {
              $("#state_nmmsg").html("! Select State");
              $("#state_nmmsg").delay(4000).fadeOut();
              $('#state_nm').css("border","1px solid #ec1313");
              $('#state_nm').focus();
              return false;
            }else if(gstnum =='') {
                $("#gstnummsg").html("! GST Number Is Required");
                $("#gstnummsg").delay(4000).fadeOut();
                $('#gstnum').css("border","1px solid #ec1313");
                $('#gstnum').focus();
                return false;
            }else if(fromdate =='') {
                $("#fromdatemsg").html("! Pick The From Date");
                $("#fromdatemsg").delay(4000).fadeOut();
                $('#fromdate').css("border","1px solid #ec1313");
                $('#fromdate').focus();
                return false;
            }else if(todate =='') {
                $("#todatemsg").html("! Pick The To Date");
                $("#todatemsg").delay(4000).fadeOut();
                $('#todate').css("border","1px solid #ec1313");
                $('#todate').focus();
                return false;
            }else {
                $.ajax({
                   url:"<?php echo SITE_URL; ?>/basic/finance/payment_assign/payassign_submitpage.php",
                   data:$("#paymentassignform").serialize(),
                   type:'POST',
                   success:function(response) {
                      if(response == 1){
                        alert('Successfully Assignd');
                        location.reload();
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
        }
        else if(trnscto == 'withdraw'){
          var wdrawer_nm = $("#wdrawer_nm").val();
          if(wdrawer_nm =='') {
            $("#wdrawer_nmmsg").html("! Select Owner's Name");
            $("#wdrawer_nmmsg").delay(4000).fadeOut();
            $('#wdrawer_nm').css("border","1px solid #ec1313");
            $('#wdrawer_nm').focus();
            return false;
          }else {
            $.ajax({
               url:"<?php echo SITE_URL; ?>/basic/finance/payment_assign/payassign_submitpage.php",
               data:$("#paymentassignform").serialize(),
               type:'POST',
               success:function(response) {
                  if(response == 1){
                    alert('Successfully Assignd');
                    location.reload();
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
        }
        else if(trnscto == 'collection'){
          var debtor_typ = $("#debtor_typ").val();
          var clientnm = $("#clientnm").val();
          if(debtor_typ =='') {
            $("#debtor_typmsg").html("! Select Debtor Type");
            $("#debtor_typmsg").delay(4000).fadeOut();
            $('#debtor_typ').css("border","1px solid #ec1313");
            $('#debtor_typ').focus();
            return false;
          }else if(clientnm =='') {
            $("#clientnmmsg").html("! Select Client Name");
            $("#clientnmmsg").delay(4000).fadeOut();
            $('#clientnm').css("border","1px solid #ec1313");
            $('#clientnm').focus();
            return false;
          }else {
            $.ajax({
                 url:"<?php echo SITE_URL; ?>/basic/finance/payment_assign/payassign_submitpage.php",
                 data:$("#paymentassignform").serialize(),
                 type:'POST',
                 success:function(response) {
                    if(response == 1){
                      alert('Successfully Assignd');
                      location.reload();
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
        }
        else if(trnscto == 'expense'){
          var expns_for = $("#expns_for").val();
          var prjct = $("#prjct").val();
          var sub_prjct = $("#sub_prjct").val();
          var bmsnm = $("#bmsnm").val();
          if(expns_for =='') {
            $("#expns_formsg").html("! Pick Employee Name");
            $("#expns_formsg").delay(4000).fadeOut();
            $('#expns_for').css("border","1px solid #ec1313");
            $('#expns_for').focus();
            return false;
          }else if(prjct =='') {
            $("#prjctmsg").html("! Pick Project Name");
            $("#prjctmsg").delay(4000).fadeOut();
            $('#prjct').css("border","1px solid #ec1313");
            $('#prjct').focus();
            return false;
          }if(sub_prjct =='') {
            $("#sub_prjctmsg").html("! Pick Sub Project Name");
            $("#sub_prjctmsg").delay(4000).fadeOut();
            $('#sub_prjct').css("border","1px solid #ec1313");
            $('#sub_prjct').focus();
            return false;
          }if(bmsnm =='') {
            $("#bmsnmmsg").html("! Pick BMS");
            $("#bmsnmmsg").delay(4000).fadeOut();
            $('#bmsnm').css("border","1px solid #ec1313");
            $('#bmsnm').focus();
            return false;
          }else {
            $.ajax({
               url:"<?php echo SITE_URL; ?>/basic/finance/payment_assign/payassign_submitpage.php",
               data:$("#paymentassignform").serialize(),
               type:'POST',
               success:function(response) {
                  if(response == 1){
                    alert('Successfully Assignd');
                    location.reload();
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
        }
        else if(trnscto == 'rent'){
          var org_id = $("#org_id").val();
          var year = $("#year").val();
          var month = $("#month").val();
          var type = $("#type").val();
          var purpose = $("#purpose").val();
          if(org_id == ''){
              $("#org_idmsg").html("! Select Organization");
              $("#org_idmsg").delay(4000).fadeOut();
              $('#org_id').css("border","1px solid #ec1313");
              $('#org_id').focus();
              return false;
          }else if(year == ''){
              $("#yearmsg").html("! Select Year");
              $("#yearmsg").delay(4000).fadeOut();
              $('#year').css("border","1px solid #ec1313");
              $('#year').focus();
              return false;
          }else if(month == ''){
              $("#monthmsg").html("! Select Month");
              $("#monthmsg").delay(4000).fadeOut();
              $('#month').css("border","1px solid #ec1313");
              $('#month').focus();
              return false;
          }else if(type == ""){
              $("#typemsg").html("! Select Type");
              $("#typemsg").delay(4000).fadeOut();
              $('#type').css("border","1px solid #ec1313");
              $('#type').focus();
              return false;
          }else if(purpose == ""){
            $("#purposemsg").html("! Select Purpose Of Use.");
            $("#purposemsg").delay(4000).fadeOut();
            $('#purpose').css("border","1px solid #ec1313");
            $('#purpose').focus();
            return false;
          }else if($('input[type=checkbox]:checked').length == 0) {
            $("#rentbindmsg").html("! Please Select Atleast One Rent.");
            $("#rentbindmsg").delay(4000).fadeOut();
            return false;
        }else {
            $.ajax({
               url:"<?php echo SITE_URL; ?>/basic/finance/payment_assign/payassign_submitpage.php",
               data:$("#paymentassignform").serialize(),
               type:'POST',
               success:function(response) {
                  if(response == 1){
                    alert('Successfully Assignd');
                    location.reload();
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

        }
        else if(trnscto == 'dd'){
          var ddno = $("#ddno").val();
          var ddexprsn = $("#ddexprsn").val();
          var ddbenificiary = $("#ddbenificiary").val();
          var ddmessage = $("#ddmessage").val();
          if(ddno == '') {
            $("#ddnomsg").html("! Select DD No");
            $("#ddnomsg").delay(4000).fadeOut();
            $('#ddno').css("border","1px solid #ec1313");
            $('#ddno').focus();
            return false;
          }else if(ddexprsn == '') {
            $("#ddexprsnmsg").html("! Select Expense Reasons");
            $("#ddexprsnmsg").delay(4000).fadeOut();
            $('#ddexprsn').css("border","1px solid #ec1313");
            $('#ddexprsn').focus();
            return false;
          }else if(ddbenificiary == '') {
            $("#ddbenificiarymsg").html("! Select Benificiary");
            $("#ddbenificiarymsg").delay(4000).fadeOut();
            $('#ddbenificiary').css("border","1px solid #ec1313");
            $('#ddbenificiary').focus();
            return false;
          }else if(ddmessage == '') {
            $("#ddmessagemsg").html("! Enter Message");
            $("#ddmessagemsg").delay(4000).fadeOut();
            $('#ddmessage').css("border","1px solid #ec1313");
            $('#ddmessage').focus();
            return false;
          }else{
            $.ajax({
               url:"<?php echo SITE_URL; ?>/basic/finance/payment_assign/payassign_submitpage.php",
               data:$("#paymentassignform").serialize(),
               type:'POST',
               success:function(response) {
                  if(response == 1){
                    alert('Successfully Assignd');
                    location.reload();
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

        }
        else if(trnscto == 'fd'){
          var fdno = $("#fdno").val();
          var fdpurpose = $("#fdpurpose").val();
          var fdmessage = $("#fdmessage").val();
          if(fdno == '') {
            $("#fdnomsg").html("! Select FD No");
            $("#fdnomsg").delay(4000).fadeOut();
            $('#fdno').css("border","1px solid #ec1313");
            $('#fdno').focus();
            return false;
          }else if(fdpurpose == '') {
            $("#fdpurposemsg").html("! Select Purpose");
            $("#fdpurposemsg").delay(4000).fadeOut();
            $('#fdpurpose').css("border","1px solid #ec1313");
            $('#fdpurpose').focus();
            return false;
          }else if(fdmessage == '') {
            $("#fdmessagemsg").html("! Enter Message");
            $("#fdmessagemsg").delay(4000).fadeOut();
            $('#fdmessage').css("border","1px solid #ec1313");
            $('#fdmessage').focus();
            return false;
          }else{
            $.ajax({
               url:"<?php echo SITE_URL; ?>/basic/finance/payment_assign/payassign_submitpage.php",
               data:$("#paymentassignform").serialize(),
               type:'POST',
               success:function(response) {
                  if(response == 1){
                    alert('Successfully Assignd');
                    location.reload();
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
        }
        else if(trnscto == 'cheque'){
          var chqno = $("#chqno").val();
          var chqclient = $("#chqclient").val();
          var chqmessage = $("#chqmessage").val();
          if(chqno == '') {
            $("#chqnomsg").html("! Select Cheque No.");
            $("#chqnomsg").delay(4000).fadeOut();
            $('#chqno').css("border","1px solid #ec1313");
            $('#chqno').focus();
            return false;
          }else if(chqclient == '') {
            $("#chqclientmsg").html("! Select Client");
            $("#chqclientmsg").delay(4000).fadeOut();
            $('#chqclient').css("border","1px solid #ec1313");
            $('#chqclient').focus();
            return false;
          }else if(chqmessage == '') {
            $("#chqmessagemsg").html("! Enter Message");
            $("#chqmessagemsg").delay(4000).fadeOut();
            $('#chqmessage').css("border","1px solid #ec1313");
            $('#chqmessage').focus();
            return false;
          }else{
            $.ajax({
               url:"<?php echo SITE_URL; ?>/basic/finance/payment_assign/payassign_submitpage.php",
               data:$("#paymentassignform").serialize(),
               type:'POST',
               success:function(response) {
                  if(response == 1){
                    alert('Successfully Assignd');
                    location.reload();
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
        }
        else if(trnscto == 'salary_advance'){
          var benif_acc = $("#benif_acc").val();
          var esa_id = $("#esa_id").val();
          var sa_remarks = $("#sa_remarks").val();
          if(benif_acc == '') {
            $("#benif_accmsg").html("! Select Benificiary A/c");
            $("#benif_accmsg").delay(4000).fadeOut();
            $('#benif_acc').css("border","1px solid #ec1313");
            $('#benif_acc').focus();
            return false;
          }else if(esa_id == '') {
            $("#esa_idmsg").html("! Select ESA ID");
            $("#esa_idmsg").delay(4000).fadeOut();
            $('#esa_id').css("border","1px solid #ec1313");
            $('#esa_id').focus();
            return false;
          }else if(sa_remarks == '') {
            $("#sa_remarksmsg").html("! Enter Remarks");
            $("#sa_remarksmsg").delay(4000).fadeOut();
            $('#sa_remarks').css("border","1px solid #ec1313");
            $('#sa_remarks').focus();
            return false;
          }else{
            $.ajax({
               url:"<?php echo SITE_URL; ?>/basic/finance/payment_assign/payassign_submitpage.php",
               data:$("#paymentassignform").serialize(),
               type:'POST',
               success:function(response) {
                  if(response == 1){
                    alert('Successfully Assignd');
                    location.reload();
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
        }
        else if(trnscto == 'loan_advance'){
          var benif_acc = $("#loan_benif_acc").val();
          var loan_id = $("#loan_id").val();
          var la_remarks = $("#la_remarks").val();
          if(benif_acc == '') {
            $("#benif_accmsg").html("Select Benificiary A/c");
            $("#benif_accmsg").delay(4000).fadeOut();
            $('#loan_benif_acc').css("border","1px solid #ec1313");
            $('#loan_benif_acc').focus();
            return false;
          }else if(loan_id == '') {
            $("#loan_idmsg").html("! Select Loan ID");
            $("#loan_idmsg").delay(4000).fadeOut();
            $('#loan_id').css("border","1px solid #ec1313");
            $('#loan_id').focus();
            return false;
          }else if(la_remarks == '') {
            $("#la_remarksmsg").html("! Enter Remarks");
            $("#la_remarksmsg").delay(4000).fadeOut();
            $('#la_remarks').css("border","1px solid #ec1313");
            $('#la_remarks').focus();
            return false;
          }else{
            $.ajax({
               url:"<?php echo SITE_URL; ?>/basic/finance/payment_assign/payassign_submitpage.php",
               data:$("#paymentassignform").serialize(),
               type:'POST',
               success:function(response) {
                  if(response == 1){
                    alert('Successfully Assignd');
                    location.reload();
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
        }
        else if(trnscto == 'loan_assignment'){
          var account_no = $("#account_no").val();
          var refno = $("#refno").val();
          var nbfcname = $("#nbfcname").val();
          var typeid = $("#typeid").val();
          var paidamt = $("#paidamt").val();
          var total_amt_emi = $("#total_amt_emi").val();
          var total_amt_cash = $("#total_amt_cash").val();
          var total_amt_oth = $("#total_amt_oth").val();
          if(account_no == '') {
            $("#account_nomsg").html("! Select Account No.");
            $("#account_nomsg").delay(4000).fadeOut();
            $('#account_no').css("border","1px solid #ec1313");
            $('#account_no').focus();
            return false;
          }else if(refno == '') {
            $("#refnomsg").html("! Select Loan Ref No.");
            $("#refnomsg").delay(4000).fadeOut();
            $('#refno').css("border","1px solid #ec1313");
            $('#refno').focus();
            return false;
          }else if(nbfcname == '') {
             $("#nbfcnamemsg").html("! Select Institution Name");
            $("#nbfcnamemsg").delay(4000).fadeOut();
            $('#nbfcname').css("border","1px solid #ec1313");
            $('#nbfcname').focus();
            return false;
          }else if(typeid == '') {
            $("#typeidmsg").html("! Select Type");
            $("#typeidmsg").delay(4000).fadeOut();
            $('#typeid').css("border","1px solid #ec1313");
            $('#typeid').focus();
            return false;
          }else if(typeid != '') {
            if (typeid=="EMI") {
                if(paidamt >= total_amt_emi) {
                    $('#chqno').css("border","2px solid #ec1313");
                    alert("Total Amount should be equal or less than approved amount");
                    $('#chqno').focus();
                    return false;
                }
            }
            if (typeid=="Cash") {
                if(paidamt >= total_amt_cash) {
                    $('#chqno').css("border","2px solid #ec1313");
                    alert("Total Amount should be equal or less than approved amount");
                    $('#chqno').focus();
                    return false;
                }
            }
            if (typeid=="Others") {
                if(paidamt >= total_amt_oth) {
                    $('#chqno').css("border","2px solid #ec1313");
                    alert("Total Amount should be equal or less than approved amount");
                    $('#chqno').focus();
                    return false;
                }
            }
          }else{
            $.ajax({
               url:"<?php echo SITE_URL; ?>/basic/finance/payment_assign/payassign_submitpage.php",
               data:$("#paymentassignform").serialize(),
               type:'POST',
               success:function(response) {
                  if(response == 1){
                    alert('Successfully Assignd');
                    location.reload();
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
        }
        else if(trnscto == 'asset_finance'){
          var benif_acc = $("#benif_acc").val();
          var af_id = $("#af_id").val();
          var af_remarks = $("#af_remarks").val();
          if(benif_acc == '') {
            $("#benif_accmsg").html("! Select Benificiary A/c.");
            $("#benif_accmsg").delay(4000).fadeOut();
            $('#benif_acc').css("border","1px solid #ec1313");
            $('#benif_acc').focus();
            return false;
          }if(af_id == '') {
            $("#af_idmsg").html("! Select AF ID.");
            $("#af_idmsg").delay(4000).fadeOut();
            $('#af_id').css("border","1px solid #ec1313");
            $('#af_id').focus();
            return false;
          }else if(af_remarks == '') {
            $("#af_remarksmsg").html("! Enter Remarks.");
            $("#af_remarksmsg").delay(4000).fadeOut();
            $('#af_remarks').css("border","1px solid #ec1313");
            $('#af_remarks').focus();
            return false;
          }else{
            $.ajax({
               url:"<?php echo SITE_URL; ?>/basic/finance/payment_assign/payassign_submitpage.php",
               data:$("#paymentassignform").serialize(),
               type:'POST',
               success:function(response) {
                  if(response == 1){
                    alert('Successfully Assignd');
                    location.reload();
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
        }
        else if(trnscto == 'lc_processing'){
          var error=0;
          var numberOfChecked = $('input:checkbox:checked').length;
          var total_amt = $('#total_amt').val();
          var paidamt = $('#paidamt').val();
          if ( $('#lcnumid').val()=='' ) 
          {
            error += 1;
            $("#lcnumidmsg").html("! Select LC Number.");
            $("#lcnumidmsg").delay(4000).fadeOut();
            $('#lcnumid').css("border","1px solid #ec1313");
            $('#lcnumid').focus();
            return false;
          }
          else
          {
            $('#lcnumid').css("border","1px solid green");
          }
            
          if ( numberOfChecked==0 ) 
          {
            error += 1;
            $('input[type="checkbox"]').css("border","1px solid red");
          }

          if ( parseFloat(total_amt)!=parseFloat(paidamt) ) 
          {
             error += 1;
            $('#total_amt').css("color","red");
            $('#paidamt').css("color","red");
          }
          if(error > 0)
          {
            return false; 
          }else{
            $.ajax({
               url:"<?php echo SITE_URL; ?>/basic/finance/payment_assign/payassign_submitpage.php",
               data:$("#paymentassignform").serialize(),
               type:'POST',
               success:function(response) {
                  if(response == 1){
                    alert('Successfully Assignd');
                    location.reload();
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
        }
        else if(trnscto == 'salary_processing'){
          var year = $("#year").val();
          var req_id = $("#req_id").val();
          var sp_remarks = $("#sp_remarks").val();
          if(year == '') {
            $("#yearmsg").html("! Select Year.");
            $("#yearmsg").delay(4000).fadeOut();
            $('#year').css("border","1px solid #ec1313");
            $('#year').focus();
            return false;
          }else if(req_id == '') {
            $("#refnomsg").html("! Request Id Is Required.");
            $("#refnomsg").delay(4000).fadeOut();
            $('#refno').css("border","1px solid #ec1313");
            $('#refno').focus();
            return false;
          }else if(sp_remarks == '') {
             $("#sp_remarksmsg").html("! Message Is Required");
            $("#sp_remarksmsg").delay(4000).fadeOut();
            $('#sp_remarks').css("border","1px solid #ec1313");
            $('#sp_remarks').focus();
            return false;
          }else{
            $.ajax({
               url:"<?php echo SITE_URL; ?>/basic/finance/payment_assign/payassign_submitpage.php",
               data:$("#paymentassignform").serialize(),
               type:'POST',
               success:function(response) {
                  if(response == 1){
                    alert('Successfully Assignd');
                    location.reload();
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
        }
        else if(trnscto == 'bank_transfer'){
          var org_nm = $("#org_nm").val();
          var bnkaccnt = $("#bnkaccnt").val();
          var bnktrn_remarks = $("#bnktrn_remarks").val();
          if(org_nm == '') {
            $("#org_nmmsg").html("Select Organisation");
            $("#org_nmmsg").delay(4000).fadeOut();
            $('#org_nm').css("border","1px solid #ec1313");
            $('#org_nm').focus();
            return false;
          }else if(bnkaccnt == '') {
            $("#bnkaccntmsg").html("Select Bank Allias Name");
            $("#bnkaccntmsg").delay(4000).fadeOut();
            $('#bnkaccnt').css("border","1px solid #ec1313");
            $('#bnkaccnt').focus();
            return false;
          }else if(bnktrn_remarks == '') {
            $("#bnktrn_remarksmsg").html("Enter Message");
            $("#bnktrn_remarksmsg").delay(4000).fadeOut();
            $('#bnktrn_remarks').css("border","1px solid #ec1313");
            $('#bnktrn_remarks').focus();
            return false;
          }else{
            $.ajax({
               url:"<?php echo SITE_URL; ?>/basic/finance/payment_assign/payassign_submitpage.php",
               data:$("#paymentassignform").serialize(),
               type:'POST',
               success:function(response) {
                  if(response == 1){
                    alert('Successfully Assignd');
                    location.reload();
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
        }
        else if(trnscto == 'others'){
          var othrhd = $("#othrhd").val();
          var particlr = $("#particlr").val();
          var lnkwith = $("#lnkwith").val();
          if(othrhd =='') {
            $("#othrhdmsg").html("! Select Head.");
            $("#othrhdmsg").delay(4000).fadeOut();
            $('#othrhd').css("border","1px solid #ec1313");
            $('#othrhd').focus();
            return false;
          }else if(particlr == '') {
              $("#particlrmsg").html("! Select The Particular Name");
              $("#particlrmsg").delay(4000).fadeOut();
              $('#particlr').css("border","1px solid #ec1313");
              $('#particlr').focus();
              return false;
          }else{
            $.ajax({
               url:"<?php echo SITE_URL; ?>/basic/finance/payment_assign/payassign_submitpage.php",
               data:$("#paymentassignform").serialize(),
               type:'POST',
               success:function(response) {
                  if(response == 1){
                    alert('Successfully Assignd');
                    location.reload();
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
        }
      }
    });
</script>
<div class="row" style="margin: 10px;">
   <!-- Body Starts Here -->
   <?php if(isset($msg)) { echo "<i style=color:#33D15B;>".$msg."</i>"; } ?>
   <form name="form" method="post" class="forms-sample" style="margin-left: 5px;" id="paymentassignform">
    <?php $emppid =  $_POST['empid'];?>
    <input type="hidden" class="form-control" name="trnsc_type" id="trnsc_type" value="<?php echo $fthimps->transac_type;?>">
    <input type="hidden" class="form-control" name="bimpid" id="bimpid" value="<?php echo $bimpid;?>">
    <input type="hidden" class="form-control" name="empid" id="empid" value="<?php echo $emppid;?>">
      <legend>
         <h5 style="color: #008787;">Uploaded Payment Details</h5>
      </legend>
      <fieldset>
         <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="display: none;">
               <div class="form-group">
                  <label for="stmnt_prvw">Statement Preview ID</label>
                  <input type="text" class="form-control" name="stmnt_prvw" id="stmnt_prvw" value="<?php echo $fthimps->preview_id;?>" readonly>
               </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="display: none;">
               <div class="form-group">
                  <label for="bankacc_id">Bank Account ID</label>
                  <input type="text" class="form-control" name="bankacc_id" id="bankacc_id" value="<?php echo $fthimps->bnkacc_id;?>" readonly>
               </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
               <div class="form-group">
                  <label for="preqnum">Payment Request No.</label>
                  <input type="text" class="form-control" name="preqnum" id="preqnum" value="<?php  echo $fthimps->pr_num;?>" readonly>
               </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                    <label for="pay_orgnstn">Payment Under Organisation</label>
                    <select class="form-control" name="pay_orgnstn" id="pay_orgnstn" readonly>
                        <?php echo "<option value='".$fthorg->id."'>".$fthorg->organisation."</option>";?>
                  </select>
                  <div class="col-md-6" id="errorpay_orgnstn" style="display:none;" align="center">
                     <strong style="color:red;font-size: 10px;" id="pay_orgnstnmsg"></strong>
                  </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
               <div class="form-group">
                    <label for="pay_bnkacc">Payment Under Bank Account</label>
                    <select class="form-control" name="pay_bnkacc" id="pay_bnkacc" readonly>
                    <?php echo "<option value='".$fthbacc->id."'>".$fthbacc->accnm."</option>";?>
                  </select>
               </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
               <div class="form-group">
                  <label for="trnsc_type">Payment Transaction Type</label>
                  <input type="text" class="form-control" name="trnsc_type" id="trnsc_type" value="<?php if (isset($_POST['bankimportid'])) { echo $fthimps->transac_type; } ?>" readonly>
               </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
               <div class="form-group">
                  <label for="trnscto">Transaction To/Type</label> <strong style="color:red;font-size: 10px;" id="trnsctomsg"></strong>
                  <select class="form-control" name="trnscto" id="trnscto">
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
                  </select>
               </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
               <div class="form-group">
                  <label for="payee_nm">Payee Name</label>
                  <input type="text" class="form-control" name="payee_nm" id="payee_nm" value="<?php echo $fthimps->payee_name;?>" readonly>
               </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
               <div class="form-group">
                  <label for="paidamt">Paid/Approved Amount</label>
                  <div class="input-group">
                     <span class="input-group-addon"><i class="fa fa-rupee"></i></span>
                     <input type="text" class="form-control" name="paidamt" id="paidamt" value="<?php echo $fthimps->transac_amt; ?>" readonly>
                  </div>
               </div>
            </div>
         </div>
         <div id="showPForm">
         </div>
         <div class="row">
            <div class="col-lg-12">
               <div class="form-group">
                  <button type="button"  style="margin-top: 15px; margin-bottom: 30px; float: right;" class="btn btn-danger" data-dismiss="modal">Close</button>
                  <input type="button" name="payasgn" id="payasgn" value="ASSIGN" class="btn btn-success mr-2" style="margin-top: 15px; margin-bottom: 30px; float: right;">
               </div>
            </div>
         </div>
      </fieldset>
   </form>
   <!-- //Body Ends Here -->     
</div>
