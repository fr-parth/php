<?php
//hradmin_report.php
include('scadmin_header.php');
$sc_id= $_SESSION['school_id'];
$date=date("Y-m-d");
$date1=date("Y-m-d 23:59:59");

if ((isset($_POST['submit'])) or (isset($_GET['year'])) or (isset($_GET['department'])))
	{
       if(isset($_POST['submit'])){
		$department=$_POST['department'];
	    $year=$_POST['year'];
		$single_yr=explode('-',$year)[0];
		//$where='';
	   }
		//$where.="( )";

		else
	   {
		$department=$_GET['department']; 
		$year=$_GET['year'];  
	   }

		//Student 360 Feedback
		if(($year == 'ALL' && $department =='ALL') or ($year=='ALL' && $department=='') or ($year=='' && $department=='ALL'))
		{
			$sqlFeedStudent = "SELECT distinct st.std_PRN,st.std_complete_name,st.Academic_Year,
			st.std_branch,st.std_dept,st.std_class,st.std_div
		   FROM tbl_student st
			where st.school_id='$sc_id'and st.std_PRN IN
			(select sf.stu_feed_student_ID
		   from tbl_student_feedback sf where sf.stu_feed_school_id='$sc_id' and sf.stu_feed_student_ID is not null )
		   group by st.std_PRN";

		$resultFeedStudent = mysql_query($sqlFeedStudent);
		$countFeedStudent = mysql_num_rows($resultFeedStudent);

		$sqlStudent = "SELECT distinct st.std_PRN,st.std_complete_name,st.Academic_Year,
		st.std_branch,st.std_dept,st.std_class,st.std_div
	   FROM tbl_student st
		where st.school_id='$sc_id'
	   group by st.std_PRN";

		$resultStudent=mysql_query($sqlStudent);
		$CountTotalStudent=mysql_num_rows($resultStudent);
		$remainingStudent=$CountTotalStudent - $countFeedStudent;

		$percentageStudent =  round((($countFeedStudent*100)/$CountTotalStudent),2);

		}

		else

		{
			if(($year!='' and $year!='ALL') and ($department!='' and $department!='ALL')){

				$sqlFeedStudent = "SELECT distinct st.std_PRN,st.std_complete_name,st.Academic_Year,
				st.std_branch,st.std_dept,st.std_class,st.std_div
			   FROM tbl_student st
				where st.school_id='$sc_id' and st.Academic_Year='$year' and st.std_dept='$department' and st.std_PRN IN
				(
			   select sf.stu_feed_student_ID
			   from tbl_student_feedback sf where sf.stu_feed_school_id='$sc_id' and sf.stu_feed_student_ID is not null )
			   group by st.std_PRN";
				$sqlStudent = " SELECT distinct st.std_PRN,st.std_complete_name,st.Academic_Year,
				st.std_branch,st.std_dept,st.std_class,st.std_div
			   FROM tbl_student st
				where st.school_id='$sc_id' and st.Academic_Year='$year' and st.std_dept='$department' 
			   group by st.std_PRN";

			}
			elseif (($year!='' and $year!='ALL') and ($department=='' or $department=='ALL'))
			{

				$sqlFeedStudent = "SELECT distinct st.std_PRN,st.std_complete_name,st.Academic_Year,
				st.std_branch,st.std_dept,st.std_class,st.std_div
			   FROM tbl_student st
				where st.school_id='$sc_id' and st.Academic_Year='$year' and st.std_PRN  IN
				(
			   select sf.stu_feed_student_ID
			   from tbl_student_feedback sf where sf.stu_feed_school_id='$sc_id' and sf.stu_feed_student_ID is not null )
			 
			   group by st.std_PRN";


				$sqlStudent = " SELECT distinct st.std_PRN,st.std_complete_name,st.Academic_Year,
				st.std_branch,st.std_dept,st.std_class,st.std_div
			   FROM tbl_student st
				where st.school_id='$sc_id' and st.Academic_Year='$year' 
			   group by st.std_PRN";
			}
			else{
				$sqlFeedStudent = "SELECT distinct st.std_PRN,st.std_complete_name,st.Academic_Year,
				st.std_branch,st.std_dept,st.std_class,st.std_div
			   FROM tbl_student st
				where st.school_id='$sc_id' and st.std_dept='$department' and st.std_PRN IN
				(
			   select sf.stu_feed_student_ID
			   from tbl_student_feedback sf where sf.stu_feed_school_id='$sc_id' and sf.stu_feed_student_ID is not null )
			 
			   group by st.std_PRN";

				$sqlStudent = " SELECT distinct st.std_PRN,st.std_complete_name,st.Academic_Year,
				st.std_branch,st.std_dept,st.std_class,st.std_div
			   FROM tbl_student st
				where st.school_id='$sc_id' and st.std_dept='$department' 				
			   group by st.std_PRN";
			}


		$resultFeedStudent = mysql_query($sqlFeedStudent);
		$countFeedStudent = mysql_num_rows($resultFeedStudent);


		$resultStudent=mysql_query($sqlStudent);
		$CountTotalStudent=mysql_num_rows($resultStudent);
		$remainingStudent=$CountTotalStudent - $countFeedStudent;

		$percentageStudent =  round((($countFeedStudent*100)/$CountTotalStudent),2);
		}






		//Teaching Process
		if(($year == 'ALL' && $department =='ALL') or ($year=='ALL' && $department=='') or ($year=='' && $department=='ALL'))
		{

			$sqlTeachingProcess = "SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
			FROM tbl_teacher  t
			where t.school_id='$sc_id' and t.t_emp_type_pid
			   in (133,134,135,137) and t.t_id IN
			(
			select ft.feed360_teacher_id
			from tbl_360feedback_template ft where ft.feed360_school_id='$sc_id' and ft.feed360_teacher_id is not null )
			group by t.t_id";

			$sqlTeacher = " SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
			FROM tbl_teacher  t
			where t.school_id='$sc_id' and t.t_emp_type_pid in (133,134,135,137) 
			group by t.t_id ";



		$resultTeachingProcess = mysql_query($sqlTeachingProcess);
		$countTeachingProcess = mysql_num_rows($resultTeachingProcess);


		$resultTeacher=mysql_query($sqlTeacher);
		$CountTotalTeacher=mysql_num_rows($resultTeacher);
		$remainingTprocess=$CountTotalTeacher - $countTeachingProcess;

		$percentageTProcess =  round((($countTeachingProcess*100)/$CountTotalTeacher),2);

		}

		else

		{

			if(($year!='' and $year!='ALL') and ($department!='' and $department!='ALL')){
				$sqlTeachingProcess ="SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
				FROM tbl_teacher  t
				 where t.school_id='$sc_id' and t.t_academic_year='$year' and t.t_dept='$department' and t.t_emp_type_pid
						in (133,134,135,137) and t.t_id IN
				 (
				select ft.feed360_teacher_id
				from tbl_360feedback_template ft where ft.feed360_school_id='$sc_id' and ft.feed360_teacher_id is not null )
				group by t.t_id";
				$sqlTeacher = " SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
				FROM tbl_teacher  t
				 where t.school_id='$sc_id' and t.t_academic_year='$year' and t.t_dept='$department' and t.t_emp_type_pid
						in (133,134,135,137) 
				group by t.t_id";
			}
			elseif (($year!='' and $year!='ALL') and ($department=='' or $department='ALL'))
			{
				$sqlTeachingProcess = "SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
				FROM tbl_teacher  t
				where t.school_id='$sc_id' and t.t_academic_year='$year' and t.t_emp_type_pid
				   in (133,134,135,137) and t.t_id IN
				(
				select ft.feed360_teacher_id
				from tbl_360feedback_template ft where ft.feed360_school_id='$sc_id' and ft.feed360_teacher_id is not null)
				group by t.t_id";

				$sqlTeacher = " SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
				FROM tbl_teacher  t
				where t.school_id='$sc_id' and t.t_academic_year='$year' and t.t_emp_type_pid
				   in (133,134,135,137) 
				group by t.t_id";
			}
			else{
				$sqlTeachingProcess = "	SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
				FROM tbl_teacher  t
				where t.school_id='$sc_id' and t.t_dept='$department' and t.t_emp_type_pid
				   in (133,134,135,137) and t.t_id IN
				(
				select ft.feed360_teacher_id
				from tbl_360feedback_template ft where ft.feed360_school_id='$sc_id' and ft.feed360_teacher_id is not null)
				group by t.t_id";

				$sqlTeacher = "	SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
				FROM tbl_teacher  t
				where t.school_id='$sc_id' and t.t_dept='$department' and t.t_emp_type_pid
				   in (133,134,135,137) 
				group by t.t_id ";
			}


		$resultTeachingProcess = mysql_query($sqlTeachingProcess);
		 $countTeachingProcess = mysql_num_rows($resultTeachingProcess);



		$resultTeacher=mysql_query($sqlTeacher);
		 $CountTotalTeacher=mysql_num_rows($resultTeacher);
		 $remainingTprocess=$CountTotalTeacher - $countTeachingProcess;

		$percentageTProcess =  round((($countTeachingProcess*100)/$CountTotalTeacher),2);

		}


		//ACR Activities
		if(($year == 'ALL' && $department =='ALL') or ($year=='ALL' && $department=='') or ($year=='' && $department=='ALL'))
		{
			$sqlAcr = "SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
			FROM tbl_teacher  t
			 where t.school_id='$sc_id'  and t.t_emp_type_pid ='137' and t.t_id IN
			 (
			select ft.tID
			from tbl_360_activities_data ft where ft.activity_level_id='4' and  ft.tID is not NULL and  ft.schoolID='$sc_id' )
			group by t.t_id";

		$resultAcr= mysql_query($sqlAcr);
		$countAcr = mysql_num_rows($resultAcr);

		$sqlTeacherAcr = " SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
		FROM tbl_teacher  t
		 where t.school_id='$sc_id'  and t.t_emp_type_pid ='137' 		
		group by t.t_id ";

		$resultTeacherAcr=mysql_query($sqlTeacherAcr);
		$CountTotalAcr=mysql_num_rows($resultTeacherAcr);
		$remainingAcr=$CountTotalAcr-$countAcr;

		$percentageAcr =  round((($countAcr*100)/$CountTotalAcr),2);

		}

		else

		{


			if(($year!='' and $year!='ALL') and ($department!='' and $department!='ALL')){
				$sqlAcr = "SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
				FROM tbl_teacher  t
				 where t.school_id='$sc_id' and t.t_academic_year='$year' and t.t_dept='$department' and t.t_emp_type_pid ='137' and t.t_id IN
				 (
				select ft.tID
				from tbl_360_activities_data ft where ft.activity_level_id='4' and  ft.tID is not NULL and  ft.schoolID='$sc_id' )
				group by t.t_id";

			  $sqlTeacherAcr = " SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
			  FROM tbl_teacher  t
			   where t.school_id='$sc_id' and t.t_academic_year='$year' and t.t_dept='$department' and t.t_emp_type_pid ='137' 
			  group by t.t_id";
			}
			elseif (($year!='' and $year!='ALL') and ($department=='' or $department='ALL'))
			{
				$sqlAcr = "SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
				FROM tbl_teacher  t
				 where t.school_id='$sc_id' and t.t_academic_year='$year' and t.t_emp_type_pid ='137' and t.t_id IN
				 (
				select ft.tID
				from tbl_360_activities_data ft where ft.activity_level_id='4' and  ft.tID is not NULL and  ft.schoolID='$sc_id' )
				group by t.t_id";

				$sqlTeacherAcr = " SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
				FROM tbl_teacher  t
				 where t.school_id='$sc_id' and t.t_academic_year='$year' and t.t_emp_type_pid ='137' 
				group by t.t_id";
			}
			else{
				$sqlAcr = "SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
				FROM tbl_teacher  t
				 where t.school_id='$sc_id'  and t.t_dept='$department' and t.t_emp_type_pid ='137' and t.t_id IN
				 (
				select ft.tID
				from tbl_360_activities_data ft where ft.activity_level_id='4' and  ft.tID is not NULL and  ft.schoolID='$sc_id' )
				group by t.t_id";

		  	$sqlTeacherAcr = "SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
			  FROM tbl_teacher  t
			   where t.school_id='$sc_id' and t.t_dept='$department' and t.t_emp_type_pid ='137' 
			  group by t.t_id";
			}

		$resultAcr= mysql_query($sqlAcr);
		$countAcr = mysql_num_rows($resultAcr);



		$resultTeacherAcr=mysql_query($sqlTeacherAcr);
		$CountTotalAcr=mysql_num_rows($resultTeacherAcr);
		$remainingAcr=$CountTotalAcr-$countAcr;
		$percentageAcr =  round((($countAcr*100)/$CountTotalAcr),2);


		}




		//Institutional activities
		if(($year == 'ALL' && $department =='ALL') or ($year=='ALL' && $department=='') or ($year=='' && $department=='ALL'))
		{
			$sqlInst = "SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
			FROM tbl_teacher  t
			 where t.school_id='$sc_id' and t.t_emp_type_pid ='137' and t.t_id  IN
			 (
			select ft.tID
			from tbl_360_activities_data ft where ft.activity_level_id='2' and  ft.tID is not NULL and  ft.schoolID='$sc_id' )
		  
			group by t.t_id";

		$resultInstitute= mysql_query($sqlInst);
		$countInstitute = mysql_num_rows($resultInstitute);

		$totalTeacherInstitute = "SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
		FROM tbl_teacher  t
		 where t.school_id='$sc_id' and t.t_emp_type_pid ='137' 
	     group by t.t_id";

		$resultTeacherInstitute=mysql_query($totalTeacherInstitute);
		$CountTotalInstitute=mysql_num_rows($resultTeacherInstitute);
		$remainingInstitute=$CountTotalInstitute-$countInstitute;

		$percentageInstitute =  round((($countInstitute*100)/$CountTotalInstitute),2);

		}

		else

		{

			if(($year!='' and $year!='ALL') and ($department!='' and $department!='ALL')){
				$sqlInst = "SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
				FROM tbl_teacher  t
				 where t.school_id='$sc_id' and t.t_academic_year='$year' and t.t_dept='$department' and t.t_emp_type_pid ='137' and t.t_id IN
				 (
				select ft.tID
				from tbl_360_activities_data ft where ft.activity_level_id='2' and  ft.tID is not NULL and  ft.schoolID='$sc_id' )
				
				group by t.t_id";

			  	$totalTeacherInstitute = " SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
				  FROM tbl_teacher  t
				   where t.school_id='$sc_id' and t.t_academic_year='$year' and t.t_dept='$department' and t.t_emp_type_pid ='137'
				  group by t.t_id";
			}
			elseif (($year!='' and $year!='ALL') and ($department=='' or $department='ALL'))
			{
				$sqlInst = "SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
				FROM tbl_teacher  t
				 where t.school_id='$sc_id' and t.t_academic_year='$year' and t.t_emp_type_pid ='137' and t.t_id IN
				 (
				select ft.tID
				from tbl_360_activities_data ft where ft.activity_level_id='2' and  ft.tID is not NULL and  ft.schoolID='$sc_id' )
				
				group by t.t_id";

					$totalTeacherInstitute = "SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
					FROM tbl_teacher  t
					 where t.school_id='$sc_id' and t.t_academic_year='$year'and t.t_emp_type_pid ='137'
					group by t.t_id";
			}
			else{
				$sqlInst = "SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
				FROM tbl_teacher  t
				 where t.school_id='$sc_id' and t.t_dept='$department' and t.t_emp_type_pid ='137' and t.t_id IN
				 (
				select ft.tID
				from tbl_360_activities_data ft where ft.activity_level_id='2' and  ft.tID is not NULL and  ft.schoolID='$sc_id' )
				
				group by t.t_id";

		  		$totalTeacherInstitute = "SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
				  FROM tbl_teacher  t
				   where t.school_id='$sc_id' and t.t_dept='$department' and t.t_emp_type_pid ='137'
				  group by t.t_id";
			}

		$resultInstitute= mysql_query($sqlInst);
		$countInstitute = mysql_num_rows($resultInstitute);



		$resultTeacherInstitute=mysql_query($totalTeacherInstitute);
		$CountTotalInstitute=mysql_num_rows($resultTeacherInstitute);
		$remainingInstitute=$CountTotalInstitute-$countInstitute;

		$percentageInstitute =  round((($countInstitute*100)/$CountTotalInstitute),2);


		}


		//Departmental Activities
		if(($year == 'ALL' && $department =='ALL') or ($year=='ALL' && $department=='') or ($year=='' && $department=='ALL'))
		{
			$sqlDept = "SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
			FROM tbl_teacher  t
			 where t.school_id='$sc_id' and t.t_emp_type_pid
					in (135,137) and t.t_id IN
			 (
			select ft.tID
			from tbl_360_activities_data ft where ft.activity_level_id='1' and  ft.tID is not NULL and  ft.schoolID='$sc_id' )
		  
			group by t.t_id";

		$resultDept= mysql_query($sqlDept);
		$countDept = mysql_num_rows($resultDept);

		$resultTeacherDept = "SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
		FROM tbl_teacher  t
		 where t.school_id='$sc_id' and t.t_emp_type_pid
				in (135,137)
			group by t.t_id";

		$totaltTeacherDept=mysql_query($resultTeacherDept);
		$CountTotalDept=mysql_num_rows($totaltTeacherDept);
		$remainingDept=$CountTotalDept-$countDept;
		$percentageDept =  round((($countDept*100)/$CountTotalDept),2);

		}

		else

		{

			if(($year!='' and $year!='ALL') and ($department!='' and $department!='ALL')){
				$sqlDept = "SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
				FROM tbl_teacher  t
				 where t.school_id='$sc_id' and t.t_academic_year='$year' and t.t_dept='$department' and t.t_emp_type_pid
						in (135,137) and t.t_id IN
				 (
				select ft.tID
				from tbl_360_activities_data ft where ft.activity_level_id='1' and  ft.tID is not NULL and  ft.schoolID='$sc_id' )
				
				group by t.t_id ";

			  $resultTeacherDept = " SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
			  FROM tbl_teacher  t
			   where t.school_id='$sc_id' and t.t_academic_year='$year' and t.t_dept='$department' and t.t_emp_type_pid
					  in (135,137) group by t.t_id ";
			}
			elseif (($year!='' and $year!='ALL') and ($department=='' or $department='ALL'))
			{
				$sqlDept = "SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
				FROM tbl_teacher  t
				 where t.school_id='$sc_id' and t.t_academic_year='$year' and t.t_emp_type_pid
						in (135,137) and t.t_id IN
				 (
				select ft.tID
				from tbl_360_activities_data ft where ft.activity_level_id='1' and  ft.tID is not NULL and  ft.schoolID='$sc_id' )
				
				group by t.t_id";

				$resultTeacherDept = " SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
				FROM tbl_teacher  t
				 where t.school_id='$sc_id' and t.t_academic_year='$year' and t.t_emp_type_pid
						in (135,137) group by t.t_id ";
			}
			else{
				$sqlDept = "SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
				FROM tbl_teacher  t
				 where t.school_id='$sc_id' and t.t_dept='$department' and t.t_emp_type_pid
						in (135,137) and t.t_id IN
				 (
				select ft.tID
				from tbl_360_activities_data ft where ft.activity_level_id='1' and  ft.tID is not NULL and  ft.schoolID='$sc_id' )
				
				group by t.t_id";

		  	$resultTeacherDept = "SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
			  FROM tbl_teacher  t
			   where t.school_id='$sc_id' and t.t_dept='$department' and t.t_emp_type_pid
					  in (135,137) group by t.t_id ";
			}


		$resultDept= mysql_query($sqlDept);
		$countDept = mysql_num_rows($resultDept);



		$totaltTeacherDept=mysql_query($resultTeacherDept);
		$CountTotalDept=mysql_num_rows($totaltTeacherDept);
		$remainingDept=$CountTotalDept-$countDept;
		$percentageDept =  round((($countDept*100)/$CountTotalDept),2);




		}





		//Society Activities
		if(($year == 'ALL' && $department =='ALL') or ($year=='ALL' && $department=='') or ($year=='' && $department=='ALL'))
		{
			$sqlSociety = "SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
			FROM tbl_teacher  t
			 where t.school_id='$sc_id' and t.t_emp_type_pid
					in (133,134,135,137) and t.t_id IN
			 (
			select ft.tID
			from tbl_360_activities_data ft where ft.activity_level_id='3' and  ft.tID is not NULL and  ft.schoolID='$sc_id' )
			group by t.t_id";

		$resultSociety= mysql_query($sqlSociety);
		$countSociety = mysql_num_rows($resultSociety);

		$resultTeacherSociety = "SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
		FROM tbl_teacher  t
		 where t.school_id='$sc_id' and t.t_emp_type_pid
				in (133,134,135,137) 
		group by t.t_id";

		$totaltTeacherSociety=mysql_query($resultTeacherSociety);
		$CountTotalSociety=mysql_num_rows($totaltTeacherSociety);
		$remianingSociety=$CountTotalSociety-$countSociety;
		$percentageSociety =  round((($countSociety*100)/$CountTotalSociety),2);

		}

		else

		{

			if(($year!='' and $year!='ALL') and ($department!='' and $department!='ALL')){
				$sqlSociety = "SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
				FROM tbl_teacher  t
				where t.school_id='$sc_id' and t.t_academic_year='$year' and t.t_dept='$department' and t.t_emp_type_pid
				  in (133,134,135,137) and t.t_id  IN
				(
				select ft.tID
				from tbl_360_activities_data ft where ft.activity_level_id='3' and  ft.tID is not NULL and  ft.schoolID='$sc_id' )
					  group by t.t_id";

			  		$resultTeacherSociety = " SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
					  FROM tbl_teacher  t
					  where t.school_id='$sc_id' and t.t_academic_year='$year' and t.t_dept='$department' and t.t_emp_type_pid
						in (133,134,135,137) 
							group by t.t_id";
			}
			elseif (($year!='' and $year!='ALL') and ($department=='' or $department='ALL'))
			{
				$sqlSociety = "SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
				FROM tbl_teacher  t
				where t.school_id='$sc_id' and t.t_academic_year='$year' and t.t_emp_type_pid
				  in (133,134,135,137) and t.t_id  IN
				(
				select ft.tID
				from tbl_360_activities_data ft where ft.activity_level_id='3' and  ft.tID is not NULL and  ft.schoolID='$sc_id' )
					  group by t.t_id";

						$resultTeacherSociety = " SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
						FROM tbl_teacher  t
						where t.school_id='$sc_id' and t.t_academic_year='$year'  and t.t_emp_type_pid
						  in (133,134,135,137) 
							  group by t.t_id";
			}
			else{
				$sqlSociety = "SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
				FROM tbl_teacher  t
				where t.school_id='$sc_id'  and t.t_dept='$department' and t.t_emp_type_pid
				  in (133,134,135,137) and t.t_id  IN
				(
				select ft.tID
				from tbl_360_activities_data ft where ft.activity_level_id='3' and  ft.tID is not NULL and  ft.schoolID='$sc_id' )
					  group by t.t_id";

		  		$resultTeacherSociety = " SELECT distinct t.t_id,t.t_complete_name,t.t_dept ,t.school_id,t.t_academic_year
				  FROM tbl_teacher  t
				  where t.school_id='$sc_id'  and t.t_dept='$department' and t.t_emp_type_pid
					in (133,134,135,137) 
						group by t.t_id";
			}


		$resultSociety= mysql_query($sqlSociety);
		$countSociety = mysql_num_rows($resultSociety);


		$totaltTeacherSociety=mysql_query($resultTeacherSociety);
		$CountTotalSociety=mysql_num_rows($totaltTeacherSociety);
		$remianingSociety=$CountTotalSociety-$countSociety;
		$percentageSociety =  round((($countSociety*100)/$CountTotalSociety),2);





		}






 }



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
    $('#example').DataTable(
	{
	"pageLength": 5
	});

	$('#example1').DataTable(
	{
	"pageLength": 5
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
    <div class="panel-heading" align='center'><h3> 360 feedback </h3></div>
	<br>
	 <div class="row" align="center" style="">



         <form method="post" id="empActivity">


						                        <div class="row" style="">
                            <div class="col-md-4"></div>

                           <div class="row" style="padding-top:30px;">
                    <div class="col-md-4"></div>
                    <div class="col-md-2" style="color:#808080; font-size:18px;">Academic Year</div>
                    <?php $date = date('Y'); ?>
                    <div class="col-md-3">
                        <select name="year" id="year" class="form-control" >
			 <?php if ((isset($_POST['submit'])) or (isset($_GET['year'])) or (isset($_GET['department']))){ ?>
             <option value="<?php echo $year; ?>"><?php echo $year; ?> </option>
             <?php } 
			 else {   ?>
             <option value="">Select Year</option>
			 <?php } ?>
			 <option value="ALL" >ALL</option>
             <?php

			 $query=mysql_query("SELECT * FROM tbl_academic_Year where school_id='$sc_id' group by Academic_Year");
			 while($result=mysql_fetch_array($query))
			 {
				if((isset($_POST['submit'])) or (isset($_GET['year'])) or (isset($_GET['department']))){ 
					if($year!=$result['Academic_Year']){
				 ?>


               <option value="<?php echo $result['Academic_Year'];?>"><?php echo $result['Academic_Year'];?></option>
			   <?php } } 
              else { ?>
			  <option value="<?php echo $result['Academic_Year'];?>"><?php echo $result['Academic_Year'];?></option>
			 <?php }?>
			 <?php }?>
             </select>
                    </div>
                </div>
							<div class='col-md-3 indent-small' id="erroracademic_year" style="color:#FF0000"></div>
                        </div>



						 <div class="row "  style="padding-top:30px;" >
               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;"> Department</div>

               <div class="col-md-3">
             <select name="department" id="department" class="form-control" >
             <?php if ((isset($_POST['submit'])) or (isset($_GET['year'])) or (isset($_GET['department']))){ ?>
             <option value="<?php echo $department; ?>"><?php echo $department; ?> </option>
             <?php } 
			 else {   ?>
			 <option value="">Select Department</option>
			 <?php } ?>
			 <option value="ALL" >ALL</option>
             <?php

			 $query=mysql_query("SELECT distinct Dept_Name,school_id FROM tbl_department_master where school_id='$sc_id' group by Dept_Name");
			 while($result=mysql_fetch_array($query))
			 {
				if((isset($_POST['submit'])) or (isset($_GET['year'])) or (isset($_GET['department']))){ 
					if($department!=$result['Dept_Name']){ 
				 ?>


               <option value="<?php echo $result['Dept_Name'];?>"><?php echo $result['Dept_Name'];?></option>

			 <?php } } 
              else { ?>
				<option value="<?php echo $result['Dept_Name'];?>"><?php echo $result['Dept_Name'];?></option>
				<?php } ?>
			 <?php } ?>
             </select>
             </div>


                  </div>





	<div class="panel-body">
		 <div id="no-more-tables" style="padding-top:20px;">
	<table id="example" class="display" width="100%" cellspacing="0" align="center">



			<div class="col-md-18" style="margin-left:560px;">
                            <input type="submit" name="submit" value="Submit" class="btn btn-success" onClick="return valid();" />
                        </div>

						</br></br>
						</table>
				<table id="example" class="table table-striped" width="98%" cellspacing="5" align="center">
		<thead class="thead-dark">
			<tr>
			<th style="width:100px; text-align: left;">Entity </th>
			<th style="width:100px; text-align: left;">360 Feedback Given </th>
			<th style="width:100px; text-align: left;">360 Feedback Not Given </th>
			<th style="width:100px; text-align: center;">Total </th>
			<th style="width:100px; text-align: center;">Percentage  </th>
			</tr>
		</thead>
		<tr>
		<td style="width:100px; text-align: left;">Student Feedback</td>
			<?php if ((isset($_POST['submit'])) or (isset($_GET['year'])) or (isset($_GET['department'])) and (($year != 'ALL' && $department !='ALL') or ($year!='ALL' && $department!='') or ($year!='' && $department!='ALL'))) { ?>
					<td style="width:100px; text-align: center;"><a href="studentFeedback.php?yr=<?php echo $year; ?>&dpt=<?php echo $department; ?>" ><?php echo $countFeedStudent;?></td>
					<td style="width:100px; text-align: center;"><a href="StudentFeedback_notGiven.php?yr=<?php echo $year; ?>&dpt=<?php echo $department; ?>"> <?php echo $remainingStudent;?></td>
					<?php }
				else{?>
					<td style="width:100px; text-align: center;"><a href="studentFeedback.php" ><?php echo $countFeedStudent;?></td>
					<td style="width:100px; text-align: center;"><a href="StudentFeedback_notGiven.php"> <?php echo $remainingStudent;?></td>

				<?php } ?>
					<td style="width:100px; text-align: center;"><?php echo $CountTotalStudent;?></td>
					<td style="width:100px; text-align: center;"><?php echo $percentageStudent;?> %</td>
		</tr>

		<tr>
		<td style="width:100px; text-align: left;">Teaching Process</td>
		<?php if ((isset($_POST['submit'])) or (isset($_GET['year'])) or (isset($_GET['department']))  and (($year != 'ALL' && $department !='ALL') or ($year!='ALL' && $department!='') or ($year!='' && $department!='ALL'))){ ?>
				<td style="width:100px; text-align: center;"><a href="teachingProcess_Given.php?yr=<?php echo $year; ?>&dpt=<?php echo $department; ?>" ><?php echo $countTeachingProcess;?></td>
				<td style="width:100px; text-align: center;"><a href="teachingProcess_notGiven.php?yr=<?php echo $year; ?>&dpt=<?php echo $department; ?>"> <?php echo $remainingTprocess;?></td>
				<?php }
			else{?>
				<td style="width:100px; text-align: center;"><a href="teachingProcess_Given.php" > <?php echo $countTeachingProcess;?></td>
				<td style="width:100px; text-align: center;"><a href="teachingProcess_notGiven.php"> <?php echo $remainingTprocess;?></td>

			<?php } ?>
					<td style="width:100px; text-align: center;"><?php echo $CountTotalTeacher;?></td>
					<td style="width:100px; text-align: center;"><?php echo $percentageTProcess;?> %</td>
		</tr>

		<tr>
		<td style="width:100px; text-align: left;">Departmental Activity</td>
		<?php if ((isset($_POST['submit'])) or (isset($_GET['year'])) or (isset($_GET['department'])) and (($year != 'ALL' && $department !='ALL') or ($year!='ALL' && $department!='') or ($year!='' && $department!='ALL'))){ ?>
				<td style="width:100px; text-align: center;"><a href="department360_given.php?yr=<?php echo $year; ?>&dpt=<?php echo $department; ?>" ><?php echo $countDept;?></td>
				<td style="width:100px; text-align: center;"><a href="department360_notGiven.php?yr=<?php echo $year; ?>&dpt=<?php echo $department; ?>"> <?php echo $remainingDept;?></td>
				<?php }
			else{?>
				<td style="width:100px; text-align: center;"><a href="department360_given.php" > <?php echo $countDept;?></td>
				<td style="width:100px; text-align: center;"><a href="department360_notGiven.php"> <?php echo $remainingDept;?></td>

			<?php } ?>
					<td style="width:100px; text-align: center;"><?php echo $CountTotalDept;?></td>
					<td style="width:100px; text-align: center;"><?php echo $percentageDept;?> %</td>
		</tr>


		<tr>
		<td style="width:100px; text-align: left;">Institute Activity</td>
		<?php if ((isset($_POST['submit'])) or (isset($_GET['year'])) or (isset($_GET['department'])) and (($year != 'ALL' && $department !='ALL') or ($year!='ALL' && $department!='') or ($year!='' && $department!='ALL'))){ ?>
				<td style="width:100px; text-align: center;"><a href="institute360_given.php?yr=<?php echo $year; ?>&dpt=<?php echo $department; ?>" ><?php echo $countInstitute;?></td>
				<td style="width:100px; text-align: center;"><a href="institute360_notGiven.php?yr=<?php echo $year; ?>&dpt=<?php echo $department; ?>"> <?php echo $remainingInstitute;?></td>
				<?php }
			else{?>
				<td style="width:100px; text-align: center;"><a href="institute360_given.php" > <?php echo $countInstitute;?></td>
				<td style="width:100px; text-align: center;"><a href="institute360_notGiven.php"> <?php echo $remainingInstitute;?></td>

			<?php } ?>
					<td style="width:100px; text-align: center;"><?php echo $CountTotalInstitute;?></td>
					<td style="width:100px; text-align: center;"><?php echo $percentageInstitute;?> %</td>
		</tr>





		<tr>
		<td style="width:100px; text-align: left;">ACR</td>
		<?php if ((isset($_POST['submit'])) or (isset($_GET['year'])) or (isset($_GET['department'])) and (($year != 'ALL' && $department !='ALL') or ($year!='ALL' && $department!='') or ($year!='' && $department!='ALL'))){ ?>
				<td style="width:100px; text-align: center;"><a href="acr360_given.php?yr=<?php echo $year; ?>&dpt=<?php echo $department; ?>" ><?php echo $countAcr;?></td>
				<td style="width:100px; text-align: center;"><a href="acr360_notgiven.php?yr=<?php echo $year; ?>&dpt=<?php echo $department; ?>"> <?php echo $remainingAcr;?></td>
				<?php }
			else{?>
				<td style="width:100px; text-align: center;"><a href="acr360_given.php" > <?php echo $countAcr;?></td>
				<td style="width:100px; text-align: center;"><a href="acr360_notgiven.php"> <?php echo $remainingAcr;?></td>

			<?php } ?>
					<td style="width:100px; text-align: center;"><?php echo $CountTotalAcr;?></td>
					<td style="width:100px; text-align: center;"><?php echo $percentageAcr;?> %</td>
		</tr>



		<tr>
		<td style="width:100px; text-align: left;">Contribution to Society</td>
		<?php if ((isset($_POST['submit'])) or (isset($_GET['year'])) or (isset($_GET['department']))  and (($year != 'ALL' && $department !='ALL') or ($year!='ALL' && $department!='') or ($year!='' && $department!='ALL'))){ ?>
				<td style="width:100px; text-align: center;"><a href="society360_given.php?yr=<?php echo $year; ?>&dpt=<?php echo $department; ?>" ><?php echo $countSociety;?></td>
				<td style="width:100px; text-align: center;"><a href="society360_notGiven.php?yr=<?php echo $year; ?>&dpt=<?php echo $department; ?>"> <?php echo $remianingSociety;?></td>
				<?php }
			else{?>
				<td style="width:100px; text-align: center;"><a href="society360_given.php" > <?php echo $countSociety;?></td>
				<td style="width:100px; text-align: center;"><a href="society360_notGiven.php"> <?php echo $remianingSociety;?></td>

			<?php } ?>
					<td style="width:100px; text-align: center;"><?php echo $CountTotalSociety;?></td>
					<td style="width:100px; text-align: center;"><?php echo $percentageSociety;?> %</td>
		</tr>


	 </form>
</table>
