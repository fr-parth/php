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

$query2="select batch_id from `tbl_raw_parent` WHERE school_id='$school_id' ORDER BY `parent_Id` DESC LIMIT 1";  //query for getting last batch_id what else if are inserting first time data
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

			for($i=2;$i<=$upload_limit;$i++)
			 {
	
	
				$arr[$i]["B"]=str_replace("'","", trim($allDataInSheet[$i]["B"]));   // student_reg_no.
				$arr[$i]["C"]=str_replace("'","", trim($allDataInSheet[$i]["C"]));  // FathersName
				$arr[$i]["D"]=str_replace("'","", trim($allDataInSheet[$i]["D"]));   // Parent mobile
				$arr[$i]["E"]=str_replace("'","", trim($allDataInSheet[$i]["E"]));   // Email ID
				$arr[$i]["F"]=str_replace("'","", trim($allDataInSheet[$i]["F"]));    // DOB
				$arr[$i]["G"]=str_replace("'","", trim($allDataInSheet[$i]["G"]));   // Gender
				$arr[$i]["H"]=str_replace("'","", trim($allDataInSheet[$i]["H"]));   // Address
				$arr[$i]["I"]=str_replace("'","", trim($allDataInSheet[$i]["I"]));    //Country
				$arr[$i]["J"]=str_replace("'","", trim($allDataInSheet[$i]["J"]));    // Family Income
				
                $std_reg_no=$allDataInSheet[$i]["B"];   // for Student Reg. No.
				$s_no=explode(" ",$std_reg_no);
				$s_reg_no= $s_no[0];
				$sprn_lenght=strlen(trim(($s_reg_no)));
				
				$mobile_no=$allDataInSheet[$i]["D"];   // for Mobile Number
				$m_name=explode(" ",$mobile_no);
				$m_no=$m_name[0];
				$m_lenght=strlen(trim(($m_no)));
				
				$email_id1=$allDataInSheet[$i]["E"];
				$e_id=explode(" ",$email_id1);
				$email_id=$e_id[0];
				$email_lenght=strlen(trim(($email_id)));
															
																 //$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_";
																 //$password = substr( str_shuffle( $chars ), 0, 8 );
			    $std_name=$allDataInSheet[$i]['C'];
				$first_name=explode(" ",$std_name); // for student name
				$s_firstname=$first_name[0];
				$s_middlename=$first_name[1];
				$s_lastname=$first_name[2];  
				
                $s_f=strlen(trim(($s_firstname)));
                $s_m=strlen(trim(($s_middlename)));	
				$s_l=strlen(trim(($s_lastname)));	
				$password="12345";
				
				if($sprn_lenght>0)
				{
					$row=mysql_query("select std_PRN from tbl_raw_parent where std_PRN='$s_reg_no'");
					if(mysql_num_rows($row)<=0)
					{
							
				          if($s_f>0 && $s_l>0)
						  {
				                        $err_flag="Correct";
										$sql_insert1="INSERT INTO `tbl_raw_parent` (std_PRN,Name,Phone,email_id,DateOfBirth,Gender,Address,country,FamilyIncome,school_id,college_mnemonic,batch_id,input_file_name,no_record_uploaded,file_type,uploaded_date_time,uploaded_by,error_status,Password)
										VALUES ('$s_reg_no','".$arr[$i]["C"]."','".$arr[$i]["D"]."','".$arr[$i]["E"]."','".$arr[$i]["F"]."','".$arr[$i]["G"]."','".$arr[$i]["H"]."','".$arr[$i]["I"]."','".$arr[$i]["J"]."','$school_id','$mnemonic','$batch_id','$input_file_name','$totalrecords','$file_type1','$date','$uploaded_by','$err_flag','$password')";
									    $result_insert1=mysql_query($sql_insert1) or die(mysql_error()); 
										$reports1="You are successfully registered with Smart Cookie";
										
						  }else
							   {
								    $err_flag="Err-Name";
									$sql_insert8="INSERT INTO `tbl_raw_parent` (std_PRN,Name,Phone,email_id,DateOfBirth,Gender,Address,country,FamilyIncome,school_id,college_mnemonic,batch_id,input_file_name,no_record_uploaded,file_type,uploaded_date_time,uploaded_by,error_status,Password)
								     VALUES ('$s_reg_no','".$arr[$i]["C"]."','".$arr[$i]["D"]."','".$arr[$i]["E"]."','".$arr[$i]["F"]."','".$arr[$i]["G"]."','".$arr[$i]["H"]."','".$arr[$i]["I"]."','".$arr[$i]["J"]."','$school_id','$mnemonic','$batch_id','$input_file_name','$totalrecords','$file_type1','$date','$uploaded_by','$err_flag','$password')";
									$result_insert8 = mysql_query($sql_insert8) or die(mysql_error());  
									$reports="Inserted data from Excel Sheet is not valid data";
							   }							  
        			   
									
										  if($result_insert1>=1)
										 { 
									       
									            $sql_insert9="INSERT INTO `tbl_parent` 
												(std_PRN,Name,Phone,email_id,DateOfBirth,Gender,Address,country,FamilyIncome,school_id,college_mnemonic,batch_id,input_file_name,no_record_uploaded,file_type,uploaded_date_time,uploaded_by,error_status,Password)
												SELECT std_PRN,Name,Phone,email_id,DateOfBirth,Gender,Address,country,FamilyIncome,school_id,college_mnemonic,batch_id,input_file_name,no_record_uploaded,file_type,uploaded_date_time,uploaded_by,error_status,Password
												FROM `tbl_raw_parent` WHERE std_PRN='$s_reg_no' AND school_id='$school_id'"; 
												$count9 = mysql_query($sql_insert9) or die(mysql_error()); 
											
											    $sql_update="UPDATE `tbl_raw_parent` SET error_status='Import' WHERE std_PRN='$s_reg_no' AND school_id='$school_id'";
											    $retval = mysql_query($sql_update) or die('Could not update data: ' . mysql_error());
							
												
												   
											}	
					}   // closing of if row<0
				
				    else
					{
						
						$count_of_duplicates=++$c;
						$err_flag="Duplicate";
						$sql_insert8="INSERT INTO `tbl_raw_parent` (std_PRN,Name,Phone,email_id,DateOfBirth,Gender,Address,country,FamilyIncome,school_id,college_mnemonic,batch_id,input_file_name,no_record_uploaded,file_type,uploaded_date_time,uploaded_by,error_status,Password)
								     VALUES ('$s_reg_no','".$arr[$i]["C"]."','".$arr[$i]["D"]."','".$arr[$i]["E"]."','".$arr[$i]["F"]."','".$arr[$i]["G"]."','".$arr[$i]["H"]."','".$arr[$i]["I"]."','".$arr[$i]["J"]."','$school_id','$mnemonic','$batch_id','$input_file_name','$totalrecords','$file_type1','$date','$uploaded_by','$err_flag','$password')";
						$result_insert1 = mysql_query($sql_insert8) or die(mysql_error()); 
						$reports1="Inserted data from Excel Sheet is Duplicate";
						$row11=mysql_query("select std_PRN from `tbl_parent` where std_PRN='$s_reg_no'");
						
						if(mysql_num_rows($row11)==0)
						{
						if($s_f>0 && $s_l>0)
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
									  {      
								            
										 $sql_update1="UPDATE `tbl_parent` SET std_PRN='$s_reg_no',Name='".$arr[$i]["C"]."',email_id='".$arr[$i]["D"]."',DateOfBirth='".$arr[$i]["E"]."',Gender='".$arr[$i]["G"]."',
										               Address='".$arr[$i]["H"]."',country='".$arr[$i]["I"]."',FamilyIncome='".$arr[$i]["J"]."',school_id='$school_id'
														WHERE std_PRN='$s_reg_no' AND school_id='$school_id'";
										 
										 $retval11 = mysql_query($sql_update1) or die('Could not update data: ' . mysql_error());
										 $report="Duplicates record Updated successfully.";
									  }
									}
								  }
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
										$sql_insert5="INSERT INTO `tbl_raw_parent` (std_PRN,Name,Phone,email_id,DateOfBirth,Gender,Address,country,FamilyIncome,school_id,college_mnemonic,batch_id,input_file_name,no_record_uploaded,file_type,uploaded_date_time,uploaded_by,error_status,Password)
										VALUES ('$s_reg_no','".$arr[$i]["C"]."','".$arr[$i]["D"]."','".$arr[$i]["E"]."','".$arr[$i]["F"]."','".$arr[$i]["G"]."','".$arr[$i]["H"]."','".$arr[$i]["I"]."','".$arr[$i]["J"]."','$school_id','$mnemonic','$batch_id','$input_file_name','$totalrecords','$file_type1','$date','$uploaded_by','$err_flag','$password')";
										$result_insert5 = mysql_query($sql_insert5) or die(mysql_error()); 
										$reports="plz put Student PRN in excel sheet.";
							}
						}	
					}
					if($retval11>0)
					{
			
							$count_of_updates=++$u;	   // for counting number of Updates records
							
					}
		
				else
				{
					                    
						$reports="plz put student PRN in excel sheet.";
				}
      	   
		
			} // for loop closing
				$query4="select count(case when `error_records`= 'Err-Phone/Email' then 1 else null end) as PHONE,
					count(case when  `error_records`='Err-SPRN' then 1 else null end) as SPRN,
				 count(case when `error_records`='Err-Name' then 1 else null end) as NAME
				 from  `tbl_raw_parent` where school_id='$school_id' and batch_id like '$batch_id'";       
				$row4=mysql_query($query4);
				$value4=mysql_fetch_array($row4);
				$phone=$value4['PHONE'];
				$s_prn=$value4['SPRN'];
				$name=$value4['NAME'];
				$error_count=$phone+$s_prn+$name;
				$correct_records=$totalrecords-$error_count-$count_of_duplicates;
				$tbl_name="Parent_Master";
				$db_tbl_name="tbl_parent";
				$sql_insert10="INSERT INTO `tbl_Batch_Master`(batch_id,input_file_name,file_type,uploaded_date_time,uploaded_by,num_records_uploaded,num_errors_records,num_duplicates_record,num_correct_records,num_records_updated,display_table_name,db_table_name)
				VALUES ('$batch_id','$input_file_name','$file_type1','$date','$uploaded_by','$totalrecords','$error_count','$count_of_duplicates','$correct_records','$count_of_updates','$tbl_name','$db_tbl_name')";
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
											  <option value="30">30</option>
											  <option value="40">40</option>
											  <option value="50">50</option>
											  <option value="60">60</option>
											  <option value="70">70</option>
											  <option value="80">80</option>
											  <option value="90">90</option>
											  <option value="100">100</option>
											  <option value="150">150</option>
											  <option value="200">200</option>
											  <option value="250">250</option>
											   <option value="300">300</option>
											  <option value="350">350</option>
											   <option value="400">400</option>
											    <option value="450">450</option>
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
									 <?php $query2="select batch_id from `tbl_raw_parent` WHERE school_id='$school_id' ORDER BY `parent_Id` DESC LIMIT 1";  //query for getting last batch_id what else if are inserting first time data
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
	$id=$_SESSION['id'];
	
	$fields=array("id"=>$id);
		   $table="tbl_school_admin";
		   
		   $smartcookie=new smartcookie();
		   
			$results=$smartcookie->retrive_individual($table,$fields);
			$arrs=mysql_fetch_array($results);
		    $school_id=$arrs['school_id'];
			$school_name=$arrs['school_name'];
			$uploadedStatus = 0;
				
	$reports="";
	$report="";
	
	
	$query="select name from `tbl_school_admin` where school_id='$school_id'"; // uploaded by
	$row1=mysql_query($query);
	$value1=mysql_fetch_array($row1);
	$uploaded_by=$value1['name'];
	$date=date('Y-m-d h:i:s',strtotime('+330 minute'));
	$s_date = date('m/d/Y');																								
	$temp = explode(".", $_FILES["file"]["name"]); 
	$file_type=$temp[1];
	$input_file_name=$temp[0].".".$temp[1];
	$file_t1=explode(".", $_FILES['file']['type']);	
	$file_type1=$file_t1[1]." ".$file_t1[2];
																
			//$id=$_SESSION['id'];
           

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
										} catch(Exception $e) 
										{
											die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
										}


