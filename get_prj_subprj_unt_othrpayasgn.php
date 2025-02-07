<?php include("../../config.php"); ?>

<?php
    $action=$_REQUEST['action'];
    
    //=============get project =============
    if($action == "show_prjdtls"){     
    	$particlr = $_POST['particlr'];
        $org_nm = $_POST['org_nm'];

    	$get_clientnm = mysqli_query($con,"SELECT * FROM `fin_customers` WHERE `status`='1' AND group_subtype='12' AND id='$particlr' ORDER BY `companynm` ASC");
        $ftch_clnt = mysqli_fetch_object($get_clientnm);
        $clnt_nm = $ftch_clnt->companynm;
        $get_clntprj = mysqli_query($con, "SELECT * from 
                                        (SELECT prj.id AS prjid,prj.pname AS prj_nm, clnt.prj_id FROM `resco_add_client` clnt 
                                            LEFT JOIN `prj_project` prj ON (clnt.`prj_id`= prj.id AND prj.ptype='RESCO') 
                                            WHERE clnt.apval_status IN ('1') AND prj.ptype_org='$org_nm' AND clnt.client_id='$particlr' 
                                        UNION ALL

                                        SELECT prj.id AS prjid,prj.pname AS prj_nm, prj_or.project_name FROM `prj_order` prj_or 
                                            LEFT JOIN `prj_project` prj ON prj_or.project_name=prj.id 
                                            WHERE prj.ptype='RESCO' AND prj.ptype_org='$org_nm' AND (prj_or.client_name='$clnt_nm' OR prj_or.client_name='$particlr') AND (prj_or.first_stage_aprrove='2' AND prj_or.sec_stage_approve='1')
                                        ) AS result GROUP BY prjid ORDER BY prj_nm ASC"
                                    );

    	if($get_clntprj->num_rows > 0)
    	{
    		echo "<option value=''>--SELECT PROJECT--</option>";

    		while ($ftchprj = mysqli_fetch_object($get_clntprj)) {

    			echo '<option value="'. $ftchprj->prjid . '">'.$ftchprj->prj_nm.'</option>';
    		}
    	}else{

    		echo "<option value=''>Data Not Available</option>";
    	}
    }
    //===========get sub project============
    if($action == "show_subprjdtls")  ///get sub project
    {
    	$particlr = $_POST['particlr'];
    	$project_id = $_POST['project_id'];
        $get_clntprj ='';
    	$get_clientnm = mysqli_query($con,"SELECT * FROM `fin_customers` WHERE `status`='1' AND group_subtype='12' AND id='$particlr' ORDER BY `companynm` ASC");
        $ftch_clnt = mysqli_fetch_object($get_clientnm);
        $clnt_nm = $ftch_clnt->companynm;
    	
        $get_clntprj = mysqli_query($con, "SELECT * from (SELECT subprj.id AS subprjid,subprj.spname AS sub_prjname,clnt.subprj_id FROM `resco_add_client` clnt 
        	LEFT JOIN `prj_subproject` subprj ON clnt.`subprj_id`= subprj.id 
        	WHERE clnt.client_id='$particlr' AND clnt.prj_id='$project_id' AND clnt.apval_status='1'
            UNION ALL 
            SELECT subprj.id AS subprjid,subprj.spname AS sub_prjname, prjor_dtls.sp_name FROM `prj_order` prj_or 
            LEFT JOIN `prj_order_details` prjor_dtls ON prj_or.unique_id=prjor_dtls.unique_id 
            LEFT JOIN `prj_subproject` subprj ON prjor_dtls.`sp_name`=subprj.id 
            WHERE prj_or.project_name='$project_id' AND (prj_or.client_name='$clnt_nm' OR prj_or.client_name='$particlr' AND (prj_or.first_stage_aprrove='1' AND prj_or.sec_stage_approve='1'))) AS result ORDER BY sub_prjname ASC");

    	if(mysqli_num_rows($get_clntprj) > 0)
    	{
    		echo "<option value=''>--Select Sub Project--</option>";

    		while ($ftchprj = mysqli_fetch_object($get_clntprj)) {

    			echo '<option value="'. $ftchprj->subprjid . '">'.$ftchprj->sub_prjname	.'</option>';
    		}
    	}else{
    		
    		echo "<option value=''>Data Not Available</option>";
    	}
    }

    //=======get unit name=======
    if($action == "show_unitdtls")  ///get Unit Name
    {
    	$project_id = $_POST['project_id'];
    	$subproj_id = $_POST['subproj_id'];
        
    	$get_untdtls = mysqli_query($con, "SELECT `id`, `unitname` FROM `resco_unitbill` WHERE `proj`='$project_id' AND `subpr_name`='$subproj_id' AND `approval1st_status`='1' AND `approval2nd_status`='1' ORDER by unitname ASC");
    	if($get_untdtls->num_rows > 0)
    	{
    		echo "<option value=''>--Select UNIT Name--</option>";

    		while ($ftch_untdtls = mysqli_fetch_object($get_untdtls)) {

    			echo '<option value="'. $ftch_untdtls->id . '">'.$ftch_untdtls->unitname.'</option>';
    		}
    	}else{
    		
    		echo "<option value=''>Data Not Available</option>";
    	}
    }
?>