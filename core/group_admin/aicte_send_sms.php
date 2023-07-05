<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
<link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">

</head>
<body>

<?php
include('groupadminheader.php');
$report = "";
//$smartcookie = new smartcookie();
//$results = $smartcookie->retrive_individual($table, $fields);
//$result = mysql_fetch_array($results);
$group_member_id=$_SESSION['id']; 
$sc_id =0;
$parameter_qry = "select * from tbl_email_parameters";
$parameter_sql = mysql_query($parameter_qry);
    // echo $qury1; exit;
$template_qry = "select * from tbl_email_sms_templates";
$template_sql = mysql_query($template_qry);

// $query1 = "select * from aicte_email_setup WHERE group_member_id='$group_member_id'";
//     $res = mysql_num_rows(mysql_query($query1));
//     $row_res=mysql_fetch_assoc(mysql_query($query1));

$incharge=$_GET['in'];

$sql1 = "SELECT aci.* from aicte_college_info aci left join tbl_school_admin sa on aci.college_id=sa.school_id WHERE aci.college_id='".$_GET['cid']."'";
$row_res=mysql_fetch_assoc(mysql_query($sql1));
$incharge_name="";
$incharge_mob="";
$incharge_email="";
switch ($incharge) {
    case 'erp':
       $incharge_name=$row_res['erp_incharge_nm'];
       $incharge_mob=$row_res['erp_incharge_mob'];
       $incharge_email=$row_res['erp_incharge_email'];
        break;
    case 'it':
       $incharge_name=$row_res['it_incharge_nm'];
       $incharge_mob=$row_res['it_incharge_mob'];
       $incharge_email=$row_res['it_incharge_email'];
        break;
    case 'aicte':
       $incharge_name=$row_res['aicte_incharge_nm'];
       $incharge_mob=$row_res['aicte_incharge_mob'];
       $incharge_email=$row_res['aicte_incharge_email'];
        break;
    case 'tpo':
       $incharge_name=$row_res['tpo_incharge_nm'];
       $incharge_mob=$row_res['tpo_incharge_mob'];
       $incharge_email=$row_res['tpo_incharge_email'];
        break;
    case 'art':
       $incharge_name=$row_res['art_incharge_nm'];
       $incharge_mob=$row_res['art_incharge_mob'];
       $incharge_email=$row_res['art_incharge_email'];
        break;
    case 'student':
       $incharge_name=$row_res['student_incharge_nm'];
       $incharge_mob=$row_res['student_incharge_mob'];
       $incharge_email=$row_res['student_incharge_email'];
        break;
    case 'admin':
       $incharge_name=$row_res['admin_incharge_nm'];
       $incharge_mob=$row_res['admin_incharge_mob'];
       $incharge_email=$row_res['admin_incharge_email'];
        break;
    case 'exam':
       $incharge_name=$row_res['exam_incharge_nm'];
       $incharge_mob=$row_res['exam_incharge_mob'];
       $incharge_email=$row_res['exam_incharge_email'];
        break;
    case 'nss':
       $incharge_name=$row_res['nss_incharge_nm'];
       $incharge_mob=$row_res['nss_incharge_mob'];
       $incharge_email=$row_res['nss_incharge_email'];
        break;
    case 'sports':
       $incharge_name=$row_res['sports_incharge_nm'];
       $incharge_mob=$row_res['sports_incharge_mob'];
       $incharge_email=$row_res['sports_incharge_email'];
        break;
    case 'other':
       $incharge_name=$row_res['placement_incharge_nm'];
       $incharge_mob=$row_res['placement_incharge_mob'];
       $incharge_email=$row_res['placement_incharge_email'];
        break;
    
    default:
        break;
}
  

    // if (isset($_POST['submit'])) {
    
    // $email_id = $_POST['email_id'];
    // $is_active = $_POST['is_active'];
    // $email_temp = $_POST['email_template_id'];
    // // $sms_temp = $_POST['sms_template_id'];

    // if($res>0){
    //     $update_query = "UPDATE aicte_email_setup SET email_id='$email_id', email_template_id='$email_temp', sms_template_id='$email_temp', is_active='$is_active' WHERE group_member_id='$group_member_id'";
    //     // echo $update_query; exit;
    //    $main_sql=mysql_query($update_query);
    // }else{
    //     $insert_query="INSERT INTO aicte_email_setup SET email_id='$email_id', email_template_id='$email_temp', sms_template_id='$email_temp', is_active='$is_active', group_member_id='$group_member_id'";
    //    $main_sql=mysql_query($insert_query);
    // }
    
    // if($main_sql){
    //     echo "<script LANGUAGE='JavaScript'>
    //                 window.alert('Email setting for AICTE College Readiness has been changed Successfully.');
    //                 window.location.href='aicte_email_setup.php';
    //                 </script>";
    // }else{
    //     echo "<script LANGUAGE='JavaScript'>
    //                 window.alert('Email setting not changed Please Try Again!');
    //                 window.location.href='aicte_email_setup.php';
    //                 </script>";
    // }
    
