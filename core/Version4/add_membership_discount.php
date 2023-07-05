<?php
include '../conn.php';
header('Content-type: application/json');
$json = file_get_contents('php://input');
$obj = json_decode($json);

$SponsorID = xss_clean(mysql_real_escape_string($obj->{'SponsorID'}));
$MemberID = xss_clean(mysql_real_escape_string($obj->{'MemberID'}));
$prn_tid = xss_clean(mysql_real_escape_string($obj->{'prn_tid'}));
$name = xss_clean(mysql_real_escape_string($obj->{'name'}));
$school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
$Entity_name = xss_clean(mysql_real_escape_string($obj->{'Entity_name'}));
$product = xss_clean(mysql_real_escape_string($obj->{'product'}));
$discount = xss_clean(mysql_real_escape_string($obj->{'discount'}));
$date=CURRENT_TIMESTAMP; //defined in core/securityfunctions.php

	if($school_id !='')
	{
		$test = mysql_query("SELECT school_name FROM tbl_school_admin where school_id='$school_id'");
			$number=mysql_num_rows ( $test );
			
			if($number)
			{
					$row = mysql_fetch_assoc($test);
					$school_name = $row['school_name'];		
			}
			else
			{
					$postvalue['responseStatus']=1001;
					$postvalue['responseMessage']="Invalid School ID";
					$postvalue['posts']=null;
					header('Content-type: application/json');
					echo json_encode($postvalue);
					@mysql_close($con);
					exit;
			}
			
	}
//echo $entity_id; exit;
	if($Entity_name =='Teacher')
	{
		$entity_id='103';
	}
	else if($Entity_name =='Student')
	{
		$entity_id='105';
	}
	else if($Entity_name=='School Admin')
	{
		$entity_id='102';
	}
	else if($Entity_name=='Parent')
	{
		$entity_id='106';
	}
	else if($Entity_name=='Spectator')
	{
		$entity_id='119';
	}
	else
	 {
		$postvalue['responseStatus']=1002;
		$postvalue['responseMessage']="Invalid Entity Name";
		$postvalue['posts']=null;
		header('Content-type: application/json');
		echo json_encode($postvalue);
		@mysql_close($con);
		exit;
	  }	

   if(empty($SponsorID) || empty($MemberID) || empty($prn_tid) || empty($name) || empty($school_name) || empty($school_id) || empty($Entity_name) || empty($entity_id) || ($discount==''))
{
		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']="Invalid Input";
		$postvalue['posts']=null;
		header('Content-type: application/json');
		echo json_encode($postvalue);
		@mysql_close($con);
		exit;
}
else
{
	//date inserted by Pranali for SMC-3769
	$test = mysql_query("INSERT INTO `tbl_membership_discount` (SponsorID,MemberID, prn_tid,name,school_name, school_id, Entity_name, Entity_type,product, discount,date) VALUES('$SponsorID','$MemberID','$prn_tid','$name','$school_name','$school_id','$Entity_name','$entity_id','$product','$discount','$date')");
	
	if ($test)
	{
		$postvalue['responseStatus']=200;
		$postvalue['responseMessage']="OK";
		echo json_encode($postvalue);
		@mysql_close($con);
		exit;
	}
	else 
	{
		$postvalue['responseStatus']=204;
		$postvalue['responseMessage']="Record Not Inserted";
		$postvalue['posts']=null;
		header('Content-type: application/json');
		echo json_encode($postvalue);
		@mysql_close($con);
		exit;
	}
}


