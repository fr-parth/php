<?php
    if(isset($_GET['id'])=='')
	{
            if(isset($_GET['id']))
			{
				$report="";
					include_once("school_staff_header.php");
				$results=mysql_query("select * from tbl_school_adminstaff where id=".$staff_id."");
                $school_admin=mysql_fetch_array($results);
			$school_id=$school_admin['school_id'];
			
			
			
 
    	if(isset($_POST['submit']))
		{
 			$t_list=$_POST['t_list'];
			$query=mysql_query("select t_list from tbl_thanqyoupointslist where t_list like '%$t_list%' and school_id='$school_id' ");
			$query1=mysql_fetch_array($query);
			$test=mysql_num_rows($query);
			
			if($test==0)
			{		
			$query1=mysql_query("insert into tbl_thanqyoupointslist(t_list,school_id,school_staff_id) values('$t_list','$school_id','$staff_id')");
			$query="insert into tbl_thanqyoupointslist(t_list,school_id) values('$t_list','' ||
 '')";
			$rs = mysql_query( $query ); 
		
		
		
			$report="ThanQ Reason $t_list added successfully";
			
		}	
			else
		{
		 $report="ThanQ Reason $t_list is already present";
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
<script>
function valid()
{

var activity=document.getElementById("t_list").value;

  if(activity=="" )
  {
   document.getElementById('erroractivity').innerHTML='Please enter Activity';
				
				return false;
	}
	
	var letters =   /^[a-zA-Z-,]+(\s{0,1}[a-zA-Z-, ])*$/;
   if(!activity.match(letters))  
     {  
	 document.getElementById('erroractivity').innerHTML='Please Enter valid Activity';
      return false;  
     }  
 }


</script>
</head>

<body style="background-color:#F8F8F8;">
<div align="center">
	<div style="width:100%">
    	
        
        	
    	<div style="height:30px;"></div>
    	
         <div class="container">
        <div class="row">
        <div class=col-md-3></div>
         <div class="col-md-7">
    
        <form method="post" name="product" onsubmit="return valid()">
       
           <div style=" background-color:#FFFFFF; border:1px solid #CCCCCC; padding-left:30px;" align="left">
            	<div style="height:10px;"></div>
                <div align="center">
                <h3>Add ThanQ - Reason</h3>
                </div>
                
           
                <div style="height:30px;"></div>
                <div class="row">
            <div class="col-md-8 col-md-offset-3">
                <input type="text" id="t_list"  name="t_list"  class="form-control"  placeholder="Enter ThanQ-Reason" />
                 <div style="height:30px;color:#FF0000; font-size:14px;font-weight:bold; " id="erroractivity" ></div>
                </div>
                
                </div>
                <div class="row">
               <div class="col-md-1   col-md-offset-3">
                <input type="submit" name="submit" class="btn btn-primary"  value="Submit"/></div>
                
                <div class="col-md-4 col-md-offset-1">
                <a href="thanqyoulist.php?name=<?=$name?>"><input type="button" value="Back" width="100%" class="btn btn-danger"></a>
              </div>
                
                </div>
                  <div style="color:#006600;padding-top:10px;" align="center"  ><B> <?php echo $report;?></B></div>
                 <div style="height:30px;"></div>
                </div>
                   
                   <div style="height:20px;"></div>
          
          
        	</div>
                </form>
         
        </div>
        

         
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
$school_id=$_SESSION['school_id'];
	$results=$smartcookie->retrive_individual($table,$fields);
$school_admin=mysql_fetch_array($results);
			$group_member_id =$school_admin['group_member_id']; 
			$report="";
			
			
 
    	if(isset($_POST['submit']))
		{
 			$t_list=$_POST['t_list'];
            "select t_list from tbl_thanqyoupointslist where t_list like '%$t_list%' and school_id='$school_id' ";
 			$query=mysql_query("select t_list from tbl_thanqyoupointslist where t_list like '%$t_list%' and school_id='$school_id' ");
			$query1=mysql_fetch_array($query);
			$test=mysql_num_rows($query);
			
			if($test==0)
			{		
			$query1=mysql_query("insert into tbl_thanqyoupointslist(t_list,school_id,group_member_id) values('$t_list','$school_id','$group_member_id')");
			//$query="insert into tbl_thanqyoupointslist(t_list,school_id) values('$t_list','0')";
			$rs = mysql_query( $query ); 
		
//alert for success message and window.location.href added by Pranali for bug SMC-3332
			$report="ThanQ Reason ".$t_list." added successfully";
		
			echo '<script type=\'text/javascript\'>';
			echo 'alert("'.$report.'");';
			echo 'window.location.href="thanqyoulist.php";</script>';
		//changes end
		}	
			else
		{
		 $report1="ThanQ Reason $t_list is already present";
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

<!--<link href="css/style.css" rel="stylesheet"> -->
<script>
function valid()
{

var activity=document.getElementById("t_list").value;

  if(activity=="" )
  {
   document.getElementById('erroractivity').innerHTML='Please enter Activity';
				
				return false;
	}
	

 
	var letters =   /^[a-zA-Z-,]+(\s{0,1}[a-zA-Z-, ])*$/;
   if(!activity.match(letters))  
     {  
	 document.getElementById('erroractivity').innerHTML='Please Enter valid Activity';
      return false;  
     }  
 

	
	
  



}


</script>
</head>

<body style="background-color:#F8F8F8;">
<div align="center">
	<div style="width:100%">
    	
        
        	
    	<div style="height:30px;"></div>
    	
         <div class="container">
        <div class="row">
        <div class="col-md-3"></div>
         <div class="col-md-7">
    
        <form method="post" name="product" >
       
           <div style=" background-color:#FFFFFF; border:1px solid #CCCCCC; padding-left:30px;" align="left">
            	<div style="height:10px;"></div>
                <div align="center">
                <h3>Add ThanQ - Reason</h3>
                </div>
                
           
                <div style="height:30px;"></div>
                <div class="row">
            <div class="col-md-8 col-md-offset-3">
                <input type="text" id="t_list"  name="t_list"  class="form-control"  placeholder="Enter ThanQ-Reason" />
                 <div style="height:30px;color:#FF0000; font-size:14px;font-weight:bold; " id="erroractivity" ></div>
                </div>
                
                </div>
                           
              <div class="row">
               <div class="col-md-1   col-md-offset-3">
                <input type="submit" name="submit" class="btn btn-primary"  value="Submit" onClick="return valid()"/></div>
                
                <div class="col-md-4 col-md-offset-1">
                <a href="thanqyoulist.php"><input type="button" value="Back" width="100%" class="btn btn-danger"></a>
              </div>
                
                </div>
			
				<div style="color:red;padding-top:10px;font-size:14px;" align="center"  ><b>
				  <?php echo $report1;?></b></div>

                 <div style="height:30px;"></div>
                </div>
                   
                   <div style="height:20px;"></div>
          
          
        	</div>
                </form>
         
        </div>
        

         
            </div>
            
          </div>
           
            
           
            
   
        
        
    </div>
</div>

</body>
</html>
<?php
		}
	}
	else{
		 include_once("scadmin_header.php");

	$results=$smartcookie->retrive_individual($table,$fields);

	$school_admin=mysql_fetch_array($results);

			$school_id=$school_admin['school_id'];

			$report="";
	
	if(isset($_GET["id"]))

	{

	$id=$_GET['id'];

	$query=mysql_query("select t_list from tbl_thanqyoupointslist where id='$id'");

	$result=mysql_fetch_array($query);

    $t_list=$result['t_list'];

	

	if(isset($_POST['submit']))

	{

		$t_list=$_POST['t_list'];

		

		

		

		$sql=mysql_query("select * from tbl_thanqyoupointslist where t_list ='$t_list' and school_id='$school_id'");

		$sql1=mysql_fetch_array($sql);

		$result=mysql_num_rows($sql);

		if($result==0)

		{

		

		

		$sql=mysql_query("update tbl_thanqyoupointslist set t_list='$t_list' where id='$id' and school_id='$school_id' ");

		

		

	

			 if(mysql_affected_rows()>0)

		{

		 $report="Data successfully updated ";

		

	

		}

	  

	  

	

		

		}
		else 
		{
			
			//$sql=mysql_query("update tbl_thanqyoupointslist set t_list='$t_list' where id='$id' and school_id='$school_id' and t_list='$t_list' ");
			$report1="Thank you point reason is already present";
		}



	

		

		

	

	}

	

	}

	?>

<html>	



<script>

function valid()

{





var activity=document.getElementById("t_list").value;



  if(activity=="" )

  {



   document.getElementById('erroractivity').innerHTML='Please enter Thanq you Name';

				

				return false;

	}

	

	

 



var letters =/^[a-zA-Z ]+$/;

   if(!activity.match(letters))  

     {  

	

	 document.getElementById('erroractivity').innerHTML='Please enter valid Thanq you Name';

      return false;  

     }  

 









}

</script>



<body>

<div class="container">

<div clss="row" style="padding-top:100px;">



<div class="col-md-3"></div>

<div class="col-md-6">

 <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">

 <div align="center">

 <h3>Edit ThanQ - Reason </h3> </div>

 

 <form method="post" >

 <div class="row" style="padding-top:50px;">



 



 <div class="col-md-6 col-md-offset-3">

 <input type="text" name="t_list"  id="t_list" value="<?php echo $t_list;?>" class="form-control" /></input>

 <div style="color:#FF0000; font-size:14px;font-weight:bold; " id="erroractivity" ></div>

 </div>

 

 

 

 </div>

 

 

  <div class="row" style="padding-top:30px;" align="center">

 

 <input type="submit" name="submit" class="btn btn-primary" style="width:20%;" value="Update"  onClick="return valid();"/>

                &nbsp;&nbsp;&nbsp;

                <a href="thanqyoulist.php"><input type="button" style="width:20%;" value="Back" class="btn btn-danger"></a>







 

<div style="color:008000;"align="center" > <?php echo $report;?></div>
<div style="color:#FF0000;"align="center" > <?php echo $report1;?></div>

 </div>

 </form>

 

<div style="height:30px;"></div>

 

</div>

</div>

</div>

</div>

</body>



</html>
	<?php } ?>	