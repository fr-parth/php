<?php

include("hr_header.php");
/* include("error_function.php"); */
$reports="";
$report="";
$c="";
$count = 0;

$id=$_SESSION['id'];
$query="select * from `tbl_school_admin` where id='$id'";       // uploaded by
$row1=mysql_query($query);
$value1=mysql_fetch_array($row1);
$uploaded_by=$value1['name'];
$fields=array("id"=>$id);
$table="tbl_school_admin";
		   
$smartcookie=new smartcookie();
$results=$smartcookie->retrive_individual($table,$fields);
$arrs=mysql_fetch_array($results);

$school_id=$arrs['school_id'];
$school_name=$arrs['school_name'];

			
$uploadedStatus = 0;

if(isset($_POST["submit"]))
{
	
	if(isset($_FILES['file']))
	{
		
		//if there was an error uploading the file
		if ($_FILES["file"]["error"] > 0)
			{
				echo "<script type=text/javascript>alert('No file selected'); window.location=''</script>";
					//echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
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
			} catch(Exception $e)
			{
				die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}


		$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet
		$arr=array();
		/* $count_of_insert="";
		$count_of_duplicates="";
		$dup=0;
		$upd=0;
		$sch_id=0;
		$val="";
		$validate=0;
		$not_validate=0;
		$count_of_wrong_school_id="";	
		$sub_error=0;
		$limit=$_POST['limit']; 
		$upload_limit=$limit+1;
		$min=min($upload_limit,$arrayCount);
		$totalrecords=$min-1;
		$flag=$_POST['flag']; */
							
					$extract = $_POST['extract'];
					if($extract==1)
					{
						echo "qwert";
						$insert=0; $list = array();
						try
						{
							//$file = fopen("C:\wamp\www\smartcookies\CSV\subject_error.csv","w+") or die("Unable to open file for output");
							// $file = fopen("/home/content/84/7121184/html/smartcookies/CSV/subject_error.csv","w+") or die("Unable to open file for output");
							$file = fopen("/home/content/84/7121184/html/tsmartcookie/CSV/subject_master.csv","w+") or die("Unable to open file for output");
							fwrite($file,"School_id" . ", " . "Semester name" . ", " . "Subject Code" . ", " . "Subject Title" . ", " . "Degree Name" . "," . "Subject type" . ", " . "subject short name" ."," . "subject credit" ."," . "course level" ."\n");
							for($i=2;$i<=$arrayCount;$i++)
							{
									$sch_id = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
									$semname = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue();
									$subj_code = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getValue();
									$scubjectname = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getValue();
									$subtype = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getValue();
									$subshortname = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getValue();
									$subcredit = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getValue();
									$semid=explode(" ",$semname);
							
									fwrite($file, $sch_id . ", " .$semid[3]." ".$semid[4] . "," . $subj_code. ", " .$scubjectname. ", " .$semid[0]." ".$semid[1]." ".$semid[2]. ", " .$subtype. "," .$subshortname. ", " .$subcredit. "," .$sn. "\n");
							
							echo "file";
							}	
						}
							catch(Exception $e)
							{
									echo 'Caught exception: ',  $e->getMessage(), "\n";
							}
						
					}	
					if($extract==2)
					{
						
						try
						{
							//$file = fopen("C:\wamp\www\smartcookies\CSV\subject_error.csv","w+") or die("Unable to open file for output");
							// $file = fopen("/home/content/84/7121184/html/smartcookies/CSV/subject_error.csv","w+") or die("Unable to open file for output");
							$file = fopen("/home/content/84/7121184/html/tsmartcookie/CSV/teacher_subject_master.csv","w+") or die("Unable to open file for output");
							
							fwrite($file,"SchoolID".", "."TeacherID".", "."SubjectID".", "."SubjectCode".", "."SubjectName".", "."YearID".", "."DivisionID".","."Division".", "."SemesterID".", "."Semester".", "."BranchID".", "."Branch".", "."DepartmentID".", "."Department".", "."CourseLevel".", "."AcademicYear\n");
							/* fwrite($file,$sn. "," . "School_id" . ", " . "Semester name" . ", " . "Subject Code" . ", " . "Subject Title" . ", " . "Degree Name" . "," . "Subject type" . ", " . "subject short name" ."," . "subject credit" ."," . "course level" ."\n"); */
							for($i=2;$i<=$arrayCount;$i++)
							{
									$sch_id = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
									$semname = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue();
									$subj_code = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getValue();
									$subjectname = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getValue();
									$subtype = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getValue();
									$subshortname = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getValue();
									$subcredit = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getValue();
									
									$teacher_id = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getValue();
									$semid=explode(" ",$semname);
									fwrite($file,$sch_id . ", ".$teacher_id.", ".", ".$subj_code.",".$subjectname.", ".$sn.", ".$sn.", ".$sn.", ".$semid[3].", ".$semname.", ".$sn.", ".$sn.", ".$sn.", ".$sn.", ".$sn.", ".$sn."\n");
									/* fwrite($file,$sn. ", " . $sch_id . ", " .$semid[3]." ".$semid[4] . "," . $subj_code. ", " .$scubjectname. ", " .$semid[0]." ".$semid[1]." ".$semid[2]. ", " .$subtype. "," .$subshortname. ", " .$subcredit. "," .$sn. "\n"); */
							
							
							}	
						}
							catch(Exception $e)
							{
									echo 'Caught exception: ',  $e->getMessage(), "\n";
							}
						
						
						
						
						
					}
						
						
						
						
						
						
						
						
						
						
						
						
						/* $getallcols=array();
						$col=array('A','B','C','D','E','F','G','H','I','J','K');
						$header=array("School_id","Semester name","Subject Code","Subject Title","Degree Name","Subject type","subject short name","subject credit","course level");
						$k=1;
						for($i=1;$i<=$arrayCount;$i++)
						{ 
							for($j=0;$j<count($header);$j++)
								{
									$value =  strtolower($objPHPExcel->getActiveSheet()->getCell($col[$j].$k)->getValue());
									$getallcols=checkColumnname($value,$col[$j]);
							
							    }
						}	
						print_r($getallcols);	
							
							
							
							//$domain = stristr($value, 'School ID');
							
							function checkColumnname($value,$index)
							{
								for($i=0;$i<count($header);$i++)
								{	
									$colname=strcasecmp($header[$i],$value);
									if($colname==0)
									{
										return $header[$i].$index;
									}
								}
							}
								 */
					
						
						
				}
				
	}
}
		
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
    $("#dialog").dialog();
  });
  </script>
