<?Php 

                          if(isset($_GET['id']))
						  {
							$report="";					 
		     //include_once("school_staff_header.php");
			 include("scadmin_header.php");

$results=mysql_query("SELECT * FROM `tbl_school_adminstaff` WHERE id =".$staff_id."");
$result=mysql_fetch_array($results);

$school_id=$result['school_id'];
if(isset($_POST['submit']))
{

 $activity_id=$_POST['activity_id'];
 $method_id=$_POST['method_name'];

 $rows= mysql_query("select * from tbl_master where school_id='$school_id' and activity_id='$activity_id'");
	  if(mysql_num_rows($rows)<=0)
	  {
		for($i=0;$i<4;$i++)
			{
			  $from=$_POST["from".$i];
			  $to=$_POST["to".$i];
			  $point=$_POST["point".$i];
		
			if($from!="" && $to!="" && $point!="")
			{
				mysql_query("insert into tbl_master(from_range,to_range,points,school_id,method_id,activity_id,subject_id) values('$from','$to','$point','$school_id','$method_id','$activity_id','0') ");
			}
			
			 
			}
			 if(mysql_affected_rows()>0)
				  {
				  
				    
								  $query=mysql_query("select method_name from tbl_method where id='$method_id'");
								  $test=mysql_fetch_array($query);
								  $method=$test['method_name'];
								  
								    $query1=mysql_query("select sc_list from tbl_studentpointslist where sc_id='$activity_id'");
								  $test1=mysql_fetch_array($query1);
								  $subject=$test1['sc_list'];
				  
				//$report=" You have successfully updated $method method for $subject activity";
				echo "<script LANGUAGE='JavaScript'>
					window.alert('You have successfully updated $method method for $subject activity');
					window.location.href='schoolAdminStaff_list.php';
					</script>";
				  
				  }

			
		}
		else
		{
	
		mysql_query("delete from tbl_master where school_id='$school_id' and activity_id='$activity_id'");
			for($i=0;$i<4;$i++)
			{
			  $from=$_POST["from".$i];
			  $to=$_POST["to".$i];
			  $point=$_POST["point".$i];
			
			
		if($from!="" && $to!="" && $point!="")
			{
				mysql_query("insert into tbl_master(from_range,to_range,points,school_id,method_id,activity_id,subject_id) values('$from','$to','$point','$school_id','$method_id','$activity_id','0') ");
			}
	       }
		    if(mysql_affected_rows()>0)
				  {
				 $query=mysql_query("select method_name from tbl_method where id='$method_id'");
								  $test=mysql_fetch_array($query);
								  $method=$test['method_name'];
								  
								    $query1=mysql_query("select sc_list from tbl_studentpointslist where sc_id='$activity_id'");
								  $test1=mysql_fetch_array($query1);
								  $subject=$test1['sc_list'];
				  
				$report=" You have successfully updated $method method for $subject activity";
				  
				  }
		
		}
		
	
	
	

}
?>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
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
		font-weight: bold;
	}
 
	/*
	Label the data
	*/
	#no-more-tables td:before { content: attr(data-title); }
}
		</style>
        <script>
		function display_points_ofmethod()
{
 document.getElementById('error').innerHTML='';
	
		var method_name=document.getElementById("method_name").value;
	var activity_id 	=document.getElementById("activity_id").value;
 		
        if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
         document.getElementById("cookieadmin_master").innerHTML  =xmlhttp.responseText;
            }
          }
       xmlhttp.open("GET","get_cookieadminmaster_staff.php?method_name="+method_name+"&subject_id=0&activity_id="+activity_id,true);
        xmlhttp.send();

}
function display_range_ofactivity()
{
		 document.getElementById('error').innerHTML='';
		//var method_name=document.getElementById("method_name").value;
	var activity_id 	=document.getElementById("activity_id").value;
 		
        if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
			var data=xmlhttp.responseText;
	        var arr=data.split("**");
		
			var index=arr[0];
				
         document.getElementById("method_name").options[index-1].selected = true;
		
		    document.getElementById("cookieadmin_master").innerHTML  =arr[1];
            }
          }
        xmlhttp.open("GET","get_method_range.php?subject_id=0&activity_id="+activity_id,true);
        xmlhttp.send();


}

		

