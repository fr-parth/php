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
				
				$error_student_prn=0;
				$error_teacher_id=0;
				$error_school_id=0;
				$error_duplicate=0;
				$new_inserted_record=0;
				$update_data_count=0;
				$existing_records=0;
				$count_correct_record=0;
				$error_subject_code=0;
				
		
				
				for($i=2;$i<=$new_limit;$i++)
				{
				$sc_id = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue();
				
				if(trim($school_id)==trim($sc_id))
				{
				
				$std_PRN=str_replace("'","", trim($allDataInSheet[$i]["A"]));   // student PRN
				$subject_code=str_replace("'","", trim($allDataInSheet[$i]["C"]));  // Employee name
				$subject_name=str_replace("'","", trim($allDataInSheet[$i]["D"]));   // mobile
				$division_id=str_replace("'","", trim($allDataInSheet[$i]["E"]));  // Dept. Name
				$semester_id=str_replace("'","", trim($allDataInSheet[$i]["F"]));  // Gender
				$branch_id=str_replace("'","", trim($allDataInSheet[$i]["G"]));  // Email ID
				$department=str_replace("'","", trim($allDataInSheet[$i]["H"])); //country
				$courselevel=str_replace("'","", trim($allDataInSheet[$i]["I"])); //t_address
				$academic_year=str_replace("'","", trim($allDataInSheet[$i]["J"]));  // T_DOB
				$teacher_id=str_replace("'","", trim($allDataInSheet[$i]["K"])); //t_internal Email
				
				
			
				  $sql=mysql_query("select std_PRN from tbl_student where std_PRN='$std_PRN' and school_id='$school_id'");
				  $count_PRN=mysql_num_rows($sql);
				  
				   $sql2=mysql_query("select t_id from tbl_teacher where t_id='$teacher_id' and school_id='$school_id'");
				  $count_tid=mysql_num_rows($sql2);
				  
				   $sql3=mysql_query("select Subject_Code from tbl_school_subject where Subject_Code='$subject_code' and school_id='$school_id'");
				  $count_subject=mysql_num_rows($sql3);
				  
						if($std_PRN!="" && ($count_PRN==1))
						{
						
									if($teacher_id!="" && ($count_tid==1))
									{
										
										if($subject_code!='' &&($count_subject!=0))
										
										{
							$sql1=mysql_query("select * from tbl_student_subject where school_id='$school_id' and batch_id='$batch_id'");
							$result1=mysql_fetch_array($sql1);
							$count1=mysql_num_rows($sql1);
										
														if($count1==0)
														{
															
															$count_correct_record++;
															$err_flag="Correct";
																$results=$smartcookiefunctions->studentsubject_raw_register($std_PRN,$teacher_id,$school_id,$subjcet_code,$subject_name,$division_id,$semester_id,$branch_id,$department,$courselevel,$academic_year,$err_flag,$date1,$uploaded_by,$batch_id);
														}
														
														else
														{
															$error_duplicate++;
															
															$err_flag="Correct";
																$results=$smartcookiefunctions->studentsubject_raw_register($std_PRN,$teacher_id,$school_id,$subjcet_code,$subject_name,$division_id,$semester_id,$branch_id,$department,$courselevel,$academic_year,$err_flag,$date1,$uploaded_by,$batch_id);
															
														}
														
										}
										
										else
										{
											$error_subject_code++;
										$err_flag="Subject_Code";
											$results=$smartcookiefunctions->studentsubject_raw_register($std_PRN,$teacher_id,$school_id,$subjcet_code,$subject_name,$division_id,$semester_id,$branch_id,$department,$courselevel,$academic_year,$err_flag,$date1,$uploaded_by,$batch_id);
											
										}
										
										
										
																				
															
									}
									else
									{
										$error_teacher_id++;
									$err_flag="Err-TeacherID";
									$results=$smartcookiefunctions->studentsubject_raw_register($std_PRN,$teacher_id,$school_id,$subjcet_code,$subject_name,$division_id,$semester_id,$branch_id,$department,$courselevel,$academic_year,$err_flag,$date1,$uploaded_by,$batch_id);
										
									}
								
						}//Teacher ID
						
						else
						{
						
						$error_student_prn++;
							$err_flag="Err-Std-PRN";
						$results=$smartcookiefunctions->studentsubject_raw_register($std_PRN,$teacher_id,$school_id,$subjcet_code,$subject_name,$division_id,$semester_id,$branch_id,$department,$courselevel,$academic_year,$err_flag,$date1,$uploaded_by,$batch_id);
						
						}
						
							
				}//School ID
				
				
				else
				{
					$error_school_id++;
					
					$err_flag="Err-SCID";
					$results=$smartcookiefunctions->studentsubject_raw_register($std_PRN,$teacher_id,$school_id,$subjcet_code,$subject_name,$division_id,$semester_id,$branch_id,$department,$courselevel,$academic_year,$err_flag,$date1,$uploaded_by,$batch_id);
					
				}
				
				//Insert into raw table
				
				
				$sql_query1=mysql_query("select * from tbl_student_subject where school_id='$school_id' and batch_id='$batch_id' and error_records='Correct' ");
				$scan=$_POST['scan'];
				
				while($result_query=mysql_fetch_array($sql_query1))
				{
			
				$student_id=$result_query['student_id'];
				$teacher_ID=$result_query['teacher_ID'];
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
				
			
				$sql3=mysql_query("select * from tbl_student_subject_master where school_id='$school_id' and teacher_ID='$teacher_ID' and subjcet_code='$subjcet_code' and student_id='$student_id' and AcademicYear='$AcademicYear'");
				$result3=mysql_fetch_array($sql3);
				$count3=mysql_num_rows($sql3);
				
				
				if($count3==0)
				{
					
							
								if($scan=="0")
								{
									
									$new_inserted_record++;
									
									
									
								}
								if($scan=="1")
															
								{
									
									
						$results=$smartcookiefunctions->studentsubject_register($student_id,$teacher_ID,$school_id,$subjcet_code,$subjectName,$Division_id,$Semester_id,$Branches_id,$Department_id,$CourseLevel,$AcademicYear,$batch_id,$date1,$uploaded_by);
									
									
								$new_inserted_record++;	
								}
				
				
				
															 
				}
				else
				{
					$existing_records++;
					
								$update_str="Update  tbl_student_subject_master";
								
								$update_str2="";
								if(!empty($teacher_first_name))
								{
										if($result3['t_name']!=$teacher_first_name)
										{
											
											$update_str2.=" t_name='$teacher_first_name',";
											
										}
								}
								
								if(!empty($teacher_middle_name))
								{
										if($result3['t_middlename']!=$teacher_middle_name)
										{
											
											$update_str2.=" t_middlename='$teacher_middle_name',";
											
										}
								}
								
								
								if(!empty($teacher_last_name))
								{
										if($result3['t_lastname']!=$teacher_last_name)
										{
											
											$update_str2.=" t_lastname='$teacher_last_name',";
											
										}
								}
								
								
								
								if(!empty($t_dept))
								{
										if($result3['t_dept']!=$t_dept)
										{
											
											$update_str2.=" t_dept='$t_dept',";
											
										}
								}
								
								
									if(!empty($t_phone))
								{
										if($result3['t_phone']!=$t_phone)
										{
											
											$update_str2.=" t_phone='$t_phone',";
											
										}
								}
								
								
									if(!empty($t_gender))
								{
										if($result3['t_gender']!=$t_gender)
										{
											
											$update_str2.=" t_gender='$t_gender',";
											
										}
								}
								
								if($t_email!="")
								
								{
								if(empty($t_email) || $t_email=="NULL")
								{
									//$update_str2.=" t_email='$t_internal_email',";
									
								}
								
									else
								{
										if($result3['t_email']!=$t_email)
										{
											
											$update_str2.=" t_email='$t_email',";
											
										}
								}
								
								}
								
								if($t_internal_email!="")
								{
								
								
								if(!empty($t_internal_email))
								{
										if($result3['t_internal_email']!=$t_internal_email)
										{
											
											$update_str2.=" t_internal_email='$t_internal_email',";
											
										}
								}
								
								}
								
								
								if(!empty($t_country))
								{
										if($result3['t_country']!=$t_country)
										{
											
											$update_str2.=" t_country='$t_country',";
											
										}
								}
								
								
								if(!empty($t_address))
								{
										if($result3['t_address']!=$t_address)
										{
											
											$update_str2.=" t_address='$t_address',";
											
										}
								}
								
								
								
								
								if(!empty($t_dob))
								{
										if($result3['t_dob']!=$t_dob)
										{
											
											$update_str2.=" t_dob='$t_dob',";
											
										}
								}
								
								
								if(!empty($t_landline))
								{
										if($result3['t_landline']!=$t_landline)
										{
											
											$update_str2.=" t_landline='$t_landline',";
											
										}
								}
								
								
								if(!empty($t_date_of_appointment))
								{
										if($result3['t_date_of_appointment']!=$t_date_of_appointment)
										{
											
											$update_str2.=" t_date_of_appointment='$t_date_of_appointment',";
											
										}
								}
								
								
								if(!empty($t_emp_type_pid))
								{
										if($result3['t_emp_type_pid']!=$t_emp_type_pid)
										{
											
											$update_str2.=" t_emp_type_pid='$t_emp_type_pid',";
											
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
														$update_str.=" batch_id='$batch_id' where t_id='$t_id' and school_id='$school_id' ";	
																	
																																	
																		$update_query=mysql_query($update_str);
																		 
																		
																		 $report="Records updated successfully.";
																
															}
															
																
													}
					
					
				}//Data updation
				
				}//While loop
				
				}
				$error_records=$error_tecaher_id+$error_name+$error_school_id;
			
				$sql5=mysql_query("update tbl_Batch_Master set num_records_uploaded='$total_records' , num_duplicates_record='$error_duplicate',num_correct_records='$count_correct_record',num_records_updated='$update_data_count',existing_records='$existing_records',num_newrecords_inserted='$new_inserted_record',num_errors_records='$error_records',display_table_name='Bulk Student Subject Data',db_table_name='tbl_student_subject_master' where batch_id='$batch_id' and school_id='$school_id' and uploaded_by='$uploaded_by'");	
				
				$sql6=mysql_query("select id from tbl_Batch_Master where school_id='$school_id' and batch_id='$batch_id' and uploaded_by='$uploaded_by' order by id desc");
		$result6=mysql_fetch_array($sql6);
				
				if($scan=="0")
				{
					
					
			header('Location: display_teacher_records.php?id='.$result6['id'].'');	
					
								
				}
		 
		if($scan=="1")
		 {
			 
			 
			 		
			header('Location: Display_student_subject_sheet_records.php?id='.$result6['id'].'');	
			
			 
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
</head>

<body>

<div class='container' style="padding-top:30px;padding-left:30px;">
    <div class='panel panel-primary dialog-panel'>
  
                      <div class='panel-heading'>
                         
                            <h3>Upload Student Subject Excel Sheet</h3>
                        
                        
                           
                          </div>
			
			<form name='frm' method='post' enctype='multipart/form-data' id='frm'>
     
      <div class='panel-body' style="background:lightgrey; box-shadow: 0 0 10px 10px black;">
   		
        
					
          
                  <div class="row" style="padding-top:20px;" align="center">
				  <div class="assignlimit">
                                
                                        
                                        	<select name="limit" class="limitofuploadingrecords" id="limit" style="width:20%; height:30px; border-radius:2px;">
                                              <option value="20" disabled selected>Set upload Records Limit</option>
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
											   <option value="10000">10000</option>
											   <option value="60000">60000</option>
											 
											  </select>
										
                                              							
											</div>
                                            </div>
											
                  		
                    <div class='row' style="padding-top:30px;">
                   <div class="col-md-4"></div>
                   <div class="col-md-2"><strong>Select File</strong></div>
                        <div class="col-md-5">
                            <input type='file' name='file'  id='file' size='30'  style="width:20%; height:30px; border-radius:2px;"/>            </div>              
                    </div>
                 
                 <div class="row" style="padding-top:20px;">
                 <div class="col-md-4"></div>
                 <div class="col-md-2"><input type="radio" name="scan" id="scan" value="0"  /> <b>Scan Only</b></div>
                 <div class="col-md-2"><input type="radio" name="scan" id="scan" value="1" checked="checked"  /><b> Scan and Upload</b></div>
                 </div>
                 
                 
                 
                 
                 <div class="row" style="padding-top:40px;">
                 
                 <div class="col-md-5"></div>
                <div class="col-md-1">   <input class='btn btn-primary' type='submit' value="Submit" name="submit" /></div>
                 
                 
                   <div class="col-md-1"><button class='btn btn-danger'  type='submit'>Cancel</button></div>
                 
                 
                 </div>
                
                <div class="row" style="color:#F00;padding-top:20px;" align="center"><b><?php echo $report;?></b></div>
                
                              
                                    </div>
                               
                 
         </form>
		 
		 
		 
		
		 
	</div>
	  
	
</div>







</body>
</html>