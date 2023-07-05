<?php
error_reporting(0);
if(isset($_GET['id']))
{

	 include_once("school_staff_header.php");
	$reports="";
	$report="";
	$c="";
	$u="";
	$count_of_duplicates="";
	$count_of_updates="";	 
	$id=$_SESSION['staff_id'];
	$query="select * from `tbl_school_adminstaff` where id='$id'";       // uploaded by
	$row1=mysql_query($query);
	$value1=mysql_fetch_array($row1);
	$uploaded_by=$value1['stf_name'];
	$date=date('Y-m-d h:i:s',strtotime('+330 minute'));
	$s_date = date('m/d/Y');																										//$_FILES['file']['type']."<br>"; 
	$temp = explode(".",$_FILES["file"]["name"]); 
	$file_type=$temp[1];
	$input_file_name=$temp[0].".".$temp[1];
	$file_t1=explode(".", $_FILES['file']['type']);	
	$file_type1=$file_t1[1]." ".$file_t1[2];
																				
	$id=$_SESSION['staff_id'];
			  
		   
		  
		   
$results=mysql_query("select * from `tbl_school_adminstaff` where id='$id'");
$arrs=mysql_fetch_array($results);

		    $school_id=$arrs['school_id'];
			$school_name=$arrs['school_name'];
$uploadedStatus = 0;

if ( isset($_POST["submit"]) ) {
if (isset($_FILES["file"])) {
//if there was an error uploading the file

if($_FILES['file']['error']>0) {
		echo "<script type=text/javascript>alert('No file selected'); window.location=''</script>";

}
else {
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

$query2="select * from `tbl_raw_student` WHERE s_school_id='$school_id' ORDER BY id DESC LIMIT 1 ";  //query for getting last batch_id what else if are inserting first time data
$row2=mysql_query($query2);
$value2=mysql_fetch_array($row2);
$batch_id1=$value2['batch_id'];
$b_id=explode("-",$batch_id1);
$b=$b_id[1]; 
$bat_id=$b+1;
$batch_id="B"."-".$bat_id;




$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet
$totalrecords=$arrayCount-1;
$arr=array();
$email_already=array();
 $j=0;


$value = $objPHPExcel->getActiveSheet()->getCell('A2')->getValue();
 if($school_id==$value)
 { 
$sc_id=$s_id[0];
$limit=$_POST['limit']; 
$upload_limit=$limit+1;	
if($limit>0)
{

for($i=2;$i<=$upload_limit;$i++)                // for loop start
{

	
				$arr[$i]["B"]=str_replace("'","",trim($allDataInSheet[$i]["B"]));   // student_reg_no.
				$arr[$i]["C"]=str_replace("'","",trim($allDataInSheet[$i]["C"]));  // student complete name
				$arr[$i]["D"]=str_replace("'","",trim($allDataInSheet[$i]["D"]));   // student mobile
				$arr[$i]["E"]=str_replace("'","",trim($allDataInSheet[$i]["E"]));   // Branch Name
				$arr[$i]["F"]=str_replace("'","",trim($allDataInSheet[$i]["F"]));    // Year
				$arr[$i]["G"]=str_replace("'","",trim($allDataInSheet[$i]["G"]));   // Gender
				
				$arr[$i]["H"]=str_replace("'","",trim($allDataInSheet[$i]["H"]));   // Email-ID
				$arr[$i]["I"]=str_replace("'","",trim($allDataInSheet[$i]["I"]));    // Country
				$arr[$i]["J"]=str_replace("'","",trim($allDataInSheet[$i]["J"]));    // Father's Name
				$arr[$i]["K"]=str_replace("'","",trim($allDataInSheet[$i]["K"]));    // DOB
				$arr[$i]["L"]=str_replace("'","",trim($allDataInSheet[$i]["L"]));    // DEPT.
				 
				$arr[$i]["M"]=str_replace("'","",trim($allDataInSheet[$i]["M"]));    // Permanant Address
				$arr[$i]["N"]=str_replace("'","",trim($allDataInSheet[$i]["N"]));    //City
				
				$arr[$i]["O"]=str_replace("'","",trim($allDataInSheet[$i]["O"]));    //Temp Address
				$arr[$i]["P"]=str_replace("'","",trim($allDataInSheet[$i]["P"]));    //Permanant Village
				$arr[$i]["Q"]=str_replace("'","",trim($allDataInSheet[$i]["Q"]));    //Permanant Taluka
				$arr[$i]["R"]=str_replace("'","",trim($allDataInSheet[$i]["R"]));    //Permanant Dist.
				$arr[$i]["S"]=str_replace("'","",trim($allDataInSheet[$i]["S"]));    //Permanant PIN
				$arr[$i]["T"]=str_replace("'","",trim($allDataInSheet[$i]["T"]));    //Internal Email
				$arr[$i]["U"]=str_replace("'","",trim($allDataInSheet[$i]["U"]));    //Specialization
				$arr[$i]["V"]=str_replace("'","",trim($allDataInSheet[$i]["V"]));    //Course Level
				$arr[$i]["W"]=str_replace("'","",trim($allDataInSheet[$i]["W"]));    //Academic Year
			
				
                
				$std_reg_no=$allDataInSheet[$i]["B"];   // for Student Reg. No.
				$s_no=explode(" ",$std_reg_no);
				$s_reg_no= $s_no[0];
				$sprn_lenght=strlen(trim(($s_reg_no)));
				
				$mobile_no=$allDataInSheet[$i]["D"];   // for Mobile Number
				$m_name=explode(" ",$mobile_no);
				$m_no=$m_name[0];
				$m_lenght=strlen(trim(($m_no)));
				
				$email_id1=$allDataInSheet[$i]["H"];
				$e_id=explode(" ",$email_id1);
				$email_id=$e_id[0];
				$email_lenght=strlen(trim(($email_id)));
															
																 //$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_";
																 //$password = substr( str_shuffle( $chars ), 0, 8 );
				if($sprn_lenght>0)
				{					
                    
				$row=mysql_query("select s_PRN from tbl_raw_student where s_PRN='$s_reg_no'");
                                 
				
				if(mysql_num_rows($row)<=0)
				{
																						
		        $std_name=$allDataInSheet[$i]["C"];
				$first_name=explode(" ",$std_name); // for student name
				$s_firstname=$first_name[0];
				$s_middlename=$first_name[1];
				$s_lastname=$first_name[2];  
				
                $s_f=strlen(trim(($s_firstname)));
                $s_m=strlen(trim(($s_middlename)));	
				$s_l=strlen(trim(($s_lastname)));	
				
				$password=$s_firstname."123";
			
				
				$branch_name=$allDataInSheet[$i]["E"];   // for Branch name
				$b_name=explode(" ",$branch_name);
				$branch_name1=$b_name[0];
				
				
				
				
										
                                        $err_flag="Correct";
										$sql_insert1="INSERT INTO `tbl_raw_student` (s_dept,s_PRN,s_firstname,s_middlename,s_lastname,s_school_name,s_school_id,s_date,s_password,s_email,s_phone,s_branch,s_year,s_gender,s_country,batch_id,input_file_name,no_record_uploaded,file_type,uploaded_date_time,uploaded_by,error_records,Course_level,Academic_Year)
										VALUES ('".$arr[$i]["L"]."','$s_reg_no','$s_firstname','$s_middlename','$s_lastname','$school_name','$school_id','$s_date','$password','$email_id','$m_no','$branch_name1','".$arr[$i]["F"]."','".$arr[$i]["G"]."','".$arr[$i]["I"]."','$batch_id','$input_file_name','$totalrecords','$file_type1','$date','$uploaded_by','$err_flag','".$arr[$i]["V"]."','".$arr[$i]["W"]."')";
									    
										$result_insert1 = mysql_query($sql_insert1) or die(mysql_error()); 
										$reports1="You are successfully registered with Smart Cookie";
										
									 
        			   
									
										  if($result_insert1>=1)
										 { 
									       
									           $sql_insert9="INSERT INTO `tbl_student` 
												(std_PRN,std_name,std_name,std_lastname,std_school_name,school_id,std_date,std_password,std_email,std_phone,std_branch,std_year,std_gender,std_country,batch_id,error_records,std_dept,Course_level,Academic_Year)
												SELECT s_PRN,s_firstname,s_middlename,s_lastname,s_school_name,s_school_id,s_date,s_password,s_email,s_phone,s_branch,s_year,s_gender,s_country,batch_id,error_records,s_dept,Course_level,Academic_Year
												FROM `tbl_raw_student` WHERE s_PRN='$s_reg_no' AND s_school_id='$school_id'"; 
												$count9 = mysql_query($sql_insert9) or die(mysql_error()); 
											
											   $sql_update="UPDATE `tbl_raw_student` SET error_records='Import' WHERE s_PRN='$s_reg_no' AND s_school_id='$school_id'";
											   $retval = mysql_query($sql_update) or die('Could not update data: ' . mysql_error());
							
												
												   
											}	
				}   // closing of if row<0
				
		else
		{
			//echo "<script type=text/javascript>alert('duplicate '); window.location=''</script>";
		    $count_of_duplicates=++$c;
			if($s_f>0 && $s_l>0)
                 {		
			        
								
						/* if(!empty($branch_name1) || strlen(trim(($branch_name1)))!=0)
						{ 
		            
							if(!empty($s_reg_no) || strlen(trim(($s_reg_no)))!=0)
							{
					            
								  if(!empty($m_no) || $m_lenght!=0)
								  { 
							        $emailval = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/';
									$mob="/^[789][0-9]{9}$/";
							        if(preg_match($mob,$m_no) || preg_match($emailval, $email_id)) 
								    { 	
				            
									  if($m_lenght == 10 || $email_lenght>0)
									{      */
								      
								         
								          //$err_flag="Correct";
										 $sql_update1="UPDATE `tbl_student` SET std_complete_name='".$arr[$i]["C"]."',std_complete_father_name='".$arr[$i]["J"]."',std_dob='".$arr[$i]["K"]."',permanent_address='".$arr[$i]["M"]."',
										 std_city='".$arr[$i]["N"]."',Temp_address='".$arr[$i]["O"]."',Permanent_village='".$arr[$i]["P"]."',Permanent_taluka='".$arr[$i]["Q"]."',
										 Permanent_district='".$arr[$i]["R"]."',Permanent_pincode='".$arr[$i]["S"]."',Email_Internal='".$arr[$i]["T"]."',Specialization='".$arr[$i]["U"]."',std_dept='".$arr[$i]["L"]."',Course_level='".$arr[$i]["V"]."',Academic_Year='".$arr[$i]["W"]."'
										 WHERE std_PRN='$s_reg_no' AND school_id='$school_id'";
										 
										 $retval11 = mysql_query($sql_update1) or die('Could not update data: ' . mysql_error());
										 $report="Duplicates record Updated successfully.";
									/* }
									}
								  }
							}
						} */
				 }
            								  
									
			
		}
		if($retval11>0)
					{
			
							$count_of_updates=++$u;	   // for counting number of Updates records
							
					}
		
				}else
				{
					                    
										$reports="plz put student PRN in excel sheet.";
				}
      	   
		
} // for loop closing
$query4="select count(case when `error_records`= 'Err-Phone/Email' then 1 else null end) as PHONE,
				count(case when `error_records`='Err-Branch' then 1 else null end) as BRANCH,
				count(case when  `error_records`='Err-SPRN' then 1 else null end) as SPRN,
				 count(case when `error_records`='Err-Name' then 1 else null end) as NAME
				 from  tbl_raw_student where `s_school_id`='$school_id' and batch_id like '$batch_id'";       
			$row4=mysql_query($query4);
			$value4=mysql_fetch_array($row4);
			$phone=$value4['PHONE'];
			$branch=$value4['BRANCH'];
			$s_prn=$value4['SPRN'];
			$name=$value4['NAME'];
			$error_count=$phone+$branch+$s_prn+$name;
			$correct_records=$totalrecords-$error_count-$count_of_duplicates;

			$sql_insert10="INSERT INTO `tbl_Batch_Master`(batch_id,input_file_name,file_type,uploaded_date_time,uploaded_by,num_records_uploaded,num_errors_records,num_duplicates_record,num_correct_records,num_records_updated)
			 VALUES ('$batch_id','$input_file_name','$file_type1','$date','$uploaded_by','$totalrecords','$error_count','$count_of_duplicates','$correct_records','$count_of_updates')";
			$count10 = mysql_query($sql_insert10) or die(mysql_error()); 


}
else
{
	echo "<script type=text/javascript>alert('Plz select upload limit'); window.location=''</script>";
}
  }
	else
	{
		echo "<script type=text/javascript>alert('School ID did not match plz import right excel sheet '); window.location=''</script>";
	}      
		
     }  
								
	}    //for exist name
							
						 // file upload closing
								
							
	             	else
	                {
	
						   //$nofile="No file selected <br />";
						   echo "<script type=text/javascript>alert('No file selected'); window.location=''";	
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
          <div class='panel-heading'>
             
                <h3>Add Student Excel Sheet</h3>
            
            
               
              </div>
			
			
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
											  <option value="500">500</option>
											  <option value="600">600</option>
											   <option value="700">700</option>
											  <option value="800">800</option>
											  <option value="900">900</option>
                                              <option value="1000">1000</option>
                                              <option value="1500">1500</option>
                                              <option value="2500">2500</option>
                                              <option value="5000">5000</option>
                                              <option value="15000">15000</option>
                                              <option value="20000">20000</option>
                                              <option value="25000">25000</option>
                                              <option value="30000">30000</option>
											 
											</div>
											</div>
											</form>
                  		<label class='control-label col-md-2 col-md-offset-2' for='id_title'></label>
                    <div class='col-md-8'>
                        <div class='col-md-8 indent-small' style="padding-left:100px">
                            <input type='file' name='file'  id='file' size='30' onChange="ValidateSingleInput(this);" style="margin-left: 455px;margin-top:20px"/>                          </div> 
                    </div>
                  </div>
                  <div style="height:50px;"></div>
                  <div class='form-group'>
                                <div class='col-md-offset-3 col-md-3' style="padding-left:155px;margin-top:-35px">
                                  <input class='btn-lg btn-primary' type='submit' value="Submit" name="submit" />
                                </div>
                                <div class='col-md-3' style="margin-top:-35px">
                                  <button class='btn-lg btn-danger'  type='submit'>Cancel</button>
                                </div>
                                </div>
                                <div class="row">
                                    <div class='col-md-6 col-md-offset-2' align="center" style="color:black;margin-top:15px;padding-left:201px;">
									 	
                                    <?php echo $reports1."<br>";
									echo $reports."<br>";
									echo $report."<br>";;
									echo $no_rows;
									
									?>
									
            
            
               
                                     </div>
                                    </div>
                                </div>
                 
         </form>
		 
		 
		 
		 
		 
		 
	</div>
	  
	<div class='col-md-12 col-md-offset-2' align="right" style="padding-right:190px;">
									 <?php $query2="select * from `tbl_raw_student` WHERE s_school_id='$school_id' ORDER BY id DESC LIMIT 1 ";  //query for getting last batch_id what else if are inserting first time data
											$row2=mysql_query($query2);
											$value2=mysql_fetch_array($row2);
											$batch_id1=$value2['batch_id'];
											$b_id=explode("-",$batch_id1);
											$b=$b_id[1]; 
											$bat_id=$b;
											$batch_id="B"."-".$bat_id;?>	
                                    <h5><?php echo "Batch"." ". $batch_id." "."Uploaded Successfully by"." ".$uploaded_by."<br>"?></h5>
                                    </div>
</div>







<div class="row">
<div class="col-md-1"></div>
<div class="col-md-12 ">
<table cellpadding="12" cellspacing="6" align="center">
<tr bgcolor="#9900CC">

<th bgcolor="#CCCCCC">School ID</th>
<th bgcolor="#CCCCCC">Student PRN</th>
<th bgcolor="#CCCCCC">Student Name</th>
<th bgcolor="#CCCCCC">Mobile Number</th>
<th bgcolor="#CCCCCC">Branch Name</th>
<th bgcolor="#CCCCCC">Year</th>
<th bgcolor="#CCCCCC">Gender</th>
<th bgcolor="#CCCCCC">Email-ID</th>
<th bgcolor="#CCCCCC">Country</th>

<tr>


</table>
</div>
</div>





</body>

</html>


<!--  -------------------------------------  1st Block Exit  ---------------------------------------  -->
<?php
}
else
{
	error_reporting(0);
	include("scadmin_header.php");
	include("error_function.php");
	$reports="";
	$report="";
	$sc_id=0;
	$id=$_SESSION['id'];
	$query="select * from `tbl_school_admin` where id='$id'";       // uploaded by
	$row1=mysql_query($query);
	$value1=mysql_fetch_array($row1);
	$uploaded_by=$value1['name'];
	$date=date('Y-m-d h:i:s',strtotime('+330 minute'));
	$s_date = date('m/d/Y');																										//$_FILES['file']['type']."<br>"; 
	$temp = explode(".", $_FILES["file"]["name"]); 
	$file_type=$temp[1];
	$input_file_name=$temp[0].".".$temp[1];
	$file_t1=explode(".", $_FILES['file']['type']);	
	$file_type1=$file_t1[1]." ".$file_t1[2];
																
			//$id=$_SESSION['id'];
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
				if ( isset($_FILES["file"]))
					{
						//if there was an error uploading the file
						if ($_FILES["file"]["error"] > 0) 
						{
							echo "Return Code: ".$_FILES["file"]["error"]."<br />";
						}
						else {														// DO Changes In below Code
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
							} 		catch(Exception $e) 
							{
								die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
							}


	$mnemonic=$school_id; 
	$query2="select batch_id from `tbl_raw_student` WHERE s_school_id='$school_id' ORDER BY id DESC LIMIT 1 ";  //query for getting last batch_id what else if are inserting first time data
	$row2=mysql_query($query2);
	$value2=mysql_fetch_array($row2);
	$batch_id1=$value2['batch_id'];
	$b_id=explode("-",$batch_id1);
	$b=$b_id[1]; 
	$bat_id=$b+1;
	$str=str_pad($bat_id, 3, "00", STR_PAD_LEFT);
	$batch_id=$mnemonic."_B"."-".$str;




				$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
				$arrayCount=count($allDataInSheet);  // Here get total count of row in that Excel sheet
				//$totalrecords=$arrayCount-1;
				$arr=array();
				$email_already=array();
				 $j=0;

				$validate=0;
				$sc_id=$s_id[0];
				$limit=$_POST['limit']; 
				$count_of_insert="";
				$count_of_duplicates="";
				$dup=0;
				$count_of_updates="";
				$upd=0;
				$sch_id=0;
				$val="";
				$validate=0;
				$count_of_wrong_school_id="";	
				$SPRN=0;
				$not_validate=0;

				$upload_limit=$limit+1;
				$min=min($upload_limit,$arrayCount);
				$totalrecords=$min-1;
if($limit>0)
{
	$flag=$_POST['flag'];
	if($flag==1)
	{
		
			
	  $insert=0; $list = array();
      try
	  {
		 $file = fopen("/home/content/84/7121184/html/smartcookies/CSV/student_error.csv","w+") or die("Unable to open file for output");
		  //$file = fopen("/home/content/84/7121184/html/tsmartcookie/CSV/student_error.csv","w+") or die("Unable to open file for output");
		 // fwrite($file,$sn. "," . "School_id" . ", " . "Student PRN" . ", " . "Name" . ", " . "phone" . ", " . "Branch name" . ", " . "Year" . "," . "Gender" . "," . "Email-Id" . " ," .  "Country". "," . "Father name" . "," . "DOB" . "," . "Class" . "," . "Permanant address" . "," . "City" . "," . "Temp address" . "," . "Permanant village" . "," . "Permanant taluka" . "," . "Permanant district" . "," . "Permanant PIN" . "," . "Internal Email" . "," . "Specialization" . "," . "Course Level" . "," . "Academic Year" . "," . "Dept. name" . "," . "Total Errorrs found" ."\n");
		fwrite($file,$sn. "," . "School_id" . ", " . "Insert Count" . ", " . "Duplicate Count" . ", " . "Update Count" . ", " . "Wrong School ID Count" . "," . "SPRN Error count" . "," . "Name not validated" . ", " . "Validation count" ."\n");
		for($i=2;$i<=$min;$i++)
		{
			
			$value = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
			$sch_lenght=strlen(trim(($value)));
			if(trim($school_id)==trim($value))
			{ 
				$arr[$i]["B"]=str_replace("'","", trim($allDataInSheet[$i]["B"]));   // student_prn_no.
				$arr[$i]["C"]=str_replace("'","", trim($allDataInSheet[$i]["C"]));  // student name
				$arr[$i]["D"]=str_replace("'","", trim($allDataInSheet[$i]["D"]));   // student mobile
				$arr[$i]["E"]=str_replace("'","", trim($allDataInSheet[$i]["E"]));   // Branch Name
				$arr[$i]["F"]=str_replace("'","", trim($allDataInSheet[$i]["F"]));    // Year
				$arr[$i]["G"]=str_replace("'","", trim($allDataInSheet[$i]["G"]));   // Gender
				$arr[$i]["H"]=str_replace("'","", trim($allDataInSheet[$i]["H"]));   // Email-ID
				$arr[$i]["I"]=str_replace("'","", trim($allDataInSheet[$i]["I"]));    //Country
				$arr[$i]["J"]=str_replace("'","", trim($allDataInSheet[$i]["J"]));    // Father's Name
				$arr[$i]["K"]=str_replace("'","", trim($allDataInSheet[$i]["K"]));    // DOB
				$arr[$i]["L"]=str_replace("'","", trim($allDataInSheet[$i]["L"]));    // Student Class
				$arr[$i]["M"]=str_replace("'","", trim($allDataInSheet[$i]["M"]));    // Permanant Address
				$arr[$i]["N"]=str_replace("'","", trim($allDataInSheet[$i]["N"]));    //City
				$arr[$i]["O"]=str_replace("'","", trim($allDataInSheet[$i]["O"]));    //Temp Address
				$arr[$i]["P"]=str_replace("'","", trim($allDataInSheet[$i]["P"]));    //Permanant Village
				$arr[$i]["Q"]=str_replace("'","", trim($allDataInSheet[$i]["Q"]));    //Permanant Taluka
				$arr[$i]["R"]=str_replace("'","", trim($allDataInSheet[$i]["R"]));    //Permanant Dist.
				$arr[$i]["S"]=str_replace("'","", trim($allDataInSheet[$i]["S"]));    //Permanant PIN
				$arr[$i]["T"]=str_replace("'","", trim($allDataInSheet[$i]["T"]));    //Internal Email
				$arr[$i]["U"]=str_replace("'","", trim($allDataInSheet[$i]["U"]));    //Specialization
				$arr[$i]["V"]=str_replace("'","", trim($allDataInSheet[$i]["V"]));    //Course Level
				$arr[$i]["W"]=str_replace("'","", trim($allDataInSheet[$i]["W"]));    //Academic Year
				$arr[$i]["X"]=str_replace("'","", trim($allDataInSheet[$i]["X"]));    //Dept. Name
				
														
				
				
                $std_reg_no=$allDataInSheet[$i]["B"];   // for Student Reg. No.
				$s_no=explode(" ",$std_reg_no);
				$s_reg_no = $s_no[0];
				$sprn_lenght=strlen(trim(($s_reg_no)));
				$a=preg_match('/^[0-9]+$/',$std_reg_no);	
				
				$std_name=$arr[$i]["C"];
				$first_name=explode(" ",$std_name); // for student name
				$s_firstname=$first_name[0];
				$s_middlename=$first_name[1];
				$s_lastname=$first_name[2];
				$s_f=strlen(trim(($s_firstname)));
				$s_m=strlen(trim(($s_middlename)));	
				$s_l=strlen(trim(($s_lastname)));				
				$b=preg_match("/^[a-zA-Z ]+$/",$std_name);
				
				
				$mobile_no=$allDataInSheet[$i]["D"];   // for Mobile Number
				$m_name=explode(" ",$mobile_no);
				$m_no=$m_name[0];
				$m_lenght=strlen(trim(($m_no)));
				$c=preg_match('/^[0-9]*$/', $m_no);
				
				$branch_name=$arr[$i]["E"];
				$d=preg_match("/^[a-zA-Z ]*$/",$branch_name);
				
				$year=$arr[$i]["F"];
				$e=preg_match('/^[0-9]*$/', $year);
				
				$gender=$arr[$i]["G"];
				$f=preg_match("/[a-zA-Z'-]/",$gender);
				
				$email_id1=$allDataInSheet[$i]["H"];
				$e_id=explode(" ",$email_id1);
				$email_id=$e_id[0];
				$email_lenght=strlen(trim(($email_id)));
				$g=filter_var($email_id, FILTER_VALIDATE_EMAIL);
															
				$Country=$arr[$i]["I"];
				$h=preg_match("/^[a-zA-Z ]*$/",$Country);
				
				$father_name=$arr[$i]["J"];
				$ik=preg_match("/^[a-zA-Z ]*$/",$father_name);
				
				$dob=$arr[$i]["K"];
				$date_regex = "/([1-9]|0[1-9]|1[1-9]|2[1-9]|3[0-1])[ \/.-]([1-9]|0[1-9]|1[1-2])[ \/.-](19|20)\d\d/";
				$j=preg_match($date_regex,$dob);
				
				//$std_class=$arr[$i]["L"];
				//$k=preg_match('/(?:[A-Za-z].*?\d|\d.*?[A-Za-z]*$)/',$std_class);
				
				$permanant_add=$arr[$i]["M"];
				$find = array(",",".");
				$add=str_replace($find,"",$permanant_add);
				$l=preg_match('/^\s*[a-z0-9\s]+$/i',$add);
				
				$city=$arr[$i]["N"];
				$m=preg_match('/^[a-zA-Z ]*$/',$city);
				
				$temp_add=$arr[$i]["O"];
				$find1 = array(",",".");
				$add1=str_replace($find1,"",$temp_add);
				$n=preg_match('/^[a-zA-Z ]*$/',$add1);
				
				$p_village=$arr[$i]["P"];
				$o=preg_match('/^[a-zA-Z ]*$/',$p_village);
				
				$p_taluka=$arr[$i]["Q"];
				$p=preg_match('/^[a-zA-Z ]*$/',$p_taluka);
				
				$p_dist=$arr[$i]["R"];
				$q=preg_match('/^[a-zA-Z ]*$/',$p_dist);
				
				$p_pin=$arr[$i]["S"];
				$r=preg_match('/^[0-9]*$/',$p_pin);
				
				$internal_email=$arr[$i]["T"];
				$s=filter_var($internal_email, FILTER_VALIDATE_EMAIL);
				
				$specialization=$arr[$i]["U"];
				$find2 = array(",",".");
				$spec=str_replace($find2,"",$specialization);
				$t=preg_match('/^[a-zA-Z ]*$/',$spec);
				
				$course_level=$arr[$i]["V"];
				$find3 = array(",",".");
				$spec=str_replace($find3,"",$course_level);
				$u=preg_match('/^[a-zA-Z ]*$/',$spec);
				
				$A_year=$arr[$i]["W"];
				$v=preg_match('/^[0-9_-]*$/',$A_year);
				
				$dept=$arr[$i]["X"];
				$w=preg_match('/^[a-zA-Z ]*$/',$dept);
				
				
				if($sprn_lenght>0)
				{
					$row=mysql_query("select std_PRN from tbl_student where std_PRN='$s_reg_no' and school_id='$school_id'");
					
					if(mysql_num_rows($row)==0)
					{
						 
				          if($s_f>0 || $s_l>0)
						  {
							   $list[$insert] = $s_reg_no;
							   
				          		++$insert;
								
						  }else{++$name_not_validated;}						  
        			   
									
										 
					}   // closing of if row<0
				
					else
					{
						
						++$dup;
					
            		}						  
									
			
		         
				}else{
						if($a==1 && $sprn_lenght>0)
						$SPRN++;
				    }
				
				
					
		
					
			}else
					{ 
					 if($sch_lenght>0 && !empty($value))
						{
							 $sch_id++;
						}
						
					}
		        
				
				
				if($a && $b && $c && $d && $e && $f && $g && $h && $ik && $j && $l && $m && $n && $o && $p && $q && $r && $s && $t && $u && $v && $w && $m_lenght==10)
						{							
							if(empty($std_reg_no) || empty($std_name) || empty($m_no) || empty($branch_name) || empty($year) || empty($gender) || empty($email_id) || empty($Country) || empty($father_name) || empty($dob) || empty($std_class) || empty($permanant_add) || empty($city) || empty($temp_add) || empty($p_village) || empty($p_taluka) || empty($p_dist) || empty($p_pin) || empty($internal_email) || empty($specialization) || empty($course_level) || empty($A_year) || empty($dept))
							{
							  
							  ++$validate;					
							}
												
														 	
						}else{
								
							     ++$not_validate;	
							 }		
				
				
			
			
		}	// for closing
			
		
			fwrite($file,$sn. ", " . $school_id . ", " .$insert . "," . $dup. ", " .$dup . ", " .$sch_id. "," .$SPRN. "," .$name_not_validated. ", " . $validate .  "\n");
			$abc=$insert;
			$ep=$abc-1;
			while($ep>=0){
			fwrite($file,$sn. ",".$sn. ", " . $list[$ep] ."\n");
			  $ep--;
			} 
				
			echo "<script type=text/javascript>alert('File has been scan successfully...'); window.location=''</script>";
		    fclose($file);
	} 							//try closing
	 catch (Exception $e) 
			{ 
				echo $e->errorMessage(); 
			} 	
			
	echo $totalrecords;
	}   //flag closing
	
	
//             ----------------------- Scan code Completed -------------------------------------
	else
	{	
		
		for($i=2;$i<=$min;$i++)
		{
			$value = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
			if(trim($school_id)==trim($value))
			{ 
		        $replace = array(",","'",".","(",")","/","\",",":","-");
				$replace1=array(",","'"); 
				$arr[$i]["B"]=str_replace($replace1,"", trim($allDataInSheet[$i]["B"]));   // student_prn_no.
				$arr[$i]["C"]=str_replace($replace1,"", trim($allDataInSheet[$i]["C"]));  // student name
				$arr[$i]["D"]=str_replace($replace1,"", trim($allDataInSheet[$i]["D"]));   // student mobile
				$arr[$i]["E"]=str_replace($replace1,"", trim($allDataInSheet[$i]["E"]));   // Branch Name
				$arr[$i]["F"]=str_replace($replace,"", trim($allDataInSheet[$i]["F"]));    // Year
				$arr[$i]["G"]=str_replace($replace1,"", trim($allDataInSheet[$i]["G"]));   // Gender
				$arr[$i]["H"]=str_replace($replace1,"", trim($allDataInSheet[$i]["H"]));   // Email-ID
				$arr[$i]["I"]=str_replace($replace1,"", trim($allDataInSheet[$i]["I"]));    //Country
				$arr[$i]["J"]=str_replace($replace1,"", trim($allDataInSheet[$i]["J"]));    // Father's Name
				$arr[$i]["K"]=str_replace($replace1,"", trim($allDataInSheet[$i]["K"]));    // DOB
				$arr[$i]["L"]=str_replace($replace1,"", trim($allDataInSheet[$i]["L"]));    // Student Class
				$arr[$i]["M"]=mysql_real_escape_string(trim($allDataInSheet[$i]["M"]));    // Permanant Address
				$arr[$i]["N"]=mysql_real_escape_string(trim($allDataInSheet[$i]["N"]));    //City
				$arr[$i]["O"]=mysql_real_escape_string(trim($allDataInSheet[$i]["O"]));    //Temp Address
				$arr[$i]["P"]=mysql_real_escape_string(trim($allDataInSheet[$i]["P"]));    //Permanant Village
				$arr[$i]["Q"]=mysql_real_escape_string(trim($allDataInSheet[$i]["Q"]));    //Permanant Taluka
				$arr[$i]["R"]=mysql_real_escape_string(trim($allDataInSheet[$i]["R"]));    //Permanant Dist.
				$arr[$i]["S"]=str_replace($replace1,"", trim($allDataInSheet[$i]["S"]));    //Permanant PIN
				$arr[$i]["T"]=str_replace($replace1,"", trim($allDataInSheet[$i]["T"]));    //Internal Email
				$arr[$i]["U"]=str_replace($replace,"", trim($allDataInSheet[$i]["U"]));    //Specialization
				$arr[$i]["V"]=str_replace($replace1,"", trim($allDataInSheet[$i]["V"]));    //Course Level
				$arr[$i]["W"]=str_replace($replace1,"", trim($allDataInSheet[$i]["W"]));    //Academic Year
				$arr[$i]["X"]=str_replace($replace1,"", trim($allDataInSheet[$i]["X"]));    //Dept. Name
				
														
				
                $std_reg_no=$arr[$i]["B"];   // for Student Reg. No.
				$s_no=explode(" ",$std_reg_no);
				$s_reg_no= $s_no[0];
				$sprn_lenght=strlen(trim(($s_reg_no)));
				
				$mobile_no=$arr[$i]["D"];   // for Mobile Number
				$m_name=explode(" ",$mobile_no);
				$m_no=$m_name[0];
				$m_lenght=strlen(trim(($m_no)));
				
				$email_id1=$arr[$i]["H"];
				$e_id=explode(" ",$email_id1);
				$email_id=$e_id[0];
				$email_lenght=strlen(trim(($email_id)));
							
			    $std_name=$arr[$i]["C"];
				$first_name=explode(" ",$std_name); // for student name
				$s_firstname=$first_name[0];
				$s_middlename=$first_name[1];
				$s_lastname=$first_name[2];  
				
                $s_f=strlen(trim(($s_firstname)));
                $s_m=strlen(trim(($s_middlename)));	
				$s_l=strlen(trim(($s_lastname)));
				$first_name1=strtolower($s_firstname);				
				$password=$first_name1."123";
				
				$branch_name=$allDataInSheet[$i]["E"];   // for Branch name
				$b_name=explode(" ",$branch_name);
				$branch_name1=$b_name[0];
			
				//----------------------
				$s_Ayr=$arr[$i]["W"];
				$s_dob=$arr[$i]["K"];
				$s_dppt=$arr[$i]["X"];
				$s_brnh=$arr[$i]["E"];
				$s_yr=$arr[$i]["F"];
				$s_county=$arr[$i]["I"];
				$s_fname=$arr[$i]["J"];
				$s_cls=$arr[$i]["L"];
				$s_padd=$arr[$i]["M"];
				$s_cty=$arr[$i]["N"];
				$s_Tadd=$arr[$i]["O"];
				$s_vill=$arr[$i]["P"];
				$s_talu=$arr[$i]["Q"];
				$s_dist=$arr[$i]["R"];
				$s_pin=$arr[$i]["S"];
				$s_int=$arr[$i]["T"];
				$s_spec=$arr[$i]["U"];
				$s_clvl=$arr[$i]["V"];
				$s_gen=$arr[$i]["G"];
				
				
				
				
				
				if($sprn_lenght>0)
				{
					$row=mysql_query("select s_PRN from tbl_raw_student where s_PRN='$s_reg_no' and s_school_id='$school_id'");
						
					if(mysql_num_rows($row)==0)
					{
							
				          if($s_f>0 || $s_l>0)
						  {
				          
                                        $err_flag="Correct";
										$sql_insert1="INSERT INTO `tbl_raw_student` (s_PRN,s_firstname,s_middlename,s_lastname,s_school_name,s_school_id,s_date,s_password,s_email,s_phone,s_branch,s_year,s_gender,s_country,batch_id,input_file_name,no_record_uploaded,file_type,uploaded_date_time,uploaded_by,error_records,s_complete_father_name,s_dob,s_permanant_address,s_city,s_temporary_address,s_permanant_village,s_permanant_taluka,s_permanant_district,s_permanant_pincode,s_specialization,mnemonic,s_complete_name,s_course_level,s_class,s_academic_year,s_dept,s_internal_emailid)
										VALUES ('$s_reg_no','$s_firstname','$s_middlename','$s_lastname','$school_name','$school_id','$s_date','$password','$email_id','$m_no','$branch_name1','".$arr[$i]["F"]."','".$arr[$i]["G"]."','".$arr[$i]["I"]."','$batch_id','$input_file_name','$totalrecords','$file_type1','$date','$uploaded_by','$err_flag','".$arr[$i]["J"]."','".$arr[$i]["K"]."','".$arr[$i]["M"]."','".$arr[$i]["N"]."','".$arr[$i]["O"]."','".$arr[$i]["P"]."','".$arr[$i]["Q"]."','".$arr[$i]["R"]."','".$arr[$i]["S"]."','".$arr[$i]["U"]."','$mnemonic','".$arr[$i]["C"]."','".$arr[$i]["V"]."','".$arr[$i]["L"]."','".$arr[$i]["W"]."','".$arr[$i]["X"]."','$s_int')";
									    
										$result_insert1 = mysql_query($sql_insert1) or die(mysql_error()); 
										$reports1="You are successfully registered with Smart Cookie";
										
						  }else
							   {
								    $err_flag="Err-Name";
									$sql_insert8="INSERT INTO `tbl_raw_student`(s_PRN,s_firstname,s_middlename,s_lastname,s_school_name,s_school_id,s_date,s_password,s_email,s_phone,s_branch,s_year,s_gender,s_country,batch_id,input_file_name,no_record_uploaded,file_type,uploaded_date_time,uploaded_by,error_records,s_complete_father_name,s_dob,s_permanant_address,s_city,s_temporary_address,s_permanant_village,s_permanant_taluka,s_permanant_district,s_permanant_pincode,s_specialization,mnemonic,s_complete_name,s_course_level,s_class,s_academic_year,s_dept)
										VALUES('$s_reg_no','$s_firstname','$s_middlename','$s_lastname','$school_name','$school_id','$s_date','$password','$email_id','$m_no','$branch_name1','".$arr[$i]["F"]."','".$arr[$i]["G"]."','".$arr[$i]["I"]."','$batch_id','$input_file_name','$totalrecords','$file_type1','$date','$uploaded_by','$err_flag','".$arr[$i]["J"]."','".$arr[$i]["K"]."','".$arr[$i]["M"]."','".$arr[$i]["N"]."','".$arr[$i]["O"]."','".$arr[$i]["P"]."','".$arr[$i]["Q"]."','".$arr[$i]["R"]."','".$arr[$i]["S"]."','".$arr[$i]["U"]."','$mnemonic','".$arr[$i]["C"]."','".$arr[$i]["V"]."','".$arr[$i]["L"]."','".$arr[$i]["W"]."','".$arr[$i]["X"]."')";
									    
									$result_insert8 = mysql_query($sql_insert8) or die(mysql_error());  
									$reports="Inserted data from Excel Sheet is not valid data";
							   }							  
        			   
									
										  if($result_insert1>=1)
										 { 
									          $check_student=mysql_query("select std_PRN from tbl_student where std_PRN='$s_reg_no' and school_id='$school_id'");
											  if(mysql_num_rows($check_student)==0)
											 {
									            $sql_insert9="INSERT INTO `tbl_student` 
												(std_PRN,std_name,std_Father_name,std_lastname,std_school_name,school_id,std_date,std_password,std_email,std_phone,std_branch,std_year,std_gender,std_country,batch_id,error_records,std_complete_father_name,std_dob,permanent_address,std_city,Temp_address,Permanent_village,Permanent_taluka,Permanent_district,Permanent_pincode,Specialization,college_mnemonic,std_complete_name,Course_level,std_class,Academic_Year,std_dept,Email_Internal)
												SELECT s_PRN,s_firstname,s_middlename,s_lastname,s_school_name,s_school_id,s_date,s_password,s_email,s_phone,s_branch,s_year,s_gender,s_country,batch_id,error_records,s_complete_father_name,s_dob,s_permanant_address,s_city,s_temporary_address,s_permanant_village,s_permanant_taluka,s_permanant_district,s_permanant_pincode,s_specialization,mnemonic,s_complete_name,s_course_level,s_class,s_academic_year,s_dept,s_internal_emailid
												FROM `tbl_raw_student` WHERE s_PRN='$s_reg_no' AND s_school_id='$school_id'"; 
												$count9 = mysql_query($sql_insert9) or die(mysql_error()); 
											   $sql_update="UPDATE `tbl_raw_student` SET error_records='Import' WHERE s_PRN='$s_reg_no' AND s_school_id='$school_id'";
											   $retval = mysql_query($sql_update) or die('Could not update data: ' . mysql_error());
											 }else
											 {
													
										          $get_stud_info=mysql_query("select * from `tbl_student` where std_PRN='$s_reg_no' AND school_id='$school_id'");
												  while($row2=mysql_fetch_array($get_stud_info))
													{

									
																$stud_prn=trim($row2['std_PRN']);
																$stud_cname=trim($row2['std_complete_name']);
																//$stud_cname_len=strlen(trim(($stud_cname)));
																$stud_dob=trim($row2['`std_dob`']);
																$stud_schid=trim($row2['school_id']);
																$stud_branch=trim($row2['std_branch']);
																$stud_dept=trim($row2['std_dept']);
																$stud_year=trim($row2['std_year']);
																$stud_emailid=trim($row2['std_email']);	
																$stud_ph=trim($row2['std_phone']);
																$stud_sem=trim($row2['std_semester']);	
																$stud_int_email=trim($row2['Email_Internal']);
																
																$stud_permadd=trim($row2['permanent_address']);	
																$stud_gen=trim($row2['std_gender']);
																$stud_cfname=trim($row2['std_Father_name']);	
																$stud_city=trim($row2['std_city']);
																
																$stud_tempadd=trim($row2['Temp_address']);	
																$stud_permv=trim($row2['Permanent_village']);
																$stud_permt=trim($row2['Permanent_taluka']);	
																$stud_permd=trim($row2['Permanent_district']);
																
																$stud_permpin=trim($row2['Permanent_pincode']);	
																$stud_spec=trim($row2['Specialization']);
																$stud_clvl=trim($row2['Course_level']);	
																$stud_ayear=trim($row2['Academic_Year']);
														}	
														
																$s_comp_name=explode(" ",$stud_cname); // for student name
																$s_fstname=$s_comp_name[0];
																$s_mname=$s_comp_name[1];
																$s_lname=$s_comp_name[2]; 
																
															   if($stud_schid==$school_id){}
																 else{$sch_val=preg_match("/^[a-zA-Z0-9]",$value);
																	  if($value!="" || $sch_val){
																		$update_schid="UPDATE `tbl_student` SET school_id='$value' where std_PRN='$s_reg_no' AND school_id='$school_id'";
																		$updatesid= mysql_query($update_schid) or die('Could not update data: ' . mysql_error());
																	}
																	}
																														   
															   if($stud_cname==$std_name){}
															   else{$s_cname_val=preg_match("/^[a-zA-Z ]+$/",$std_name);
																   if($s_cname_val){
																		$update_name="UPDATE `tbl_student` SET std_complete_name='$std_name' where std_PRN='$s_reg_no' AND school_id='$school_id'";
																		$update1= mysql_query($update_name) or die('Could not update data: ' . mysql_error());
																	}
																	}
																if($s_fstname==$s_firstname){}
																 else{$s_fname_val=preg_match("/^[a-zA-Z ]*$/",$s_firstname);
																	  if($s_fname_val){
																		$update_fname="UPDATE `tbl_student` SET std_name='$s_firstname' where std_PRN='$s_reg_no' AND school_id='$school_id'";
																		$updatef= mysql_query($update_fname) or die('Could not update data: ' . mysql_error());
																	}
																	}
																if($s_mname==$s_middlename){}
																 else{$s_mname_val=preg_match("/^[a-zA-Z ]*$/",$s_middlename);
																	  if($s_mname_val){
																		$update_smname="UPDATE `tbl_student` SET std_Father_name='$s_middlename' where std_PRN='$s_reg_no' AND school_id='$school_id'";
																		$updatem= mysql_query($update_smname) or die('Could not update data: ' . mysql_error());
																	}
																	}
																if($s_lname==$s_lastname){}
																 else{$s_lname_val=preg_match("/^[a-zA-Z ]*$/",$s_lastname);
																	  if($s_lname_val){
																		$update_slname="UPDATE `tbl_student` SET std_lastname='$s_lastname' where std_PRN='$s_reg_no' AND school_id='$school_id'";
																		$updatel= mysql_query($update_slname) or die('Could not update data: ' . mysql_error());
																	}
																	}    		
															
																if($stud_dob==$s_dob){}
																else{$date_regex = "/([1-9]|0[1-9]|1[1-9]|2[1-9]|3[0-1])[ \/.-]([1-9]|0[1-9]|1[1-2])[ \/.-](19|20)\d\d/";
																	$dov_val=preg_match($date_regex,$s_dob);
																	if($dov_val){	
																		   $update_dob="UPDATE `tbl_student` SET `std_dob`='$s_dob' where std_PRN='$s_reg_no' AND school_id='$school_id'";
																		   $update2= mysql_query($update_dob) or die('Could not update data: ' . mysql_error());
																	}
																	}
																if($stud_branch==$s_brnh){}
																else{$branc_val=preg_match("/^[a-zA-Z ]*$/",$s_brnh);
																		if($branc_val){
																		   $update_branch="UPDATE `tbl_student` SET std_branch='$s_brnh' where std_PRN='$s_reg_no' AND school_id='$school_id'";
																		   $update3= mysql_query($update_branch) or die('Could not update data: ' . mysql_error());
																	}
																	}
																if($stud_dept==$s_dppt){}
																else{$dept_val=preg_match('/^[a-zA-Z ]*$/',$s_dppt);
																		if($dept_val){
																		   $update_dept="UPDATE `tbl_student` SET std_dept='$s_dppt' where std_PRN='$s_reg_no' AND school_id='$school_id'";
																		   $update4= mysql_query($update_dept) or die('Could not update data: ' . mysql_error());
																	}
																	}
																if($stud_year==$s_yr){}
																else{$yr_val=preg_match('/^[0-9]+$/', $s_yr);
																	if($yr_val){
																		   $update_year="UPDATE `tbl_student` SET std_year='$s_yr' where std_PRN='$s_reg_no' AND school_id='$school_id'";
																		   $update5= mysql_query($update_year) or die('Could not update data: ' . mysql_error());
																	}
																	}
																if($stud_emailid==$email_id){}
																else{$e_val=filter_var($email_id, FILTER_VALIDATE_EMAIL);
																		if($e_val){
																		   $update_emailid="UPDATE `tbl_student` SET std_email='$email_id' where std_PRN='$s_reg_no' AND school_id='$school_id'";
																		   $update6= mysql_query($update_emailid) or die('Could not update data: ' . mysql_error());
																		}
																	}	
																if($stud_ph==$m_no){}
																else{$m_val=preg_match('/^[0-9]+$/',$m_no);
																		if($m_val && $m_lenght==10){
																		   $update_ph="UPDATE `tbl_student` SET std_phone='$m_no' where std_PRN='$s_reg_no' AND school_id='$school_id'";
																		   $update7= mysql_query($update_ph) or die('Could not update data: ' . mysql_error());
																		}
																	}	
																if($stud_int_email==$s_int){}
																else{$inte_val=filter_var($s_int, FILTER_VALIDATE_EMAIL);
																		if($inte_val){
																		   $update_inemail="UPDATE `tbl_student` SET Email_Internal='$s_int' where std_PRN='$s_reg_no' AND school_id='$school_id'";
																		   $update8= mysql_query($update_inemail) or die('Could not update data: ' . mysql_error());
																		}
																	}		
																if($stud_permadd==$s_padd){}
																else{if($s_padd!=""){
																		
																		   $update_padd="UPDATE `tbl_student` SET permanent_address='$s_padd' where std_PRN='$s_reg_no' AND school_id='$school_id'";
																		   $update9= mysql_query($update_padd) or die('Could not update data: ' . mysql_error());
																		}
																	}	
																if($stud_gen==$s_gen){}
																else{$gen_val=preg_match("/[a-zA-Z'-]/",$s_gen);
																		if($gen_val){
																		   $update_gen="UPDATE `tbl_student` SET std_gender='$s_gen' where std_PRN='$s_reg_no' AND school_id='$school_id'";
																		   $update10= mysql_query($update_gen) or die('Could not update data: ' . mysql_error());
																		}
																	}	    										
																if($stud_cfname==$s_fname){}
																else{$f_val=preg_match("/^[a-zA-Z ]+$/",$s_fname);
																		if($f_val){
																		   $update_f_name="UPDATE `tbl_student` SET std_Father_name='$s_fname' where std_PRN='$s_reg_no' AND school_id='$school_id'";
																		   $update11= mysql_query($update_f_name) or die('Could not update data: ' . mysql_error());
																		}
																	}
																if($stud_city==$s_cty){}
																else{$cty_val=preg_match('/^[a-zA-Z ]+$/',$s_cty);
																		if($cty_val){
																		   $update_city="UPDATE `tbl_student` SET std_city='$s_cty' where std_PRN='$s_reg_no' AND school_id='$school_id'";
																		   $update12= mysql_query($update_city) or die('Could not update data: ' . mysql_error());
																		}
																	}											
																if($stud_tempadd==$s_Tadd){}
																else{
																		if($s_Tadd!=""){
																		   $update_tempadd="UPDATE `tbl_student` SET Temp_address='$s_Tadd' where std_PRN='$s_reg_no' AND school_id='$school_id'";
																		   $update13= mysql_query($update_tempadd) or die('Could not update data: ' . mysql_error());
																		}
																	}						

																if($stud_permv==$s_vill){}
																else{$vill_val=preg_match('/^[a-zA-Z ]+$/',$s_vill);
																		if($vill_val){
																		   $update_village="UPDATE `tbl_student` SET Permanent_village='$s_vill' where std_PRN='$s_reg_no' AND school_id='$school_id'";
																		   $update14= mysql_query($update_village) or die('Could not update data: ' . mysql_error());
																		}
																	}	
																if($stud_permt==$s_talu){}
																else{$talu_val=preg_match('/^[a-zA-Z ]+$/',$s_talu);
																		if($talu_val){
																		   $update_taluka="UPDATE `tbl_student` SET Permanent_taluka='$s_talu' where std_PRN='$s_reg_no' AND school_id='$school_id'";
																		   $update15= mysql_query($update_taluka) or die('Could not update data: ' . mysql_error());
																		}
																	}	
																if($stud_permd==$s_dist){}
																else{$dist_val=preg_match('/^[a-zA-Z ]+$/',$s_dist);
																		if($dist_val){
																		   $update_district="UPDATE `tbl_student` SET Permanent_district='$s_dist' where std_PRN='$s_reg_no' AND school_id='$school_id'";
																		   $update16= mysql_query($update_district) or die('Could not update data: ' . mysql_error());
																		}
																	}
																if($stud_permpin==$s_pin){}
																else{$pin_val=preg_match('/^[0-9]+$/',$s_pin);
																		if($pin_val){
																		   $update_pincode="UPDATE `tbl_student` SET Permanent_pincode='$s_pin' where std_PRN='$s_reg_no' AND school_id='$school_id'";
																		   $update17= mysql_query($update_pincode) or die('Could not update data: ' . mysql_error());
																		}
																	}
																if($stud_spec==$s_spec){}
																else{$find2 = array(",",".");
																		$spec=str_replace($find2,"",$s_spec);
																		$spec_val=preg_match('/^[a-zA-Z ]+$/',$spec);
																		if($spec_val){
																		   $update_speciltion="UPDATE `tbl_student` SET Specialization='$s_spec' where std_PRN='$s_reg_no' AND school_id='$school_id'";
																		   $update18= mysql_query($update_speciltion) or die('Could not update data: ' . mysql_error());
																		}
																	}
																if($stud_clvl==$s_clvl){}
																else{$find3 = array(",",".");
																		$c_lvl=str_replace($find3," ",$s_clvl);
																		$clvl_val=preg_match('/^[a-zA-Z ]+$/',$c_lvl);
																		if($clvl_val){
																		   $update_courselvl="UPDATE `tbl_student` SET Course_level='$s_clvl' where std_PRN='$s_reg_no' AND school_id='$school_id'";
																		   $update19= mysql_query($update_courselvl) or die('Could not update data: ' . mysql_error());
																		}
																	}	
																if($stud_ayear==$s_Ayr){}
																else{$ayr_val=preg_match('/^[0-9_-]+$/',$s_Ayr);
																		if($ayr_val){
																		   $update_Ayear="UPDATE `tbl_student` SET Academic_Year='$s_Ayr' where std_PRN='$s_reg_no' AND school_id='$school_id'";
																		   $update20= mysql_query($update_Ayear) or die('Could not update data: ' . mysql_error());
																		}
																	}		
											 											 
											  }
											 
											 
											 
												// update Student Semester Record info.....
												$insert_student_sem=mysql_query("select student_id from `StudentSemesterRecord` where student_id='$s_reg_no' and school_id='$school_id'");
												
												if(mysql_num_rows($insert_student_sem)==0)
												{
													$insert_studsem="INSERT INTO `StudentSemesterRecord` (student_id,school_id,BranchName,AcdemicYear,CourseLevel,DeptName,Specialization)
													VALUES('$s_reg_no','$school_id','".$arr[$i]["E"]."','".$arr[$i]["W"]."','".$arr[$i]["V"]."','".$arr[$i]["X"]."','".$arr[$i]["U"]."')";
									    
													$insert_count_of_stud_sem = mysql_query($insert_studsem) or die(mysql_error());   
												
												}else
													{
														 $update_stud_sem="UPDATE `StudentSemesterRecord` SET student_id='$s_reg_no',school_id='$school_id',
														 BranchName='".$arr[$i]["E"]."',AcdemicYear='".$arr[$i]["W"]."',CourseLevel='".$arr[$i]["V"]."',DeptName='".$arr[$i]["X"]."',Specialization='".$arr[$i]["U"]."'
														 WHERE student_id='$s_reg_no' AND school_id='$school_id'";
														 $update_count = mysql_query($update_stud_sem) or die('Could not update data: ' . mysql_error());
													}
											 
										
						
											 
										 }				
					}   // closing of if row==0
				
						else
						{
							
												$insert_student_sem=mysql_query("select student_id from `StudentSemesterRecord` where student_id='$s_reg_no' and school_id='$school_id'");
												
												if(mysql_num_rows($insert_student_sem)==0)
												{
													$insert_studsem="INSERT INTO `StudentSemesterRecord` (student_id,school_id,BranchName,AcdemicYear,CourseLevel,DeptName,Specialization)
													VALUES('$s_reg_no','$school_id','".$arr[$i]["E"]."','".$arr[$i]["W"]."','".$arr[$i]["V"]."','".$arr[$i]["X"]."','".$arr[$i]["U"]."')";
									    
													$insert_count_of_stud_sem = mysql_query($insert_studsem) or die(mysql_error());   
												
												}else
													{
														 $update_stud_sem="UPDATE `StudentSemesterRecord` SET student_id='$s_reg_no',school_id='$school_id',
														 BranchName='".$arr[$i]["E"]."',AcdemicYear='".$arr[$i]["W"]."',CourseLevel='".$arr[$i]["V"]."',DeptName='".$arr[$i]["X"]."',Specialization='".$arr[$i]["U"]."'
														 WHERE student_id='$s_reg_no' AND school_id='$school_id'";
														 $update_count = mysql_query($update_stud_sem) or die('Could not update data: ' . mysql_error());
													}
							//Duplicate_code: 
							 $count_of_duplicates=++$c;
							
								   $err_flag="Duplicate";
								   $update_raw_table="UPDATE `tbl_raw_student` SET 	batch_id='$batch_id',error_records='$err_flag' WHERE s_PRN='$s_reg_no' AND s_school_id='$school_id'";
								   $update_count1 = mysql_query($update_raw_table) or die('Could not update data: ' . mysql_error());
								
							       $check_student_main_table=mysql_query("select std_PRN from tbl_student where std_PRN='$s_reg_no' and school_id='$school_id'");
								   if(mysql_num_rows($check_student_main_table)==0)
									{
										        $err_flag="Correct";
									            $sql_insert9="INSERT INTO `tbl_student` 
												(`std_PRN`,`std_complete_name`,`std_name`,`std_Father_name`,`std_lastname`,`std_school_name`,`school_id`,`std_date`,`std_password`,`std_email`,`std_phone`,`std_branch`,`std_year`,`std_gender`,`std_country`,`batch_id`,`error_records`,`std_complete_father_name`,`std_dob`,`permanent_address`,`std_city`,`Temp_address`,`Permanent_village`,`Permanent_taluka`,`Permanent_district`,`Permanent_pincode`,`Specialization`,`college_mnemonic`,`Course_level`,`std_class`,`Academic_Year`,`std_dept`,`Email_Internal`)
												VALUES ('$s_reg_no','$std_name','$s_firstname','$s_middlename','$s_lastname','$school_name','$school_id','$s_date','$password','$email_id','$m_no','$branch_name1','$s_yr','$s_gen','$s_county','$batch_id','$err_flag','$s_fname','$s_dob','$s_padd','$s_cty','$s_Tadd','$s_vill','$s_talu','$s_dist','$s_pin','$s_spec','$mnemonic','$s_clvl','$s_cls','$s_Ayr','$s_dppt','$s_int')";
												
												$count9 = mysql_query($sql_insert9) or die(mysql_error()); 
											
							
							        }else{
							
											$get_stud_info=mysql_query("select * from `tbl_student` where std_PRN='$s_reg_no' AND school_id='$school_id'");
											while($row2=mysql_fetch_array($get_stud_info))
											{

									
													$stud_prn=trim($row2['std_PRN']);
													$stud_cname=trim($row2['std_complete_name']);
													//$stud_cname_len=strlen(trim(($stud_cname)));
													$stud_dob=trim($row2['`std_dob`']);
													$stud_schid=trim($row2['school_id']);
													$stud_branch=trim($row2['std_branch']);
													$stud_dept=trim($row2['std_dept']);
													$stud_year=trim($row2['std_year']);
													$stud_emailid=trim($row2['std_email']);	
													$stud_ph=trim($row2['std_phone']);
													$stud_sem=trim($row2['std_semester']);	
													$stud_int_email=trim($row2['Email_Internal']);
													
													$stud_permadd=trim($row2['permanent_address']);	
													$stud_gen=trim($row2['std_gender']);
													$stud_cfname=trim($row2['std_Father_name']);	
													$stud_city=trim($row2['std_city']);
													
													$stud_tempadd=trim($row2['Temp_address']);	
													$stud_permv=trim($row2['Permanent_village']);
													$stud_permt=trim($row2['Permanent_taluka']);	
													$stud_permd=trim($row2['Permanent_district']);
													
													$stud_permpin=trim($row2['Permanent_pincode']);	
													$stud_spec=trim($row2['Specialization']);
													$stud_clvl=trim($row2['Course_level']);	
													$stud_ayear=trim($row2['Academic_Year']);
											}	
											
											$s_comp_name=explode(" ",$stud_cname); // for student name
											$s_fstname=$s_comp_name[0];
											$s_mname=$s_comp_name[1];
											$s_lname=$s_comp_name[2]; 
													
												   if($stud_schid==$school_id){}
													 else{$sch_val=preg_match("/^[a-zA-Z0-9]",$value);
														  if($value!="" || $sch_val){
															$update_schid="UPDATE `tbl_student` SET school_id='$value' where std_PRN='$s_reg_no' AND school_id='$school_id'";
															$updatesid= mysql_query($update_schid) or die('Could not update data: ' . mysql_error());
														}
														}
																											   
												   if($stud_cname==$std_name){}
												   else{$s_cname_val=preg_match("/^[a-zA-Z ]+$/",$std_name);
													   if($s_cname_val){
															$update_name="UPDATE `tbl_student` SET std_complete_name='$std_name' where std_PRN='$s_reg_no' AND school_id='$school_id'";
															$update1= mysql_query($update_name) or die('Could not update data: ' . mysql_error());
														}
														}
													if($s_fstname==$s_firstname){}
													 else{$s_fname_val=preg_match("/^[a-zA-Z ]*$/",$s_firstname);
														  if($s_fname_val){
															$update_fname="UPDATE `tbl_student` SET std_name='$s_firstname' where std_PRN='$s_reg_no' AND school_id='$school_id'";
															$updatef= mysql_query($update_fname) or die('Could not update data: ' . mysql_error());
														}
														}
													if($s_mname==$s_middlename){}
													 else{$s_mname_val=preg_match("/^[a-zA-Z ]*$/",$s_middlename);
														  if($s_mname_val){
															$update_smname="UPDATE `tbl_student` SET std_Father_name='$s_middlename' where std_PRN='$s_reg_no' AND school_id='$school_id'";
															$updatem= mysql_query($update_smname) or die('Could not update data: ' . mysql_error());
														}
														}
													if($s_lname==$s_lastname){}
													 else{$s_lname_val=preg_match("/^[a-zA-Z ]*$/",$s_lastname);
														  if($s_lname_val){
															$update_slname="UPDATE `tbl_student` SET std_lastname='$s_lastname' where std_PRN='$s_reg_no' AND school_id='$school_id'";
															$updatel= mysql_query($update_slname) or die('Could not update data: ' . mysql_error());
														}
														}    		
												
													if($stud_dob==$s_dob){}
													else{$date_regex = "/([1-9]|0[1-9]|1[1-9]|2[1-9]|3[0-1])[ \/.-]([1-9]|0[1-9]|1[1-2])[ \/.-](19|20)\d\d/";
														$dov_val=preg_match($date_regex,$s_dob);
														if($dov_val){	
															   $update_dob="UPDATE `tbl_student` SET `std_dob`='$s_dob' where std_PRN='$s_reg_no' AND school_id='$school_id'";
															   $update2= mysql_query($update_dob) or die('Could not update data: ' . mysql_error());
														}
														}
													if($stud_branch==$s_brnh){}
													else{$branc_val=preg_match("/^[a-zA-Z ]*$/",$s_brnh);
															if($branc_val){
															   $update_branch="UPDATE `tbl_student` SET std_branch='$s_brnh' where std_PRN='$s_reg_no' AND school_id='$school_id'";
															   $update3= mysql_query($update_branch) or die('Could not update data: ' . mysql_error());
														}
														}
													if($stud_dept==$s_dppt){}
													else{$dept_val=preg_match('/^[a-zA-Z ]*$/',$s_dppt);
															if($dept_val){
															   $update_dept="UPDATE `tbl_student` SET std_dept='$s_dppt' where std_PRN='$s_reg_no' AND school_id='$school_id'";
															   $update4= mysql_query($update_dept) or die('Could not update data: ' . mysql_error());
														}
														}
													if($stud_year==$s_yr){}
													else{$yr_val=preg_match('/^[0-9]+$/', $s_yr);
														if($yr_val){
															   $update_year="UPDATE `tbl_student` SET std_year='$s_yr' where std_PRN='$s_reg_no' AND school_id='$school_id'";
															   $update5= mysql_query($update_year) or die('Could not update data: ' . mysql_error());
														}
														}
													if($stud_emailid==$email_id){}
													else{$e_val=filter_var($email_id, FILTER_VALIDATE_EMAIL);
															if($e_val){
															   $update_emailid="UPDATE `tbl_student` SET std_email='$email_id' where std_PRN='$s_reg_no' AND school_id='$school_id'";
															   $update6= mysql_query($update_emailid) or die('Could not update data: ' . mysql_error());
															}
														}	
													if($stud_ph==$m_no){}
													else{$m_val=preg_match('/^[0-9]+$/',$m_no);
															if($m_val && $m_lenght==10){
															   $update_ph="UPDATE `tbl_student` SET std_phone='$m_no' where std_PRN='$s_reg_no' AND school_id='$school_id'";
															   $update7= mysql_query($update_ph) or die('Could not update data: ' . mysql_error());
															}
														}	
													if($stud_int_email==$s_int){}
													else{$inte_val=filter_var($s_int, FILTER_VALIDATE_EMAIL);
															if($inte_val){
															   $update_inemail="UPDATE `tbl_student` SET Email_Internal='$s_int' where std_PRN='$s_reg_no' AND school_id='$school_id'";
															   $update8= mysql_query($update_inemail) or die('Could not update data: ' . mysql_error());
															}
														}		
													if($stud_permadd==$s_padd){}
													else{if($s_padd!=""){
															
															   $update_padd="UPDATE `tbl_student` SET permanent_address='$s_padd' where std_PRN='$s_reg_no' AND school_id='$school_id'";
															   $update9= mysql_query($update_padd) or die('Could not update data: ' . mysql_error());
															}
														}	
													if($stud_gen==$s_gen){}
													else{$gen_val=preg_match("/[a-zA-Z'-]/",$s_gen);
															if($gen_val){
															   $update_gen="UPDATE `tbl_student` SET std_gender='$s_gen' where std_PRN='$s_reg_no' AND school_id='$school_id'";
															   $update10= mysql_query($update_gen) or die('Could not update data: ' . mysql_error());
															}
														}	    										
													if($stud_cfname==$s_fname){}
													else{$f_val=preg_match("/^[a-zA-Z ]+$/",$s_fname);
															if($f_val){
															   $update_f_name="UPDATE `tbl_student` SET std_Father_name='$s_fname' where std_PRN='$s_reg_no' AND school_id='$school_id'";
															   $update11= mysql_query($update_f_name) or die('Could not update data: ' . mysql_error());
															}
														}
													if($stud_city==$s_cty){}
													else{$cty_val=preg_match('/^[a-zA-Z ]+$/',$s_cty);
															if($cty_val){
															   $update_city="UPDATE `tbl_student` SET std_city='$s_cty' where std_PRN='$s_reg_no' AND school_id='$school_id'";
															   $update12= mysql_query($update_city) or die('Could not update data: ' . mysql_error());
															}
														}											
													if($stud_tempadd==$s_Tadd){}
													else{
															if($s_Tadd!=""){
															   $update_tempadd="UPDATE `tbl_student` SET Temp_address='$s_Tadd' where std_PRN='$s_reg_no' AND school_id='$school_id'";
															   $update13= mysql_query($update_tempadd) or die('Could not update data: ' . mysql_error());
															}
														}						

													if($stud_permv==$s_vill){}
													else{$vill_val=preg_match('/^[a-zA-Z ]+$/',$s_vill);
															if($vill_val){
															   $update_village="UPDATE `tbl_student` SET Permanent_village='$s_vill' where std_PRN='$s_reg_no' AND school_id='$school_id'";
															   $update14= mysql_query($update_village) or die('Could not update data: ' . mysql_error());
															}
														}	
													if($stud_permt==$s_talu){}
													else{$talu_val=preg_match('/^[a-zA-Z ]+$/',$s_talu);
															if($talu_val){
															   $update_taluka="UPDATE `tbl_student` SET Permanent_taluka='$s_talu' where std_PRN='$s_reg_no' AND school_id='$school_id'";
															   $update15= mysql_query($update_taluka) or die('Could not update data: ' . mysql_error());
															}
														}	
													if($stud_permd==$s_dist){}
													else{$dist_val=preg_match('/^[a-zA-Z ]+$/',$s_dist);
															if($dist_val){
															   $update_district="UPDATE `tbl_student` SET Permanent_district='$s_dist' where std_PRN='$s_reg_no' AND school_id='$school_id'";
															   $update16= mysql_query($update_district) or die('Could not update data: ' . mysql_error());
															}
														}
													if($stud_permpin==$s_pin){}
													else{$pin_val=preg_match('/^[0-9]+$/',$s_pin);
															if($pin_val){
															   $update_pincode="UPDATE `tbl_student` SET Permanent_pincode='$s_pin' where std_PRN='$s_reg_no' AND school_id='$school_id'";
															   $update17= mysql_query($update_pincode) or die('Could not update data: ' . mysql_error());
															}
														}
													if($stud_spec==$s_spec){}
													else{$find2 = array(",",".");
															$spec=str_replace($find2,"",$s_spec);
															$spec_val=preg_match('/^[a-zA-Z ]+$/',$spec);
															if($spec_val){
															   $update_speciltion="UPDATE `tbl_student` SET Specialization='$s_spec' where std_PRN='$s_reg_no' AND school_id='$school_id'";
															   $update18= mysql_query($update_speciltion) or die('Could not update data: ' . mysql_error());
															}
														}
													if($stud_clvl==$s_clvl){}
													else{$find3 = array(",",".");
															$c_lvl=str_replace($find3," ",$s_clvl);
															$clvl_val=preg_match('/^[a-zA-Z ]+$/',$c_lvl);
															if($clvl_val){
															   $update_courselvl="UPDATE `tbl_student` SET Course_level='$s_clvl' where std_PRN='$s_reg_no' AND school_id='$school_id'";
															   $update19= mysql_query($update_courselvl) or die('Could not update data: ' . mysql_error());
															}
														}	
													if($stud_ayear==$s_Ayr){}
													else{$ayr_val=preg_match('/^[0-9_-]+$/',$s_Ayr);
															if($ayr_val){
															   $update_Ayear="UPDATE `tbl_student` SET Academic_Year='$s_Ayr' where std_PRN='$s_reg_no' AND school_id='$school_id'";
															   $update20= mysql_query($update_Ayear) or die('Could not update data: ' . mysql_error());
															}
														}		
														
														
									}
								
						}
										
							
				
				}else
					{
						 if($s_f>0 && $s_l>0)
						{
							if(!empty($m_no) || $email_lenght>0)
							{
										$err_flag="Err-SPRN";
										$sql_insert5="INSERT INTO `tbl_raw_student` (s_PRN,s_complete_name,s_firstname,s_middlename,s_lastname,s_school_name,s_school_id,s_date,s_password,s_email,s_phone,s_branch,s_year,s_gender,s_country,batch_id,input_file_name,no_record_uploaded,file_type,uploaded_date_time,uploaded_by,error_records,s_complete_father_name,s_dob,s_permanant_address,s_city,s_temporary_address,s_permanant_village,s_permanant_taluka,s_permanant_district,s_permanant_pincode,s_specialization,mnemonic,s_complete_name,s_course_level,s_class,s_academic_year,s_dept,s_internal_emailid)
										VALUES ('$s_reg_no','$std_name','$s_firstname','$s_middlename','$s_lastname','$school_name','$school_id','$s_date','$password','$email_id','$m_no','$branch_name1','".$arr[$i]["F"]."','".$arr[$i]["G"]."','".$arr[$i]["I"]."','$batch_id','$input_file_name','$totalrecords','$file_type1','$date','$uploaded_by','$err_flag','".$arr[$i]["J"]."','".$arr[$i]["K"]."','".$arr[$i]["M"]."','".$arr[$i]["N"]."','".$arr[$i]["O"]."','".$arr[$i]["P"]."','".$arr[$i]["Q"]."','".$arr[$i]["R"]."','".$arr[$i]["S"]."','".$arr[$i]["U"]."','$mnemonic','".$arr[$i]["C"]."','".$arr[$i]["V"]."','".$arr[$i]["L"]."','".$arr[$i]["W"]."','".$arr[$i]["X"]."','$s_int')";
									    
										$result_insert5 = mysql_query($sql_insert5) or die(mysql_error()); 
										$reports="plz put Student PRN in excel sheet.";
							}
						}	
					}
				
			
							$count_of_updates=$count_of_duplicates;	   // for counting number of Updates records
							
					
		
			
			}else
					{
						$count_of_wrong_school_id=++$sc_id;
						$err_flag="Err-SCID";
						$sql_insert15="INSERT INTO `tbl_raw_student` (s_PRN,s_firstname,s_middlename,s_lastname,s_school_name,s_school_id,s_date,s_password,s_email,s_phone,s_branch,s_year,s_gender,s_country,batch_id,input_file_name,no_record_uploaded,file_type,uploaded_date_time,uploaded_by,error_records,s_father_name,s_dob,s_permanant_address,s_city,s_temporary_address,s_permanant_village,s_permanant_taluka,s_permanant_district,s_permanant_pincode,s_specialization,mnemonic,s_course_level,s_class,s_academic_year,s_dept)
										VALUES ('$s_reg_no','$s_firstname','$s_middlename','$s_lastname','$school_name','$school_id','$s_date','$password','$email_id','$m_no','$branch_name1','".$arr[$i]["F"]."','".$arr[$i]["G"]."','".$arr[$i]["I"]."','$batch_id','$input_file_name','$totalrecords','$file_type1','$date','$uploaded_by','$err_flag','".$arr[$i]["J"]."','".$arr[$i]["K"]."','".$arr[$i]["M"]."','".$arr[$i]["N"]."','".$arr[$i]["O"]."','".$arr[$i]["P"]."','".$arr[$i]["Q"]."','".$arr[$i]["R"]."','".$arr[$i]["S"]."','".$arr[$i]["U"]."','$mnemonic','".$arr[$i]["V"]."','".$arr[$i]["L"]."','".$arr[$i]["W"]."','".$arr[$i]["X"]."')";
						$result_insert15 = mysql_query($sql_insert15) or die(mysql_error()); 
						
					
					}
		
		} // for loop closing
//------------------------------------ Code Of batch master-------------------------------------
				$query4="select count(case when `error_records`= 'Err-Phone/Email' then 1 else null end) as PHONE,
				count(case when `error_records`='Err-Branch' then 1 else null end) as BRANCH,
				count(case when  `error_records`='Err-SPRN' then 1 else null end) as SPRN,
				count(case when `error_records`='Err-Name' then 1 else null end) as NAME,
				count(case when `error_records`='Err-SCID' then 1 else null end) as SCID
				from  tbl_raw_student where `s_school_id`='$school_id' and batch_id like '$batch_id'";       
				$row4=mysql_query($query4);
				$value4=mysql_fetch_array($row4);
				$phone=$value4['PHONE'];
				$branch=$value4['BRANCH'];
				$s_prn=$value4['SPRN'];
				$name=$value4['NAME'];
				$wrong_scid=$value4['SCID'];
				$error_count=$phone+$branch+$s_prn+$name+$wrong_scid+$count_of_duplicates;
				$correct_records=$totalrecords-$error_count;
				if($correct_records>=0)
				{
					$tbl_name="Student_Master";
					$db_tbl_name="tbl_student";
					$sql_insert10="INSERT INTO `tbl_Batch_Master`(school_id,batch_id,input_file_name,file_type,uploaded_date_time,uploaded_by,num_records_uploaded,num_errors_records,num_duplicates_record,num_correct_records,num_records_updated,display_table_name,db_table_name,num_errors_scid)
					VALUES ('$school_id','$batch_id','$input_file_name','$file_type1','$date','$uploaded_by','$totalrecords','$error_count','$count_of_duplicates','$correct_records','$count_of_updates','$tbl_name','$db_tbl_name','$count_of_wrong_school_id')";
					$count10 = mysql_query($sql_insert10) or die(mysql_error());
				}				
//----------------------------------------End Of batch master-----------------------------------


	}	      // else close
}          // limit if close
else
{
	echo "<script type=text/javascript>alert('Plz select upload limit'); window.location=''</script>";
}  

		
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
    <div class='panel panel-primary dialog-panel'>
   <div style="color:red;font-size:15px;font-weight:bold;margin-top:10px;"> <?php if(isset($_GET['report'])){ echo $_GET['report']; };?></div>
          <div class='panel-heading'>
             
                <h3>Add Student Excel Sheet</h3>
            
            
               
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
                                    <h5><?php echo "Batch"." ". $batch_id." "."Uploaded Successfully by"." ".$uploaded_by."<br>"?></h5>
                                    </div>
									</div>
									<div class="row">
									<div class="col-md-1"></div>
									<div class="col-md-12 ">
									<table cellpadding="12" cellspacing="6" align="center">
									<tr bgcolor="#9900CC">
									<!--<center><a href="download_stud_upload_format.php?name=<?php //echo "S";?>">Download Student Upload Excel Sheet Format</a></center><tr>-->
									<center>
									<a href="download_stud_upload_format.php?name=<?php echo "EE";?>">Download Student Error Excel Sheet</a></center><tr>
									</table>
									</div>
									</div>
									</form>
									</body>
									</html>
	
<?php

}


?>	