function display_activity()
{
var activity_type=document.getElementById("activity_type").value;
 document.getElementById('error').innerHTML='';
 		
        if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
         document.getElementById("activity_id").innerHTML =xmlhttp.responseText;
            }
          }
       xmlhttp.open("GET","get_activity_staff.php?activity_type="+activity_type,true);
        xmlhttp.send();


}
function validation()
{
   var activity_type = document.getElementById("activity_type").value;
   var method = document.getElementById("method_name").value;
   var activity = document.getElementById("activity_id").value;
	  if(activity_type=='')
	 {
	  document.getElementById('error').innerHTML='Please select Activity Type';
				
		  return false;
	 
	 }
	 else if(activity=='')
	 {
	  document.getElementById('error').innerHTML='Please select activity';
				
		  return false;
	 
	 }
	 
	 
	 else if(method=='')
	 {
	  document.getElementById('error').innerHTML='Please select method';
				
		  return false;
	 
	 }
	 else
	 {
	  document.getElementById('error').innerHTML='';
	 }
	  var numbers = /^[0-9]+$/;  
    var alpha=/^[a-zA-Z+]+$/;
	for(var i=0;i<4;i++)
	{
	  var to='to'+i;
	  var from='from'+i;
	  var point='point'+i;
	var to_range=document.getElementById(to).value;
	var from_range=document.getElementById(from).value;
	var point_value=document.getElementById(point).value;
	if(from_range!='' && to_range!='' )
   {
	
			if(method==2 || method==4)
			{
			
				 if(!numbers.test(to_range))
				 {
				 document.getElementById('error').innerHTML='Please enter valid to_range ';
						
				  return false;
				 }
				 if(!numbers.test(from_range))
				 {
					 document.getElementById('error').innerHTML='Please enter valid from_range ';
				  return false;
				 }
				 if(!numbers.test(point_value))
				 {
					 document.getElementById('error').innerHTML='Please enter valid  point ';
				  return false;
				 }
					var from_range = new Number(from_range);
				var to_range = new Number(to_range);
				
				   if(from_range>to_range)
				   {
					document.getElementById('error').innerHTML='From range should be less than to range';
								
						  return false;
				   
				   }
			
			
			
			}
			else
			{
				 if(!alpha.test(to_range))
					 {
					 document.getElementById('error').innerHTML='Please enter valid to_range ';
					  return false;
					 }
				 if(!alpha.test(from_range))
					 {
					  document.getElementById('error').innerHTML='Please enter valid from_range ';
					  return false;
					 }
					 if(!numbers.test(point_value))
					 {
						 document.getElementById('error').innerHTML='Please enter valid  point ';
					  return false;
					 }
					   if(from_range>to_range)
				   {
					document.getElementById('error').innerHTML='From range should be less than to range';
								
						  return false;
				   
				   }
				
			}
	}
	 
	
	}
	
}
		
		</script>
</head>

