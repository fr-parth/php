<?php
 include_once('stud_header.php');
 $report="";
 $id=$_SESSION['id'];
		
		$query=mysql_query("select * from tbl_student where id='$id' ");
		$result=mysql_fetch_array($query);
		$school_id=$result['school_id'];
		$std_PRN=$result['std_PRN'];
		$balance_bluestud_points=$result['balance_bluestud_points'];
     $used_blue_points=$result['used_blue_points'];
	 $rows=mysql_query("select * from tbl_student_reward where sc_stud_id='$id'");
        $results=mysql_fetch_array($rows);
	 
 $teacher_id=$_GET['t_id'];
 
 if(isset($_POST['submit']))
 {
 
 $studentpointlist_id = $_POST['activity1'];

 $points=$_POST['points'];
 if(isset($_POST['activity1']))
 {
 if($_POST['points']!=0)
{
$point_date = date('d/m/Y');
if(substr($studentpointlist_id,0,8)=="subject-")
				{
 $reason_id=substr($studentpointlist_id,8);
				
				
				 $query1=mysql_query("SELECT subjcet_code, subjectName  FROM tbl_student_subject_master sm JOIN tbl_academic_Year a ON sm.AcademicYear = a.Year WHERE sm.student_id = '$std_PRN' AND sm.school_id = '$school_id' AND Enable = '1' AND sm.teacher_ID='$teacher_id'  and sm.subjcet_code='$reason_id' ");
				 $resultset=mysql_fetch_array($query1);
				 
				  $reason=$resultset['subjcet_code'];
				  $activity_type="subject";
				}
				else
				{
				
				 $query1 = mysql_query("select sc_list,sc_id from tbl_studentpointslist where sc_id = $studentpointlist_id and school_id='$school_id'");
				  $resultset=mysql_fetch_array($query1);
				
				  $reason=$resultset['sc_id'];
				    $activity_type="activity";
				}
				
				
				
				$testset=mysql_query("insert into tbl_request (stud_id1,stud_id2,requestdate,points,reason,flag,entitity_id,activity_type,school_id) values('$std_PRN','$teacher_id','$point_date','$points','$reason','N','103','$activity_type','$school_id')");
				$report="Request sent successfully";

 
 
 }
 
 else
 {
 
 $report="Please enter points";
 }
 
 }
 
 else
 {
 
  $report="Please select Activity or subject";
 }

 
 
 }
 
 
 
 ?>

 <head>
  <script>
	function valid()
	{
	
	var points=document.getElementById('points').value;
	
	
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

	var elem=document.forms['radioform'].elements['reason'];
	len=elem.length-1;
	chkvalue='';
	for(i=0; i<=len; i++)
	{
		if(elem[i].checked)chkvalue=elem[i].value;	
	}
	if(chkvalue=='')
	{
		document.getElementById('errorreport').innerHTML="Please select one reason";
		  return false;
	}

return true;
	
	
	
	
	
	
	}
	
	
	
	
	
 function MyAlert(subject)
{
if(subject=="activity")

{

  document.getElementById('catList').innerHTML='<div class="row" style="padding-top:30px;"><div class="col-md-1" ></div> <div class="col-md-3" > <b> Art</b><br><br> <?php $query1 = mysql_query("SELECT sp.sc_list,sc_id FROM tbl_studentpointslist sp JOIN tbl_activity_type a WHERE sp.school_id= '$school_id' AND a.activity_type = 'Art' AND a.id = sc_type");while($row = mysql_fetch_array($query1)){?><input type="radio"  value="<?php echo $row['sc_id'];?>" name="activity1" id="activity1" /> &nbsp;&nbsp;<?php echo $row['sc_list'];?><br/> <?php } ?> </div><div class="col-md-3" > <b> Sports</b><br><br> <?php $query1 = mysql_query("SELECT sp.sc_list,sc_id FROM tbl_studentpointslist sp JOIN tbl_activity_type a WHERE sp.school_id= '$school_id' AND a.activity_type = 'Sports' AND a.id = sc_type");while($row = mysql_fetch_array($query1)){?><input type="radio"  value="<?php echo $row['sc_id'];?>" name="activity1" id="activity1"/> &nbsp;&nbsp;<?php echo $row['sc_list'];?><br/> <?php } ?> </div><div class="col-md-1" ></div> <div class="col-md-4" > <b> General</b><br><br> <?php $query1 = mysql_query("SELECT sp.sc_list,sc_id FROM tbl_studentpointslist sp JOIN tbl_activity_type a WHERE sp.school_id= '$school_id' AND a.activity_type = 'General Activity' AND a.id = sc_type");while($row = mysql_fetch_array($query1)){?><input type="radio"  value="<?php echo $row['sc_id'];?>" name="activity1" id="activity1" /> &nbsp;&nbsp;<?php echo $row['sc_list'];?><br/> <?php } ?> </div></div>';
}                                   
								
if(subject=="subject")
{
document.getElementById('catList').innerHTML='';

  document.getElementById('catList').innerHTML='<div class="row" style="padding-top:30px;"><div class="col-md-4" ></div> <div class="col-md-7" > <b> Subjects</b><br><br> <?php $query1 = mysql_query("SELECT subjcet_code, subjectName,Semester_id,Branches_id,teacher_ID  FROM tbl_student_subject_master sm JOIN tbl_academic_Year a ON sm.AcademicYear = a.Year WHERE sm.student_id = '$std_PRN' AND sm.school_id = '$school_id' AND Enable = '1' AND sm.teacher_ID='$teacher_id' and a.school_id='$school_id'"); while($row = mysql_fetch_array($query1)){$sub_id=$row['subjcet_code']; ?><input type="radio"   value="<?php echo 'subject-'.$sub_id;?>" name="activity1" id="<?php echo 'subject-'.$sub_id;?>" /> &nbsp;&nbsp;<?php echo $row['subjectName'];?><br/><?php } ?> </div></div>';

}

}
	</script>
    
    <script>
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
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
  width:100px;
}
</style>
 </head>
 
 <body style="background-color:#FFFFFF;">
 <div class="container" style="padding-top:30px;">
  <div class="col-md-12"  style="padding:20px; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">	
             
             <div class="row">
             <div class="col-md-7">
             <h2>Request for Reward Points</h2>
             </div>
             
           
             </div>
             
             </div>
 </div>
 <div class="container" style="padding-top:30px;">
 <div class="col-md-2">

