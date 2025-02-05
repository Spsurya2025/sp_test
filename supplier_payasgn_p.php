<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

<?php include("../../config.php"); ?>

<!-- Start of Scripts -->
  <!-- Form Validation -->
  <script type="text/javascript">
    $(document).ready(function(){
    
      $("#paysbmt").click(function() {
      
        var suplrnm = $("#suplrnm").val();
        var prj_name = $("#prj_name").val();
        var ponum = $("#ponum").val();

        // Checking for Blank Fields.

        if(suplrnm =='') {
          $('#payreqfor').css("border","1px solid #D3D3D3");

          $('#suplrnm').css("border","2px solid #ec1313");
          alert("Pick The Supplier Name");
          $('#suplrnm').focus();
          return false;
        }

        else if (prj_name =='') {
          $('#payreqfor, #suplrnm').css("border","1px solid #D3D3D3");

          $('#prj_name').css("border","2px solid #ec1313");
          alert("Select Project Name");
          $('#prj_name').focus();
          return false;
        }

        else if (ponum =='') {
          $('#payreqfor, #suplrnm, #prj_name').css("border","1px solid #D3D3D3");

          $('#ponum').css("border","2px solid #ec1313");
          alert("Select PO Number");
          $('#ponum').focus();
          return false;
        }

        else {
          return true;
        }
      });
    });
  </script>
  <!-- End of Form Validation -->

  <script>
    $(document).ready(function () {
      $('#suplrnm').selectize({
        sortField: 'text'
      });
    });
  </script>


  <!-- Get clients As Per Debtor Selection -->
  <script type="text/javascript">
    $(document).ready(function(){
      $("#spreq_typ").change(function(){
        var reqtyp = $("#spreq_typ").val();
        if (reqtyp != "") {
          if (reqtyp == "PR") {
            $("#prDtls").show();
            $("#trnsDtls").hide();
          }
          else {
            $("#prDtls").hide();
            $("#trnsDtls").show();
          }
        }
        else {
          $("#prDtls").hide();
          $("#trnsDtls").hide();
        }
      });
    });
  </script>
  <!-- End of Get clients As Per Debtor Selection -->


  <!-- Get Cr Limit & Project As Per Supplier Selection -->
  <script type="text/javascript">
    function getCrPrj() {
      var splrid = $("#suplrnm").val();
      if (splrid != "") {
        $.ajax({
          url:"../../get_prj.php",
          data:{sup_id:splrid},
          type:'POST',
          success:function(response) {
            var res = $.trim(response);
            $("#prj_name").html(res);
          }
        });
      }
      else {
        $("#prj_name").html("<option value=''>Pick A Valid Supplier</option>");
      }
    }

    $(document).ready(function(){
      $("#suplrnm").change(function(){
        getCrPrj();
      });
    });

  <?php // if(isset($_GET['prid'])) { ?>
    // $(document).ready(function(){
    //   getCrPrj();
    // });
  <?php // } ?>
  </script>
  <!-- End of Get Cr Limit & Project As Per Supplier Selection -->

  <!-- Get PO As Per Project Selection -->
  <script type="text/javascript">
    $(document).ready(function(){
      $("#prj_name").change(function(){
        var prjid = $("#prj_name").val();
        var splrid = $("#suplrnm").val();

        if (prjid != "") {
          $.ajax({
            url:"../get_po.php",
            data:{prjj:prjid,supl:splrid},
            type:'POST',
            success:function(response) {
              var resp = $.trim(response);
              $("#ponum").html(resp);
            }
          });
        }
        else {
          $("#ponum").html("<option value=''>No PO Found</option>");
        }
      });
    });
  </script>
  <!-- End of Get PO As Per Project Selection -->

  <!-- Get PO Details As Per PO No. Selection -->
  <script type="text/javascript">
    $(document).ready(function(){
      $("#ponum").change(function(){
        var ponm = $("#ponum").val();

        if (ponm != "") {
          $.ajax({
            url:"../get_po.php",
            data:{ponum:ponm},
            type:'POST',
            success:function(result) {
              var rslt = $.trim(result);
              var poinfo = rslt.split("#");
              
              document.getElementById("poamnt").value = poinfo[0];
              document.getElementById("podate").value = poinfo[1];
            }
          });
        }
        else {
          $("#poamnt").val("");
          $("#podate").val("");
        }
      });
    });
  </script>
  <!-- End of Get PO Details As Per PO No. Selection -->


  <script type="text/javascript">
    $(document).ready(function(){
      $("#spreq_typ").change(function(){
        var req = $("#spreq_typ").val();
        if (req == "PR") {
          var ponm = $("#ponum").val();

          if (ponm != "") {
            $.ajax({
              url:"../get_pr.php",
              data:{ponum:ponm},
              type:'POST',
              success:function(result) {
                var resp = $.trim(result);
                $("#pr_numbr").html(resp);
              }
            });
          }
          else {
            $("#pr_numbr").html("<option value=''>No PR Found</option>");
          }
        }
      });
    });
  </script>

  <script type="text/javascript">
    $(document).ready(function(){
      $("#pr_numbr").change(function(){
        var pr = $("#pr_numbr").val();
        var ponm = $("#ponum").val();

        if (pr != "") {
          $.ajax({
            url:"../get_other_pr_dtls.php",
            data:{ponum:ponm,prnum:pr},
            type:'POST',
            success:function(result) {
              var resp = JSON.parse(result);

              $("#subprj_nm").val(resp.sbprjct);
              $("#bms_name").val(resp.blng_mlstn);
              $("#pramnt").val(resp.pramt);
            }
          });
        }
        else {
          $("#subprj_nm").val("");
          $("#bms_name").val("");
          $("#pramnt").val("");
        }
      });
    });
  </script>

  
