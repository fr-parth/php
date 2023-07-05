<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Quick Registration</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
 <style type="text/css">



        body{
            margin: 0px auto;
            max-width: 50%;
        }
        #title{
          text-align: center;
          color: #C0C0C0;
          font-size: x-large;
        }
		
		input[type="submit"]
        {
			text-align: center;
            margin-left: 40%;
           background-color: #FFFFFF;
           width:100px;
           height:30px;
           border-radius: 5px;
           font-size: 17px;
           box-shadow:0px 0px 2px 3px #FFCC33;
           background: linear-gradient(#FFF,#CCC);
        }
       

 </style>
</head>

<body>

<?php


$smart_cookee1="";
$smart_cookee2="";
$ethikal_hr1="";
$ethikal_hr2="";
$startup_world1="";
$startup_world2="";
$report="";
$report1="";


if(isset($_POST['submit']))
{
	
	$source = "Web";
	$firstname=$_POST['firstname'];
	$middlename=$_POST['middlename'];
	$lastname=$_POST['lastname'];
	$phonenumber=$_POST['phonenumber'];
	$emailid=$_POST['emailid'];
	$countrycode=$_POST['countrycode'];
	$usertype=$_POST['usertype'];
	$orgname=$_POST['orgname'];
	$project[]=$_POST['project'];


	for($i=0;$i<count($project);$i++)
	{
		for($j=0;$j<count($project[$i]);$j++)
		{
			if($project[$i][$j]=='smartcookie')
				{
					$result="http://tsmartcookies.bpsi.us/core/Version2/quickregistration_for_all_domain_API.php?Key=1&firstname=$firstname&middlename=$middlename&lastname=$lastname&phonenumber=$phonenumber&emailid=$emailid&countrycode=$countrycod&usertype=$usertype&org_name=$orgname&source=$source";


					$json= file_get_contents($result);

						$data = json_decode($json, TRUE);
						//echo "<pre>";
								//print_r($data);
							$r=$data["responseStatus"];
								//$data["responseMessage"];
								//echo $data["posts"][0]->id;



					if($r=="200")
					{    $r3=$data["responseMessage"];
						$coll=	$data["posts"];
								     $value= $coll[0];
									  /*echo "SMART COOKIE LOGIN INFO"."<br>";
									  echo "---------------------------------------------------------"."<br>";
									  echo "smartcookie Member ID of ".$usertype."=".$value["id"]."<br>";
									  echo "smartcookie Password of ".$usertype."=". $value["password"]."<br>";
									  echo "***************************************************"."<br>";*/
                                      $smart_cookee1=$value["id"];
                                     // $smart_cookee2=$value["password"];
                                      $smart_cookee3=$value["email"];


					}
                    else{
                              $r3=$data["responseMessage"];
                              $coll=	$data["posts"];
								     $value= $coll[0];

                                      $smart_cookee1=$value["id"];
                                      $smart_cookee2=$value["password"];
                                      $smart_cookee3=$value["email"];

                      }

				}
			if($project[$i][$j]=='ethicalhr')
				{
				$result=  "http://ethicalhr.org/webservices/quickregistration_for_all_domain_API.php?Key=2&firstname=$firstname&middlename=$middlename&lastname=$lastname&phonenumber=$phonenumber&emailid=$emailid&countrycode=$countrycod&usertype=$usertype&org_name=$orgname&source=$source";

					$json= file_get_contents($result);

						$data = json_decode($json, TRUE);
						//echo "<pre>";
								//print_r($data);
							$r=$data["responseStatus"];
								//$data["responseMessage"];
								//echo $data["posts"][0]->id;



					if($r=="200")
					{     $r2=$data["responseMessage"];
						$coll=	$data["posts"];
								     $value= $coll[0];
									 /*echo "ETHICAL HR LOGIN INFO"."<br>";
									 echo "---------------------------------------------------------"."<br>";
									 echo "ethicalhr Member ID of ".$usertype."=".$value["id"]."<br>";
									  echo "ethicalhr Password of ".$usertype."=". $value["password"]."<br>";
									   echo "Ethical Hr ID of ".$usertype."=". $value["ethical_reg_id"]."<br>";
									   echo "***************************************************"."<br>";*/
                                      $ethikal_hr1=$value["id"];
                                     // $ethikal_hr2=$value["password"];
                                      $ethikal_hr3=$value["ethical_reg_id"];
                                      $ethikal_hr4=$value["email"];


					}
                    else{   $r2=$data["responseMessage"];
                          $coll=	$data["posts"];
								     $value= $coll[0];

                                      $ethikal_hr1=$value["id"];
                                      $ethikal_hr2=$value["password"];
                                      $ethikal_hr3=$value["ethical_reg_id"];
                                      $ethikal_hr4=$value["email"];

                      }
				}
				if($project[$i][$j]=='startupworld')
				{
					$result=  "http://bpsi.us/startupworldus/quickregistration_for_all_domain_API.php?Key=5&firstname=$firstname&middlename=$middlename&lastname=$lastname&phonenumber=$phonenumber&emailid=$emailid&countrycode=$countrycod&usertype=$usertype&org_name=$orgname&source=$source";

				$json= file_get_contents($result);

						$data = json_decode($json, TRUE);
						//echo "<pre>";
								//print_r($data);
							$r=$data["responseStatus"];
								//$data["responseMessage"];
								//echo $data["posts"][0]->id;




					if($r=="200")
					{
					    $r1=$data["responseMessage"];
						$coll=	$data["posts"];
								     $value= $coll[0];
									  /*echo "STARTUP WORLD LOGIN INFO"."<br>";
									   echo "---------------------------------------------------------"."<br>";
									  echo "startupworld Member ID of ".$usertype."=".$value["id"]."<br>";
									  echo "startupworld Password of ".$usertype."=". $value["password"]."<br>";
									   echo "***************************************************"."<br>";*/
                                     $startup_world1=$value["id"];
                                    // $startup_world2=$value["password"];
                                     $startup_world3=$value["email"];

									  
						
					}
                    else{
                                $r1=$data["responseMessage"];

                                 $coll=	$data["posts"];
								     $value= $coll[0];

                                     $startup_world1=$value["id"];
                                     $startup_world2=$value["password"];
                                     $startup_world3=$value["email"];
                      }
				}
				if($project[$i][$j]=='jobsitare')
				{
					$report="Work in progress";
					$site1="Job Sitara";
				}
				if($project[$i][$j]=='startterbarter')
				{
					$report1="Work in progress";
					$site2="Starter Barter";
				}
				if($project[$i][$j]=='international')
				{
					$report2="Work in progress";
					$site3="Join International Team";
				}
					
		}
		
	}
	
	
}




?>
<div class="panel panel-default">
  <div class="panel-heading" style="text-align: center;color: #333CFF;font-size: x-large" >Simultaneously Registration Page</div>
  <div class="panel-body">
<form method="post">

	

<!--<lable for name><span class="label label-default">First Name:</span></lable>  -->
<input type="text" class="form-control" aria-describedby="sizing-addon1" placeholder="Enter First Name" name="firstname" id="firstname" value="<?php echo isset($_POST['firstname']) ? $_POST['firstname'] : '' ?>" required></br>

<!--<lable for name>Middle Name:</lable> -->
<input type="text" class="form-control" aria-describedby="sizing-addon1" placeholder="Enter Middle Name" name="middlename" id="middlename" value="<?php echo isset($_POST['middlename']) ? $_POST['middlename'] : '' ?>" required></br>

<!--<lable for name>Last Name:</lable> -->
<input type="text" class="form-control" aria-describedby="sizing-addon1" placeholder="Enter Last Name" name="lastname" id="lastname" value="<?php echo isset($_POST['lastname']) ? $_POST['lastname'] : '' ?>" required></br>

<!--<lable for name>Phone Number:</lable> -->
<input type="text" class="form-control" aria-describedby="sizing-addon1" placeholder="Enter Phone Number" name="phonenumber" id="phonenumber" value="<?php echo isset($_POST['phonenumber']) ? $_POST['phonenumber'] : '' ?>" required></br>

<!--<lable for name>Email Id:</lable>-->
<input type="text" class="form-control" aria-describedby="sizing-addon1" placeholder="Enter Email-ID" name="emailid" id="emailid" value="<?php echo isset($_POST['emailid']) ? $_POST['emailid'] : '' ?>" required></br>

<!--<lable for name>Country Code:</lable>-->
<select class="form-control" aria-describedby="sizing-addon1" name="countrycode" id="countrycode" required>
<option value="">Country Code</option>
<option value="91" <?php if(isset($_POST['countrycode']) && $_POST['countrycode']=='91'){ ?> selected  <?php } ?>>91</option>
<option value="1" <?php if(isset($_POST['countrycode']) && $_POST['countrycode']=='1'){ ?> selected  <?php } ?>>1</option>

</select></br>


<!--<lable for name>User Type:</lable>   -->

<select class="form-control" aria-describedby="sizing-addon1" name="usertype" id="usertype" required>
<option value="">User Type</option>
<option value="stud" <?php if(isset($_POST['usertype']) && $_POST['usertype']=='stud'){ ?> selected  <?php } ?>>Student</option>
<option value="emp" <?php if(isset($_POST['usertype']) && $_POST['usertype']=='emp'){ ?> selected  <?php } ?>>Employee</option>
</select></br>

<!--<lable for name>Organisation Name:</lable>  -->
<input type="text" class="form-control" aria-describedby="sizing-addon1" placeholder="Enter Organisation Name" name="orgname" id="orgname" value="<?php echo isset($_POST['orgname']) ? $_POST['orgname'] : '' ?>" required></br>

<lable for name><span class="label label-default" style="font-size: medium">Check for sign up:</span></lable></br> </br>
<input  type="checkbox" name="project[]" value="smartcookie" required>Smartcookie</br>
<input type="checkbox" name="project[]"  value="jobsitare">Job Sitara</br>
<input type="checkbox" name="project[]" value="ethicalhr">Ethical Hr</br>
<input type="checkbox" name="project[]"  value="startupworld">Startup World</br>
<input type="checkbox" name="project[]"  value="startterbarter">Starter Barter</br>
<input type="checkbox" name="project[]"  value="international">Join International Team</br>
<!--<input type="checkbox" name="project[]" value="jobsitare"></br>
<input type="checkbox" name="project[]" value="jobsitare"></br>
<input type="checkbox" name="project[]" value="jobsitare"></br>
<input type="checkbox" name="project[]"value="jobsitare" ></br>-->
<input type="submit" class="btn btn-default" id="submit" name="submit" value="Sign Up" required>

</form>

</div>
</div>
<div class="panel panel-default">
  <div class="panel-body">

                                        <!--echo "SMART COOKIE LOGIN INFO"."<br>";
									  echo "---------------------------------------------------------"."<br>";
									  echo "smartcookie Member ID of ".$usertype."=".$value["id"]."<br>";
									  echo "smartcookie Password of ".$usertype."=". $value["password"]."<br>";
									  echo "***************************************************"."<br>";
-->
                                      <div class="panel-heading" style="background-color: #EAEAEA">Result</div>

                                      <!-- Table -->
                                      <table class="table">
                                                <tr>
                                                        <td>Member ID</td>
                                                        <td>Status</td>
                                                        <td>Email-Id</td>
                                                        <td>Password </td>
                                                        <td>Site Name</td>
                                                </tr>
                                                <tr>
                                                        <?php

                                                        if(empty($smart_cookee1) && empty($smart_cookee2) && empty($smart_cookee1))
                                                        {

                                                        }
                                                        else{


                                                        ?>
                                                        <td><?php echo $smart_cookee1; ?></td>
                                                        <td><?php echo $r3; ?></td>
                                                        <td><?php echo $smart_cookee3; ?></td>
                                                        <?php
                                                        if($r3=="New USer") {?>
                                                           <td><?php echo $smart_cookee2; ?></td>
                                                        <?php } else{  ?>                                               
														<td><?php echo "Already Exist";?></td>
														<?php } ?>


                                                        <td><a href="http://tsmartcookies.bpsi.us/" target="_blank">Smart Cookie</a></td>
                                                        <?php }?>
                                                </tr>
                                                <tr>
                                                        <?php

                                                        if(empty($ethikal_hr1) && empty($ethikal_hr2) && empty($ethikal_hr3)&& empty($ethikal_hr4))
                                                        {

                                                        }
                                                        else{


                                                        ?>
                                                        <td><?php echo $ethikal_hr3; ?></td>
                                                        <td><?php echo $r2; ?></td>
                                                        <td><?php echo $ethikal_hr4; ?></td>
                                                        <?php
                                                        if($r2=="New USer") {?>
                                                           <td><?php echo $ethikal_hr2; ?></td>
                                                        <?php } else{  ?>                                               
														<td><?php echo "Already Exist";?></td>
														<?php } ?>


                                                        <td><a href="http://ethicalhr.org/login.php" target="_blank">Ethical HR</a></td>
                                                        <?php }?>
                                                </tr>
                                                <tr>
                                                        <?php

                                                        if(empty($startup_world1) && empty($startup_world2) && empty($startup_world3))
                                                        {

                                                        }
                                                        else{


                                                        ?>
                                                        <td><?php echo $startup_world1; ?></td>
                                                        <td><?php echo $r1; ?></td>
                                                        <td><?php echo $startup_world3; ?></td>
                                                        <?php
                                                        if($r1=="New USer") {?>
                                                           <td><?php echo $startup_world2; ?></td>
                                                        <?php } else{  ?>                                               
														<td><?php echo "Already Exist";?></td>
														<?php } ?>


                                                        <td><a href="http://startupworld.us/login.php" target="_blank">Startup World</a></td>
                                                        <?php }?>
                                                </tr>
												<tr>
                                                        <?php

                                                        if(empty($report))
                                                        {

                                                        }
                                                        

													else{  ?>
                                                        
                                                        <td><?php echo $report;?></td>
                                                        <td><?php echo $report;?></td>
                                                        <td><?php echo $report;?></td>
                                                        <td><?php echo $report;?></td>
                                                        <td><?php echo $site1;?></td> 
														
															<?php  }  ?>
												</tr>		                                         
													<tr>
                                                        <?php

                                                        if(empty($report1))
                                                        {

                                                        }
                                                        

													else{  ?>
                                                        
                                                        <td><?php echo $report1;?></td>
                                                        <td><?php echo $report1;?></td>
                                                        <td><?php echo $report1;?></td>
                                                        <td><?php echo $report1;?></td>
                                                        <td><?php echo $site2;?></td> 
														
													<?php  }  ?>
												</tr>	
<tr>
                                                        <?php

                                                        if(empty($report2))
                                                        {

                                                        }
                                                        

													else{  ?>
                                                        
                                                        <td><?php echo $report2;?></td>
                                                        <td><?php echo $report2;?></td>
                                                        <td><?php echo $report2;?></td>
                                                        <td><?php echo $report2;?></td>
                                                        <td><?php echo $site3;?></td> 
														
													<?php  }  ?>
												</tr>													
											     
                                                
                                      </table>

  </div>
</div>




</body>
</html>