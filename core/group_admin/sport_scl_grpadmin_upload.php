<?php
//include 'sd_upload_function.php';
include("groupadminheader.php");
//print_r($_SESSION['data']);
$uploaded_by = $_SESSION['group_admin_id'];
$group_type = $_SESSION['data'][0]['group_type'];
$group_name = $_SESSION['data'][0]['group_name'];
$group_member_id = $_SESSION['group_admin_id'];

/*function url(){
  return sprintf(
    "%s://%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['SERVER_NAME']
  );
}*/
function mysql_escape_mimic($inp) {
    if(is_array($inp))
        return array_map(__METHOD__, $inp);

    if(!empty($inp) && is_string($inp)) {
        return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a",",","(",")"), array('', '', '', '', '', '', '','','',''), $inp);
    }

    return $inp;
}

if($_SESSION['entity'] !=12){

	echo "You are not authorize to view this page.";
	exit;
}
?>
<div class='container'>



<div class='panel panel-default'>

	<div class='panel-heading' align ='center'>

		<h2>School Upload Panel</h2></div>
<form method="post" action="" enctype="multipart/form-data">
<table align='left'>

<tr><br><td><b>Select upload data type: </td><td><select name="file_type" id= 'file_type'/><option value=''>Select data type</option>
<option value='basic_data'>School's basic data</option>
<option value='all_data'>School's all data</option></td></tr>
<tr><br><td><b>Select file: </td><td><input type="file" name="file" accept=".csv"/></td></tr>
		   
		<tr><td><br><input class="btn btn-success" type="submit" name="submit_file" value="Submit"/></td></tr>
		</table>
 </form>   

 
 <form method='post' enctype='multipart/form-data'>
<table align='right'>
		<div class='row'>
			<select name='data_format' id='data_format'>

				<option value=''>Select format</option>
				<option value='basic_data_format'>School's basic data format</option>
				<option value='all_data_format'>School's all data format</option>
				

			</select>

			<button type='submit' name='dformat' class='btn btn-success btn-xs' >Download Format</button>
		</div>	
</table>
		</form>
	<div class='panel-body'>

	<div class='row'>

	<div class='col-md-8'>

	</div>
	</div>
	</div>
	</div>
	</div>

	<?php
//include('../conn.php');
//header('Content-Type: text/plain; charset=utf-8');

//function random_password( $length = 8 ) {
//    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
//    $password = substr( str_shuffle( $chars ), 0, $length );
//    return $password;
//}

