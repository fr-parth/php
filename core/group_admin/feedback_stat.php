<?php
//hradmin_report.php
//comment
include('groupadminheader.php');
if(isset($_POST['group_name'])){
	$group_member_id =	$_POST['group_name'];
}
else{
	$group_member_id = $_SESSION['group_admin_id'];
}

$date=date("Y-m-d");
$date1=date("Y-m-d 23:59:59");

            if(isset($_POST['year'])){
				$year=$_POST['year'];
			}
			else{
				$year="ALL";
			}
			if(isset($_POST['group_name'])){
            $group_member_id =	explode(',',$_POST['group_name'])[0];
			$group_name=$_POST['group_name'];
			}
			else{
				$group_member_id = $_SESSION['group_admin_id'];
				$group_name=$_SESSION['group_admin_id'];
			}
			/* $sqlFeedStudent = "	SELECT cnt, sc.school_name,sc.school_id
										FROM tbl_school_admin sc
										inner join (SELECT count(distinct sf.stu_feed_student_ID,sf.stu_feed_academic_year) as cnt, st.school_id as scid, st.group_member_id as grpid FROM tbl_student_feedback sf join tbl_student st on sf.stu_feed_student_ID=st.std_PRN and sf.stu_feed_school_id=st.school_id

										 where st.group_member_id='$group_member_id') temptbl on sc.school_id=scid
										where cnt!='0' and
										sc.group_member_id=grpid
										group by sc.school_id "; */

			if(($year == 'ALL' && $group_member_id =='ALL') or ($year=='ALL' && $group_member_id=='') or ($year=='' && $group_member_id=='ALL'))
			{
				$sqlFeedStudent = "SELECT distinct(sa.school_id),sa.school_name  FROM tbl_school_admin sa join tbl_group_school gs on sa.group_member_id=gs.group_member_id
				and sa.school_id=gs.school_id where sa.school_id  in 
				(Select distinct sf.stu_feed_school_id from tbl_student_feedback sf join tbl_student st on st.std_PRN = sf.stu_feed_student_ID  )";

				$sqlStudent="SELECT distinct(sa.school_id),sa.school_name FROM tbl_school_admin sa join tbl_group_school gs on sa.group_member_id=gs.group_member_id
				and sa.school_id=gs.school_id";
			}
			else{
				
			if(($year!='' and $year!='ALL') and ($group_member_id!='' and $group_member_id!='ALL')){
				$sqlFeedStudent = "SELECT distinct(sa.school_id),sa.school_name  FROM tbl_school_admin sa join tbl_group_school gs on sa.group_member_id=gs.group_member_id
				and sa.school_id=gs.school_id where sa.group_member_id='$group_member_id' and sa.school_id  in 
				(Select distinct sf.stu_feed_school_id from tbl_student_feedback sf join tbl_student st on st.std_PRN = sf.stu_feed_student_ID  where sf.stu_feed_academic_year='$year' )";

                $sqlStudent="SELECT distinct(sa.school_id),sa.school_name  FROM tbl_school_admin sa join tbl_group_school gs on sa.group_member_id=gs.group_member_id
                and sa.school_id=gs.school_id where sa.group_member_id='$group_member_id'";
			}
			elseif (($year!='' and $year!='ALL') and ($group_member_id=='' or $group_member_id=='ALL')){
				$sqlFeedStudent = "SELECT distinct(sa.school_id),sa.school_name  FROM tbl_school_admin sa join tbl_group_school gs on sa.group_member_id=gs.group_member_id
				and sa.school_id=gs.school_id where sa.school_id  in 
				(Select distinct sf.stu_feed_school_id from tbl_student_feedback sf join tbl_student st on st.std_PRN = sf.stu_feed_student_ID  where sf.stu_feed_academic_year='$year' )";

                $sqlStudent="SELECT distinct(sa.school_id),sa.school_name FROM tbl_school_admin sa join tbl_group_school gs on sa.group_member_id=gs.group_member_id
                and sa.school_id=gs.school_id";
		    }
			else{
				$sqlFeedStudent = "SELECT distinct(sa.school_id),sa.school_name FROM tbl_school_admin sa join tbl_group_school gs on sa.group_member_id=gs.group_member_id
				and sa.school_id=gs.school_id where sa.group_member_id='$group_member_id' and sa.school_id  in 
				(Select distinct sf.stu_feed_school_id from tbl_student_feedback sf join tbl_student st on st.std_PRN = sf.stu_feed_student_ID )";

                $sqlStudent="SELECT distinct(sa.school_id),sa.school_name  FROM tbl_school_admin sa join tbl_group_school gs on sa.group_member_id=gs.group_member_id
                and sa.school_id=gs.school_id where sa.group_member_id='$group_member_id'";
			}
			}
		$resultFeedStudent = mysql_query($sqlFeedStudent);
		$countFeedStudent = mysql_num_rows($resultFeedStudent);
		$resultStudent=mysql_query($sqlStudent);
		$CountTotalStudent=mysql_num_rows($resultStudent);
		$remainingStudent=$CountTotalStudent-$countFeedStudent;
		

 
		$percentageStudent =  round((($countFeedStudent*100)/$CountTotalStudent),2);

		//}


		//Teaching Process
		if(($year == 'ALL' && $group_member_id =='ALL') or ($year=='ALL' && $group_member_id=='') or ($year=='' && $group_member_id=='ALL'))
			{
			$sqlTeachingProcess = "SELECT distinct(sa.school_id),sa.school_name  FROM tbl_school_admin sa join tbl_group_school gs on sa.group_member_id=gs.group_member_id
			and sa.school_id=gs.school_id where sa.school_id  in (SELECT distinct feed360_school_id
			FROM tbl_360feedback_template ft join tbl_teacher t on t.t_id=ft.feed360_teacher_id )";

			$sqlTeacher = "SELECT distinct(sa.school_id),sa.school_name  FROM tbl_school_admin sa join tbl_group_school gs on sa.group_member_id=gs.group_member_id
			and sa.school_id=gs.school_id where sa.school_id not in (SELECT distinct feed360_school_id
			FROM tbl_360feedback_template ft join tbl_teacher t on t.t_id=ft.feed360_teacher_id )";
		
		}else {
			if(($year!='' and $year!='ALL') and ($group_member_id!='' and $group_member_id!='ALL')){
				$sqlTeachingProcess = "SELECT distinct(sa.school_id),sa.school_name  FROM tbl_school_admin sa join tbl_group_school gs on sa.group_member_id=gs.group_member_id
			and sa.school_id=gs.school_id where sa.group_member_id='$group_member_id' and sa.school_id  in (SELECT distinct feed360_school_id
			FROM tbl_360feedback_template ft join tbl_teacher t on t.t_id=ft.feed360_teacher_id where feed360_academic_year_ID='$year')";

			$sqlTeacher = "SELECT distinct(sa.school_id),sa.school_name  FROM tbl_school_admin sa join tbl_group_school gs on sa.group_member_id=gs.group_member_id
			and sa.school_id=gs.school_id where sa.group_member_id='$group_member_id' and sa.school_id not in (SELECT distinct feed360_school_id
			FROM tbl_360feedback_template ft join tbl_teacher t on t.t_id=ft.feed360_teacher_id where  feed360_academic_year_ID='$year')";
			}
			elseif (($year!='' and $year!='ALL') and ($group_member_id=='' or $group_member_id=='ALL')){
				$sqlTeachingProcess = "SELECT distinct(sa.school_id),sa.school_name  FROM tbl_school_admin sa join tbl_group_school gs on sa.group_member_id=gs.group_member_id
			and sa.school_id=gs.school_id where  sa.school_id  in (SELECT distinct feed360_school_id
			FROM tbl_360feedback_template ft join tbl_teacher t on t.t_id=ft.feed360_teacher_id where feed360_academic_year_ID='$year')";

			$sqlTeacher = "SELECT distinct(sa.school_id),sa.school_name  FROM tbl_school_admin sa join tbl_group_school gs on sa.group_member_id=gs.group_member_id
			and sa.school_id=gs.school_id where  sa.school_id not in (SELECT distinct feed360_school_id
			FROM tbl_360feedback_template ft join tbl_teacher t on t.t_id=ft.feed360_teacher_id where  feed360_academic_year_ID='$year')";
		    }
			else{
				$sqlTeachingProcess = "SELECT distinct(sa.school_id),sa.school_name  FROM tbl_school_admin sa join tbl_group_school gs on sa.group_member_id=gs.group_member_id
			and sa.school_id=gs.school_id where sa.group_member_id='$group_member_id' and sa.school_id  in (SELECT distinct feed360_school_id
			FROM tbl_360feedback_template ft join tbl_teacher t on t.t_id=ft.feed360_teacher_id )";

			$sqlTeacher = "SELECT distinct(sa.school_id),sa.school_name  FROM tbl_school_admin sa join tbl_group_school gs on sa.group_member_id=gs.group_member_id
			and sa.school_id=gs.school_id where sa.group_member_id='$group_member_id' and sa.school_id not in (SELECT distinct feed360_school_id
			FROM tbl_360feedback_template ft join tbl_teacher t on t.t_id=ft.feed360_teacher_id)";
			} 
		 }


		$resultTeachingProcess = mysql_query($sqlTeachingProcess);
		$countTeachingProcess = mysql_num_rows($resultTeachingProcess);
		$resultTeacher=mysql_query($sqlTeacher);
		$remainingTprocess=mysql_num_rows($resultTeacher);
		$CountTotalTeacher=$remainingTprocess + $countTeachingProcess;

		$percentageTProcess =  round((($countTeachingProcess*100)/$CountTotalTeacher),2);


		//$ac_yr=mysql_query("SELECT Academic_Year FROM tbl_academic_Year where Year='$year'");
		//	$yt=mysql_fetch_array($ac_yr);
		//	$yr=$yt['Academic_Year'];

		//ACR Activities
		if(($year == 'ALL' && $group_member_id =='ALL') or ($year=='ALL' && $group_member_id=='') or ($year=='' && $group_member_id=='ALL'))
			{
			$sqlAcr = "SELECT distinct sa.school_id,sa.school_name FROM tbl_school_admin sa 
			join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id where sa.school_id  in
		    (select sf.schoolID
		    from tbl_360_activities_data sf join tbl_teacher t on t.t_id= sf.tID where sf.activity_level_id='4' and  (sf.Emp_type_id ='137') )";	

			$sqlTeacherAcr = "SELECT distinct sa.school_id,sa.school_name 	FROM tbl_school_admin sa 
			join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id where sa.school_id not in
			(select sf.schoolID
			from tbl_360_activities_data sf join tbl_teacher t on t.t_id= sf.tID where  
			sf.activity_level_id='4' and  (sf.Emp_type_id ='137'))";	
		}
		else{
		
			if(($year!='' and $year!='ALL') and ($group_member_id!='' and $group_member_id!='ALL')){
				$sqlAcr = "SELECT distinct sa.school_id,sa.school_name FROM tbl_school_admin sa 
			join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id where sa.group_member_id='$group_member_id' and sa.school_id  in
		    (select sf.schoolID
		    from tbl_360_activities_data sf join tbl_teacher t on t.t_id= sf.tID where sf.group_member_id='$group_member_id' 
			and sf.Academic_Year='$year' and sf.activity_level_id='4' and  (sf.Emp_type_id ='137') )";	

			$sqlTeacherAcr = "SELECT distinct sa.school_id,sa.school_name 	FROM tbl_school_admin sa 
			join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id where sa.group_member_id='$group_member_id' and sa.school_id not in
			(select sf.schoolID
			from tbl_360_activities_data sf join tbl_teacher t on t.t_id= sf.tID where sf.group_member_id='$group_member_id' and sf.Academic_Year='$year' 
			and sf.activity_level_id='4' and  (sf.Emp_type_id ='137'))";	
			}
			
			elseif (($year!='' and $year!='ALL') and ($group_member_id=='' or $group_member_id=='ALL')){
				$sqlAcr = "SELECT distinct sa.school_id,sa.school_name FROM tbl_school_admin sa 
				join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id where sa.school_id  in
				(select sf.schoolID
				from tbl_360_activities_data sf join tbl_teacher t on t.t_id= sf.tID where sf.Academic_Year='$year' and sf.activity_level_id='4' and  (sf.Emp_type_id ='137') )";	
	
				$sqlTeacherAcr = "SELECT distinct sa.school_id,sa.school_name 	FROM tbl_school_admin sa 
				join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id where sa.school_id not in
				(select sf.schoolID
				from tbl_360_activities_data sf join tbl_teacher t on t.t_id= sf.tID where sf.Academic_Year='$year' 
				and sf.activity_level_id='4' and  (sf.Emp_type_id ='137'))";	
			}
			else{
				$sqlAcr = "SELECT distinct sa.school_id,sa.school_name FROM tbl_school_admin sa 
				join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id where sa.group_member_id='$group_member_id' and sa.school_id  in
				(select sf.schoolID
				from tbl_360_activities_data sf join tbl_teacher t on t.t_id= sf.tID where sf.group_member_id='$group_member_id' 
				and sf.activity_level_id='4' and  (sf.Emp_type_id ='137') )";	 
	
				$sqlTeacherAcr = "SELECT distinct sa.school_id,sa.school_name 	FROM tbl_school_admin sa 
				join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id where sa.group_member_id='$group_member_id' and sa.school_id not in
				(select sf.schoolID
				from tbl_360_activities_data sf join tbl_teacher t on t.t_id= sf.tID where sf.group_member_id='$group_member_id' 
				and sf.activity_level_id='4' and  (sf.Emp_type_id ='137'))";	
			}

	}
		$resultAcr= mysql_query($sqlAcr);
		$countAcr = mysql_num_rows($resultAcr);
		$resultTeacherAcr=mysql_query($sqlTeacherAcr);
		$remainingAcr=mysql_num_rows($resultTeacherAcr);
		$CountTotalAcr=$remainingAcr+$countAcr;
		$percentageAcr =  round((($countAcr*100)/$CountTotalAcr),2);



		//Institutional activities
		if(($year == 'ALL' && $group_member_id =='ALL') or ($year=='ALL' && $group_member_id=='') or ($year=='' && $group_member_id=='ALL'))
			{
			$sqlInst = "SELECT distinct sa.school_id,sa.school_name
			FROM tbl_school_admin sa 
			  join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id where sa.school_id  in 
			(select sf.schoolID
			from tbl_360_activities_data sf join tbl_teacher t on t.t_id= sf.tID where sf.activity_level_id='2' and  (sf.Emp_type_id ='137') )";	

			$totalTeacherInstitute = " SELECT distinct sa.school_id,sa.school_name
			FROM tbl_school_admin sa 
  			join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id where sa.school_id not in
			(select sf.schoolID
			from tbl_360_activities_data sf join tbl_teacher t on t.t_id= sf.tID where sf.activity_level_id='2' and  (sf.Emp_type_id ='137') )";	

		} else {
			if(($year!='' and $year!='ALL') and ($group_member_id!='' and $group_member_id!='ALL')){
				$sqlInst = "SELECT distinct sa.school_id,sa.school_name
				FROM tbl_school_admin sa 
				  join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id where sa.group_member_id='$group_member_id' and sa.school_id  in 
				(select sf.schoolID
				from tbl_360_activities_data sf join tbl_teacher t on t.t_id= sf.tID where sf.group_member_id='$group_member_id' and sf.Academic_Year='$year' and sf.activity_level_id='2' and  (sf.Emp_type_id ='137') )";	
	
				$totalTeacherInstitute = " SELECT distinct sa.school_id,sa.school_name
				FROM tbl_school_admin sa 
				  join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id where sa.group_member_id='$group_member_id' and sa.school_id not in
		 		(select sf.schoolID
				from tbl_360_activities_data sf join tbl_teacher t on t.t_id= sf.tID where sf.group_member_id='$group_member_id' and sf.Academic_Year='$year' and sf.activity_level_id='2' and  (sf.Emp_type_id ='137') )";	
			}
			elseif (($year!='' and $year!='ALL') and ($group_member_id=='' or $group_member_id=='ALL')){
				$sqlInst = "SELECT distinct sa.school_id,sa.school_name
				FROM tbl_school_admin sa 
				  join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id where sa.school_id  in 
				(select sf.schoolID
				from tbl_360_activities_data sf join tbl_teacher t on t.t_id= sf.tID where sf.Academic_Year='$year' and sf.activity_level_id='2' and  (sf.Emp_type_id ='137') )";	
	
				$totalTeacherInstitute = " SELECT distinct sa.school_id,sa.school_name
				FROM tbl_school_admin sa 
				  join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id where sa.school_id not in
				(select sf.schoolID
				from tbl_360_activities_data sf join tbl_teacher t on t.t_id= sf.tID where  sf.Academic_Year='$year' and sf.activity_level_id='2' and  (sf.Emp_type_id ='137') )";	
			}
			else{
				$sqlInst = "SELECT distinct sa.school_id,sa.school_name
				FROM tbl_school_admin sa 
				  join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id where sa.group_member_id='$group_member_id' and sa.school_id  in 
				(select sf.schoolID
				from tbl_360_activities_data sf join tbl_teacher t on t.t_id= sf.tID  where sf.group_member_id='$group_member_id' and sf.activity_level_id='2' and  (sf.Emp_type_id ='137') )";	
	
				$totalTeacherInstitute = " SELECT distinct sa.school_id,sa.school_name
				FROM tbl_school_admin sa 
				  join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id where sa.group_member_id='$group_member_id' and sa.school_id not in
				(select sf.schoolID
				from tbl_360_activities_data sf join tbl_teacher t on t.t_id= sf.tID where sf.group_member_id='$group_member_id' and sf.activity_level_id='2' and  (sf.Emp_type_id ='137') )";	
			}
		}

		$resultInstitute= mysql_query($sqlInst);
		$countInstitute = mysql_num_rows($resultInstitute);
		$resultTeacherInstitute=mysql_query($totalTeacherInstitute);
		$remainingInstitute=mysql_num_rows($resultTeacherInstitute);
		$CountTotalInstitute=$remainingInstitute+$countInstitute;

		$percentageInstitute =  round((($countInstitute*100)/$CountTotalInstitute),2);




		//Departmental Activities
		if(($year == 'ALL' && $group_member_id =='ALL') or ($year=='ALL' && $group_member_id=='') or ($year=='' && $group_member_id=='ALL'))
			{
			$sqlDept = "SELECT distinct sa.school_id,sa.school_name FROM tbl_school_admin sa 
            join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id 
            where sa.school_id  in 
            (select sf.schoolID from tbl_360_activities_data sf join tbl_teacher t on t.t_id= sf.tID where  sf.activity_level_id='1' and 
            sf.Emp_type_id in (135,137) )";

			$resultTeacherDept="SELECT distinct sa.school_id,sa.school_name FROM tbl_school_admin sa 
  			join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id 
  			where  sa.school_id  not in 
			(select sf.schoolID from tbl_360_activities_data sf join tbl_teacher t on t.t_id= sf.tID  where  sf.activity_level_id='1' and 
 			sf.Emp_type_id in (135,137)  )";
		} else {

			if(($year!='' and $year!='ALL') and ($group_member_id!='' and $group_member_id!='ALL')){
				$sqlDept = "SELECT distinct sa.school_id,sa.school_name FROM tbl_school_admin sa 
				join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id 
				where sa.group_member_id='$group_member_id' and sa.school_id  in 
				(select sf.schoolID from tbl_360_activities_data sf join tbl_teacher t on t.t_id= sf.tID where  sf.activity_level_id='1' and 
				(sf.Emp_type_id in (135,137) ) and  sf.group_member_id='$group_member_id' and sf.Academic_Year= '$year')";
	
				$resultTeacherDept="SELECT distinct sa.school_id,sa.school_name FROM tbl_school_admin sa 
				  join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id 
				  where sa.group_member_id='$group_member_id' and sa.school_id  not in 
				(select sf.schoolID from tbl_360_activities_data sf join tbl_teacher t on t.t_id= sf.tID  where  sf.activity_level_id='1' and 
				 (sf.Emp_type_id in (135,137) ) and  sf.group_member_id='$group_member_id' and sf.Academic_Year= '$year' )";
			}
			
			elseif (($year!='' and $year!='ALL') and ($group_member_id=='' or $group_member_id=='ALL')){
				$sqlDept = "SELECT distinct sa.school_id,sa.school_name FROM tbl_school_admin sa 
				join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id 
				where sa.school_id  in 
				(select sf.schoolID from tbl_360_activities_data sf join tbl_teacher t on t.t_id= sf.tID where  sf.activity_level_id='1' and 
				(sf.Emp_type_id in (135,137) ) and  sf.Academic_Year= '$year')";
	
				$resultTeacherDept="SELECT distinct sa.school_id,sa.school_name FROM tbl_school_admin sa 
				  join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id 
				  where sa.school_id  not in 
				(select sf.schoolID from tbl_360_activities_data sf join tbl_teacher t on t.t_id= sf.tID  where  sf.activity_level_id='1' and 
				 (sf.Emp_type_id in (135,137) ) and  sf.Academic_Year= '$year' )";
			}
			else{

				$sqlDept = "SELECT distinct sa.school_id,sa.school_name FROM tbl_school_admin sa 
				join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id 
				where sa.group_member_id='$group_member_id' and sa.school_id  in 
				(select sf.schoolID from tbl_360_activities_data sf join tbl_teacher t on t.t_id= sf.tID where  sf.activity_level_id='1' and 
				(sf.Emp_type_id in (135,137) ) and  sf.group_member_id='$group_member_id' )";
	
				$resultTeacherDept="SELECT distinct sa.school_id,sa.school_name FROM tbl_school_admin sa 
				  join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id 
				  where sa.group_member_id='$group_member_id' and sa.school_id  not in 
				(select sf.schoolID from tbl_360_activities_data sf join tbl_teacher t on t.t_id= sf.tID  where  sf.activity_level_id='1' and 
				 (sf.Emp_type_id in (135,137) ) and  sf.group_member_id='$group_member_id')";
			}
		 

		}
		
		$resultDept= mysql_query($sqlDept);
		$countDept = mysql_num_rows($resultDept);
		$totaltTeacherDept=mysql_query($resultTeacherDept);
		$remainingDept=mysql_num_rows($totaltTeacherDept);
		$CountTotalDept=$remainingDept+$countDept;
		
		$percentageDept =  round((($countDept*100)/$CountTotalDept),2);




		//Society Activities
		if(($year == 'ALL' && $group_member_id =='ALL') or ($year=='ALL' && $group_member_id=='') or ($year=='' && $group_member_id=='ALL'))
			{
			$sqlSociety = "SELECT distinct sa.school_id,sa.school_name
			FROM tbl_school_admin sa 
			  join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id where sa.school_id  in 
			(select sf.schoolID from tbl_360_activities_data sf join tbl_teacher t on t.t_id= sf.tID where  sf.activity_level_id='3' and sf.Emp_type_id in (133,134,135,137))";

			$resultTeacherSociety = "SELECT distinct sa.school_id,sa.school_name
			FROM tbl_school_admin sa 
  			join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id where sa.school_id not in 
			(select sf.schoolID from tbl_360_activities_data sf join tbl_teacher t on t.t_id= sf.tID where  sf.activity_level_id='3' and sf.Emp_type_id in (133,134,135,137))";

		} else{
			if(($year!='' and $year!='ALL') and ($group_member_id!='' and $group_member_id!='ALL')){
				$sqlSociety = "SELECT distinct sa.school_id,sa.school_name
				FROM tbl_school_admin sa 
				  join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id where sa.group_member_id='$group_member_id' and sa.school_id  in 
				(select sf.schoolID from tbl_360_activities_data sf join tbl_teacher t on t.t_id= sf.tID where  sf.activity_level_id='3' and  (sf.Emp_type_id in (133,134,135,137) ) and  sf.group_member_id='$group_member_id' and sf.Academic_Year='$year' )";
	
				$resultTeacherSociety = "SELECT distinct sa.school_id,sa.school_name
				FROM tbl_school_admin sa 
				  join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id where sa.group_member_id='$group_member_id' and sa.school_id not in 
				(select sf.schoolID from tbl_360_activities_data sf join tbl_teacher t on t.t_id= sf.tID where  sf.activity_level_id='3' and  (sf.Emp_type_id in (133,134,135,137) ) and  sf.group_member_id='$group_member_id' and sf.Academic_Year='$year' )";
			}
			elseif (($year!='' and $year!='ALL') and ($group_member_id=='' or $group_member_id=='ALL')){
				$sqlSociety = "SELECT distinct sa.school_id,sa.school_name
				FROM tbl_school_admin sa 
				  join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id where sa.school_id  in 
				(select sf.schoolID from tbl_360_activities_data sf join tbl_teacher t on t.t_id= sf.tID where  sf.activity_level_id='3' and  (sf.Emp_type_id in (133,134,135,137) )  and sf.Academic_Year='$year' )";
	
				$resultTeacherSociety = "SELECT distinct sa.school_id,sa.school_name
				FROM tbl_school_admin sa 
				  join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id where sa.school_id not in 
				(select sf.schoolID from tbl_360_activities_data sf join tbl_teacher t on t.t_id= sf.tID where  sf.activity_level_id='3' and  (sf.Emp_type_id in (133,134,135,137) )  and sf.Academic_Year='$year' )";
			}
			else{
				$sqlSociety = "SELECT distinct sa.school_id,sa.school_name
				FROM tbl_school_admin sa 
				  join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id where sa.group_member_id='$group_member_id' and sa.school_id  in 
				(select sf.schoolID from tbl_360_activities_data sf join tbl_teacher t on t.t_id= sf.tID where  sf.activity_level_id='3' and  (sf.Emp_type_id in (133,134,135,137) ) and  sf.group_member_id='$group_member_id')";
	
				$resultTeacherSociety = "SELECT distinct sa.school_id,sa.school_name
				FROM tbl_school_admin sa 
				  join tbl_group_school gs on sa.group_member_id=gs.group_member_id and sa.school_id=gs.school_id where sa.group_member_id='$group_member_id' and sa.school_id not in 
	 				(select sf.schoolID from tbl_360_activities_data sf join tbl_teacher t on t.t_id= sf.tID where  sf.activity_level_id='3' and  (sf.Emp_type_id in (133,134,135,137) ) and  sf.group_member_id='$group_member_id')";
			}
		}

		$resultSociety= mysql_query($sqlSociety);
		$countSociety = mysql_num_rows($resultSociety);
		$totaltTeacherSociety=mysql_query($resultTeacherSociety);
		$remianingSociety=mysql_num_rows($totaltTeacherSociety);
		$CountTotalSociety=$remianingSociety+$countSociety;
		//$percentageSociety=($countSociety/$CountTotalSociety)*100;
		$percentageSociety =  round((($countSociety*100)/$CountTotalSociety),2);




 