<body>
<div class="container" style="padding:10px;">
<div class="container" style="padding:10px;">
<div class="row" style="padding:5px;height:50px; background-color:#C1CDCD ;border-color:#C1CDCD;box-shadow: 0px 1px 3px 1px #C3C3C4;" align="left">
        	<h1 style="padding-left:20px; margin-top:2px;">Activity Method</h1>
        </div>
        
 </div>
  <div class="container" style="background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;padding:5px;" align="center">
  <form method="post" >
   <div class="row" style="padding:2px;">
            <div class="col-md-2 col-md-offset-3"  style="font-size:16px;font-weight:bold;" align="left">
              Activity Type
            </div>
             <div class="col-md-3">
             <select name="activity_type" id="activity_type" class="form-control form-group-internal" onChange="display_activity()" >
             <option value="">Select</option>
             <?php  
			  $row=mysql_query("select * from tbl_activity_type where school_id='$school_id' ");  
			        while( $result=mysql_fetch_array($row))
					{
					// print($result);exit;
					 ?>
                    <option value="<?php echo $result['id']; ?>"><?php echo $result['activity_type']; ?></option>
                     
              <?php }?>
               </select>
            </div>
            </div>
    <div class="row" style="padding:2px;">
            <div class="col-md-2 col-md-offset-3"  style="font-size:16px;font-weight:bold;" align="left">
              Activity
            </div>
             <div class="col-md-3">
             <select name="activity_id" id="activity_id" class="form-control form-group-internal" onChange="display_range_ofactivity()" >
             
               </select>
            </div>
            </div>
            <div class="row" style="padding-top:5px;" align="left">
              <div class="col-md-2 col-md-offset-3" style="font-size:16px;font-weight:bold;">
                  Method
            </div>
             <div class="col-md-3">
             <select name="method_name" id="method_name" class="form-control" onChange="display_points_ofmethod()">
               <option value="">Select</option>
             <?php  $row=mysql_query("select * from tbl_method  where where school_id='$school_id'");  
			        while( $result=mysql_fetch_array($row))
					{
					 
					 ?>
                    <option value="<?php echo $result['id']; ?>"><?php echo $result['method_name']; ?></option>
                     
              <?php }?>
               </select>
            </div>
    </div>
             <div class="container" id="cookieadmin_master" style="padding:5px;">
            
            
                 
                 
            
             </div>
             <div class="row" style="padding-top:5px;">
             <div class="col-md-2 col-md-offset-4">
             <input type="submit" class="btn btn-primary" name="submit" value="Submit" style="width:100px;font-weight:bold;font-size:14px;" onClick=" return validation()"/>
             </div>
             <div class="col-md-3">
                      <?php $names="school_master_table"; ?>
             <a href="school_master_table.php?name=<?=$names?>">
             <input type="button" class="btn btn-primary" value="Back" style="width:100px;font-weight:bold;font-size:14px;" />
             </a>
             </div>
             </div>
             <div class="row" style="padding-top:5px;color:#006600;">
             <div class="col-md-4 col-md-offset-4" id="error"><b>
              <?php echo $report;?></b>
             </div>
           
             </div>
             </form>
   
       
    </div>
  
</div>
  


 </div>

</body>

</html>
<?php
							  }
							  else
							  {
								  $report="";
								  include("scadmin_header.php");
//include("hr_header.php");
$id=$_SESSION['id'];
//            $fields=array("id"=>$id);
// 		   $table="tbl_school_admin";
		   
// 		   $smartcookie=new smartcookie();
		   
// $results=$smartcookie->retrive_individual($table,$fields);
// $result=mysql_fetch_array($results);

$school_id=$_SESSION['school_id'];
if(isset($_POST['submit']))
{

 $activity_id=$_POST['activity_id'];
 $method_id=$_POST['method_name'];
//method_id checked in select query by Pranali for SMC-4210 on 2-12-19
 $rows= mysql_query("select * from tbl_master where school_id='$school_id' and activity_id='$activity_id' and method_id='$method_id'");

	  if(mysql_num_rows($rows)<=0)
	  {
		for($i=0;$i<4;$i++)
			{
			  $from=$_POST["from".$i];
			  $to=$_POST["to".$i];
			  $point=$_POST["point".$i];
		
			if($from!="" && $to!="" && $point!="")
			{
				mysql_query("insert into tbl_master(from_range,to_range,points,school_id,method_id,activity_id,subject_id) values('$from','$to','$point','$school_id','$method_id','$activity_id','0') ");
			}
			
			 
			}
			 if(mysql_affected_rows()>0)
				  {
				  
				    
								  $query=mysql_query("select method_name from tbl_method where id='$method_id'");
								  $test=mysql_fetch_array($query);
								  $method=$test['method_name'];
								  
								    $query1=mysql_query("select sc_list from tbl_studentpointslist where sc_id='$activity_id'");
								  $test1=mysql_fetch_array($query1);
								  $subject=$test1['sc_list'];
				  
				//$report=" You have successfully updated $method method for $subject activity";
				echo "<script LANGUAGE='JavaScript'>
					alert('You have successfully updated $method method for $subject activity');
					window.location.href='school_master_table.php';
					</script>";
				  
				  }

			
		}
		else
		{
	
		mysql_query("delete from tbl_master where school_id='$school_id' and activity_id='$activity_id'");
			for($i=0;$i<4;$i++)
			{
			  $from=$_POST["from".$i];
			  $to=$_POST["to".$i];
			  $point=$_POST["point".$i];
			
			
		if($from!="" && $to!="" && $point!="")
			{

				mysql_query("insert into tbl_master(from_range,to_range,points,school_id,method_id,activity_id,subject_id) values('$from','$to','$point','$school_id','$method_id','$activity_id','0') ");
			}
	       }
		    if(mysql_affected_rows()>0)
				  {
				  	
				 $query=mysql_query("select method_name from tbl_method where id='$method_id'");
								  $test=mysql_fetch_array($query);
								  $method=$test['method_name'];
								  
								    $query1=mysql_query("select sc_list from tbl_studentpointslist where sc_id='$activity_id'");
								  $test1=mysql_fetch_array($query1);
								  $subject=$test1['sc_list'];
				  
				//$report=" You have successfully updated $method method for $subject activity";
				echo "<script LANGUAGE='JavaScript'>
					alert('You have successfully updated $method method for $subject activity');
					window.location.href='school_master_table.php';
					</script>";
				  
				  }
		
		}
}
?>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
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
		font-weight: bold;
	}
 
	/*
	Label the data
	*/
	#no-more-tables td:before { content: attr(data-title); }
}
		</style>
        <script>
