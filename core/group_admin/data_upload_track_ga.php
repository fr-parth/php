<?php
/*
Author : Pranali Dalvi
Date : 15-11-19
This file was created for tracking uploaded data of Schools under Group Admin
*/
/*Updated by Rutuja for design changes for SMC-4926 on 28-10-2020*/       
include("groupadminheader.php");

$groupID=$_SESSION['id'];

if (isset($_POST['search']))
{
    //Below queries modified (join taken on tables tbl_Batch_Master and tbl_school_admin) by Pranali for SMC-4193 on 26-11-19
    $sql = "SELECT sa.school_id,bm.tbl_display_name,bm.tbl_name,bm.inserted_date,sa.group_member_id,sa.school_name,sa.school_type,bm.Academic_Year 
        FROM tbl_school_datacount bm
        LEFT JOIN tbl_school_admin sa ON bm.school_id=sa.school_id
        WHERE sa.group_member_id='".$groupID."'";

    $qry="";
    //SMC-5126 by Pranali on 27/1/21 : Added all received values in session and displayed in input fields after search is performed
    //$_SESSION['academic_year'] = $_POST['academic_year'];
   // $_SESSION['school_id'] = $_POST['school_name'];
    $_SESSION['date_type'] = $_POST['date_type'];
    $_SESSION['from_date'] = $_POST['from_date'];
    $_SESSION['to_date'] = $_POST['to_date'];

    /*if ($_SESSION['academic_year'] != '') {
   
        $qry .=" AND bm.academic_year='".$_SESSION['academic_year']."'";
    }
    if($_SESSION['school_id'] != ''){
        $qry .=" AND bm.school_id='".$_SESSION['school_id']."'";
    }*/
    if($_SESSION['date_type']=="expected")
    {
        if($_SESSION['from_date']=="" && $_SESSION['to_date']!=""){
            $qry.=" AND date_format(bm.inserted_date,'%Y-%m-%d') <='".$_SESSION['to_date']."'  ";
        }
        else if($_SESSION['from_date']!="" && $_SESSION['to_date']==""){
            $qry.=" AND date_format(bm.inserted_date,'%Y-%m-%d') >'".$_SESSION['from_date']."'";
        }
        else if($_SESSION['from_date']!="" && $_SESSION['to_date']!=""){
            $qry.=" AND date_format(bm.inserted_date,'%Y-%m-%d') BETWEEN '".$_SESSION['from_date']."' AND '".$_SESSION['to_date']."' ";
        }
    }
    if($_SESSION['date_type']=="school_activation")
    {
        if($_SESSION['from_date']=="" && $_SESSION['to_date']!=""){
            $qry.=" AND date_format(sa.accept_terms_date,'%Y-%m-%d') <='".$_SESSION['to_date']."'  ";
        }
        else if($_SESSION['from_date']!="" && $_SESSION['to_date']==""){
            $qry.=" AND date_format(sa.accept_terms_date,'%Y-%m-%d') >'".$_SESSION['from_date']."'";
        }
        else if($_SESSION['from_date']!="" && $_SESSION['to_date']!=""){
            $qry.=" AND date_format(sa.accept_terms_date,'%Y-%m-%d') BETWEEN '".$_SESSION['from_date']."' AND '".$_SESSION['to_date']."' ";
        }
    }
    
        
        // else{
        //     $qry.="  date_format(bm.inserted_date,'%Y-%m-%d') BETWEEN '".$from_date."' AND '".$to_date."'";
        // }
        
  $sql = $sql . $qry . " group by bm.school_id";

  //print_r($sql);exit;

}
else if (isset($_POST['btn_all']))
{
    $sql="SELECT * from tbl_school_admin WHERE group_member_id='".$groupID."'";
    // print_r($sql);exit;
}
else if (isset($_POST['btn_not_uploaded']))
{
    $btn_not_uploaded=1;
    $sql = "SELECT sa.school_id,bm.tbl_display_name,bm.tbl_name,bm.inserted_date,sa.group_member_id,sa.school_name,sa.school_type,bm.Academic_Year
            FROM tbl_school_datacount bm
            LEFT JOIN tbl_school_admin sa ON bm.school_id=sa.school_id
            WHERE sa.group_member_id='".$groupID."' AND bm.expected_records='0' group by bm.school_id";
    //$sql = "select *
               // FROM tbl_school_admin sa where sa.group_member_id='".$groupID."' and sa.school_id NOT IN (select school_id from tbl_school_datacount bm )";
}
else if (isset($_POST['btn_uploaded']))
{
    $sql = "SELECT sa.school_id,bm.tbl_display_name,bm.tbl_name,bm.inserted_date,sa.group_member_id,sa.school_name,sa.school_type,bm.Academic_Year
            FROM tbl_school_datacount bm
            LEFT JOIN tbl_school_admin sa ON bm.school_id=sa.school_id
            WHERE sa.group_member_id='".$groupID."' AND bm.expected_records!='0' group by bm.school_id";
    //$sql = "select *
                //FROM tbl_school_admin sa where sa.group_member_id='".$groupID."' and sa.school_id IN (select school_id from tbl_school_datacount bm )";
}
else{
        $sql = "SELECT sa.school_id,bm.tbl_display_name,bm.tbl_name,bm.inserted_date,sa.group_member_id,sa.school_name,sa.school_type,bm.Academic_Year 
            FROM tbl_school_datacount bm
            LEFT JOIN tbl_school_admin sa ON bm.school_id=sa.school_id
            WHERE sa.group_member_id='".$groupID."' group by bm.school_id";
}
        $row = mysql_query($sql);
        // print_r($sql);exit;
        $count1 = mysql_num_rows($row);

