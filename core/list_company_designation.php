<?php
       if(isset($_GET['name']))
	   { 
	   include_once("school_staff_header.php");
		 
$results=mysql_query("select * from tbl_school_adminstaff where id=".$id."");
$result=mysql_fetch_array($results);
$sc_id=$result['school_id'];
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SmartCookies</title>

<script>
$(document).ready(function() {
    $('#example').dataTable( {
       // "pagingType": "full_numbers"
    } );
} );
function confirmation(xxx) {
    var answer = confirm("Are you sure you want to delete?")
    if (answer){
        
        window.location = "delete_school_division.php?id="+xxx;
    }
    else{
       
    }
}
</script>
</head>
<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">
<div>

</div>
<div class="container" style="padding:25px;">
        	
            
            	<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
                   
                    
                    <div style="background-color:#F8F8F8 ;">
                    <div class="row">
                    <div class="col-md-3 "  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       <a href="add_school_division.php?id=<?=$staff_id?>"> <input type="button" class="btn btn-primary" name="submit" value="Add Division" style="width:110px;font-weight:bold;font-size:14px;"/></a>
               			 </div>
              			 <div class="col-md-5 " align="center">

                   				<h2> Division </h2>
               			 </div>
                         
                     </div>
                  
                  
                   
                  
               <div class="row">
             
               <div class="col-md-2">
               </div>
               <div class="col-md-8 ">
               <?php $i=0;?>
                  <table class="table-bordered" id="example" width="100%">
                     <thead>
                    	<tr style="background-color:#555;color:#FFFFFF;height:30px;"><th style="width:20%;" ><b><center>Sr.No</center></b></th><th style="width:20%;" ><center>Designation </center></th>
                        <th style="width:20%;" ><center>Edit </center></th><th style="width:30%;" ><center>Delete </center></th></tr></thead><tbody>
                 <?php
				
				   $i=0;
				
				   
                  $arr1=mysql_query("select  id,DivisionName  from Division where school_id='$sc_id' ");
				 
				  if(mysql_num_rows($arr1)>=1)
				  {
				  	while($row1=mysql_fetch_array($arr1))
					{
						$i++;
						$diision=$row1['division']
				  ?> 
                 		<tr style="height:30px;color:#808080;">
                        	<th style="width:100px;" ><b><center><?php echo $i;?></center></b></th>
                            <th style="width:150px;" ><center><?php echo $row['class'];?></center> </th>
                          
                            <th style="width:150px;" ><center><?php $id=$row1['id'];?>
                            		<a href="edit_school_division.php?divi=<?php echo $id; ?> " style="">Edit</a>				                               </center> </th>
                            <th style="width:250px;" ><center><a > Delete</a>                                </center> </th>
                          </tr>
               
                 <?php
				         
				  }
				 
				    
			
					 
				  
				 
				 }?>
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
                      
                   
               			</div>
                 
                    </div>
                      
                
                  
                 
                    
                    
                  
               </div>
               </div>
</body>
</html>
<?php 
		   }
		   else
		   {
			   include('scadmin_header.php');
$id=$_SESSION['id'];
           $fields=array("id"=>$id);
		   $table="tbl_school_admin";
		   
		   $smartcookie=new smartcookie();
		   
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$sc_id=$result['school_id'];
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SmartCookies</title>

<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">

 <link rel="stylesheet" href="css/bootstrap.min.css">

<script>

function confirmation(xxx) {
    var answer = confirm("Are you sure you want to delete?")
    if (answer){
        
        window.location = "delete_school_division.php?id="+xxx;
    }
    else{
       
    }
}


$(document).ready(function() {

    $('#example').dataTable( {



    } );

} );

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
</head>

<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">
<div>

</div>
<div class="container" style="padding:25px;" >
        	
            
            	<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
                   
                    
                    <div style="background-color:#F8F8F8 ;">
                    <div class="row">
                    <div class="col-md-3 "  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       <a href="add_company_designation.php">   <input type="button" class="btn btn-primary" name="submit" value="Add Division" style="width:110px;font-weight:bold;font-size:14px;"/></a>
               			 </div>
              			 <div class="col-md-5 " align="center"  >

                   				<h2> Designation</h2>
               			 </div>
                         
                     </div>
                  
                  
     <!--Added Title and fetch data from database By Dhanashri_Tak -->              
                  
               <div class="row">
             
               <div class="col-md-1">
               </div>
               <div class="col-md-12 ">
               <?php $i=0;?>
                 <table id="example" class="display" width="100%" cellspacing="0">
                     <thead>
                    	<tr>
						<th><center>Sr No</center></b></th>
						<th><center>Designation ID</center></b></th>
						<!--<th style="width:;" >
						
						<center>Division </center></th>						
						
						<th><center>Batch ID</center></th>-->
						<th><center>Designation </center></th>
						<th><center>Edit </center> </th>
						<th><center>Delete </center> </th>
                     </tr></thead>					 					 <tbody>
                 <?php

				   $i=0;



                  $arr1=mysql_query("select id,ExtDivisionID,DivisionName,batch_id from Division where school_id='$sc_id' ");

				  if(mysql_num_rows($arr1)>=1)
				  {
				  	while($row1=mysql_fetch_array($arr1)){$i++;
				  ?>
                 		<tr style="height:30px;color:#808080;">
						<th style="width:100px;" ><b><center><?php echo $i;?></center></b></th>
                        	<!--<th style="width:;" ><b><center>
							<?php echo $row1['ExtDivisionID'];?></center></b></th>-->
							<th style="width:;" ><center><?php echo $row1['ExtDivisionID'];?></center> </th>
                            <th style="width:;" ><center><?php echo $row1['DivisionName'];?></center> </th>
							<!--<th><center><?php //echo $row1['batch_id'];?> </center></th>-->
							<th style="width:30px;" ><b><center>

                 <?php $id= $row['id'];?>  <a href="edit_company_designation.php?id=<?php echo $row1['id']; ?>&division=<?php echo $row1['DivisionName']; ?>" <span class="glyphicon glyphicon-pencil"></span></a></center></b></th>

				 <th style="width:40px;" ><b><center> <a onClick="confirmation(<?php echo $row1['id']; ?>)"><span class="glyphicon glyphicon-trash"></span></a></b></center></th>	
                          </tr>
               
                 <?php
				         
				  }
				 
				/*End*/
				
					 
				  
				 
				 }?>
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
                      
                   
               			</div>
                 
                    </div>
                      
                
                  
                 
                    
                    
                  
               </div>
               </div>
</body>
</html>
<?php
 }
 ?>
