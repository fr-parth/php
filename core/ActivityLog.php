<?php
include('scadmin_header.php');
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$school_id=$result['school_id'];
/*echo date_default_timezone_get()."<br>";
echo $_SERVER['HTTP_USER_AGENT'];*/
/*echo date("Y-m-d h:i:s"); */
error_reporting(0);

//below condition added by Pranali for SMC-4139 on 21-4-20
if(isset($_POST['submit']))
{
  $from_date2 = $_POST['from_date'];
  $from_time = $_POST['from_time'];
  $to_date2 = $_POST['to_date'];
  $to_time = $_POST['to_time'];

if($from_date2==''){
  $from_date2 = Date('yy-m-d');
}

if($to_date2==''){
  $to_date2 = Date('yy-m-d');
}

$from_date1=strtotime($from_date2);
$to_date1=strtotime($to_date2);

  $from_date = @date("Y-m-d", $from_date1 );
  $to_date = @date("Y-m-d", $to_date1 );

  if($from_time==''){
    $from_time = '00:00:00';
  } 
  if($to_time==''){
    $to_time = '23:59:59';
  }
  $from_date_time = $from_date.' '.$from_time;
  $to_date_time = $to_date.' '.$to_time;

   $current_date = Date('yy-m-d');
   $sql = "SELECT `ActivityLogID`,`EntityID`,`Entity_type`,`EntityID_2`,`Entity_Type_2`,`Timestamp`,`Activity`,`quantity`,`school_id` FROM `tbl_ActivityLog` WHERE school_id='".$school_id."' AND `Timestamp` BETWEEN '".$from_date_time."' AND '".$to_date_time."' order by ActivityLogID desc";
}
else{
  $current_date = Date('yy-m-d');
  $sql = "SELECT `ActivityLogID`,`EntityID`,`Entity_type`,`EntityID_2`,`Entity_Type_2`,`Timestamp`,`Activity`,`quantity`,`school_id` FROM `tbl_ActivityLog` WHERE school_id='".$school_id."' AND `Timestamp` like '%$current_date%' order by ActivityLogID desc";
}
//echo $sql;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta charset="utf-8">
  <title>Smart Cookies</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">


  <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/jq-2.2.3/dt-1.10.12/af-2.1.2/b-1.2.2/b-colvis-1.2.2/b-flash-1.2.2/b-print-1.2.2/cr-1.3.2/fc-3.2.2/fh-3.1.2/kt-2.1.3/r-2.1.0/rr-1.1.2/sc-1.4.2/se-1.2.0/datatables.min.css"/>

  <script type="text/javascript" src="https://cdn.datatables.net/v/bs/jq-2.2.3/dt-1.10.12/af-2.1.2/b-1.2.2/b-colvis-1.2.2/b-flash-1.2.2/b-print-1.2.2/cr-1.3.2/fc-3.2.2/fh-3.1.2/kt-2.1.3/r-2.1.0/rr-1.1.2/sc-1.4.2/se-1.2.0/datatables.min.js"></script>
  <link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>

   
    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>

    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <script src="js/jquery.twbsPagination.js" type="text/javascript"></script>
    <script>

  <script>

    $(document).ready(function() {

      $('#example').dataTable( {
       "order": [[ 8, "desc" ]]


     } );

    } );

  </script>
  



  

  <style>

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



      #no-more-tables tr { border: 1px solid #ccc; }



      #no-more-tables td {

        /* Behave  like a "row" */

        border: none;

        border-bottom: 1px solid #eee;

        position: relative;

        padding-left: 50%;

        white-space: normal;

        text-align:left;

        font:Arial, Helvetica, sans-serif;

      }



      #no-more-tables td:before {

        /* Now like a table header */

        position: absolute;

        /* Top/left values mimic padding */

        top: 6px;

        left: 6px;



        padding-right: 10px;

        white-space: nowrap;


      }



    /*

    Label the data

    */

    #no-more-tables td:before { content: attr(data-title); }

  }

</style>    
<!--valid() added by Pranali for date validation -- >   
  <script type="text/javascript">