if(isset($_POST["submit_file"]))
 { 

//print_r($_FILES);  exit;
	 $filetype = $_POST["file_type"];
	 //print_r($filetype); exit;
     $filename = basename($_FILES['file']['name']); //exit; 
    $file = $_FILES['file']['tmp_name'];
    
    $handle = fopen($file, "r");
	if($filetype == '')
	 {
		echo "Please select data type to upload";
		exit;
	 }

    if ($file == NULL) {
     echo "Please select a file to import";
      
    }
	else if($filetype == 'basic_data')
	{
		
		$i = 0;
		$j = 0;
		$row = 1;
		$a = 0;

	
		$total_rec = 0;

		$main_table  = "tbl_school_admin";
		$raw_table	 = "tbl_school_admin_raw";
      while(($filesop = fgetcsv($handle, 0, ",")) !== false)
        {
        	//print_r($filesop[0]);exit;
        	$dynamic="";
			
		  if($row == 1){$row++;continue;}else {$total_rec++;}
		  
		  $ok = 1;
		 //if($ok) { $ok = false; continue; }
		 
			$school_type = $filesop[0];
			//school type is empty then by default school add by yogesh SMC-4869
			if($school_type=='')
					{
						$school_type='school';
					}
			$school_id	= $filesop[1];
			$school_name = $filesop[2];
			$DTECode = $filesop[3];
			$school_email = $filesop[4];
			$address =	$filesop[5];
			$scadmin_city = $filesop[6];
			$scadmin_country = $filesop[7];
			$scadminState=$filesop[11];
//School Pattern added by Sayali Balkawade for SMC-4239 
			//$scadmin_pattern = $filesop[12];
//AICTE ID added by Sayali Balkawade for SMC-4705 on 5/9/2020
			$aicteId=$filesop[12];
			$aicte_aid=$filesop[13];


			$CountryCode = (!empty($filesop[8])?$filesop[8] : 91);
			//print_r($filesop);exit;
			$mobile	= $filesop[9];
            $sc_admin_name = (!empty($filesop[10])?$filesop[10] : $filesop[4]);
          
            $name = explode(" ", $sc_admin_name);
         
          
                $password = $school_id; 
                            
 
			//$password = random_password(8);
			
			if($school_id == "" || $school_name == "")
			{
				//print_r($ok);exit;
				$ok = 0;
				$msg = "Either School ID  or School Name is missing";
				$password = "";
			}
			

			/*Below conditions on aicte application ID, aicte permanent id & school_id added by Rutuja for SMC-5026 on 10-12-2020*/
			/*if($school_id == "" &&  $aicteId == "" && $aicte_aid == "" )
			{
				$ok = 0;
				$msg = "Either school id or AICTE permanent ID or AICTE application ID should be filled out";
				$password = "";
			}*/
			if($aicteId!='')
			{
				$dynamic = " aicte_permanent_id = '$aicteId' ";
				$dynamic.= " OR";
			}
			if($aicte_aid!='')
			{
				$dynamic.=" aicte_application_id = '$aicte_aid' ";
				$dynamic.= " OR";
			}
			if($school_id!='')
			{
				$dynamic.= " school_id = '$school_id' ";	
			}
			// check for school id
			//print_r($dynamic);exit;
			$myquery = "select * from $main_table where ($dynamic) ";
			//$myquery = "select * from $main_table where ($dynamic) and group_member_id='$group_member_id' ";
			
			$myres = mysql_query($myquery);
			$count = mysql_num_rows($myres);
		
			if($count > 0)
			{
				$ok = 2;
				/*Below variables fetched from the database as if the details entered for the fields other than those that are mandatory are blank, then the data present in the database for those fields should be maintained-Rutuja for SMC-4740 on 19/06/2020*/
				$rowschool=mysql_fetch_array($myres);

				//print_r($rowschool );exit;
					$school_type_row=$rowschool['school_type'];
					if($school_type!='' || $school_type!=NULL)
					{
					 $school_type=$school_type;
					}else{
					 $school_type=$school_type_row;
					}
					$school_name_row=$rowschool['school_name'];
					if($school_name!='' || $school_name!=NULL )
					{
					 $school_name=$school_name;
					}else{
					 $school_name=$school_name_row;
					 //print_r($school_name);exit;
					}
					$DTECode_row=$rowschool['DTECode'];
					if($DTECode!='' || $DTECode!=NULL)
					{
					 $DTECode=$DTECode;
					}else{
					 $DTECode=$DTECode_row;
					}
					$school_email_row=$rowschool['email'];
					if($school_email!='' || $school_email!=NULL)
					{
					 $school_email=$school_email;
					}else{
					 $school_email=$school_email_row;
					}
					$address_row=$rowschool['address'];
					if($address!='' || $address!=NULL)
					{
					 $address=$address;
					}else{
					 $address=$address_row;
					}
					$scadmin_city_row=$rowschool['scadmin_city'];
					if($scadmin_city!='' || $scadmin_city!=NULL)
					{
					 $scadmin_city=$scadmin_city;
					}else{
					 $scadmin_city=$scadmin_city_row;
					}
					$scadmin_country_row=$rowschool['scadmin_country'];
					if($scadmin_country!='' || $scadmin_country!=NULL)
					{
					 $scadmin_country=$scadmin_country;
					}else{
					 $scadmin_country=$scadmin_country_row;
					}
					$CountryCode_row=$rowschool['CountryCode'];
					if($CountryCode!='' || $CountryCode!=NULL)
					{
					 $CountryCode=$CountryCode;
					}else{
					 $CountryCode=$CountryCode_row;
					}
					$mobile_row=$rowschool['mobile'];
					if($mobile!='' || $mobile!=NULL)
					{
					 $mobile=$mobile;
					}else{
					 $mobile=$mobile_row;
					}
					$scadminState_row=$rowschool['scadmin_state'];
					if($scadminState!='' || $scadminState!=NULL)
					{
					 $scadminState=$scadminState;
					}else{
					 $scadminState=$scadminState_row;
					}
							
					$sc_admin_name_row=$rowschool['name'];
					if(($sc_admin_name!='' || $sc_admin_name!=NULL)  && strpos($sc_admin_name_row, '@')!=false)
					{
					 $sc_admin_name=$sc_admin_name;
					 
					 //$adname = explode(" ", $sc_admin_name);
          
     //        		if($adname[1] == '')
     //        		{
     //            	$password = $adname[0]."123"; 
                
     //       			 }else{
                
     //            	$password = end($adname)."123";
					// }
					}else{
					 $sc_admin_name=$sc_admin_name_row;
					 //$password=$rowschool['password'];
					}
					// Change password to school_id for not activated school (is_accept_terms!=1)
				 	if($rowschool['is_accept_terms'] !=1)
					 {
					 	$password = $school_id;
					 }
					 else{
					 	$password = $rowschool['password'];
					 }

					$aicteId_row=$rowschool['aicte_permanent_id'];
					if($aicteId!='' || $aicteId!=NULL)
					{
					 $aicteId=$aicteId;
					}else{
					 $aicteId=$aicteId_row;
					}
					$aicte_aid_row=$rowschool['aicte_application_id'];
					if($aicte_aid!='' || $aicte_aid!=NULL)
					{
					 $aicte_aid=$aicte_aid;
					}else{
					 $aicte_aid=$aicte_aid_row;
					}

//end SMC-4740



				// $mysqlquery = "update $main_table set school_type='$school_type',school_name=\"$school_name\",DTECode='$DTECode',email='$school_email',address='$address',scadmin_city='$scadmin_city',scadmin_country='$scadmin_country',CountryCode='$CountryCode',mobile='$mobile',scadmin_state='$scadminState',name='$sc_admin_name',school_pattern='$scadmin_pattern',reg_date=NOW(),password='$password',uploaded_by = '$uploaded_by',group_type='$group_type',group_name='$group_name' where school_id = '$school_id' and group_member_id='$group_member_id';"; 
				
//Updated below query for solving the issue of records not getting updated. And also added AICTE Application ID in the query- Rutuja for SMC 4740 on 18/06/2020

					//print_r($school_name);exit;
					//$school_name1=mysql_escape_mimic($school_name);
			   		//$sc_admin_name1=mysql_escape_mimic($sc_admin_name);
			   		$now=date('Y-m-d h:i:sa'); 
					//print_r($school_name);exit;

			   	 if(strpos($school_name, '&') !== false)
			   	 {
			   	 	$j++;
				    $now=date('Y-m-d h:i:sa'); 
				    $msg="& sign is not allowed";
					 $sql = "INSERT INTO $raw_table	(school_type, school_id, school_name,DTECode,email,address,scadmin_city,scadmin_country,CountryCode,mobile,name,reg_date,password,error_msg,uploaded_by,group_member_id,aicte_permanent_id,aicte_application_id) values ('$school_type','$school_id','".$school_name."','$DTECode','$school_email','$address','$scadmin_city','$scadmin_country','$CountryCode','$mobile','".$sc_admin_name."','$now','$password','$msg','$uploaded_by','$group_member_id','$aicteId','$aicte_aid')"; 

					$res = mysql_query($sql);

				 } 
				 else
				 {
				 	//print_r($school_name);exit;
				 	$mysqlquery = "update $main_table set school_type='$school_type',school_name='".$school_name."',DTECode='$DTECode',email=\"$school_email\",address='$address',scadmin_city='$scadmin_city',scadmin_country='$scadmin_country',CountryCode='$CountryCode',mobile='$mobile',scadmin_state='$scadminState',name='".$sc_admin_name."',reg_date='$now',password='$password',uploaded_by = '$uploaded_by',group_type='$group_type',group_name='$group_name' ,aicte_permanent_id='$aicteId',aicte_application_id='$aicte_aid' where school_id = '$school_id';"; 

				 		//echo $mysqlquery; 
				 	$myquery1 = "select * from tbl_group_school where ($dynamic) ";
				 	//echo $myquery1;
					$myres1 = mysql_query($myquery1);
					$count1 = mysql_num_rows($myres1); 
		
					if($count1 === 0)	{		
						$insert="INSERT INTO `tbl_group_school`(group_member_id,group_mnemonic_name, school_id,createdby, isenabled) VALUES ('$group_member_id','$group_name','$school_id', '".$sc_admin_name."', 1)"; 
						$res1 = mysql_query($insert) ;
						
					}
					else{
						$update="update `tbl_group_school` set group_member_id='$group_member_id', group_mnemonic_name= '$group_name', school_id = '$school_id', modifiedby='".$sc_admin_name."', isenabled=1 where school_id = '$school_id' and group_member_id='$group_member_id';";
						$res1 = mysql_query($update) ;
					}

                 
					$mysqlres = mysql_query($mysqlquery);
				
					if($mysqlres)
					{
						 $a++;
					}
					else
					{
						  $j++;
						  //echo "1 ".$school_id." - ".$total_rec."<br>";
						    
						//$ok = 0;
						$msg = "DB Error - ".mysql_error();
						//$school_name1=mysql_escape_mimic($school_name);
				   		//$sc_admin_name1=mysql_escape_mimic($sc_admin_name);
				   		$now=date('Y-m-d h:i:sa'); 
				   		
						 $sql = "INSERT INTO $raw_table	(school_type, school_id, school_name,DTECode,email,address,scadmin_city,scadmin_country,CountryCode,mobile,name,reg_date,password,error_msg,uploaded_by,group_member_id,aicte_permanent_id,aicte_application_id) values ('$school_type','$school_id','".$school_name."','$DTECode','$school_email','$address','$scadmin_city','$scadmin_country','$CountryCode','$mobile','".$sc_admin_name."','$now','$password',\"$msg\",'$uploaded_by','$group_member_id','$aicteId','$aicte_aid')"; 



					$res = mysql_query($sql);
				     
					}

				}
			}


			if($ok == 1)
			{
				// $sql = "INSERT INTO $main_table(school_type,school_id,school_name,DTECode,email,address,scadmin_city,scadmin_country,CountryCode,mobile,scadmin_state,name,reg_date,password,uploaded_by,group_type,group_name,group_member_id,school_pattern) values ('$school_type','$school_id',\"$school_name\",'$DTECode','$school_email','$address','$scadmin_city','$scadmin_country','$CountryCode','$mobile','$scadminState','$sc_admin_name',NOW(),'$password','$uploaded_by','$group_type','$group_name','$group_member_id','$scadmin_pattern') ;"; 


			   //$school_name1=mysql_escape_mimic($school_name);
			  // $sc_admin_name1=mysql_escape_mimic($sc_admin_name);

				if(strpos($school_name, '&') !== false)
			   	{
			   	 	$j++;
				    $now=date('Y-m-d h:i:sa'); 
				    $msg="& sign is not allowed";
					 $sql = "INSERT INTO $raw_table	(school_type, school_id, school_name,DTECode,email,address,scadmin_city,scadmin_country,CountryCode,mobile,name,reg_date,password,error_msg,uploaded_by,group_member_id,aicte_permanent_id,aicte_application_id) values ('$school_type','$school_id','".$school_name."','$DTECode','$school_email','$address','$scadmin_city','$scadmin_country','$CountryCode','$mobile','".$sc_admin_name."','$now','$password','$msg','$uploaded_by','$group_member_id','$aicteId','$aicte_aid')"; 

					$res = mysql_query($sql);

				} 
				else
				{

			   		$now=date('Y-m-d h:i:sa'); 
               		$sql = "INSERT INTO $main_table(school_type,school_id,school_name,DTECode,email,address,scadmin_city,scadmin_country,CountryCode,mobile,scadmin_state,name,reg_date,password,uploaded_by,group_type,group_name,group_member_id,aicte_permanent_id,aicte_application_id) values ('$school_type','$school_id','".$school_name."','$DTECode','$school_email','$address','$scadmin_city','$scadmin_country','$CountryCode','$mobile','$scadminState','".$sc_admin_name."','$now','$password','$uploaded_by','$group_type','$group_name','$group_member_id','$aicteId','$aicte_aid') "; 

               		 $insert="INSERT INTO `tbl_group_school`(group_member_id,group_mnemonic_name, school_id,createdby, isenabled) VALUES ('$group_member_id','$group_name','$school_id', '".$sc_admin_name."', 1)"; 

                 	$res = mysql_query($sql);
                 	$res1 = mysql_query($insert) ;

					if($res)
					{
						//$mysql = "delete from $raw_table where school_id = '$school_id' and school_name = \"$school_name\" LIMIT 1";
						//$myre s= mysql_query($mysql);
					   $i++;
					}
					else
					{
					 	$j++;

					  	$now=date('Y-m-d h:i:sa'); 
						$ok = 0;
						
						$msg = "DB Error - ".mysql_error();
						//echo $msg

					  	$sql1 = "INSERT INTO $raw_table	(school_type, school_id, school_name,DTECode,email,address,scadmin_city,scadmin_country,CountryCode,mobile,name,reg_date,password,error_msg,uploaded_by,group_member_id,aicte_permanent_id,aicte_application_id) values ('$school_type','$school_id', '".$school_name."','$DTECode','$school_email','$address','$scadmin_city','$scadmin_country','$CountryCode','$mobile','".$sc_admin_name."','$now','$password',\"$msg\",'$uploaded_by','$group_member_id','$aicteId','$aicte_aid')"; 

						$res1 = mysql_query($sql1);
				
							if($res1)
							{
								//echo "3 ".$school_id." - ".$total_rec."<br>";
								// echo $msg."<br>";
			    
							}else
							{
								//echo $sql1."<br>";
								 $msg = "DB Error - ".mysql_error();
				  				//echo "3 ".$school_id." - ".$total_rec."<br>";
				  				//echo $msg."<br>";
				 
							}
					}
				}
								
			}
			else if($ok == '0')
			{
				//print_r($ok);exit;
				$now=date('Y-m-d H:i:s');
           		$sql = "INSERT INTO $raw_table	(school_type, school_id, school_name,DTECode,email,address,scadmin_city,scadmin_country,CountryCode,mobile,name,reg_date,password,error_msg,uploaded_by,group_member_id,aicte_permanent_id,aicte_application_id) values ('$school_type','$school_id','".$school_name."','$DTECode','$school_email','$address','$scadmin_city','$scadmin_country','$CountryCode','$mobile','".$sc_admin_name."','$now','$password',\"$msg\",'$uploaded_by','$group_member_id','$aicteId','$aicte_aid')"; 


                $res = mysql_query($sql);

				if($res)
				{
					 $j++;
				  //echo "5 ".$school_id." - ".$total_rec."<br>";
			     
				}else{
				 
			   
				}
				
			}
			
		}
		
		echo "<div align='center'><font color='green'><b>Total inserted records: ".$i."</b></font></div>";
		echo "<div align='center'><font color='green'><b>Total updated records: ".$a."</b></font></div>";
		echo "<div align='center'><br><br><font color='red'><b>Total rejected records: ".$j."</b></font></div>";
		echo "<div align='center'><br><br><font color='green'><b>Total  records: ".$total_rec."</b></font></div>";
		?>
<?php if($j> 0){?>
		<table border='1px' align='center'>

		<tr>
		<th>Sr No.</th>
		<th>Error Message</th>
		<th>School Id</th>
		<th>School Name</th>
		<th>School Email</th>
		<th>Registration Date</th>
		</tr>
		<?php 
		$now=date("Y-m-d H:i:s");
		
		$myquery1 = "select error_msg,school_id,school_name,email,reg_date from $raw_table where group_member_id = '$group_member_id' order by id DESC LIMIT $j";
		$myres1 = mysql_query($myquery1);

		$k = 1;
		while($row = mysql_fetch_array($myres1))
		{
			
		?>
		<tr>
		<td align='center'><?php echo $k++ ?></td>
		<td><?php echo $row['error_msg'] ;?></td>
		<td><?php echo $row['school_id'] ?></td>
		<td><?php echo $row['school_name'] ?></td>
		<td><?php echo $row['email'] ?></td>
		<td><?php echo date('Y-M-d H:i:s',strtotime($row['reg_date'])); ?></td>
		</tr>

		<?php }?>
		</table>
<?php } ?>

	<?php

		
	}
	else if($filetype == 'all_data')
	{
		$table = 'sport_school_all_details';
		$m =0;
		$row = 0;
		while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
        {
			if($row == 0){$row++;continue;}
			$school_id = $filesop[10];
			$school_name = $filesop[11];
			$now=date('Y-m-d H:i:s');
			if($school_id != "" && $school_name != "")
			{
				$fields = array();
				for($i=0;$i<count($filesop); $i++) {
					$fields[] = '\''.addslashes($filesop[$i]).'\'';
				}
			   $sql = "Insert into $table values(''," . implode(', ', $fields) . ",'$uploaded_by','$now','$group_member_id')"; //exit;
			   $res = mysql_query($sql);
			   
			   if($res)
				{
				   $m++;
				}
				else
				{
					$ok = 0;
					$msg = "DB Error - ".mysql_error();
				}
			}
			
		}
		echo "<div align='center'><font color='green'><b>Total uploaded records: ".$m."</b></font></div>";
	}
    
}

if(isset($_POST['dformat']))
{

	$data_format=$_POST['data_format'];	
	$path = url()."/core/Importdata/";

	if($data_format =='basic_data_format')
	{
		$filename="school_basic_data_format.csv";
		$filepath = $path.$filename;

		echo "<script>window.open('$filepath');</script>";

	}
	if($data_format =='all_data_format')
	{
		$filename="school_all_data_format.csv";
		$filepath = $path.$filename;

		echo "<script>window.open('$filepath');</script>";

	}	

}

?>