<!-- End of Scripts -->

<!-- Supplier Form -->
<div class="row" style="margin-top: 20px;">
  <center><h4 style="text-decoration: underline; font-weight: bold; color: #37909e;">Supplier Payment Details</h4></center>
  <div class="col-lg-12">
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="suplrnm">Supplier Name</label>
        <select class="form-control" name="suplrnm" id="suplrnm">
          <?php
            // if (isset($_GET['prid'])) {
            //   $splid = $srow->suplrnm;
            //   $gtsplm = mysqli_query($con, "SELECT * FROM `prj_supplier` WHERE `id`='$splid' ORDER BY `supplier_name` ASC");
            //   $fthsplm = mysqli_fetch_object($gtsplm);

            //   echo "<option value='".$fthsplm->id."'>".$fthsplm->supplier_name."</option>";
            // }
          ?>
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
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="prj_name">Project Name</label>
        <select class="form-control" name="prj_name" id="prj_name">
          <option value="">--- Select Project ---</option>
        </select>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="ponum">PO Number</label>
        <select class="form-control" name="ponum" id="ponum">
          <option value="">--- Purchase Order ---</option>
        </select>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="podate">PO Date</label>
        <input type="text" name="podate" id="podate" class="form-control" placeholder="yyyy-mm-dd" readonly>
      </div>
    </div>
  </div>
  <div class="col-lg-12">
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="poamnt">PO Amount</label>
        <div class="input-group">
          <span class="input-group-addon"><i class="fa fa-rupee"></i></span>
          <input type="text" class="form-control" name="poamnt" id="poamnt" placeholder="9999.99" readonly>
        </div>
      </div>
    </div>
    <!-- <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="trnsprtamt">Transportation Amount</label>
        <div class="input-group">
          <span class="input-group-addon"><i class="fa fa-rupee"></i></span>
          <input type="text" class="form-control" name="trnsprtamt" id="trnsprtamt" value="<?php // if(isset($_GET['prid'])) { echo $srow->trnsprtamt; } ?>" placeholder="9999.99" readonly>
        </div>
      </div>
    </div>
    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="inspcamt">Inspection Amount</label>
        <div class="input-group">
          <span class="input-group-addon"><i class="fa fa-rupee"></i></span>
          <input type="text" class="form-control" name="inspcamt" id="inspcamt" value="<?php // if(isset($_GET['prid'])) { echo $srow->inspcamt; } ?>" placeholder="9999.99" readonly>
        </div>
      </div>
    </div> -->
  <?php if ($_GET['trnsctyp'] != "Credit") { ?>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
      <div class="form-group">
        <label for="spreq_typ">Request Type</label>
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
        <legend><h6><strong style="color: #2bc59b;">PR Details</strong></h6></legend>
        <div class="table-responsive">
          <table class="table table-bordered table-responsive">
            <thead>
              <tr>
                <th>PR No.</th>
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
      <div class="col-lg-4">
        <legend><h6><strong style="color: #2bc59b;">Transportation Details</strong></h6></legend>
        <div class="table-responsive">
          <table class="table table-bordered table-responsive">
            <thead>
              <tr>
                <th>Transportation Reason</th>
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
<!-- End of Supplier Form -->