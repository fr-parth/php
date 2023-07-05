<?php

           if(isset($_GET['id']))
		   {
		 include_once("school_staff_header.php");
	  $report="";
	  $results=mysql_query("SELECT * FROM `tbl_school_adminstaff` WHERE id =".$staff_id."");
	  $result=mysql_fetch_array($results);
	  $school_id=$result['school_id'];

if(isset($_POST['submit']))
{
 $subject_id=$_POST['subject_id'];
 $method=$_POST['method_name'];
 $meth= explode(",", $method);
 $method_id = $meth['0'];
 $method_name = $meth['1'];
 $rows= mysql_query("select * from tbl_master where school_id='$school_id' and subject_id='$subject_id'");
	  if(mysql_num_rows($rows)<=0)
	  {
			for($i=0;$i<4;$i++)
				{
				  $from=$_POST["from".$i];
				  $to=$_POST["to".$i];
				 
				  $point=$_POST["point".$i];
				
					  
				
							if($from!="" && $to!="" && $point!="")
							{
		mysql_query("insert into tbl_master(from_range,to_range,points,school_id,method_id,subject_id) values('$from','$to','$point','$school_id','$method_id','$subject_id')");
							}
							
							 if(mysql_affected_rows()>0)
								  {
								  
								  $query=mysql_query("select method_name from tbl_method where id='$method_id'");
								  $test=mysql_fetch_array($query);
								  $method=$test['method_name'];
								  
								    $query1=mysql_query("select subject from tbl_school_subject where id='$subject_id'");
								  $test1=mysql_fetch_array($query1);
								  $subject=$test1['subject'];
								 echo "<script LANGUAGE='JavaScript'>
					window.alert('You have successfully updated $method method for $subject $dynamic_subject');
					window.location.href='school_master_table.php';
					</script>";
								// $report="";
								  
								  }
					             }
                              }
		                  else
		                     {
	    mysql_query("delete from tbl_master where school_id='$school_id' and subject_id='$subject_id'");
		   for($i=0;$i<4;$i++)
			{
			  $from=$_POST["from".$i];
			  $to=$_POST["to".$i];
			  $point=$_POST["point".$i];
			 if($from!="" && $to!="" && $point!="")
						{
			mysql_query("insert into tbl_master(from_range,to_range,points,school_id,method_id,subject_id) values('$from','$to','$point','$school_id','$method_id','$subject_id')");
						}
			      if(mysql_affected_rows()>0)
					  {
					     $query=mysql_query("select method_name from tbl_method where id='$method_id'");
						 $test=mysql_fetch_array($query);
						 $method=$test['method_name'];
						 $query1=mysql_query("select subject from tbl_school_subject where id='$subject_id'");
						 $test1=mysql_fetch_array($query1);
						 $subject=$test1['subject'];
								  
					 $report="You have successfully updated $method method for $subject subject.";
					  
					  }
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
    	var subject_id 	=document.getElementById("subject_id").value;
 		
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
        xmlhttp.open("GET","get_cookieadminmaster.php?method_name="+method_name+"&subject_id=" +subject_id+"&activity_id=0",true);
        xmlhttp.send();


}


function display_points_ofsubject()
{
		  document.getElementById('error').innerHTML='';
		//var method_name=document.getElementById("method_name").value;
	var subject_id 	=document.getElementById("subject_id").value;
 		
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
		
		    document.getElementById("cookieadmin_master").innerHTML=arr[1];
            }
          }
        xmlhttp.open("GET","get_method_range.php?subject_id="+subject_id+"&activity_id=0",true);
        xmlhttp.send();
   }
   
   
 function validation()
   {
     var method=document.getElementById("method_name").value;
	 
	 if(method==1)
	 {
	  document.getElementById('error').innerHTML='Using Judgement Method Teacher can assign points in between 1 to 100 ';
	  return false;
	 }
	  var subject=document.getElementById("subject_id").value;
	  if(subject=='')
	 {
	  document.getElementById('error').innerHTML='Please select <?php echo $dynamic_subject; ?>';
				
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
   	var meth = method.split(",");
   	var method_id = meth[0];
   	var method_name = meth[1];
   	//Below condition changed by Rutuja for SMC_5069 on 17-02-2021
	if(method_name=="Marks" || method_name=="Percentile")
	{
	     if(from_range!='' && to_range!='' )
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
		  
	
	
	}
	else
	{
	if(from_range!='' && to_range!='' )
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
        	<h1 style="padding-left:20px; margin-top:2px;"><?php echo $dynamic_subject;?> Method</h1>
        </div>
        
 </div>
  <div class="container" style="background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;padding:5px;" align="center">
  <form method="post" >
    <div class="row" style="padding:2px;">
            <div class="col-md-2 col-md-offset-3"  style="font-size:16px;font-weight:bold;"><?php echo $dynamic_subject;?><span style="color:red;font-size: 25px;">*</span>
            </div>
             <div class="col-md-3">
             <select name="subject_id" id="subject_id" class="form-control form-group-internal" onChange="display_points_ofsubject()">
              <option value="">Select</option>
             <?php  $row=mysql_query("select * from tbl_school_subject where school_id='$school_id'");  
			        while( $result=mysql_fetch_array($row))
					{
					 
					 ?>
                    <option value="<?php echo $result['id']; ?>"><?php echo $result['subject']; ?></option>
                     
              <?php }?>
               </select>
            </div>
            </div>
            <div class="row" style="padding-top:5px;">
              <div class="col-md-2 col-md-offset-3" style="font-size:16px;font-weight:bold;">
                  Method<span style="color:red;font-size: 25px;">*</span>
            </div>
             <div class="col-md-3">
             <select name="method_name" id="method_name" class="form-control" onChange="display_points_ofmethod()">
               <option value="">Select</option>
             <?php  $row=mysql_query("select * from tbl_method where school_id=''");  
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
             <input type="submit" class="btn btn-primary" name="submit" value="Submit" onClick="return validation()"  style="width:100px;font-weight:bold;font-size:14px;" />
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
			  include('scadmin_header.php');
$report="";

// $smartcookie=new smartcookie();
$id=$_SESSION['id'];
     //       $fields=array("id"=>$id);
		   // $table="tbl_school_admin";
		   
		   // $smartcookie=new smartcookie();
		   
// $results=$smartcookie->retrive_individual($table,$fields);
// $result=mysql_fetch_array($results);
$school_id=$_SESSION['school_id'];


if(isset($_POST['submit']))
{

 $subject_id=$_POST['subject_id'];
 $method=$_POST['method_name'];
 $meth= explode(",", $method);
 $method_id = $meth['0'];
 $method_name = $meth['1'];


 $rows= mysql_query("select * from tbl_master where school_id='$school_id' and subject_id='$subject_id'");
	  if(mysql_num_rows($rows)<=0)
	  {
			for($i=0;$i<4;$i++)
				{
				  $from=$_POST["from".$i];
				  $to=$_POST["to".$i];
				 
				  $point=$_POST["point".$i];
				
					  if($from!="" && $to!="" && $point!="")
							{
								mysql_query("insert into tbl_master(from_range,to_range,points,school_id,method_id,subject_id) values('$from','$to','$point','$school_id','$method_id','$subject_id') ");
							}
							
							 if(mysql_affected_rows()>0)
								  {
								  
								  $query=mysql_query("select method_name from tbl_method where id='$method_id'");
								  $test=mysql_fetch_array($query);
								  $method=$test['method_name'];
								  
								  $query1=mysql_query("select subject from tbl_school_subject where id='$subject_id'");
								  $test1=mysql_fetch_array($query1);
								  $subject=$test1['subject'];
								 echo "<script LANGUAGE='JavaScript'>
					alert('You have successfully updated $method method for $subject $dynamic_subject');
					window.location.href='school_master_table.php';
					</script>";
								 //$report=" You have successfully updated $method method for $subject subject";
								
								  
								  }
					           }
                             }
		                  else
		                    {
	
		mysql_query("delete from tbl_master where school_id='$school_id' and subject_id='$subject_id'");
		
		
			for($i=0;$i<4;$i++)
			{
			  $from=$_POST["from".$i];
			  $to=$_POST["to".$i];
			 
			  $point=$_POST["point".$i];
			
				
					if($from!="" && $to!="" && $point!="")
						{
							mysql_query("insert into tbl_master(from_range,to_range,points,school_id,method_id,subject_id) values('$from','$to','$point','$school_id','$method_id','$subject_id') ");
						}
			   
					 if(mysql_affected_rows()>0)
					  {
					  
								  $query=mysql_query("select method_name from tbl_method where id='$method_id'");
								  $test=mysql_fetch_array($query);
								  $method=$test['method_name'];
								  
								  $query1=mysql_query("select subject from tbl_school_subject where id='$subject_id'");
								  $test1=mysql_fetch_array($query1);
								  $subject=$test1['subject'];
								  
					// $report="You have successfully updated $method method for $subject subject.";
					  echo "<script LANGUAGE='JavaScript'>
					alert('You have successfully updated $method method for $subject $dynamic_subject');
					window.location.href='school_master_table.php';
					</script>";
				}
				
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
	var subject_id 	=document.getElementById("subject_id").value;
 		
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
        xmlhttp.open("GET","get_cookieadminmaster.php?method_name="+method_name+"&subject_id=" +subject_id+"&activity_id=0",true);
        xmlhttp.send();


}
function display_points_ofsubject()
{
		  document.getElementById('error').innerHTML='';
		//var method_name=document.getElementById("method_name").value;
	var subject_id 	=document.getElementById("subject_id").value;
 		
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
        xmlhttp.open("GET","get_method_range.php?subject_id=" +subject_id+"&activity_id=0",true);
        xmlhttp.send();


}
 function validation()
{

     var method=document.getElementById("method_name").value;
	 
	 if(method==1)
	 {
	  document.getElementById('error').innerHTML='Using Judgement Method Teacher can assign points in between 1 to 100 ';
	  return false;
	 }
	  var subject=document.getElementById("subject_id").value;
	  if(subject=='')
	 {
	  document.getElementById('error').innerHTML='Please select <?php echo $dynamic_subject; ?>';
				
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
   	var meth = method.split(",");
   	var method_id = meth[0];
   	var method_name = meth[1];//alert(method_id);alert(method_name);
	if(method_name=="Marks" || method_name=="Percentile")
	{
	     if(from_range!='' && to_range!='' )
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
		  }
	else
	{
	if(from_range!='' && to_range!='' )
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
        	<h1 style="padding-left:20px; margin-top:2px;"><?php echo $dynamic_subject;?> Method</h1>
        </div>
        
 </div>
  <div class="container" style="background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;padding:5px;" align="center">
  <form method="post" >
    <div class="row" style="padding:2px;">
            <div class="col-md-2 col-md-offset-3"  style="font-size:16px;font-weight:bold;">
                <?php echo $dynamic_subject;?><span style="color:red;font-size: 25px;">*</span>
            </div>
             <div class="col-md-3">
             <select name="subject_id" id="subject_id" class="form-control form-group-internal" onChange="display_points_ofsubject()">
              <option value="">Select</option>
             <?php  $row=mysql_query("select * from tbl_school_subject where school_id='$school_id' order by `subject` asc");  
			        while( $result=mysql_fetch_array($row))
					{
					 
					 ?>
                    <option value="<?php echo $result['id']; ?>"><?php echo $result['subject']; ?></option>
                     
              <?php }?>
               </select>
            </div>
            </div>
            <div class="row" style="padding-top:5px;">
              <div class="col-md-2 col-md-offset-3" style="font-size:16px;font-weight:bold;">
                  Method<span style="color:red;font-size: 25px;">*</span>
            </div>
             <div class="col-md-3">
             <select name="method_name" id="method_name" class="form-control" onChange="display_points_ofmethod()">
               <option value="">Select</option>
             <?php  
//school_id and method_flag condition added by Pranali for SMC-4210 on 29-11-19
             $row=mysql_query("select * from tbl_method where school_id='$school_id' and method_flag='Yes'");  
			        while( $result=mysql_fetch_array($row))
					{
					 ?>
                    <option value="<?php echo $result['id']; ?>,<?php echo $result['method_name']; ?>"><?php echo $result['method_name']; ?></option>
              <?php }?>
               </select>
            </div>
    </div>
             <div class="container" id="cookieadmin_master" style="padding:5px;"></div>
             
             <div class="row" style="padding-top:5px;">
             <div class="col-md-2 col-md-offset-4">
             <input type="submit" class="btn btn-primary" name="submit" value="Submit"    onClick="return validation()"       style="width:100px;font-weight:bold;font-size:14px;" />
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

