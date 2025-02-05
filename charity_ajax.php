
<?php require_once('../../config.php');?>

<?php
 
 $charity_id = $_POST['org_id'];

 if($charity_id != ''){

$t_data = mysqli_query($con,"SELECT * FROM prj_creditor WHERE group_subtype='109' AND cred_status = '1' AND id = $charity_id");

$fetct= mysqli_fetch_object($t_data);

// $data = json_encode($fetct);

// print_r ($data);

echo $fetct->biladd;

 }else{
    
 }

 ?>