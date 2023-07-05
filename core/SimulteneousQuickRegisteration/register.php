<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Registration</title>
      <link href="css/style.css" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="css/font-awesome.css"/>
      <!-- Bootstrap -->
      <link href="css/bootstrap.css" rel="stylesheet">
      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
      <script type="text/javascript" src="js/jquery.js"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script src="js/bootstrap.js"></script>
      <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" />
      <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
      <link href='http://fonts.googleapis.com/css?family=Josefin+Sans:400,100,100italic,300italic,400italic,600,600italic,700italic,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
      <link href="css/media-queries.css" rel="stylesheet">
      <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
      <style>
	  input[type=text] {
   			color: black;
			font-size:20px;
		}
	  a{
		  color: blue;
		}
	  </style>
   </head>
   <body>
   
      <header class="clearfix">
         <div class="top-sect clearfix">
            <div class="container padding_none clearfix">
               <div class="row">
                  <div class="col-md-12">
                     <div class="heading-s">
                        <p>Simultaneous Registration</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!--<div class="nav-section  clearfix">
            <div class="container padding_none clearfix">
               <div class="col-md-8 col-md-offset-2 text-center">
                  <div class="col-md-4">
                     <div class="register-ic">
                        <p>REGISTER USING :</p>
                     </div>
                  </div>
                  <div class="col-md-7">
                     <div class="social-iconsb cleafix ">
                        <a class="btn fb-cin pdng-btmicons  btn-facebook">
                        <i class="fa fa-facebook"></i>
                        </a>
                        <a class="btn  icon-bgtw pdng-btmicons  btn-twitter">
                        <i class="fa   fa-twitter"></i>
                        </a>
                        <a class="btn  icon-bgtw pdng-btmicons  btn-google">
                        <i class="fa   fa-google"></i>
                        </a>
                        <a class="btn icon-linken pdng-btmicons  btn-linkedin">
                        <i class="fa   fa-linkedin"></i>
                        </a>
                        <a class="btn  icon-bgtw pdng-btmicons  btn-email">
                        <span class="glyphicon glyphicon-envelope"></span>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>-->
      </header>
      <div class="container">
         <div class="liketo-join clearfix">
            <h2>Would like to join : </h2>
         </div>
         <div class="registration-sec clearfix">
            <div class="row" >
<div class="col-md-6 col-md-offset-3">

<?php


$smart_cookee1="";
$smart_cookee2="";
$ethikal_hr1="";
$ethikal_hr2="";
$startup_world1="";
$startup_world2="";
$report="";
$report1="";
 $lastpage = $_SERVER['HTTP_REFERER'];

if(isset($_POST['submit']))
{
	//$_SERVER['HTTP_REFERER'];
	//echo "dghdh";
	
	$firstname=$_POST['firstname'];
	$middlename=$_POST['middlename'];
	$lastname=$_POST['lastname'];
	$phonenumber=$_POST['phonenumber'];
	$emailid=$_POST['emailid'];
	$countrycode=$_POST['countrycode'];
	$usertype=$_POST['usertype'];
	$orgname=$_POST['orgname'];
	$project[]=$_POST['project'];
	$source ='';

	
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
					
		}
		
	}
	
	
}




?>
<div class="panel panel-default">
  <div class="panel-heading" style="text-align: center;color: #C0C0C0;font-size: x-large" >Simultaneous Registration Page</div>
  <div class="panel-body">
<form method="post">


<!--<lable for name><span class="label label-default">First Name:</span></lable>  -->
<input style="color:black;" type="text" class="form-control" aria-describedby="sizing-addon1" placeholder="Enter First Name" name="firstname" id="firstname" value="<?php if(isset($_GET['firstname'])) echo $_GET['firstname']; elseif(isset($_POST['firstname'])) echo $_POST['firstname'];?>" required pattern="[A-Za-z]*"></br>

