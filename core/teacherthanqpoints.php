<?php
 include_once('stud_header.php');
 $report="";
 $id=$_SESSION['id'];
		
		$query=mysql_query("select * from tbl_student where id='$id' ");
		$result=mysql_fetch_array($query);
		$student_name='';
		if($value['std_complete_name']!='')
			{
				$arr=explode(" ",$value['std_complete_name']);
				$i=0;
				while(count($arr)>$i)
				{
					$student_name=$student_name.' '.ucfirst(strtolower($arr[$i]));
					$i++;
				}
			
			}
			else
			{
				$student_name=ucfirst(strtolower($value['std_name'])).' '.ucfirst(strtolower($value['std_Father_name'])).' '.ucfirst(strtolower($value['std_lastname']));
			}
		$school_id=$result['school_id'];
		$std_PRN=$result['std_PRN'];
		$balance_bluestud_points=$result['balance_bluestud_points'];
     $used_blue_points=$result['used_blue_points'];
	 $rows=mysql_query("select * from tbl_student_reward where sc_stud_id='$std_PRN'");
        $results=mysql_fetch_array($rows);
	 
 $teacher_id=$_GET['t_id'];

 
 if(isset($_POST['submit']))
 {
$date=Date('d/m/Y');
$sc_thanqupointlist_id=$_POST['reason'];
$row=mysql_query("select * from tbl_thanqyoupointslist where id='$sc_thanqupointlist_id'");
$value=mysql_fetch_array($row);
$reasonofreward=$value['t_list'];
 $blue_points=$_POST['blue_points'];

 if($blue_points<=$balance_bluestud_points)
 {
 $sql=mysql_query("select t_id,balance_blue_points from tbl_teacher where t_id='$teacher_id'");
 $result1=mysql_fetch_array($sql);
 $t_id=$result1['t_id'];

 $final_blue_points=$result1['balance_blue_points']+$blue_points;
 $query=mysql_query("update tbl_teacher set balance_blue_points='$final_blue_points'  where t_id='$teacher_id'");

 $query1=mysql_query("insert into tbl_teacher_point (sc_teacher_id,sc_entities_id,assigner_id,sc_thanqupointlist_id,sc_point,point_date) values('$teacher_id','105','$std_PRN','$sc_thanqupointlist_id','$blue_points','$date')");
 
 $final_bluestud_points=$balance_bluestud_points-$blue_points;
$final_used_blue_points=$used_blue_points+$blue_points;


 $test=mysql_query("update tbl_student set balance_bluestud_points='$final_bluestud_points' , used_blue_points='$final_used_blue_points' where  id='$id'");
 // Message to be sent
							
								
									$row=mysql_query("select gc.gcm_id,t_name,t_middlename,t_lastname,t_complete_name from teacher_gcmid  gc left outer join tbl_teacher t on  gc.teacher_PRN=t.t_id where gc.teacher_PRN='$teacher_id'");
								while($value=mysql_fetch_array($row))
								{
								
									$Gcm_id=$value['gcm_id'];
									$teacher_name="";
									if($value['t_complete_name']=="")
									{
										
									$teacher_name=ucfirst(strtolower($value['t_name']))." ".ucfirst(strtolower($value['t_middlename']))." ".ucfirst(strtolower($value['t_lastname']));
									}
									else
									{
										
										$arr=explode(" ",$value['t_complete_name']);
										$i=0;
										while(count($arr)>$i)
										{
										$teacher_name=$teacher_name.' '.ucfirst(strtolower($arr[$i]));
											$i++;
										}
		
									}
						 $message = "Reward Point | Hello ".$teacher_name.", your student ".trim($student_name)." rewarded you ".$blue_points ." points for ".$reasonofreward;
								include('pushnotification.php');
						      send_push_notification($Gcm_id, $message);
								
								}
								
 
  $report="$blue_points Blue Points assigned successfully";
 
header("location:teacherthanqpoints.php?t_id=".$t_id."&report=".$report);
 
 }
 else
 {
 $report="You have insufficient Blue Points ";
 }
 
 
 
 
 }
 
 
 
 ?>

 <head>
  <script>
  
  function votepick()
  {
  var reason=document.getElementById('reason').value;
  
  if(reason=="")
  {
  document.getElementById('errorreport').innerHTML="Please select one Reason";
	return false;
  }
  
  }

	function valid()
	{
	
	var points=document.getElementById('blue_points').value;
	
	
	if(points=="" || points==null)
	{
	document.getElementById('errorreport').innerHTML="Please enter Points";
	return false;
	
	}
	
	var numbers = /^[0-9]+$/;  
      if(!points.match(numbers))  
      {  
    document.getElementById('errorreport').innerHTML="Please enter valid Points";
      return false;  
      }  

	
	
	
	
	
	
	
	}
	</script>
    <style>
	
