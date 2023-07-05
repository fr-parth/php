<?php 

         if(isset($_GET['name']))
	       {
		  	//$id=$_SESSION['staff_id'];
	    include_once("school_staff_header.php");
		$report="";
		$results=mysql_query("select * from tbl_school_adminstaff where id=".$id."");
        $result=mysql_fetch_array($results);
	    $Get_staff=$result['id'];
        $sc_id=$result['school_id'];
		if(isset($_POST['submit']))
		{
		 	echo "<script type=text/javascript>alert(;work in progress'); window.location=''</script>";

		$member_ID=$_POST['member_id'];
		$Date1=$_POST['datepicker'];
		$Date2=$_POST['datepicker1'];
		$member_type=$_POST['memtype'];
		$school_ID=$_POST['school_id'];
		}
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
        
        window.location = "delete_teacher.php?id="+xxx;
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
                    <div class="row">
                    <div class="col-md-3 "  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;
                     <!--  <a href="teacher_setup.php?id=<?=$Get_staff?>">   <input type="submit" class="btn btn-primary" name="submit" value="Add Teacher" style="width:150;font-weight:bold;font-size:14px;"/></a>-->
               			 </div>
              			 <div class="col-md-6 " align="center"  >
                         	<h2>Error Log Report</h2>
               			 </div>
                         
                     </div>
               <div class="row" style="padding:10px;" >
             <div class="col-md-12  " id="no-more-tables" >
               <?php $i=0;?>
                  <table class="table-bordered  table-condensed cf" id="example" width="100%;" >
                     <tr style="background-color:#428BCA" ><th style="width:10%;" ><b>Sr.No</b></th><th style="width:10%;"><b>Err ID</b></th><th style="width:30%;" >Err Type</th><th style="width:20%;"><b>Err Description</b></th><th style="width:20%;">Data</th>
					<th style="width:20%;">Date-Time</th><th style="width:20%;">User Type</th><th style="width:20%;">Member ID</th><th style="width:20%;">Name</th><th style="width:20%;">Email ID</th><th style="width:10%;">App Name</th><th style="width:10%;">Line</th><th style="width:10%;">Status</th>
					<th style="width:10%;">Assignment Date</th><th style="width:10%;">Assigned to</th><th style="width:10%;">Resolution Date</th><th style="width:10%;">Resolved By</th></tr></thead><tbody>
                 <?php
				 
				   $i=1;
				  $arr=mysql_query("select * from tbl_error_log ");?>
				  <?php while($row=mysql_fetch_array($arr)){?>
                  
                 <tr>
                    <td style="width:10%;"><?php echo $i;?></td>
					<td style="width:9%;"><?php echo $row['id'];?></td>
                    <td style="width:15%;"><?php echo $row['error_type'];?></td> 
                    <td style="width:15%;"><?php echo $row['error_description'];?></td> 
					<td style="width:15%;"><?php echo $row['data'];?></td> 
                    <td style="width:15%;"><?php echo $row['datetime'];?></td> 
					<td style="width:15%;"><?php echo $row['user_type'];?></td> 
					<td style="width:15%;"><?php echo $row['member_id'];?></td> 
					<td style="width:15%;"><?php echo $row['name'];?></td> 
					<td style="width:13%;"><?php echo $row['email'];?> </td> 
				    <td style="width:10%;"><?php echo $row['app_name'];?> </td>
					<td style="width:8%;"><?php echo $row['line'];?></td>
					<td style="width:8%;"><?php echo $row['status'];?></td>
					<td style="width:8%;"><?php echo $row['assignment_date'];?></td>
					<td style="width:8%;"><?php echo $row['assigned_to'];?></td>
					<td style="width:8%;"><?php echo $row['resolution_date'];?></td>
					<td style="width:8%;"><?php echo $row['resolved_by'];?></td>
                 
                 </tr>
                <?php 
				$i++;
				?>
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
<!----------------------------------------------------End---School Staff------------------------------------------------------------->
</html>

<?php
	  }
	  
	else
	  {
	   ?>
         <?php
			error_reporting(0);
			include("corporate_cookieadminheader.php");
			$report="";
			
			if(isset($_POST['submit']))
			{
		
			 $member_ID=$_POST['member_id'];
			 $Date1=$_POST['datepicker'];
			 $Date2=$_POST['datepicker1'];
			 $member_type=$_POST['memtype'];
			 $school_ID=$_POST['school_id'];
			$keywords=$_POST['keywords'];
			}


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

  <style>
  hr.style-eight {
    padding: 0;
    border: none;
    border-top: medium double #333;
    color: #333;
    text-align: center;
}
hr.style-eight:after {
    content: "§";
    display: inline-block;
    position: relative;
    top: -0.7em;
    font-size: 1.5em;
    padding: 0 0.25em;
    background: white;
}
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
input:focus {
    background-color: yellow;
}
input[type=text] {
  width: 100px;
  -webkit-transition: width .35s ease-in-out;
  transition: width .35s ease-in-out;
}
input[type=text]:focus {
  width: 250px;
}
label {
color: #B4886B;
font-weight: bold;
display: block;
width: 150px;
float: left;
}
label:after { content: ": " }
</style>
        



<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
 <link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script>
$(function() {
    $( "#datepicker" ).datepicker();
  });
$(function() {
    $( "#datepicker1" ).datepicker();
  });
$(document).ready(function() {
    $('#example').dataTable( {
	
      
    } );
} );

</script>


<script>


function confirmation(xxx) {

    var answer = confirm("Are you sure you want to delete?")
    if (answer){
        
        window.location = "delete_teacher.php?id="+xxx;
    }
    else{
       
    }
}

</script>
<body bgcolor="#CCCCCC"> 
<div style="bgcolor:#CCCCCC">

<div class="container"  style="padding:5px;" >
        	
            
            	<div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;border:groove; width:2000px;">
                   
                   
                    <div style="background-color:#F8F8F8 ;">
                    <div class="row">
                    <div class="col-md-3 " style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;
                    
               			 </div>
              			 <div class="col-md-6 " align="center"  >
                         	<h2>Error Log Report</h2>
							<hr class="style-eight">
               			 </div>
                         
                     </div>
					  <div class="row"  style="padding-left:380px;">
					   <form method="post" action="#">
						<p>From Date: <input type="text" id="datepicker">&nbsp;&nbsp; TO Date: <input type="text" id="datepicker1"></p>
					
						</div> 
						 <div class="row"  style="padding-left:378px;">
						
						<p>Member ID: <input type="text" name="member_id" id='member_id'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<select name="memtype" class="memtype" id='memtype' style="width:20%; height:30px; border-radius:2px;margin-left:18px">
						<option value="" disabled selected>Member Type</option>
						<?php
						   $arr1=mysql_query("select user_type from tbl_error_log group by user_type");
						?>
						<?php while($row=mysql_fetch_array($arr1)){?>
						<option value="<?php echo $row['user_type']; ?>"><?php echo $row['user_type']; ?></option>
						</p>
						<?php }?>
						</select>
						</div> 
						
						 <div class="row"  style="padding-left:380px;">
						
						<p>School ID: <input type="text" name="school_id" id='school_id'> &nbsp;&nbsp;&nbsp;Keywords: <input type="text" name="keywords" id='keywords'></p>
						<?php
						   $arr12=mysql_query("select count(*) as C from tbl_error_log ");
						 
							$value4=mysql_fetch_array($arr12);
							$total_ERR=$value4['C'];
						?>
						<label for=" "><b>Total Errors: <mark><?php echo $total_ERR; ?></mark></b></label>
						<input class='btn-lg btn-primary' type='submit' value="Search" name="submit" />
         
						</div> 
               <div class="row" style="padding:10px;" >
             <div class="col-md-12  " id="no-more-tables" >
               <?php $i=0;?>
                  <table class="table-bordered  table-condensed cf" id="example" width="100%;" >
                     <tr style="background-color:#428BCA;color:white" ><th style="width:10%;" ><b>Sr.No</b></th><th style="width:10%;"><b>Err ID</b></th><th style="width:30%;" >Err Type</th><th style="width:20%;"><b>Err Description</b></th><th style="width:5%;">Data</th>
					<th style="width:8%;">Date-Time</th><th style="width:8%;">User Type</th><th style="width:8%;">Member ID</th><th style="width:20%;">Name</th><th style="width:20%;">Email ID</th><th style="width:10%;">App Name</th><th style="width:10%;">Subroutine name</th><th style="width:8%;">Line</th><th style="width:8%;">Status</th>
					<th style="width:8%;">Assignment Date</th><th style="width:8%;">Assigned to</th><th style="width:8%;">Resolution Date</th><th style="width:10%;">Resolved By</th><th style="width:8%;">Last Programmer Name</th><th style="width:8%;">Webservice Name</th><th style="width:8%;">Webmethod Name</th><th style="width:8%;">Programmer Error Message</th><th style="width:8%;">school Id</th></tr></thead><tbody>
                 <?php
						 
						   $i=1;
						  $arr=mysql_query("select * from tbl_error_log where (member_id='$member_ID' or school_id='$school_ID' or user_type='$member_type')");
				  ?>
				  <?php while($row=mysql_fetch_array($arr)){?>
                  
                  <tr onmouseover="this.style.cursor='pointer';this.style.textDecoration='underline';this.style.color='dodgerblue'" onmouseout="this.style.textDecoration='none';this.style.color='black';"  onclick="window.location='Error_log_report_vertical_PT.php?Err_id=<?php echo $row['id'];?>'"class="d0" style="padding-top:2px;color:#808080">
                    <td style="width:10%;"><?php echo $i;?></td>
					<td style="width:9%;"><?php echo $row['id'];?></td>
                    <td style="width:8%;"><?php echo $row['error_type'];?></td> 
                    <td style="width:8%;"><?php echo $row['error_description'];?></td> 
					<td style="width:5%;"><?php echo $row['data'];?></td> 
                    <td style="width:8%;"><?php echo $row['datetime'];?></td> 
					<td style="width:8%;"><?php echo $row['user_type'];?></td> 
					<td style="width:8%;"><?php echo $row['member_id'];?></td> 
					<td style="width:8%;"><?php echo $row['name'];?></td> 
					<td style="width:8%;"><?php echo $row['email'];?> </td> 
				    <td style="width:8%;"><?php echo $row['app_name'];?> </td>
					<td style="width:8%;"><?php echo $row['subroutine_name'];?> </td>
					<td style="width:8%;"><?php echo $row['line'];?></td>
					<td style="width:8%;"><?php echo $row['status'];?></td>
					<td style="width:8%;"><?php echo $row['assignment_date'];?></td>
					<td style="width:8%;"><?php echo $row['assigned_to'];?></td>
					<td style="width:8%;"><?php echo $row['resolution_date'];?></td>
					<td style="width:8%;"><?php echo $row['resolved_by'];?></td>
					<td style="width:8%;"><?php echo $row['last_programmer_name'];?></td>
					<td style="width:8%;"><?php echo $row['webservice_name'];?></td>
					<td style="width:8%;"><?php echo $row['webmethod_name'];?></td>
					<td style="width:8%;"><?php echo $row['programmer_error_message'];?></td>
					<td style="width:8%;"><?php echo $row['school_id'];?></td>
                 
                 </tr>
                <?php 
				$i++;
				?>
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
  <?php }?>
  
  