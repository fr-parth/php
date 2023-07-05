<?php
            if(isset($_GET['editactivity']))
			{
				include('school_staff_header.php');
        $report="";
			
	       /*$fields=array("id"=>$id);
		   $table="tbl_school_admin";
		   $smartcookie=new smartcookie();*/
		   
       $results=mysql_query("select * from tbl_school_adminstaff where id=".$staff_id."");
       $school_admin=mysql_fetch_array($results);
	   $school_id=$school_admin['school_id'];
			$report="";
	
	
	if(isset($_GET['editactivity']))
	{
	$activity_id=$_GET['editactivity'];

	
	$sql=mysql_query("select sc_list,sc_type from tbl_studentpointslist where sc_id='$activity_id' and school_id='$school_id'");
	$result=mysql_fetch_array($sql);
	$sc_type=$result['sc_type'];
	$activity=$result['sc_list'];
	$test=mysql_query("select activity_type from tbl_activity_type where id='$sc_type'");
	$test1=mysql_fetch_array($test);
	$activity_type=$test1['activity_type'];
	
	?>
    
    <?php
	
	if(isset($_POST['submit']))
	{
		$activity=$_POST['activity'];
		$activity_type=$_POST['activity_type'];
		$sql=mysql_query("select * from tbl_studentpointslist where sc_id='$activity_id' and  school_id='$school_id'");
		$result=mysql_num_rows($sql);
		if($result==1)
		{
		
		$test=mysql_query("select id from tbl_activity_type where activity_type='$activity_type'");
		$test1=mysql_fetch_array($test);
		
		$sc_type=$test1['id'];
		
		$sql=mysql_query("update tbl_studentpointslist set sc_list='$activity', sc_type='$sc_type' where  school_id='$school_id' and  sc_id='$activity_id'");
		
			 if(mysql_affected_rows()>0)
		{
		 $report="Activity Successfully updated ";
		}
	  }
    }
   }
	?>
   
<html>	

<script>
function valid()
{

var activity=document.getElementById("activity").value;
var activity_type=document.getElementById("activity_type").value;
  if(activity=="" )
  {
   document.getElementById('erroractivity').innerHTML='Please enter Activity';
				return false;
	}

var letters = /^[a-zA-Z ]*$/; 
   if(!activity.match(letters))  
     {  
	 document.getElementById('erroractivity').innerHTML='Please enter valid Activity';
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
 <h2>Activity<b style="color:red;">*</h2> </div>
 
 <form method="post" >
 <div class="row" style="padding-top:20px;">
 
<div style="padding-left:40px;" class="col-md-5" >
 <h4>Activity Type </h4>
 </div>
 <div class="col-md-6">
 <select name="activity_type" id="activity_type" class="form-control">
                           
                                <?php 
								if(isset($_POST['activity_type']))
								{
							     $activity_type= $_POST['activity_type'];
						
							    $rowt=mysql_query("SELECT * FROM tbl_activity_type where activity_type!='$activity_type'");
								$vals=mysql_fetch_array($rowt);
								$act_type=$vals['activity_type'];
								?>
						 <option value='<?php echo  $_POST['activity_type']; ?>' SELECTED ><?php echo $act_type;?></option> 
							<?php } else { ?>
                               <option value='<?php echo  $activity_type; ?>' SELECTED ><?php echo $activity_type;?></option>
                            <?php  }  ?>
                               <?php
							  
							  
							      $row1=mysql_query("SELECT * FROM tbl_activity_type where activity_type!='$activity_type'");
							    while($values=mysql_fetch_array($row1))
                               {?>
                             <option value='<?php echo  $values['activity_type']; ?>'><?php echo $values['activity_type'];?></option>
                               
                              <?php }?>
                             
                             </select>
                        <div style="color:#FF0000; font-size:14px;font-weight:bold; " id="erroractivitytype" ></div>
 </div>
 </div>
 <div class="row" style="padding-top:20px; ">
<div style="padding-left:40px;" class="col-md-5" >
 <h4>Activity<b style="color:red";></b></h4>
 </div>
 <div class="col-md-6">
 <input type="text" name="activity"  id="activity" value="<?php echo $activity;?>" class="form-control" />
 <div style="color:#FF0000; font-size:14px;font-weight:bold; " id="erroractivity" ></div>
 </div>
 
 
 
 </div>
 
 
  <div class="row" style="padding-top:20px;" align="center">
 
 <input type="submit" name="submit" class="btn btn-primary" style="width:20%;" value="Update"  onClick="return valid();"/>
                &nbsp;&nbsp;&nbsp;
                <a href="activitylist.php?name=<?=$name?>"><input type="button" style="width:20%;" value="Back" class="btn btn-danger"></a>



 
<div style="color:#FF0000;"align="center" > <?php echo $report;?></div>
 </div>
 </form>
 
<div style="height:30px;"></div>
</div>
</div>
</div>
</div>

</body>
<?php
		
				}
				else
				{
		include_once("scadmin_header.php");
// 	 $fields=array("id"=>$id);
// 		   $table="tbl_school_admin";
// 		   $smartcookie=new smartcookie();
		   
// $results=$smartcookie->retrive_individual($table,$fields);
// $school_admin=mysql_fetch_array($results);
	
			$school_id=$_SESSION['school_id'];
			$report="";
	
	
	if(isset($_GET['activity']))
	{
	$activity_id=$_GET['activity'];

	
	$sql=mysql_query("select sc_list,sc_type from tbl_studentpointslist where sc_id='$activity_id' and school_id='$school_id'");
	$result=mysql_fetch_array($sql);
	$sc_type=$result['sc_type'];
	$activity=$result['sc_list'];
	$test=mysql_query("select activity_type from tbl_activity_type where id='$sc_type'");
	$test1=mysql_fetch_array($test);
	$activity_type=$test1['activity_type'];
	
	?>
    <?php
	
	if(isset($_POST['submit']))
	{
		$activity=$_POST['activity'];
		$activity_type=$_POST['activity_type'];
		
		
		$sql=mysql_query("select * from tbl_studentpointslist where sc_id='$activity_id' and  school_id='$school_id'");
		$result=mysql_num_rows($sql);
		if($result==1)
		{
		
		$test=mysql_query("select id from tbl_activity_type where activity_type='$activity_type' and school_id='$school_id'");
		$test1=mysql_fetch_array($test);
		
		$sc_type=$test1['id'];
		
		$sql=mysql_query("update tbl_studentpointslist set sc_list='$activity', sc_type='$sc_type' where  school_id='$school_id' and  sc_id='$activity_id'");
	//Alert message given by Pranali for SMC-4998
			 if(mysql_affected_rows()>0)
		{
			echo "<script>alert('Activity successfully updated');
			window.location.href='activity.php';
			</script>";
		 //$report="Activity Successfully updated ";
		}
	  }
    }
   }
	?>
<html>	

<script>
function valid()
{

var activity=document.getElementById("activity").value;
var activity_type=document.getElementById("activity_type").value;
  if(activity=="" )
  {
  // document.getElementById('erroractivity').innerHTML='Please enter Activity';
		alert("Please enter Activity!");		
				return false;
	}

var letters = /^[a-zA-Z ]*$/;
  /* if(!activity.match(letters))  
     {  
	 document.getElementById('erroractivity').innerHTML='Please enter valid Activity';
      return false;  
     }
	*/	
if( activity.trim()=="" || activity.trim()==null)
		{
			alert("It is not valid activity!");
			return false;
		}
        
        else if (letters.test(activity)) {
            //alert("Your your Academic Year is : " + reason);
           // return true;
        }
		else{
        alert("It is not valid activity!");
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
 <h2>Activity </h2> </div>
 
 <form method="post" >
 <div class="row" style="padding-top:20px;">
 
<div style="padding-left:40px;" class="col-md-5" >
 <h4>Activity Type<b style="color:red;">*</b></h4>
 </div>
 <div class="col-md-6">
 	
 <select name="activity_type" id="activity_type" class="form-control">
                           
                             
                               <?php
							  
							  //Modified query and kept selected for activity type get by url by Pranali for SMC-4998
							      $row1=mysql_query("SELECT * FROM tbl_activity_type where activity_type!='' and school_id='$school_id' group by activity_type order by activity_type asc");
							    while($values=mysql_fetch_array($row1))
                               {?>
                             <option value="<?php echo  $values['activity_type']; ?>" <?php 

                             	if($activity_type==$values['activity_type'])
                             		echo "selected";
                              ?> >

                             	<?php echo $values['activity_type'];?></option>
                               
                              <?php }?>
                             
                             </select>
                              <div style="color:#FF0000; font-size:14px;font-weight:bold; " id="erroractivitytype" ></div>
 </div>
 
 
 </div>
 
 
 <div class="row" style="padding-top:20px; ">
 
<div style="padding-left:40px;" class="col-md-5" >
 <h4>Activity</h4>
 </div>
 <div class="col-md-6">
 <input type="text" name="activity"  id="activity" value="<?php echo $activity;?>" class="form-control" /></input>
 <div style="color:#FF0000; font-size:14px;font-weight:bold; " id="erroractivity" ></div>
 </div>
 
 
 
 </div>
 
 
  <div class="row" style="padding-top:20px;" align="center">
 
 <input type="submit" name="submit" class="btn btn-primary" style="width:20%;" value="Update"  onClick="return valid();"/>
                &nbsp;&nbsp;&nbsp;
                <a href="activity.php"><input type="button" style="width:20%;" value="Back" class="btn btn-danger"></a>



 
<div style="color:green;"align="center" > <?php echo $report;?></div>
 </div>
 </form>
 
<div style="height:30px;"></div>
</div>
</div>
</div>
</div>

</body>
<?php
					
}
	
?>