</head>
<body >
<div class='container' style="padding-top:30px;padding-left:30px;">
    <div class='panel panel-primary dialog-panel' align="center">
<!--   <div style="color:red;font-size:15px;font-weight:bold;margin-top:10px;"> <?php echo $errorreport;?></div>
   <div style="color:#093;font-size:15px;font-weight:bold;margin-top:10px;"> <?php if(isset($_GET['report'])){ echo $_GET['report']; }; ?></div>-->
          <div class='panel-heading' align="center">

                <h3>Extract Excel Sheet</h3>



              </div>

					<form  method="post" action="" enctype="multipart/form-data">
                    <div class='panel-body' style="background:lightgrey; box-shadow: 0 0 10px 10px black;">
                   <!-- <form name='frm' method='post' enctype='multipart/form-data' id='frm'>-->
                    <div class="row" >
                    <p><b>Scan Excel file</b></p>

                    <select name="extract">
                        <option value="1"> Project Master</option>
                        <option value="2"> Manager Project Master</option>
                        
                        
                        <option value="5"> Project Master</option>
                    </select>

                   <!-- <input type="radio" name="flag" value="1" > Subject Master &nbsp;
                    <input type="radio" name="flag" value="2" > Teacher Subject Master &nbsp;
                    <input type="radio" name="flag" value="3" > Class Semester Subject &nbsp;
                    <input type="radio" name="flag" value="4" > Student Semester Subject  &nbsp;
                    <input type="radio" name="flag" value="5" > Subject Semester Master  &nbsp;-->
                    </div>
                    <br>

                 
                                <div class='col-md-4'>
                                    <div class='col-md-4 indent-small'>
                                        <input type='file' name='file'  id='file'  onChange="ValidateSingleInput(this);" style="margin-left:455px;margin-top:20px"/>                          </div>
                                </div>
                                <br><br>
                             
                              <div style="height:50px;"></div>
                              <div class='form-group'>
                                <div class='col-md-offset-3 col-md-3' style="padding-left:155px;margin-top:-35px">
                                  <input class='btn-lg btn-primary' type='submit' value="submit" name="submit" />
                                </div>
                                <div class='col-md-3' style="margin-top:-35px">

                                  <a href="student_setup.php"><button class='btn-lg btn-danger'  type='button'>Back</button></a>
                                </div>
                                </div>
                                <div class="row">
                                    <div class='col-md-6 col-md-offset-2' align="center" style="color:black;margin-top:15px;padding-left:201px;">

                                    <?php
                                            echo $reports1."<br>";
                                            echo $reports."<br>";
                                            echo $report."<br>";
                                            echo $no_rows;

                                    ?>


                                     </div>
                                    </div>
                                </div>

						</form>

            </div>

         </div>                         
 </body>
 </html>

							
																					 