.preview
{
border-radius:50% 50% 50% 50%;  

box-shadow: 0 3px 2px rgba(0, 0, 0, 0.3);
-webkit-border-radius: 99em;
  -moz-border-radius: 99em;
  border-radius: 99em;
  border: 5px solid #eee;
  width:100px;9425154627
}
</style>
 </head>
 
 <body style="background-color:#FFFFFF;">


 <div class="container" style="padding-top:30px; width:90%;">
 
 <div class="row"><h4 align="center"> Assign Blue points to Teacher</h4></div>

<div style="padding-top:30px">
 <div class="col-md-18 col-md-offset-1" style="border:1px solid #CCCCCC;">
 <?php 
           
			
			
 $sql=mysql_query("select t_pc,t_name,t_complete_name,t_lastname,balance_blue_points from tbl_teacher where t_id='$teacher_id' and school_id='$school_id'");
 $test=mysql_fetch_array($sql);
 
 ?>
 <div>
        <div> 
        <div class="row" style="padding-top:20px" >  <div class="col-md-2"></div>
                     <div class="col-md-2"><?php if($test['t_pc'] != ''){?>
                <img src="<?php echo $test['t_pc'];?>" class="preview" style=" width:70px;height:70px;" alt="Responsive image" />
                <?php }else {?> <img src="image/avatar_2x.png"  style="border:1px solid #CCCCCC; width:70px;height:70px;" class="preview" alt="Responsive image"/> <?php }?></div>
                     
                 
 				<h5 style="padding-top:27px;"><?php 
				
				if($test['t_complete_name']=="")
				{
				  echo $test['t_name']." ".$test['t_lastname'];
				 }
				 else
				 {
				 echo ucwords(strtolower($test['t_complete_name']));
				 }
				  
				  ?></h5>
		 </div>
         
         
          <?php
		 $sql1=mysql_query("select Semester_id,subjectName,Branches_id,Semester_id,Department_id from tbl_student_subject_master s join tbl_academic_Year Y on Y.Year=s.AcademicYear and Y.Enable='1' ");
		 $result1=mysql_fetch_array($sql1);
		 		
			
				
				
				
		 ?>
         
        
         
            
         
           
          
           <div class="row" style="padding-top:30px">
         <div class="col-md-1"></div>
           <div class="col-md-2"><label>Subject </label></div>
           <div class="col-md-4" style="width: 300px;">
         <?php
		echo $result1['subjectName'];
				
				
		 ?></div>    
         
         
         </div>
         
        
         
          <div class="row" style="padding-top:30px;">
            <div class="col-md-1"></div>
            <div class="col-md-3"><label>Balance Blue Points</label></div>   
               <div class="col-md-1"><?php echo $test['balance_blue_points'];?></div>   
             
       
       </div>
         <form method="post" name="radioform">
         
         <div class="row" style="padding-top:30px;">
         <div class="col-md-1"></div>
       <div class="col-md-2"><label>Reason</label></div>
       
      <div class="col-md-3">
      <select name="reason" id="reason" class="form-control" onChange="votepick()">
       <?php $query=mysql_query("select * from tbl_thanqyoupointslist where school_id='$school_id' ");
	   		
			$count=mysql_num_rows($query);
			while($result=mysql_fetch_array($query))
			{?>
		
	
    <option  value="<?php echo $result['id'];?>"><?php echo $result['t_list'];?></option>
    
    
       
          
			
			<?php }
			
	   
	   ?></select></div></div>
       
       <div class="row" style="padding-top:30px;">
            <div class="col-md-1"></div>
            <div class="col-md-2"><label>Points</label></div>   
               <div class="col-md-5"><input type="text" name="blue_points" id="blue_points" class="form-control"></div>   
             
       
       </div>
       
       
          <div class="row" style="padding-top:30px;" align="center">
          

           <input type="submit" name="submit" value="Assign" class="btn btn-primary" onClick="return valid();">
         <a href="student_assign_Thanqpoints.php" style="text-decoration:none">  <input type="button" name="cancel" value="Back" class="btn btn-danger"></a>
             
       
       </div>
       </form> <div id="errorreport" style="color:#FF0000;padding-top:20px; font-weight:bold" align="center" ><?php echo $report;?></div>
        <?php if(isset($_GET['t_id']) && isset($_GET['report']))
		{
        ?>
       <div id="errorreport" style="color:#FF0000;padding-top:20px; font-weight:bold" align="center" ><?php echo $_GET['report'];?></div>
       <?php }?>
         
       
       
       
         
         </div>
 
 
   	</div>		
 
 </div>
</div>

</div>

 </body>
 