<?php
error_reporting(0);
//include('conn.php');
include_once("cookieadminheader.php");
$report="";
$subject_id=$_GET['id'];


/*$id=$_SESSION['id'];
$query="select * from `tbl_school_admin` where id='$id'";       // getting the the school id of login user by checking the session
$row1=mysql_query($query);
$value1=mysql_fetch_array($row1);
 $school_id=$value1['school_id'];*/
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);


 
 if(isset($_POST['submit']))
	 {   
//echo "hii";
		$id=$_POST['dropcoll']; 
		$countryCode=$_POST['countryCode']; 
//$school_name = $_POST['school_name']; 
		
		
		$select=mysql_query("select school_name,school_id from tbl_school_admin where id='$id'"); 
		$fetch=mysql_fetch_array($select);
	    $data_pwd=$fetch['school_id'];
		
      
						
		
					
							$insert=mysql_query("update tbl_teacher  set CountryCode ='$countryCode' where school_id = '$data_pwd'"); 
							
							$insert=mysql_query("update tbl_student  set country_code ='$countryCode' where school_id = '$data_pwd'");
							
							if($insert)	
							{
			$successreport="Country Code Is Successfully Updated";
							}
							else
							{
				$successreport1="Country Code Not Updated";
							}

	 } 
	
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
    <link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="../js/jquery-1.11.1.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>

    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<script type="text/javascript" src="../js/jquery.form.js"></script>
	 <script type="text/javascript"> </script>
 <form action="" method="POST" >
<div class="row">
    <div class="col-md-2 "></div>
  <div class="col-md-8 center centered">
<div class="panel panel-danger " style="margin-top:60px;">
  <div class="panel-heading text-center">
    <h3 class="panel-title"><font color="#580000"><b>Update Country Code For Student And Teacher <?php echo $dynamic_student;?></b></font></h3>
  </div>
  <div class="panel-body" style="margin-top:10px;">
 <div class="center-block">
 <div class="row" align='right'>

 <div class="col-md-3" ><select name="dropcoll" class="dropdownMenu1" id="dropcoll" style="width:85%; height:30px;text-align:center; border-radius:2px;margin-left:360px;margin-top:20px;margin-bottom:20px;" onChange="onSchoolChange()">
   <?php $sql1=mysql_query("Select id,school_name,school_id from tbl_school_admin  where `school_name`!='' group by school_name order by `id` desc");?>
    <option value="<?php echo $school_id; ?>" disabled selected>School/College Name</option>
	
	<?php while($row=mysql_fetch_array($sql1)){ ?>
	
	<option value="<?php echo $row['id']; ?>" <?php if($row['id']==$school_name){ echo "selected";}else{}?>><?php echo $row['school_id'] ." - " .$row['school_name'];?></option>
	
	
	
    <?php }?>
  </select>
</div>
</div>



<div class="row" align='right'>

 <div class="col-md-3" ><select name="countryCode" class="dropdownMenu1" id="countryCode" style="width:85%; height:30px;text-align:center; border-radius:2px;margin-left:360px;margin-top:20px;margin-bottom:20px;" onChange="onSchoolChange()">
   <?php $sql1=mysql_query("Select calling_code,country from tbl_country where calling_code!='' order by country desc");?>
   
	<?php while($row=mysql_fetch_array($sql1)){ ?>
	
	<option value="<?php echo $row['calling_code'];?>"><?php echo $row['country']." - " .$row['calling_code'];?></option>
	
	
    <?php }?>
  </select>
</div>
</div>

</div>
</div>
<div>
<div class="row">
<div class="row" align="center">
					  <div class="col-md-4" ></div>
					  <div  class="col-md-4" >
						 <input type="submit" name="submit" value="Submit" class="btn btn-success"/>
					  </div>
					   <div class="col-md-3" ></div>
					   
				</div>
					</div>
				<div class="row" style="padding:30px;padding-left:300px;">
                                    <div class="col-md-7" style="color:#F00;" align="center" id="error">
                                        <b><?php echo $successreport1; ?></b>
                                    </div>
                                </div>
					<div class="row" style="padding:30px;padding-left:280px;">
                                    <div class="col-md-7" style="color:#008000;" align="center" id="error">
                                        <b><?php echo $successreport; ?></b>
                                    </div>
                                </div>	

							
				</form>
</div>
</div>
</div>
</div>
</div>
</html>