if(isset($_POST['reset'])) {
    
    unset($_SESSION['academic_year']);
    unset($_SESSION['school_id']);
    unset($_SESSION['date_type']);
    unset($_SESSION['from_date']);
    unset($_SESSION['to_date']);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>School List</title>
    <link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="..///code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="../css/datepicker.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    <script src="..///code.jquery.com/jquery-1.10.2.js"></script>
    <script src="../js/jquery-1.11.1.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="..///code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script type="text/javascript" src="../js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
    <!-- <style>
        @media only screen and (max-width: 800px) {
            /* Force table to not be like tables anymore */
            #no-more-tables table,
            #no-more-tables thead,
            #no-more-tables tbody,
            #no-more-tables th,
            #no-more-tables td,
            #no-more-tables tr {
                display: block;
            }
            /* Hide table headers (but not display: none;, for accessibility) */
            #no-more-tables thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
            #no-more-tables tr {
                border: 1px solid #000000;
                font-weight: bold;
            }
            #no-more-tables td {
                /* Behave  like a "row" */
                border: none;
                border-bottom: 1px solid #000000;
                position: relative;
                padding-left: 50%;
                white-space: normal;
                text-align: left;
                font: Arial, Helvetica, sans-serif;
                font-weight:bold;
            }
            #no-more-tables td:before {
                /* Now like a table header */
                position: absolute;
                /* Top/left values mimic padding */
                top: 6px;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                text-align: left;
                font-weight:bold;
            }
            /*
            Label the data
            */
            #no-more-tables td:before {
                content: attr(data-title);
                font-weight:bold;
            }
        }
        .sortable{
                cursor: pointer;
        }
    </style> -->
    
    <script>
        $(document).ready(function () {
            $('#data_upload_tbl').dataTable({});
        });
    </script>
    
