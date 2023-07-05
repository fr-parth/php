<?php



include("groupadminheader.php");
error_reporting(0);
$group_member_id = $_SESSION['group_admin_id'];
 //print_r($group_member_id);exit;
  $qr="SELECT * FROM tbl_group_school tgs inner join tbl_school_admin tsa  on tsa.school_id=tgs.school_id where tgs.group_member_id='$group_member_id'";
 
   $id=$_GET['id'];
   if($id!='')
   {
       $select=mysql_query("SELECT * FROM tbl_school_admin WHERE school_id='$id'");
       $sel=mysql_fetch_array($select);
     //  $group_member_id=$sel['group_member_id'];
       $group_mnemonic_name=$sel['group_name'];
       $createdby=$sel['name'];
       $isenabled=$sel['is_accept_terms'];
       $school_id=$sel['school_id'];
       $sel1=mysql_query("SELECT * FROM tbl_group_school WHERE school_id='$id' and group_member_id='$group_member_id'");
       $sel2=mysql_num_rows($sel1);
     //  print_r($group_member_id);
      //print_r($sel2);die;
  if($sel2>0)
{
 header("Location: coll_group_school_list.php");

}
else
{
   $insert="INSERT INTO `tbl_group_school`(group_member_id,group_mnemonic_name, school_id,createdby, isenabled) VALUES ('$group_member_id','$group_mnemonic_name','$school_id','$createdby','$isenabled')";
     
      $ins=mysql_query($insert);
      header("Location: coll_group_school_list.php");

}
      

   }
   
   $a=$_GET['id1'];
   if($a!='')
   {
     
     $sql = "DELETE FROM `tbl_group_school` WHERE school_id='$a' and group_member_id='$group_member_id'";
     $del=mysql_query($sql);

   }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
        /*
        Label the data
        */
        #no-more-tables td:before {
            content: attr(data-title);
        }
    }

    /*for loader*/
    .loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
    
</style>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
    
   </head>
 <script>
     $(document).ready(function() {
        $('#example').dataTable({});    
 });
</script>
<body bgcolor="#CCCCCC">

<div style="bgcolor:#CCCCCC">
    <div class="container-fluid" style="padding:30px;width:1152px">
       

        <div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
            <div style="background-color:#F8F8F8 ;">
                <div class="row">
                    <div style="color:#700000 ;padding:5px;" >
                       
                        <div class="col-md-12 " align="center">
                            <h2>List of School in <?php echo $group_name1; ?></h2>
                        </div>
                         </div>
                         
                     </div>
               
                <div class="clearfix"></div>
                <br>
                
                    
                    </div>
                   
 <form method="post" id="myform">
               
            <div class="col-md-1" >
            <button type="submit" value="Search" name="submit" class="btn btn-primary"><a href="group_school_list_not.php" style="color:#fff">Add More School</a></button>
            </div>
      
               
                   
                         
                      
                    
                    <div class="row" style="padding:10px;">
                        <div class="col-md-12  " id="no-more-tables">
                        
                          <div class="col-md-8" id="college_data">

                             <div class="form-group">
                                <label for="type" class ="control-label col-sm-4"></label>
                                <label></label>
                            </div>
                           

                          </div>




                            <table class="table-bordered  table-condensed cf" id="example" width="100%;">
                                <thead>
                                <tr style="background-color:#428BCA">
                                 <th> Sr. No.</th>
                                 <th>School ID </th>
                    <th>School Name </th>
                    <th> City </th>
                    <th> State </th>
                    <th> Country</th>
                    <th> Remove</th>
          
          
                                </tr>
                                </thead>
                              
                                     <tbody id="ajaxRecords">
                                <?php
                  $i=1;                 
                                    $arr = mysql_query($qr);
                                    //$as=mysql_fetch_array($arr);
                                    //print_r($as);die;
                                
                                   while ($row = mysql_fetch_array($arr)) {

                                                   ?>
                                 <tr>
                <td data-title="Sr.No" ><b><?php echo $i;  ?></b></td>
                <td data-title="Teacher ID" ><b><?php echo $row['school_id']; ?></b></td>                 <td data-title="Teacher ID" ><b><?php echo $row['school_name']; ?></b></td>
                <td data-title="Teacher ID" ><b><?php echo $row['scadmin_city']; ?></b></td>
                <td data-title="Sr.No" ><b><?php echo $row['scadmin_state'];  ?></b></td>
                <td data-title="Sr.No" ><b><?php echo $row['scadmin_country'];  ?></b></td>
                <?php 
                 echo "<td><a class='btn btn-danger' input type='submit' name='submit' value='Delete' href='coll_group_school_list.php?id1=".$row['school_id']."'>Remove</a></td>"; ?>      
                  </tr>
                            <?php $i++;?>
                            <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    </form>
                <div class="row" style="padding:5px;">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-3 " align="center">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                    </div>
                </div>
            </div>
        </div>
</body>
</html>

