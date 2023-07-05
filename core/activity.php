<?php
//activity.php  

           if(isset($_GET['id']))
		   {
			include_once("school_staff_header.php");
			$report="";
			
			/* $id=$_SESSION['id'];
           $fields=array("id"=>$id);
		   $table="tbl_school_admin";
		   
		   $smartcookie=new smartcookie();*/
		   //echo "select * from tbl_school_adminstaff where id=".$id."";
     $results=mysql_query("SELECT * FROM tbl_school_adminstaff WHERE id =".$staff_id."");
       $school_admin=mysql_fetch_array($results);
			$school_id=$school_admin['school_id'];
			$std_id=$school_admin['id'];
			$report="";
			$rec_limit = 10;
$sql =  "SELECT * FROM tbl_studentpointslist sp JOIN tbl_activity_type a WHERE sp.school_id='$school_id'  AND a.id = sc_type" ;
$retval = mysql_query( $sql);
if(! $retval )
{
  die('Could not get data: ' . mysql_error());
}


$row = mysql_fetch_array($retval, MYSQL_NUM );
$rec_count = $row[0];

if( isset($_GET{'page'} ) )
{
   $page = $_GET{'page'} + 1;
   $offset = $rec_limit * $page ;
}
else
{
   $page = 0;
   $offset = 0;
}
 $left_rec = $rec_count - ($page * $rec_limit);
 
 
    	if(isset($_POST['submit']))
		{
 			$activity_name=$_POST['activity'];
 			$activity_type=$_POST['type'];
			
			
			
			$sql=mysql_query("select id from tbl_activity_type where activity_type='$activity_type'");
			
			$sql1=mysql_fetch_array($sql);
			$id=$sql1['id'];
		
		
			$query=mysql_query( "select sc_list from tbl_studentpointslist where sc_list='$activity_name' AND (school_id='0' OR school_id='$school_id')  ");
			
			$test=mysql_num_rows($query);
			if($test<=0)
			{		
			$result=mysql_num_rows($sql);
			if($result==1)
			{
			
			
			$query="insert into tbl_studentpointslist(sc_list,sc_type,school_id,school_staff_id) values('$activity_name','$id','$school_id','$std_id')";
			$rs = mysql_query( $query ); 

			$report="Activity is Successfully added"; 
		}
		else
		{
		

		$sql=mysql_query("insert into tbl_activity_type(activity_type,school_id,school_staff_id) values('$activity_type','$school_id','$id')");
			$result=mysql_query("select * from tbl_activity_type where activity_type='$activity_type'");
			$result1=mysql_fetch_array($result);
			$activity_type=$result1['id'];
	
			
			$query="insert into tbl_studentpointslist(sc_list,sc_type,school_id) values('$activity_name','$activity_type','$school_id')";
			$rs = mysql_query( $query );
			
			$report="Activity is Successfully added"; 
           }
		 }
		else
		{
		 $report="Activity is already present";
		}
		}
		
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">



<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
<title>Smart Cookies</title>
</head>

<link href="css/style.css" rel="stylesheet">
 <link rel="stylesheet" href="css/bootstrap.min.css">
 
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script>
function valid()
{

var activity=document.getElementById("activity").value;
var activity_type=document.getElementById("type").value;
/*
  if(activity=="" )
  {
   document.getElementById('erroractivity').innerHTML='Please enter Activity';

				return false;
	}



var letters =/^[a-zA-Z0-9!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]*$/
   if(!activity.match(letters))
     {
	 document.getElementById('erroractivity').innerHTML='Please Enter valid Activity';
      return false;
     }

*/



  if(activity_type=="select" )
  {

   document.getElementById('erroractivitytype').innerHTML='Please enter Activity Type';
				
				return false;
	}
}

function confirmation(xxx) {

    var answer = confirm("Are you sure you want to delete?")
    if (answer){
        
        window.location = "delete_activity.php?id="+xxx;
    }
    else{
       
    }
}
</script>
</head>

<body style="background-color:#F8F8F8;">
<div align="center">
	<div style="width:100%">
    	
        
        	<div style="height:10px;"></div>
    		<div style="height:50px; border-bottom: thin solid #CCCCCC;" align="left">
        	<h1 style="padding-left:20px; margin-top:2px;color:#666">Activity</h1>
        	</div>
    	<div style="height:30px;"></div>
    	
         <div class="container">
        <div class="row">
         <div class="col-md-6">
    
        <form method="post" name="product" onsubmit="return valid()">
        	<div style=" background-color:#FFFFFF; border:1px solid #CCCCCC; padding-left:30px;" align="left">
            	<div style="height:10px;"></div>
            	<div>
					<h2 style="color:#666;">Add Activity</h2>
                </div>
                <div style="height:10px;"></div>
            	<div>
      <input type="text" id="activity"  name="activity" style="width:50%; height:30px; padding:5px;" placeholder="Enter Activity" />
                </div>
                <div style="height:30px;color:#FF0000; font-size:14px;font-weight:bold; " id="erroractivity" ></div>
                <div>
                 <select name="type" id="type"  style="width:50%; height:30px; padding:5px;">
                 <option value="select">Select Activity Type</option>
        
                <?php $query=mysql_query("select distinct(activity_type) from tbl_activity_type where school_id=0");
				while($row=mysql_fetch_array($query))
				{?>
               
                <option value='<?php echo $row['activity_type'];?>'><?php echo $row['activity_type'];?></option>
                
             
               <?php } ?>
                  </select>
                </div><span style="color:red;font-size: 25px;">*</span>
                <div style="height:30px;color:#FF0000; font-size:14px;font-weight:bold; " id="erroractivitytype" ></div>
                <div style="height:20px;"></div>
                <div>
                <input type="submit" name="submit" class="btn btn-primary" style="width:20%;" value="Submit" />
                &nbsp;&nbsp;&nbsp;
           <a href="activitylist.php?name=<?=$name?>"><input type="button" style="width:20%;" value="Back" class="btn btn-danger"></a>
                 <div style="color:#FF0000;padding-top:10px;" align="center" > <?php echo $report;?></div>
                </div>
                 <div style="height:30px;"></div>
                </div>
                   
                   <div style="height:20px;"></div>
                </form>
         
        </div>
        
         <div class="col-md-6">
      
        	
            	<div style="background-color:#FFFFFF; border:1px solid #CCCCCC;" align="right">
                
                
                <table id="example" class="table-bordered" cellpadding="2" cellspacing="2" width="100%">
                                      
                    	<tr align="left" style="width:100%; background-color:#999999; color:#FFFFFF; height:30px;"><th>
                        Sr. No.</th><th>Activity Name</th><th>Activity Type</th><th>Edit</th><th>Delete</th></tr>
                        <?php
							$i=$rec_limit*$page;
							$sp_id1=$id;
						
							
							$arr = mysql_query( "SELECT * FROM tbl_studentpointslist sp JOIN tbl_activity_type a WHERE sp.school_id= '$school_id'  AND a.id = sc_type ORDER BY sc_id LIMIT $offset, $rec_limit"  );
							while($row = mysql_fetch_array($arr))
							{
							$i++;
						?>
                        <tr align="left"><td><?php echo $i;?></td><td><?php echo $row['sc_list'];?></td><td><?php echo $row['activity_type'];?></td>
                         <td><a href="editschoolactivity.php?activity=<?php echo $row['sc_id'];  ?>" >Edit</a></td>
                     <td><a  onClick="confirmation(<?php echo $row['sc_id'];?>)">Delete</a></td></tr>
                        <?php
							}
						?>
                    </table>
                	
                
                </div>
                
                
                 <div align="center">
        <?php
if( $page > 0 )
{
   $last = $page - 2;
   echo "<a href=\"activity.php?id=".$std_id."&$page=$last\">Last 10 Records</a> |";
   echo "<a href=\"activity.php?id=".$std_id."&page=$page\">Next 10 Records</a>";
}
else if( $page == 0 )
{
   echo "<a href=\"activity.php?id=".$std_id."&page=$page\">Next 10 Records</a>";
}
else if( $left_rec < $rec_limit )
{
   $last = $page - 2;
   echo "<a href=\"activity.php?id=".$std_id."&page=$last\">Last 10 Records</a>";
}

?></div>
         
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
		   include_once("scadmin_header.php");
		   
	       $id=$_SESSION['id'];
           $fields=array("id"=>$id);
		   $table="tbl_school_admin";
		   
// 		   $smartcookie=new smartcookie();
		   
// $results=$smartcookie->retrive_individual($table,$fields);
// $school_admin=mysql_fetch_array($results);
			$school_id=$_SESSION['school_id'];
			$report="";
			
			$rec_limit = 10;
			$sql =  "SELECT *  FROM tbl_studentpointslist sp JOIN tbl_activity_type a WHERE sp.school_id= '$school_id'  AND a.id = sc_type";
$retval = mysql_query( $sql);
if(! $retval )
{
  die('Could not get data: ' . mysql_error());
}


$row = mysql_fetch_array($retval, MYSQL_NUM );
$rec_count = $row[0];

if( isset($_GET{'page'} ) )
{
   $page = $_GET{'page'} + 1;
   $offset = $rec_limit * $page ;
}
else
{
   $page = 0;
   $offset = 0;
}
 $left_rec = $rec_count - ($page * $rec_limit);
 
 
    	if(isset($_POST['submit']))
		{
 			$activity_name=$_POST['activity'];
 			$activity_type=$_POST['type'];
			
			
			
			$sql=mysql_query("select id from tbl_activity_type where activity_type='$activity_type' AND school_id=$school_id");
			
			$sql1=mysql_fetch_array($sql);
			$id=$sql1['id'];

			$query=mysql_query( "select sc_list from tbl_studentpointslist where sc_list='$activity_name' AND (school_id='$school_id')  ");
			
			$test=mysql_num_rows($query);
		if($test<=0)
		{		
			$result=mysql_num_rows($sql);
			if($result==1)
			{
				$query="insert into tbl_studentpointslist(sc_list,sc_type,school_id) values('$activity_name','$id','$school_id')";
				$rs = mysql_query( $query ); 
				
				$successreport="Activity is Successfully added"; 
			}
		else
		{
			$results = mysql_query("SELECT * FROM tbl_activity_type WHERE activity_type='$activity_type' and school_id='$school_id'");
			$result1=mysql_fetch_array($results);
		 	$activity_type=$result1['id']; 
			if (mysql_num_rows($results) == 0) 
			{
			$sql=mysql_query("insert into tbl_activity_type(activity_type,school_id) values('$activity_type','$school_id')");
			$result=mysql_query("select * from tbl_activity_type where activity_type='$activity_type'");
			$result2=mysql_fetch_array($result);
			$activity_type=$result2['id'];
			}
			$query="insert into tbl_studentpointslist(sc_list,sc_type,school_id) values('$activity_name','$activity_type','$school_id')";
			$rs = mysql_query( $query );
			
			$successreport="Activity is Successfully added"; 

		}
		
				
		}
		
		else
		{
		 $report="Activity is already present";
		}
		}
		
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<!--Changes done by Pranali  on 11-06-2018 for bug SMC-2749 -->

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
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
<title>Smart Cookies</title>
</head>

<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">

 <link rel="stylesheet" href="css/bootstrap.min.css">

<script src="js/jquery-1.11.1.min.js"></script>

<script src="js/jquery.dataTables.min.js"></script>

<script>

$(document).ready(function() {

    $('#example').dataTable( {
		
    } );

} );



</script>
<script>
function valid()
{

var activity=document.getElementById("activity").value;
var activity_type=document.getElementById("type").value;
  if(activity.trim()=="" )
  {
   document.getElementById('erroractivity').innerHTML='Please Enter Activity';
				
				return false;
	}
 
var letters =/^[^-\s][a-zA-Z_\s-]+$/
   if(!activity.match(letters))  
     {  
	 document.getElementById('erroractivity').innerHTML='Please Enter Valid Activity';
      return false;  
     }  
 else{
	document.getElementById('erroractivity').innerHTML=''; 
 }

	
	
  if(activity_type=="select" )
  {

   document.getElementById('erroractivitytype').innerHTML='Please Enter Activity Type';
				
				return false;
	}
	




}

function confirmation(xxx) {

    var answer = confirm("Are you sure you want to delete?")
    if (answer){
        
        window.location = "delete_activity.php?id="+xxx;
    }
    else{
       
    }
}
</script>
</head>

<body style="background-color:#F8F8F8;">
<div class="container">
	<div style="width:100%">
    	
        
        	<div style="height:10px;"></div>
    		<div style="height:50px; border-bottom: thin solid #CCCCCC;" align="center">
        	<h1 style="padding-left:20px; margin-top:2px;color:#666">Activity</h1>
        	</div>
    	<div style="height:30px;"></div>
    	
         <div class="container">
        <div class="row">
         <div class="col-md-6">
    
        <form method="post" name="product" onsubmit="return valid()">
        	<div style=" background-color:#FFFFFF; border:1px solid #CCCCCC; padding-left:30px;" align="left">
            	<div style="height:10px;"></div>
            	<div>
					<h2 style="color:#666;">Add Activity</h2>
                </div>
                
                <div style="height:30px;color:#FF0000; font-size:14px;font-weight:bold; " id="erroractivity" ></div>
                <div><b style="color:red";>*</b>
                 <select name="type" id="type"  style="width:50%; height:30px; padding:5px;">
                 <option value="select">Select Activity Type</option>
        <!--Modified query for taking not blank records and alphabetically ordered records by Pranali for SMC-4998-->
                <?php $query=mysql_query("select distinct(activity_type) from tbl_activity_type where school_id='$school_id' AND activity_type!='' ORDER BY activity_type ASC");
				while($row=mysql_fetch_array($query))
				{?>
               
                <option value='<?php echo $row['activity_type'];?>'><?php echo $row['activity_type'];?></option>
                
             
               <?php }?>
                  </select>
                </div>
                <div style="height:30px;color:#FF0000; font-size:14px;font-weight:bold; " id="erroractivitytype" ></div>
				
				<div style="height:10px;"></div>
            	<div><b style="color:red";>*</b>
                <input type="text" id="activity"  name="activity" style="width:50%; height:30px; padding:5px;" placeholder="Enter Activity" />
                </div>
                <div style="height:20px;"></div>
                <div>
                <input type="submit" name="submit" class="btn btn-primary" style="width:20%;" value="Submit" />
                &nbsp;&nbsp;&nbsp;
                <a href="activitylist.php"><input type="button" style="width:20%;" value="Back" class="btn btn-danger"></a>
                 <div style="color:#FF0000;padding-top:10px;" align="center" > <?php echo $report;?></div>
                 <div style="color:#090;" align="center"><?php echo $successreport;?></div>
                </div>
                 <div style="height:30px;"></div>
                </div>
                   
                   <div style="height:20px;"></div>
                </form>
         
        </div>
        
         <div class="col-md-6">
      
        	
            	<div style="background-color:#FFFFFF; border:1px solid #CCCCCC;" align="right">
                
                
                <table id="example" class="table-bordered table-condensed cf" cellpadding="2" cellspacing="2" width="100%">
                     <thead>                 
                    	<tr align="left" style="width:100%; background-color:#999999; color:#FFFFFF; height:30px;"><th>
                        Sr. No.</th><th>Activity Name</th><th>Activity Type</th><th>Edit</th><th>Delete</th></tr>
						</thead>
						<tbody>
                        <?php
							$i=$rec_limit*$page;
							$sp_id1=$_SESSION['id'];
													
							$arr = mysql_query("SELECT *  FROM tbl_studentpointslist sp JOIN tbl_activity_type a WHERE sp.school_id= '$school_id'  AND a.id = sp.sc_type ORDER BY sp.sc_id");
							while($row = mysql_fetch_array($arr))
							{
							$i++;
						?>
                        <tr align="left"><td><?php echo $i;?></td><td><?php echo $row['sc_list'];?></td><td><?php echo $row['activity_type'];?></td>
                         <td><a href="editschoolactivity.php?activity=<?php echo $row['sc_id'];  ?>" >Edit</a></td>
                     <td><a  onClick="confirmation(<?php echo $row['sc_id']; ?> )">Delete</a></td></tr>
                        <?php
							}
						?>
						</tbody>
                    </table>
                             
                </div>
                            
            </div>
           
          </div>    
    </div>
</div>
</div>
</body>
</html>
<?php   
	}
?>
	