</head>
<body>
<div class="container">
<div align="center">
    <!-- <div class="row" style="padding-top:30px;"> -->
        <form method="POST">
            <div>
                <h2 style="padding-left:20px; margin-top:2px;color:#333;font-family:Times New Roman, Times, serif;font-size:30px;">My Data Upload Status</h2>
            </div>
        <br>
        <!--<div class="row">
            <div class="col-md-2" style="font-weight:bold;font-size:120%;"> Academic Year</div>
            <div class="col-md-2" >

                <select name="academic_year" class="form-control searchselect">
                    <?php $query = mysql_query("SELECT distinct(Academic_Year) FROM tbl_academic_Year where Enable='1' AND Academic_Year!=''"); ?>
                    <option value="">All</option>
                    <?php $j = 1;
                    while ($test = mysql_fetch_array($query)) {
                        ?>
                        <option value="<?php echo $test['Academic_Year']; ?>" <?php 
                            if($_SESSION['academic_year']==$test['Academic_Year'])
                                echo "selected";

                           ?>>
                            <?php 
                            echo $test['Academic_Year']; ?></option>
                        <?php $j++;
                    }
                    ?>
                </select></div>

                <div class="col-md-2 pull-left" style="font-weight:bold;font-size:120%;"> School Name</div>
            <div class="col-md-6" >

                <select name="school_name" class="form-control searchselect">
                    <?php $query = mysql_query("SELECT distinct(school_name),school_id FROM tbl_school_admin WHERE group_member_id='$groupID'"); ?>
                    <option value="" style="font-weight:bold">All</option>
                    <?php $j = 1;
                    while ($test = mysql_fetch_array($query)) {
                        ?>
                        <option value="<?php echo $test['school_id'] ?>"
                            <?php 
                            if($_SESSION['school_id']==$test['school_id'])
                                echo "selected";

                            ?> 

                            ><?php echo ucwords($test['school_name']); ?></option>
                        <?php $j++;
                    }
                    ?>
                </select></div>
            </div>-->
    <div class="clear-fix" style="clear: both"></div>
<br>
<!--Added from date and to date filters for SMC-5126 on 27/1/21-->
<div class="row">
            <div class="col-md-2" style="font-weight:bold;font-size:120%;"> Date Type </div>
            <div class="col-md-2" >
                <select class="form-control" name="date_type" id="date_type">
                  <option value="">Select</option>
                  <option value="expected" <?php 
                            if($_SESSION['date_type']=='expected')
                                echo "selected";

                            ?>  >Expected Records</option>
                  <option value="school_activation"
                  <?php 
                            if($_SESSION['school_id']=='school_activation')
                                echo "selected";

                            ?> >School Activation</option>
                  
                </select>
            </div>

            <div class="col-md-2" style="font-weight:bold;font-size:120%;"> From Date </div>
            <div class="col-md-2" >
                <input type="text" name="from_date" id="from_date" autocomplete="off" class="form-control" value="<?php if(isset($_SESSION['from_date'])) echo  $_SESSION['from_date']; ?>" />
            </div>
                
             <div class="col-md-2" style="font-weight:bold;font-size:120%;"> To Date </div>
            <div class="col-md-2" >
                <input type="text" name="to_date" id="to_date" autocomplete="off" class="form-control" value="<?php if(isset($_SESSION['to_date'])) echo  $_SESSION['to_date']; ?>" />
            </div>

</div>
<div class="clear-fix" style="clear: both"></div> <br>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-2"><input type="submit" name="search" value="Search" class="btn btn-success pull-right" style="font-weight:bold"></div>
            <div class="col-md-2 "><input type="submit" name="reset" value="Reset" class="btn btn-danger pull-left" style="font-weight:bold"></div>
            <!-- <div class="col-md-1" >
            <input type="button" class="btn btn-info" value="Reset" onclick="window.open('data_upload_track_ga.php','_self')" />
            </div> -->
        </div>
       <!--  </div> -->
           </form>
     </div>

    <div class="row">
        <form method="post">
            
            <?php if(isset($_POST['btn_uploaded'])){ ?>
                <input type="submit" name="btn_all" id="btn_all" class="btn btn-success" value="All Records">
            <input type="submit" name="btn_not_uploaded" id="btn_not_uploaded" class="btn btn-success" value="Expected Data Not Given">
        <?php }
        else if(isset($_POST['btn_not_uploaded'])){?>
            <input type="submit" name="btn_all" id="btn_all" class="btn btn-success" value="All Records">
            <input type="submit" name="btn_uploaded" id="btn_uploaded" class="btn btn-success" value="Expected Data Given">
        <?php }