function display_points_ofmethod()
{
	document.getElementById('error').innerHTML='';
		
	var method_name = document.getElementById("method_name").value;
	var activity_id = document.getElementById("activity_id").value;
 		
        if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
         document.getElementById("cookieadmin_master").innerHTML  =xmlhttp.responseText;
            }
          }
       xmlhttp.open("GET","get_cookieadminmaster.php?method_name="+method_name+"&subject_id=0&activity_id="+activity_id,true);
        xmlhttp.send();

}
function display_range_ofactivity()
{
		 document.getElementById('error').innerHTML='';
		//var method_name=document.getElementById("method_name").value;
	var activity_id 	=document.getElementById("activity_id").value;
 		
        if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
			var data=xmlhttp.responseText;
	        var arr=data.split("**");
		
			var index=arr[0];
				
         document.getElementById("method_name").options[index-1].selected = true;
		
		    document.getElementById("cookieadmin_master").innerHTML  =arr[1];
            }
          }
        xmlhttp.open("GET","get_method_range.php?subject_id=0&activity_id="+activity_id,true);
        xmlhttp.send();


}	

function display_activity()
{
var activity_type=document.getElementById("activity_type").value;
 document.getElementById('error').innerHTML='';
 		
        if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
         document.getElementById("activity_id").innerHTML =xmlhttp.responseText;
            }
          }
       xmlhttp.open("GET","get_activity.php?activity_type="+activity_type,true);
        xmlhttp.send();


}
function validation()
{
	var activity_type=document.getElementById("activity_type").value;
    var method=document.getElementById("method_name").value;

    var elt = document.getElementById('method_name');
    methodname = elt.options[elt.selectedIndex].text;

    //alert(sel.options[sel.selectedIndex].text);
    //var method_name=document.getElementById("method_name").text;
	var activity=document.getElementById("activity_id").value;
	var method_details=document.getElementById("method_details");
	 // alert(activity_type+' '+method+' '+activity);
	  
	if(activity_type=='')
	 {
	  document.getElementById('error').innerHTML='Please select Activity Type';
				
		  return false;
	 
	 }
	 
	else if(activity=='')
	 {
	  document.getElementById('error').innerHTML='Please select activity';
				
		  return false;
	 
	 }
	 
	 else if(method=='')
	 {
	  document.getElementById('error').innerHTML='Please select method';
				
		  return false;
	 
	 }
	 else
	 {
	  document.getElementById('error').innerHTML='';
	 }
	  var numbers = /^[0-9]+$/;  
    var alpha=/^[a-zA-Z0-9+]+$/;
	for(var i=0;i<4;i++)
	{
	  var to='to'+i;
	  var from='from'+i;
	  var point='point'+i;

	var to_range=document.getElementById(to).value;
	var from_range=document.getElementById(from).value;
	var point_value=document.getElementById(point).value;
	
	if(from_range!='' && to_range!='')
   {
			if(methodname=='Marks' || methodname=='Percentile') //method checking for Marks and Percentile
			{
	
				 if(!numbers.test(to_range))
				 {
				 		
				 document.getElementById('error').innerHTML='Please enter valid to_range ';
						
				  return false;
				 }
				 if(!numbers.test(from_range))
				 {
					 document.getElementById('error').innerHTML='Please enter valid from_range ';
				  return false;
				 }
				 if(!numbers.test(point_value))
				 {
					 document.getElementById('error').innerHTML='Please enter valid  point ';
				  return false;
				 }
				var from_range = new Number(from_range);
				var to_range = new Number(to_range);
				
				   if(from_range>to_range)
				   {
					document.getElementById('error').innerHTML='From range should be less than to range';
								
						  return false;
				   
				   }
			
			}
			else //only for grade
			{
				 if(!alpha.test(to_range))
					 {
					 document.getElementById('error').innerHTML='Please enter valid to_range ';
					  return false;
					 }
				 if(!alpha.test(from_range))
					 {
					  document.getElementById('error').innerHTML='Please enter valid from_range ';
					  return false;
					 }
					 if(!numbers.test(point_value))
					 {
						 document.getElementById('error').innerHTML='Please enter valid  point ';
					  return false;
					 }
					   if(from_range>to_range)
				   {
					document.getElementById('error').innerHTML='From range should be less than to range';
								
						  return false;
				   
				   }
				
			}
	}
	 
	
	}
	
}
		
		</script>
