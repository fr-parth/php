
	<?php

include_once("header.php");
	 
$id=$_SESSION['id'];
$query=mysql_query("select * from `tbl_teacher` where id='$id'");  
$value=mysql_fetch_array($query); 
$school_id=$value['school_id'];
$teacher_id=$value['id'];
$t_id=$value['t_id'];
$t_name=$value['t_complete_name'];

$report="";

$method="";
 
 
$uploadedStatus = 0;

if ( isset($_POST["submit"]) ) 
{
	
    if ( !empty($_FILES["file"]["name"])) 
	{
		$sql2=mysql_query("select batch_id from tbl_Batch_Master where school_id='$school_id' and entity='Teacher' and uploaded_by like '$t_id' order by id desc limit 1");
	$resultsql=mysql_fetch_array($sql2);
 $count=mysql_num_rows($sql2);
		 
		   $date1=date('Y-m-d h:i:s',strtotime('+330 minute'));
		 if($count==0)
		 {
			$batch_id=$school_id."-"."B-1";
			 			 
		 }
		 else
		 {
			$batch_id=$resultsql['batch_id'];
			$b_id=explode("-",$batch_id);
			$batch=$b_id[2];
			$batch=$batch+1;
			$batch_id=$school_id."-"."B-".$batch;
						
		 }
		 $storagename= $_FILES["file"]["name"];
	
		  $sql3=mysql_query("insert into tbl_Batch_Master (batch_id,input_file_name,uploaded_date_time,uploaded_by,entity,school_id)values('$batch_id','$storagename','$date1','$t_id','Teacher','$school_id') ");
		 $storagename = "Importdata/" . $_FILES["file"]["name"];
		
			//$storagename= $_FILES["file"]["name"];
			move_uploaded_file($_FILES["file"]["tmp_name"],  $storagename);
			$uploadedStatus = 1;

			set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
			include 'PHPExcel/IOFactory.php';
			$inputFileName = $storagename; 

			try {
					$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
				} 
			catch(Exception $e) {
					die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
				}
				
				$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
				$arrayCount = count($allDataInSheet); 
				$DataCount = $arrayCount-1;  // Here get total count of row in that Excel sheet
				$dates=date('d/m/Y');
				$arr=array();
				for($i=2;$i<=$arrayCount;$i++)
				{
				$arr[$i]["A"]=str_replace("'","", trim($allDataInSheet[$i]["A"])); // school_id
				$arr[$i]["B"]=str_replace("'","", trim($allDataInSheet[$i]["B"]));   // t_id
				$arr[$i]["C"]=str_replace("'","", trim($allDataInSheet[$i]["C"]));  // student PRN
				$arr[$i]["D"]=str_replace("'","", trim($allDataInSheet[$i]["D"]));   // subject Code
				$arr[$i]["E"]=str_replace("'","", trim($allDataInSheet[$i]["E"]));  // judgement
				$arr[$i]["F"]=str_replace("'","", trim($allDataInSheet[$i]["F"]));  // marks
				$arr[$i]["G"]=str_replace("'","", trim($allDataInSheet[$i]["G"]));  // grade
				$arr[$i]["H"]=str_replace("'","", trim($allDataInSheet[$i]["H"]));  // Percentile
				$arr[$i]["I"]=str_replace("'","", trim($allDataInSheet[$i]["I"]));   // outof
				
				$sc_id=$allDataInSheet[$i]["A"];   // for teacher ID
				$sc_id=trim($sc_id);
								
				$teacher_id=$allDataInSheet[$i]["B"];   // for teacher ID
				$teacher_id=trim($teacher_id);
					
				$std_PRN=$allDataInSheet[$i]["C"];   // for teacher ID
				$std_PRN=trim($std_PRN);
				
				$subject_code=$allDataInSheet[$i]["D"];   // for teacher ID
				$subject_code=trim($subject_code);
				
				$judgement=$allDataInSheet[$i]["E"];   // for teacher ID
				$judgement=trim($judgement);
				
				
				$marks=$allDataInSheet[$i]["F"];   // for teacher ID
				$marks=trim($marks);
				
				$grade=$allDataInSheet[$i]["G"];   // for teacher ID
				$grade=trim($grade);
				
				$percentile=$allDataInSheet[$i]["H"];   // for teacher ID
				$percentile=trim($percentile);
				
				$outof=$allDataInSheet[$i]["I"];   // for teacher ID
				$outof=trim($outof);
				
				$count=0;
				if($judgement=="")
				{
					$count++;
				}
				if($marks=="")
				{
				$count++;
				}
				if($grade=="")
				{
					$count++;
				}
				if($percentile=="")
				{
					$count++;
				}
				
				//echo $count;die;
				if($sc_id!='')
				{
					if($teacher_id!='')
					{
						if($std_PRN!='')
						
						{
							if($subject_code!='')
							{
											
				if($count==3)
				{
				
							if($judgement!="")
							{
								
									$points=$judgement;
																
									$method="1";
								
							} // Judgement
				
				
							if($marks!="")
								{
										if($outof=='' || $outof==100)
											{	
											$calmarks=$marks;					
												
											}
											else
											{
												$calmarks=($marks * 100)/$outof;
											}
								
								
								$results=mysql_query("SELECT  m.id,m.points,from_range,to_range FROM tbl_master m JOIN tbl_method t on 	t.id=m.method_id WHERE t.id ='2' AND school_id='0'");
							
										
										while( $rows = mysql_fetch_array($results))
									{
										 $from_range=$rows['from_range'];
										 $to_range=$rows['to_range'];
										 if($calmarks>=$from_range && $calmarks<=$to_range)
										{
										 $points=$rows['points'];
										
										}
									}
									
													
									$method="2";
								
								
							
						} // Marks
						
						
						if($grade!="")
								{
									
											
							$results=mysql_query("SELECT  m.id,m.points,from_range,to_range FROM tbl_master m JOIN tbl_method t on 	t.id=m.method_id WHERE t.id ='3' AND school_id='0'");
							
										
											while( $rows = mysql_fetch_array($results))
									{
										 $from_range=$rows['from_range'];
										 $to_range=$rows['to_range'];
											if(strcmp($from_range,$grade)<=0 && strcmp($to_range,$grade)>=0)
											{
												$points=$rows['points'];
											}
											else
											{
												$points=0;
											}
									}
									
													
									$method="3";
								
								
							
						}// Grade
				
						
						if($percentile!="")
								{
										
												$calpercentile=$percentile;
											
								
								
								
									
							$results=mysql_query("SELECT  m.id,m.points,from_range,to_range FROM tbl_master m JOIN tbl_method t on 	t.id=m.method_id WHERE t.id ='4' AND school_id='0'");
							
										
										while( $rows = mysql_fetch_array($results))
									{
										 $from_range=$rows['from_range'];
										 $to_range=$rows['to_range'];
										 if($calpercentile>=$from_range && $calpercentile<=$to_range)
										{
										 $points=$rows['points'];
										
										}
									}
									$method="4";
								
							
						}//Percentile
				
				
					
					
				
				
								
					
				
					
				
				

				if($school_id==$sc_id)
				{
				
				if($t_id==$teacher_id)
				{
					
					
					$sqlquery=mysql_query("select st.tch_sub_id from tbl_teacher_subject_master st join tbl_academic_Year Y on st.AcademicYear=Y.Year and Y.Enable='1' where st.school_id='$school_id' and st.teacher_ID='$teacher_id' and st.subjcet_code='$subject_code'");
					$result_count=mysql_num_rows($sqlquery);
					
					
					if($result_count!='')
					{
							
				$sqlquery1=mysql_query("select ss.id from tbl_student_subject_master ss join tbl_academic_Year Y on ss.AcademicYear=Y.Year and Y.Enable='1' where ss.school_id='$school_id' and ss.teacher_ID='$teacher_id' and ss.student_id='$std_PRN'" );
				
				$result_count1=mysql_num_rows($sqlquery1);
				
				if($result_count1!='')
					{

				$sql_insert8="INSERT INTO import_student_points (school_id,sc_teacher_id,sc_stud_id,sc_entites_id,sc_studentpointlist_id,method,judgement,marks,grade,percentile,outof,points,activity_type,point_date,batch_no) values('$sc_id','$t_id','$std_PRN','103','$subject_code','$method','$judgement','$marks','$grade','$percentile','$outof','$points','subject','$dates','$batch_id')"; 
							$count8 = mysql_query($sql_insert8) or die(mysql_error()); 
					}// Teacher student mapping
					
					else
					{
							$sql_insert8="INSERT INTO `error_import_student_points` 
								(school_id,sc_teacher_id,sc_stud_id,sc_entites_id,sc_studentpointlist_id,method,judgement,marks,grade,percentile,outof,points,activity_type,point_date,error_code,batch_no) values('$sc_id','$t_id','$std_PRN','103','$subject_code','$method','$judgement','$marks','$grade','$percentile','$outof','$points','subject','$dates','Teacher student mapping not match','$batch_id')"; 
							$count8 = mysql_query($sql_insert8) or die(mysql_error()); 
		
						
					}// Teacher student mapping
					
							
					}// Teacher subject mapping
					
					else
					{
						
							$sql_insert8="INSERT INTO `error_import_student_points` 
								(school_id,sc_teacher_id,sc_stud_id,sc_entites_id,sc_studentpointlist_id,method,judgement,marks,grade,percentile,outof,points,activity_type,point_date,error_code,batch_no) values('$sc_id','$t_id','$std_PRN','103','$subject_code','$method','$judgement','$marks','$grade','$percentile','$outof','$points','subject','$dates','Teacher subject mapping not match','$batch_id')"; 
							$count8 = mysql_query($sql_insert8) or die(mysql_error()); 
		
						
						
					}// Teacher subject mapping
							
							
				}// Teacher mapping
				
				else
				{
					$sql_insert8="INSERT INTO `error_import_student_points` 
								(school_id,sc_teacher_id,sc_stud_id,sc_entites_id,sc_studentpointlist_id,method,judgement,marks,grade,percentile,outof,points,activity_type,point_date,error_code,batch_no) values('$sc_id','$t_id','$std_PRN','103','$subject_code','$method','$judgement','$marks','$grade','$percentile','$outof','$points','subject','$dates','Teacher ID not match','$batch_id')"; 
							$count8 = mysql_query($sql_insert8) or die(mysql_error()); 
		
					
					
				}// Teacher mapping
							
							
		}// School ID not match
		else
		
		{
				$sql_insert8="INSERT INTO `error_import_student_points` 
								(school_id,sc_teacher_id,sc_stud_id,sc_entites_id,sc_studentpointlist_id,method,judgement,marks,grade,percentile,outof,points,activity_type,point_date,error_code,batch_no) values('$sc_id','$t_id','$std_PRN','103','$subject_code','$method','$judgement','$marks','$grade','$percentile','$outof','$points','subject','$dates','School ID not match','$batch_id')"; 
							$count8 = mysql_query($sql_insert8) or die(mysql_error()); 
		
			
		}// school ID not match
				}// Count 3
				
				
				
				else
				{
				
					$sql_insert8="INSERT INTO `error_import_student_points` 
								(school_id,sc_teacher_id,sc_stud_id,sc_entites_id,sc_studentpointlist_id,method,judgement,marks,grade,percentile,outof,points,activity_type,point_date,error_code,batch_no) values('$sc_id','$t_id','$std_PRN','103','$subject_code','$method','$judgement','$marks','$grade','$percentile','$outof','$points','subject','$dates','Point method Error','$batch_id')";
									$count8 = mysql_query($sql_insert8) or die(mysql_error()); 
					
					
				}// Point method error
				
				
				
				
							}
							else
						{
							$sql_insert8="INSERT INTO `error_import_student_points` 
								(school_id,sc_teacher_id,sc_stud_id,sc_entites_id,sc_studentpointlist_id,method,judgement,marks,grade,percentile,outof,points,activity_type,point_date,error_code,batch_no) values('$sc_id','$t_id','$std_PRN','103','$subject_code','$method','$judgement','$marks','$grade','$percentile','$outof','$points','subject','$dates','Subject Not Found','$batch_id')";
									$count8 = mysql_query($sql_insert8) or die(mysql_error()); 	
							
						}
				
						}//student PRN not null
						
						else
						{
							$sql_insert8="INSERT INTO `error_import_student_points` 
								(school_id,sc_teacher_id,sc_stud_id,sc_entites_id,sc_studentpointlist_id,method,judgement,marks,grade,percentile,outof,points,activity_type,point_date,error_code,batch_no) values('$sc_id','$t_id','$std_PRN','103','$subject_code','$method','$judgement','$marks','$grade','$percentile','$outof','$points','subject','$dates','Student Not Found','$batch_id')";
									$count8 = mysql_query($sql_insert8) or die(mysql_error()); 	
							
						}
						
					}// Teacher ID not Null
					
					
					else
					{
					$sql_insert8="INSERT INTO `error_import_student_points` 
								(school_id,sc_teacher_id,sc_stud_id,sc_entites_id,sc_studentpointlist_id,method,judgement,marks,grade,percentile,outof,points,activity_type,point_date,error_code,batch_no) values('$sc_id','$t_id','$std_PRN','103','$subject_code','$method','$judgement','$marks','$grade','$percentile','$outof','$points','subject','$dates','Teacher Not Found','$batch_id')";
									$count8 = mysql_query($sql_insert8) or die(mysql_error()); 	
						
					}
				
				
				
				}// School Not null
				else
				{
						$sql_insert8="INSERT INTO `error_import_student_points` 
								(school_id,sc_teacher_id,sc_stud_id,sc_entites_id,sc_studentpointlist_id,method,judgement,marks,grade,percentile,outof,points,activity_type,point_date,error_code,batch_no) values('$sc_id','$t_id','$std_PRN','103','$subject_code','$method','$judgement','$marks','$grade','$percentile','$outof','$points','subject','$dates','School Not Found','$batch_id')";
									$count8 = mysql_query($sql_insert8) or die(mysql_error()); 
					
				}
				
							
							
			}// For loop ended
			
		$sql3=mysql_query("select id from import_student_points where batch_no='$batch_id' and sc_teacher_id='$t_id'");
		$count3=mysql_num_rows($sql3);
		
		$sql4=mysql_query("select id from error_import_student_points where batch_no='$batch_id' and sc_teacher_id='$t_id'");
		$count4=mysql_num_rows($sql4);
		
	
		$sql5=mysql_query("update tbl_Batch_Master set num_records_uploaded='$DataCount' ,num_errors_records='$count4', num_correct_records='$count3',display_table_name='Bulk student points',db_table_name='import_student_points' where batch_id='$batch_id' and school_id='$school_id' and uploaded_by='$t_id'");	
		
		$sql6=mysql_query("select id from tbl_Batch_Master where school_id='$school_id' and batch_id='$batch_id' and uploaded_by='$t_id'");
		$result6=mysql_fetch_array($sql6);
		
					
				
		
		
		header('Location: display_inserted_records.php?id='.$result6['id'].'');		
	
	}// for file upload
	
	else
	{
		$report="Please select File ";
	}

	


}// Submit
														

