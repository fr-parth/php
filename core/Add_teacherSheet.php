<?php 
  if(isset($_GET['id']))
  {
	  include_once("school_staff_header.php");
/*
This script is use to upload any Excel file into database.
Here, you can browse your Excel file and upload it into 
your database.
*/

$sch_id=$_GET['id'];
$reports="";
$report="";
/*$id=$_SESSION['id'];
           $fields=array("id"=>$id);
		   $table="tbl_school_admin";
		   $smartcookie=new smartcookie();*/
		   
$results=mysql_query("SELECT * FROM tbl_school_admin WHERE school_id =".$sch_id."");
$arrs=mysql_fetch_array($results);

			$school_id=$arrs['school_id'];
			$school_name=$arrs['school_name'];
$uploadedStatus = 0;

if ( isset($_POST["submit"]) ) {
if ( isset($_FILES["file"])) {
//if there was an error uploading the file
if ($_FILES["file"]["error"]>0)
{
   "Return Code: ".$_FILES["file"]["error"]."<br />";
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

$reports="";
$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
 $arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet
$arr=array();
$email_already=array();
 $j=0;
for($i=2;$i<=$arrayCount;$i++){
$arr[$i]["A"]=trim($allDataInSheet[$i]["A"]);
$arr[$i]["B"]=trim($allDataInSheet[$i]["B"]);
$arr[$i]["C"]=trim($allDataInSheet[$i]["C"]);
$arr[$i]["D"]=trim($allDataInSheet[$i]["D"]);
$arr[$i]["E"]=trim($allDataInSheet[$i]["E"]);
$arr[$i]["F"]=trim($allDataInSheet[$i]["F"]);
$arr[$i]["G"]=trim($allDataInSheet[$i]["G"]);
$arr[$i]["H"]=trim($allDataInSheet[$i]["H"]);
$arr[$i]["I"]=trim($allDataInSheet[$i]["I"]);
$arr[$i]["J"]=trim($allDataInSheet[$i]["J"]);
 $date=$arr[$i]["E"];
 $email=$arr[$i]["J"];

 
$row=mysql_query("select * from tbl_teacher where t_email like '$email' ");
		if(mysql_num_rows($row)<=0)
		{
	 list($day,$month,$year) = explode("/",$date);
    $year_diff  = date("Y") - $year;
    $month_diff = date("m") - $month;
    $day_diff   = date("d") - $day;
    if ($day_diff < 0 || $month_diff < 0) $year_diff--;
     $age= $year_diff;
	$t_date = date('m/d/Y');
	
 $password = $allDataInSheet[$i]['A']."123";
	
		$sql_insert="INSERT INTO tbl_teacher(t_name,t_current_school_name,school_id,t_school_staff_id,t_exprience,t_qualification,t_address,t_city,t_dob,t_age,t_gender,t_country,state,t_email,t_date,t_password) VALUES ('". trim($allDataInSheet[$i]["A"])."','$school_name','$school_id','$staff_id','".$arr[$i]["C"]."','".$arr[$i]["B"]."','".$arr[$i]["F"]."','".$arr[$i]["I"]."','$date','$age','".$arr[$i]["D"]."','".$arr[$i]["G"]."','".$arr[$i]["H"]."','".$arr[$i]["J"]."','$t_date','$password')";
					$count = mysql_query($sql_insert) or die(mysql_error()); 
		if($count>=1){
		
	$to=$arr[$i]["J"];
	$from="smartcookiesprogramme@gmail.com";
	$subject="Successful Registration";
	$message="Hello ".$allDataInSheet[$i]['A']."\r\n\r\n".
		 "Thanks for registration with Smart Cookie as teacher\r\n".
		  "your Username is: "  .$arr[$i]["J"].  "\n\n".
		  "your password is: ".$password."\n\n".
		   "Regards,\r\n".
   	      "Smart Cookie Admin";
		  
       mail($to, $subject, $message);
		}
		}
		else
		{
		 $email_already[$j]=$email;
		$j++;
		}
}
if(count($email_already)>0)
{
	
	if(count($email_already)>1)
	{
	for($i=0;$i<count($email_already)-1;$i++)
	{
	 $reports=$reports.$email_already[$i].",";
	}
	$reports=$reports.$email_already[count($email_already)-1];
	 $reports=$reports."are already present";
	}
	else
	{
	
	$reports=$email_already[count($email_already)-1]."is already present";
	}
}
else
{
$report="You are successfully registered and  passwords are sent to respective E-mail Id";

}

				/*unlink($inputFileName);
if($result_insert>=1){$report="successfully updated"; header("Location:Add_teacherSheet.php?report=".$report);}
*/
}

} else {
echo "No file selected <br />";
}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>



</head>

<body >
<div class='container' style="padding-top:30px;padding-left:30px;">
<div class='panel panel-primary dialog-panel'>
<div style="color:#008000;font-size:15px;font-weight:bold;margin-top:10px;"><?php if(isset($_GET['report'])){ echo $_GET['report']; };?></div>
          <div class='panel-heading'>
             
                <h3>Add Excel Sheet</h3>
            
            
               
              </div>
      <div class='panel-body'>
   		<form name='frm' method='post' enctype='multipart/form-data' id='frm'>
        
          
                  <div class='form-group'>
                  		<label class='control-label col-md-2 col-md-offset-2' for='id_title'></label>
                    <div class='col-md-8'>
                        <div class='col-md-8 indent-small'>
                            <input type='file' name='file'  id='file' size='30' /> </div> 
                    </div>
                  </div>
                  <div style="height:50px;"></div>
                  <div class='form-group'>
                                <div class='col-md-offset-3 col-md-3'>
                                  <input class='btn-lg btn-primary' type='submit'   value="Submit" name="submit" />
                                </div>
                                <div class='col-md-3'>
          <a href="Admin_Staff_setup.php?id=<?=$sch_id?>"><input type="button" class='btn-lg btn-danger' value="Back"></a>
                                   </div>
                                </div>
                                <div class="row">
                                    <div class='col-md-6 col-md-offset-2' style="color:#FF0000;">
                                    <?php echo $reports;
									echo $report;
									?>
                                    </div>
                                </div>
                 
         </form>
	</div>
</div>
<div class="row">
<div class="col-md-1"></div>
<div class="col-md-12 ">
<table cellpadding="12" cellspacing="6" >
<tr bgcolor="#9900CC">
<th bgcolor="#CCCCCC">Name</th>
<th bgcolor="#CCCCCC">Qualification</th>
<th bgcolor="#CCCCCC">Experience</th>
<th bgcolor="#CCCCCC">Gender</th>
<th bgcolor="#CCCCCC" >Date of Birth(DD/MM/YYYY)</th>
<th bgcolor="#CCCCCC">Address</th>
<th bgcolor="#CCCCCC">country</th>
<th bgcolor="#CCCCCC">State</th>
<th bgcolor="#CCCCCC">city</th>
<th bgcolor="#CCCCCC">Email</th></tr>
<tr>


</table>
</div>
</div>





</body>

</html>
<?php
  }
  else
  {
	  include("scadmin_header.php");
/*
This script is use to upload any Excel file into database.
Here, you can browse your Excel file and upload it into 
your database.
*/
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

if ( isset($_POST["submit"]) ) {
if ( isset($_FILES["file"])) {
//if there was an error uploading the file
if ($_FILES["file"]["error"]>0)
{
 "Return Code: ".$_FILES["file"]["error"]."<br />";
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

$reports="";
$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
 $arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet
$arr=array();
$email_already=array();
 $j=0;
for($i=2;$i<=$arrayCount;$i++){
$arr[$i]["A"]=trim($allDataInSheet[$i]["A"]);
$arr[$i]["B"]=trim($allDataInSheet[$i]["B"]);
$arr[$i]["C"]=trim($allDataInSheet[$i]["C"]);
$arr[$i]["D"]=trim($allDataInSheet[$i]["D"]);
$arr[$i]["E"]=trim($allDataInSheet[$i]["E"]);
$arr[$i]["F"]=trim($allDataInSheet[$i]["F"]);
$arr[$i]["G"]=trim($allDataInSheet[$i]["G"]);
$arr[$i]["H"]=trim($allDataInSheet[$i]["H"]);
$arr[$i]["I"]=trim($allDataInSheet[$i]["I"]);
$arr[$i]["J"]=trim($allDataInSheet[$i]["J"]);
 $date=$arr[$i]["E"];
 $email=$arr[$i]["J"];

 
$row=mysql_query("select * from tbl_teacher where t_email like '$email' ");
		if(mysql_num_rows($row)<=0)
		{
	 list($day,$month,$year) = explode("/",$date);
    $year_diff  = date("Y") - $year;
    $month_diff = date("m") - $month;
    $day_diff   = date("d") - $day;
    if ($day_diff < 0 || $month_diff < 0) $year_diff--;
     $age= $year_diff;
	$t_date = date('m/d/Y');
	
 $password = $allDataInSheet[$i]['A']."123";
	
		$sql_insert="INSERT INTO tbl_teacher(t_name,t_current_school_name,school_id,t_exprience,t_qualification,t_address,t_city,t_dob,t_age,t_gender,t_country,state,t_email,t_date,t_password) VALUES ('". trim($allDataInSheet[$i]["A"])."','$school_name','$school_id','".$arr[$i]["C"]."','".$arr[$i]["B"]."','".$arr[$i]["F"]."','".$arr[$i]["I"]."','$date','$age','".$arr[$i]["D"]."','".$arr[$i]["G"]."','".$arr[$i]["H"]."','".$arr[$i]["J"]."','$t_date','$password')";
					$count = mysql_query($sql_insert) or die(mysql_error()); 
		if($count>=1){
		
	$to=$arr[$i]["J"];
	$from="smartcookiesprogramme@gmail.com";
	$subject="Successful Registration";
	$message="Hello ".$allDataInSheet[$i]['A']."\r\n\r\n".
		 "Thanks for registration with Smart Cookie as teacher\r\n".
		  "your Username is: "  .$arr[$i]["J"].  "\n\n".
		  "your password is: ".$password."\n\n".
		   "Regards,\r\n".
   	      "Smart Cookie Admin";
		  
       mail($to, $subject, $message);
		}
		}
		else
		{
		 $email_already[$j]=$email;
		$j++;
		}
}
if(count($email_already)>0)
{
	
	if(count($email_already)>1)
	{
	for($i=0;$i<count($email_already)-1;$i++)
	{
	 $reports=$reports.$email_already[$i].",";
	}
	$reports=$reports.$email_already[count($email_already)-1];
	 $reports=$reports."are already present";
	}
	else
	{
	
	$reports=$email_already[count($email_already)-1]."is already present";
	}
}
else
{
$report="You are successfully registered and  passwords are sent to respective E-mail Id";

}

				/*unlink($inputFileName);
if($result_insert>=1){$report="successfully updated"; header("Location:Add_teacherSheet.php?report=".$report);}
*/
}

} else {
echo "No file selected <br />";
}
}

?>









<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>



</head>

<body >
<div class='container' style="padding-top:30px;padding-left:30px;">
    <div class='panel panel-primary dialog-panel'>
   <div style="color:red;font-size:15px;font-weight:bold;margin-top:10px;"> <?php if(isset($_GET['report'])){ echo $_GET['report']; };?></div>
          <div class='panel-heading'>
             
                <h3>Add Excel Sheet</h3>
            
            
               
              </div>
      <div class='panel-body'>
   		<form name='frm' method='post' enctype='multipart/form-data' id='frm'>
        
          
                  <div class='form-group'>
                  		<label class='control-label col-md-2 col-md-offset-2' for='id_title'></label>
                    <div class='col-md-8'>
                        <div class='col-md-8 indent-small'>
                            <input type='file' name='file'  id='file' size='30' />                          </div> 
                    </div>
                  </div>
                  <div style="height:50px;"></div>
                  <div class='form-group'>
                                <div class='col-md-offset-3 col-md-3'>
                                  <input class='btn-lg btn-primary' type='submit'   value="Submit" name="submit" />
                                </div>
                                <div class='col-md-3'>
               <a href="Admin_Staff_setup.php"><input type="button" class='btn-lg btn-danger' value="Back"></a>
                                </div>
                                </div>
                                <div class="row">
                                    <div class='col-md-6 col-md-offset-2' style="color:#FF0000;">
                                    <?php echo $reports;
									echo $report;
									?>
                                    </div>
                                </div>
                 
         </form>
	</div>
</div>
<div class="row">
<div class="col-md-1"></div>
<div class="col-md-12 ">
<table cellpadding="12" cellspacing="6" >
<tr bgcolor="#9900CC">
<th bgcolor="#CCCCCC">Name</th>
<th bgcolor="#CCCCCC">Qualification</th>
<th bgcolor="#CCCCCC">Experience</th>
<th bgcolor="#CCCCCC">Gender</th>
<th bgcolor="#CCCCCC" >Date of Birth(DD/MM/YYYY)</th>
<th bgcolor="#CCCCCC">Address</th>
<th bgcolor="#CCCCCC">country</th>
<th bgcolor="#CCCCCC">State</th>
<th bgcolor="#CCCCCC">city</th>
<th bgcolor="#CCCCCC">Email</th></tr>
<tr>


</table>
</div>
</div>





</body>

</html>
<?php
  }
?>