<!--<lable for name>Middle Name:</lable> -->
<input  style="color:black;font-size:14;" type="text" class="form-control" aria-describedby="sizing-addon1" placeholder="Enter Middle Name" name="middlename" id="middlename" value="<?php if(isset($_GET['middlename'])) echo $_GET['middlename']; elseif(isset($_POST['middlename'])) echo $_POST['middlename'];?>" pattern="[A-Za-z]*" ></br>

<!--<lable for name>Last Name:</lable> -->
<input type="text" class="form-control" aria-describedby="sizing-addon1" placeholder="Enter Last Name" name="lastname" id="lastname" pattern="[A-Za-z]*" value="<?php if(isset($_GET['lastname'])) echo $_GET['lastname']; elseif(isset($_POST['lastname'])) echo $_POST['lastname'];?>" required></br>

<!--<lable for name>Phone Number:</lable> -->
<input type="number" maxlength="10" class="form-control" aria-describedby="sizing-addon1" placeholder="Enter Phone Number" name="phonenumber" id="phonenumber" value="<?php if(isset($_GET['phonenumber'])) echo $_GET['phonenumber']; elseif(isset($_POST['phonenumber'])) echo $_POST['phonenumber'];?>" required></br>

<!--<lable for name>Email Id:</lable>-->
<input type="text" class="form-control" aria-describedby="sizing-addon1" placeholder="Enter Email-ID" name="emailid" id="emailid"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$"value="<?php if(isset($_GET['emailid'])) echo $_GET['emailid']; elseif(isset($_POST['emailid'])) echo $_POST['emailid'];?>" required></br>

<!--<lable for name>Country Code:</lable>-->
<select style="font-size=20px;;color:black;" class="form-control" aria-describedby="sizing-addon1" name="countrycode" id="countrycode" value="<?php if(isset($_GET['countrycode'])) echo $_GET['countrycode']; elseif(isset($_POST['countrycode'])) echo $_POST['countrycode'];?>" required>
<option style="font-size=20px;color:black;" value="">Country Code</option>
<option value="91">91</option>
<option value="1">1</option>

</select></br>


<!--<lable for name>User Type:</lable>   -->

<select style="font-size=20px;color:black;" class="form-control" aria-describedby="sizing-addon1" name="usertype" id="usertype" value="<?php if(isset($_GET['usertype'])) echo $_GET['usertype']; elseif(isset($_POST['usertype'])) echo $_POST['usertype'];?>" required>
<option style="font-size=20px;color:black;" value="">User Type</option>
<option value="Student">Student</option>
<option value="Employee">Employee</option>
</select></br>

<!--<lable for name>Organisation Name:</lable>  -->
<input type="text" class="form-control" aria-describedby="sizing-addon1" placeholder="Enter Organisation Name" name="orgname" id="orgname" value="<?php if(isset($_GET['orgname'])) echo $_GET['orgname']; elseif(isset($_POST['orgname'])) echo $_POST['orgname'];?>" pattern="[A-Za-z A-Zaa-z ]*" required></br>

<lable for name><span class="label label-default" style="font-size: medium">Check for sign up:</span></lable></br> </br>
<input  type="checkbox" name="project[]" value="smartcookie"  required>Smartcookie
<input type="checkbox" name="project[]"  value="jobsitare">Job Sitare
<input type="checkbox" name="project[]" value="ethicalhr">Ethical Hr
<input type="checkbox" name="project[]"  value="startupworld">Startup World
<input type="checkbox" name="project[]"  value="startterbarter">Startter Barter
<!--<input type="checkbox" name="project[]" value="jobsitare"></br>
<input type="checkbox" name="project[]" value="jobsitare"></br>
<input type="checkbox" name="project[]" value="jobsitare"></br>
<input type="checkbox" name="project[]"value="jobsitare" ></br>-->
<input type="submit" class="btn btn-default" id="submit" name="submit" value="Sign Up">

<a href="<?php echo $lastpage;?>"><input type="button" class="btn btn-default" id="back" name="back" value="Back"></a>
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
														<td><?php echo "NIL";?></td>
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
														<td><?php echo "NIL";?></td>
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
														<td><?php echo "NIL";?></td>
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
											     
                                                
                                      </table>

  </div>
</div>



         </body>
</html>