// }
?>

<div class="container" style="padding:25px;">
<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;background-color:#F8F8F8;">

    <!-- <form method="post" action="../../AICTEcollegeinfo/SendMailToIncharge"> -->
    <form method="post">
        <div class="row">
            <div class="col-md-12 " align="center" style="color:#663399;">
                <h2>Send Email To <?= $incharge_name;?> For AICTE College Readiness</h2>
                <!-- <h5 align="center"><a href="Add_SubjectSheet_updated_20160109PT.php" >Add Excel Sheet</a></h5>  -->
                <br>
                <input type="hidden" name="cid" value="<?= $_GET['cid'];?>">
                <input type="hidden" name="incharge" value="<?= $_GET['in'];?>">
                <input type="hidden" name="incharge_name" value="<?= $incharge_name;?>">
                <br>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row" style="padding-top:30px;">
            <div class="col-md-offset-1 col-md-3" style="color:#808080;font-size:18px; ">Incharge Email ID:</div>
            <div class="col-md-3">
                <?= $incharge_email;?>
                <input type="hidden" name="incharge_email" value="<?= $incharge_email;?>">
            </div>
            <div class="col-md-2" style="color:#808080;font-size:18px;">Incharge Mobile:</div>
            <div class="col-md-3">
                <?= $incharge_mob;?>
                <input type="hidden" name="incharge_mobile" value="<?= $incharge_mob;?>">

            </div>
        </div>

        <div class="row" style="padding-top:30px;">
            <div class="col-md-offset-1 col-md-3" style="color:#808080;font-size:18px;">Sender Email ID:<span style="color:red;font-size: 25px;"></span></div>
            <div class="col-md-6">
                <select class="form-control searchselect" id="email_id" name="email_id" required>
                    <option>Select Sender Id</option>
                    <?php while($res_parameter=mysql_fetch_assoc($parameter_sql)){?>
                        <option value="<?= $res_parameter['e_id'];?>"><?= $res_parameter['email_id'];?></option>
                    <?php }?>
                </select>
            </div>
        </div>
        
        <div class="row" style="padding-top:30px;">
            <div class="col-md-offset-1 col-md-3" style="color:#808080;font-size:18px;"> Select Email Template :<span style="color:red;font-size: 25px;"></span></div>
            <div class="col-md-6">        
                <select class="form-control searchselect" id="email_template_id" name="email_template_id" required>
                    <option>Select Email Template</option>
                    <?php while($res_template=mysql_fetch_assoc($template_sql)){?>
                        <option value="<?= $res_template['id'];?>"><?= $res_template['subject'];?></option>
                    <?php }?>
                </select>
            </div>
            <br/><br/>
        </div>
    
        <div class="row" style="padding-top:15px;">
            <div class="col-md-2 col-md-offset-5 ">
                <input type="submit" class="btn btn-success" name="submit" value="Send SMS" id="btnValid"/>
            </div>
        </div>

        <div id="error" style="color:#F00;text-align: center;" align="center"></div>

            <div class="col-md-12" style="padding-top:30px;">
                <h3 class="text-center">Template Preview:</h3>
                <div class="col-md-12" id="email_body"></div>
                
            </div>


    </form>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
    <script src="../js/locale/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="../js/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('.searchselect').select2();
        $("#email_id").attr("required");
        $("#email_template_id").attr("required");
        
        $('#email_template_id').change(function() {
            var base_url = "<?php echo $GLOBALS['URLNAME'];?>";
            var value = $(this).val();
            //var value = '8';

            $.ajax({
                    type: "POST",
                    url: base_url + '/core/EmailSmsTemplate_ajax.php',
                    data: { id : value},
                    dataType: "json",
                    cache:false,
                    success: function(data) {
                        // $("#email_subject").html("Subject : " + data["subject"]);
                        $("#email_body").html(data["email_body"]);
                        
                        }       
                });
        });
            
    });
</script>
</body>
</html>