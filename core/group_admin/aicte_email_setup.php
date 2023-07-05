<html>
<head>

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

$query1 = "select * from aicte_email_setup WHERE group_member_id='$group_member_id'";
    $res = mysql_num_rows(mysql_query($query1));
    $row_res=mysql_fetch_assoc(mysql_query($query1));
    
    if (isset($_POST['submit'])) {
    
    $email_id = $_POST['email_id'];
    $is_active = $_POST['is_active'];
    $email_temp = $_POST['email_template_id'];
    // $sms_temp = $_POST['sms_template_id'];

    if($res>0){
        $update_query = "UPDATE aicte_email_setup SET email_id='$email_id', email_template_id='$email_temp', sms_template_id='$email_temp', is_active='$is_active' WHERE group_member_id='$group_member_id'";
        // echo $update_query; exit;
       $main_sql=mysql_query($update_query);
    }else{
        $insert_query="INSERT INTO aicte_email_setup SET email_id='$email_id', email_template_id='$email_temp', sms_template_id='$email_temp', is_active='$is_active', group_member_id='$group_member_id'";
       $main_sql=mysql_query($insert_query);
    }
    
    if($main_sql){
        echo "<script LANGUAGE='JavaScript'>
                    window.alert('Email setting for AICTE College Readiness has been changed Successfully.');
                    window.location.href='aicte_email_setup.php';
                    </script>";
    }else{
        echo "<script LANGUAGE='JavaScript'>
                    window.alert('Email setting not changed Please Try Again!');
                    window.location.href='aicte_email_setup.php';
                    </script>";
    }
    
}
?>

<div class="container" style="padding:25px;">
<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;background-color:#F8F8F8;">

    <form method="post">

        <div class="row">

            <div class="col-md-3 col-md-offset-1" style="color:#700000 ;padding:5px;"></div>

            <div class="col-md-6 " align="center" style="color:#663399;">

                <h2>AICTE College Readiness Email Setup</h2>
                <!-- <h5 align="center"><a href="Add_SubjectSheet_updated_20160109PT.php" >Add Excel Sheet</a></h5>  -->
                <br><br>
            </div>


        </div>

       <div class="row" style="padding-top:30px;">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-2" style="color:#808080;font-size:18px; margin-left:12px">Email ID:<span style="color:red;font-size: 25px;"></span></div>
                                    <div class="col-md-3">

                <select class="form-control" id="email_id" name="email_id" required>
                    <option>Select Email Id</option>
                    <?php while($res_parameter=mysql_fetch_assoc($parameter_sql)){?>
                        <option <?php if ($row_res['email_id']==$res_parameter['e_id']){ echo "selected";} ?> value="<?= $res_parameter['e_id'];?>"><?= $res_parameter['email_id'];?></option>
                    <?php }?>
                </select>

            </div>
            
         </div>
        
           
    
    
    
             <div class="row" style="padding-top:30px;">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-2" style="color:#808080;font-size:18px;margin-left:14px"> Select Email Template :<span style="color:red;font-size: 25px;"></span></div>
                                    <div class="col-md-3">
                
                <select class="form-control" id="email_template_id" name="email_template_id" required>
                    <option>Select Email Template</option>
                    <?php while($res_template=mysql_fetch_assoc($template_sql)){?>
                        <option <?php if ($row_res['email_template_id']==$res_template['id']){ echo "selected";} ?> value="<?= $res_template['id'];?>"><?= $res_template['subject'];?></option>
                    <?php }?>
                </select>

            </div>

            <br/><br/>
        </div>
    
        <div id="error" style="color:#F00;text-align: center;" align="center"></div>

            <div class="row" style="padding-top:30px;">
                <div class="col-md-4"></div>
                <div class="col-md-2" style="color:#808080; font-size:18px; margin-left: 13px;" > Auto send on form Submit<span
                            style="color:red;font-size: 25px;"></span></div>
                <div class="col-md-3">
                    <select name="is_active" id="is_active" class="form-control" required>
                        <option <?php if ($row_res['is_active']==1){ echo "selected";} ?> value="1" >Yes</option>
                        <option <?php if ($row_res['is_active']==0){ echo "selected";} ?> value="0" >No</option>
                    </select>
                </div>
            </div>

            <div class="col-md-12" style="padding-top:30px;">
                <h3 class="text-center">Template Preview:</h3>
                <div class="col-md-12" id="email_body"></div>
                
            </div>

        <div class="row" style="padding-top:15px;">
            <div class="col-md-2 col-md-offset-4 ">
                <input type="submit" class="btn btn-success" name="submit" value="Add" id="btnValid"/>
            </div>

            <div class="col-md-3 " align="left">
                <input type="reset" class="btn btn-primary" name="Back" value="Reset"/>
            </div>
        </div>

    </form>

</div>

<script type="text/javascript">
    $(document).ready(function(){
        <?php if($row_res['email_template_id']!=""){?>
        var base_urls = "<?php echo $GLOBALS['URLNAME'];?>";
            var em_id = <?= $row_res['email_template_id'];?>;
            //var value = '8';

            $.ajax({
                    type: "POST",
                    url: base_urls + '/core/EmailSmsTemplate_ajax.php',
                    data: { id : em_id},
                    dataType: "json",
                    cache:false,
                    success: function(data) {
                        // $("#email_subject").html("Subject : " + data["subject"]);
                        $("#email_body").html(data["email_body"]);
                        
                        }       
            });
        <?php } ?>
    //     $("#ac_year").datepicker();

        $("#is_active").change(function(){
            var isAct = $(this).val();
            if(isAct=="1"){
                $("#email_id").attr("required");
                $("#email_template_id").attr("required");
                
            }else{
                $("#email_id").removeAttr("required");
                $("#email_template_id").removeAttr("required");
                
            }
        });
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