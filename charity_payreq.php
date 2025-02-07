<?php include("../../config.php"); ?>

<script>

  <?php if (!isset($_GET['prid'])) { ?>

    $(document).ready(function () {

      $("#org_id").change(function () {

        if ($(this).val() != '') {

          $('#year').attr('disabled', false);

        }

      })

    })

  <?php } else { ?>

    $(document).ready(function () {

      $('#year').attr('disabled', false);

    })

  <?php } ?>

</script>

<script>//serach option in select box

  <?php if (!isset($_GET['prid'])) { ?>

    $(document).ready(function () {

      $(".rentdetails").change(function () {

        if ($(this).val() != '') {

          var org = $("#org_id").val();

          var yr = $("#year").val();

          if (org != '' && yr != '') {

            $.ajax({

              url: "payment_assign/get_charity_pymnt_rqst.php",

              data: { org_id: org, yr: yr },

              type: 'POST',

              success: function (response) {

                var resp = $.trim(response);

                $("#rent_bind").html(resp);

              }

            })

          }

        } else {

          $("#rent_bind").html('');

        }

      });

    });

  <?php } ?>

</script>

<script>

  $(document).ready(function () {

    $("#paysbmt").click(function () {

      var org_id = $("#org_id").val();

      var year = $("#year").val();

      var message = $("#message").val();

      if (org_id == '') {

        $("#org_idmsg").html("! Select Organisation");

        $("#errororg_id").show().delay(6000).fadeOut();

        $('#org_id').css("border", "1px solid #ec1313");

        $('#org_id').focus();

        return false;

      } else if (year == '') {

        $("#yearmsg").html("! Select year");

        $("#erroryear").show().delay(6000).fadeOut();

        $('#year').css("border", "1px solid #ec1313");

        $('#year').focus();

        return false;

      }
      else if (message == '') {

        $("#rent_bindmsg").html("Remarks Not to be Blank");

        $("#errorrent_bind").show().delay(6000).fadeOut();

        $('#rent_bind').focus();

        return false

      }
      
      else if ($('input[type=checkbox]:checked').length == 0) {

        $("#rent_bindmsg").html("! Select One Charity option Atleast");

        $("#errorrent_bind").show().delay(6000).fadeOut();

        $('#rent_bind').focus();

        return false;

      } else {

        return true;

      }

    });

  });

</script>

<?php

if (isset($_GET['prid'])) // Fetch query 
{

  $prid = $_GET['prid'];

  $fthsplr = mysqli_query($con, "SELECT x.*,y.`organisation` FROM `fin_payment_request_rent` x,`prj_organisation` y WHERE x.`org_id`=y.`id` AND x.`payreq_id`='$prid'");

  $srow = mysqli_fetch_object($fthsplr);

}

?>

<script>

  <?php if (isset($_GET['prid'])) { ?>

    $(document).ready(function () {

      $.ajax({

        url: "updt_rnt_pymnt_rqst.php",

        data: { prqid: <?php echo $_GET['prid']; ?>, tl_rt: <?php echo $srow->ttl_rate; ?> },

        type: 'POST',

        success: function (response) {

          var resp = $.trim(response);

          $("#rent_bind").html(resp);

        }

      })

    })

  <?php } ?>

</script>

<div class="row" style="margin-top: 20px;">

  <center>

    <h4 style="text-decoration: underline; font-weight: bold; color: #37909e;">Charity Payment Details</h4>

  </center>

  <div class="col-lg-12">

    <div class="col-lg-4">

      <div class="form-group">

        <label for="org_id">Name of Person/Organization<span style="color:red">*</span></label>

        <select name="org_id[]" class="form-control rentdetails" id="org_id">

          <?php if (isset($_GET['prid'])) {

            echo "<option value='" . $srow->org_id . "'>" . $srow->organisation . "</option>";



          }
          if (!isset($_GET['prid'])) { ?>

            <option value="">--Select--</option>

            <?php $orgn = mysqli_query($con, "SELECT p.*
                        FROM   prj_creditor p, fin_charity_details od
                        WHERE p.group_subtype='109' AND p.cred_status = '1' AND p.id = od.creditor_id AND od.status = 1 AND od.charity_type = 1 AND NOT EXISTS (SELECT * FROM fin_payment_request_charity ch WHERE od.creditor_id = ch.org_id);");

            while ($roworg = mysqli_fetch_object($orgn)) {

              echo "<option value='" . $roworg->id . "'>" . $roworg->companynm . "</option>";

            }
          } ?>

        </select>

        <div class="col-md-12" id="errororg_id" style="display:none;" align="center">

          <strong style="color:red;font-size: 14px;" id="org_idmsg"></strong>

        </div>

      </div>

    </div>

    <div class="col-lg-4">

      <label for="year">Select Date<span style="color:red">*</span></label>



      <input type="date" class="form-control rentdetails" name="year" id="year" disabled="">

      </select>

      <div class="col-md-12" id="erroryear" style="display:none;" align="center">

        <strong style="color:red;font-size: 14px;" id="yearmsg"></strong>

      </div>

    </div>




    <div class="col-md-12" id="errorrent_bind" style="display:none;" align="center">

    <strong style="color:red;font-size: 14px;" id="rent_bindmsg"></strong>

    </div>

    </br></br>

    <div class="col-lg-12" id="rent_bind"></div>

  </div>