</div>

 <div class="col-md-10">
 <?php 

 $sql=mysql_query("select t_pc,t_name,t_lastname,t_complete_name,t_current_school_name,balance_blue_points from tbl_teacher where t_id='$teacher_id' and school_id='$school_id'");
 $test=mysql_fetch_array($sql);
 
 ?>
 <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
        <div style="background-color:#F8F8F8 ;"> 
        <div class="row" style="padding-top:20px" >  <div class="col-md-2"></div>
                     <div class="col-md-2"><?php if($test['t_pc'] != ''){?>
                <img src="<?php echo $test['t_pc'];?>" class="preview" style=" width:70px;height:70px;" alt="Responsive image" />
                <?php }else {?> <img src="image/avatar_2x.png"  style="border:1px solid #CCCCCC; width:70px;height:70px;" class="preview" alt="Responsive image"/> <?php }?></div>
                     
                 
 				<h3 style="padding-top:27px;">
                <?php
							if($test['t_complete_name']=="")
							{
							
							 echo $test['t_name']." ".$test['t_lastname'];
                            }
                            
                            else
							{
							echo $test['t_complete_name'];
							}?>
                            
                </h3>
		 </div>
         
         
           
         
         <div class="row" style="padding-top:30px">
         <div class="col-md-1"></div>
           <div class="col-md-3"><label>Subject</label></div>
           <div class="col-md-2" style="width: 300px;">
         
         <?php
	
		 $sql1=mysql_query("SELECT subjcet_code, subjectName,Semester_id,Branches_id,teacher_ID  FROM tbl_student_subject_master sm JOIN tbl_academic_Year a ON sm.AcademicYear = a.Year 
WHERE sm.student_id = '$std_PRN' AND sm.school_id = '$school_id' AND Enable = '1' AND sm.teacher_ID='$teacher_id' and a.school_id='$school_id'");
		 while($result1=mysql_fetch_array($sql1))
		 		{
			
				echo $result1['subjectName'];?><br>
				<?php }
				
		 ?></div>    
         
         
         </div>
         
      
        
          
       
        
        
         <form method="post" name="radioform">
         
         
        <div class="row" style="padding-top:30px">
         <div class="col-md-1"></div>
           <div class="col-md-3"><label> Activity/Subject</label></div>
         <div class="col-md-3"><input type="radio" name="activity" id="activity" value="activity" onclick = "MyAlert(this.value)" > Activity</div>
           <div class="col-md-3"><input type="radio" name="activity" id="subject" value="subject" onclick = "MyAlert(this.value)">Subject</div>
         
         
         </div>
         
         
         
         
         <div  id="catList">
         </div>
         
       
       
       
       <div class="row" style="padding-top:40px;">
            <div class="col-md-1"></div>
            <div class="col-md-2"><label>Points</label></div>   
               <div class="col-md-5"><input type="text" name="points" id="points" class="form-control" onKeyPress="return isNumberKey(event)"></div>   
             
       
       </div>
       
       
          <div class="row" style="padding-top:40px;" align="center">
          

           <input type="submit" name="submit" value="Request" class="btn btn-success" onClick="return valid();">
         <a href="requestgreenpoint_teacher.php" style="text-decoration:none">  <input type="button" name="cancel" value="Back" class="btn btn-danger"></a>
             
       
       </div>
       </form>
       <div id="errorreport" style="color:#FF0000;padding-top:20px; font-weight:bold" align="center" ><?php echo $report;?></div>
       
         
       
       
       
         
         </div>
 
 
   			
                  
               
 </div>
 </div>
</div>

</div>

 </body>
 