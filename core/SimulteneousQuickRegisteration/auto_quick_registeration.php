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
		
table, td, th {
    border: 1px solid black;
}

table {
    border-collapse: collapse;
    width: 100%;
}

td {
    height: 50px;
    vertical-align: bottom;
	text-align:center;
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
                        <p>Startup World Registration </p>
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
         <div class="liketo-join clearfix" style="color:white;">
            <h3 style='text-align:center'>Welcome to world of Opportunities for jobs.Opportunities for connecting people of your field.</h3>
            <p style='text-align:center'>Thanks for beigning with vibrant minds<p>
            <p style='text-align:center'>Now you are member of Tsmartcookie,Job Sitara and Ethical HR<p>
            
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
 //$lastpage = $_SERVER['HTTP_REFERER'];


	//$_SERVER['HTTP_REFERER'];
	//echo "dghdh";
	
	$firstname=$_GET['firstname'];
	$middlename=$_GET['middlename'];
	$lastname=$_GET['lastname'];
	$phonenumber=$_GET['phonenumber'];
	$emailid=$_GET['emailid'];
	$countrycode=$_GET['countrycode'];
	$usertype=$_GET['usertype'];
	$orgname=$_GET['orgname'];
	$projectlist=$_GET['project'];
	$project=explode(',',$projectlist);
	$source ='';
//var_dump($project);
	
	for($i=0;$i<count($project);$i++)
	{
		
			if($project[$i]=='smartcookie')
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
			if($project[$i]=='ethicalhr')
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
				if($project[$i]=='startupworld')
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
				if($project[$i]=='jobsitare')
				{
					$report="Work in progress";
					$site1="Job Sitara";
				}
				if($project[$i]=='startterbarter')
				{
					$report1="Work in progress";
					$site2="Starter Barter";
				}
					
		}
		
	
	
	





?>

                                        <!--echo "SMART COOKIE LOGIN INFO"."<br>";
									  echo "---------------------------------------------------------"."<br>";
									  echo "smartcookie Member ID of ".$usertype."=".$value["id"]."<br>";
									  echo "smartcookie Password of ".$usertype."=". $value["password"]."<br>";
									  echo "***************************************************"."<br>";
-->
                                     

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