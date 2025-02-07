<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

<?php include("../../../config.php"); ?>

<?php
  if(isset($_GET['prid'])) // Fetch query 
  {
    $prid = $_GET['prid'];
    $fthtrns = mysqli_query($con,"SELECT * FROM `fin_payment_request_transporter` WHERE `payreq_id`='$prid'");
    $trow = mysqli_fetch_object($fthtrns);
  }
?>

<!-- Start of Scripts -->
  <!-- Form Validation -->

  <!-- End of Form Validation -->
  <!-- Get Sub-Project, BMS & Po Number As Per Project Selection -->
  <script type="text/javascript">
    $(document).ready(function(){
      $("#prjctnm").change(function(){
        var prjctid = $(this).val();
        if (prjctid != "") {
          $.ajax({
            url:"<?php echo SITE_URL; ?>/basic/finance/payment_assign/transporter_pay_assign/sp_bms_po_frpayasgn.php",
            data:{prjctnm:prjctid},
            type:'POST',
            success:function(response) {
              var resp = JSON.parse(response);

              $("#subprjnm").html(resp.subprjs);
              $("#bmsnm").html(resp.tbms);
              $("#ponum").html(resp.pos);
            }
          });
        }
        else {
          $("#subprjnm").html("<option value=''>Pick A Valid Project</option>");
          $("#bmsnm").html("<option value=''>Pick A Valid Project</option>");
          $("#ponum").html("<option value=''>Pick A Valid Project</option>");
        }
      });
    });
  </script>
  <!-- End of Get Sub-Project, BMS & Po Number As Per Project Selection -->

  <!-- Start of Calculations -->
  <script type="text/javascript">
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
  <!-- End of Calculations -->

<!-- End of Scripts -->

<div class="row" style="margin-top: 20px;">
  <center><h4 style="text-decoration: underline; font-weight: bold; color: #37909e;">Transporter Payment Details</h4></center>
  <div class="col-lg-12">
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
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
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
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
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="subprjnm">Sub Project Name</label>
        <select class="form-control" name="subprjnm" id="subprjnm">
          <option value="">--- Select Sub Project ---</option>
        </select>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="bmsnm">Billing Milestone</label>
        <select class="form-control" name="bmsnm" id="bmsnm">
          <option value="">--- Select BMS ---</option>
        </select>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="ponum">PO Number</label>
        <select class="form-control" name="ponum" id="ponum">
          <option value="">--- Select PO Number ---</option>
        </select>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="place_from">Place From</label>
        <input type="text" name="place_from" id="place_from" class="form-control" placeholder="Source Place" autocomplete="off">
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="place_to">Place To</label>
        <input type="text" name="place_to" id="place_to" class="form-control" placeholder="Destination Place" autocomplete="off">
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="distance">Distance</label>
        <div class="input-group">
          <input type="text" name="distance" id="distance" class="form-control" placeholder="99.99" autocomplete="off" onkeyup="calc()">
          <span class="input-group-addon" style="font-weight: bold;">kms</span>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="material_nm">material_nm</label>
        <input type="text" name="material_nm" id="material_nm" class="form-control" placeholder="material_nm Name" autocomplete="off">
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="mtrl_weight">Material Weight</label>
        <div class="input-group">
          <input type="text" name="mtrl_weight" id="mtrl_weight" class="form-control" placeholder="Weight in KG" autocomplete="off" onkeyup="calc()">
          <span class="input-group-addon" style="font-weight: bold;">kgs</span>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
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
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="lry_model">Lorry Model</label>
        <input type="text" name="lry_model" id="lry_model" class="form-control" placeholder="Model Name" autocomplete="off">
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="dala_typ">Dala Type</label>
        <input type="text" name="dala_typ" id="dala_typ" class="form-control" placeholder="Type of Dala" autocomplete="off">
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="carrycap">Carrying Capacity</label>
        <div class="input-group">
          <input type="text" name="carrycap" id="carrycap" class="form-control" autocomplete="off" placeholder="Carrying Capacity in KG">
          <span class="input-group-addon" style="font-weight: bold;">kgs</span>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="totalamnt">Total Amount</label>
        <div class="input-group">
          <span class="input-group-addon"><i class="fa fa-rupee"></i></span>
          <input type="text" class="form-control" name="totalamnt" id="totalamnt" placeholder="9999.99" autocomplete="off" onkeyup="calc()">
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="rateper_km">Rate Per KM</label>
        <div class="input-group">
          <span class="input-group-addon"><i class="fa fa-rupee"></i></span>
          <input type="text" name="rateper_km" id="rateper_km" class="form-control" placeholder="Rate/km" readonly>
          <span class="input-group-addon" style="font-weight: bold;">/km</span>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="rateper_kg">Rate Per KG</label>
        <div class="input-group">
          <span class="input-group-addon"><i class="fa fa-rupee"></i></span>
          <input type="text" name="rateper_kg" id="rateper_kg" class="form-control" placeholder="Rate/kg" readonly>
          <span class="input-group-addon" style="font-weight: bold;">/kg</span>
        </div>
      </div>
    </div>
  </div>
</div>