else{?>
<input type="submit" name="btn_all" id="btn_all" class="btn btn-success" value="All Records">
            <input type="submit" name="btn_not_uploaded" id="btn_not_uploaded" class="btn btn-success" value="Expected Data Not Given">
<?php    }     ?>
        </form>
    </div>
    <br>
    <!-- <div> -->

        <div class="row" >
            <?php if(isset($_POST['btn_not_uploaded'])){ ?>
                <h2><center><b>Expected Data Not Given</b></center></h2>
           <?php }
            else if(isset($_POST['btn_uploaded']))
            { ?>
                <h2><center><b>Expected Data Given</b></center></h2>
           <?php  }
            else if(isset($_POST['btn_all']))
            { ?>
                <h2><center><b>All Schools</b></center></h2>
           <?php }
            else
            { ?>
                <h2><center><b>Expected Data Given</b></center></h2>
           <?php }
            ?>
            <table id="data_upload_tbl" class="col-md-12 table-bordered">
              <thead>
               <tr style="background-color:#0073BD; color:#ffffff;font-family:Times New Roman, Times, serif;font-size:17px">
                    <th>Sr.No.</th>
                    <th>Academic Year</th>
                    <th>School ID</th>
                    <th>School Name</th>
                    <th>Preview Uploaded Details</th>
                </tr>
                </thead>
                <?php $i = 1;
                    
                 $site = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME']; 
                 //print_r($result);exit;
                while ($result = mysql_fetch_array($row)){                      ?>
                
                <tr style="font-family:Times New Roman, Times, serif;font-size:17px; color:#333;">
                    <td data-title="Sr.No."><?php echo $i; ?></td>
                    <td data-title="Academic Year"><?php echo $result['Academic_Year'];?></td>
                    <td data-title="School ID"><?php echo $result['school_id'];?></td>
                    <td data-title="School Name"><?php echo $result['school_name'];?></td>
                    <td data-title="Upload Preview">
                    <?php $school_id=$result['school_id']; 
                         $school = mysql_query("SELECT school_name FROM tbl_school_admin WHERE school_id='$school_id'");
                         $school1 = mysql_fetch_assoc($school); 
                         $school_name = $school1['school_name'];

                         //     $url=$_SERVER[REQUEST_SCHEME].'://'.$server_name.'/core/Version4/School_Data_Upload_Tracking_API.php';
                         // $data=array('SchoolID'=>$school_id,'GroupID'=>$group_id,'Academic_Year'=>$Academic_Year);
                         $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
                         $url = $protocol.'://'.$_SERVER['SERVER_NAME'].'/core/Version6/Upload_Data_Status_Segregation_API.php';
                         $data = array('GroupID'=>$group_id,'SchoolID'=>$school_id,'School_Type'=>$school_type);
                         
                         $ch = curl_init($url);             
                         $data_string = json_encode($data);    
                         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
                         curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
                         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
                         curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
                         $upload_status = json_decode(curl_exec($ch),true);
                         // foreach($upload_status as $res)
                         // {
                             // print_r($res['total_percent']);exit;
                         // }
                    ?>
                        <input type="submit" width="100px" value="<?php  if($upload_status['total_percent']==""){ echo "0%"; }else if($upload_status['total_percent']>100){ echo "100%"; } else{ echo $upload_status['total_percent']."%"; }?>" name="upload_preview" onClick="window.location.href='data_upload_details_ga.php?school_id=<?php echo $result['school_id'] ?>&Academic_Year=<?php echo $result['Academic_Year']?>&school_type=<?php echo $result['school_type']?>&action=<?php echo $btn_not_uploaded ?>'" class="" style="font-size: 17px;" />
                    </td>
                </tr>   
                    <?php $i++;
                    }
                    ?>
            </table>            
        </div>
    <!-- </div> -->   <!--end of center content -->
</div>
</div>
</body>
<script type="text/javascript">
    $(function () {
        $('#from_date').datepicker({
          format:'yyyy-mm-dd',
          endDate: '0d',
          changeMonth:true,
          changeYear:true,
          autoClose:true
        });

        $('#to_date').datepicker({
          format:'yyyy-mm-dd',
          endDate: '0d',
          changeMonth:true,
          changeYear:true,
          autoClose:true
       });

        $('.searchselect').select2();
    });
</script>
</html>