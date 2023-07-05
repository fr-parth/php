<?php

include('cookieadminheader.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
        $(document).ready(function () {
            $('#example').dataTable({});
        });
    </script>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
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

            #no-more-tables tr {
                border: 1px solid #ccc;
            }

            #no-more-tables td {

                /* Behave  like a "row" */

                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
                white-space: normal;
                text-align: left;
                font: Arial, Helvetica, sans-serif;
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
           /*Label the data*/
            #no-more-tables td:before {
                content: attr(data-title);
            }
        }
    </style>
</head>



<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
<script type="text/javascript">
function valid(){
  
  var from = document.getElementById("from_date").value;
  var myDate = new Date(from);
  var today = new Date();
                   
 
  if(myDate.getFullYear() > today.getFullYear()) {

        alert('Please select valid from date');
        return false;

  }
  else if(myDate.getFullYear() == today.getFullYear()) {

      if (myDate.getMonth() == today.getMonth()) {
                                
          if (myDate.getDate() > today.getDate()) {

              alert('Please select valid from date');
              return false;
          }                    
          
      }

  else if (myDate.getMonth() > today.getMonth()) {
      alert('Please select valid from date');
      return false;

  }                
          
  }          
          
  var to = document.getElementById("to_date").value;
  var myDate1 = new Date(to);
  var today1 = new Date();
                    
    
 
  if(myDate1.getFullYear() > today1.getFullYear()) {

         alert('Please select valid to date');
          return false;
      
    }
    else if(myDate1.getFullYear() == today1.getFullYear()) {

      if (myDate1.getMonth() == today1.getMonth()) {
                                
          if (myDate1.getDate() > today1.getDate()) {
          
            alert('Please select valid to date');
            return false;
        }
                                
        
    }

    else if(myDate1.getMonth() > today1.getMonth()) {
      alert('Please select valid to date');
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
<body>

<div style="bgcolor:#CCCCCC">
    <div class="" style="padding:30px;">
        <div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
            <div style="background-color:#F8F8F8 ;">
                <div class="row">
                    <div class="col-md-0 " style="color:#700000 ;padding:5px;">&nbsp;&nbsp;&nbsp;&nbsp;
                        <!-- <a href="Add_degree.php"> <input type="submit" class="btn btn-primary" name="submit" value="Add Degree" style="font-weight:bold;font-size:14px;"/></a>      -->
                    </div>

                    <div class="col-md-10 " align="center">

                        <h2>Login Status </h2>
                    <!-- </div> -->

                     
    <form method="POST" action="">
          
             <div class="col-md-3 ">
                <label>Select Entity Type<b style="color:red;"> *</b></label>
                <select name="Entity_type" class=" form-control" style="text-indent:30%">
                   <option value="All" style="text-indent:30%">All</option>
                   <?php 
                   $sql="SELECT `sc_id`,`sc_entities` FROM `tbl_entites` group by sc_entities";
                   $res=mysql_query($sql);
                   $result=mysql_fetch_array($res);
                  
                   while($value=mysql_fetch_array($res)){ ?>
                    <option value="<?php echo $value['sc_entities'] ; ?>" <?php if(isset($_POST['Entity_type'])){ if($value['sc_entities']==$_POST['Entity_type']) { echo "selected" ; } } ?> style="text-indent:30%"><?php echo $value['sc_entities'] ; ?></option>
                   <?php }
                   ?>
                </select>
            </div> 
            <div class="col-md-3 form-group has-success">
                <label>School ID/Organization ID<b style="color:red;"> *</b></label>
                <input  class="form-control"  type="text" name="school_id" placeholder="School ID" value="<?php if(isset($_POST['school_id'])) { echo $_POST['school_id']; }?>">
            </div>
            <div class="form-group col-md-3">
               
                 <label class='control-label' for='from_date' style="text-align:left;">From Date :<b style="color:red;"> *</b></label>&emsp;<input name="from_date" id='from_date' value="<?php if (isset($_POST['from_date'])){ echo $_POST['from_date']; } else { echo date("Y-m-01 h:i:s"); }?>" class='datepicker form-control' autocomplete="off" placeholder="From Date">&emsp;
             
            </div>

            <div class="form-group col-md-3">
                <label class='control-label' for='to_date' style="text-align:left;">To Date :<b style="color:red;"> *</b></label>&emsp;<input name="to_date" id='to_date' value="<?php if (isset($_POST['to_date'])){ echo $_POST['to_date']; } else { echo date("Y-m-d h:i:s"); } ?>" class='datepicker form-control' autocomplete="off" placeholder="To Date">&emsp;
                
            </div>
       
            <div class="form-group col-md-2">
                <input type="submit" name="submit" value="Submit" class="btn btn-primary" onclick='return valid();' style="margin-left: 1080px;margin-top:-70px;">
            </div>
            <div class="form-group col-md-2">
                <input type="button" class="btn btn-info" value="Reset" onclick="window.open('loginStatusCookie.php','_self')" style="margin-left: 1000px;margin-top:-70px;"/>
                                            
            </div>
      </form>
  </div>
                </div>


                <div class="row" style="padding:10px;">

                    <div class="col-md-12  " id="no-more-tables">

                        <table id="example" class="display" width="100%" cellspacing="0">
                            <thead>
                            <!-- Camel casing for Log Track No & School ID done by Pranali -->
                            <th>Sr. No.</th>
                            <th>Log Track No</th>
                            <th>Name</th>
                            <th>Entity Type/School ID</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            
                            <!--<th>FirstLoginTime</th>
                            <th>FirstMethod</th>
                            <th>FirstDeviceDetails</th>
                            <th>FirstPlatformOS</th>
                            <th>FirstIPAddress</th>
                            <th>FirstLatitude</th>
                            <th>FirstLongitude</th>
                            <th>FirstBrowser</th>-->
                            <th>Login Time</th>
                            <th>Logout Time</th>
                            <!--<th>LatestMethod</th>-->
                            <th>Device Details</th>
                            <th>Platform OS</th>
                            <th>IP Address</th>
                            <!--<th>LatestLatitude</th>
                            <th>LatestLongitude</th>-->
                           <!-- <th>Browser</th>-->

                            <!--<th>CountryCode</th> -->
                            </thead>

                            <tbody>
                            <?php
                            $i = 1;
                            $table = "";
                            $ent_type = "";
                            $name = "";
                            function checkEntity($entity)
                            {
                                $data = array();
                                switch ($entity) {
                                    case 105:
                                        $data['table'] = "tbl_student";
                                        $data['ent_type'] = "STUDENT";
                                        $data['name'] = "std_complete_name";
                                        $data['fname'] = "std_name";
                                        $data['mname'] = "std_Father_name";
                                        $data['lname'] = "std_lastname";
                                        break;
                                    case 203:
                                        $data['table'] = "tbl_teacher";
                                        $data['ent_type'] = "MANAGER";
                                        $data['name'] = "t_complete_name";
                                        $data['fname'] = "t_name";
                                        $data['mname'] = "t_middlename";
                                        $data['lname'] = "t_lastname";
                                        break;
                                        case 205:
                                        $data['table'] = "tbl_student";
                                        $data['ent_type'] = "EMPLOYEE";
                                        $data['name'] = "std_complete_name";
                                        $data['fname'] = "std_name";
                                        $data['mname'] = "std_Father_name";
                                        $data['lname'] = "std_lastname";
                                        break;
                                    case 103:
                                        $data['table'] = "tbl_teacher";
                                        $data['ent_type'] = "TEACHER";
                                        $data['name'] = "t_complete_name";
                                        $data['fname'] = "t_name";
                                        $data['mname'] = "t_middlename";
                                        $data['lname'] = "t_lastname";
                                        break;
                                    case 108:
                                        $data['table'] = "tbl_sponsorer";
                                        $data['ent_type'] = "SPONSOR";
                                        $data['name'] = "sp_name";
                                        break;
                                    case 116:
                                        $data['table'] = "tbl_salesperson";
                                        $data['ent_type'] = "SALESPERSON";
                                        $data['name'] = "p_name";
                                        break;
                                    case 113:
                                        $data['table'] = "tbl_cookieadmin";
                                        $data['ent_type'] = "cookieadmin";
                                        $data['name'] = "admin_email";
                                        break;
                                    case 102:
                                        $data['table'] = "tbl_school_admin";
                                        $data['ent_type'] = "schooladmin";
                                        $data['name'] = "name";
                                        break;
                                    case 115:
                                        $data['table'] = "tbl_school_adminstaff";
                                        $data['ent_type'] = "schooladminstaff";
                                        $data['name'] = "stf_name";
                                        break;
                                    case 114:
                                        $data['table'] = "tbl_cookie_adminstaff";
                                        $data['ent_type'] = "cookieadminstaff";
                                        $data['name'] = "stf_name";
                                        break;
                                    case 106:
                                        $data['table'] = "tbl_parent";
                                        $data['ent_type'] = "parent";
                                        $data['name'] = "Name";
                                        break;
    //new case added for spectator by Pranali for SMC-3750
                                    case 119:
                                        $data['table'] = "tbl_vol_spect_master";
                                        $data['ent_type'] = "spectator";
                                        $data['name'] = "name";
                                        break;
                                }
                                return $data;
                            }
 
                               

if(isset($_POST['submit']))
{
     
   $from_date2 = $_POST['from_date'];
    $from_time = $_POST['from_time'];
   $to_date2 = $_POST['to_date'];
  $to_time = $_POST['to_time'];
   $school_id = $_POST['school_id'];
  $Entity_type = $_POST['Entity_type'];
if($from_date2=='')
{
  $from_date2 = Date('yy-m-d');
}

if($to_date2=='')
{
  $to_date2 = Date('yy-m-d');
}

  $from_date1=strtotime($from_date2);
  $to_date1=strtotime($to_date2);

  $from_date = @date("Y-m-d", $from_date1 );
  $to_date = @date("Y-m-d", $to_date1 );

  if($from_time=='')
  {
    $from_time = '00:00:00';
  } 
  if($to_time=='')
  {
    $to_time = '23:59:59';
  }
 $from_date_time = $from_date.' '.$from_time;
  $to_date_time = $to_date.' '.$to_time;

   $current_date = date("Y-m-d h:i:s");
    $arr="SELECT `sc_id`,`sc_entities` FROM `tbl_entites` where sc_entities='".$Entity_type."' ";
    $query1 = mysql_query($arr);            
    $row2 = mysql_fetch_assoc($query1);
   // echo $row2['sc_id'];
    $arr1="SELECT `Entity_type` FROM `tbl_LoginStatus` where Entity_type='".$row2['sc_id']."'";
    $query2 = mysql_query($arr1);   
            
    $row3 = mysql_fetch_assoc($query2);
    
      if($Entity_type==$row2['sc_entities'])
      {
         $a=$row3['Entity_type'];
      }
      
    
      if($_POST['Entity_type']!='')
    {
        if($_POST['Entity_type']=='All')
        {
            $sql="SELECT `RowID`,`EntityID`,`Entity_type`,`LatestLoginTime`,`LogoutTime`,`LatestMethod`,`LatestDeviceDetails`,`LatestPlatformOS`,`LatestIPAddress`,`LatestBrowser`,`school_id`,`LatestLatitude`,`LatestLongitude` FROM `tbl_LoginStatus` WHERE `school_id`='".$school_id."' AND `LatestLoginTime` BETWEEN '".$from_date_time."' AND '".$to_date_time."' AND `LogoutTime` BETWEEN '".$from_date_time."' AND '".$to_date_time."' ORDER BY RowID DESC ";
             
        }
        else {
       $sql="SELECT `RowID`,`EntityID`,`Entity_type`,`LatestLoginTime`,`LogoutTime`,`LatestMethod`,`LatestDeviceDetails`,`LatestPlatformOS`,`LatestIPAddress`,`LatestBrowser`,`school_id`,`LatestLatitude`,`LatestLongitude` FROM `tbl_LoginStatus` WHERE `school_id`='".$school_id."' AND `Entity_type`='".$a."' AND `LatestLoginTime` BETWEEN '".$from_date_time."' AND '".$to_date_time."' AND `LogoutTime` BETWEEN '".$from_date_time."' AND '".$to_date_time."' ORDER BY RowID DESC ";
        }
        $_POST['Entity_type']='';
    } 
   }else{
     $from_date_time=date("Y-m-01 h:i:s");

  $current_date = date("Y-m-d h:i:s");
  // $sql = "SELECT `RowID`,`EntityID`,`Entity_type`,`LatestLoginTime`,`LogoutTime`,`LatestMethod`,`LatestDeviceDetails`,`LatestPlatformOS`,`LatestIPAddress`,`LatestBrowser`,`school_id`,`LatestLatitude`,`LatestLongitude` FROM `tbl_LoginStatus` ORDER BY RowID DESC LIMIT $start, $max";
    $sql = "";
}
 

                           
                            //echo $sql;//exit;
                            $query = mysql_query($sql);
                            while ($row = mysql_fetch_assoc($query)) {
                                $data = checkEntity($row['Entity_type']);
                                  $entity_type = $data['ent_type'];
                                if($entity_type=='STUDENT' || $entity_type=='TEACHER' ){
                                    $sql1 = "SELECT " . $data['name'] . " as name," . $data['fname'] . " as f," . $data['lname'] . " as l from " . $data['table'] . " WHERE id='" . $row['EntityID'] . "'";
                                     }
                                elseif($entity_type=='EMPLOYEE' || $entity_type=='MANAGER' ){
                                    $sql1 = "SELECT " . $data['name'] . " as name," . $data['fname'] . " as f," . $data['lname'] . " as l from " . $data['table'] . " WHERE id='" . $row['EntityID'] . "'";
                               
                                }elseif($entity_type=='SPONSOR'){
                                    $sql1 = "SELECT " . $data['name']." as name from ".$data['table'] . " WHERE id='" . $row['EntityID'] . "'";
                                }elseif($entity_type=='SALESPERSON'){
                                    $sql1 = "SELECT " . $data['name']." as name from ".$data['table'] . " WHERE person_id='" . $row['EntityID'] . "'";
                                }
                                elseif($entity_type=='cookieadmin'){
                                    $sql1 = "SELECT " . $data['name']." as name from ".$data['table'];
                                }
                                elseif($entity_type=='schooladmin'){
                                    $sql1 = "SELECT " . $data['name']." as name from ".$data['table'] . " WHERE id='" . $row['EntityID'] . "'";
                                }
                                elseif($entity_type=='schooladminstaff'){
                                    $sql1 = "SELECT " . $data['name']." as name from ".$data['table'] . " WHERE id='" . $row['EntityID'] . "'";
                                }
                                elseif($entity_type=='cookieadminstaff'){
                                    $sql1 = "SELECT " . $data['name']." as name from ".$data['table'] . " WHERE id='" . $row['EntityID'] . "'";
                                }
                                elseif($entity_type=='parent'){
                                    $sql1 = "SELECT " . $data['name']." as name from ".$data['table'] . " WHERE id='" . $row['EntityID'] . "'";
                                }
                                elseif($entity_type=='spectator'){
                                   $sql1 = "SELECT " . $data['name']." as name,category from ".$data['table'] . " WHERE id='" . $row['EntityID'] . "'";
                                                                            
                                }
                               
                                
                                $q = mysql_query($sql1);
                                
                               $row1 = mysql_fetch_assoc($q);
                                    
                                    
                                    if($row1['category']!=''){
                                         $entity_type=$row1['category'];
                                    }
                               //}
  

                                ?>
                                
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $row['RowID']; ?></td>
                                    <td><?php if ($row1['name'] != "") {
                                            echo strtoupper($row1['name']);
                                        }else {
                                            echo strtoupper($row1['f']) . " " . strtoupper($row1['l']);
                                        } ?></td>
                                    <td><?php echo ucwords($entity_type);echo "<br>"; if($row['school_id']!=''){echo '('.$row['school_id'].')';}else{}?></td>
                                    <td>
                                    <!--end code for SMC-3750 -->
                                        <a href="loginlogout_status_details.php?lat=<?php echo $row['LatestLatitude'];?>&long=<?php echo $row['LatestLongitude'];?>">
                                            <?php if($row['LatestLatitude']!=''){echo $row['LatestLatitude'];}else{} ?>
                                        </a>
                                    </td>

                                    <td><a herf="loginlogout_status_details.php?lat=<?php echo $row['LatestLatitude'];?>&long=<?php echo $row['LatestLongitude'];?>"><?php if($row['LatestLongitude']!=''){echo $row['LatestLongitude'];}else{}  ?></a></td>
                                    <td><?php echo $row['LatestLoginTime']; ?></td>
                                    <td><?php if ($row['LogoutTime'] != "") {
                                            echo $row['LogoutTime'];
                                        } else {
                                            echo "<div style='color:#694489'>Running</div>";
                                        } ?></td>
                                    <!--<td><?php echo $row['LatestMethod']; ?></td>  -->
                                    <td><?php echo $row['LatestDeviceDetails']; ?></td>
                                    <td><?php echo $row['LatestPlatformOS']; ?></td>
                                    <td><?php echo $row['LatestIPAddress']; ?></td>
                                    <!--<td><?php //echo $row['LatestBrowser']; ?></td>-->
                                </tr>

                           
<?php }  ?>
                            </tbody>
                        </table>

                    </div>

                </div>

                <div class="row" style="padding:5px;">

                    <div class="col-md-4">

                    </div>

                    <div class="col-md-3 " align="center">


                        </form>

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-4">

                    </div>

                    <div class="col-md-3" style="color:#FF0000;" align="center">

                        <?php echo $report; ?>

                    </div>
                </div>
            </div>
        </div>
</body>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.twbsPagination.js" type="text/javascript"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
<script type="text/javascript">
            $(function () {

                
                
            $("#from_date").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                    endDate: new Date()
                });

                $("#to_date").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                    endDate: new Date()
                });

            });

</script>

</html>