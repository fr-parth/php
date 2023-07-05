<?php
include('scadmin_header.php');
$sc_id=$_SESSION['school_id'];
//       $fields=array("id"=>$id);
//        $smartcookie=new smartcookie();

// $results=$smartcookie->retrive_individual($table,$fields);
// $result=mysql_fetch_array($results);
// $sc_id=$result['school_id'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
        <script>
$(document).ready(function() {
    $('#example').dataTable( {
      //  "pagingType": "full_numbers"
    } );
} );
</script>
<script>
    function confirmation($d_id)
  {
    var s = "Are you sure you want to delete?";
    var answer = confirm(s);
    if (answer){

        window.location = "delete_school_department.php?id="+$d_id;
    }
    else{

    }
  }
</script>
 

</head>
<html>
<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">
<div>

</div>
<div class="container" style="padding:25px;" >
          
            
              <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
                   
                    
                    <div style="background-color:#F8F8F8 ;">
                        <div class="row">
                        <div class="col-md-3"  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                        <div class="col-md-5 " align="center" style="color:black;padding:5px;" >
                            <h2>My Group List</h2>
                        </div>
                         
                     </div>

                  
                   
                  
               <div class="row" style="padding-top:0px;">
             
               <div class="col-md-0">
               </div>
               <div class="col-md-12 ">
               <?php $i=0;?>
<!--Removed <align='left'> styling and Added Sr. No. column by Pranali for SMC-5154 -->
                  <table id="example" class="display" width="100%" cellspacing="0">
                     <thead>
                      <tr style="height:40px;">
                        <th style="width:100px;" ><b>Sr. No.</b></th>
                        <th style="width:100px;" >Group Name</th> 
                        <th style="width:100px;" ><b>Group Member Id</b></th>
                        <!-- <th>Edit</th>
                        <th>Delete</th> -->
                      </tr>
                    </thead>

            <tbody>
                 
         
        <?php
         
           $i=1;
        //    echo "SELECT * FROM tbl_group_school where school_id='$sc_id' " .'<br>';
        //    echo $id11 .'<br>';
        //    echo $_SESSION .'<br>' ;
        //    var_dump($_SESSION);
          $arr=mysql_query("SELECT * FROM tbl_group_school where school_id='$sc_id' ");?>
                  <?php while($row=mysql_fetch_array($arr)){?>
                 <tr style="height:40px;">
                  <td style="width:100px;" ><?php echo $i++ ;?></td>
                  <td style="width:100px;" ><?php echo $row['group_mnemonic_name'] ;?></td>
                  <td style="width:100px;" ><?php echo $row['group_member_id'];?></td>
                 <!-- <td><a href="add_school_department.php?d_id=<?php echo $row['id'];?>&d_code=<?php echo $row['Dept_code']; ?>"><span class="glyphicon glyphicon-pencil"></a>
                </td> -->
                <!-- 
                 <td><a onClick="confirmation(<?php echo $row['id']; ?>)"><span class="glyphicon glyphicon-trash"></a>
                </td> -->
            </tr>
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
                      <div class="col-md-4" style="color:#FF0000;" align="center">
                      
                      <?php if(isset($_GET['report'])){echo $_GET['report'];}?>
                    </div>
                 
                    </div>
                      
                
                  
                 
                    
                    
                  
               </div>
               </div>
</body>
</html>
