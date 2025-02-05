<?php require_once('../../auth.php'); ?>
<?php require_once('../../config.php'); ?>
<!-- 
    ::Page Nomenclature::
    # Module Name: Finance Module <All Payment Unassigned List>
    # Page Name: unassignedlist.php <self page name>
    # About Page: This page For All Payment Unassigned List.     
    # Creation By: Gayatri <who created the page>
    # Creation Date: 2023-03-07 <page creation date>
     <tables name that link with this page>
    -->   
<?php
    /*$history="-1";
    if(isset($_POST['records-limit'])){
      $_SESSION['records-limit'] = $_POST['records-limit'];
    }
    $limit = isset($_SESSION['records-limit']) ? $_SESSION['records-limit'] : 500;
    $page = (isset($_GET['page']) && is_numeric($_GET['page']) ) ? $_GET['page'] : 1;
    $paginationStart = ($page - 1) * $limit;
    $result = mysqli_query($con,"SELECT x.*, x.id as paymntid, y.*, y.id as stmntid FROM `fin_banking_imports` x, `fin_statement_preview` y WHERE x.`preview_id`=y.`id` AND y.`status`='1' And x.`is_pay_aprvd` = '0' ORDER BY x.`id` Desc LIMIT $paginationStart, $limit");
    $total_pages_sql = "SELECT count(*) FROM `fin_banking_imports` x, `fin_statement_preview` y WHERE x.`preview_id`=y.`id` AND y.`status`='1' And x.`is_pay_aprvd` = '0' ORDER BY x.`id` Desc";
    $res_data = mysqli_query($con,$total_pages_sql);
    $total_rows = mysqli_fetch_array($res_data)[0];
    $totoalPages = ceil($total_rows / $limit);
    // Prev + Next
    $prev = $page - 1;
    $next = $page + 1;*/
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>All Unassigned Payment List : Suryam Group</title>
        <!-- Bootstrap Core CSS -->
        <link href="<?php echo SITE_URL; ?>/basic/css/bootstrap.min.css" rel="stylesheet">
        <!-- MetisMenu CSS -->
        <link href="<?php echo SITE_URL; ?>/basic/css/metisMenu.min.css" rel="stylesheet">
        <!-- Timeline CSS -->
        <link href="<?php echo SITE_URL; ?>/basic/css/timeline.css" rel="stylesheet">
        <!-- Custom CSS -->
        <!-- Morris Charts CSS -->
        <link href="<?php echo SITE_URL; ?>/basic/css/morris.css" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="<?php echo SITE_URL; ?>/basic/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <![endif]-->
        <!-- jQuery -->
        <script src="<?php echo SITE_URL; ?>/basic/js/jquery.min.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- DATETIMEPICKER CDNs -->
        <script src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
        <!-- DATETIMEPICKER CDNs -->
        <link rel="shortcut icon" href="../images/favicon.png" />
        <!--Clock-->
        <script src="<?php echo SITE_URL; ?>/basic/js/clock.js" type="text/javascript"></script>
        <!--//Clock-->
        <!-- Used For Auto Typing Search -->
          <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
        <!-- // Used For Auto Typing Search-->
        <link href="<?php echo SITE_URL; ?>/basic/css/startmin.css" rel="stylesheet">
        <!-- Data tables-->
          <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
          <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
          <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
          <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
          <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
          <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
          <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
          <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
        <!-- end -->
        <script>
            $(document).ready(function() { 
              startclock ();
                $('#records-limit').change(function () {
                    $('form').submit();
                });
                $('#organisation_name,#account_name,#account_num,#payee_name').selectize({
                    sortField: 'text'
                });
                $('#filterdata').DataTable({
                  dom: 'lBfrtip',
                  //scrollX: true,
                  buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel'},
                    {extend: 'pdfHtml5',orientation: 'landscape',pageSize: 'LEGAL'},
                    {extend: 'print',
                      customize: function(win) {
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');
                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                        }
                    }
                  ]
                });
            });
        </script>
    </head>
    <body>
        <div id="wrapper">
            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <?php require_once('../../header.php'); // include Header Portion ?>
                <?php require_once('../../menu.php'); // include Menu Portion ?>
            </nav>
            <div id="page-wrapper">
                <section>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                         <h4 class="page-header alert-success p-3 mb-2">All Payment Unassigned List</h4>
                      </div>
                    </div>
                <span> 
                <!-- /.row -->
                <div class="row">
                    <!-- Body Starts Here -->
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="panel tabbed-panel panel-info">
                            <div class="panel-body p-2">
                                <div class="tabcontent">
                                    <div class="table-responsive" class="tabcontent">
                                        <!-- search section -->
                                        <div class="form-row">
                                            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                 <label for="pname">Organisation Name</label>
                                                 <select name="organisation_name" id="organisation_name" class="form-control">
                                                    <option value="">-- Select Organisation Name-- </option>
                                                    <?php
                                                       $organidels = "SELECT `id`,`organisation` FROM `prj_organisation` WHERE `status`='1' order by id desc";
                                                       $fetorgan = mysqli_query($con, $organidels);
                                                       while ($getorganname = mysqli_fetch_object($fetorgan)) {
                                                          echo '<option value="' . $getorganname->id . '">' . $getorganname->organisation . '</option>';
                                                       }
                                                       ?>
                                                 </select>
                                                </div>
                                            </div>
                                           <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                              <div class="form-group">
                                                 <label for="pname">Account Name</label>
                                                 <select name="account_name" id="account_name" class="form-control">
                                                    <option value="">-- Select Account Name-- </option>
                                                    <?php
                                                       $bankaccoun = "SELECT `id`,`accnm` FROM `fin_bankaccount` ORDER by `id` desc";
                                                       $fetbankaccoun = mysqli_query($con, $bankaccoun);
                                                       while ($getfetbankaccoun = mysqli_fetch_object($fetbankaccoun)) {
                                                          echo '<option value="' . $getfetbankaccoun->id . '">' . $getfetbankaccoun->accnm . '</option>';
                                                       }
                                                       ?>
                                                 </select>
                                              </div>
                                           </div>
                                           <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                              <div class="form-group">
                                                 <label for="pname">Account Number</label>
                                                 <select name="account_num" id="account_num" class="form-control">
                                                    <option value="">-- Select Account Number-- </option>
                                                    <?php
                                                       $bankaccounnum = "SELECT `id`,`accntnum` FROM `fin_bankaccount` ORDER by `id` desc";
                                                       $fetbankaccounnum = mysqli_query($con, $bankaccounnum);
                                                       while ($getdptj = mysqli_fetch_object($fetbankaccounnum)) {
                                                          echo '<option value="' . $getdptj->accntnum . '">' . $getdptj->accntnum . '</option>';
                                                       }
                                                       ?>
                                                 </select>
                                              </div>
                                           </div>
                                           <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                              <div class="form-group">
                                                 <label for="pname">Payee Name</label>
                                                 <select name="payee_name" id="payee_name" class="form-control">
                                                    <option value="">-- Select Payee Name-- </option>
                                                    <?php
                                                       $dptqry = "SELECT DISTINCT `payee_name` FROM `fin_banking_imports` ORDER by `payee_name` desc";
                                                       $fetdptqry = mysqli_query($con, $dptqry);
                                                       while ($getdptj = mysqli_fetch_object($fetdptqry)) {
                                                          echo '<option value="' . $getdptj->payee_name . '">' . $getdptj->payee_name . '</option>';
                                                       }
                                                       ?>
                                                 </select>
                                              </div>
                                           </div>
                                           <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                              <div class="form-group">
                                                 <label for="pname">Transaction Type</label>
                                                 <select name="transac_type" id="transac_type" class="form-control">
                                                    <option value="">-- Select Transaction Type-- </option>
                                                    <option value="Debit">Debit</option>
                                                    <option value="Credit">Credit </option>
                                                 </select>
                                              </div>
                                           </div>
                                           <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                              <div class="form-group">
                                                 <label for="pname">Transaction Form</label>
                                                 <input type="date" name="from_date" id="from_date" class="form-control" placeholder="From Date" />
                                              </div>
                                           </div>
                                           <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                              <div class="form-group">
                                                 <label for="pname">Transaction To</label>
                                                 <input type="date" name="to_date" id="to_date" class="form-control" placeholder="To Date" />
                                              </div>
                                           </div>
                                           <div class="col-lg-2 col-md-4 col-sm-3 col-xs-6 mt-4">
                                              <input type="hidden" name="sessionid" id="sessionid" value="<?php echo $_SESSION['ERP_SESS_ID'];?>"/>
                                              <input type="button" name="filter" id="filter" value="Filter" class="btn btn-info" /> 
                                              <input type="button" onClick="window.location.reload();" value="Refresh" class="btn btn-info" /> 
                                           </div>
                                        </div>
                                        <!-- search end -->
                                        <!-- Select dropdown -->
                                        <?php /* temporary commented for datatable
                                        <div class="d-flex flex-row-reverse bd-highlight mb-3">
                                            <form action="unassignedlist.php" method="post">
                                                <label>Show 
                                                <select name="records-limit" id="records-limit" class="custom-select">
                                                    <?php foreach([500,1000,2000] as $limit) : ?>
                                                    <option
                                                        <?php if(isset($_SESSION['records-limit']) && $_SESSION['records-limit'] == $limit) echo 'selected'; ?>
                                                        value="<?= $limit; ?>">
                                                        <?= $limit; ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select> entries</label>&nbsp;&nbsp;<label style="color:red">Total Records :<?php echo $total_rows;?></label>
                                                
                                            </form>
                                        </div>
                                        */?>
                                        <!-- Datatable -->
                                        <table class="table table-striped" id="filterdata">
                                            <thead>
                                                <tr class="bg-dark">   
                                                   <th>#</th>
                                                   <th>Organisation Name</th>
                                                   <th>Account Name</th>
                                                   <th>Account Number</th>
                                                   <th>Bank Name</th>
                                                   <th>Branch Name</th>
                                                   <th>Upload By</th>
                                                   <th>Transaction Date</th>
                                                   <th>PR No.</th>
                                                   <th>Payee Name.</th>
                                                   <th>Transaction Type</th>
                                                   <th>Credit</th>
                                                   <th>Debit</th>
                                                   <th>Pending With</th>
                                                </tr> 
                                            </thead>
                                            <tbody>                 
                                              <?php
                                                /*$result = mysqli_query($con,"SELECT x.*, x.id as paymntid, y.*, y.id as stmntid FROM `fin_banking_imports` x, `fin_statement_preview` y WHERE x.`preview_id`=y.`id` AND y.`status`='1' And x.`is_pay_aprvd` = '0' ORDER BY x.`id` Desc LIMIT $offset, $no_of_records_per_page");*/
                                                $result = mysqli_query($con,"SELECT x.*, x.id as paymntid, y.*, y.id as stmntid FROM `fin_banking_imports` x, `fin_statement_preview` y WHERE x.`preview_id`=y.`id` AND y.`status`='1' And x.`is_pay_aprvd` = '0' ORDER BY x.`id` Desc");
                                                 $i=1;
                                                 while($fetch=mysqli_fetch_object($result))
                                                 {
                                                  $bankresult = mysqli_query($con,"SELECT * FROM `fin_bankaccount` x WHERE `id`= ".$fetch->bnkacc_id);
                                                  $fetchbank = mysqli_fetch_object($bankresult);
                                                  if ($fetchbank->acc_type=='1') 
                                                  {
                                                    $tablename = "fin_bank";
                                                  }else if($fetchbank->acc_type=='2'){
                                                    $tablename = "fin_work_capital";
                                                  }
                                                  $bnkqr = mysqli_query($con, "SELECT x.*, y.organisation FROM ".$tablename." x, `prj_organisation` y WHERE x.`orgname`=y.`id` AND x.`id`= '".$fetchbank->bnkname."'");
                                                  $bankdetails = mysqli_fetch_object($bnkqr);
                                                  $orgns=$bankdetails->organisation ? $bankdetails->organisation:'Not Available';
                                                  $bnkname = $bankdetails->bnkname ? $bankdetails->bnkname:'Not Available';
                                                  $branchname = $bankdetails->branch ? $bankdetails->branch:'Not Available';
                                                  $accntname=$fetchbank->accnm ? $fetchbank->accnm:'Not Available';//account name
                                                  $accntnumber=$fetchbank->accntnum ? $fetchbank->accntnum:'Not Available';//account name
                                                  $empresult = mysqli_query($con,"SELECT fullname FROM `mstr_emp` WHERE `id`= ".$fetch->upload_by);
                                                  $empdetails=mysqli_fetch_object($empresult);
                                                 ?>
                                                <tr>
                                                   <td><?php echo $i; ?></td>
                                                   <td><?php echo $orgns; ?></td>
                                                   <td><?php echo $accntname; ?></td>
                                                   <td><?php echo $accntnumber; ?></td>
                                                   <td><?php echo $bnkname; ?></td>
                                                   <td><?php echo $branchname; ?></td>
                                                   <td><?php echo $empdetails->fullname; ?></td>
                                                   <td><?php echo $fetch->transac_dt ? $fetch->transac_dt:"Not Given"; ?></td>
                                                   <td><?php echo $fetch->pr_num ? $fetch->pr_num:"Not Given"; ?></td>
                                                   <td><?php echo $fetch->payee_name ? $fetch->payee_name:"Not Given"; ?></td>
                                                   <td><?php echo $fetch->transac_type ? $fetch->transac_type:"Not Given"; ?></td>
                                                   <td><?php if($fetch->transac_type == 'Credit'){ echo $fetch->transac_amt;}else{echo '0.00' ;} ?></td>
                                                    <td><?php if($fetch->transac_type == 'Debit'){ echo $fetch->transac_amt;}else{echo '0.00' ;} ?></td>
                                                   <td style="color:red"><?php if($fetch->is_pay_aprvd == '0'){ echo "Pending With Sasmita Pradhan And Deepak Kumar Jena";}elseif($fetch->is_pay_aprvd == '1'){ echo "Pending With Samarendra Sangram Singh"; } ?></td>
                                                </tr>
                                              <?php $i++; } ?>
                                            </tbody>
                                        </table>
                                        <?php /* pagination commented for data table
                                        <nav aria-label="Page navigation example mt-5">
                                            <ul class="pagination justify-content-center">
                                                <li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
                                                    <a class="page-link"
                                                        href="<?php if($page <= 1){ echo '#'; } else { echo "?page=" . $prev; } ?>">Previous</a>
                                                </li>
                                                <?php for($i = 1; $i <= $totoalPages; $i++ ): ?>
                                                <li class="page-item <?php if($page == $i) {echo 'active'; } ?>">
                                                    <a class="page-link" href="unassignedlist.php?page=<?= $i; ?>"> <?= $i; ?> </a>
                                                </li>
                                                <?php endfor; ?>
                                                <li class="page-item <?php if($page >= $totoalPages) { echo 'disabled'; } ?>">
                                                    <a class="page-link"
                                                        href="<?php if($page >= $totoalPages){ echo '#'; } else {echo "?page=". $next; } ?>">Next</a>
                                                </li>
                                            </ul>
                                        </nav>
                                        */?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    
                    <!-- //Body Ends Here -->      
                </div>
                <!-- /.row -->
                    
                </section>
            </div>
            <?php require_once('../../footer.php'); ?>
        </div>
        <!-- /#wrapper -->      
        <!-- Metis Menu Plugin JavaScript -->
        <script src="<?php echo SITE_URL; ?>/basic/js/metisMenu.min.js"></script>
        <!-- Custom Theme JavaScript -->
        <script src="<?php echo SITE_URL; ?>/basic/js/startmin.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){    
            $('#filter').click(function(){//for filter
                var organisation_name = $('#organisation_name').val();
                var account_name = $('#account_name').val();
                var sessionid = $('#sessionid').val();
                var from_date = $('#from_date').val();  
                var to_date = $('#to_date').val(); 
                var payee_name = $('#payee_name').val();  
                var account_num = $('#account_num').val(); 
                var transac_type = $('#transac_type').val(); 
                  $.ajax({  
                     url:"<?php echo SITE_URL; ?>/basic/finance/payment_assign/unpaymentassignfilter.php",  
                     method:"POST",  
                     data:{from_date:from_date,to_date:to_date,payee_name:payee_name,account_num:account_num,transac_type:transac_type,organisation_name:organisation_name,account_name:account_name,sessionid:sessionid},  
                     success:function(response)  
                     {  
                        $("#filterdata").html(response);
                     }  
                  });
            });  
         }); 
        </script>
    </body>
</html>