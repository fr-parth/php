<?php
error_reporting(0);
include("scadmin_header.php");

$reports="";
$report="";
//$count=0;
$flag='N';

$id=$_SESSION['id'];
$query="select * from `tbl_school_admin` where id='$id'";       // uploaded by
$row1=mysql_query($query);
$value1=mysql_fetch_array($row1);
$uploaded_by=$value1['name'];
$id=$_SESSION['id'];
$fields=array("id"=>$id);
$table="tbl_school_admin";

$smartcookie=new smartcookie();

$results=$smartcookie->retrive_individual($table,$fields);
$arrs=mysql_fetch_array($results);

$school_id=$arrs['school_id'];
$school_name=$arrs['school_name'];
$uploadedStatus = 0;

if (isset($_POST["submit"])) 
{
	if (isset($_FILES["file"])) 
	{
		//if there was an error uploading the file
		if ($_FILES["file"]["error"] > 0) 
		{
			echo "Return Code: ". $_FILES["file"]["error"] . "<br />";
		}
		else 
		{
			if (file_exists($_FILES["file"]["name"]))
			{
				unlink($_FILES["file"]["name"]);
			}
			$storagename= $_FILES["file"]["name"];
			move_uploaded_file($_FILES["file"]["tmp_name"],  $storagename);
			$uploadedStatus = 1;

			set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
			include 'PHPExcel/IOFactory.php';
			// This is the file path to be uploaded.

			$inputFileName = $storagename; 

			try 
			  {
				$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
		      } 
			catch(Exception $e)
			 {
				die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			 }


			$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet
			

			$arr=array();


			$value = $objPHPExcel->getActiveSheet()->getCell('A2')->getValue();
			$value1 = $objPHPExcel->getActiveSheet()->getCell('B2')->getValue();


       // echo "select batch_id from `tbl_teachr_subject_row` WHERE school_id='$school_id' ORDER BY teacher_id DESC LIMIT 1 ";
		
			$query2="select batch_id from `tbl_teachr_subject_row` WHERE school_id='$school_id' ORDER BY teacher_id DESC LIMIT 1 ";  //query for getting last batch_id what else if are inserting first time data
			$row2=mysql_query($query2);
			$value2=mysql_fetch_array($row2);
			$batch_id1=$value2['batch_id'];
			        $b_id=explode("-",$batch_id1);
			$b=$b_id[1]; 
		    $bat_id=$b+1;
			$batch_id="B"."-".$bat_id;

			//school ID
			if($school_id==$value1)
			{ 

				/* 	 
				echo "</br>limit-->".*/
				$limit=$_POST['limit'];  
				$upload_limit=$limit+1;

				if ($arrayCount>0)
				{
					//$delete = mysql_query("delete from `tbl_teachr_subject_row`");
					for($i=2;$i<=$upload_limit;$i++)
					{ 
						//echo "<script type=text/javascript>alert('$i'); window.location=''
						$arr[$i]["A"]=trim($allDataInSheet[$i]["A"]);   //Teacher emp code
						$arr[$i]["B"]=trim($allDataInSheet[$i]["B"]);   // school id
						$arr[$i]["C"]=trim($allDataInSheet[$i]["C"]);   //subject_code
						$arr[$i]["D"]=trim($allDataInSheet[$i]["D"]);   // subject Name
						$arr[$i]["E"]=trim($allDataInSheet[$i]["E"]);   // division id
						$arr[$i]["F"]=trim($allDataInSheet[$i]["F"]);   // semester id 
						$arr[$i]["G"]=trim($allDataInSheet[$i]["G"]);   // branch id
						$arr[$i]["H"]=trim($allDataInSheet[$i]["H"]);   // dept id
						$arr[$i]["I"]=trim($allDataInSheet[$i]["I"]);   // CourseLevel
						$arr[$i]["J"]=trim($allDataInSheet[$i]["J"]);   // Academic Year

						$sub_code=$arr[$i]["C"]; // for subject code
						$subject_code=strlen(trim(($sub_code)));  // $email=$arr[$i]["M"];
 
						$teacherEmpID=$arr[$i]["A"];
						$schoolID=$arr[$i]["B"];
						$subject_code=$arr[$i]["C"];
						$subject_title=$arr[$i]["D"];
						$Division_id=$arr[$i]["E"];
						$Semester_id=$arr[$i]["F"];
						$Branches_id=$arr[$i]["G"];
						$dept=$arr[$i]["H"];
						$CourseLevel=$arr[$i]["I"];
						$acdmicYear=$arr[$i]["J"];

						$upload_date=date('Y-m-d H:m:s');


						if(!empty($teacherEmpID))
						{
$teacherSubRow="INSERT INTO `tbl_teachr_subject_row`(teacher_id,school_id 	,school_staff_id,subjcet_code,subjectName,Division_id,Semester_id,Branches_id,Department_id,CourseLevel,AcademicYear,status,upload_date,uploaded_by,batch_id)
				VALUES('$teacherEmpID','$school_id','','$subject_code','$subject_title','$Division_id','$Semester_id','$Branches_id','$dept','$CourseLevel','$acdmicYear','N','$upload_date','$uploaded_by','$batch_id')";
							$rs = mysql_query($teacherSubRow);
						}		  
							$flag='Y';
					}
				}
				$sql5=mysql_query("select tch_sub_id from tbl_teachr_subject_row where status='N'");
				$count=mysql_num_rows($sql5);


if($flag=='Y')
				{
				if($arrayCount==($count+1))
				{
	$sql2=mysql_query("select tch_sub_id,teacher_id,school_id,subjcet_code,subjectName,Division_id,Semester_id,Branches_id,Department_id,CourseLevel,AcademicYear from tbl_teachr_subject_row where status='N'");
					$num2=mysql_num_rows($sql2);
					while($row2=mysql_fetch_array($sql2))
					{


						$id=trim($row2['tch_sub_id']);
						$teacher_id=trim($row2['teacher_id']);
						$school_id=trim($row2['school_id']);
						$subject_code=trim($row2['subjcet_code']);
						$subject_title=trim($row2['subjectName']);
						$Division_id=trim($row2['Division_id']);
						$Semester_id=trim($row2['Semester_id']);
						$Branches_id=trim($row2['Branches_id']);	
						$Department_id=trim($row2['Department_id']);
						$CourseLevel=trim($row2['CourseLevel']);	
						$academiYear=$row2['AcademicYear'];

$matchteacher=mysql_query("select t_id,school_id,t_emp_type_pid from tbl_teacher where school_id='$school_id' and t_id='$teacher_id' and(t_emp_type_pid=133 or 132)");
						$getteacherinfo=mysql_fetch_array($matchteacher);
						$teahcerid=$getteacherinfo['t_id'];
						$no=mysql_num_rows($matchteacher);

						if(mysql_num_rows($matchteacher)!=0)
						{
							$no=mysql_num_rows($matchteacher);
							
							
							if($subject_code!="") //mapping with subject code
							{
								$row=mysql_query("select Subject_Code,subject from `tbl_school_subject` where Subject_Code='$subject_code' and school_id='$school_id'");
								$getCount=mysql_fetch_array($row);  
								$subjectcount=mysql_num_rows($row);

								if(mysql_num_rows($row)!=0)
								{
									$subjectcount=mysql_num_rows($row);
									$sub_code1=trim($getCount['Subject_Code']);
									$sub_title1=trim($getCount['subject']);


							$matchingrecord=mysql_query("select * from tbl_teacher_subject_master where teacher_id='$teahcerid' AND school_id='$school_id' AND subjcet_code='$sub_code1' AND Division_id='$Division_id' AND Semester_id='$Semester_id' AND Branches_id='$Branches_id' AND CourseLevel='$CourseLevel' AND AcademicYear='$academiYear'");
                                     $getrecord=mysql_num_rows($matchingrecord);


									if($getrecord <=0)
									{
										$date=date('Y-m-d');
$sql_insert1="INSERT INTO `tbl_teacher_subject_master`(teacher_id,school_id,school_staff_id 	,subjcet_code,subjectName,Division_id,Semester_id,Branches_id,Department_id,CourseLevel,AcademicYear,upload_date,uploaded_by,batch_id)
										VALUES ('$teahcerid','$school_id','','$sub_code1','$sub_title1','$Division_id','$Semester_id','$Branches_id','$Department_id','$CourseLevel','$academiYear','$upload_date','$uploaded_by','$batch_id')";

										$result_insert1 = mysql_query($sql_insert1) or die(mysql_error()); 
										$reports1="All Teacher Subject are successfully Inserted...";
                                   $query=mysql_query("update tbl_teachr_subject_row set status='Y' where tch_sub_id='$id'"); 
									}
									else
									{

										//    echo "</br>select tch_sub_id from tbl_teacher_subject_master where teacher_id='$teahcerid' AND school_id='$school_id' AND subjcet_code='$sub_code1' AND Division_id='$Division_id' AND Semester_id='$Semester_id' AND Branches_id='$Branches_id'";

										$fetch_t_id=mysql_query("select tch_sub_id from tbl_teacher_subject_master where teacher_id='$teahcerid' AND school_id='$school_id' AND subjcet_code='$sub_code1' AND Division_id='$Division_id' AND Semester_id='$Semester_id' AND Branches_id='$Branches_id'");
										$result=mysql_fetch_array($fetch_t_id);
										$t_id=$result['tch_sub_id'];
										$getNo=mysql_num_rows($fetch_t_id);



										//	echo "</br>update tbl_teacher_subject_master set AcademicYear='$academiYear',CourseLevel='$CourseLevel', Division_id = '$Division_id',Semester_id = '$Semester_id',Branches_id='$Branches_id',Department_id = '$Department_id' where where tch_sub_id='$t_id'";

										/*$sqls=mysql_query("update tbl_teacher_subject_master set AcademicYear='$academiYear',CourseLevel='$CourseLevel', Division_id = '$Division_id',Semester_id = '$Semester_id',Branches_id='$Branches_id',Department_id = '$Department_id' where teacher_id='$teahcerid' AND school_id='$school_id' 
										AND subjcet_code='$sub_code1' and Semester_id = '$Semester_id' and Branches_id='$Branches_id'");*/

										$sqls=mysql_query("update tbl_teacher_subject_master set AcademicYear='$academiYear',CourseLevel='$CourseLevel', Division_id = '$Division_id',Semester_id = '$Semester_id',Branches_id='$Branches_id',Department_id = '$Department_id' where tch_sub_id='$t_id'");

										$query=mysql_query("update tbl_teachr_subject_row set status='duplicate' where tch_sub_id='$id'");

										$updatesubject="Fond Duplicate Record";
										//echo "<br/>Insert duplicate record";
									}//duplicate
								}	

								else
								{
									//echo "<script type=text/javascript>alert('Name exist'); window.location=''";
									$report="Subject Code didn't match.";
									$query=mysql_query("update tbl_teachr_subject_row set status='Subject Code' where tch_sub_id='$id'");
								}	

							}


							else
							{
								//echo "<script type=text/javascript>alert('Name exist'); window.location=''";
								//$reports="Plz Specify Subject Code.";
								$report1="Please put Subject Code in your upload list.";
							}


						}

						else
						{
							$error="Teacher ID didn't match.";
							$query=mysql_query("update tbl_teachr_subject_row set status='Teacher_id Not Match' where tch_sub_id='$id'");
						}
					}
					mysql_free_result($sql2);
					// closing of if row<0
				}




					$query4="select count(case when `status`= 'Y' then 1 else null end) as Y,
					count(case when `status`='Fond Duplicate Record' then 1 else null end) as FoundDuplicateRecord,
					count(case when  `status`='Subject Code' then 1 else null end) as SubjectCode,
					count(case when `status`='Teacher_id Not Match' then 1 else null end) as StudentNotMatch ,count(1) as totalrecord
					from  tbl_teacher_subject_master where batch_id='".$batch_id."'";       
					$row4=mysql_query($query4);
					$value4=mysql_fetch_array($row4);
					$inserreocrd=$value4['Y'];
					$duplicate=$value4['FoundDuplicateRecord'];
					$subjectcode=$value4['SubjectCode'];
					$subjectNotMatch=$value4['StudentNotMatch'];
					$totalrecord=$value4['totalrecord'];
					$error_count=$subjectcode+$subjectNotMatch;
					$correct_records=$totalrecords-$error_count-$count_of_duplicates;
					$display_table_name="Teacher Subject";
					$db_table_name="tbl_teachr_subject_row";



					$sql_insert10="INSERT INTO `tbl_Batch_Master`(batch_id,input_file_name,file_type,uploaded_date_time,uploaded_by,num_records_uploaded,num_errors_records,num_duplicates_record,num_correct_records,display_table_name,db_table_name) VALUES ('$batch_id','$inputFileName','$file_type1','$date','$uploaded_by','$totalrecord','$error_count','$duplicate','$inserreocrd','$display_table_name','$db_table_name')";
					$count10 = mysql_query($sql_insert10) or die(mysql_error()); 

				}
				else
				{
					echo "<script type=text/javascript>alert('Plz select upload limit'); window.location=''</script>";
				}
			// }
			}
			else
			{
				echo "<script type=text/javascript>alert('School ID did not match plz import right excel sheet'); window.location=''</script>";
			} 
		}  // for closing
	}    //for exist name
	// file upload closing
	else
	{
		//$nofile="No file selected <br />";
		echo "<script type=text/javascript>alert('No file selected'); window.location=''</script>";	
	}
}   // submit closing

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">


