<?php
include("groupadminheader.php");
error_reporting(0);
$group_member_id = $_SESSION['group_admin_id'];
//AICTE Permanent ID and AICTE Application ID added by Sayali for SMC-5103 on 13/1/2021
$schoolres = mysql_query("select scadmin_state,scadmin_city,aicte_permanent_id,aicte_application_id from tbl_school_admin where group_member_id = '$group_member_id' AND scadmin_state!='' group by scadmin_state");
$condition = "group_member_id = '$group_member_id'";
if (($_GET['Search']))
{
$searchq=$_GET['Search'];
$State=$_GET['state'];
    if ($State != '')
    {
        $condition.= " AND scadmin_state = '$State'";
    } 

    $is_activated=$_GET['is_activated'];
    if ($is_activated != '')
    {
        $condition.= " AND is_accept_terms = '$is_activated'";
    }
    $coordinator_id=$_GET['coordinator_id'];
    if ($coordinator_id == '1')
    {
        $condition.= " AND coordinator_id IS NOT NULL AND coordinator_id!=''";
    }
    if ($coordinator_id == '0')
    {
        $condition.= " AND coordinator_id IS NULL OR coordinator_id=''";
    }
    if ($coordinator_id == '')
    {
        $condition.= "";
    }

        $condition.= " AND school_id NOT LIKE '%grp%'";
                   
}
 $s_query="SELECT id,school_id,school_name,email,mobile,scadmin_city,scadmin_state,aicte_permanent_id,aicte_application_id,coordinator_id FROM tbl_school_admin where $condition";
 //echo $s_query;
        $sql=mysql_query($s_query) or die("could not Search!");
                    
?>

<!DOCTYPE html >
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Smart Cookie:School Detail</title>
<link rel="stylesheet" href="../css/bootstrap.min.css">
<script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
<script src="../js/select2.min.js"></script>
<script src='../js/bootstrap.min.js' type='text/javascript'></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.cs">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<link href="../css/select2.min.css" rel="stylesheet" />
<script src="../js/jquery.twbsPagination.js" type="text/javascript"></script>
    <script>
    $(document).ready(function() {
    $('#example').dataTable();
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
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                text-align:left;
            }
            /*
            Label the data
            */
            #no-more-tables td:before { content: attr(data-title); }
        }
    </style>
