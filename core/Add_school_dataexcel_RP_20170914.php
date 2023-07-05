
	<?php

include_once("cookieadminheader.php");
	 
	 include("smartcookiefunction.php");

 
$uploadedStatus = 0;
$report="";

if ( isset($_POST["submit"]) ) 
{
	
    if ( !empty($_FILES["file"]["name"])) 
	{
		
		$sql2=mysql_query("select batch_id from tbl_Batch_Master where school_id='0' and entity='Cookie_Admin' and uploaded_by like 'Cookie_Admin' order by id desc");
	$resultsql=mysql_fetch_array($sql2);
$count=mysql_num_rows($sql2);	 
		   $date1=date('Y-m-d h:i:s',strtotime('+330 minute'));
		 if($count=="")
		 {
			$batch_id="School"."-"."B-1";
			 			 
		 }
		 else
		 {
			 
			 
			$batch_id=$resultsql['batch_id'];
			$b_id=explode("-",$batch_id);
			$batch=$b_id[2];
			$batch=$batch+1;
			$batch_id="School"."-"."B-".$batch;
						
		 }
		 $storagename= $_FILES["file"]["name"];
	
		  $sql3=mysql_query("insert into tbl_Batch_Master (batch_id,input_file_name,uploaded_date_time,uploaded_by,entity,school_id)values('$batch_id','$storagename','$date1','Cookie_Admin','Cookie_Admin','0') ");
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
				echo "<pre>";
				var_dump($allDataInSheet);die;
				$arrayCount = count($allDataInSheet); 
				
				$DataCount = $arrayCount-1;  // Here get total count of row in that Excel sheet
				
				$dates=date('Y/m/d');
				$arr=array();
				/*echo "<pre>";
				var_dump($allDataInSheet);die;*/
				for($i=1;$i<=$arrayCount;$i++)
				{
				/*$arr[$i]["A"]=str_replace("'","", trim($allDataInSheet[$i]["A"])); // dte_code
				$arr[$i]["B"]=str_replace("'","", trim($allDataInSheet[$i]["B"]));   // school id
				$arr[$i]["C"]=str_replace("'","", trim($allDataInSheet[$i]["C"]));  // school name
				$arr[$i]["D"]=str_replace("'","", trim($allDataInSheet[$i]["D"]));   // admin name
				$arr[$i]["E"]=str_replace("'","", trim($allDataInSheet[$i]["E"]));  // stream
				$arr[$i]["F"]=str_replace("'","", trim($allDataInSheet[$i]["F"]));  // address
				$arr[$i]["G"]=str_replace("'","", trim($allDataInSheet[$i]["G"]));  // email
				$arr[$i]["H"]=str_replace("'","", trim($allDataInSheet[$i]["H"]));  // phone*/
				
				$allDataInSheet[$i]["A"]="DTE-000001"; // dte_code
				$allDataInSheet[$i]["B"]="5001";   // school id
				$allDataInSheet[$i]["C"]="Test School";  // school name
				$allDataInSheet[$i]["D"]="Testing Pravin";   // admin name
				$allDataInSheet[$i]["E"]="School";  // stream
				$allDataInSheet[$i]["F"]="Kothrud pune";  // address
				$allDataInSheet[$i]["G"]="pravinc@blueplanetsolutions.com";  // email
				$allDataInSheet[$i]["H"]="9421614354";  // phone
				//$dte_code=$allDataInSheet[$i]["A"];				// for teacher ID
				$dte_code=$allDataInSheet[$i]["A"];				// for teacher ID
				$dte_code=trim($dte_code);
				
				$sc_id=$allDataInSheet[$i]["B"];   // for teacher ID
				$sc_id=trim($sc_id);			
				$school_name=$allDataInSheet[$i]["C"];   // for teacher ID
				$school_name=trim($school_name);
				$school_name=str_replace(","," ",$school_name);
				$school_name=str_replace("'","",$school_name);
									
				$admin_name=$allDataInSheet[$i]["D"];   // for teacher ID
				$admin_name=trim($admin_name);
				
				$stream=$allDataInSheet[$i]["E"];   // for teacher ID
				$stream=trim($stream);
				
				$address=$allDataInSheet[$i]["F"];   // for teacher ID
				$address=trim($address);
				$address=str_replace(","," ",$address);
				
				
				$email=$allDataInSheet[$i]["G"];   // for teacher ID
				$email=trim($email);
				
				$phone=$allDataInSheet[$i]["H"];   // for teacher ID
				$phone=trim($phone);
				
					
				$count=0;
				 $smartcookiefunctions=new smartcookiefunctions();
				$error="";
				//echo $count;die;
				
				if($dte_code!='')
				{
					
				if($sc_id!='')
				{
					if($school_name!='')
					{
						
						$emailval="/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";
						
								if($email!='' && preg_match($emailval, $email))
								{
									
								
								$sql_query1=mysql_query("select * from tbl_school_admin where school_id='$sc_id'");
								
										if(mysql_num_rows($sql_query1)==0)
										{
											
											$results=$smartcookiefunctions->school_admin_registration($dte_code,$sc_id,$school_name,$admin_name,$stream,$address,$phone,$email,$batch_id);
											$report="School data uploaded successfully";
												
										
										}
										else
										{
											$error="Duplicate";
											
											$results=$smartcookiefunctions->school_admin_error_registration($dte_code,$sc_id,$school_name,$admin_name,$stream,$address,$phone,$email,$batch_id,$error);
											
										}
					
								
								}// Email ID Error
								
										else
										{
											$error="ErrorEmail";
											
											$results=$smartcookiefunctions->school_admin_error_registration($dte_code,$sc_id,$school_name,$admin_name,$stream,$address,$phone,$email,$batch_id,$error);
											
											
										}
										
										
							
					}// School Name  not Null
					
					
					else
					{
					//school Name not null
					$error="ErrorSchool_Name";
											
											$results=$smartcookiefunctions->school_admin_error_registration($dte_code,$sc_id,$school_name,$admin_name,$stream,$address,$phone,$email,$batch_id,$error);
						
					}
				
				
				
				}// School Not null
				
				else
				{
						// school ID not null
						
						$error="ErrorSchool_ID";
											
						$results=$smartcookiefunctions->school_admin_error_registration($dte_code,$sc_id,$school_name,$admin_name,$stream,$address,$phone,$email,$batch_id,$error);
					
				}
				
				}
				else
				{
						// Dte ID not null
						
						$error="ErrorDte_code";
											
						$results=$smartcookiefunctions->school_admin_error_registration($dte_code,$sc_id,$school_name,$admin_name,$stream,$address,$phone,$email,$batch_id,$error);
					
				}
				
							
							
			}// For loop ended
			echo"after for loop";
		var_dump($allDataInSheet);die;
			
		$sql3=mysql_query("select id from tbl_school_admin_raw where batch_id='$batch_id' and (error_code='Duplicate' or error_code='ErrorEmail' or error_code='ErrorSchool_Name' or error_code='ErrorSchool_ID') ");
		$count3=mysql_num_rows($sql3);
		
		$sql4=mysql_query("select id from tbl_school_admin where batch_id='$batch_id'");
		$count4=mysql_num_rows($sql4);
		
	
		$sql5=mysql_query("update tbl_Batch_Master set num_records_uploaded='$DataCount' ,num_errors_records='$count3', num_correct_records='$count4',display_table_name='Bulk college data',db_table_name='tbl_school_admin' where batch_id='$batch_id' and school_id='0' and uploaded_by='Cookie_Admin'");	
		
		$sql6=mysql_query("select id from tbl_Batch_Master where school_id='0' and batch_id='$batch_id' and uploaded_by='Cookie_Admin' order by id desc limit 1");
		$result6=mysql_fetch_array($sql6);
		
					
				
		
		
		header('Location: display_college_records.php?id='.$result6['id'].'');		
	
	}// for file upload
	
	else
	{
		$report="Please select File ";
	}

	


}// Submit
														

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
   		<form name='frm' method='post' enctype='multipart/form-data' id='frm'>
                                
                            <div class="row" style="margin-top:5%;" align="center">          
                            <h3>Upload College list</h3>
                                                      </div>       
          
                          <div class="row" style="margin-top:5%;" align="center">          
                            <input type='file' name='file'  id='file' onChange="ValidateSingleInput(this);" />                          </div>
                            <div class="row" style="margin-top:4%;" align="center">
                    
                
                                  <input class='btn btn-primary' type='submit' value="Submit" name="submit" />
                               
                                  <!--<button class='btn btn-danger'  type='submit'>Cancel</button>-->
								 <!-- <a href="addschool.php"><button class='btn btn-primary'>Back</button></a>-->
                                  
                                  </div>
                                
                                  <div class="row" style="color:red; margin-top:2%;" align="center"> <?php echo $report;?></div>
                 
         </form>
           <div class="row" style="color:red; margin-top:2%;" align="center"> <?php 
		   if(isset($_GET['report']))
		   {
		   echo $_GET['report'];
		   
		   
		    }
		   ?></div>
		 
		 
		 
		 
         
         <div class="row" ><center>
         <a href="Download_college_data.php?id=<?php echo "0".","."D";?>">Download College Data sheet format</a>
         </center></div>
		 
		 
	</div>
	  
	
</div>








</body>

</html>