var _validFileExtensions = [".xlsx", ".xls", ".xlsm", ".xlw", ".xlsb",".xml",".xlt"];    
function ValidateSingleInput(oInput) {
if (oInput.type == "file") {
var sFileName = oInput.value;
if (sFileName.length > 0) {
var blnValid = false;
for (var j = 0; j < _validFileExtensions.length; j++) {
var sCurExtension = _validFileExtensions[j];
if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
blnValid = true;
break;
}
}

if (!blnValid) {
alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
oInput.value = "";
return false;
}
}
}
return true;
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//js/jquery-1.10.2.js"></script>
<script src="//js/jquery-ui.js"></script>
<link rel="stylesheet" href="/js/style.css">
<style>
H3{
text-align: center;
color: white;
font-family: arial, sans-serif;
font-size: 20px;
font-weight: bold;
margin-top: 0px;

background-color:grey;
width: 25%;
line-height:30px;
}
H5{
text-align: center;
color: white;
font-family: arial, sans-serif;
font-size: 20px;
font-weight: bold;
margin-top: 0px;
background-color:grey;
width:35%;
line-height:30px;
}
</style>

<script>
$(function() {
$( "#dialog" ).dialog();
});
</script>
</head>

<body >
<div class='container' style="padding-top:30px;padding-left:30px;">
<div class='panel panel-primary dialog-panel'>
<div style="color:red;font-size:15px;font-weight:bold;margin-top:10px;"> <?php if(isset($_GET['report'])){ echo $_GET['report']; };?></div>
<div><a href="getexcel.php">Download Excel File Format</a></div>
<div class='panel-heading' align="center"> <h3>Add Teacher Subject Excel Sheet</h3>  </div>  



