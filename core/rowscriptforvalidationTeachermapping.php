<?php
include("scadmin_header.php");
echo "hi--";
for($i=0;$i<1000;$i++)
{
$sql=mysql_query("select * from tbl_teachr_subject_row where status='N'");

$num=mysql_num_rows($sql);
while($row=mysql_fetch_array($sql))
{
            $id=$row['tch_sub_id']
            $teacher_id=$row['teacher_id'];
			$school_id=$row['school_id'];
			$subject_code=$row['subjcet_code'];
			$subject_title=$row['Semester_id'];
			
			/*$date=explode(",",$id);
			
		    $date[0];
		    $date[1];
		    $sub_code=$date[2];
			$sub_title=$date[3];*/
			 
			  $matchstudent=mysql_query("select std_PRN from tbl_teacher where school_id=".$school_id." AND t_id=".$teacher_id."");
			   $no=mysql_num_rows($matchstudent);
			   $getstdrow=mysql_fetch_array($matchstudent);
			         
		  if($no!=0)
		  {
	            $teacher_id=$getstdrow['t_id'];
				$school_id=$getstdrow['school_id'];
				
							$row=mysql_query("select Subject_Code,subject from `tbl_school_subject` where Subject_Code='$subject_code' and school_id='$school_id'");
							$getsubject=mysql_fetch_array($row);
							$getRows=mysql_num_rows($row);
			
		 if($getRows!=0)
			{
				   $sub_code1=$getsubject['Subject_Code'];
			       $sub_title1=$getsubject['subject'];
				   
			 $isert=mysql_query("INSERT INTO `tbl_teacher_subject_master` (`teacher_id`, `school_id`, `school_staff_id`, `subjcet_code`, `subjectName`, `Division_id`, `Semester_id`, `Branches_id`, `Department_id`, `uploaded_by`) VALUES ('$teacher_id','$school_id', NULL, '$sub_code1', '$sub_title1', '1', '2', '3', '4',  'pratik tambekar')");
                          
						  echo "All Teacher are successfully Inserted...";
						  	
						  
						  $query=mysql_query("update tbl_teachr_subject_row set status='Y' where tch_sub_id='$id'"); 
						
						
						  
				}
					 else
						 {
						   echo "subject code not match";
						 }
					
				}
					
					  else
						 {
						   echo "Student PRN Not Match";
						 }
					  	 
					 
				}//while loop



}//for Loop


?>