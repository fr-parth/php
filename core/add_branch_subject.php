<?php

$report="";

include('scadmin_header.php');

$id=$_SESSION['id'];

           $fields=array("id"=>$id);

		   $table="tbl_school_admin";

		   

		   $smartcookie=new smartcookie();

		   

$results=$smartcookie->retrive_individual($table,$fields);

$result=mysql_fetch_array($results);

$sc_id=$result['school_id'];

if(isset($_POST['submit']))

{
	echo "sgbrfuygrf";
$subject_code = $_POST['0'];
$subject_name = $_POST['subject_name'];
$branch_name = $_POST['2'];
$division = $_POST['3'];
$year = $_POST['4'];
$course_level = $_POST['5'];


$sql1 = mysql_query("select * from tbl_school_subject where subject=$subject_name");
$count1 = mysql_num_rows($sql1);

$sql2 = mysql_query("select * from tbl_school_subject where Subject_Code=$subject_code");
$count2 = mysql_num_rows($sql2);

if($count1==0 and $count2==0)
{
	//echo "insert into tbl_school_subject (Subject_Code,subject,Branch_ID,Year_ID,Course_Level_PID,school_id)values('$subject_code','$subject_name','$branch_name','$year','$course_level','$sc_id')";
	
	$sql1 = mysql_query("insert into tbl_school_subject (Subject_Code,subject,Branch_ID,Year_ID,Course_Level_PID,school_id)values('$subject_code','$subject_name','$branch_name','$year','$course_level','$sc_id')");
	
}
else
{
	
	echo "<script>alert('SUbject already exists')</script>";
}









}


?>

<html>

<head>



</head>

<body bgcolor="#CCCCCC">

<div style="bgcolor:#CCCCCC">

<div class="container" style="padding:25px;"" >

        	

	<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;
			box-shadow: 0px 1px 3px 1px #C3C3C4;background-color:#F8F8F8;">

    <form method="post">

                    

                    

                    <div class="row">

                    <div class="col-md-3 col-md-offset-1"  style="color:#700000 ;padding:5px;" ></div>

						<div class="col-md-3 " align="center" style="color:#663399;" >

                         	<h2>Add Branch Subject</h2>

							<h5 align="center"><a href="Add_SubjectSheet_updated_20160109PT.php" >Add Excel Sheet</a></h5>

						</div>

                         

                    </div>

                  

				<div class="row formgroup" style="padding:5px;" >

               

					<div class="col-md-3 col-md-offset-4">

						<input type="text" name="0" class="form-control " id="0" placeholder="Subject Code" required>

					</div><span style="color:red;font-size: 25px;">*</span>

					<br/><br/>

				    <div class="col-md-3 col-md-offset-4">

                        <input type="text" name="subject_name" class="form-control " id="1" placeholder="Subject Name" required>

					</div><span style="color:red;font-size: 25px;">*</span>

				    <br/><br/>
					
					<div class="col-md-3 col-md-offset-4">

                        <input type="text" name="2" class="form-control " id="2" placeholder="Branch Name" required>

					</div><span style="color:red;font-size: 25px;">*</span>

				    <br/><br/>

					<div class="col-md-3 col-md-offset-4">

                        <input type="text" name="3" class="form-control " id="3" placeholder="Division" required>

					</div><span style="color:red;font-size: 25px;">*</span>

				      <br/><br/>

					<div class="col-md-3 col-md-offset-4">

                        <input type="text" name="4" class="form-control " id="4" placeholder="Year" required>

					</div><span style="color:red;font-size: 25px;">*</span>
					
					<br/><br/>
				   
					<div class="col-md-3 col-md-offset-4">

                        <input type="text" name="5" class="form-control " id="5" placeholder="Course Level" required/>

					</div><span style="color:red;font-size: 25px;">*</span>
					
					<br/><br/>

                    <div class="col-md-4" id="E-0" style="color:#FF0000;"></div>

              

				</div>
                  
				  
					<div id="error" style="color:#F00;text-align: center;" align="center"></div>

					<div id="add"></div>

					<div class="row" style="padding-top:15px;">

						<div class="col-md-2 col-md-offset-4 " >

						<input type="submit" class="btn btn-primary" name="submit" value="Add " 
						style="width:80px;font-weight:bold;font-size:14px;"/>

						</div>

                    

						<div class="col-md-3 "  align="left">

						<a href="branch_subject_master.php" style="text-decoration:none;"> <input type="button" class="btn btn-primary" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;" /></a>

						</div>

					</div>

                 

					<div class="row" style="padding-top:15px;">

						<div class="col-md-4">

						<input type="hidden" name="count" id="count" value="1"/>

						</div>

						<div class="col-md-11" style="color:#FF0000;" align="center" id="error">

                      

						<?php echo $errorreport;?>

               			</div>
							
						<div class="col-md-11" style="color:#063;" align="center" id="error">

                      

						<?php echo $successreport;?>

               			</div>

                 

                    </div>

                      

	</form>

                  
	</div>
	</div>

</body>

</html>