function valid(){
  alert('in valid');
  var from = document.getElementById("from_date").value;
  var myDate = new Date(from);
  var today = new Date();
                   
 if(from == "") {
        alert('Please select date');
        return false;
 }
 else if(myDate.getFullYear() > today.getFullYear()) {

        alert('Please select valid date');
        return false;

  }
  else if(myDate.getFullYear() == today.getFullYear()) {

      if (myDate.getMonth() == today.getMonth()) {
                                
          if (myDate.getDate() > today.getDate()) {

              alert('Please select valid date');
              return false;
          }                    
          
      }

  else if (myDate.getMonth() > today.getMonth()) {
      alert('Please select valid date');
      return false;

  }                
          
  }          
          
  var to = document.getElementById("to_date").value;
  var myDate1 = new Date(to);
  var today1 = new Date();
                    
    
   if(to == "") {
        alert('Please select date');
        return false;
 }
 else if(myDate1.getFullYear() > today1.getFullYear()) {

         alert('Please select valid date');
          return false;
      
    }
    else if(myDate1.getFullYear() == today1.getFullYear()) {

      if (myDate1.getMonth() == today1.getMonth()) {
                                
          if (myDate1.getDate() > today1.getDate()) {
          
            alert('Please select valid date');
            return false;
        }
                                
        
    }

    else if(myDate1.getMonth() > today1.getMonth()) {
      alert('Please select valid date');
      return false;

    }
                            
  }

    if(myDate.getFullYear() > myDate1.getFullYear())
    {
      alert('Start Date should be less than End Date');
      return false;
    }

    else if(myDate.getFullYear() == myDate1.getFullYear())
    {
        if(myDate.getMonth() == myDate1.getMonth()){

          if(myDate.getDate() > myDate1.getDate()) {

          alert('Start Date should be less than End Date');
          return false;
          }
          
        }
        else if (myDate.getMonth() > myDate1.getMonth()) {
          alert('Start Date should be less than End Date');
          return false;

        }
                            
    }
}
</script>      
</head>
<body>

 <div style="bgcolor:#CCCCCC">



  <div class="" style="padding:30px;" >

   <div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">



    <div style="background-color:#F8F8F8 ;">

      <div class="row">

        <div class="col-md-0 "  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;

          <!-- <a href="Add_degree.php"> <input type="submit" class="btn btn-primary" name="submit" value="Add Degree" style="font-weight:bold;font-size:14px;"/></a>      -->

        </div>

        <div class="col-md-10 " align="center"  >

          <div style="font-size:34px;">Activity Log</div>

        </div>



      </div>
