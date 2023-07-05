<?php
/**
 * Created by PhpStorm.
 * User: Bpsi-Rohit
 * Date: 9/14/2017
 * Time: 4:23 PM
 */
include("groupadminheader.php");
$group_member_id=$_SESSION['id'];
$group_mnumonic_code1=$group_mnumonic_code;
$created_by=$group_admin_name;

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
		//changes done by Saumya intern start here
		if($_FILES["file"]["size"] > 1)
		{
		$start_row = 1;
		$total_excel_data=0;
		$insert_scl=0;
		$update_scl=0;
		if (($csv_file = fopen($filename, "r")) !== FALSE) {
		  while (($read_data = fgetcsv($csv_file, 1000, ",")) !== FALSE) {
			  $total_excel_data+=1;
			$column_count = count($read_data);
			if($start_row==1){

			}else{
				$created_on=date("Y/m/d") .' '. date("h:i:sa");
				$password=$read_data[0] . "123";
				$scl_exist_chk_qry=mysql_query("SELECT count(school_id) as scl_cnt from tbl_school_admin where school_id='".$read_data[1]."'");
				$scl_exist_chk_result=mysql_fetch_array($scl_exist_chk_qry);

				$scl_exist_chk_qry1=mysql_query("SELECT count(school_id) as scl_cnt1 from tbl_group_school where school_id='".$read_data[1]."' and group_member_id='".$group_member_id."' ");
				$scl_exist_chk_result1=mysql_fetch_array($scl_exist_chk_qry1);
				if($scl_exist_chk_result['scl_cnt']>=1){
					$scl_update_qry=mysql_query("update tbl_school_admin set DTECode ='".$read_data[0]."' , school_name='".$read_data[2]."' , name='".$read_data[3]."',stream='".$read_data[4]."',address='".$read_data[5]."',email='".$read_data[6]."',mobile='".$read_data[7]."' where school_id='".$read_data[1]."' ");
					$update_scl+=1;
				}else{
					$sql1=mysql_query("INSERT into tbl_school_admin(DTECode,school_id,school_name,name,stream,address,email,mobile,school_type,password) values('".$read_data[0]."','".$read_data[1]."','".$read_data[2]."','".$read_data[3]."','".$read_data[4]."','".$read_data[5]."','".$read_data[6]."','".$read_data[7]."','".$read_data[8]."','$password')");
					$insert_scl+=1;
				}
				if($scl_exist_chk_result1['scl_cnt1']==0){
				$sql2=mysql_query("INSERT into tbl_group_school (group_member_id,group_mnemonic_name,school_id,createdby,createdon) values ('".$group_member_id."','".$group_mnumonic_code1."','".$read_data[1]."','".$created_by."','".$created_on."')");
					// $scl_update_qry=mysql_query("update tbl_group_school set group_mnemonic_name ='".$group_mnumonic_code1."' , modifiedby='".$created_by."' , createdon='".$created_on."' where school_id='".$read_data[1]."' and group_member_id='".$group_member_id."' ");
				}else{
						// echo "<script type=\"text/javascript\">
						// 	alert(\" School Id Update Sucessfully. \");
						// 	window.location =  \"Add_school_dataexcel.php\"
						// 	</script>";
				}
			}
			$start_row++;

			}
			
			fclose($csv_file);
			}
			if($insert_scl || $update_scl )
					{
						$total_excel_data-=1;
						echo "<script type=\"text/javascript\">
							alert(\"CSV File has been successfully Imported.We recived $total_excel_data in which $insert_scl inserted and $update_scl updated. \");
							window.location = \"Add_school_dataexcel.php\"
						</script>";
					}
					else {
						echo "<script type=\"text/javascript\">
								alert(\"Invalid File:Please Upload CSV File.\");
								window.location = \"Add_school_dataexcel.php\"
							  </script>";
						
					}
	}
		//changes done by Saumya intern end here
		

		// if($_FILES["file"]["size"] > 1)
		// {
		// 	$file = fopen($filename, "r");
		// 	$count=0;
		// 	while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
		// 	{
		// 		// if($count == 0){

		// 		// }else{
		// 			$column_count=count($getData);
		// 			$count++;
		// 			for($a=0;$c<=$column_count;$c++){
		// 				// echo "ji";  
		// 				// echo "<br>". $getData[$c] ."<br>";
		// 			}
		// 			// $myvalue = 'Test me more';
		// 			// $strng_getvalue=trim($getData[0]," ");
		// 			// echo $getData[0] .' , '.$getData[1];
		// 			// echo $strng_getvalue;echo gettype($strng_getvalue) . "<br>";
		// 			// var_dump($getData);
		// 			// $arr1=array();
		// 			// $arr1 = explode(" ",$strng_getvalue);
		// 			// print_r($arr1)."<br>";

		// 			$password=$arr[0]."123"; // will print Test																						
		// 			echo "INSERT into tbl_school_admin(DTECode,school_id,school_name,name,stream,address,email,mobile,school_type,password) values('".$arr1[0]."','".$arr1[1]."','".$arr1[2]."','".$arr1[3]."','".$arr1[4]."','".$arr1[5]."','".$arr1[6]."','".$arr1[7]."','".$arr1[8]."','$password')";		echo "<br>";
					
		// 		$sql = "INSERT into tbl_school_admin(DTECode,school_id,school_name,name,stream,address,email,mobile,school_type,password) values('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."','".$getData[6]."','".$getData[7]."','".$getData[8]."','$password')";
		// 			$result = mysql_query($sql);
		// 			if(!isset($result))
		// 			{
		// 				echo "<script type=\"text/javascript\">
		// 						alert(\"Invalid File:Please Upload CSV File.\");
		// 						window.location = \"Add_school_dataexcel.php\"
		// 					  </script>";
		// 			}
		// 			else {
		// 				echo "<script type=\"text/javascript\">
		// 					alert(\"CSV File has been successfully Imported.\");
		// 					window.location = \"Add_school_dataexcel.php\"
		// 				</script>";//changes done by Pranali intern end here
		// 			}
		// 		// }
		// 	}
		// 	fclose($file);
		// }
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