</head>

<body>
<div class="container" style="padding:10px;">
<div class="container" style="padding:10px;">
<div class="row" style="padding:5px;height:50px; background-color:#C1CDCD ;border-color:#C1CDCD;box-shadow: 0px 1px 3px 1px #C3C3C4;" align="left">
        	<h1 style="padding-left:20px; margin-top:2px;">Activity Method</h1>
        </div>
        
 </div>
  <div class="container" style="background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;padding:5px;" align="center">
  <form method="post" >
   <div class="row" style="padding:2px;">
            <div class="col-md-2 col-md-offset-3"  style="font-size:16px;font-weight:bold;" align="left">
              Activity Type
            </div>
             <div class="col-md-3">
             <select name="activity_type" id="activity_type" class="form-control form-group-internal" onChange="display_activity()" >
             <option value="">Select</option>
             <?php 
             //Query modified for checking activity_type!='' and ordering activity_type in ascending order by Pranali for SMC-5020
			  $row=mysql_query("select distinct * from tbl_activity_type where school_id='$school_id' and activity_type!='' ORDER BY activity_type ASC "); 
		
			        while( $result=mysql_fetch_array($row))
					{
					 
					 ?>
                    <option value="<?php echo $result['id']; ?>"><?php echo $result['activity_type']; ?></option>
                     
              <?php }?>
               </select>
            </div>
            </div>
    <div class="row" style="padding:2px;">
            <div class="col-md-2 col-md-offset-3"  style="font-size:16px;font-weight:bold;" align="left">
              Activity
            </div>
             <div class="col-md-3">
             <select name="activity_id" id="activity_id" class="form-control form-group-internal" onChange="display_range_ofactivity()" >
             
               </select>
            </div>
            </div>
            <div class="row" style="padding-top:5px;" align="left">
              <div class="col-md-2 col-md-offset-3" style="font-size:16px;font-weight:bold;">
                  Method
            </div>
             <div class="col-md-3">
             <select name="method_name" id="method_name" class="form-control" onChange="display_points_ofmethod()">
               <option value="">Select</option>
             <?php  $row=mysql_query("select * from tbl_method where school_id='".$school_id."' and method_flag='Yes' and method_name!='Judgement'");
			        while( $result=mysql_fetch_array($row))
					{
					 
					 ?>
                    <option value="<?php echo $result['id']; ?>"><?php echo $result['method_name']; ?></option>
                   
              <?php }
              ?>


               </select>
            </div>
    </div>
             <div class="container" id="cookieadmin_master" style="padding:5px;">
             </div>
             <div class="row" style="padding-top:5px;">
             <div class="col-md-2 col-md-offset-4">
             <input type="submit" class="btn btn-primary" name="submit" value="Submit" style="width:100px;font-weight:bold;font-size:14px;" onClick=" return validation()"/>
             </div>
             <div class="col-md-3">
             <a href="school_master_table.php">
             <input type="button" class="btn btn-primary" value="Back" style="width:100px;font-weight:bold;font-size:14px;" />
             </a>
             </div>
             </div>
             <div class="row" style="padding-top:5px;color:#006600;">
             <div class="col-md-4 col-md-offset-4" id="error"><b>
              <?php echo $report;?></b>
             </div>
           
             </div>
             </form>
   
       
    </div>
  
</div>
  


 </div>

</body>

</html>
<?php
								  }
?>