<?php
 	include("scadmin_header.php");
	include("error_function.php");
	$reports="";
	$report="";
     $smartcookie=new smartcookie();
$results=$smartcookie->retrive_individual($table,$fields);
$arrs=mysql_fetch_array($results);

$school_id=$arrs['school_id'];
$school_name=$arrs['school_name'];

$uploadedStatus = 0;
  if (isset($_POST["submit"]) )
{
	if (isset($_FILES["file"]))
	{
		//if there was an error uploading the file
		if ($_FILES["file"]["error"] > 0)
			{
				echo "<script type=text/javascript>alert('plase select file'); window.location=''</script>";
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


        $query2="select batch_id from `tbl_class_subject_master` WHERE school_id='$school_id' ORDER BY `id` DESC LIMIT 1";  //query for getting last batch_id what else if are inserting first time data
        $row2=mysql_query($query2);
        $value2=mysql_fetch_array($row2);
        $batch_id1=$value2['batch_id'];
        $b_id=explode("-",$batch_id1);
  	    $b=$b_id[1];
  	    $bat_id=$b+1;
  	    $str=str_pad($bat_id, 3, "00", STR_PAD_LEFT);
  	    $batch_id=$school_id."_B"."-".$str;




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

							$arr[$i]["B"]=str_replace("'","",trim($allDataInSheet[$i]["B"]));  // class
							$arr[$i]["C"]=str_replace("'","",trim($allDataInSheet[$i]["C"]));  // Subject code
							$arr[$i]["D"]=str_replace("'","",trim($allDataInSheet[$i]["D"]));  // subject title
							$arr[$i]["E"]=str_replace("'","",trim($allDataInSheet[$i]["E"]));  // semester ID
							$arr[$i]["F"]=str_replace("'","",trim($allDataInSheet[$i]["F"]));  // Semester
							$arr[$i]["G"]=str_replace("'","",trim($allDataInSheet[$i]["G"]));  // Branch ID
							$arr[$i]["H"]=str_replace("'","",trim($allDataInSheet[$i]["H"]));  // Branch
							$arr[$i]["I"]=str_replace("'","",trim($allDataInSheet[$i]["I"]));  // Department ID
                            $arr[$i]["J"]=str_replace("'","",trim($allDataInSheet[$i]["J"]));  // Department
                            $arr[$i]["K"]=str_replace("'","",trim($allDataInSheet[$i]["K"]));  // Course Level
                            $arr[$i]["L"]=str_replace("'","",trim($allDataInSheet[$i]["L"]));  // Academic year
                            $arr[$i]["M"]=str_replace("'","",trim($allDataInSheet[$i]["M"]));  // Subject type
                            $arr[$i]["N"]=str_replace("'","",trim($allDataInSheet[$i]["N"]));  // subject short name
                            $arr[$i]["O"]=str_replace("'","",trim($allDataInSheet[$i]["O"]));  // subject credit

                            $class=$arr[$i]["B"];
                            $sub_code=$arr[$i]["C"];
                            $sub_title=$arr[$i]["D"];
                            $sem_id=$arr[$i]["E"];                         // for subject code
                            $semester=$arr[$i]["F"];
                            $branch_id=$arr[$i]["G"];
                            $branch=$arr[$i]["H"];
                            $dept_id=$arr[$i]["I"];
                            $dept=$arr[$i]["J"];
                            $course_lvl=$arr[$i]["K"];
                            $Academic_year=$arr[$i]["L"];
                            $Sub_type=$arr[$i]["M"];
                            $sub_short_name=$arr[$i]["N"];
                            $sub_credit=$arr[$i]["O"];



							if(!empty($class) && !empty($sub_code) && !empty($school_id))
							{
								$row=mysql_query("select * from `tbl_class_subject_master` where subject_code='$sub_code' and class='$class' and school_id='$school_id'");
								if(mysql_num_rows($row)==0)
								{
									$sql_insert1="INSERT INTO `tbl_class_subject_master` (`school_id`,`class`,`subject_code`,`subject_name`,`semester_id`,`semester`,`branch_id`,`branch`,`dept_id`,`department`,`course_level`,`academic_year`,`batch_id`,`uploaded_by`,`subject_type`,`subject_short_name`,`subject_credit`)
									VALUES ('$school_id',$class','$sub_code','".$arr[$i]["D"]."','".$arr[$i]["E"]."','".$arr[$i]["F"]."','".$arr[$i]["G"]."','".$arr[$i]["H"]."','".$arr[$i]["I"]."','".$arr[$i]["J"]."','".$arr[$i]["K"]."','".$arr[$i]["L"]."','$batch_id','$school_name','$Sub_type','$sub_short_name','$sub_credit')";
									$result_insert1 = mysql_query($sql_insert1) or die(mysql_error());
									$reports1="All Subjects has been successfully Inserted...";
								}


								else
								{

									$count_of_duplicates=++$c;
									$get_subject_info=mysql_query("select * from `tbl_class_subject_master` where subject_code='$sub_code' and class='$class' and school_id='$school_id'");
									while($row2=mysql_fetch_array($get_subject_info))
									{


										$updt_class=trim($row2['class']);
										$updt_subject_codee=trim($row2['subject_code']);
										$updt_subject_nm=trim($row2['subject_name']);
										$updt_sem_id=trim($row2['semester_id']);
										$updt_semester=trim($row2['semester']);
										$updt_branch_id=trim($row2['branch_id']);
										$updt_branch=trim($row2['branch']);
										$updt_dept_id=trim($row2['dept_id']);
                                        $updt_dept=trim($row2['department']);
                                        $updt_course_lvl=trim($row2['course_level']);
                                        $updt_academic_yr=trim($row2['academic_year']);
                                         $updt_sub_type=trim($row2['subject_type']);
                                          $updt_subj_short_nm=trim($row2['subject_short_name']);
                                           $updt_sub_credit=trim($row2['subject_credit']);


									}
									 if($class==$updt_class){}
								     else{if($class!=""){
											$update_class="UPDATE `tbl_class_subject_master` SET class='$class' where subject_code='$sub_code' and class='$class' and school_id='$school_id'";
											$update1= mysql_query($update_class) or die('Could not update data: ' . mysql_error());
										}
									    }
									if($sub_code==$updt_subject_codee){}
								     else{$sub_code_val=preg_match('/^[A-Za-z0-9_-]+$/',$sub_code);
											if($sub_code_val || $sub_code!=""){
											$update_sub_code="UPDATE `tbl_class_subject_master` SET subject_code='$sub_code' where subject_code='$sub_code' and class='$class' and school_id='$school_id'";
											$update2= mysql_query($update_sub_code) or die('Could not update data: ' . mysql_error());
										}
									    }
									if($sub_title==$updt_subject_nm){}
								     else{$sub_title_val=preg_match("/[a-zA-Z'-]/",$sub_title);
											if($sub_title!='' || $sub_title_val){
											$update_sub_title="UPDATE `tbl_class_subject_master` SET subject_name='$sub_title' where subject_code='$sub_code' and class='$class' and school_id='$school_id'";
											$update3= mysql_query($update_sub_title) or die('Could not update data: ' . mysql_error());
										}
									    }
									if($sem_id==$updt_sem_id){}
								     else{$sem_id_val=preg_match("/[a-zA-Z'-]/",$sem_id);
											if($sem_id_val){
											$update_deg_name="UPDATE `tbl_class_subject_master` SET semester_id='$sem_id' where subject_code='$sub_code' and class='$class' and school_id='$school_id'";
											$update4= mysql_query($update_deg_name) or die('Could not update data: ' . mysql_error());
										}
									    }
									if($semester==$updt_semester){}
								     else{$sem_type_val=preg_match("/[a-zA-Z'-]/",$semester);
											if($sem_type_val){
											$update_sub_type="UPDATE `tbl_class_subject_master` SET semester='$semester' where subject_code='$sub_code' and class='$class' and school_id='$school_id'";
											$update5= mysql_query($update_sub_type) or die('Could not update data: ' . mysql_error());
										}
									    }

									if($branch_id==$updt_branch_id){}
								     else{$branch_name_val=preg_match("/[a-zA-Z0-9_'-]/",$branch_id);
											if($branch_name_val){
											$update_short_nm="UPDATE `tbl_class_subject_master` SET branch_id='$branch_id' where subject_code='$sub_code' and class='$class' and school_id='$school_id'";
											$update6= mysql_query($update_short_nm) or die('Could not update data: ' . mysql_error());
										}
									    }
									if($branch==$updt_branch){}
								     else{$Br_nm_val=preg_match("/[a-zA-Z0-9_'-]+$/",$branch);
											if($Br_nm_val){
											$update_sub_credit="UPDATE `tbl_class_subject_master` SET branch='$branch' where subject_code='$sub_code' and class='$class' and school_id='$school_id'";
											$update7= mysql_query($update_sub_credit) or die('Could not update data: ' . mysql_error());
										}
									    }
									if($dept_id==$updt_dept_id){}
								     else{$dept_id_val=preg_match("/[a-zA-Z0-9_'-]/",$dept_id);
											if($dept_id_val){
											$update_deptid="UPDATE `tbl_class_subject_master` SET dept_id='$dept_id' where subject_code='$sub_code' and class='$class' and school_id='$school_id'";
											$update8= mysql_query($update_sub_credit) or die('Could not update data: ' . mysql_error());
										}
									    }
									if($dept==$updt_dept){}
								     else{$deptname_val=preg_match('/^[A-Za-z0-9_-]+$/',$dept);
											if($deptname_val || $dept!=""){
											$update_dept="UPDATE `tbl_class_subject_master` SET department='$dept' where subject_code='$sub_code' and class='$class' and school_id='$school_id'";
											$update9= mysql_query($update_sub_credit) or die('Could not update data: ' . mysql_error());
										}
									    }
                                     if($course_lvl==$updt_course_lvl){}
								     else{$up_clvl_val=preg_match('/^[A-Za-z0-9_-]+$/',$course_lvl);
											if($up_clvl_val || $course_lvl!=""){
											$update_course_lvl="UPDATE `tbl_class_subject_master` SET course_level='$course_lvl' where subject_code='$sub_code' and class='$class' and school_id='$school_id'";
											$update10= mysql_query($update_sub_credit) or die('Could not update data: ' . mysql_error());
										}
									    }

                                     if($Academic_year==$updt_academic_yr){}
								     else{$a_yr=preg_match('/^[0-9_-]+$/',$Academic_year);
											if($a_yr || $Academic_year!=""){
											$update_academicyr="UPDATE `tbl_class_subject_master` SET academic_year='$Academic_year' where subject_code='$sub_code' and class='$class' and school_id='$school_id'";
											$update11= mysql_query($update_sub_credit) or die('Could not update data: ' . mysql_error());
										}
									    }

                                         if($Sub_type==$updt_sub_type){}
								         else{$a_yr=preg_match('/^[A-Za-z_+]+$/',$Sub_type);
											if($Sub_type!='' || $a_yr){
											$update_subtype="UPDATE `tbl_class_subject_master` SET subject_type='$Sub_type' where subject_code='$sub_code' and class='$class' and school_id='$school_id'";
											$update12= mysql_query($update_subtype) or die('Could not update data: ' . mysql_error());
										}
									    }

                                        if($sub_short_name==$updt_subj_short_nm){}
								         else{$short_nm=preg_match('/^[A-Za-z]+$/',$sub_short_name);
											if($sub_short_name!='' || $short_nm){
											$update_subshortnm="UPDATE `tbl_class_subject_master` SET subject_short_name='$sub_short_name' where subject_code='$sub_code' and class='$class' and school_id='$school_id'";
											$update13= mysql_query($update_subshortnm) or die('Could not update data: ' . mysql_error());
										}
									    }

                                        if($sub_credit==$updt_sub_credit){}
								         else{$credit=preg_match('/^[0-9_-]+$/',$sub_credit);
											if($sub_credit!='' || $credit){
											$update_subcredit="UPDATE `tbl_class_subject_master` SET subject_credit='$sub_credit' where subject_code='$sub_code' and class='$class' and school_id='$school_id'";
											$update14= mysql_query($update_subcredit) or die('Could not update data: ' . mysql_error());
										}
									    }



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


    }  // file closed

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
    <div class='panel panel-primary dialog-panel'>
   <div style="color:red;font-size:15px;font-weight:bold;margin-top:10px;"> <?php if(isset($_GET['report'])){ echo $_GET['report']; };?></div>
          <div class='panel-heading' style="margin-left: 450px;">

                <h3>Add Class Subject Excel Sheet</h3>



              </div>


                    <div class='panel-body' style="background:lightgrey; box-shadow: 0 0 10px 10px black;">
                    <form name='frm' method='post' enctype='multipart/form-data' id='frm'>
                    <div class="row" style="margin-left: 500px;">
                    <p><b>Scan Excel file</b></p><input type="radio" name="flag" value="1" >YES
                    <input type="radio" name="flag" value="0" checked>NO
                    </div>
                    <br>

                  <div class='form-group'>
                  <div class="assignlimit">
                                  <div class="assign-limit">
                                        <form method="post" action="#" enctype="multipart/form-data">
                                        	<select name="limit" class="limitofuploadingrecords" id="limit" style="width:20%; height:30px; border-radius:2px;margin-left:426px;">
                                              <option value="" disabled selected>Set upload Records Limit</option>
                                              <option value="1">1</option>
                                              <option value="4">4</option>
                                              <option value="100">100</option>
                                              <option value="500">500</option>
                                              <option value="1000">1000</option>
                                              <option value="1500">1500</option>
                                               <option value="2000">2000</option>
                                             <option value="2500">2500</option>
                                              <option value="5000">5000</option>
                                              <option value="15000">15000</option>
                                              <option value="20000">20000</option>
                                              <option value="25000">25000</option>
                                              <option value="30000">30000</option>
                                              </select>

                                            </div>
                                            </div>

                                    <!--<label class='control-label col-md-2 col-md-offset-2' for='id_title'></label>-->
                                <div class='col-md-4'>
                                    <div class='col-md-4 indent-small'>
                                        <input type='file' name='file'  id='file' size='30' onChange="ValidateSingleInput(this);" style="margin-left:455px;margin-top:20px"/>                          </div>
                                </div>
                                <br><br>
                              </div>
                              <div style="height:50px;"></div>
                              <div class='form-group'>
                                <div class='col-md-offset-3 col-md-3' style="padding-left:155px;margin-top:-35px">
                                  <input class='btn-lg btn-primary' type='submit' value="Submit" name="submit" />
                                </div>
                                <div class='col-md-3' style="margin-top:-35px">

                                 <!-- <button class='btn-lg btn-danger'  type='submit'>Cancel</button>  -->
								<!--adding reset buutton -->
								   <input type="reset" value="Reset"class='btn-lg btn-danger' >
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

                                        <div class='col-md-12 col-md-offset-2' align="right" style="padding-right:190px;">
                                     <?php $query2="select batch_id from `tbl_raw_student` WHERE s_school_id='$school_id' ORDER BY id DESC LIMIT 1 ";
                                            $row2=mysql_query($query2);
                                            $value2=mysql_fetch_array($row2);
                                            $batch_id1=$value2['batch_id'];
                                            $b_id=explode("-",$batch_id1);
                                            $b=$b_id[1];
                                            $b1=$b_id[0];
                                            $bat_id=$b;
                                            $batch_id=$b1."-".$bat_id;?>
                                  
                                    </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-12 ">
                                    <table cellpadding="12" cellspacing="6" align="center">
                                    <tr bgcolor="#9900CC">
                                    <center><a href="download_stud_upload_format.php?name=<?php echo "S";?>">Download Student Upload Excel Sheet Format</a></center><tr>
                                    <center><?php for($space=1;$space<=25;$space++){?>&nbsp;<?php }?>
                                    <a href="download_stud_upload_format.php?name=<?php echo "EE";?>">Download Student Error Excel Sheet</a></center><tr>
                                    </table>
                                    </div>
                                    </div>
                                    </form>
                                    </body>
                                    </html>