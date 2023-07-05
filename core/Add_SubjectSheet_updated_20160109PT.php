<?php
error_reporting(0);
include("scadmin_header.php");
//include("error_function.php");
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
include("error_funtion.php");			
$uploadedStatus = 0;

if (isset($_POST["submit"]) )
{
	if (isset($_FILES["file"]))
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
		$count_of_insert="";
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
		$flag=$_POST['flag'];
		
		
		if($limit>0)
		{
			if($flag==1)
			{
							 //$path_3 =dirname(__FILE__);
							//echo $path_3;
		
				$insert=0; $list = array();
				try
				{
					//$file = fopen("C:\wamp\www\smartcookies\CSV\subject_error.csv","w+") or die("Unable to open file for output");
                     $file = fopen("/home/content/84/7121184/html/smartcookies/CSV/subject_error.csv","w+") or die("Unable to open file for output");
			        //$file = fopen("/home/content/84/7121184/html/tsmartcookie/CSV/subject_error.csv","w+") or die("Unable to open file for output");
					fwrite($file,$sn. "," . "School_id" . ", " . "Insert Count" . ", " . "Duplicate Count" . ", " . "Update Count" . ", " . "Wrong School ID Count" . "," . "Subject Error count" . ", " . "Validation count" ."," . "Refuse count" ."\n");
					for($i=2;$i<=$min;$i++)
					{
						$value = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
						$sch_lenght=strlen(trim(($value)));
						if(trim($school_id)==trim($value))
						{ 
	
							$arr[$i]["B"]=str_replace("'","",trim($allDataInSheet[$i]["B"]));  // Semester Name or ID
							$arr[$i]["C"]=str_replace("'","",trim($allDataInSheet[$i]["C"]));  // Subject code
							$arr[$i]["D"]=str_replace("'","",trim($allDataInSheet[$i]["D"]));  // subject title
							$arr[$i]["E"]=str_replace("'","",trim($allDataInSheet[$i]["E"]));  // Degree name
							$arr[$i]["F"]=str_replace("'","",trim($allDataInSheet[$i]["F"]));  // Subject Type 
							$arr[$i]["G"]=str_replace("'","",trim($allDataInSheet[$i]["G"]));  // Subject Short Name
							$arr[$i]["H"]=str_replace("'","",trim($allDataInSheet[$i]["H"]));  // Subject Credit
							$arr[$i]["I"]=str_replace("'","",trim($allDataInSheet[$i]["I"]));  // Course Level
																					 
							$semester_id=$arr[$i]["B"];			
							$semester_code=trim(($semester_id));
							
							
							$sub_code=trim($arr[$i]["C"]);                          // for subject code
							$subject_code=strlen(($sub_code));
							$a=preg_match('/^[A-Za-z0-9_-]+$/',$sub_code);
							
							$sub_title=$arr[$i]["D"];
							$b=preg_match("/[a-zA-Z'-]/",$sub_title);
							
							$degree_name=$arr[$i]["E"];			
							$degree_nm=trim(($degree_name));							
							$c=preg_match("/[a-zA-Z'-]/",$degree_nm);
							
							$subject_type=$arr[$i]["F"];
							$d=preg_match("/[a-zA-Z'-]/",$subject_type);
							
							$sub_type=trim(($subject_type));
							$e=preg_match("/[a-zA-Z'-]/",$sub_type);

							$sub_short_code=$arr[$i]["G"];
							$f=preg_match("/[a-zA-Z'-]/",$sub_short_code);
							
							$sub_credit=$arr[$i]["H"];
							$g=preg_match('/^[0-9]+$/', $sub_credit);	
							
							$course_lvl=$arr[$i]["I"];	
							$h=preg_match("/[a-zA-Z'-]/",$course_lvl);

								if(!empty($sub_code) || $subject_code>0)
								{
									$row=mysql_query("select * from `tbl_school_subject` where Subject_Code='$sub_code' and Subject_type='$sub_type'");
									if(mysql_num_rows($row)==0)
									{
										
												$list[$insert] = $sub_code;              
												++$insert;	                        // count of insert
										
																					   
									}	
									else
									{
							
										++$dup;   
								
									}	
								}else
								{
										++$sub_error;
								}		
								
								
											 
																						  
						}else
								{
									if(!empty($value) && $sch_lenght>0)        
										++$sch_id;               
								}
							
								if($a && $b && $c && $d && $e && $f && $g && $h)
								{							
									if(empty($semester_id) || empty($sub_code) || empty($sub_title) || empty($degree_name) || empty($subject_type) || empty($sub_short_code) || empty($sub_credit) || empty($course_lvl))
									{
															
																	
										 ++$validate;	    
									}
														
																	
								}else{
										  ++$not_validate;
									}
								
							
					}    // for loop closed
				
					fwrite($file,$sn. ", " . $school_id . ", " .$insert . "," . $dup. ", " .$dup. ", " .$sch_id. "," .$sub_error. ", " . $validate .  "," .$not_validate. "\n");
					$abc=$insert;
					$ep=$abc-1;
					while($ep>=0)
					{
						fwrite($file,$sn. ",". $sn. "," . $list[$ep] ."\n");
						$ep--;
					} 
		
					echo "<script type=text/javascript>alert('File has been scan successfully...'); window.location=''</script>";
				
				
				}  // try block closed
				catch (Exception $e) 
				{ 
					echo $e->errorMessage(); 
				} 	
					
											 	
					//fclose($file);	
				
			
			}
			
		
// --------------------------------- actual upload file code ---------------------------
			else
			{
	
				try
				{
					for($i=2;$i<=$min;$i++)
					{
						$value = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
						if(trim($school_id)==trim($value))
						{ 
	
							$arr[$i]["B"]=str_replace("'","",trim($allDataInSheet[$i]["B"]));  // Semester Name or ID
							$arr[$i]["C"]=str_replace("'","",trim($allDataInSheet[$i]["C"]));  // Subject code
							$arr[$i]["D"]=str_replace("'","",trim($allDataInSheet[$i]["D"]));  // subject title
							$arr[$i]["E"]=str_replace("'","",trim($allDataInSheet[$i]["E"]));  // Degree name
							$arr[$i]["F"]=str_replace("'","",trim($allDataInSheet[$i]["F"]));  // Subject Type 
							$arr[$i]["G"]=str_replace("'","",trim($allDataInSheet[$i]["G"]));  // Subject Short Name
							$arr[$i]["H"]=str_replace("'","",trim($allDataInSheet[$i]["H"]));  // Subject Credit
							$arr[$i]["I"]=str_replace("'","",trim($allDataInSheet[$i]["I"]));  // Course Level
																					 
							$sub_code=$arr[$i]["C"];                          // for subject code
							$subject_code=strlen(trim(($sub_code)));
							$semester_id=$arr[$i]["B"];			
							$semester_code=trim(($semester_id));	
							$subject_type=$arr[$i]["F"];			
							$sub_type=trim(($subject_type));	
							$degree_name=$arr[$i]["E"];			
							$degree_code=trim(($degree_name));	
							$sub_title=$arr[$i]["D"];
							$sub_short_name=$arr[$i]["G"];
							$sub_credit=$arr[$i]["H"];
							$sub_course_lvl=$arr[$i]["H"];
													 
							if(!empty($sub_code) || $subject_code>0)
							{
								$row=mysql_query("select * from `tbl_school_subject` where Subject_Code='$sub_code' and Subject_type='$sub_type' and school_id='$school_id'");
								if(mysql_num_rows($row)==0)
								{
									$sql_insert1="INSERT INTO `tbl_school_subject` (school_id,Subject_Code,Semester_id,subject,Degree_name,Uploaded_by,Subject_type,subject_credit,Course_Level_PID,Subject_short_name)
									VALUES ('$school_id','$sub_code','".$arr[$i]["B"]."','".$arr[$i]["D"]."','".$arr[$i]["E"]."','$uploaded_by','".$arr[$i]["F"]."','".$arr[$i]["H"]."','".$arr[$i]["I"]."','".$arr[$i]["G"]."')";		    
									$result_insert1 = mysql_query($sql_insert1) or die(mysql_error()); 
									$reports1="All Subjects are successfully Inserted...";
								}	
									
									
								else
								{
						
									$count_of_duplicates=++$c;
									$get_subject_info=mysql_query("select * from `tbl_school_subject` where Subject_Code='$sub_code' and Subject_type='$sub_type' and school_id='$school_id'");
									while($row2=mysql_fetch_array($get_subject_info))
									{


										$subject_sem_id=trim($row2['Semester_id']);
										$subject_codee=trim($row2['Subject_Code']);
										$subject_title=trim($row2['subject']);
										$subject_deg_nm=trim($row2['Degree_name']);
										$subject_typee=trim($row2['Subject_type']);
										$subject_sh_nm=trim($row2['Subject_short_name']);
										$subject_criditt=trim($row2['subject_credit']);
										$subject_course_pid=trim($row2['Course_Level_PID']);
										$sch_id1=trim($row2['school_id']);
									
									}	
									 if($semester_id==$subject_sem_id){}
								     else{if($subject_sem_id!=""){
											$update_semid="UPDATE `tbl_school_subject` SET Semester_id='$subject_sem_id' where Subject_Code='$sub_code' and Subject_type='$sub_type' and school_id='$school_id'";
											$update1= mysql_query($update_semid) or die('Could not update data: ' . mysql_error());
										}
									    }
									if($sub_code==$subject_codee){}
								     else{$sub_code_val=preg_match('/^[A-Za-z0-9_-]+$/',$subject_codee);
											if($sub_code_val || $subject_codee!=""){
											$update_sub_code="UPDATE `tbl_school_subject` SET Subject_Code='$subject_codee' where Subject_Code='$sub_code' and Subject_type='$sub_type' and school_id='$school_id'";
											$update2= mysql_query($update_sub_code) or die('Could not update data: ' . mysql_error());
										}
									    }
									if($sub_title==$subject_title){}
								     else{$sub_title_val=preg_match("/[a-zA-Z'-]/",$subject_title);
											if($sub_title_val || $subject_codee!=""){
											$update_sub_title="UPDATE `tbl_school_subject` SET subject='$subject_title' where Subject_Code='$sub_code' and Subject_type='$sub_type' and school_id='$school_id'";
											$update3= mysql_query($update_sub_title) or die('Could not update data: ' . mysql_error());
										}
									    }
									if($degree_name==$subject_deg_nm){}
								     else{$deg_nm_val=preg_match("/[a-zA-Z'-]/",$subject_deg_nm);
											if($deg_nm_val){
											$update_deg_name="UPDATE `tbl_school_subject` SET Degree_name='$subject_deg_nm' where Subject_Code='$sub_code' and Subject_type='$sub_type' and school_id='$school_id'";
											$update4= mysql_query($update_deg_name) or die('Could not update data: ' . mysql_error());
										}
									    }
									if($sub_type==$subject_typee){}
								     else{$sub_type_val=preg_match("/[a-zA-Z'-]/",$subject_typee);
											if($sub_type_val){
											$update_sub_type="UPDATE `tbl_school_subject` SET Subject_type='$subject_typee' where Subject_Code='$sub_code' and Subject_type='$sub_type' and school_id='$school_id'";
											$update5= mysql_query($update_sub_type) or die('Could not update data: ' . mysql_error());
										}
									    }
									if($sub_short_name==$subject_sh_nm){}
								     else{$sub_short_name_val=preg_match("/[a-zA-Z'-]/",$subject_sh_nm);
											if($sub_short_name_val){
											$update_short_nm="UPDATE `tbl_school_subject` SET Subject_short_name='$subject_sh_nm' where Subject_Code='$sub_code' and Subject_type='$sub_type' and school_id='$school_id'";
											$update6= mysql_query($update_short_nm) or die('Could not update data: ' . mysql_error());
										}
									    }
									if($sub_credit==$subject_criditt){}
								     else{$sub_credit_val=preg_match('/^[0-9]+$/',$subject_criditt);	
											if($sub_credit_val){
											$update_sub_credit="UPDATE `tbl_school_subject` SET subject_credit='$subject_criditt' where Subject_Code='$sub_code' and Subject_type='$sub_type' and school_id='$school_id'";
											$update7= mysql_query($update_sub_credit) or die('Could not update data: ' . mysql_error());
										}
									    }
									if($sub_course_lvl==$subject_course_pid){}
								     else{$sub_course_lvl_val=preg_match("/[a-zA-Z'-]/",$subject_course_pid);
											if($sub_course_lvl_val){
											$update_sub_credit="UPDATE `tbl_school_subject` SET Course_Level_PID='$subject_course_pid' where Subject_Code='$sub_code' and Subject_type='$sub_type' and school_id='$school_id'";
											$update8= mysql_query($update_sub_credit) or die('Could not update data: ' . mysql_error());
										}
									    }
									if($sch_id1==$value){}
								     else{$school_id_val=preg_match('/^[A-Za-z0-9_-]+$/',$value);
											if($school_id_val || $sch_id1!=""){
											$update_sub_credit="UPDATE `tbl_school_subject` SET school_id='$value' where Subject_Code='$sub_code' and Subject_type='$sub_type' and school_id='$school_id'";
											$update8= mysql_query($update_sub_credit) or die('Could not update data: ' . mysql_error());
										}
									    }
								
															
							
								}	
								if($result_insert1>=1)
									{ 
								
										 $sql_insert2="INSERT INTO `tbl_subjectdetails`(Subject_Code,Semester_ID)
										 VALUES ('$sub_code','".$arr[$i]["B"]."')";
														
										$result_insert2 = mysql_query($sql_insert2) or die(mysql_error()); 	
													   
									}	
							}	
							else
							{
									//$reports="Plz Specify Subject Code.";
									$report1="Please put Subject Code in your upload list. ";
							}				 
						} 
					}  		// closing of if row<0
				}
				catch (Exception $e) 
				{ 
					echo $e->errorMessage(); 
				} 
			}         // else closed
		}          // if limit>0 closed
			else
			{
				echo "<script type=text/javascript>alert('Plz select upload limit'); window.location=''</script>";
			}


	}   // else closed
    
		echo "<script type=text/javascript>alert('file is successfully added'); window.location=''</script>";
    }  // file closed
								
}  // submit closed
/* else
	{
	  
		 echo "<script type=text/javascript>alert('No file selected'); window.location=''</script>";	
	}		 */					
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">

   
   var _validFileExtensions = [".xlsx", ".xls", ".xlsm", ".xlw", ".xlsb",".xml",".xlt",".csv",".CSV"];    
