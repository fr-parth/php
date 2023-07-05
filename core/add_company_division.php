<?php

                  if(isset($_GET['id']))

				  {

					 include_once("school_staff_header.php");

		        $report="";

				  $results=mysql_query("select * from tbl_school_adminstaff where id=".$staff_id."");

				  $result=mysql_fetch_array($results);

				  $sc_id=$result['school_id'];



            if(isset($_POST['submit']))

                {

	

		          	$divisions=$_POST['division'];

		            $division=explode(",",$divisions);

					

			        $count=count($division);

					$class_id=$_POST['class_id'];	

					$result=mysql_query("select * from tbl_school_class where Id=$class_id");

					$values=mysql_fetch_array($result);

					$class=$values['class'];

				

					$counts=0;			

					$j=0;

				

						for($i=0;$i<count($division);$i++)

						{

							$results=mysql_query("select id,division from tbl_school_division where class_id='$class_id'  and division like '%$division[$i]%'");

								 if(mysql_num_rows($results)<=0 && $division[$i]!="")

									{

									    $division[$i]=strtoupper($division[$i]);



$query="insert into tbl_school_division(class_id,division,school_id,school_staff_id) values('$class_id','$division[$i]','$sc_id','$staff_id')";

										$rs = mysql_query($query); 

										$div2[$counts]=$division[$i];

                                        $counts++; 

									}

									else

									{

									     $div1[$j]=$division[$i];

									  $j++;

									

									}

						           }

						

						$divs="";

							 if($counts==0)

									{

									  for($i=0;$i<count($div1);$i++)

									   {

									   if($j==$i+1)

										 {

										  $divs=$divs." ".$div1[$i];

									     }

										 else

										 {

										 $divs=$divs." ".$div1[$i].",";

										 }

									   }

									  

								 if(count($div1)>1)

									   {

										 $report=$divs." divisions are already present in  class".$class;

										}

										else

										{

										 	$report=$division[0] ." division is already present in  class ".$class;

										

										}

									

									}	

									

								else if($counts==1)

								    {

							            $report="You are successfully added ".$division[0]." division in class ".$class." ";

									}

									else

									{

										for($i=0;$i<count($div2);$i++)

									   {

									   

											if($counts==$i+1)

											 {

											 $divs=$divs." ".$div2[$i];

										

											 }

											 else

											 {

											

											 $divs=$divs." ".$div2[$i].",";

											 

											

											 }

									   }

									   $report="You are successfully added ".$divs." divisions in class ".$class."";

									

									}

									}



                          ?>







<html >

<head>



<title>Untitled Document</title>



<script>



function valid()

{ 

   

	var division=document.getElementById("division").value;



			

		if(division==null||division=="")

			{

			

				document.getElementById('error').innerHTML='Please Enter Division';

				

				return false;

			}

			

           var divisions = division.split(',');

		  

		   for(var j=0;j<divisions.length;j++)

		   {

		 

		   	regx=/^[0-9]*$/;

				//validation of division

				

			if(regx.test(divisions[j]))

				{

			

					document.getElementById('error').innerHTML='Please Enter valid Division';

					return false;

				}

		   }



	



}

</script>

</head>





<body bgcolor="#CCCCCC">

<div style="bgcolor:#CCCCCC">

<div>



</div>

<div class="container" style="padding:25px;"" >

        	

            

            	<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">

                   

                    

                    <div style="background-color:#F8F8F8 ;">

                    <div class="row">

                    <div class="col-md-4"  style="color:#700000 ;" >

                         

               			 </div>

              			 <div class="col-md-3 " align="center" style="color:#666 ;" >

                         	

                   				<h2>Add Designation</h2>

               			 </div>

                         

                     </div>

                  

                  

                   

                  

               <div class="row">

               <form method="post">

               <div class="col-md-3">

               </div>

               <div class="col-md-6 col-md-offest-2">

               <?php $i=0;?>

                  <table class="table-bordered" >

                     

                    	<tr style="background-color:#555;color:#FFFFFF;height:30px;"><th style="width:60px;" ><b><center>Sr.No</center></b></th><th style="width:150px;" ></th><th style="width:350px;" ><center><b>Designation</b></center></th></tr>

                 

               

                   <?php

				   $value=mysql_query("select id,class from tbl_school_class where school_id='$sc_id' ORDER BY class ");?>

                 

                  <tr >

                  <td align="center">1</td>

                  <td align="center" ><select name="class_id" style="width:100px;" class="form-control"><?php while($result=mysql_fetch_array($value)){ ?><option value="<?php echo $result['id'];?>"><?php echo $result['class'];?></option><?php }?></select></td><td align="left" style="padding:5px;width:200px;"><input type="text" class="form-control" id="division" name="division" placeholder=" Divisions separated by comma"/></td></tr>

                 

                   

                  

                  </table>

                  </div>

                  </div>

                  

                  

                   <div class="row" style="padding:15px;">

              

                  <div class="col-md-3 col-md-offset-3 "  align="center">

                    <input type="submit" class="btn btn-primary" name="submit" value="Add" style="width:70px;font-weight:bold;font-size:14px;" onClick="return valid()"/>

                   

                   </div>

                   <script>

					         function backpage()

							 {

                                window.history.go(-1);

							 }

                    </script>

                   <div class="col-md-3 "  align="left">

                            <?php $names="division"; ?>

                   <a href="list_school_division.php?name=<?=$names?>" style="text-decoration:none;"><input type="button" class="btn btn-primary" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;" /></a>

                    </div>

                   </form>

                    </div>

                     <div class="row" style="padding:15px;" >

                     <div class="col-md-4">

                     </div>

                      <div class="col-md-6" style="color:#FF0000;"  id="error">

                      

                      <?php echo $report;?>

               			</div>

                 

                    </div>

                      

                

                  

                 

                    

                    

                  

               </div>

               </div>

</body>

</html>

<?php

				  }

				  else

				  {

					  $report="";

include('hr_header.php');

$id=$_SESSION['id'];

           $fields=array("id"=>$id);

		   $table="tbl_school_admin";

		   

		   $smartcookie=new smartcookie();

		   

$results=$smartcookie->retrive_individual($table,$fields);

$result=mysql_fetch_array($results);

$sc_id=$result['school_id'];



if(isset($_POST['submit']))

{

	

			$divisions=$_POST['division'];

			   $division=explode(",",$divisions);

			       $count=count($division);

					

				

					$counts=0;			

					$j=0;

				

						for($i=0;$i<count($division);$i++)

						{

							$results=mysql_query("select id,DivisionName from Division  where  DivisionName like '%$division[$i]%'");

								 if(mysql_num_rows($results)<=0 && $division[$i]!="")

									{

									    $division[$i]=strtoupper($division[$i]);

										$query="insert into Division(DivisionName,school_id) values('$division[$i]','$sc_id') ";

										$rs = mysql_query($query ); 

										

										$div2[$counts]=$division[$i];

                                        $counts++; 

									}

									else

									{

									     $div1[$j]=$division[$i];

									  $j++;

									

									}

						          }

						      $divs="";

							 if($counts==0)

									{

									

									   for($i=0;$i<count($div1);$i++)

									   {

									   

										if($j==$i+1)

										 {

										  $divs=$divs." ".$div1[$i];

									

										 }

										 else

										 {

										

									     $divs=$divs." ".$div1[$i].",";

										 

										

										 }

									   }

									  

									   if(count($div1)>1)

									   {

										 $report=$divs." divisions are already present";

										}

										else

										{

										 	$report=$division[0] ." division is already present ";

										

										}

									

									}	

									

								else if($counts==1)

								    {

							            $successreport="You are successfully added ".$division[0]." division ";

									}

									else

									{

										for($i=0;$i<count($div2);$i++)

									   {

									   

											if($counts==$i+1)

											 {

											 $divs=$divs." ".$div2[$i];

										

											 }

											 else

											 {

											

											 $divs=$divs." ".$div2[$i].",";

											 

											

											 }

									   }

									  $successreport="You are successfully added ".$divs." divisions ";

									

									}

										

							     }



?>







<html>

<head>



<title>Untitled Document</title>



<script>



function valid()

{ 

   

	var division=document.getElementById("division").value;



			

		if(division==null||division=="")

			{

			

				document.getElementById('error').innerHTML='Please Enter Division';

				

				return false;

			}

			

           var divisions = division.split(',');

		  

		   for(var j=0;j<divisions.length;j++)

		   {

		 

		   	regx=/^[0-9]*$/;

				//validation of division

				

			if(regx.test(divisions[j]))

				{

			

					document.getElementById('error').innerHTML='Please Enter valid Division';

					return false;

				}

		   }



	



}

</script>

</head>





<body bgcolor="#CCCCCC">

<div style="bgcolor:#CCCCCC">

<div>



</div>

<div class="container" style="padding:25px;"" >

        	

            

            	<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">

                   

                    

                    <div style="background-color:#F8F8F8 ;">

                    <div class="row">

                    <div class="col-md-4"  style="color:#700000 ;" >

                         

               			 </div>

              			 <div class="col-md-3 " align="center" style="color:#666 ;" >

                         	

                   				<h2>Add Designation</h2>

               			 </div>

                         

                     </div>

                  

                  

                   

                  

               <div class="row">

               <form method="post">

               <div class="col-md-3">

               </div>

               <div class="col-md-6 col-md-offest-2">

               <?php $i=0;?>

                  <table class="table-bordered" >

                     

                    	<tr style="background-color:#555;color:#FFFFFF;height:30px;"><th style="width:60px;" ><b><center>Sr.No</center></b></th><th style="width:350px;" ><center><b>Designation</b></center></th></tr>

                 

               

                   <?php

				   $value=mysql_query("select id,class from tbl_school_class where school_id='$sc_id' ORDER BY class ");?>

                 

                  <tr >

                  <td align="center">1</td>

           <td align="left" style="padding:5px;width:200px;"><input type="text" class="form-control" id="division" name="division" placeholder=" Divisions separated by comma"/></td></tr>

                  </table>

                  </div>

                  </div>

                  

                  

                   <div class="row" style="padding:15px;">

              

                  <div class="col-md-3 col-md-offset-3 "  align="center">

                    <input type="submit" class="btn btn-primary" name="submit" value="Add" style="width:70px;font-weight:bold;font-size:14px;" onClick="return valid()"/>

                   

                   </div>

                   <div class="col-md-3 "  align="left">

                   <a href="list_school_division.php" style="text-decoration:none;"> <input type="button" class="btn btn-primary" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;" /></a>

                    </div>

                   </form>

                    </div>

                     <div class="row" style="padding:15px;" >

                     <div class="col-md-4">

                     </div>

                      <div class="col-md-6"  >

                      
<div style="color:#FF0000;" id="error">
                      <?php echo $report;?>
                      </div>
                      <div style="color:#090;">
                      <?php echo $successreport;?>
                      </div>

               			</div>
                        

                 

                    </div>

              </div>

               </div>

</body>

</html>

<?php

				   }

?>