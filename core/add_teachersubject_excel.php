<?php
include("scadmin_header.php");
 include("smartcookiefunction.php");

$report="";
$id=$_SESSION['id'];
		$query="select * from `tbl_school_admin` where id='$id'";       // uploaded by
		$row=mysql_query($query);
		$value=mysql_fetch_array($row);
		$uploaded_by=$value['name'];
		$school_id=$value['school_id'];
		$school_name=$value['school_name'];
		
		if ( isset($_POST["submit"]) ) 
{
	
    if ( !empty($_FILES["file"]["name"])) 
	{
		
		$scan=$_POST['scan'];
		
			$sql2=mysql_query("select batch_id from tbl_Batch_Master where school_id='$school_id' and entity='School_Admin' and uploaded_by like '$uploaded_by' order by id desc");
			$resultsql=mysql_fetch_array($sql2);
			$count=mysql_num_rows($sql2);	 
		   $date1=date('Y-m-d h:i:s',strtotime('+330 minute'));
		   $t_date = date('d/m/Y');
					 if($count=="")
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
		   $file_t1=explode(".", $storagename);	
		$file_type1=$file_t1[1];
	
		  $sql3=mysql_query("insert into tbl_Batch_Master (batch_id,input_file_name,uploaded_date_time,uploaded_by,entity,school_id)values('$batch_id','$storagename','$date1','$uploaded_by','School_Admin','$school_id') ");
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
				$total_records=$arrayCount-1;
				$DataCount = $arrayCount;		
							
				$limit=$_POST['limit'];
				
				$new_limit=min($limit,$DataCount);
				
				$arr=array();
				$smartcookiefunctions=new smartcookiefunctions();
				
				$count_existing_records=0;

				
				$count_correct_record=0;
				$error_duplicate=0;
				$error_dept=0;
				$error_branch=0;
				$error_semester=0;
				$error_div_name=0;
				$error_subject_name=0;
				$error_subject_code=0;
				$error_teacher_id=0;
				$error_school_id=0;
				$new_inserted_record=0;
				$update_data_count=0;
				
				$ij=0;
				$k=0;
				
		
				
				for($i=2;$i<=$new_limit;$i++)
				{
				$sc_id = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
				
				if(trim($school_id)==trim($sc_id))
				{
			
				$t_id=str_replace("'","", trim($allDataInSheet[$i]["B"]));   // t_id
				$subject_code=str_replace("'","", trim($allDataInSheet[$i]["C"]));  // Employee name
				$subject_name=str_replace("'","", trim($allDataInSheet[$i]["D"]));   // mobile
				
				$ExtSchoolSubjectId=str_replace("'","", trim($allDataInSheet[$i]["E"])); 
				$ExtSemesterId=str_replace("'","", trim($allDataInSheet[$i]["F"])); 
				$ExtBranchId=str_replace("'","", trim($allDataInSheet[$i]["G"])); 
				$ExtYearID=str_replace("'","", trim($allDataInSheet[$i]["H"])); 
				$ExtDivisionID=str_replace("'","", trim($allDataInSheet[$i]["I"])); 
				
				
				$division=str_replace("'","", trim($allDataInSheet[$i]["J"]));  // Dept. Name
				$semester=str_replace("'","", trim($allDataInSheet[$i]["K"]));  // Gender
				$branch=str_replace("'","", trim($allDataInSheet[$i]["L"]));  // Email ID
				$ExtDeptId=str_replace("'","", trim($allDataInSheet[$i]["M"])); //country
				$courselevel=str_replace("'","", trim($allDataInSheet[$i]["N"])); //t_address
				$academic_year=str_replace("'","", trim($allDataInSheet[$i]["O"]));  // T_DOB
				
			
			
				  $sql=mysql_query("select t_id from tbl_teacher where t_id='$t_id' and school_id='$school_id'");
				  $count_tid=mysql_num_rows($sql);
				  
				  
				   $sql2=mysql_query("select Subject_Code,subject from `tbl_school_subject` where Subject_Code='$subject_code' and school_id='$school_id'");
				  $count_sub=mysql_num_rows($sql2);
				  
				    $sql3=mysql_query("select DivisionName from Division where ExtDivisionID=$ExtDivisionID and school_id='$school_id'");
				  $count_div=mysql_num_rows($sql3);
				  $sql_div=mysql_fetch_array($sql3);
				   $division=$sql_div['DivisionName'];
				  
				  
				    $sql4=mysql_query("select Semester_Name from tbl_semester_master where Semester_Name='$semester' and school_id='$school_id'");
				  $count_sem=mysql_num_rows($sql4);
				  
				  
				    $sql5=mysql_query("select id from tbl_branch_master where branch_Name='$branch' and school_id='$school_id'");
				  $count_branch=mysql_num_rows($sql5);
				  
				
				    $sql6=mysql_query("select * from tbl_department_master where Dept_code='$ExtDeptId' and school_id='$school_id'");
				  $count_dept=mysql_num_rows($sql6);
				  
				  $result_sql=mysql_fetch_array($sql6);
				  $department=$result_sql['Dept_Name'];
				 
				  
				  
						if($t_id!="" && ($count_tid!=0))
						{
						
									if($subject_code!="" && ($count_sub!=0))
									{
											
											if($subject_name!='' && ($count_sub!=0))
											
											{
																					
											if($division!='' && ($count_div!=0))
											{
												
												if($semester!='' && ($count_sem!=0))
												{
													if($branch!='' && ($count_branch!=0))
													{
									
														if($department!='' && ($count_dept!=0))
													{
							
							
$sql1=mysql_query("select * from  tbl_teachr_subject_row where
 school_id='$school_id' and teacher_id='$t_id' and subjcet_code='$subject_code' and ExtSemesterId='$ExtSemesterId' and ExtBranchId='$ExtBranchId' and ExtSchoolSubjectId='$ExtSchoolSubjectId' and ExtYearID='$ExtYearID' and ExtDivisionID='$ExtDivisionID' and ExtDeptId='$ExtDeptId' and subjectName like '$subject_name' and Division_id='$division' and Semester_id='$semester' 
 and Branches_id='$branch' and Department_id='$department'  
 and AcademicYear='$academic_year' and CourseLevel='$courselevel' and batch_id='$batch_id'");
							$result1=mysql_fetch_array($sql1);
							$count1=mysql_num_rows($sql1);
										
														if($count1==0)
														{
															
															$count_correct_record++;
															$err_flag="Correct";
																$results=$smartcookiefunctions->teacher_subject_raw($ExtSemesterId,$ExtBranchId,$ExtSchoolSubjectId,$ExtYearID,$ExtDivisionID,$ExtDeptId,$sc_id,$t_id,$subject_code,$subject_name,$division,$semester,$branch,$department,$courselevel,$academic_year,$err_flag,$date1,$uploaded_by,$batch_id);
														}
														
														else
														{
															
															
															$error_duplicate++;
															
															$err_flag="Duplicate";
																$results=$smartcookiefunctions->teacher_subject_raw($ExtSemesterId,$ExtBranchId,$ExtSchoolSubjectId,$ExtYearID,$ExtDivisionID,$ExtDeptId,$sc_id,$t_id,$subject_code,$subject_name,$division,$semester,$branch,$department,$courselevel,$academic_year,$err_flag,$date1,$uploaded_by,$batch_id);
															
														}
														
													}
													else
													{
														$error_dept++;
														$results=$smartcookiefunctions->teacher_subject_raw($ExtSemesterId,$ExtBranchId,$ExtSchoolSubjectId,$ExtYearID,$ExtDivisionID,$ExtDeptId,$sc_id,$t_id,$subject_code,$subject_name,$division,$semester,$branch,$department,$courselevel,$academic_year,$err_flag,$date1,$uploaded_by,$batch_id);
														
														
													}
														
													}
													else
													{
														
														$error_branch++;
										$err_flag="Error_Branch";
											$results=$smartcookiefunctions->teacher_subject_raw($ExtSemesterId,$ExtBranchId,$ExtSchoolSubjectId,$ExtYearID,$ExtDivisionID,$ExtDeptId,$sc_id,$t_id,$subject_code,$subject_name,$division,$semester,$branch,$department,$courselevel,$academic_year,$err_flag,$date1,$uploaded_by,$batch_id);
														
													}
														
														
												}
												
												else
												{
													$error_semester++;
										$err_flag="Error_Semester";
											$results=$smartcookiefunctions->teacher_subject_raw($ExtSemesterId,$ExtBranchId,$ExtSchoolSubjectId,$ExtYearID,$ExtDivisionID,$ExtDeptId,$sc_id,$t_id,$subject_code,$subject_name,$division,$semester,$branch,$department,$courselevel,$academic_year,$err_flag,$date1,$uploaded_by,$batch_id);
													
													
												}
														
														
											}
											else
											{
												
												$error_div_name++;
										$err_flag="Division Not found";
										$results=$smartcookiefunctions->teacher_subject_raw($ExtSemesterId,$ExtBranchId,$ExtSchoolSubjectId,$ExtYearID,$ExtDivisionID,$ExtDeptId,$sc_id,$t_id,$subject_code,$subject_name,$division,$semester,$branch,$department,$courselevel,$academic_year,$err_flag,$date1,$uploaded_by,$batch_id);
												
												
											}
														
														
											
														
														
										}
										
										else
										{
											$error_subject_name++;
										$err_flag="Error_Subject_Name";
											$results=$smartcookiefunctions->teacher_subject_raw($ExtSemesterId,$ExtBranchId,$ExtSchoolSubjectId,$ExtYearID,$ExtDivisionID,$ExtDeptId,$sc_id,$t_id,$subject_code,$subject_name,$division,$semester,$branch,$department,$courselevel,$academic_year,$err_flag,$date1,$uploaded_by,$batch_id);
											
										}
										
										
										
																				
															
									}
									else
									{
										$error_subject_code++;
									$err_flag="Err_subject_Code";
									$results=$smartcookiefunctions->teacher_subject_raw($ExtSemesterId,$ExtBranchId,$ExtSchoolSubjectId,$ExtYearID,$ExtDivisionID,$ExtDeptId,$sc_id,$t_id,$subject_code,$subject_name,$division,$semester,$branch,$department,$courselevel,$academic_year,$err_flag,$date1,$uploaded_by,$batch_id);
										
									}
								
						}//Teacher ID
						
						else
						{
						
						$error_teacher_id++;
							$err_flag="Err_teacher_ID";
						$results=$smartcookiefunctions->teacher_subject_raw($ExtSemesterId,$ExtBranchId,$ExtSchoolSubjectId,$ExtYearID,$ExtDivisionID,$ExtDeptId,$sc_id,$t_id,$subject_code,$subject_name,$division,$semester,$branch,$department,$courselevel,$academic_year,$err_flag,$date1,$uploaded_by,$batch_id);
						
						}
						
							
				}//School ID
				
				
				else
				{
					$error_school_id++;
					
					$err_flag="Err-SCID";
				$results=$smartcookiefunctions->teacher_subject_raw($ExtSemesterId,$ExtBranchId,$ExtSchoolSubjectId,$ExtYearID,$ExtDivisionID,$ExtDeptId,$sc_id,$t_id,$subject_code,$subject_name,$division,$semester,$branch,$department,$courselevel,$academic_year,$err_flag,$date1,$uploaded_by,$batch_id);
					
				}
				
				
				}
				//Insert into raw table
				//echo "select * from tbl_teachr_subject_row where school_id='$school_id' and batch_id='$batch_id' and status='Correct'";
				
				$sql_query1=mysql_query("select * from tbl_teachr_subject_row where school_id='$school_id' and batch_id='$batch_id' and status='Correct'");
				
				
				while($result_query=mysql_fetch_array($sql_query1))
				{
					
				$ExtSemesterId=$result_query['ExtSemesterId'];
				$ExtBranchId=$result_query['ExtBranchId'];
				$ExtSchoolSubjectId=$result_query['ExtSchoolSubjectId'];
				$ExtYearID=$result_query['ExtYearID'];
				$ExtDivisionID=$result_query['ExtDivisionID'];
				$ExtDeptId=$result_query['ExtDeptId'];
				
				$teacherID=$result_query['teacher_id'];
				$school_id=$result_query['school_id'];
				$subjcet_code=$result_query['subjcet_code'];
				$subjectName=$result_query['subjectName'];
				$Division_id=$result_query['Division_id'];
				$Semester_id=$result_query['Semester_id'];
				$Branches_id=$result_query['Branches_id'];
				$Department_id=$result_query['Department_id'];
				$CourseLevel=$result_query['CourseLevel'];
				$AcademicYear=$result_query['AcademicYear'];
				$batch_id=$result_query['batch_id'];
				
				

	$sql_search=mysql_query("select * from tbl_teacher_subject_master where ExtSemesterId='$ExtSemesterId' and ExtBranchId='$ExtBranchId' and ExtSchoolSubjectId='$ExtSchoolSubjectId' and ExtYearID='$ExtYearID' and ExtDivisionID='$ExtDivisionID' and ExtDeptId='$ExtDeptId' and school_id='$school_id' and teacher_id='$teacherID' and subjcet_code='$subjcet_code' and subjectName='$subjectName' and Division_id='$Division_id' and Semester_id='$Semester_id' and Branches_id='$Branches_id' and Department_id='$Department_id' and CourseLevel='$CourseLevel' and AcademicYear='$AcademicYear'");
				$result3=mysql_fetch_array($sql_search);
				$count3=mysql_num_rows($sql_search);
				
				
				if($count3==0)
				{
					
							
								if($scan=="0")
								{
									
									$new_inserted_record++;
									
									
									
								}
								if($scan=="1")
															
								{
									$new_inserted_record++;	
									
						$results=$smartcookiefunctions->teachersubject_register($ExtSemesterId,$ExtBranchId,$ExtSchoolSubjectId,$ExtYearID,$ExtDivisionID,$ExtDeptId,$school_id,$teacherID,$subjcet_code,$subjectName,$Division_id,$Semester_id,$Branches_id,$Department_id,$CourseLevel,$AcademicYear,$batch_id,$date1,$uploaded_by);
									
									
								
								}
				
				
				
															 
				}
				else
				{
					$count_existing_records++;
					
					
								$update_str="Update  tbl_teacher_subject_master";
								
								$update_str2="";
							
								
								
								if(!empty($ExtSemesterId))
								{
										if($result3['ExtSemesterId']!=$ExtSemesterId)
										{
											
											$update_str2.=" ExtSemesterId='$ExtSemesterId',";
											
										}
								}
								
								if(!empty($ExtBranchId))
								{
										if($result3['ExtBranchId']!=$ExtBranchId)
										{
											
											$update_str2.=" ExtBranchId='$ExtBranchId',";
											
										}
								}
								
								
								if(!empty($ExtSchoolSubjectId))
								{
										if($result3['ExtSchoolSubjectId']!=$ExtSchoolSubjectId)
										{
											
											$update_str2.=" ExtSchoolSubjectId='$ExtSchoolSubjectId',";
											
										}
								}
								
								
								if(!empty($ExtYearID))
								{
										if($result3['ExtYearID']!=$ExtYearID)
										{
											
											$update_str2.=" ExtYearID='$ExtYearID',";
											
										}
								}
								
								if(!empty($ExtDivisionID))
								{
										if($result3['ExtDivisionID']!=$ExtDivisionID)
										{
											
											$update_str2.=" ExtDivisionID='$ExtDivisionID',";
											
										}
								}
								
								
								if(!empty($ExtDeptId))
								{
										if($result3['ExtDeptId']!=$ExtDeptId)
										{
											
											$update_str2.=" ExtDeptId='$ExtDeptId',";
											
										}
								}
								
								
							
									if(!empty($subjcet_code))
								{
										if($result3['subjcet_code']!=$subjcet_code)
										{
											
											$update_str2.=" subjcet_code='$subjcet_code',";
											
										}
								}
								
								
									if(!empty($subjectName))
								{
										if($result3['subjectName']!=$subjectName)
										{
											
											$update_str2.=" subjectName='$subjectName',";
											
										}
								}
								
								
								
								
								if(!empty($Division_id))
								{
										if($result3['Division_id']!=$Division_id)
										{
											
											$update_str2.=" Division_id='$Division_id',";
											
										}
								}
								
								
								if(!empty($Semester_id))
								{
										if($result3['Semester_id']!=$Semester_id)
										{
											
											$update_str2.=" Semester_id='$Semester_id',";
											
										}
								}
								
								
								
								
								if(!empty($Branches_id))
								{
										if($result3['Branches_id']!=$Branches_id)
										{
											
											$update_str2.=" Branches_id='$Branches_id',";
											
										}
								}
								
								
								if(!empty($Department_id))
								{
										if($result3['Department_id']!=$Department_id)
										{
											
											$update_str2.=" Department_id='$Department_id',";
											
										}
								}
								
							
								if(!empty($CourseLevel))
								{
										if($result3['CourseLevel']!=$CourseLevel)
										{
											
											$update_str2.=" CourseLevel='$CourseLevel',";
											
										}
								}
								
								
								if(!empty($AcademicYear))
								{
										if($result3['AcademicYear']!=$AcademicYear)
										{
											
											$update_str2.=" AcademicYear='$AcademicYear',";
											
										}
								}
								
								
								
								
											if($update_str2!='')
													{		
								
															if($scan=="0")
															{
																
															$update_data_count++;
															
																
																
															}
															if($scan=="1")
															{
																
																$update_str=$update_str." set".$update_str2;
																		
																			//$update_str=chop($update_str,",");
																			// $operation_status="Updated";
																				$update_data_count++;	  
														$update_str.=" batch_id='$batch_id' where teacher_id='$teacherID' and school_id='$school_id' ";	
																	
																																	
																		$update_query=mysql_query($update_str);
																		 
																		
																		 $report="Records updated successfully.";
																
															}
															
																
													}
													
													
					
					
				}//Data updation
				
				}//While loop
				
				
				
				$error_records=$error_dept+$error_branch+$error_semester+$error_div_name+$error_subject_code+$error_subject_name+$error_teacher_id+$error_school_id;
				
			
				$sql5=mysql_query("update tbl_Batch_Master set num_records_uploaded='$total_records' , num_duplicates_record='$error_duplicate',num_correct_records='$count_correct_record',num_records_updated='$update_data_count',existing_records='$count_existing_records',num_newrecords_inserted='$new_inserted_record',num_errors_records='$error_records',display_table_name='Teacher Subject',db_table_name='tbl_teacher_subject_master' where batch_id='$batch_id' and school_id='$school_id' and uploaded_by='$uploaded_by'");	
				
				$sql6=mysql_query("select id from tbl_Batch_Master where school_id='$school_id' and batch_id='$batch_id' and uploaded_by='$uploaded_by' order by id desc");
		$result6=mysql_fetch_array($sql6);
				
				if($scan=="0")
				{
					
					
			header('Location: display_teacher_records.php?id='.$result6['id'].'');	
					
								
				}
		 
		if($scan=="1")
		 {
			 
			 
			 		
		header('Location: Display_tecahersheet_records.php?id='.$result6['id'].'');	
			
			 
		 }
		 
		 
		 
		 
		 
		 
		 
		 
		 
		
		
		
		
		
	}// File
	
	else
	{
		$report="Please select file";
	}
	
	
	}//Submit button
		
		
		
		
		


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Teacher Excelsheet</title>


<script type="text/javascript">

   
   var _validFileExtensions = [".xlsx", ".xls", ".xlsm", ".xlw", ".xlsb",".xml",".xlt",".csv",".CSV"];    
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
		
		<script>
			function formvalidation()
			{ 
			
				 var Record = document.getElementById("limit");

				  if(Record.value == "20")
				  {
				document.getElementById('errorRecord').innerHTML='Select Your Limit';
				  //alert('Select your limit');
				  
				  return false;
				  }
				  
			}
			</script>
</head>

<body>

<div class='container' style="padding-top:30px;padding-left:30px;">
    <div class='panel panel-primary dialog-panel'>
  
                      <div class='panel-heading'>
                         
                            <h3 align="center">Add Teacher Subjects Excel Sheet</h3>
                        
                        
                           
                          </div>
			
			<form name='frm' method='post' enctype='multipart/form-data' id='frm'>
     
      <div class='panel-body' style="background:lightgrey; box-shadow: 0 0 10px 10px black;">
   		
        
					
          
                  <div class="row" style="padding-top:20px;" align="center">
				  <div class="assignlimit">
                                
                                        
                                        	<select name="limit" class="limitofuploadingrecords" id="limit" style="width:20%; height:30px; border-radius:2px;">
                                              <option value="20" disabled selected="">Set upload Records Limit</option>
											  <option value="1">1</option>
											  <option value="50">50</option>
											  <option value="100">100</option>
											  <option value="200">200</option>
											  <option value="400">400</option>
											  <option value="500">500</option>
											  
											  <option value="800">800</option>
											  <option value="1000">1000</option>
											  <option value="1500">1500</option>
											  <option value="2000">2000</option>
											   <option value="3000">3000</option>
                                                <option value="3500">3500</option>
											 
											  </select>
										
                                              	<div class='form-group' id="errorRecord" style="color:#FF0000"></div>							
											</div>
                                            </div>
											
                  		
                    <div class='row' style="padding-top:30px;">
                   <div class="col-md-4" style="margin-right : 10px"></div>
                   <div class="col-md-2"><strong>Select File</strong></div>
                        <div class="col-md-5">
                            <input type='file' name='file'  id='file' size='30' onChange="ValidateSingleInput(this);" style="width:100%; height:30px; border-radius:2px;"/>            </div>              
                    </div>
                 
                 <div class="row" style="padding-top:20px;">
                 <div class="col-md-4"></div>
                 <div class="col-md-2"><input type="radio" name="scan" id="scan" value="0"  /> <b>Scan Only</b></div>
                 <div class="col-md-2"><input type="radio" name="scan" id="scan" value="1" checked="checked"  /><b> Scan and Upload</b></div>
                 </div>
                 
                 
                 
                 
                 <div class="row" style="padding-top:40px;">
                 
                 <div class="col-md-5"></div>
                <div class="col-md-1">   <input class='btn btn-primary' type='submit' value="Submit" name="submit" onclick="return formvalidation();" /></div>
                 
                 
                   <div class="col-md-1"><a href="Add_teacher_subject.php"><input class='btn btn-danger'  type='button' value="Back" /></a></div>         
                 
                 </div>
                
                <div class="row" style="color:#F00;padding-top:20px;" align="center"><b><?php echo $report;?></b></div>
                
                              
                                    </div>
                               
                 
         </form>
		 
		 
		 
		
		 
	</div>
	  
	
</div>







</body>
</html>