?>









<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//js/jquery-1.10.2.js"></script>
  <script src="//js/jquery-ui.js"></script>



</head>

<body >
<div class='container' style="padding-top:30px;padding-left:30px;">
    
 
          <?php
          
		  $sql_query=mysql_query("SELECT distinct st.subjcet_code,st.`subjectName` FROM `tbl_teacher_subject_master` st inner join tbl_academic_Year Y on st.AcademicYear=Y.Year and Y.Enable='1'  WHERE st.`teacher_id` ='$t_id' and st.school_id='$school_id'");
		  
		  
		  ?>
			
      <div class='panel-body' style="background:#CCC; border-color:#666; ">
   		<form name='frm' method='post' enctype='multipart/form-data' id='frm'>
                                
                            <div class="row" style="margin-top:5%;" align="center">          
                            <h3>Upload student marks list</h3>
                                                      </div>       
          
                          <div class="row" style="margin-top:5%;" align="center">          
                            <input type='file' name='file'  id='file' onChange="ValidateSingleInput(this);" />                          </div>
                            <div class="row" style="margin-top:4%;" align="center">
                    
                
                                  <input class='btn btn-primary' type='submit' value="Submit" name="submit" />
                               
                                  <button class='btn btn-danger'  type='submit'>Cancel</button>
                                  
                                  </div>
                                
                                  <div class="row" style="color:red; margin-top:2%;" align="center"> <?php echo $report;?></div>
                 
         </form>
           <div class="row" style="color:red; margin-top:2%;" align="center"> <?php 
		   if(isset($_GET['report']))
		   {
		   echo $_GET['report'];
		   
		   
		    }
		   ?></div>
		 
		 
		 
		 
         
         <div class="row" ><center><a href="download_bulk_recordsreport.php?id=<?php echo "1".",".$t_id.",".$school_id.","."D";?>">Download Teacher upload student marks sheet format</a></center></div>
		 
		 
	</div>
	  
	
</div>








</body>

</html>
