<?php
 include("scadmin_header.php");
if($_SESSION['usertype']=='HR Admin Staff' OR $_SESSION['usertype']=='School Admin Staff')
	{
		$sc_id1=$_SESSION['school_id']; 
		$query2 = mysql_query("select id from tbl_school_admin where school_id ='$sc_id1'");

    $value2 = mysql_fetch_array($query2);

    $id = $value2['id'];
		
		
	}
	else
	{
		$id = $_SESSION['id'];
	}

$sql=mysql_query("select school_id from tbl_school_admin where id='$id'");
$result=mysql_fetch_array($sql);
//Below school_id fetched from session added by Rutuja for SMC-5022 on 15-12-2020
$sc_id=$_SESSION['school_id'];

switch($_GET['fn']){
	
	case 'fun_course':
		$row=mysql_query("SELECT d.id,t.t_complete_name,t.t_emp_type_pid,t.t_dept,t.t_id,t.t_DeptID,d.Dept_Name , d.ExtDeptId
			FROM tbl_teacher t 
			join tbl_department_master d on t.t_DeptID = d.ExtDeptId and t.school_id=d.School_ID
			where t.school_id='".$sc_id."' and t.t_DeptID!='' and t.t_id='".$_GET['teacher_id']."';
			"); 
			echo "<option>select</option>";
		  while($val=mysql_fetch_array($row))
		  {
		  	  echo "<option value='$val[Dept_Name]'> $val[Dept_Name]</option>";
		   }
		  
		break;	
		
		
		case 'fun_dept':
		//$row=mysql_query("select distinct Branch_name,Department_Name,school_id,ExtBranchId from  tbl_semester_master where Department_Name='".$_GET['value']."' and school_id='$sc_id' group by  Branch_name "); 

//Modified below query by Pranali to take values from tbl_branch_master according to course levekl and department for SMC-5048
		$row = mysql_query("SELECT id,ExtBranchId,branch_Name FROM tbl_branch_master where Course_Name='".$_GET['course_level']."' and DepartmentName='".$_GET['value']."' and school_id='".$sc_id."' and IsEnabled='1' and branch_Name!='' group by branch_Name order by branch_Name asc");
			echo "<option>select</option>";
			
		  while($val=mysql_fetch_array($row))
			  
		  {
		  	  echo "<option value='$val[ExtBranchId],$val[branch_Name]'> $val[branch_Name]</option>";
		   }
		break;	
		
		case 'fun_branch':
		$a = $_GET['value'];
		$b = explode (",", $a);
		$c = $b[1];
		//Added and CourseLevel='".$_GET['course_level']."' by Pranali for SMC-5048
        $row=mysql_query("select * from  tbl_semester_master where Branch_name='$c' and school_id='$sc_id' and Department_Name='".$_GET['dept']."' and Is_enable='1' and Semester_Name!='' and CourseLevel='".$_GET['course_level']."' group by Semester_Name order by Semester_Name asc"); 
			echo "<option>select</option>";
		  while($val=mysql_fetch_array($row))
		  {
		  	  echo "<option value='$val[ExtSemesterId],$val[Semester_Name]'> $val[Semester_Name]</option>";
		   }
		
		break;	
		 
		
		case 'fun_subject':
		$a=$_GET['value'];
		$ext=explode(",",$a)[1];
		$row=mysql_query("select distinct Subject_Code from   tbl_school_subject where Subject_Code='$ext' and school_id='$sc_id'"); 
		$val=mysql_fetch_array($row);
		echo "<option value='$val[Subject_Code]'> $val[Subject_Code]</option>"; 
		
		break;	
//Added below case by Pranaali for SMC-5048
		case 'fun_subject_name':
		
		$row = mysql_query("SELECT * FROM tbl_teacher_subject_master where teacher_id='".$_GET['teacher_id']."' and school_id='".$sc_id."' and subjectName!='' group by subjectName order by subjectName asc");
		echo "<option>select</option>";
		  while($val=mysql_fetch_array($row))
		  {
		  	  echo "<option value='$val[subjectName],$val[subjcet_code]'> $val[subjectName]</option>";
		   }

			break;
//Added fun_sem by Pranali to display class according to course level selected for SMC-5006 on 30/1/21
		case 'fun_sem':
		 
            $row=mysql_query("SELECT DISTINCT ExtClassID,class FROM Class where class!= '' AND school_id='$sc_id' and course_level='".$_GET['course_level']."' order by class ASC");

            echo "<option value='0'> select</option>";

                    while($val=mysql_fetch_array($row))
                    {
                                                
             			echo "<option value='$val[class],$val[ExtClassID]'> $val[class] </option>";

            		}
		  
		break;
	
}

?>