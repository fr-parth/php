<?php
include('hr_header.php');
$report="";
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$sc_id=$result['school_id'];
$d_id = $_GET['d_id'];
$result="";
 if(isset($_POST['submit']))
 {
   $d_name =  $_POST['dept_name'];
   $d_code =  $_POST['dept_code'];
   $fax_no =  $_POST['fax_no'];
   $email =  $_POST['email_id'];

   $sql = "UPDATE `tbl_department_master` SET Dept_Name='$d_name', Dept_code='$d_code', Fax_No='$fax_no', Email_Id='$email' WHERE id='$d_id'";
   $r=mysql_query($sql);
   if(mysql_affected_rows()>0)
   {
     echo "<script>alert('Record Updated Successfully..!!');
window.location = 'list_company_department.php';
	 </script>";
   
   //Above file added by Rutuja Jori on 29/05/2019 as after updating records the page was logged out 
   }
   else
   {
     echo "<script>alert('Error while updating record') </script>";
   }
 }

 $sql = mysql_query("select * from tbl_department_master where school_id='$sc_id' and id='$d_id'");
 if(mysql_num_rows($sql)>0)
 {
   $result = mysql_fetch_assoc($sql);
 }

?>

<body bgcolor="#CCCCCC" >

<div style="bgcolor:#CCCCCC">
<div>

</div>
<div class="container" style="padding:25px;" >


            	<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4; background-color:#F8F8F8 ;">



                 	<h2 style="padding-top:30px;"><center>Edit Department</center></h2>

                   <form method="post" >

                <div class="row" style="padding-top:50px;">
<div class="col-md-4"></div>


<div class="col-md-2" style="color:#808080; font-size:18px;">
Department Name</div>

<div class="col-md-3">
<input type="text" class="form-control" name="dept_name" id="dept_name" value="<?php echo $result['Dept_Name']?>">
</div>
</div>

<div class="row"><div class="col-md-4 col-md-offset-5" id="errordept" style="color:#F00;"></div></div>


   <div class="row" style="padding-top:30px;">
<div class="col-md-4"></div>


<div class="col-md-2" style="color:#808080; font-size:18px;">
Department Code</div>

<div class="col-md-3">
<input type="text" class="form-control" name="dept_code" id="dept_code" value="<?php echo $result['Dept_code']?>">
</div>

<div class="col-md-3" style="color:#FF0000;"><?php  echo $report1;?></div>
</div>
<div class="row"><div class="col-md-2 col-md-offset-5" id="errordeptcode" style="color:#F00;"></div></div>

  <!-- <div class="row" style="padding-top:30px;">
<div class="col-md-4"></div>


<div class="col-md-2" style="color:#808080; font-size:18px;">
Establishment Year</div>

<?php  $date=date('Y');?>

<div class="col-md-3">

<select name="year" class="form-control" id='year'>
<option value="">Select Year</option>
<?php


for($i=$date;$i>1900;$i--)
{?>

<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php  }


?>







</select>
</div>
</div>
<div class="row"><div class="col-md-2 col-md-offset-5" id="erroryear" style="color:#F00;"></div></div>


 <div class="row" style="padding-top:30px;">
<div class="col-md-4"></div>


<div class="col-md-2" style="color:#808080; font-size:18px;">
Phone No.</div>

<div class="col-md-3">
<input type="text" class="form-control" name="phone_no" id="phone_no" value="<?php echo $result['PhoneNo']?>">
</div>
</div>-->
<div class="row"><div class="col-md-3 col-md-offset-5" id="errorphone" style="color:#F00;"></div></div>
<div class="row" style="padding-top:30px;">
<div class="col-md-4"></div>


<div class="col-md-2" style="color:#808080; font-size:18px;">
Fax No.</div>

<div class="col-md-3">
<input type="text" class="form-control" name="fax_no" id="fax_no" value="<?php echo $result['Fax_No']?>">
</div>
</div>
<div class="row"><div class="col-md-2 col-md-offset-5" id="errorfax" style="color:#F00;"></div></div>
<div class="row" style="padding-top:30px;">
<div class="col-md-4"></div>


<div class="col-md-2" style="color:#808080; font-size:18px;">
Email Id</div>

<div class="col-md-3">
<input type="text" class="form-control" name="email_id" id="email_id" value="<?php echo $result['Email_Id']?>">
</div>
</div>

<div class="row"><div class="col-md-2 col-md-offset-5" id="erroremail" style="color:#F00;"></div></div>


<div class="row" style="padding-top:60px;">
<div class="col-md-5"></div>

<div class="col-md-1"><input type="submit" name="submit" value="Update"  class="btn btn-success" onClick="return valid()"></div>

 <div><a href="list_company_department.php" style="text-decoration:none;">
                            <input type="button" class="btn btn-primary" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;"/>
                        </a>
						
				   </div>
				   
		<!--Back button added by Rutuja Jori on 29/05/2019-->				   
				   
</div>


                 <div class="row" style="padding-top:30px;" >
                 <center style="color:#006600;"><?php echo $errorreport?></center>
                 <center style="color:#093;"><?php echo $successreport?></center>
                 </div>


                    </form>

               </div>
               </div>
</body>
</html>