</head>
<body bgcolor="#CCCCCC">
<div align="center">
    <div class="container" style="width:100%;">
        <div style="padding-top:50px;">
            <h2 style="padding-left:20px; margin-top:2px;color:#666;margin-left: -150px">Schools List</h2>
        </div><br>
        <div class='row'>
        <form style="margin-top:5px;" method="get">
            <div class="col-md-5">
              <div class="form-group">
                <label for="type" class ="control-label col-sm-4">Select State<span style="color:red;">*</span>:</label>
                  <div class="col-sm-8" id="typeedit">
                    <select class="form-control searchselect" name="state">
                      <option value="">State</option>
                      <?php while($sc_row= mysql_fetch_array($schoolres)){ ?>
                        <option value="<?php echo $sc_row['scadmin_state']; ?>" <?php if($sc_row['scadmin_state']==$_GET['state']){echo 'selected'; } ?>><?php echo $sc_row['scadmin_state']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div> 
              <div class="col-md-3">
              <div class="form-group">
                <label for="type" class ="control-label col-sm-6">Is Active<span style="color:red;">*</span>:</label>
                  <div class="col-sm-6" id="typeedit">
                    <select class="form-control searchselect" name="is_activated">
                      <option value="">Select</option>
                    
                        <option value="1" <?php if($_GET['is_activated']=="1"){echo 'selected'; } ?>>Yes</option>
                        <option value="0" <?php if($_GET['is_activated']=="0"){echo 'selected'; } ?>>No</option>
                         <option value="" <?php if($_GET['is_activated']==""){echo 'selected'; } ?>>All</option>
                                            
                    </select>
                  </div>
                </div>
              </div> 
               <div class="col-md-2">
                <div class="form-group">
                <label for="type" class ="control-label col-sm-4">Coor.:</label>
                  <div class="col-sm-8" id="typeedit">
                    <select class="form-control searchselect" name="coordinator_id">
                      <option value="">Select</option>
                    
                        <option value="1" <?php if($_GET['coordinator_id']=="1"){echo 'selected'; } ?>>Yes</option>
                        <option value="0" <?php if($_GET['coordinator_id']=="0"){echo 'selected'; } ?>>No</option>
                         <option value="" <?php if($_GET['coordinator_id']==""){echo 'selected'; } ?>>All</option>
                                            
                    </select>
                  </div>
                </div>
              </div>
              
              <div class="col-md-1" style="margin-left:0px" >
                <button type="submit" name="Search" value="Search" class="btn btn-primary">Search</button>
              </div>
              <div class="col-md-1" >
                <!-- <input type="button" class="btn btn-info" value="Reset" onclick="window.open('export_teachers.php','_self')" /> -->
                        <a href="csv_export_school.php?gid=<?= $group_member_id;?>&sid=<?= $_GET['state'];?>&aid=<?= $_GET['is_activated'];?>&co_id=<?= $_GET['coordinator_id'];?>" class="btn btn-success">Export to CSV</a>    
              </div>
          </form>
          </div><br> 
          
                    <div class="row">   
        <?php
            $count=mysql_num_rows($sql);
            if($count == 0){
                echo "<script>$('#show').css('display','none');</script><div style='margin-top:20px;'><font color='Red'><b>There Was No Search Result</b></font></div>";
            }
            else
            {
            ?>
            <div id="no-more-tables">
            <?php $i = 0; ?>
            <table id="example" class="col-md-10 table-bordered table-striped table-condensed cf" >
                <thead>
                 <tr  style="background-color:#428BCA; color:#FFFFFF; height:30px;">
                    <th> Sr. No.</th>
                    <!--School Member ID added by Rutuja for SMC-5079 on 01-01-2021-->
                    <th> School Member ID </th>
                    <th> School ID </th>
                    <th> School Name </th>
                    <th> Email ID </th>
                    <th> Mobile </th>
                    <th> City </th>
                    <th> State </th>
                    <th> AICTE Permanent ID </th>
                    <th> AICTE Application ID </th>
                    <th> Coordinator ID/Coordinator Name/Coordinator Email </th>
                   
                 </tr>
                </thead>
                <?php
                     $i = 1;
                            //$sql="select * from tbl_school_admin where group_member_id = '$group_member_id' order by id";
                            //echo $sql;    
                            //$arr = mysql_query("$sql");
                    $i = ($start_from +1);
                     while ($row = mysql_fetch_array($sql)) {
                            $Sc_id = $row["school_id"];
                            
                    ?>
                    <tr> 
                        <td data-title="Sr.No" ><b><?php echo $i; ?></b></td>
                        <td data-title="Id" ><?php echo $row['id'];?></td>
                        <td data-title="sc_id" ><?php echo $row['school_id'];?></td>
                        <td data-title="Name" ><?php echo $row['school_name'];?></td>
                        <td data-title="email" ><?php echo $row['email']; ?> </td>
                        <td data-title="Phone" ><?php echo $row['mobile']; ?> </td>
                        <td data-title="City" ><?php echo $row['scadmin_city']; ?> </td>
                        <td data-title="State" ><?php echo $row['scadmin_state']; ?> </td>
                        <td data-title="aicte_permanent_id" ><?php echo $row['aicte_permanent_id']; ?> </td>
                        <td data-title="aicte_application_id" ><?php echo $row['aicte_application_id']; ?> </td>
                        <td data-title="aicte_application_id" ><?php 
                            $a=$row['coordinator_id'];
                                  
                             if($a!='')
                            {
                            $sql1= mysql_query("SELECT t_email,t_complete_name FROM tbl_teacher where t_id='$a' and school_id='$Sc_id'");
                            $query =mysql_fetch_array($sql1);
                            $email=$query['t_email'];
                            $coordinator_name=$query['t_complete_name'];
                            echo $a;?><br>
                            <?php echo $coordinator_name;?><br>
                            <?php echo $email;?><?php
                            }
                            else{echo "";}
                            ?>
                          </td>
                    </tr>
                            <?php $i++;
                            } ?>
            </table>
        </div>  
                
            <?php
            }
        ?>
    </div>
    </div>
</div>

<script>
    $(document).ready(function(){
      $('.searchselect').select2();
    });

</script>
</body>
</html>
<style>
.modal fade {
  text-align: center;
}

@media screen and (min-width: 768px) { 
  .modal fade:before {
    display: inline-block;
    vertical-align: middle;
    content: " ";
    height: 100%;
  }
}

.modal-dialog {
  display: inline-block;
  text-align: left;
  vertical-align: middle;
  margin-left: -35%;
  width: 70%;
}
</style>