$mnemonic=$school_id; 
//if($mnemonic!='' && $school_id==$mnemonic)
//{
	$query2="select batch_id from `tbl_raw_parent` WHERE school_id='$school_id' ORDER BY `parent_Id` DESC LIMIT 1";  //query for getting last batch_id what else if are inserting first time data
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
$count_of_insert="";
$count_of_duplicates="";
$dup=0;
$upd=0;
$sch_id=0;
$val="";
$validate=0;
$not_validate=0;
$count_of_wrong_school_id="";	
$STDPRN=0;
$c_dup=0;


	$sc_id=$s_id[0];
	$limit=$_POST['limit']; 
	$upload_limit=$limit+1;
	$min=min($upload_limit,$arrayCount);
	$totalrecords=$min-1;
	$flag=$_POST['flag'];
	if($limit>0)
	{
		
		if($flag==1)
		{
		   	 $insert=0; $list = array();
			try
			{
				$file = fopen("/home/content/84/7121184/html/smartcookies/CSV/parent_error.csv","w+") or die("Unable to open file for output");
				//$file = fopen("/home/content/84/7121184/html/tsmartcookie/CSV/parent_error.csv","w+") or die("Unable to open file for output");
				fwrite($file,$sn. "," . "School_id" . ", " . "Insert Count" . ", " . "Duplicate Count" . ", " . "Update Count" . ", " . "Wrong School ID Count" . "," . "SPRN Error count" . "," . "Name not validated" . ", " . "Validation count" ."," . "Refuse count" ."\n");
		
				for($i=2;$i<=$min;$i++)
				{
					$value = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
					$sch_lenght=strlen(trim(($value)));
					if(trim($school_id)==trim($value))
					{ 
			
						$arr[$i]["B"]=str_replace("'","", trim($allDataInSheet[$i]["B"]));   // student_reg_no.
						$arr[$i]["C"]=str_replace("'","", trim($allDataInSheet[$i]["C"]));   // FathersName
						$arr[$i]["D"]=str_replace("'","", trim($allDataInSheet[$i]["D"]));   // Parent mobile
						$arr[$i]["E"]=str_replace("'","", trim($allDataInSheet[$i]["E"]));   // Email ID
						$arr[$i]["F"]=str_replace("'","", trim($allDataInSheet[$i]["F"]));   // DOB
						$arr[$i]["G"]=str_replace("'","", trim($allDataInSheet[$i]["G"]));   // Gender
						$arr[$i]["H"]=str_replace("'","", trim($allDataInSheet[$i]["H"]));   // Address
						$arr[$i]["I"]=str_replace("'","", trim($allDataInSheet[$i]["I"]));   //Country
						$arr[$i]["J"]=str_replace("'","", trim($allDataInSheet[$i]["J"]));    // Family Income
						$arr[$i]["K"]=str_replace("'","", trim($allDataInSheet[$i]["K"]));    // Qualification
						$arr[$i]["L"]=str_replace("'","", trim($allDataInSheet[$i]["L"]));    // Occupation
						$arr[$i]["M"]=str_replace("'","", trim($allDataInSheet[$i]["M"]));    // Parent_Image_Path
						$arr[$i]["N"]=str_replace("'","", trim($allDataInSheet[$i]["N"]));    // State
						$arr[$i]["O"]=str_replace("'","", trim($allDataInSheet[$i]["O"]));    // City
						$arr[$i]["P"]=str_replace("'","", trim($allDataInSheet[$i]["P"]));    // Mother Name
						
						
						$std_reg_no=$arr[$i]["B"];   // for Student Reg. No.
						$a=preg_match('/^[0-9_-]*$/',$s_reg_no);
						$s_no=explode(" ",$std_reg_no);
						$s_reg_no= $s_no[0];
						$sprn_lenght=strlen(trim(($s_reg_no)));
						
						$parent_name=$arr[$i]["C"];
						$first_name=explode(" ",$parent_name); 
						$s_firstname=$first_name[0];
						$s_middlename=$first_name[1];
						$s_lastname=$first_name[2];  
						
						$p_f=strlen(trim(($s_firstname)));
						$p_m=strlen(trim(($s_middlename)));	
						$p_l=strlen(trim(($s_lastname)));
						$b=preg_match("/^[a-zA-Z]{1,}([\s-]*[a-zA-Z\s\'-]*)$/",$parent_name);
						
						$mobile_no=$arr[$i]["D"];   // for Mobile Number
						$m_name=explode(" ",$mobile_no);
						$m_no=$m_name[0];
						$m_lenght=strlen(trim(($m_no)));
						$c=preg_match('/^[0-9]+$/',$m_no);
												
						$email_id1=$arr[$i]["E"];
						$e_id=explode(" ",$email_id1);
						$email_id=$e_id[0];
						$email_lenght=strlen(trim(($email_id)));
						$d=filter_var($email_id, FILTER_VALIDATE_EMAIL);
						
						$DOB=$arr[$i]["F"];
						$date_regex = "/([1-9]|0[1-9]|1[1-9]|2[1-9]|3[0-1])[ \/.-]([1-9]|0[1-9]|1[1-2])[ \/.-](19|20)\d\d/"; 
						$e=preg_match($date_regex,$DOB);
						
						$gender=$arr[$i]["G"];
				        $f=preg_match("/[a-zA-Z'-]/",$gender);
						
						$Address=$arr[$i]["H"];
				         $g=preg_match('/[A-Za-z0-9\-\\,.]+/',$Address);
						
						$country=$arr[$i]["I"];
				        $h=preg_match("/^[a-zA-Z_.]*$/",$country);
																
						$F_income=$arr[$i]["J"];
				        $ik=preg_match('/^[0-9]+$/',$F_income);			
						
						$qualification=$arr[$i]["K"];
				        $j=preg_match("/^[a-zA-Z]{1,}([\s-]*[a-zA-Z\s\'-.]*)$/",$qualification);
						
						$occu=$arr[$i]["L"];
				         $k=preg_match("/^[a-zA-Z]*$/",$occu);
						
						$p_img_path=$arr[$i]["M"];
				        $l=filter_var($p_img_path, FILTER_VALIDATE_URL);
						
						$state=$arr[$i]["N"];
				        $m=preg_match("/^[a-zA-Z ]*$/",$state);
						
						$city=$arr[$i]["O"];
				       $n=preg_match("/^[a-zA-Z ]*$/",$city);
						
						$mother_name=$arr[$i]["P"];
				        $o=preg_match("/^[a-zA-Z ]*$/",$mother_name);
						
						if($sprn_lenght>0)
						{
							$row=mysql_query("select std_PRN from `tbl_parent` where std_PRN='$s_reg_no'");
					
							if(mysql_num_rows($row)==0)
							{
						  
								if($p_f>0 || $p_l>0)
								{
										$list[$insert] = $s_reg_no;              
										++$insert;	                        // count of insert
								
						  
						  
								}else{
									  ++$name_not_validated;        // error count of names
								    }						  
        			   
									
										 
							   // closing of if row<0
				
							}else
							{
							
								++$dup;                     // count of duplicates
					
							}						  
									
			
		         
						}else{
								if($a==1 || $sprn_lenght>0)       // errror count of student prn
									$STDPRN++;
							}
				
				
					
		
					
					}else
						{
							if(!empty($value) && $sch_lenght>0)        
							++$sch_id;                                // count of school id did not match
						
						}
						
						if($a && $b && $c && $d && $e && $f && $g && $h && $ik && $j && $k && $l && $m && $n && $o && $m_lenght==10)
						{							
							if(empty($std_reg_no) || empty($parent_name) || empty($m_no) || empty($email_id) || empty($DOB) || empty($gender) || empty($Address) || empty($country) || empty($F_income) || empty($qualification) || empty($occu) || empty($p_img_path) || empty($state) || empty($city) || empty($mother_name))
							{
													
								 ++$validate;	                  // count of no. of records validated successfully							
							}	
												
														 	
						}else{
								
							    ++$not_validate;	 // count of no. of records not validated successfully	
							 }			
					
				}  // for closing
				
				fwrite($file,$sn. ", " . $school_id . ", " .$insert . "," . $dup. ", " .$dup. ", " .$sch_id. "," .$STDPRN. "," .$name_not_validated. ", " . $validate .  "," .$not_validate. "\n");
				$abc=$insert;
				$ep=$abc-1;
				while($ep>=0)
				{
					fwrite($file,$sn. ", ". $sn. "," . $list[$ep] ."\n");
					$ep--;
				} 
		
				echo "<script type=text/javascript>alert('File has been scan successfully...'); window.location=''</script>";
				fclose($file);
			}
			catch (Exception $e) 
			{ 
				echo $e->errorMessage(); 
			} 	
		
		}     // flag==0
		 
				
	    else
		{
			for($i=2;$i<=$min;$i++)
			{
				$value = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
				if(trim($school_id)==trim($value))
				{ 
						$replace = array(",","'",".","(",")","/","\",",":","-");
						$arr[$i]["B"]=str_replace("'","", trim($allDataInSheet[$i]["B"]));   // student_reg_no.
						$arr[$i]["C"]=str_replace("'","", trim($allDataInSheet[$i]["C"]));   // FathersName
						$arr[$i]["D"]=str_replace("'","", trim($allDataInSheet[$i]["D"]));   // Parent mobile
						$arr[$i]["E"]=str_replace("'","", trim($allDataInSheet[$i]["E"]));   // Email ID
						$arr[$i]["F"]=str_replace("'","", trim($allDataInSheet[$i]["F"]));   // DOB
						$arr[$i]["G"]=str_replace("'","", trim($allDataInSheet[$i]["G"]));   // Gender
						$arr[$i]["H"]=str_replace($replace," ", trim($allDataInSheet[$i]["H"]));   // Address
						$arr[$i]["I"]=str_replace("'","", trim($allDataInSheet[$i]["I"]));   //Country
						$arr[$i]["J"]=str_replace("'","", trim($allDataInSheet[$i]["J"]));    // Family Income
						$arr[$i]["K"]=str_replace("'","", trim($allDataInSheet[$i]["K"]));    // Qualification
						$arr[$i]["L"]=str_replace("'","", trim($allDataInSheet[$i]["L"]));    // Occupation
						$arr[$i]["M"]=str_replace("'","", trim($allDataInSheet[$i]["M"]));    // Parent_Image_Path
						$arr[$i]["N"]=str_replace("'","", trim($allDataInSheet[$i]["N"]));    // State
						$arr[$i]["O"]=str_replace("'","", trim($allDataInSheet[$i]["O"]));    // City
						$arr[$i]["P"]=str_replace("'","", trim($allDataInSheet[$i]["P"]));    // Mother Name
						
						$std_reg_no=$arr[$i]["B"];   // for Student Reg. No.
						$s_no=explode(" ",$std_reg_no);
						$s_reg_no= $s_no[0];
						$sprn_lenght=strlen(trim(($s_reg_no)));
						
						$mobile_no=$arr[$i]["D"];   // for Mobile Number
						$m_name=explode(" ",$mobile_no);
						$m_no=$m_name[0];
						$m_lenght=strlen(trim(($m_no)));
						
						$email_id1=$arr[$i]["E"];
						$e_id=explode(" ",$email_id1);
						$email_id=$e_id[0];
						$email_lenght=strlen(trim(($email_id)));
																
										
						$std_name=$arr[$i]["C"];
						$first_name=explode(" ",$std_name); 
						$s_firstname=$first_name[0];
						$s_middlename=$first_name[1];
						$s_lastname=$first_name[2];  
						
						$s_f=strlen(trim(($s_firstname)));
						$s_m=strlen(trim(($s_middlename)));	
						$s_l=strlen(trim(($s_lastname)));	
						$password="12345";
						//--------------
						$parnt_DOB=$arr[$i]["F"];
						$parnt_GENDER=$arr[$i]["G"];
						$parnt_ADDRESS=$arr[$i]["H"];
						$parnt_COUNTRY=$arr[$i]["I"];
						$parnt_FINCOME=$arr[$i]["J"];
						$parnt_QUALIFICATION=$arr[$i]["K"];
						$parnt_OCCUPATION=$arr[$i]["L"];
						$parnt_IMAGE_PATH=$arr[$i]["M"];
						$parnt_STATE=$arr[$i]["N"];
						$parnt_CITY=$arr[$i]["O"];
						$parnt_MOTHER_NAME=$arr[$i]["P"];
						
				if($sprn_lenght>0)
				{
					$row=mysql_query("select std_PRN from tbl_raw_parent where std_PRN='$s_reg_no'");
					if(mysql_num_rows($row)==0)
					{
							
				          if($s_f>0 || $s_l>0)
						  {
				                        $err_flag="Correct";
										$sql_insert1="INSERT INTO `tbl_raw_parent` (std_PRN,Name,Phone,email_id,DateOfBirth,Gender,Address,country,FamilyIncome,school_id,college_mnemonic,batch_id,input_file_name,no_record_uploaded,file_type,uploaded_date_time,uploaded_by,error_status,Password,Qualification,Occupation,p_img_path,state,city,Mother_name)
										VALUES ('$s_reg_no','".$arr[$i]["C"]."','".$arr[$i]["D"]."','".$arr[$i]["E"]."','".$arr[$i]["F"]."','".$arr[$i]["G"]."','".$arr[$i]["H"]."','".$arr[$i]["I"]."','".$arr[$i]["J"]."','$school_id','$mnemonic','$batch_id','$input_file_name','$totalrecords','$file_type1','$date','$uploaded_by','$err_flag','$password','".$arr[$i]["K"]."','".$arr[$i]["L"]."','".$arr[$i]["M"]."','".$arr[$i]["N"]."','".$arr[$i]["O"]."','".$arr[$i]["P"]."')";
									    $result_insert1=mysql_query($sql_insert1) or die(mysql_error()); 
										$reports1="You are successfully registered with Smart Cookie";
										
						  }else
							   {
								    $err_flag="Err-Name";
									$sql_insert8="INSERT INTO `tbl_raw_parent` (std_PRN,Name,Phone,email_id,DateOfBirth,Gender,Address,country,FamilyIncome,school_id,college_mnemonic,batch_id,input_file_name,no_record_uploaded,file_type,uploaded_date_time,uploaded_by,error_status,Password,Qualification,Occupation,p_img_path,state,city,Mother_name)
								     VALUES ('$s_reg_no','".$arr[$i]["C"]."','".$arr[$i]["D"]."','".$arr[$i]["E"]."','".$arr[$i]["F"]."','".$arr[$i]["G"]."','".$arr[$i]["H"]."','".$arr[$i]["I"]."','".$arr[$i]["J"]."','$school_id','$mnemonic','$batch_id','$input_file_name','$totalrecords','$file_type1','$date','$uploaded_by','$err_flag','$password','".$arr[$i]["K"]."','".$arr[$i]["L"]."','".$arr[$i]["M"]."','".$arr[$i]["N"]."','".$arr[$i]["O"]."','".$arr[$i]["P"]."')";
									$result_insert8 = mysql_query($sql_insert8) or die(mysql_error());  
									$reports="Inserted data from Excel Sheet is not valid data";
							   }							  
        			   
									
										  if($result_insert1>=1)
										 { 
									       
									            $sql_insert9="INSERT INTO `tbl_parent` 
												(std_PRN,Name,Phone,email_id,DateOfBirth,Gender,Address,country,FamilyIncome,school_id,college_mnemonic,batch_id,input_file_name,no_record_uploaded,file_type,uploaded_date_time,uploaded_by,error_status,Password,Qualification,Occupation,p_img_path,state,city,Mother_name)
												SELECT std_PRN,Name,Phone,email_id,DateOfBirth,Gender,Address,country,FamilyIncome,school_id,college_mnemonic,batch_id,input_file_name,no_record_uploaded,file_type,uploaded_date_time,uploaded_by,error_status,Password,Qualification,Occupation,p_img_path,state,city,Mother_name
												FROM `tbl_raw_parent` WHERE std_PRN='$s_reg_no' AND school_id='$school_id'"; 
												$count9 = mysql_query($sql_insert9) or die(mysql_error()); 
											
											    $sql_update="UPDATE `tbl_raw_parent` SET error_status='Import' WHERE std_PRN='$s_reg_no' AND school_id='$school_id'";
											    $retval = mysql_query($sql_update) or die('Could not update data: ' . mysql_error());
							
												
												   
											}	
					}   // closing of if row<0
				
				    else
					{
						
						$count_of_duplicates=++$c_dup;
						$err_flag="Duplicate";
						$check_duplicate=mysql_query("select std_PRN from `tbl_raw_parent` where std_PRN='$s_reg_no'");
						if(mysql_num_rows($check_duplicate)==0)
						{
							$sql_insert8="INSERT INTO `tbl_raw_parent` (std_PRN,Name,Phone,email_id,DateOfBirth,Gender,Address,country,FamilyIncome,school_id,college_mnemonic,batch_id,input_file_name,no_record_uploaded,file_type,uploaded_date_time,uploaded_by,error_status,Password,Qualification,Occupation,p_img_path,state,city,Mother_name)
								     VALUES ('$s_reg_no','".$arr[$i]["C"]."','".$arr[$i]["D"]."','".$arr[$i]["E"]."','".$arr[$i]["F"]."','".$arr[$i]["G"]."','".$arr[$i]["H"]."','".$arr[$i]["I"]."','".$arr[$i]["J"]."','$school_id','$mnemonic','$batch_id','$input_file_name','$totalrecords','$file_type1','$date','$uploaded_by','$err_flag','$password','".$arr[$i]["K"]."','".$arr[$i]["L"]."','".$arr[$i]["M"]."','".$arr[$i]["N"]."','".$arr[$i]["O"]."','".$arr[$i]["P"]."')";
							$result_insert1 = mysql_query($sql_insert8) or die(mysql_error()); 
							$reports1="Inserted data from Excel Sheet is Duplicate";
						
						}else{
									$update_duplicate="UPDATE `tbl_raw_parent` SET std_PRN='$s_reg_no',Name='".$arr[$i]["C"]."',email_id='".$arr[$i]["D"]."',DateOfBirth='".$arr[$i]["E"]."',Gender='".$arr[$i]["G"]."',
								     Address='".$arr[$i]["H"]."',country='".$arr[$i]["I"]."',FamilyIncome='".$arr[$i]["J"]."',school_id='$school_id',Qualification='".$arr[$i]["K"]."',Occupation='".$arr[$i]["L"]."',p_img_path='".$arr[$i]["M"]."',state='".$arr[$i]["N"]."',city='".$arr[$i]["O"]."',Mother_name='".$arr[$i]["P"]."'
								     WHERE std_PRN='$s_reg_no' AND school_id='$school_id'";
									$udpdate_count = mysql_query($update_duplicate) or die('Could not update data: ' . mysql_error());
							 }
					
							$get_parent_info=mysql_query("select * from `tbl_parent` where std_PRN='$s_reg_no' AND school_id='$school_id'");
							//$num2=mysql_num_rows($get_stud_info);
							while($row2=mysql_fetch_array($get_parent_info))
							{


									$stud_prn=trim($row2['std_PRN']);
									$parent_name=trim($row2['Name']);
									$parent_phone=trim($row2['Phone']);
									$parent_schid=trim($row2['school_id']);
									$parent_emialid=trim($row2['email_id']);
									$parent_dob=trim($row2['DateOfBirth']);
									$parent_gen=trim($row2['Gender']);
									$parent_Add=trim($row2['Address']);	
									$parent_Ctry=trim($row2['country']);
									$parent_Fincome=trim($row2['FamilyIncome']);	
									$parent_Quali=trim($row2['Qualification']);
									$parent_Occu=trim($row2['Occupation']);	
									$parent_imgpath=trim($row2['p_img_path']);
									$parent_state=trim($row2['state']);	
									$parent_city=trim($row2['city']);
									$parent_Mname=trim($row2['Mother_name']);	
									
							}	
							 if($parent_name==$std_name){}
								   else{if($std_name!=""){
											$update_name="UPDATE `tbl_parent` SET Name='$std_name' where std_PRN='$s_reg_no' AND school_id='$school_id'";
											$update1= mysql_query($update_name) or die('Could not update data: ' . mysql_error());
										}
									    }
							if($parent_phone==$m_no){}
								   else{$m_val=preg_match('/^[0-9]+$/',$m_no);
								         if($m_val && $m_lenght==10){
											$update_ph="UPDATE `tbl_parent` SET Phone='$m_no' where std_PRN='$s_reg_no' AND school_id='$school_id'";
											$update2= mysql_query($update_name) or die('Could not update data: ' . mysql_error());
										}
									    }
							if($parent_schid==$school_id){}
							     else{$sch_val=preg_match("/^[a-zA-Z0-9]",$school_id);
								         if($sch_val || $sch_val!=""){
											$update_scid="UPDATE `tbl_parent` SET school_id='$school_id' where std_PRN='$s_reg_no' AND school_id='$school_id'";
											$update3= mysql_query($update_name) or die('Could not update data: ' . mysql_error());
										}
									    }
							if($parent_emialid==$email_id){}
									else{$em_val=filter_var($email_id, FILTER_VALIDATE_EMAIL);
											if($em_val){
											   $update_emailid="UPDATE `tbl_parent` SET email_id='$email_id' where std_PRN='$s_reg_no' AND school_id='$school_id'";
											   $update4= mysql_query($update_emailid) or die('Could not update data: ' . mysql_error());
											}
										}				
								if($parent_dob==$parnt_DOB){}
									else{$date_regex = "/([1-9]|0[1-9]|1[1-9]|2[1-9]|3[0-1])[ \/.-]([1-9]|0[1-9]|1[1-2])[ \/.-](19|20)\d\d/";
										$dov_val=preg_match($date_regex,$parnt_DOB);
										if($dov_val){	
											   $update_dob="UPDATE `tbl_parent` SET DateOfBirth='$parnt_DOB' where std_PRN='$s_reg_no' AND school_id='$school_id'";
											   $update5= mysql_query($update_dob) or die('Could not update data: ' . mysql_error());
										}
									    }
								if($parent_gen==$parnt_GENDER){}
									else{$gen_val=preg_match("/[a-zA-Z'-]/",$parnt_GENDER);
											if($gen_val){
											   $update_gen="UPDATE `tbl_parent` SET Gender='$parnt_GENDER' where std_PRN='$s_reg_no' AND school_id='$school_id'";
											   $update6= mysql_query($update_gen) or die('Could not update data: ' . mysql_error());
											}
										}	    
								if($parent_Add==$parnt_ADDRESS){}
									else{	$find = array(",",".");
											$add=str_replace($find,"",$parnt_ADDRESS);
											$add_val=preg_match('/^\s*[a-z0-9\s]+$/i',$add);
											if($add_val || $parnt_ADDRESS!=""){
											   $update_add="UPDATE `tbl_parent` SET Address='$parnt_ADDRESS' where std_PRN='$s_reg_no' AND school_id='$school_id'";
											   $update7= mysql_query($update_gen) or die('Could not update data: ' . mysql_error());
											}
										}	
								if($parent_Ctry==$parnt_CITY){}
									else{$cty_val=preg_match('/^[a-zA-Z ]*$/',$parnt_CITY);
											if($cty_val){
											   $update_gen="UPDATE `tbl_parent` SET city='$parnt_CITY' where std_PRN='$s_reg_no' AND school_id='$school_id'";
											   $update8= mysql_query($update_gen) or die('Could not update data: ' . mysql_error());
											}
										}
								if($parent_Ctry==$parnt_COUNTRY){}
									else{$country_val=preg_match("/^[a-zA-Z ]+$/",$parnt_COUNTRY);
											if($country_val){
											   $update_country="UPDATE `tbl_parent` SET country='$parnt_COUNTRY' where std_PRN='$s_reg_no' AND school_id='$school_id'";
											   $update9= mysql_query($update_gen) or die('Could not update data: ' . mysql_error());
											}
									}
								if($parent_Fincome==$parnt_FINCOME){}
									else{$income_val=preg_match('/^[0-9]+$/',$parnt_FINCOME);
											if($income_val){
											   $update_fincome="UPDATE `tbl_parent` SET FamilyIncome='$parnt_FINCOME' where std_PRN='$s_reg_no' AND school_id='$school_id'";
											   $update10= mysql_query($update_gen) or die('Could not update data: ' . mysql_error());
											}
										}			
								if($parent_Quali==$parnt_QUALIFICATION){}
									else{$que_val=preg_match("/^[a-zA-Z]{1,}([\s-]*[a-zA-Z\s\'-.]*)$/",$parnt_QUALIFICATION);
											if($que_val){
											   $update_qua="UPDATE `tbl_parent` SET Qualification='$parnt_QUALIFICATION' where std_PRN='$s_reg_no' AND school_id='$school_id'";
											   $update11= mysql_query($update_gen) or die('Could not update data: ' . mysql_error());
											}
										}			
								if($parent_Occu==$parnt_OCCUPATION){}
									else{ $occ_val=preg_match("/^[a-zA-Z]*$/",$parnt_OCCUPATION);
											if($occ_val){
											   $update_occu="UPDATE `tbl_parent` SET Occupation='$parnt_OCCUPATION' where std_PRN='$s_reg_no' AND school_id='$school_id'";
											   $update12= mysql_query($update_gen) or die('Could not update data: ' . mysql_error());
											}
										}
								if($parent_imgpath==$parnt_IMAGE_PATH){}
									else{ $img_val=filter_var($parnt_IMAGE_PATH, FILTER_VALIDATE_URL);
											if($img_val){
											   $update_imgpath="UPDATE `tbl_parent` SET p_img_path$parnt_IMAGE_PATH' where std_PRN='$s_reg_no' AND school_id='$school_id'";
											   $update13= mysql_query($update_gen) or die('Could not update data: ' . mysql_error());
											}
										}	
								if($parent_state==$parnt_STATE){}
									else{ $state_val=preg_match("/^[a-zA-Z ]*$/",$parnt_STATE);
											if($state_val){
											   $update_state="UPDATE `tbl_parent` SET state='$parnt_STATE' where std_PRN='$s_reg_no' AND school_id='$school_id'";
											   $update14= mysql_query($update_gen) or die('Could not update data: ' . mysql_error());
											}
										}
								if($parent_city==$parnt_CITY){}
									else{ $city_val=preg_match("/^[a-zA-Z ]*$/",$parnt_CITY);
											if($city_val){
											   $update_city="UPDATE `tbl_parent` SET city='$parnt_CITY' where std_PRN='$s_reg_no' AND school_id='$school_id'";
											   $update15= mysql_query($update_gen) or die('Could not update data: ' . mysql_error());
											}
										}	
								if($parent_Mname==$parnt_MOTHER_NAME){}
									else{$mom_val=preg_match("/^[a-zA-Z ]*$/",$parnt_MOTHER_NAME);
											if($mom_val){
											   $update_mname="UPDATE `tbl_parent` SET Mother_name='$parnt_MOTHER_NAME' where std_PRN='$s_reg_no' AND school_id='$school_id'";
											   $update16= mysql_query($update_gen) or die('Could not update data: ' . mysql_error());
											}
										}


					}					
				}else
					{
						 if($s_f>0 && $s_l>0)
						{$em_val=filter_var($email_id, FILTER_VALIDATE_EMAIL);
							if(!empty($m_no) || $em_val)
							{
										$err_flag="Err-SPRN";
										$sql_insert5="INSERT INTO `tbl_raw_parent` (std_PRN,Name,Phone,email_id,DateOfBirth,Gender,Address,country,FamilyIncome,school_id,college_mnemonic,batch_id,input_file_name,no_record_uploaded,file_type,uploaded_date_time,uploaded_by,error_status,Password,Qualification,Occupation,p_img_path,state,city,Mother_name)
										VALUES ('$s_reg_no','".$arr[$i]["C"]."','".$arr[$i]["D"]."','".$arr[$i]["E"]."','".$arr[$i]["F"]."','".$arr[$i]["G"]."','".$arr[$i]["H"]."','".$arr[$i]["I"]."','".$arr[$i]["J"]."','$school_id','$mnemonic','$batch_id','$input_file_name','$totalrecords','$file_type1','$date','$uploaded_by','$err_flag','$password','".$arr[$i]["K"]."','".$arr[$i]["L"]."','".$arr[$i]["M"]."','".$arr[$i]["N"]."','".$arr[$i]["O"]."','".$arr[$i]["P"]."')";
										$result_insert5 = mysql_query($sql_insert5) or die(mysql_error()); 
										$reports="plz put Student PRN in excel sheet.";
							}
						}	
					}
					
			
							$count_of_updates=$count_of_duplicates;	   // for counting number of Updates records
							
					
		
				}else
					{
						$count_of_wrong_school_id=++$id;
						$err_flag="Err-SCID";
						$sql_insert18="INSERT INTO `tbl_raw_parent` (std_PRN,Name,Phone,email_id,DateOfBirth,Gender,Address,country,FamilyIncome,school_id,college_mnemonic,batch_id,input_file_name,no_record_uploaded,file_type,uploaded_date_time,uploaded_by,error_status,Password,Qualification,Occupation,p_img_path,state,city,Mother_name)
								     VALUES ('$s_reg_no','".$arr[$i]["C"]."','".$arr[$i]["D"]."','".$arr[$i]["E"]."','".$arr[$i]["F"]."','".$arr[$i]["G"]."','".$arr[$i]["H"]."','".$arr[$i]["I"]."','".$arr[$i]["J"]."','$school_id','$mnemonic','$batch_id','$input_file_name','$totalrecords','$file_type1','$date','$uploaded_by','$err_flag','$password','".$arr[$i]["K"]."','".$arr[$i]["L"]."','".$arr[$i]["M"]."','".$arr[$i]["N"]."','".$arr[$i]["O"]."','".$arr[$i]["P"]."')";
						$result_insert18 = mysql_query($sql_insert18) or die(mysql_error()); 
						
					
					}
		
			} // for loop closing
		}
//------------------------------------ Code Of batch master-------------------------------------
				$query4="select count(case when `error_status`= 'Err-Phone/Email' then 1 else null end) as PHONE,
						count(case when  `error_status`='Err-SPRN' then 1 else null end) as SPRN,
						count(case when `error_status`='Err-Name' then 1 else null end) as NAME,
						count(case when `error_status`='Err-SCID' then 1 else null end) as SC_ID
						from `tbl_raw_parent` where school_id='$school_id' and batch_id like '$batch_id'";       
				$row4=mysql_query($query4);
				$value4=mysql_fetch_array($row4);
				$phone=$value4['PHONE'];
				$s_prn=$value4['SPRN'];
				$name=$value4['NAME'];
				$wrong_SCID=$value4['SC_ID'];
				$error_count=$phone+$s_prn+$name+$wrong_SCID+$count_of_duplicates;
				$correct_records=$totalrecords-$error_count;
				if($correct_records>=0)
				{
					$tbl_name="Parent_Master";
					$db_tbl_name="tbl_parent";
					$sql_insert10="INSERT INTO `tbl_Batch_Master`(batch_id,input_file_name,file_type,uploaded_date_time,uploaded_by,num_records_uploaded,num_errors_records,num_duplicates_record,num_correct_records,num_records_updated,display_table_name,db_table_name,num_errors_scid)
					VALUES ('$batch_id','$input_file_name','$file_type1','$date','$uploaded_by','$totalrecords','$error_count','$count_of_duplicates','$correct_records','$count_of_updates','$tbl_name','$db_tbl_name','$count_of_wrong_school_id')";
					$count10 = mysql_query($sql_insert10) or die(mysql_error());
				}
				
//----------------------------------------End Of batch master-----------------------------------
}
else
{
	echo "<script type=text/javascript>alert('Plz select upload limit'); window.location=''</script>";
}
 
		
     }  // else closing
								
	}    //for exist name
			
	             
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
             
                <h3>Add Parent Excel Sheet</h3>
            
            
               
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
                                        	<select name="limit" class="limitofuploadingrecords" id="limit" style="width:20%; height:30px; border-radius:2px;margin-left:455px;">
                                              <option value="20" disabled selected>Set upload Records Limit</option>
											  <option value="1">1</option>
											  <option value="4">4</option>
											  <option value="10">10</option>
											  <option value="20">20</option>
											  <option value="40">40</option>
											  <option value="50">50</option>
											  <option value="60">60</option>
											  <option value="70">70</option>
											  <option value="80">80</option>
											  <option value="90">90</option>
											  <option value="100">100</option>
											  <option value="150">150</option>
											  <option value="200">200</option>
											  <option value="250">250</option>
											   <option value="300">300</option>
											  <option value="350">350</option>
											   <option value="400">400</option>
											   <option value="450">450</option>
											  <option value="500">500</option>
											  <option value="500">500</option>
											  <option value="600">600</option>
											   <option value="620">620</option>
											   <option value="621">621</option>
											  <option value="700">700</option>
											  <option value="720">720</option>
											  <option value="800">800</option>
											  <option value="824">824</option>
											  <option value="800">852</option>
											  <option value="900">900</option>
                                              <option value="1000">1000</option>
                                              <option value="1500">1500</option>
											  <option value="1766">1766</option>
											  <option value="2500">2450</option>
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
                                  <button class='btn-lg btn-danger'  type='submit'>Cancel</button>
                                </div>
                                </div>
                                <div class="row">
                                    <div class='col-md-6 col-md-offset-2' align="center" style="color:black;margin-top:15px;padding-left:201px;">
									 	
                                    <?php echo $reports1."<br>";
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
									 <?php $query2="select batch_id from `tbl_raw_parent` WHERE school_id='$school_id' ORDER BY `parent_Id` DESC LIMIT 1 ";  //query for getting last batch_id what else if are inserting first time data
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
<center><a href="download_stud_upload_format.php?name=<?php echo "P";?>">Download Parent Upload Excel Sheet Format</a></center><tr>
<center><?php for($space=1;$space<=25;$space++){?>&nbsp;<?php }?>
<a href="download_stud_upload_format.php?name=<?php echo "EP";?>">Download Parent Error Excel Sheet</a></center><tr>

</table>
</div>
</div>


</form>


</body>

</html>
<?php
	
	}
	
?>