function ValidateSingleInput(oInput) {
    if (oInput.type == "file") {
        var sFileName = oInput.value;
		alert(sFileName);
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
   <div style="color:red;font-size:15px;font-weight:bold;margin-top:8px;"> <?php if(isset($_GET['report'])){ echo $_GET['report']; };?></div>
          <div class='panel-heading'>
             
                <h3>Add Subject Excel Sheet</h3>
            
            
               
              </div>
			
			
      <div class='panel-body' style="background:lightgrey; box-shadow: 0 0 6px 6px black;">
   		<form name='frm' method='post' enctype='multipart/form-data' id='frm'>
        
                   <div class="row" style="margin-left: 500px;">
					<p><b>Scan Excel file</b></p><input type="radio" name="flag" value="1" >YES 
					<input type="radio" name="flag" value="0" checked>NO
					</div> 
					<br>
                  <div class='form-group'>
				  <div class="assignlimit">
                                  <div class="assign-limit">
                                        <form method="post" action="#">
                                        	<select name="limit" class="limitofuploadingrecords" id="limit" style="width:20%; height:30px; border-radius:2px;margin-left: 430px;">
                                              <option value="20" disabled selected>Set upload Records Limit</option>
											  <option value="1">1</option>
											  <option value="2">2</option>
											  <option value="4">4</option>
											  <option value="100">100</option>
											  <option value="500">500</option>
											  <option value="1000">1000</option>
                                              <option value="1500">1500</option>
											  <option value="2000">2000</option>
                                              <option value="2500">2500</option>
											  <option value="3000">3000</option>
                                              <option value="5000">5000</option>
                                              <option value="15000">15000</option>
                                              <option value="20000">20000</option>
                                             </div>
											</div>
											
                  		<!--<label class='control-label col-md-2 col-md-offset-2' for='id_title'></label>-->
                    <div class='col-md-4'>
                       <div class='col-md-4 indent-small'>
                            <input type='file' name='file' id='file' onChange="ValidateSingleInput(this);" style="margin-left:455px;margin-top:20px"/>                          </div> 
                    </div>
                  </div>
                  <div style="height:50px;"></div>
                  <div class='form-group'>
                                <div class='col-md-offset-3 col-md-3' style="padding-left:155px;margin-top:-35px">
                                  <input class='btn-lg btn-primary' type='submit' value="Submit" name="submit" />
                                </div>
                                <div class='col-md-3' style="margin-top:-35px">
                                   <input type="reset" value="Reset"class='btn-lg btn-danger' >
								   <!--   cancel button remove-->
								 <!--<button type="cancel" class='btn-lg btn-danger' onclick="javascript:window.location='list_school_subject.php'">Cancel</button>-->
                                </div>
                                </div>
                                <div class="row">
                                    <div class='col-md-6 col-md-offset-2' align="center" style="color:black;margin-top:15px;padding-left:201px;">
									 	
                              <?php echo $reports1."<br>";
									echo $reports."<br>";
									echo $report."<br>";
									echo $report1."<br>";
									//echo $no_rows;
									
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
<center><a href="download_stud_upload_format.php?name=<?php echo "SUB";?>">Download Subject Upload Excel Sheet Format</a></center><tr>
<center><?php for($space=1;$space<=25;$space++){?>&nbsp;<?php }?>
<a href="download_stud_upload_format.php?name=<?php echo "E";?>">  Download Subject Error Excel Sheet</a></center><tr>
<tr>
</table>
</div>
</div>
</form>
</body>
</html>