<!--Below filters added by Pranali for displaying list according to selected filter for SMC-4139 on 21-4-20-->
      <div class="row" style="padding:50px;" >

      <!-- <div class='row' style="margin-left:20px;"> -->
       <form method="POST" action="">
        <label class='control-label' for='from_date' style="text-align:left;">From Date :</label>&nbsp;&nbsp;<input type="text" name="from_date" id="from_date" class='datepicker' autocomplete="off">&nbsp;&nbsp;

        <label class='control-label' for='from_time' style="text-align:left;">From Time :</label>&nbsp;&nbsp;<input type="time" name="from_time" id='from_time' autocomplete="off">&nbsp;&nbsp;

        <label class='control-label' for='to_date' style="text-align:left;">To Date :</label>&nbsp;&nbsp;<input name="to_date" id='to_date' class='datepicker' autocomplete="off">&nbsp;&nbsp;


        <label class='control-label' for='to_time' style="text-align:left;">To Time :</label>&nbsp;&nbsp;<input type="time" name="to_time" id='to_time' autocomplete="off">
        &nbsp;&nbsp;
        <input type="submit" name="submit" value="Search" class="btn btn-primary" onclick='return valid();'>
      <!-- </div> -->
      </form>

       <div class="col-md-12  " id="no-more-tables" style="margin-top:30px;">

   <table id="example" class="display" width="100%" cellspacing="0">
        <thead>
            <th>From Entity 1</th>
            <th>Entity 1 Type</th>
            <!--<th>FirstLoginTime</th>
            <th>FirstMethod</th>
            <th>FirstDeviceDetails</th>
            <th>FirstPlatformOS</th>
            <th>FirstIPAddress</th>
            <th>FirstLatitude</th>
            <th>FirstLongitude</th>
            <th>FirstBrowser</th>-->
            <th>Activity</th>
            <th>To Entity 2</th>
            <th>Entity 2 Type</th>
            <th>Quantity in Unit</th>
            <th>Device Details</th>
            <th>Country Code</th>
            <th>Time</th>


            <!--<th>CountryCode</th> -->
          </thead>

          <tbody>
           <?php

           $table = "";
           $ent_type ="";
           $name = "";
           function checkEntity($entity)
           {
             $school_type = $_SESSION['school_type'];
             $user=$_SESSION['usertype'];
             $data = array();
             switch($entity)
             {



              case 105:

              $data['table'] = "tbl_student";
          //if conition added by Sayali Balkawade for SMC-4128 on 30/09/2019 
          //$data['tid'] ="std_PRN"; and $data['school_id'] = "school_id"; added by Pranali for SMC-4139 on 13-4-20
              if ($school_type == 'organization' && $user=='HR Admin')
              {
                $data['ent_type'] = "EMPLOYEE";
              }
              else{
                $data['ent_type'] = "STUDENT";
              }
              $data['name'] ="std_complete_name";
              $data['tid'] ="std_PRN";
              $data['id'] ="id";
              $data['school_id'] = "school_id";
              break;

              case 103:
              $data['table'] = "tbl_teacher";

              if ($school_type == 'organization' && $user=='HR Admin')
              {
                $data['ent_type'] = "MANAGER";
              }
              else{
                $data['ent_type'] = "TEACHER";
              }

              $data['name'] ="t_complete_name";
              $data['tid'] ="t_id";
              $data['id'] ="id";
              $data['school_id'] = "school_id";

              break;
              case 108:
              $data['table'] = "tbl_sponsorer";
              $data['ent_type'] = "SPONSOR";
              $data['name'] ="sp_company";
              $data['id'] ="id";
              break;
            }
            return $data;
          }

          //$current_date = Date('yy-m-d');
          //$sql = "SELECT `ActivityLogID`,`EntityID`,`Entity_type`,`EntityID_2`,`Entity_Type_2`,`Timestamp`,`Activity`,`quantity`,`school_id` FROM `tbl_ActivityLog` WHERE school_id='".$school_id."' AND `Timestamp` like '%$current_date%' order by ActivityLogID desc";
          $query = mysql_query($sql);
          while ($row = mysql_fetch_assoc($query))
          {
            /*Entity 1  */
            $data =  checkEntity($row['Entity_type']);
            $entity_type = $data['ent_type'];
        //if else condition for tid removed and combined both query into single query by Pranali for SMC-4139 on 12-4-20
            $sql1 = "SELECT ".$data['name']." as name from ".$data['table']." WHERE ".$data['id']." ='".$row['EntityID']."' OR (".$data['tid']." ='".$row['EntityID']."' AND ".$data['school_id']." ='".$row['school_id']."') ";

            $q = mysql_query($sql1);
            $row1 = mysql_fetch_array($q);

            /* Entity 2    */
            $data1 =  checkEntity($row['Entity_Type_2']);
            $entity_type2 = $data1['ent_type'];

      //if else condition for tid removed and added condition for receiver entity by Pranali for SMC-4139 on 13-4-20
            if($row['Entity_Type_2']==108){
             $sql2 = "SELECT ".$data1['name']." as name from ".$data1['table']." WHERE ".$data1['id']." ='".$row['EntityID_2']."'";
            }
            else{
              $sql2 = "SELECT ".$data1['name']." as name from ".$data1['table']." WHERE ".$data1['id']." ='".$row['EntityID_2']."' OR (". $data1['tid']."='".$row['EntityID_2']."' AND ". $data1['school_id']."='".$row['school_id']."')";           
            }
            $sql2_res = mysql_query($sql2);
            $Ent2_name = mysql_fetch_array($sql2_res);

            /* Device Information */
           //below if condition added by Pranali to fetch member id of teacher for SMC-4629 on 12-4-20
            if(($row['Entity_type']==103 || $row['Entity_type']==203) && $row['Entity_Type_2']!=108)
            {
              $sql3_res=mysql_query("SELECT id 
                FROM tbl_teacher t 
                WHERE t_id='".$row['EntityID']."' AND school_id='".$row['school_id']."'");
              $teacher_info = mysql_fetch_array($sql3_res);
              
              $sql4_res=mysql_query("SELECT `LatestMethod`,`LatestDeviceDetails`,`CountryCode` FROM `tbl_LoginStatus` WHERE `EntityID`='".$teacher_info['id']."' AND`Entity_type`='".$row['Entity_type']."'");
              $device = mysql_fetch_array($sql4_res);
              
            }
            else{
              $sql4_res=mysql_query("SELECT `LatestMethod`,`LatestDeviceDetails`,`CountryCode` FROM `tbl_LoginStatus` WHERE `EntityID`='".$row['EntityID']."' AND`Entity_type`='".$row['Entity_type']."'");

              $device = mysql_fetch_array($sql4_res);
            }


            ?>
            <tr>
              <td><?php echo strtoupper($row1['name']); ?></td>


              <td><?php echo $entity_type; ?></td>

              <td><?php echo $row['Activity']; ?></td>
              <td><?php echo strtoupper($Ent2_name['name']); ?></td>
              <td><?php echo $entity_type2; ?></td>
              <td><?php echo $row['quantity']; ?></td>
              <td><?php echo $device['LatestDeviceDetails']."<br>(".$device['LatestMethod'].")"; ?></td>
              <!-- <td><?php //if($row['LogoutTime']!="") {echo $row['LogoutTime'];}else{echo "<div style='color:#428BCA'>Running</div>";} ?></td>   -->
              <td><?php echo $device['CountryCode']; ?></td>
              <td><?php echo $row['Timestamp']; ?></td>
              <!--<td><?php //echo $row['LatestPlatformOS']; ?></td>
              <td><?php //echo $row['LatestIPAddress']; ?></td>
              <td><?php //echo $row['LatestBrowser']; ?></td>-->

            </tr>

          <?php } ?>
        </tbody>
      </table>

    </div>

  </div>

  <div class="row" style="padding:5px;">

   <div class="col-md-4">

   </div>

   <div class="col-md-3 "  align="center">

   

 </div>

</div>

<div class="row" >

 <div class="col-md-4">

 </div>

 <div class="col-md-3" style="color:#FF0000;" align="center">

  <?php //echo $report;?>

</div>
</div>
</div>
</div>
</body>
  
  <script>
        $(function () {
            $("#from_date").datepicker({
               // changeMonth: true,
                //changeYear: true
        dateFormat: 'yy-mm-dd',
      maxDate:0
            });
        });
        $(function () {
            $("#to_date").datepicker({
                //changeMonth: true,
                //changeYear: true,
        dateFormat: 'yy-mm-dd',
        maxDate:0
            });
        });
    </script>

</html>