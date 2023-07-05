<?php
/**
 * Created by PhpStorm.
 * User: Bpsi-Rohit
 * Date: 9/14/2017
 * Time: 4:23 PM
 */
include_once("cookieadminheader.php");
//changes done by Pranali intern start
if(isset($_POST["Import"]))
{
     $filename=$_FILES["file"]["tmp_name"];
	 $fname=$_FILES["file"]["name"];
	 $filepath="C:/Users/tata/Downloads/".$fname;
	 $ext = pathinfo($filepath, PATHINFO_EXTENSION);
	 
    /*$con=mysql_connect("50.63.166.149","smartcoo_dev1","Black348Berry") or die('conn failed');
    mysql_select_db("smartcoo_dev",$con) or die('db failed');*/
    if($ext=="")
	{
		echo "<script>alert('Please Upload File!!');</script>";
	}
	else if($ext!="xls" && $ext!="csv")
	{
		echo "<script>alert('Please Upload Excel File!!');</script>";
	}
	else
	{
		if($_FILES["file"]["size"] > 1)
		{
			$file = fopen($filename, "r");
			$count=0;
			while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
			{
				if($count == 0){

				}else{
					$myvalue = 'Test me more';
					$arr = explode(' ',trim($getData[3]));
					$password=$arr[0]."123"; // will print Test
					// echo "INSERT into tbl_school_admin(DTECode,school_id,school_name,name,stream,address,email,mobile,school_type,password) values('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."','".$getData[6]."','".$getData[7]."','".$getData[8]."','$password')";		echo "<br>";
					$sql = "INSERT into tbl_school_admin(DTECode,school_id,school_name,name,stream,address,email,mobile,school_type,password) values('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."','".$getData[6]."','".$getData[7]."','".$getData[8]."','$password')";
					$result = mysql_query($sql);
					if(!isset($result))
					{
						echo "<script type=\"text/javascript\">
								alert(\"Invalid File:Please Upload CSV File.\");
								window.location = \"Add_school_dataexcel.php\"
							  </script>";
					}
					else {
						echo "<script type=\"text/javascript\">
							alert(\"CSV File has been successfully Imported.\");
							window.location = \"Add_school_dataexcel.php\"
						</script>";//changes done by Pranali intern end here
					}
				}
				$count++;
			}
			fclose($file);
		}
	}
}
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
    <div class='panel-body' style="background:#CCC; border-color:#666; ">

         <form class="form-horizontal" action="" method="post" name="upload_excel" enctype="multipart/form-data">
            <div class="row" style="margin-top:5%;" align="center">
                <h3>Upload College List</h3>
            </div>
            <div class="row" style="margin-top:5%;" align="center">
                <input type="file" name="file" id="file" class="input-large">
            <div class="row" style="margin-top:4%;" align="center">
                 <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
            </div>
            <div class="row" style="color:red; margin-top:2%;" align="center"> <?php /*echo $report;*/?></div>
        </form>

   <div class="row" ><center>
                <a href="Download_college_data.php?id=<?php echo "0".","."D";?>">Download College Data Sheet Format</a>
            </center></div>
    </div>
</div>
</body>
</html>
