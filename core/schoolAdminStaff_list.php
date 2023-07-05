<?php include('scadmin_header.php');?>

<?php
$report="";
$usertype = $_SESSION['usertype'];
$sc_id=$_SESSION['school_id'];
$smartcookie=new smartcookie();
$id=$_SESSION['id'];
//school_id field taken in $fields array by Pranali for SMC-5011
           $fields=array("school_id"=>$sc_id);
       $table="tbl_school_admin";
       
       $smartcookie=new smartcookie();
       
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);

$school_type = $result['school_type'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
 <link rel="stylesheet" href="css/bootstrap.min.css">


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
        



<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<script>
$(document).ready(function() {
    $('#example').dataTable( {
      
    } );
} );


function confirmation(xxx) {

    var answer = confirm("Are you sure you want to delete?")
    if (answer){
        
        window.location = "delete_school_staff.php?id="+xxx;
    }
    else{
       
    }
}

</script>
<body bgcolor="#CCCCCC"> 
<div style="bgcolor:#CCCCCC">

<div class="container"  style="padding:30px;" >
          
            
              <div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
                   
                    
                    <div style="background-color:#F8F8F8 ;">
                    <div align="center" style="color:#090;"><?php if(isset($_GET['successreport'])){ echo $_GET['successreport'];}?></div>
                    <div class="row">
                    <div class="col-md-3 "  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;
                       <a href="Add_Staff.php"><input type="button" class="btn btn-primary" name="submit" value="Add Staff" style="width:150;font-weight:bold;font-size:14px;"/></a>
                     </div>
                     <div class="col-md-6 " align="center"  >
                          
                          <h2>List of Staff Members </h2>
                     </div>
                         
                     </div>
                  
                  
                   
                  
               <div class="row" style="padding:10px;" >
             
         
               <div class="col-md-12  " id="no-more-tables" >
               <?php $i=0;?>
                  <table class="table-bordered  table-condensed cf" id="example" width="100%;" >
                     <thead><!-- Camel casing done for Sr. No. by Pranali -->
                      <tr style="background-color:#428BCA" ><th style="width:10%;" ><b>Sr. No.</b></th><th style="width:20%;" >Name</th><th style="width:20%;">Email ID</th><th style="width:10%;" >Designation</th><th style="width:10%;" >Gender </th>
            <th style="width:10%;" >Qualification</th><th style="width:10%;" >Phone</th><th style="width:10%;" >Experience</th><!--<th style="width:10%;" > gender</th> --><th style="width:10%;" >DOB</th>
                        <th style="text-align:center">Edit</th>
            <th style="text-align:center">Delete</th>
                       
                        </tr></thead><tbody>
                 <?php
         
           $i=1;
          $arr=@mysql_query("select * from tbl_school_adminstaff where school_id='$sc_id' AND delete_flag='0' order by id desc");?>
                  <?php while($row=@mysql_fetch_array($arr)){
          $schoo_staff_id=$row['id'];
          ?>
                 <tr style="color:#808080;" class="active">
                    <td data-title="Sr.No" style="width:10%;" ><b><?php echo $i;?></b></td>
                    <td data-title="Name" style="width:20%;"><?php echo $row['stf_name'];?> </td>
                    
                         <td data-title="Email" style="width:10%;"><?php echo $row['email'];?> </td>
                    <td data-title="Designation" style="width:10%;">
                                  <?php echo $row['designation']; ?> 
                               
                  
                    </td>
                    
                      <td  data-title="Gender" style="width:10%;">
                                  <?php
                  echo $row['gender'];
                  
                   ?> 
                               
                  
                    </td>
        
                    <td  data-title="Qualification" style="width:10%;">
                                  <?php echo $row['qualification']; ?> 
                               
                  
                    </td>
                    <td  data-title="Phone" style="width:10%;">
                                  <?php 
                           echo $row['phone'];
                  
                   ?> 
                               
                  
                    </td>
           <td  data-title="Phone" style="width:10%;">
                                  <?php 
                           echo $row['exprience'];
                  
                   ?> 
                               
                  
                    </td>
          <!--
          <td  data-title="Phone" style="width:10%;">
                                  <?php 
                           echo $row['gender'];
                  
                   ?> 
                               
                  
                    </td>
          
          -->
          <td  data-title="Phone" style="width:10%;">
                                  <?php 
                           echo $row['dob'];
                  
                   ?> 
                               
                  
                    </td>
        <td>  <!--href updated by Rutuja Jori for merging Add & Edit pages into one for SMC-4196 on 29/11/2019--><a href="Admin_Staff_setup.php?staff_d=<?=$schoo_staff_id; ?>&entity=<?=$usertype; ?>&school_type=<?=$school_type; ?>" style="width:100px;"><span class="glyphicon glyphicon-pencil"></span> </a>
      <!--  <td><a href="Update_Admin_Staff_setup.php?staff_d=<?//=$schoo_staff_id; ?>"><span class='glyphicon glyphicon-pencil'></span>
    </a>  -->
  </td>            
                 
         <td style="width:100px;" ><center> <a onClick="confirmation(<?php echo $schoo_staff_id; ?> )"><span class="glyphicon glyphicon-trash"></span></a></center></td>           
  
    
                  
                 </tr>
                <?php $i++;?>
                 <?php }?>
                  
                  </tbody>
                  </table>
                
                  </div>
                  </div>
                  
                  
                   <div class="row" style="padding:5px;">
                   <div class="col-md-4">
               </div>
                  <div class="col-md-3 "  align="center">
                   
                   </form>
                   </div>
                    </div>
                     <div class="row" >
                     <div class="col-md-4">
                     </div>
                      <div class="col-md-3" style="color:#FF0000;" align="center">
                      
                      <?php echo $report;?>
                    </div>
                 
                    </div>                    
                  
               </div>
               </div>
</body>
</html>
