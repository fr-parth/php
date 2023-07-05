<style>
#cssmenu ul ul 
{
display: none;
background: #fff;
}
#purches div{ color:#CCCCCC;
}
</style>

<link rel="stylesheet" href="css/custom-accord.css" />


    <div  style=" border:1px solid #CCCCCC; background-color:#fff;" align="center">
        <div style=" background-color:#2F329F; padding:7px 0px 7px 7px;font-weight:bold;color:#fff;">
            My <?php echo xecho($dynamic_subject.'s');?> &nbsp;&nbsp;
        </div>      
	
     <table class="">
        <?php $i=1;?>
		<tr style="background-color:#003399;color:#FFFFFF; color:#FFFFFF;">
			<th style="width:44%; text-align:center" >Sr.no</th>
			<th style="width:44%; text-align:center" ><?php echo xecho($dynamic_subject);?></th>
			<th style="width:44%; text-align:center;"><?php echo xecho($dynamic_subject.' Code');?></th>
			<?php if($school_type=='school'){ ?><th style="width:30%" >Semester</th><?php } ?>
		</tr>
	</table>
	<form method="post">
		<select name="info" class="form-control">
				  <option value="1" <?php if(xss_clean(mysql_real_escape_string(isset($_POST['info'])))){ if(xss_clean(mysql_real_escape_string($_POST['info']=="1")))?> selected <?php } ?>>Current</option>
				  <option value="2" <?php if(xss_clean(mysql_real_escape_string(isset($_POST['info'])))){ if(xss_clean(mysql_real_escape_string($_POST['info']=="2")))?> selected <?php } ?>>All</option>
		</select>
        <input type="submit" name="submit" value="submit">
		 
	</form>


	<?php	
		if(xss_clean(mysql_real_escape_string(isset($_POST['submit']))))
		{
			$i=1;
				$info=xss_clean(mysql_real_escape_string($_POST['info']));
				if($info=="1")
				{
					
				$arr="SELECT  distinct st.school_id,st.teacher_id,st.Branches_id,st.`subjectName`,st.subjcet_code,st.Division_id,st.Semester_id,st.Department_id,st.CourseLevel,st.AcademicYear FROM `tbl_teacher_subject_master` st inner join tbl_academic_Year Y on st.AcademicYear=Y.Year    WHERE st.`teacher_id` ='$t_id' and st.school_id='$school_id' and Y.Enable='1' and Y.school_id='$school_id'";
		
				}
				else
				{
				$arr="SELECT distinct st.school_id,st.teacher_id,st.Branches_id,st.`subjectName`,st.subjcet_code,st.Division_id,st.Semester_id,st.Department_id,st.CourseLevel,st.AcademicYear FROM `tbl_teacher_subject_master` st   WHERE st.`teacher_id` ='$t_id' and st.school_id='$school_id' ";
		
				}		
	
		}
		else
		{
			$arr="SELECT distinct st.school_id,st.teacher_id,st.Branches_id,st.`subjectName`,st.subjcet_code,st.Division_id,st.Semester_id,st.Department_id,st.CourseLevel,st.AcademicYear FROM `tbl_teacher_subject_master` st inner join tbl_academic_Year Y on st.AcademicYear=Y.Year    WHERE st.`teacher_id` ='$t_id' and st.school_id='$school_id' and Y.Enable='1' and Y.school_id='$school_id'";
		}
		?>
		
	<?php
	$arr1=mysql_query($arr);
				  while($row=mysql_fetch_array($arr1))
				  {
					  ?>
					  
                    <div class='row' >
					
						<div class='col-md-1' style="text-align:center"><?php echo xecho($i++ .'. ');?></div>
						<div class='col-md-10'><a href="display_student.php?t_id=<?php echo xecho($row['teacher_id']);?>&school_id=<?php echo xecho($row['school_id']);?>&subjectName=<?php echo xecho($row['subjectName']);?>"><?php echo xecho($row['subjectName']);?></a></div>
						
					
					</div>
					<div class='row' >
						<div class='col-md-4 col-md-offset-1'><?php echo xecho($row['subjcet_code']);?></div>
						<div class='col-md-2'><?php echo xecho($row['CourseLevel']);?></div>
						<div class='col-md-5'><?php echo xecho($row['Semester_id']);?></td></div>
					</div>
					</br>
                  <?php
				  }
				 

			   
		
						?>
       
  <div id="cssmenu" class="accord-sub" >
                         
<ul><li>
 <?php 
   if($_SESSION['usertype']=='Manager'){
		   ?>
           
		   
		   
		<?php   
		   }
		   else{
	?>    
   <?php echo xecho($branch[0]);?>
    <?php
	 }
	 ?>





&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;






 <?php 
   if($_SESSION['usertype']=='Manager'){
		   ?>
           
		   
		   
		<?php   
		   }
		   else{
	?>    
    <?php echo xecho($sem." ".$no); ?>
    <?php
	 }
	 ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        
                  
         <ul style="padding-top:15px;"> 
    

         
     
    </ul>
                 </li></ul> </div>
                        
                       
                        </div>
                        
            
                        
           