<div class='panel-body' style="background:lightgrey; box-shadow: 0 0 10px 10px black;">
<form name='frm' method='post' enctype='multipart/form-data' id='frm'>


<div class='form-group'>
<div class="assignlimit">
<div class="assign-limit">
<form method="post" action="#">
<select name="limit" class="limitofuploadingrecords" id="limit" style="width:20%; height:30px; border-radius:2px;margin-left: 430px;">
<option value="20" disabled selected>Set upload Records Limit</option>
<option value="1">1</option>
<option value="4">4</option>
<option value="20">20</option>
<option value="40">40</option>
<option value="60">60</option>
<option value="80">80</option>
<option value="100">100</option>
<option value="120">120</option>
<option value="850">850</option>
<option value="1000">1000</option>
<option value="1200">1200</option>
<option value="1500">1500</option>
<option value="1700">1700</option>
<option value="2000">2000</option>
<option value="2050">2050</option>
<option value="2100">2100</option>
<option value="2500">2500</option>
<option value="3000">3000</option>
<option value="3150">3150</option>
</div>
</div>
</form>
<label class='control-label col-md-2 col-md-offset-2' for='id_title'></label>
<div class='col-md-4'>
<div class='col-md-2' style="padding-left:100px">
<input type='file' name='file' id='file' onChange="ValidateSingleInput(this);" style="margin-left:455px;margin-top:20px"/>                          </div> 
</div>
</div>
<div style="height:50px;"></div>
<div class='form-group'>
<div class='col-md-offset-3 col-md-3' style="padding-left:155px;margin-top:-35px">
<input class='btn-lg btn-primary' type='submit' value="Submit" name="submit" />
</div>
<div class='col-md-3' style="margin-top:-35px">
<button type="cancel" class='btn-lg btn-danger' onclick="javascript:window.location='list_school_subject.php'">Cancel</button>
</div>
</div>
<div class="row">
<div class='col-md-6 col-md-offset-2' align="center" style="color:black;margin-top:15px;padding-left:201px;">

<?php echo $reports1."<br>";
echo $reports."<br>";
echo $report."<br>";
echo $error."<br>";
echo $updatesubject."<br>";
echo $no_rows;

?>




</div>
</div>
</div>

</form>






</div>


</div>







<div class="row">
<div class="col-md-1"></div>
<div class="col-md-12 ">
<table cellpadding="12" cellspacing="6" align="center">
<tr bgcolor="#9900CC">

<!--<th bgcolor="#CCCCCC">School ID</th>
<th bgcolor="#CCCCCC">Semester_ID</th>
<th bgcolor="#CCCCCC">Subject_Code</th>
<th bgcolor="#CCCCCC">Subject_Title</th>
<th bgcolor="#CCCCCC">Branch_ID</th>
<th bgcolor="#CCCCCC">Degree Name</th>-->


<tr>


</table>
</div>
</div>





</body>

</html>