?>
<html>
<head>


<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>

  <script src="https://cdn.datatables.net/1.10.9/js/dataTables.bootstrap.min.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>


 <script>
 $(document).ready(function()
 {
    $('#example').DataTable({
		searching: false, paging: false, info: false
	});
} );
</script>
<!-- JQuery script and JavaScript valid() function added  by Pranali for task SMC-2235 on 05-07-2018  -->
<script>
$(document).ready(function(){

		$("#fromDiv").hide();
		$("#toDiv").hide();
    $('#info').on('change', function() {
      if ( this.value == "1")
      {
        $("#fromDiv").show();
		$("#toDiv").show();
      }
      else
      {
        $("#fromDiv").hide();
		$("#toDiv").hide();
      }
    });
});

</script>

</head>


<body>

		<div class="container">

  <div class="panel panel-default">

    <div class="panel-heading" align='center'><h3> 360 Feedback For All Schools/Colleges</h3></div>

	<br>
	 <div class="row" align="center" style="">



         <form method="post" id="empActivity">


						    <div class="row" style="">
                            	<div class="col-md-4"></div>

                           <div class="row" style="padding-top:1px;">
                    			<div class="col-md-4"></div>
                    			<div class="col-md-2" style="color:#808080; font-size:18px;"><span>Academic Year</span></div>
                   	 			<?php $date = date('Y'); ?>
                    			<div class="col-md-2">
                        			<select name="year" id="year" class="form-control" >
									<?php if ((isset($_POST['submit'])) or (isset($_POST['year'])) or (isset($_POST['group_name']))){ ?>
                                           <option value="<?php echo $_POST['year']; ?>" ><?php echo $_POST['year']; ?></option>    
									<?php } else{?>
										<option value="ALL" >ALL</option>
										<?php } ?>
										<option value="ALL" >ALL</option>
										<?php

										$query=mysql_query("SELECT Academic_Year FROM tbl_academic_Year where group_member_id='$group_member_id' and Year != '' group by Year order by Year ");
										while($result=mysql_fetch_array($query))
										{?>


										<option value="<?php echo $result['Academic_Year'];?>"><?php echo $result['Academic_Year'];?></option>

										<?php }?>

									</select>
                    			</div>
								<div class="col-md-12" style="margin-top: 20px;margin-left: ;">
                              <div class="" style="margin-top: 40px; margin-left:100px;">
                                 		<span style="float:left;margin-left:330px;">Group Name</span>
              
                                <div class="" >
                                  <select name="group_name" id="group_name"style=" width:25%;margin-right:197px;" class="form-control searchselect"  >
								  <?php if ((isset($_POST['submit'])) or (isset($_POST['year'])) or (isset($_POST['group_name']))){ 
									  $grp=explode(',',$_POST['group_name']);
									  if($grp[1]==""){
									  if(!is_numeric($grp[0])){  ?>
										<option value="ALL" >ALL</option>
									 <?php } else{ 
                                                  $gp = mysql_query("SELECT distinct(group_member_id),group_mnemonic_name FROM tbl_group_school where group_mnemonic_name!='' and group_member_id='$grp[0]'");
												 $rr = mysql_fetch_array($gp)?>
												  <option  value="<?php echo $rr['group_member_id'].','.$rr['group_mnemonic_name'] ?>"><?php echo $rr['group_mnemonic_name'].'-'.$rr['group_member_id'] ?></option>
									<?php }}else { ?>
									  

                                   <option value="<?php echo $grp[1].','.$grp[0]; ?>"><?php echo $grp[1].'-'.$grp[0]; ?> </option>
                                     
									 <?php } ?>
									 <option value="ALL" >ALL</option>
									 <?php
									 $gp = mysql_query("SELECT distinct(group_member_id),group_mnemonic_name FROM tbl_group_school where group_mnemonic_name!=''");
									 while($rr = mysql_fetch_array($gp)){?>
									 <option  value="<?php echo $rr['group_member_id'].','.$rr['group_mnemonic_name'] ?>"><?php echo $rr['group_mnemonic_name'].'-'.$rr['group_member_id'] ?></option>
									   <?php } } 
			                         else {   ?>
									 <option value="ALL" >ALL</option>
                                  <?php
                                  $gp = mysql_query("SELECT distinct(group_member_id),group_mnemonic_name FROM tbl_group_school where group_mnemonic_name!=''");
                                  while($rr = mysql_fetch_array($gp)){?>
                                  <option <?php if($group_member_id==$rr['group_member_id']){ echo 'selected'; } ?> value="<?php echo $rr['group_member_id'].','.$rr['group_mnemonic_name'] ?>"><?php echo $rr['group_mnemonic_name'].'-'.$rr['group_member_id'] ?></option>
                                    <?php } ?>
									<?php } ?>
                                  </select>
                              </div>

                            </div> 
                          </div>
						<div class="col-md-12" style="" style="margin-top: 20px;margin-left: 290px;">
								<input type="submit" name="submit" value="Submit" class="btn btn-success" onClick="return valid();" />
						</div>

                </div>
											<div class='col-md-3 indent-small' id="erroracademic_year" style="color:#FF0000"></div>
                        </div>









	<div class="panel-body">
		 <div id="no-more-tables" style="padding-top:20px;">
						<!-- <div class="col-md-18" style="margin-left:560px;">
                            <input type="submit" name="submit" value="Submit" class="btn btn-success" onClick="return valid();" />
                        </div> -->

						</br></br>
				<table id="example" class="table table-striped" width="90%" cellspacing="5" align="center">
					<thead class="thead-dark">
						<tr>
						<th style="width:150px; text-align: left;">Type Of Feedback </th>
						<th style="width:100px; text-align: left;">360 Feedback Given by Number of College</th>
						<th style="width:100px; text-align: left;">360 Feedback Not Given by Number Of College </th>
						<th style="width:100px; text-align: center;">Total Colleges </th>
						<th style="width:100px; text-align: center;">Percentage  </th>
						</tr>
					</thead>
		<tbody>

		
		<tr>
		<td style="width:100px; text-align: left;">Student Feedback</td>
					<td style="width:100px; text-align: center;"><a href="school_list.php?year=<?php echo $year;?>&group_name=<?php echo $group_name;?>" ><?php echo $countFeedStudent;?></td>
					<td style="width:100px; text-align: center;"><a href="not_given_school.php?year=<?php echo $year;?>&group_name=<?php echo $group_name;?>"> <?php echo $remainingStudent;?></td>

					<td style="width:100px; text-align: center;"><?php echo $CountTotalStudent;?></td>
					<td style="width:100px; text-align: center;"><?php echo $percentageStudent;?> %</td>
		</tr>
		<tr>
		<td style="width:100px; text-align: left;">Teaching Process</td>
					<td style="width:100px; text-align: center;"><a href="tschool_list.php?year=<?php echo $year;?>&group_name=<?php echo $group_name;?>" > <?php echo $countTeachingProcess;?></td>
					<td style="width:100px; text-align: center;"><a href="tnot_given_school_list.php?year=<?php echo $year;?>&group_name=<?php echo $group_name;?>"> <?php echo $remainingTprocess;?></td>
					<td style="width:100px; text-align: center;"><?php echo $CountTotalTeacher;?></td>
					<td style="width:100px; text-align: center;"><?php echo $percentageTProcess;?> %</td>
		</tr>

		<tr>
		<td style="width:100px; text-align: left;">Department Activity</td>
					<td style="width:100px; text-align: center;"><a href="dept_given_school.php?year=<?php echo $year;?>&group_name=<?php echo $group_name;?>"> <?php echo $countDept;?></td>
					<td style="width:100px; text-align: center;"><a href="dept_not_given_school.php?year=<?php echo $year;?>&group_name=<?php echo $group_name;?>"> <?php echo $remainingDept;?></td>
					<td style="width:100px; text-align: center;"><?php echo $CountTotalDept;?></td>
					<td style="width:100px; text-align: center;"><?php echo $percentageDept;?> %</td>
		</tr>


		<tr>
		<td style="width:100px; text-align: left;">Institute Activity</td>
					<td style="width:100px; text-align: center;"><a href="institute_given_school.php?year=<?php echo $year;?>&group_name=<?php echo $group_name;?>" > <?php echo $countInstitute;?></td>
					<td style="width:100px; text-align: center;"> <a href="institute_not_given_school.php?year=<?php echo $year;?>&group_name=<?php echo $group_name;?>"><?php echo $remainingInstitute;?></td>
					<td style="width:100px; text-align: center;"><?php echo $CountTotalInstitute;?></td>
					<td style="width:100px; text-align: center;"><?php echo $percentageInstitute;?> %</td>
		</tr>



		<tr>
		<td style="width:100px; text-align: left;">ACR</td>
					<td style="width:100px; text-align: center;"><a href="acr_given_school.php?year=<?php echo $year;?>&group_name=<?php echo $group_name;?>"> <?php echo $countAcr;?></td>
					<td style="width:100px; text-align: center;"><a href="acr_not_given_school.php?year=<?php echo $year;?>&group_name=<?php echo $group_name;?>"><?php echo $remainingAcr;?></td>
					<td style="width:100px; text-align: center;"><?php echo $CountTotalAcr;?></td>
					<td style="width:100px; text-align: center;"><?php echo $percentageAcr;?> %</td>
		</tr>

		<tr>
		<td style="width:100px; text-align: left;">Contribution to Society</td>
					<td style="width:100px; text-align: center;"><a href="society_given_school.php?year=<?php echo $year;?>&group_name=<?php echo $group_name;?>"> <?php echo $countSociety;?></td>
					<td style="width:100px; text-align: center;"><a href="society_not_given_school.php?year=<?php echo $year;?>&group_name=<?php echo $group_name;?>"> <?php echo $remianingSociety;?></td>
					<td style="width:100px; text-align: center;"><?php echo $CountTotalSociety;?></td>
					<td style="width:100px; text-align: center;"><?php echo $percentageSociety;?> %</td>
		</tr>
		</tbody>

	 </form>
</table>
