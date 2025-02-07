<?php include("../../../config.php");
if (isset($_GET['bimpid']) && isset($_GET['peid'])) // Fetch query 
{
    $bimpid = $_GET['bimpid'];
    $peid = $_GET['peid'];
    $fetch = mysqli_query($con, "SELECT * FROM `fin_payment_entry` WHERE `id`='$peid'");

    $row = mysqli_fetch_object($fetch);

    if ($row->trnscto == 'LC Processing') {
        $pid = $row->id;
        $fthlc = mysqli_query($con, "SELECT * FROM `fin_payment_entry_lc` WHERE `payent_id`='$pid'");
        $salc = mysqli_fetch_object($fthlc);
        $count  = mysqli_num_rows($fthlc);
    }

    $query = mysqli_query($con, "SELECT x.*,c.`lcnum`, c.`amnt`, y.`organisation`, a.`supplier_name`,b.`fullname` FROM `fin_lcasgn` x,`prj_organisation` y,`prj_supplier` a,`mstr_emp` b,`fin_lce` c WHERE x.`orgid`=y.`id` AND  x.`splrid`=a.`id` AND x.`created_by`=b.`id` AND x.`status`='1' AND x.`lcnumid`='$salc->lc_id' and x.`lcnumid`=c.`id` ORDER BY x.`id` DESC");

    // z.`bnkname`, z.`accnum`, `fin_bank` z, x.`bnkid`=z.`id` AND    // this part is removed it will use forther

    while ($fetcheddata = mysqli_fetch_object($query)) {
        $lcnum = $fetcheddata->lcnum;
        $supplier_name = $fetcheddata->supplier_name;
        $amnt = $fetcheddata->amnt;
        $dt = $fetcheddata->dt;
    }
}
?>
<div class="panel panel-default">
    <div class="panel-head bg-dark">
        <div class="col-lg-12 " style="padding:10px">
            <h5 class="text-primary m-0">Transaction type Details : (LC Processing) </h5>
        </div>
    </div>
    <div class="panel-body p-1">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-row mt-1">
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="display: block;">
                    <div class="form-group">
                        <label for="lc_num">LC No.</label>
                        <input type="text" class="form-control" id="lc_num" value="<?php echo $lcnum; ?>" readonly>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="client">Client</label>
                        <input type="text" class="form-control" id="client" value="<?php echo $supplier_name; ?>" readonly>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="text" class="form-control" id="amount" value="<?php echo $amnt; ?>" readonly>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="transc_dt">Transaction Dt:</label>
                        <input type="text" class="form-control" id="transc_dt" value="<?php echo $dt; ?>" readonly>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-4">
            <div class="form-group">
                <table class="table table-bordered" id="dynamic_field">
                    <thead class="bg-primary">
                        <tr>
                            <th>Sl. No.</th>
                            <th>Invoice No.</th>
                            <th>Invoice Dt</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody class="input_fields_wrap" id="tableresult">
                        <?php
                        $sqlquery = mysqli_query($con, "SELECT u.*, b.* FROM fin_lcasgn_dtls u, fin_payment_entry_lc_inv_charg b WHERE u.id = b.inv_no AND b.lcp_id='$salc->id' order by b.`id` desc");
                        if ($sqlquery->num_rows > 0) {
                            $sl = 1;
                            while ($data = mysqli_fetch_object($sqlquery)) {
                                $invc_no = mysqli_query($con, "SELECT * FROM prj_dispatch WHERE unique_id = '" . $data->PO_uniq_id . "' order by `id` desc");
                                $data_invc_no = mysqli_fetch_object($invc_no);
                        ?>
                                <tr>
                                    <td><?php echo $sl++; ?></td>
                                    <td><?php echo $data_invc_no->inv_no; ?></td>
                                    <td><?php echo $data_invc_no->invc_dte; ?></td>
                                    <td><?php echo $data->invcamnt; ?></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <?php
                        $sqlqueryothr = mysqli_query($con, "SELECT * FROM `fin_payment_entry_lc_oth_charg` WHERE `lcp_id`='$salc->id' order by`id` desc");
                        $cntdtothr = mysqli_num_rows($sqlqueryothr);
                        if ($cntdtothr > 0) {
                            $sl = 1;
                            while ($dataothr = mysqli_fetch_object($sqlqueryothr)) {
                        ?>
                                <tr>
                                    <td style="color:blue;" align="right" colspan="2">
                                        <label for="ltr_ctg_nm">Other :</label>
                                    </td>
                                    <td style="color:blue;" align="center">
                                        <input type="text" class="form-control persum" value="<?php echo $dataothr->other_crg; ?>" readonly>
                                    </td>
                                    <td style="color:blue;" align="center">
                                        <input type="text" class="form-control persum" value="<?php echo $dataothr->other_amt; ?>" readonly>
                                    </td>
                                </tr>
                        <?php }
                        } ?>
                        <tr>
                            <td style="color:blue;" align="right" colspan="3">
                                <label for="ltr_ctg_nm">Total :</label>
                            </td>
                            <td style="color:blue;" align="center">
                                <input type="text" class="form-control" name="total_amt" id="total_amt" value="<?php echo $salc->total_amt ?>" readonly>
                            </td>

                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="rent_bind">
            <!-- Additional content if needed -->
        </div>

    </div>
</div>