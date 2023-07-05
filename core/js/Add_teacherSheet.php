<?php
 require_once("excelreader/Excel/reader.php");
include("scadmin_header.php");
       if(isset($_FILES['file']['tmp_name']))
{
$edata = new Spreadsheet_Excel_Reader();
$_SERVER['DOCUMENT_ROOT'];
// Set output Encoding.
$edata->setOutputEncoding('CP1251');

//print_r($_FILES);
if($_FILES['file']['tmp_name'])
{

$uploadurl='data';
 $tmp_name= $_FILES['file']['tmp_name'];
$name=$_FILES['file']['name'];
  

$edata->read($tmp_name);
//move_uploaded_file($tmp_name,"$uploadurl/$name");
}
//print_r($edata);
//error_reporting(E_ALL ^ E_NOTICE);
$arr=array();

//for($k=0;$k<=2;$k++)
//{

for ($i = 2; $i <= $edata->sheets[0]['numRows']; $i++)
{


	for ($j = 1; $j <= $edata->sheets[0]['numCols']; $j++)
	{
		$arr[$i][$j]=$edata->sheets[0]['cells'][$i][$j];
	
	}
	$date=$arr[$i][9];
	echo list($month,$day,$year) = explode("/",$date);
    $year_diff  = date("Y") - $year;
    $month_diff = date("m") - $month;
    $day_diff   = date("d") - $day;
    if ($day_diff < 0 || $month_diff < 0) $year_diff--;
    echo $age= $year_diff;
	$t_date = date('m/d/Y');
	 $sql_insert="INSERT INTO tbl_teacher(t_name,t_current_school_name,school_id,t_exprience,t_subject,t_class,t_qualification,t_address,t_city,t_dob,t_age,t_gender,t_country,state,t_email,t_date) VALUES ('".$arr[$i][1]."','".$arr[$i][2]."','".$arr[$i][3]."','".$arr[$i][5]."','".$arr[$i][6]."','".$arr[$i][7]."','".$arr[$i][4]."','".$arr[$i][10]."','".$arr[$i][13]."','".$arr[$i][9]."','$age','".$arr[$i][8]."','".$arr[$i][11]."','".$arr[$i][12]."','".$arr[$i][14]."','$t_date')";
					$result_insert = mysql_query($sql_insert) or die(mysql_error()); 
					if($result_insert>=1){$report="successfully updated"; header("Location:Add_teacherSheet.php?report=".$report);}
}


}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<link href='css/bootstrap.min.css' rel='stylesheet' type='text/css'>
  <link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
  <link href='css/bootstrap-switch.css' rel='stylesheet' type='text/css'>
  <link href='css/bootstrap-multiselect.css' rel='stylesheet' type='text/css'>
  <script src='js/jquery.min.js' type='text/javascript'></script>
  <script src='js/bootstrap.min.js' type='text/javascript'></script>
  <script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
  <script src='js/bootstrap-switch.min.js' type='text/javascript'></script>
  <script src='js/bootstrap-multiselect.js' type='text/javascript'></script>

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
                          <input type='file' name='file'  size='30' /> 
                         </div> 
                    </div>
                  </div>
                  <div style="height:50px;"></div>
                  <div class='form-group'>
                                <div class='col-md-offset-3 col-md-3'>
                                  <input class='btn-lg btn-primary' type='submit'   value="Submit" name="submit" />
                                </div>
                                <div class='col-md-3'>
                                  <button class='btn-lg btn-danger'  type='submit'>Cancel</button>
                                </div>
                  </div>
         </form>
	</div>
</div>
<table cellpadding="4" cellspacing="4" >
<tr bgcolor="#9900CC">
<th bgcolor="#CCCCCC">Name</th>
<th bgcolor="#CCCCCC">Qualification</th>
<th bgcolor="#CCCCCC">Experience</th>
<th bgcolor="#CCCCCC">subject</th>
<th bgcolor="#CCCCCC">Class</th>
<th bgcolor="#CCCCCC">Gender</th>
<th bgcolor="#CCCCCC">Date of Birth</th>
<th bgcolor="#CCCCCC">Address</th>
<th bgcolor="#CCCCCC">country</th>
<th bgcolor="#CCCCCC">State</th>
<th bgcolor="#CCCCCC">city</th>
<th bgcolor="#CCCCCC">Email</th>
<th bgcolor="#CCCCCC">Password</th>


</tr>
</table>





</body>

</html>
