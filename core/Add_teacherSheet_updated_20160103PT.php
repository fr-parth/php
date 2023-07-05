<?php
//include("conn.php");
error_reporting(0);
if(isset($_GET['id']))
{

include_once("school_staff_header.php");
$c="";
$count_of_duplicates="";	 
$id=$_SESSION['id'];
$query="select * from `tbl_school_adminstaff` where id='$id'";       // uploaded by
$row1=mysql_query($query);
$value1=mysql_fetch_array($row1);
$uploaded_by=$value1['name'];
 

 //$batch_id="B" .time().rand(1,100);




$no_rows="";
$nofile="";
$count1="";
$reports="";
$report="";
$id=$_SESSION['id'];
           
			$fields=array("id"=>$id);
			$table="tbl_school_admin";
		   
			$smartcookie=new smartcookie();
		   
$results=$smartcookie->retrive_individual($table,$fields);
$arrs=mysql_fetch_array($results);

			$school_id=$arrs['school_id'];
			$school_name=$arrs['school_name'];
$uploadedStatus = 0;

if ( isset($_POST["submit"]) ) 
{
	
if ( isset($_FILES["file"])) 
{
										//if there was an error uploading the file
if ($_FILES["file"] > 0) {
		 echo "<script type=text/javascript>alert('Please select file'); window.location=''</script>";
}
else {
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

try {
	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
} catch(Exception $e) {
	die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}

$reports="";
$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet
$totalrecords=$arrayCount-1;
$arr=array();
$email_already=array();
 $j=0;
  $t_date = date('m/d/Y');
  $date=date('Y-m-d h:i:s',strtotime('+330 minute'));
  
$mnemonic=$_POST['mnemonic']; 
if($mnemonic!='')
{ 
$query2="select * from `tbl_raw_teacher` WHERE t_school_id='$school_id' ORDER BY id DESC LIMIT 1 ";  //query for getting last batch_id what else if are inserting first time data
$row2=mysql_query($query2);
$value2=mysql_fetch_array($row2);
$batch_id1=$value2['batch_id'];
$b_id=explode("-",$batch_id1);
$b=$b_id[1]; 
$bat_id=$b+1;
$str=str_pad($bat_id, 3, "00", STR_PAD_LEFT);
$batch_id=$mnemonic."_B"."-".$str;


$value = $objPHPExcel->getActiveSheet()->getCell('A2')->getValue();    // school_id
 if($school_id==$value)
 { 




$temp = explode(".", $_FILES["file"]["name"]); 
$file_type=$temp[1];
$input_file_name=$temp[0].".".$temp[1];
$temp = explode(".", $_FILES["file"]["name"]); 
//$file_type=$temp[1];
$input_file_name=$temp[0].".".$temp[1];
 $file_t1=explode(".", $_FILES['file']['type']);	
$file_type1=$file_t1[1]." ".$file_t1[2];
$limit=$_POST['limit']; 
$upload_limit=$limit+1;
 if($limit>0)
 {	 
for($i=2;$i<=$upload_limit;$i++)
{
	
	$arr[$i]["B"]=trim($allDataInSheet[$i]["B"]);   // t_id
	$arr[$i]["C"]=trim($allDataInSheet[$i]["C"]);  // Employee name
	$arr[$i]["D"]=trim($allDataInSheet[$i]["D"]);   // mobile
	$arr[$i]["E"]=trim($allDataInSheet[$i]["E"]);   // Dept. Name
	$arr[$i]["F"]=trim($allDataInSheet[$i]["F"]);   // Gender
	$arr[$i]["G"]=trim($allDataInSheet[$i]["G"]);   // E mail ID
	$arr[$i]["H"]=trim($allDataInSheet[$i]["H"]);   // Country
	
	           $teacher_id=$allDataInSheet[$i]["B"];   // for teacher ID
				 $t_name=explode(" ",$teacher_id);
				$t_id=$t_name[0];
				$t_ID=strlen(trim(($t_id)));
		
				$email_id1=$allDataInSheet[$i]["G"];
				$e_id=explode(" ",$email_id1);
				$email_id=$e_id[0];
				$email_lenght=strlen(trim(($email_id)));
		
	
				$mobile_no=$allDataInSheet[$i]["D"];   // for Mobile Number
				$m_name=explode(" ",$mobile_no);
				$m_no=$m_name[0];
				$m_lenght=strlen(trim(($m_no)));		
	
	  if($t_ID!=0  && $m_lenght>0)
	   {
 
		   $row=mysql_query("select * from `tbl_raw_teacher` where t_id like '$t_id' and t_phone like '$m_no'");
		   if(mysql_num_rows($row)<=0)
			{
			
			    $emp_name=$allDataInSheet[$i]['C'];
				$first_name=explode(" ",$emp_name); // for Employee name
				$t_firstname=$first_name[0];
				$t_middlename=$first_name[1];
				$t_lastname=$first_name[2];  
				
                $t_f=strlen(trim(($t_firstname)));    // calculate lenght of name
                $t_m=strlen(trim(($t_middlename)));	
				$t_l=strlen(trim(($t_lastname)));	
			
				
				$dept_name=$allDataInSheet[$i]["E"];   // for department name
				 $d_name=explode(" ",$dept_name);
				$dept_name1=$d_name[0];
				
				
				 
				$emp_name=$allDataInSheet[$i]['C'];   //for password
				$first_name=explode(" ",$emp_name);
				$password=$first_name[0]."123"; 
				
				
				
		if($t_f>0 && $t_l>0)
        {		
		/*  if(!empty($t_firstname) && !empty($t_lastname)) 
				
		  { */
			
			 if(!empty($dept_name1) || strlen(trim(($dept_name1)))!==0)
			  { 
		            
		          if(!empty($t_id) || strlen(trim(($t_id)))!==0)
				  {
					 
					   if(!empty($m_no) || strlen(trim(($m_no)))!==0)
					   { 
				             $emailval = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/';
							  $mob="/^[789][0-9]{9}$/";
				        if(preg_match($mob,$m_no) || preg_match($emailval, $email_id)) 
						{
								if($email_lenght>0 || $m_lenght == 10)
                                {									
										
										$err_flag="Correct";
										$sql_insert1="INSERT INTO `tbl_raw_teacher`(t_id,t_name,t_middlename,t_lastname,t_dept,t_school_name,t_school_id,t_date,t_password,t_phone,t_country,batch_id,uploaded_by,uploaded_date_time,file_type,input_file_name,no_record_uploaded,error_records,t_gender,t_email) VALUES ('$t_id',' $t_firstname','$t_middlename','$t_lastname','$dept_name1','$school_name','$school_id','$t_date','$password','$m_no','".$arr[$i]["H"]."','$batch_id','$uploaded_by','$date','$file_type1','$input_file_name','$totalrecords','$err_flag','". trim($allDataInSheet[$i]["F"])."','$email_id')";
										$count1 = mysql_query($sql_insert1) or die(mysql_error()); 
                                        $reports1="You are successfully registered with Smart Cookie";
								}	 
							
							else 
							{
								if($m_lenght<10 || $m_lenght>10)
								{
									
									
									
									
										$err_flag="Err-Phone/Email";
										$sql_insert7="INSERT INTO `tbl_raw_teacher`(t_id,t_name,t_middlename,t_lastname,t_dept,t_school_name,t_school_id,t_date,t_password,t_phone,t_country,batch_id,uploaded_by,uploaded_date_time,file_type,input_file_name,no_record_uploaded,error_records,t_gender,t_email) VALUES ('$t_id','$t_firstname','$t_middlename','$t_lastname','$dept_name1','$school_name','$school_id','$t_date','$password','$m_no','".$arr[$i]["H"]."','$batch_id','$uploaded_by','$date','$file_type1','$input_file_name','$totalrecords','$err_flag','". trim($allDataInSheet[$i]["F"])."','$email_id')";
										$count7 = mysql_query($sql_insert7) or die(mysql_error()); 
										$reports="Inserted data from Excel Sheet is not valid data";	  
								}
								
								
							}
						}
							
							else
							{
							
							
							
										$err_flag="Err-Phone/Email";
										$sql_insert9="INSERT INTO `tbl_raw_teacher`(t_id,t_name,t_middlename,t_lastname,t_dept,t_school_name,t_school_id,t_date,t_password,t_phone,t_country,batch_id,uploaded_by,uploaded_date_time,file_type,input_file_name,no_record_uploaded,error_records,t_gender,t_email) VALUES ('$t_id','$t_firstname','$t_middlename','$t_lastname','$dept_name1','$school_name','$school_id','$t_date','$password','$m_no','".$arr[$i]["H"]."','$batch_id','$uploaded_by','$date','$file_type1','$input_file_name','$totalrecords','$err_flag','". trim($allDataInSheet[$i]["F"])."','$email_id')";
										$count9 = mysql_query($sql_insert9) or die(mysql_error()); 
										$reports="Inserted data from Excel Sheet is not valid data";	  
							
							}
						   
					}
							else
							{
						  
										$err_flag="Err-Phone/Email";
										$sql_insert2="INSERT INTO `tbl_raw_teacher`(t_id,t_name,t_middlename,t_lastname,t_dept,t_school_name,t_school_id,t_date,t_password,t_phone,t_country,batch_id,uploaded_by,uploaded_date_time,file_type,input_file_name,no_record_uploaded,error_records,t_gender,t_email) VALUES ('$t_id','$t_firstname','$t_middlename','$t_lastname','$dept_name1','$school_name','$school_id','$t_date','$password','$m_no','".$arr[$i]["H"]."','$batch_id','$uploaded_by','$date','$file_type1','$input_file_name','$totalrecords','$err_flag','". trim($allDataInSheet[$i]["F"])."','$email_id')";
										$count2 = mysql_query($sql_insert2) or die(mysql_error()); 
										$reports="Inserted data from Excel Sheet is not valid data";	  
							}
                  }	
							else
							{
					
					
					
					
										$err_flag="Err-Tid";
										$sql_insert3="INSERT INTO `tbl_raw_teacher`(t_id,t_name,t_middlename,t_lastname,t_dept,t_school_name,t_school_id,t_date,t_password,t_phone,t_country,batch_id,uploaded_by,uploaded_date_time,file_type,input_file_name,no_record_uploaded,error_records,t_gender,t_email) VALUES ('$t_id','$t_firstname','$t_middlename','$t_lastname','$dept_name1','$school_name','$school_id','$t_date','$password','$m_no','".$arr[$i]["H"]."','$batch_id','$uploaded_by','$date','$file_type1','$input_file_name','$totalrecords','$err_flag','". trim($allDataInSheet[$i]["F"])."','$email_id')";
										$count3 = mysql_query($sql_insert3) or die(mysql_error()); 
										$reports="Inserted data from Excel Sheet is not valid data";	 
							}					
			  }

							else 			
							{
					
				
				
										$err_flag="Err-Dept";
										$sql_insert4="INSERT INTO `tbl_raw_teacher`(t_id,t_name,t_middlename,t_lastname,t_dept,t_school_name,t_school_id,t_date,t_password,t_phone,t_country,batch_id,uploaded_by,uploaded_date_time,file_type,input_file_name,no_record_uploaded,error_records,t_gender,t_email) VALUES ('$t_id','$t_firstname','$t_middlename','$t_lastname','$dept_name1','$school_name','$school_id','$t_date','$password','$m_no','".$arr[$i]["H"]."','$batch_id','$uploaded_by','$date','$file_type1','$input_file_name','$totalrecords','$err_flag','". trim($allDataInSheet[$i]["F"])."','$email_id')";
										$count4 = mysql_query($sql_insert4) or die(mysql_error()); 
										$reports="Inserted data from Excel Sheet is not valid data";	 

							} 


			  
							/* }
			
							else 			
							{
				
				
				
				            $err_flag="Err-Name";
							$sql_insert5="INSERT INTO `tbl_raw_teacher`(t_id,t_name,t_middlename,t_lastname,t_dept,t_school_name,t_school_id,t_date,t_password,t_phone,t_country,batch_id,uploaded_by,uploaded_date_time,file_type,input_file_name,no_record_uploaded,error_records,t_gender,t_email) VALUES ('$t_id','$t_firstname','$t_middlename','$t_lastname','$dept_name1','$school_name','$school_id','$t_date','$password','$m_no','".$arr[$i]["H"]."','$batch_id','$uploaded_by','$date','$file_type1','$input_file_name','$totalrecords','$err_flag','". trim($allDataInSheet[$i]["F"])."','$email_id')";
			                $count5 = mysql_query($sql_insert5) or die(mysql_error()); 
							$reports="Inserted data from Excel Sheet is not valid data";	

							}  */
		}	
			
							else
							{
				
				
										$err_flag="Err-Name";
										$sql_insert6="INSERT INTO `tbl_raw_teacher`(t_id,t_name,t_middlename,t_lastname,t_dept,t_school_name,t_school_id,t_date,t_password,t_phone,t_country,batch_id,uploaded_by,uploaded_date_time,file_type,input_file_name,no_record_uploaded,error_records,t_gender,t_email) VALUES ('$t_id','$t_firstname','$t_middlename','$t_lastname','$dept_name1','$school_name','$school_id','$t_date','$password','$m_no','".$arr[$i]["H"]."','$batch_id','$uploaded_by','$date','$file_type1','$input_file_name','$totalrecords','$err_flag','". trim($allDataInSheet[$i]["F"])."','$email_id')";
										$count6 = mysql_query($sql_insert6) or die(mysql_error()); 
										$reports="Inserted data from Excel Sheet is not valid data";		
							}
					 
					 
					 
		if($count1>=1)
		{
		
		 		
				$sql_insert8="INSERT INTO `tbl_teacher` 
					(t_id,t_name,t_middlename,t_lastname,t_current_school_name,school_id,t_dept,t_gender,t_password,t_date,t_phone,t_country,t_email,batch_id,error_records)
				SELECT t_id,t_name,t_middlename,t_lastname,t_school_name,t_school_id,t_dept,t_gender,t_password,t_date,t_phone,t_country,t_email,batch_id,error_records
				FROM `tbl_raw_teacher` WHERE t_phone='$m_no' AND t_school_id='$school_id' AND error_records like 'Correct' "; 
				$count8 = mysql_query($sql_insert8) or die(mysql_error()); 
				
				$sql_update="UPDATE `tbl_raw_teacher` SET error_records='Import' WHERE t_phone='$m_no' AND t_school_id='$school_id'";
				$retval = mysql_query($sql_update) or die('Could not update data: ' . mysql_error());
				 
                
		  
		}
		
	}
		else
		{
			$count_of_duplicates=++$c;    			// counting duplicates values
			$report="Your Name is already Exist.";
		    
           		   
		
		}
	}
	 
		else
		{
								$err_flag="Err-Tid";
								$sql_insert13="INSERT INTO `tbl_raw_teacher`(t_id,t_name,t_middlename,t_lastname,t_dept,t_school_name,t_school_id,t_date,t_password,t_phone,t_country,batch_id,uploaded_by,uploaded_date_time,file_type,input_file_name,no_record_uploaded,error_records,t_gender,t_email) VALUES ('$t_id','$t_firstname','$t_middlename','$t_lastname','$dept_name1','$school_name','$school_id','$t_date','$password','$m_no','".$arr[$i]["H"]."','$batch_id','$uploaded_by','$date','$file_type1','$input_file_name','$totalrecords','$err_flag','". trim($allDataInSheet[$i]["F"])."','$email_id')";
								$count13 = mysql_query($sql_insert13) or die(mysql_error()); 
								$reports="Inserted data from Excel Sheet is not valid data";
	    }								
	 	
	 
	  
	   
		

}  			// for loop closing

			// code for tbl_batch_master entry log maintain

	$query3="select count(case when `error_records`= 'Err-Phone/Email' then 1 else null end) as PHONE,
    count(case when `error_records`='Err-Tid' then 1 else null end) as TID,
    count(case when  `error_records`='Err-Dept' then 1 else null end) as DEPT,
    count(case when `error_records`='Err-Name' then 1 else null end) as NAME
    from  tbl_raw_teacher where `t_school_id`='$school_id' and batch_id like '$batch_id'";    
	 
$row3=mysql_query($query3);
$value3=mysql_fetch_array($row3);
$phone=$value3['PHONE'];
$tid=$value3['TID'];
$dept=$value3['DEPT'];
$name=$value3['NAME'];
$error_count=$phone+$tid+$dept+$name;
$correct_records=$totalrecords-$error_count-$count_of_duplicates;

$sql_insert10="INSERT INTO `tbl_Batch_Master`(batch_id,input_file_name,file_type,uploaded_date_time,uploaded_by,num_records_uploaded,num_errors_records,num_duplicates_record,num_correct_records)
VALUES ('$batch_id','$input_file_name','$file_type1','$date','$uploaded_by','$totalrecords','$error_count','$count_of_duplicates','$correct_records')";
$count10 = mysql_query($sql_insert10) or die(mysql_error()); 


}  // close of upload limit
else
{
	echo "<script type=text/javascript>alert('Plz select upload limit'); window.location=''</script>";
}
}
	else
	{
		echo "<script type=text/javascript>alert('School ID did not match plz import right excel sheet '); window.location=''</script>";
	} 
}else
	{
		echo "<script type=text/javascript>alert('plz select college mnemonic '); window.location=''</script>";
	} 	
}

 echo "<script type=text/javascript>alert('file is successfully added'); window.location=''</script>";
}




 else 
 {
    //nofile="No file selected <br />";
    echo "<script type=text/javascript>alert('No file selected'); window.location=''</script>";	
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
H3	{
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
width: 35%;
line-height:30px;
}
</style>

<script>
  $(function() {
    $( "#dialog" ).dialog();
  });
  </script>
</head>

<body>

<div class='container' style="padding-top:30px;padding-left:30px;">
    
	<div class='panel panel-primary dialog-panel'>
	
	<div style="color:red;font-size:15px;font-weight:bold;margin-top:10px;"> <?php if(isset($_GET['report'])){ echo $_GET['report']; };?></div>
          
			<div class='panel-heading'>
             
                <h3>Add Teacher Excel Sheet</h3>
            
            </div>
			
			
		<div class='panel-body' style="background:lightgrey; box-shadow: 0 0 10px 10px black;">
   		
		<form name='frm' method='post' enctype='multipart/form-data' id='frm'>
        
          
						<div class='form-group'>
				  
								<div class="assignlimit">
				  
									<div class="assign-limit">
								  
                                        <form method="post" action="#">
                                        	
											<select name="limit" class="limitofuploadingrecords" id="limit" style="width:20%; height:30px; border-radius:2px;margin-left: 350px;">
                                            
												<option value="20" disabled selected>Set upload Records Limit</option>
												<option value="1">1</option>
												<option value="4">4</option>
												<option value="10">10</option>
												<option value="20">20</option>
												<option value="40">40</option>
												<option value="60">60</option>
												<option value="80">80</option>
												<option value="100">100</option>
												<option value="120">120</option>
											</select>
											  
											<select name="mnemonic" class="collegemnemonic" id="mnemonic" style="width:20%; height:30px; border-radius:2px;margin-left:10px;">
                                              
												<option value="" disabled selected>Select Specific college Mnemonic</option>
												<option value="CEOP">CEOP</option>
												<option value="YCCE">YCCE</option>
												<option value="VNIT">VNIT</option>
												<option value="GCOEA">GCOEA</option>
												<option value="KDK">KDK</option>
												<option value="PICT">PICT</option>
												<option value="MIT">MIT</option>
												<option value="SVCP">SVCP</option>
											</select>
											
										</form>	
											
									</div>
											
								</div>
										
										
										
                  		<label class='control-label col-md-2 col-md-offset-2' for='id_title'></label>
                   
						<div class='col-md-8'>
                        <div class='col-md-8 indent-small' style="padding-left:100px">
                           
						   <input type='file' name='file'  id='file' size='30' onChange="ValidateSingleInput(this);" style="margin-left: 455px;margin-top:20px"/>      
					    </div> 
						</div>
						
					</div>
					
					<div style="height:50px;"></div>
					<div class='form-group'>
                                <div class='col-md-offset-3 col-md-3' style="padding-left:155px;margin-top:-35px;">
									<input class='btn-lg btn-primary' type='submit' value="Submit" name="submit" />
                                </div>
								&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class='col-md-3' style="margin-top:-35px">
									<button class='btn-lg btn-danger'  type='submit'>Cancel</button>
                                </div>
                    </div>
                                <div class="row">
                                    <div class='col-md-6 col-md-offset-2' align="center" style="color:black;margin-top:15px;padding-left:201px;">
									 	
                                    <?php echo $reports1."<br>";
									//echo $reports."<br>";
									echo $report."<br>";;
									//echo $no_rows;
									
									?>
									
									</div>
                                </div>
        </div>
                 
         </form>
		 
		 
		 
		 
		 
		 
	</div>
	  
	<!--<div class='col-md-12 col-md-offset-2' align="right" style="padding-right:190px;">
									 	 <?php $query2="select * from `tbl_raw_teacher` WHERE t_school_id='$school_id' ORDER BY id DESC LIMIT 1 ";  //query for getting last batch_id what else if are inserting first time data
												$row2=mysql_query($query2);
												$value2=mysql_fetch_array($row2);
												$batch_id1=$value2['batch_id'];
												$b_id=explode("-",$batch_id1);
												$b=$b_id[1]; 
												$bat_id=$b;
												$batch_id="B"."-".$bat_id;?>	
                                    <h5><?php echo "Batch"." ". $batch_id." "."Uploaded Successfully by"." ".$uploaded_by."<br>"?></h5>
                                    </div>-->
</div>







<div class="row">
<div class="col-md-1"></div>
<div class="col-md-12 ">
<table cellpadding="12" cellspacing="6" align="center">
<tr bgcolor="#9900CC">
<th bgcolor="#CCCCCC">School ID</th>
<th bgcolor="#CCCCCC">Teacher ID</th>
<th bgcolor="#CCCCCC">Name</th>
<th bgcolor="#CCCCCC">Mobile Number</th>
<th bgcolor="#CCCCCC">Department Name</th>
<th bgcolor="#CCCCCC">Gender</th>
<th bgcolor="#CCCCCC">Email ID</th>
<th bgcolor="#CCCCCC">Country</th>

<tr>


</table>
</div>
</div>





</body>

</html>

<!--   ----       -------------------  Start From here -------------------   -------- --- -->
<?php
	}
	else
	{
		//error_reporting(0);
		include("scadmin_header.php");
		include("error_function.php");
	 
		$id=$_SESSION['id'];
		$query="select * from `tbl_school_admin` where id='$id'";       // uploaded by
		$row1=mysql_query($query);
		$value1=mysql_fetch_array($row1);
		$uploaded_by=$value1['name'];
 
		$no_rows="";
		$nofile="";
		$count1="";
		$reports="";
		$report="";
		$count_of_updates="";
		
		$count_of_wrong_school_id="";
		$sc_id=0;
		$id=$_SESSION['id'];
        $fields=array("id"=>$id);
		$table="tbl_school_admin";
		   
		   $smartcookie=new smartcookie();
		   
		$results=$smartcookie->retrive_individual($table,$fields);
		$arrs=mysql_fetch_array($results);

			$school_id=$arrs['school_id'];
			$school_name=$arrs['school_name'];
			$uploadedStatus = 0;
			

if ( isset($_POST["submit"]) ) {
	
if ( isset($_FILES["file"])) {
//if there was an error uploading the file
if ($_FILES["file"]["error"] > 0) {
	
 "Return Code: " . $_FILES["file"]["error"] . "<br />";
 echo "<script type=text/javascript>alert('Please select file'); window.location=''</script>";
}
else
	{
if (file_exists($_FILES["file"]["name"])) {
unlink($_FILES["file"]["name"]);
}
$storagename= $_FILES["file"]["name"];
move_uploaded_file($_FILES["file"]["tmp_name"],  $storagename);
$uploadedStatus = 1;

set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
include 'PHPExcel/IOFactory.php';
// This is the file path to be uploaded.
$inputFileName = $storagename; 

try {
	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
} catch(Exception $e) {
	die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}


$reports="";
$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet

$arr=array();
$email_already=array();
 $j=0;
  $t_date = date('m/d/Y');
  $date=date('Y-m-d h:i:s',strtotime('+330 minute'));
  
$mnemonic=$school_id; 
//if($mnemonic!='' && $school_id==$mnemonic)
//{
$query2="select * from `tbl_raw_teacher` WHERE t_school_id='$school_id' ORDER BY id DESC LIMIT 1 ";  //query for getting last batch_id what else if are inserting first time data
$row2=mysql_query($query2);
$value2=mysql_fetch_array($row2);
$batch_id1=$value2['batch_id'];
$b_id=explode("-",$batch_id1);
$b=$b_id[1]; 
$bat_id=$b+1;
$str=str_pad($bat_id, 3, "00", STR_PAD_LEFT);
$batch_id=$mnemonic."_B"."-".$str;

$temp = explode(".", $_FILES["file"]["name"]); 
$file_type=$temp[1];
$input_file_name=$temp[0].".".$temp[1];
$temp = explode(".", $_FILES["file"]["name"]); 
//$file_type=$temp[1];
$input_file_name=$temp[0].".".$temp[1];
 $file_t1=explode(".", $_FILES['file']['type']);	
$file_type1=$file_t1[1]." ".$file_t1[2];
$limit=$_POST['limit']; 

$upload_limit=$limit+1;
$min=min($upload_limit,$arrayCount);
$totalrecords=$min-1;
$count_of_insert="";
$count_of_duplicates="";
$dup=0;

$upd=0;
$sch_id=0;
$val="";
$validate=0;
$not_validate=0;
$count_of_wrong_school_id="";	
$TID=0;
$flag=$_POST['flag'];
 if($limit>0)
 {	 
	
	if($flag==1)
	{
		 $insert=0; $list = array();
      try
	  {
		  
		//$file = fopen("C:\wamp\www\smartcookies\CSV\teacher_error.csv","w+") or die("Unable to open file for output");
		$file = fopen("/home/content/84/7121184/html/smartcookies/CSV/teacher_error.csv","w+") or die("Unable to open file for output");
		//$file = fopen("/home/content/84/7121184/html/tsmartcookie/CSV/teacher_error.csv","w+") or die("Unable to open file for output");
		fwrite($file,$sn. "," . "School_id" . ", " . "Insert Count" . ", " . "Duplicate Count" . ", " . "Update Count" . ", " . "Wrong School ID Count" . "," . "SPRN Error count" . "," . "Name not validated" . ", " . "Validation count" ."," . "Refuse count" ."\n");
		for($i=2;$i<=$min;$i++)
		{
			$value = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
			$sch_lenght=strlen(trim(($value)));
			if(trim($school_id)==trim($value))
			{ 		
				$arr[$i]["B"]=str_replace("'","", trim($allDataInSheet[$i]["B"]));   // t_id
				$arr[$i]["C"]=str_replace("'","", trim($allDataInSheet[$i]["C"]));  // Employee name
				$arr[$i]["D"]=str_replace("'","", trim($allDataInSheet[$i]["D"]));   // mobile
				$arr[$i]["E"]=str_replace("'","", trim($allDataInSheet[$i]["E"]));   // Dept. Name
				$arr[$i]["F"]=str_replace("'","", trim($allDataInSheet[$i]["F"]));   // Gender
				$arr[$i]["G"]=str_replace("'","", trim($allDataInSheet[$i]["G"]));   // E mail ID
				$arr[$i]["H"]=str_replace("'","", trim($allDataInSheet[$i]["H"]));   // Country
				$arr[$i]["I"]=str_replace("'","", trim($allDataInSheet[$i]["I"]));    //t_Address
	            $arr[$i]["J"]=str_replace("'","", trim($allDataInSheet[$i]["J"]));    // T_DOB
				$arr[$i]["K"]=str_replace("'","", trim($allDataInSheet[$i]["K"]));    //t_internal email
				$arr[$i]["L"]=str_replace("'","", trim($allDataInSheet[$i]["L"]));    // t_landline
				$arr[$i]["M"]=str_replace("'","", trim($allDataInSheet[$i]["M"]));    // t_date_appoinment
				$arr[$i]["N"]=str_replace("'","", trim($allDataInSheet[$i]["N"]));     //Employee type PID
				
				
				
				
	            $teacher_id=$arr[$i]["B"];   // for teacher ID
				$t_name=explode(" ",$teacher_id);
				$t_id=$t_name[0];
				$t_ID=strlen(trim(($t_id)));
				$a=preg_match('/^[0-9]+$/',$teacher_id);
				
				$teacher_name=$arr[$i]["C"];
				$first_name=explode(" ",$teacher_name); // for Employee name
				$t_firstname=$first_name[0];
				$t_middlename=$first_name[1];
				$t_lastname=$first_name[2];  
							
				$t_f=strlen(trim(($t_firstname)));    // calculate lenght of name
				$t_m=strlen(trim(($t_middlename)));	
				$t_l=strlen(trim(($t_lastname)));	
				$b=preg_match("/^[a-zA-Z ]*$/",$teacher_name);
				
				$mobile_no=$allDataInSheet[$i]["D"];   // for Mobile Number
				$m_name=explode(" ",$mobile_no);
				$m_no=$m_name[0];
				$m_lenght=strlen(trim(($m_no)));
				$c=preg_match('/^[0-9]+$/', $m_no);
				
				$dept=$arr[$i]["E"];
				$d=preg_match("/^[a-zA-Z ]*$/",$dept);
				
				$gender=$arr[$i]["F"];
				$e=preg_match("/[a-zA-Z'-]/",$gender);
				
				$email_id1=$allDataInSheet[$i]["G"];
				$e_id=explode(" ",$email_id1);
				$email_id=$e_id[0];
				$email_lenght=strlen(trim(($email_id)));
				$f=filter_var($email_id, FILTER_VALIDATE_EMAIL);
				
				$country=$arr[$i]["H"];
				$g=preg_match("/^[a-zA-Z ]*$/",$country);
		
				$Address=$arr[$i]["I"];
				$find = array(",",".");
				$add=str_replace($find,"",$Address);
				$h=preg_match('/^[0-9]{1,7} [a-zA-z0-9]{1,35}\a*/',$add);
				
				$dob=$arr[$i]["J"];
				$date_regex = "/([1-9]|0[1-9]|1[1-9]|2[1-9]|3[0-1])[ \/.-]([1-9]|0[1-9]|1[1-2])[ \/.-](19|20)\d\d/";
				$ik=preg_match($date_regex,$dob);
				
				$intern_email=$arr[$i]["K"];
				$j=filter_var($intern_email, FILTER_VALIDATE_EMAIL);

				$landline=$arr[$i]["L"];
				$k=preg_match('/^[0-9]+$/',$landline);
				
				$date_appt=$arr[$i]["M"];
				$date_regex1 = "/([1-9]|0[1-9]|1[1-9]|2[1-9]|3[0-1])[ \/.-]([1-9]|0[1-9]|1[1-2])[ \/.-](19|20)\d\d/";
				$l=preg_match($date_regex1,$date_appt);
				
				$E_PID=$arr[$i]["N"];
				$m=preg_match('/^[0-9]+$/',$E_PID);	
				if($t_ID>0)
				{
					$row=mysql_query("select t_id from `tbl_teacher` where t_id='$t_id' and school_id='$school_id'");
					
					if(mysql_num_rows($row)==0)
					{
						  
				          if($t_f>0 || $t_l>0)
						  {
							   $list[$insert] = $t_id;
				          		++$insert;	
								
						  
						  
						  }else{++$name_not_validated;}						  
        			   
									
										 
					}   // closing of if row<0
				
					else
					{
						
						++$dup;
					
            		}						  
									
			
		         
				}else{
					 if($a==1 && $t_ID>0)
					  $TID++;
				    }
				
				
					
		
					
			}else
					{
						if(!empty($value) && $sch_lenght>0)
						++$sch_id;
						
					}
				

					if($a && $b && $c && $d && $e && $f && $g && $h && $ik && $j && $k && $l && $m && $m_lenght==10)
						{							
							if(empty($teacher_id) || empty($teacher_name) || empty($m_no) || empty($dept) || empty($gender) || empty($email_id) || empty($country) || empty($Address) || empty($dob) || empty($intern_email) || empty($landline) || empty($date_appt) || empty($E_PID))
							{
													
								 ++$validate;							
								
							}
												
														 	
						}else{
								
							     ++$not_validate;	
							 }				
		}
		fwrite($file,$sn. ", " . $school_id . ", " .$insert . "," . $dup. ", " .$dup. ", " .$sch_id. "," .$TID. "," .$name_not_validated. ", " . $validate .  "," .$not_validate. "\n");
		$abc=$insert;
			$ep=$abc-1;
			while($ep>=0){
			fwrite($file,$sn. ",". $sn. ", " . $list[$ep] ."\n");
			  $ep--;
			} 
		
		echo "<script type=text/javascript>alert('File has been scan successfully...'); window.location=''</script>";
		fclose($file);
	  }catch (Exception $e) 
			{ 
				echo $e->errorMessage(); 
			} 	
	
	
	}
	
	
	//   Flag==0
	else
	{	$count_dup=0;$count_upd=0;$insertc=0;$sc_id=0;$bad_tid=0;$invalid_nm=0;$count_of_updates=0;
		for($i=2;$i<=$min;$i++)
		{
			$value = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
			if(trim($school_id)==trim($value))
			{
			    $replace = array(",","'",".","(",")","/","\",",":","-");
				$arr[$i]["B"]=str_replace("'","", trim($allDataInSheet[$i]["B"]));   // t_id
				$arr[$i]["C"]=str_replace("'","", trim($allDataInSheet[$i]["C"]));  // Employee name
				$arr[$i]["D"]=str_replace("'","", trim($allDataInSheet[$i]["D"]));   // mobile
				$arr[$i]["E"]=str_replace("'","", trim($allDataInSheet[$i]["E"]));   // Dept. Name
				$arr[$i]["F"]=str_replace("'","", trim($allDataInSheet[$i]["F"]));   // Gender
				$arr[$i]["G"]=str_replace("'","", trim($allDataInSheet[$i]["G"]));   // E mail ID
				$arr[$i]["H"]=str_replace("'","", trim($allDataInSheet[$i]["H"]));   // Country
				$arr[$i]["I"]=str_replace($replace," ", trim($allDataInSheet[$i]["I"]));    //t_Address
	            $arr[$i]["J"]=str_replace("'","", trim($allDataInSheet[$i]["J"]));    // T_DOB
				$arr[$i]["K"]=str_replace("'","", trim($allDataInSheet[$i]["K"]));    //t_internal email
				$arr[$i]["L"]=str_replace("'","", trim($allDataInSheet[$i]["L"]));    // t_landline
				$arr[$i]["M"]=str_replace("'","", trim($allDataInSheet[$i]["M"]));    // t_date_appoinment
				$arr[$i]["N"]=str_replace("'","", trim($allDataInSheet[$i]["N"]));     //Employee type PID

				

				   $valid_email=$arr[$i]["G"];
				    $s=filter_var($valid_email, FILTER_VALIDATE_EMAIL);
			    	if($s)
                    {
                         $email_id=$arr[$i]["G"];

                    }
                     $mobile_no=$arr[$i]["D"];   // for Mobile Number
				    //$m_name=explode(" ",$mobile_no);
				    //$m_no=$m_name[0];

                    $c=preg_match('/^[0-9]+$/', $mobile_no);
				    if($c)
                    {
                          $m_no=$mobile_no;

                    }
                    $m_lenght=strlen(trim(($m_no)));
	            $teacher_id=$arr[$i]["B"];   // for teacher ID
				$t_name=explode(" ",$teacher_id);
				$t_id=$t_name[0];
				$t_ID=strlen(trim(($t_id)));
				
				$emp_name=$arr[$i]["C"];
				$first_name=explode(" ",$emp_name); // for Employee name
				$t_firstname=$first_name[0];
				$t_middlename=$first_name[1];
				$t_lastname=$first_name[2];  
							
				$t_f=strlen(trim(($t_firstname)));    // calculate lenght of name
				$t_m=strlen(trim(($t_middlename)));	
				$t_l=strlen(trim(($t_lastname)));	
							

				
				$first_name1=strtolower($t_firstname);  //for password
				$password=$first_name1."123"; 
						
				$dept_name1=$arr[$i]["E"];
				$teach_gender=$arr[$i]["F"];
				

			   //	$e_id=explode(" ",$email_id1);
				//$email_id=$e_id[0];
				$email_lenght=strlen(trim(($email_id)));
		         
				 $teach_country=$arr[$i]["H"];
				 $teach_address=$arr[$i]["I"];
				 $teach_dob=$arr[$i]["J"];

				 $teach_landline=$arr[$i]["L"];
				 $teach_date_app=$arr[$i]["M"];
				 $teach_type_pid=$arr[$i]["N"];
	
				  $valid1_email=$arr[$i]["K"];
				    $s1=filter_var($valid1_email, FILTER_VALIDATE_EMAIL);
			    	if($s1)
                    {
                         $teach_int_email=$arr[$i]["K"];

                    }
				

							
							
							
							
							 
											
	
	
				if($t_ID>0)
	 
				{
				   $row11=mysql_query("select t_id from `tbl_raw_teacher` where t_id='$t_id' and t_school_id='$school_id'");
				   if(mysql_num_rows($row11)==0)
					{
						if($t_f>0 || $t_l>0)
                        {																		
																
										$err_flag="Correct";
										$sql_insert1="INSERT INTO `tbl_raw_teacher`(t_id,t_complete_name,t_name,t_middlename,t_lastname,t_dept,t_school_name,t_school_id,t_date,t_password,t_phone,t_country,batch_id,uploaded_by,uploaded_date_time,file_type,input_file_name,no_record_uploaded,error_records,t_gender,t_email,t_emp_type_pid,college_mnemonic,t_dob,t_date_of_appointment,t_internal_email,t_address) VALUES ('$t_id','".$arr[$i]["C"]."','$t_firstname','$t_middlename','$t_lastname','$dept_name1','$school_name','$school_id','$t_date','$password','$m_no','".$arr[$i]["H"]."','$batch_id','$uploaded_by','$date','$file_type1','$input_file_name','$totalrecords','$err_flag','".$arr[$i]["F"]."','$email_id','".$arr[$i]["N"]."','$mnemonic','".$arr[$i]["J"]."','".$arr[$i]["M"]."','".$arr[$i]["K"]."','".$arr[$i]["I"]."')";
										$count1 = mysql_query($sql_insert1) or die(mysql_error()); 
										$reports1="You are successfully registered with Smart Cookie";
													
						}else{
						        ++$invalid_nm;
							    $err_flag="Err-Name";
								$sql_insert6="INSERT INTO `tbl_raw_teacher`(t_id,t_complete_name,t_name,t_middlename,t_lastname,t_dept,t_school_name,t_school_id,t_date,t_password,t_phone,t_country,batch_id,uploaded_by,uploaded_date_time,file_type,input_file_name,no_record_uploaded,error_records,t_gender,t_email,t_emp_type_pid,college_mnemonic,t_dob,t_date_of_appointment,t_internal_email,t_address) VALUES ('$t_id','".$arr[$i]["C"]."','$t_firstname','$t_middlename','$t_lastname','$dept_name1','$school_name','$school_id','$t_date','$password','$m_no','".$arr[$i]["H"]."','$batch_id','$uploaded_by','$date','$file_type1','$input_file_name','$totalrecords','$err_flag','".$arr[$i]["F"]."','$email_id','".$arr[$i]["N"]."','$mnemonic','".$arr[$i]["J"]."','".$arr[$i]["M"]."','".$arr[$i]["K"]."','".$arr[$i]["I"]."')";
								$count6 = mysql_query($sql_insert6) or die(mysql_error()); 
								$reports="Inserted data from Excel Sheet is not valid data";
							 }						

						
						if($count1>=1)
						{
						    ++$insertc;
							$check_teacher=mysql_query("select t_id from `tbl_teacher` where t_id='$t_id' and school_id='$school_id'");
							if(mysql_num_rows($check_teacher)==0)
							{
		 		
								$sql_insert8="INSERT INTO `tbl_teacher` 
									(t_id,t_complete_name,t_name,t_middlename,t_lastname,t_current_school_name,school_id,t_dept,t_gender,t_password,t_date,t_phone,t_country,t_email,batch_id,error_records,t_emp_type_pid,college_mnemonic,t_date_of_appointment,t_internal_email,t_address)
								SELECT t_id,t_complete_name,t_name,t_middlename,t_lastname,t_school_name,t_school_id,t_dept,t_gender,t_password,t_date,t_phone,t_country,t_email,batch_id,error_records,t_emp_type_pid,college_mnemonic,t_date_of_appointment,t_internal_email,t_address
								FROM `tbl_raw_teacher` WHERE t_id='$t_id' AND t_school_id='$school_id'"; 
								$count8 = mysql_query($sql_insert8) or die(mysql_error()); 
								$sql_update="UPDATE `tbl_raw_teacher` SET error_records='Import' WHERE t_id='$t_id' AND t_school_id='$school_id'";
								$retval = mysql_query($sql_update) or die('Could not update data: ' . mysql_error());
							}else
							{
											$get_teacher_info=mysql_query("select * from `tbl_teacher` where t_id='$t_id' and school_id='$school_id'");
											while($row2=mysql_fetch_array($get_teacher_info))
											{


												$t_schid=trim($row2['school_id']);
												$t_ID=trim($row2['t_id']);
												$t_com_name=trim($row2['t_complete_name']);
												$t_mobno=trim($row2['t_phone']);
												$t_depart=trim($row2['t_dept']);
												$t_genderr=trim($row2['t_gender']);
												$t_emailid=trim($row2['t_email']);
												$t_countryy=trim($row2['t_country']);
												$t_add=trim($row2['t_address']);
												$t_DOB=trim($row2['t_dob']);
												$t_int_emailid=trim($row2['t_internal_email']);
												$t_land=trim($row2['t_landline']);
												$t_date_of_app=trim($row2['t_date_of_appointment']);
												$t_emp_id=trim($row2['t_emp_type_pid']);
									
											}
											$teacher_namee=explode(" ",$t_com_name); // for Employee name
											$t_fname=$teacher_namee[0];
											$t_mname=$teacher_namee[1];
											$t_lname=$teacher_namee[2]; 
											
											 if($t_schid==$value){}
											 else{$sch_val=preg_match("/^[a-zA-Z0-9]",$value);
												  if($value!="" || $sch_val){
													$update_schid="UPDATE `tbl_teacher` SET school_id='$value' where t_id='$t_id' and school_id='$school_id'";
													$update1= mysql_query($update_schid) or die('Could not update data: ' . mysql_error());
												}
												}
											 if($t_ID==$t_id){}
											 else{$tid_val=preg_match('/^[0-9]+$/',$t_id);
												  if($tid_val){
													$update_tid="UPDATE `tbl_teacher` SET t_id='$t_id' where t_id='$t_id' and school_id='$school_id'";
													$update2= mysql_query($update_tid) or die('Could not update data: ' . mysql_error());
												}
												}
											if($t_com_name==$emp_name){}
											 else{$t_name_val=preg_match("/^[a-zA-Z ]*$/",$teacher_name);
												  if($t_name_val){
													$update_tcname="UPDATE `tbl_teacher` SET t_complete_name='$emp_name' where t_id='$t_id' and school_id='$school_id'";
													$update3= mysql_query($update_tcname) or die('Could not update data: ' . mysql_error());
												}
												}
											if($t_fname==$t_firstname){}
											 else{$t_fname_val=preg_match("/^[a-zA-Z ]*$/",$t_firstname);
												  if($t_fname_val){
													$update_fname="UPDATE `tbl_teacher` SET t_name='$t_firstname' where t_id='$t_id' and school_id='$school_id'";
													$update4= mysql_query($update_fname) or die('Could not update data: ' . mysql_error());
												}
												}
											if($t_mname==$t_middlename){}
											 else{$t_mname_val=preg_match("/^[a-zA-Z ]*$/",$t_middlename);
												  if($t_mname_val){
													$update_tmname="UPDATE `tbl_teacher` SET t_middlename='$t_middlename' where t_id='$t_id' and school_id='$school_id'";
													$update5= mysql_query($update_tmname) or die('Could not update data: ' . mysql_error());
												}
												}
											if($t_lname==$t_lastname){}
											 else{$t_lname_val=preg_match("/^[a-zA-Z ]*$/",$t_lastname);
												  if($t_lname_val){
													$update_tlname="UPDATE `tbl_teacher` SET t_lastname='$t_lastname' where t_id='$t_id' and school_id='$school_id'";
													$update6= mysql_query($update_tlname) or die('Could not update data: ' . mysql_error());
												}
												}    	
											if($t_mobno==$m_no){}
											 else{$t_mobno_val=preg_match('/^[0-9]+$/', $m_no);
												  if($t_mobno_val && $m_lenght==10){
													$update_tmobno="UPDATE `tbl_teacher` SET t_phone='$m_no' where t_id='$t_id' and school_id='$school_id'";
													$update7= mysql_query($update_tmobno) or die('Could not update data: ' . mysql_error());
												}
												} 
											 if($t_depart==$dept_name1){}
											 else{$t_dept_val=preg_match("/^[a-zA-Z ]*$/",$dept_name1);
												  if($t_dept_val){
													$update_tdept="UPDATE `tbl_teacher` SET t_dept='$dept_name1' where t_id='$t_id' and school_id='$school_id'";
													$update8= mysql_query($update_tdept) or die('Could not update data: ' . mysql_error());
												}
												}   
											if($t_genderr==$teach_gender){}
											 else{$t_gen_val=preg_match("/[a-zA-Z'-]/",$teach_gender);
												  if($t_gen_val){
													$update_tgen="UPDATE `tbl_teacher` SET t_gender='$teach_gender' where t_id='$t_id' and school_id='$school_id'";
													$update9= mysql_query($update_tgen) or die('Could not update data: ' . mysql_error());
												}
												}
											if($t_emailid==$email_id){}
											 else{$t_emailid_val=filter_var($email_id, FILTER_VALIDATE_EMAIL);
												  if($t_emailid_val){
													$update_temail="UPDATE `tbl_teacher` SET t_email='$email_id' where t_id='$t_id' and school_id='$school_id'";
													$update10= mysql_query($update_temail) or die('Could not update data: ' . mysql_error());
												}
												}	
											if($t_countryy==$teach_country){}
											 else{$t_conty_val=preg_match("/^[a-zA-Z ]*$/",$teach_country);
												  if($t_conty_val){
													$update_tcountry="UPDATE `tbl_teacher` SET t_country='$teach_country' where t_id='$t_id' and school_id='$school_id'";
													$update11= mysql_query($update_tcountry) or die('Could not update data: ' . mysql_error());
												}
												}	
											if($t_add==$teach_address){}
											 else{ $find = array(",",".","/","'");
													$add=str_replace($find,"",$teach_address);
													$t_add_val=preg_match('/^[0-9]{1,7} [a-zA-z0-9]{1,35}\a',$teach_address);
												  if($t_add_val){
													$update_tadd="UPDATE `tbl_teacher` SET t_address='$teach_address' where t_id='$t_id' and school_id='$school_id'";
													$update12= mysql_query($update_tadd) or die('Could not update data: ' . mysql_error());
												}
												}	
							
											if($t_DOB==$teach_dob){}
											 else{$date_regex = "/([1-9]|0[1-9]|1[1-9]|2[1-9]|3[0-1])[ \/.-]([1-9]|0[1-9]|1[1-2])[ \/.-](19|20)\d\d/";
													$t_dob_val=preg_match($date_regex,$teach_dob);
												  if($t_dob_val){
													$update_tdob="UPDATE `tbl_teacher` SET t_dob='$teach_dob' where t_id='$t_id' and school_id='$school_id'";
													$update13= mysql_query($update_tdob) or die('Could not update data: ' . mysql_error());
												}
												}
											if($t_int_emailid==$teach_int_email){}
											 else{$t_int_email_val=filter_var($teach_int_email, FILTER_VALIDATE_EMAIL);
												if($t_int_email_val){
													$update_tintemail="UPDATE `tbl_teacher` SET t_internal_email='$teach_int_email' where t_id='$t_id' and school_id='$school_id'";
													$update14= mysql_query($update_tintemail) or die('Could not update data: ' . mysql_error());
												}
												}
											if($t_land==$teach_landline){}
											 else{$t_land_val=preg_match('/^[0-9]+$/',$teach_landline);
												if($t_land_val){
													$update_tlandline="UPDATE `tbl_teacher` SET t_landline='$teach_landline' where t_id='$t_id' and school_id='$school_id'";
													$update15= mysql_query($update_tlandline) or die('Could not update data: ' . mysql_error());
												}
												}
											if($t_date_of_app==$teach_date_app){}
											 else{$date_regex1 = "/([1-9]|0[1-9]|1[1-9]|2[1-9]|3[0-1])[ \/.-]([1-9]|0[1-9]|1[1-2])[ \/.-](19|20)\d\d/";
													$t_date_app_val=preg_match($date_regex1,$teach_date_app);
												if($t_date_app_val){
													$update_tdateapp="UPDATE `tbl_teacher` SET t_date_of_appointment='$teach_date_app' where t_id='$t_id' and school_id='$school_id'";
													$update16= mysql_query($update_tdateapp) or die('Could not update data: ' . mysql_error());
												}
												}
											if($t_emp_id==$teach_type_pid){}
											 else{$t_empid_val=preg_match('/^[0-9]+$/',$teach_type_pid);
												if($t_empid_val){
													$update_empid="UPDATE `tbl_teacher` SET t_emp_type_pid='$teach_type_pid' where t_id='$t_id' and school_id='$school_id'";
													$update17= mysql_query($update_empid) or die('Could not update data: ' . mysql_error());
												}
												}		
							}
						}
					}
					else
					{

								++$count_dup;
						
								$err_flag="Duplicate";
								$update_duplicate="UPDATE `tbl_raw_teacher` SET batch_id='$batch_id',error_records='$err_flag'
								WHERE t_id='$t_id' AND t_school_id='$school_id'";
								$update_count12 = mysql_query($update_duplicate) or die('Could not update data: ' . mysql_error());
								
								   $c=mysql_query("select t_id from `tbl_teacher` where t_id='$t_id' and school_id='$school_id'");
								   if(mysql_num_rows($c)==0)
									{
										        $err_flag="Correct";
									            $sql_insert6="INSERT INTO `tbl_teacher`(t_id,t_complete_name,t_name,t_middlename,t_lastname,t_dept,`t_current_school_name`,school_id,t_date,t_password,t_phone,t_country,batch_id,error_records,t_gender,t_email,t_emp_type_pid,college_mnemonic,t_dob,t_date_of_appointment,t_internal_email,t_address)
											    VALUES ('$t_id','$emp_name','$t_firstname','$t_middlename','$t_lastname','$dept_name1','$school_name','$school_id','$t_date','$password','$m_no','$teach_country','$batch_id','$err_flag','$teach_gender','$email_id','$teach_type_pid','$mnemonic','$teach_dob','$teach_date_app','$teach_int_email','$teach_address')";
								           
												$count9 = mysql_query($sql_insert6) or die(mysql_error());
											
							
							        }else{
											$get_teacher_info=mysql_query("select * from `tbl_teacher` where t_id='$t_id' and school_id='$school_id'");
											while($row2=mysql_fetch_array($get_teacher_info))
											{


												$t_schid=trim($row2['school_id']);
												$t_ID=trim($row2['t_id']);
												$t_com_name=trim($row2['t_complete_name']);
												$t_mobno=trim($row2['t_phone']);
												$t_depart=trim($row2['t_dept']);
												$t_genderr=trim($row2['t_gender']);
												$t_emailid=trim($row2['t_email']);
												$t_countryy=trim($row2['t_country']);
												$t_add=trim($row2['t_address']);
												$t_DOB=trim($row2['t_dob']);
												$t_int_emailid=trim($row2['t_internal_email']);
												$t_land=trim($row2['t_landline']);
												$t_date_of_app=trim($row2['t_date_of_appointment']);
												$t_emp_id=trim($row2['t_emp_type_pid']);
									
											}
											$teacher_namee=explode(" ",$t_com_name); // for Employee name
											$t_fname=$teacher_namee[0];
											$t_mname=$teacher_namee[1];
											$t_lname=$teacher_namee[2]; 
											
											 if($t_schid==$value){}
											 else{$sch_val=preg_match("/^[a-zA-Z0-9]",$value);
												  if($value!="" || $sch_val){
													$update_schid="UPDATE `tbl_teacher` SET school_id='$value' where t_id='$t_id' and school_id='$school_id'";
													$update1= mysql_query($update_schid) or die('Could not update data: ' . mysql_error());
												}
												}
											 if($t_ID==$t_id){}
											 else{$tid_val=preg_match('/^[0-9]+$/',$t_id);
												  if($tid_val){
													$update_tid="UPDATE `tbl_teacher` SET t_id='$t_id' where t_id='$t_id' and school_id='$school_id'";
													$update2= mysql_query($update_tid) or die('Could not update data: ' . mysql_error());
												}
												}
											if($t_com_name==$emp_name){}
											 else{$t_name_val=preg_match("/^[a-zA-Z ]*$/",$teacher_name);
												  if($t_name_val){
													$update_tcname="UPDATE `tbl_teacher` SET t_complete_name='$emp_name' where t_id='$t_id' and school_id='$school_id'";
													$update3= mysql_query($update_tcname) or die('Could not update data: ' . mysql_error());
												}
												}
											if($t_fname==$t_firstname){}
											 else{$t_fname_val=preg_match("/^[a-zA-Z ]*$/",$t_firstname);
												  if($t_fname_val){
													$update_fname="UPDATE `tbl_teacher` SET t_name='$t_firstname' where t_id='$t_id' and school_id='$school_id'";
													$update4= mysql_query($update_fname) or die('Could not update data: ' . mysql_error());
												}
												}
											if($t_mname==$t_middlename){}
											 else{$t_mname_val=preg_match("/^[a-zA-Z ]*$/",$t_middlename);
												  if($t_mname_val){
													$update_tmname="UPDATE `tbl_teacher` SET t_middlename='$t_middlename' where t_id='$t_id' and school_id='$school_id'";
													$update5= mysql_query($update_tmname) or die('Could not update data: ' . mysql_error());
												}
												}
											if($t_lname==$t_lastname){}
											 else{$t_lname_val=preg_match("/^[a-zA-Z ]*$/",$t_lastname);
												  if($t_lname_val){
													$update_tlname="UPDATE `tbl_teacher` SET t_lastname='$t_lastname' where t_id='$t_id' and school_id='$school_id'";
													$update6= mysql_query($update_tlname) or die('Could not update data: ' . mysql_error());
												}
												}    	
											if($t_mobno==$m_no){}
											 else{$t_mobno_val=preg_match('/^[0-9]+$/', $m_no);
												  if($t_mobno_val && $m_lenght==10){
													$update_tmobno="UPDATE `tbl_teacher` SET t_phone='$m_no' where t_id='$t_id' and school_id='$school_id'";
													$update7= mysql_query($update_tmobno) or die('Could not update data: ' . mysql_error());
												}
												} 
											 if($t_depart==$dept_name1){}
											 else{$t_dept_val=preg_match("/^[a-zA-Z ]*$/",$dept_name1);
												  if($t_dept_val){
													$update_tdept="UPDATE `tbl_teacher` SET t_dept='$dept_name1' where t_id='$t_id' and school_id='$school_id'";
													$update8= mysql_query($update_tdept) or die('Could not update data: ' . mysql_error());
												}
												}   
											if($t_genderr==$teach_gender){}
											 else{$t_gen_val=preg_match("/[a-zA-Z'-]/",$teach_gender);
												  if($t_gen_val){
													$update_tgen="UPDATE `tbl_teacher` SET t_gender='$teach_gender' where t_id='$t_id' and school_id='$school_id'";
													$update9= mysql_query($update_tgen) or die('Could not update data: ' . mysql_error());
												}
												}
											if($t_emailid==$email_id){}
											 else{$t_emailid_val=filter_var($email_id, FILTER_VALIDATE_EMAIL);
												  if($t_emailid_val){
													$update_temail="UPDATE `tbl_teacher` SET t_email='$email_id' where t_id='$t_id' and school_id='$school_id'";
													$update10= mysql_query($update_temail) or die('Could not update data: ' . mysql_error());
												}
												}	
											if($t_countryy==$teach_country){}
											 else{$t_conty_val=preg_match("/^[a-zA-Z ]*$/",$teach_country);
												  if($t_conty_val){
													$update_tcountry="UPDATE `tbl_teacher` SET t_country='$teach_country' where t_id='$t_id' and school_id='$school_id'";
													$update11= mysql_query($update_tcountry) or die('Could not update data: ' . mysql_error());
												}
												}	
											if($t_add==$teach_address){}
											 else{ $find = array(",",".","/","'");
													$add=str_replace($find,"",$teach_address);
													$t_add_val=preg_match('/^[0-9]{1,7} [a-zA-z0-9]{1,35}\a',$teach_address);
												  if($t_add_val){
													$update_tadd="UPDATE `tbl_teacher` SET t_address='$teach_address' where t_id='$t_id' and school_id='$school_id'";
													$update12= mysql_query($update_tadd) or die('Could not update data: ' . mysql_error());
												}
												}	
							
											if($t_DOB==$teach_dob){}
											 else{$date_regex = "/([1-9]|0[1-9]|1[1-9]|2[1-9]|3[0-1])[ \/.-]([1-9]|0[1-9]|1[1-2])[ \/.-](19|20)\d\d/";
													$t_dob_val=preg_match($date_regex,$teach_dob);
												  if($t_dob_val){
													$update_tdob="UPDATE `tbl_teacher` SET t_dob='$teach_dob' where t_id='$t_id' and school_id='$school_id'";
													$update13= mysql_query($update_tdob) or die('Could not update data: ' . mysql_error());
												}
												}
											if($t_int_emailid==$teach_int_email){}
											 else{$t_int_email_val=filter_var($teach_int_email, FILTER_VALIDATE_EMAIL);
												if($t_int_email_val){
													$update_tintemail="UPDATE `tbl_teacher` SET t_internal_email='$teach_int_email' where t_id='$t_id' and school_id='$school_id'";
													$update14= mysql_query($update_tintemail) or die('Could not update data: ' . mysql_error());
												}
												}
											if($t_land==$teach_landline){}
											 else{$t_land_val=preg_match('/^[0-9]+$/',$teach_landline);
												if($t_land_val){
													$update_tlandline="UPDATE `tbl_teacher` SET t_landline='$teach_landline' where t_id='$t_id' and school_id='$school_id'";
													$update15= mysql_query($update_tlandline) or die('Could not update data: ' . mysql_error());
												}
												}
											if($t_date_of_app==$teach_date_app){}
											 else{$date_regex1 = "/([1-9]|0[1-9]|1[1-9]|2[1-9]|3[0-1])[ \/.-]([1-9]|0[1-9]|1[1-2])[ \/.-](19|20)\d\d/";
													$t_date_app_val=preg_match($date_regex1,$teach_date_app);
												if($t_date_app_val){
													$update_tdateapp="UPDATE `tbl_teacher` SET t_date_of_appointment='$teach_date_app' where t_id='$t_id' and school_id='$school_id'";
													$update16= mysql_query($update_tdateapp) or die('Could not update data: ' . mysql_error());
												}
												}
											if($t_emp_id==$teach_type_pid){}
											 else{	$t_empid_val=preg_match('/^[0-9]+$/',$teach_type_pid);
													if($t_empid_val)
													{
														$update_empid="UPDATE `tbl_teacher` SET t_emp_type_pid='$teach_type_pid' where t_id='$t_id' and school_id='$school_id'";
														$update17= mysql_query($update_empid) or die('Could not update data: ' . mysql_error());
													}
												}			
										}
					

							$count_of_updates=$count_dup;	   // for counting number of Updates records
							
					
						}
				}else{
				        ++$bad_tid;
					    if($t_f>0 || $t_l>0)
						{
							if(!empty($m_no) || $email_lenght>0)
							{
								$err_flag="Err-Tid";
								$sql_insert3="INSERT INTO `tbl_raw_teacher`(t_id,t_name,t_middlename,t_lastname,t_dept,t_school_name,t_school_id,t_date,t_password,t_phone,t_country,batch_id,uploaded_by,uploaded_date_time,file_type,input_file_name,no_record_uploaded,error_records,t_gender,t_email) VALUES ('$t_id','$t_firstname','$t_middlename','$t_lastname','$dept_name1','$school_name','$school_id','$t_date','$password','$m_no','".$arr[$i]["H"]."','$batch_id','$uploaded_by','$date','$file_type1','$input_file_name','$totalrecords','$err_flag','". trim($allDataInSheet[$i]["F"])."','$email_id')";
								$count3 = mysql_query($sql_insert3) or die(mysql_error());
								$reports="plz put Teacher ID in excel sheet.";
							}
						}				
					}
			}else
					{
						++$sc_id;
						$err_flag="Err-SCID";
						$sql_insert13="INSERT INTO `tbl_raw_teacher`(t_id,t_name,t_middlename,t_lastname,t_dept,t_school_name,t_school_id,t_date,t_password,t_phone,t_country,batch_id,uploaded_by,uploaded_date_time,file_type,input_file_name,no_record_uploaded,error_records,t_gender,t_email) VALUES ('$t_id','$t_firstname','$t_middlename','$t_lastname','$dept_name1','$school_name','$school_id','$t_date','$password','$m_no','".$arr[$i]["H"]."','$batch_id','$uploaded_by','$date','$file_type1','$input_file_name','$totalrecords','$err_flag','". trim($allDataInSheet[$i]["F"])."','$email_id')";
						$count13 = mysql_query($sql_insert13) or die(mysql_error()); 
					
					}
					
		}  // for loop closing
	}  // else flag closing
// -----------------------------------------Code For Batch Master ------------------------------
				/*$query4="select count(case when `error_records`= 'Err-Phone/Email' then 1 else null end) as PHONE,
				count(case when `error_records`='Err-Tid' then 1 else null end) as TID,
				count(case when  `error_records`='Err-Dept' then 1 else null end) as DEPT,
				count(case when `error_records`='Err-Name' then 1 else null end) as NAME,
				count(case when `error_records`='Err-SCID' then 1 else null end) as SCID
				from  tbl_raw_teacher where `t_school_id`='$school_id' and batch_id like '$batch_id'";
				$row4=mysql_query($query4);
				$value4=mysql_fetch_array($row4);
				$phone=$value4['PHONE'];
				$tid=$value4['TID'];
				$dept=$value4['DEPT'];
				$name=$value4['NAME'];
				$wrong_scid=$value4['SCID']; */
				$error_count=$insertc+$count_dup+$count_of_updates+$sc_id+$bad_tid;
				$correct_records=$totalrecords-($error_count-1);
				if($correct_records>=0)
				{
					$tbl_name="Teacher_Master";
					$db_tbl_name="tbl_teacher";
					$sql_insert10="INSERT INTO `tbl_Batch_Master`(school_id,batch_id,input_file_name,file_type,uploaded_date_time,uploaded_by,num_records_uploaded,num_errors_records,num_duplicates_record,num_correct_records,num_records_updated,display_table_name,db_table_name,num_errors_scid,num_newrecords_inserted,num_errors_name,num_errors_sprn)
					 VALUES ('$school_id','$batch_id','$input_file_name','$file_type1','$date','$uploaded_by','$totalrecords','$error_count','$count_dup','$correct_records','$count_of_updates','$tbl_name','$db_tbl_name','$sc_id','$insertc','$invalid_nm','$bad_tid')";
					 $count10 = mysql_query($sql_insert10) or die(mysql_error());
				}

// -----------------------------------------End of Batch Master ------------------------------


 }  // close of upload limit
else
{
	echo "<script type=text/javascript>alert('Plz select upload limit'); window.location=''</script>";
}

/* }else
{
	echo "<script type=text/javascript>alert('Plz select College Mnemonic '); window.location=''</script>";
} */
}


echo "<script type=text/javascript>alert('file is successfully added'); window.location=''</script>";
}







 else
 {
    //nofile="No file selected <br />";
  //echo "<script type=text/javascript>alert('No file selected'); window.location=''</script>";
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
H3	{
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
width: 35%;
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
          <div class='panel-heading'>
             
                <h3>Add Teacher Excel Sheet</h3>
            
            
               
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
                                        <form method="post" action="#">
                                        	<select name="limit" class="limitofuploadingrecords" id="limit" style="width:20%; height:30px; border-radius:2px;margin-left:445px;">
                                              <option value="20" disabled selected>Set upload Records Limit</option>
											  <option value="1">1</option>
											  <option value="4">4</option>
											   <option value="100">100</option>
											  <option value="500">500</option>
											  <option value="800">800</option>
											  <option value="900">900</option>
											  <option value="950">950</option>
											  <option value="1000">1000</option>
											   <option value="1500">1500</option>
											   <option value="2000">2000</option>
											  </select>
											
                                             </div> 											
											</div>
											
                  		<!--<label class='control-label col-md-2 col-md-offset-2' for='id_title'></label>-->
                    <div class='col-md-4'>
                        <div class='col-md-4 indent-small' style="padding-left:100px">
                            <input type='file' name='file'  id='file' size='30' onChange="ValidateSingleInput(this);" style="margin-left:355px;margin-top:20px"/>                          </div> 
                    </div>
					<br><br>
                  </div>
                  <div style="height:50px;"></div>
                  <div class='form-group'>
                                <div class='col-md-offset-3 col-md-3' style="padding-left:140px;margin-top:-35px">
                                  <input class='btn-lg btn-primary' type='submit' value="Submit" name="submit" />
                                </div>
								
                                <div class='col-md-3' style="margin-top:-35px">
								 <a href="teacher_setup.php" style="text-decoration:none;">
                            <!--<button class='btn-lg btn-danger'  type='submit'>Cancel</button>-->
							<!--Height parameter added by Rutuja for SMC-4420 on 13/01/2020-->
								   <input type="button" class="btn btn-danger" name="Cancel" value="Back" style="width:80px;font-weight:bold;font-size:14px;height: 47px;" /></a>
								  </a>
                                </div>
                                </div>
                                <div class="row">
                                    <div class='col-md-6 col-md-offset-2' align="center" style="color:black;margin-top:15px;padding-left:201px;">
									 	
                                    <?php
									
											echo $reports1."<br>";
											echo $reports."<br>";
											echo $report."<br>";
									
									
									?>
									
            
            
               
                                     </div>
                                    </div>
                                </div>
                 
         </form>
		 
		 
		 
		 
		 
		 
	</div>
	  
	<!--<div class='col-md-12 col-md-offset-2' align="right" style="padding-right:190px;">
									 	 <?php $query2="select * from `tbl_raw_teacher` WHERE t_school_id='$school_id' ORDER BY id DESC LIMIT 1 ";  //query for getting last batch_id what else if are inserting first time data
												$row2=mysql_query($query2);
												$value2=mysql_fetch_array($row2);
												$batch_id1=$value2['batch_id'];
												$b_id=explode("-",$batch_id1);
												$b=$b_id[1];
												$b1=$b_id[0];
												$bat_id=$b;
												$batch_id=$b1."-".$bat_id;?>	
                                    <h5><?php echo "Batch"." ". $batch_id." "."Uploaded Successfully by"." ".$uploaded_by."<br>"?></h5>
                                    </div>-->
</div>







<div class="row">
<div class="col-md-1"></div>
<div class="col-md-12 ">
<table cellpadding="12" cellspacing="6" align="center">
<tr bgcolor="#9900CC">
<center><a href="download_stud_upload_format.php?name=<?php echo "T";?>">Download Teacher Upload Excel Sheet Format</a></center><tr>
<center><?php for($space=1;$space<=25;$space++){?>&nbsp;<?php }?>
<a href="download_stud_upload_format.php?name=<?php echo "ET";?>">Download Teacher Error Excel Sheet</a></center><tr>

</table>
</div>
</div>

</form>



</body>

</html>
<?php
		
	}
	
?>