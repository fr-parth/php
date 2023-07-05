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
$Dept_id=$result['Dept_id'];

if(isset($_POST['submit']))

{



	 $j=0;

	  $count=$_POST['count'];

	 $counts=0;

	 

							// Loop to store and display values of individual checked checkbox.

							for($i=0;$i<$count;$i++)

							{

								

							  $subject=ucwords(strtolower($_POST[$i]));

									 

							            

							  $results=mysql_query("select * from tbl_school_subject where school_id='$sc_id'  and subject like '$subject' ");      

							

								 if(mysql_num_rows($results)==0 && $subject!="")

									{

									 $query="insert into tbl_school_subject (subject,school_id,Dept_id) values('$subject','$sc_id','$Dept_id') ";

										$rs = mysql_query($query ); 

										$subject2[$counts]=$subject;

										$counts++;

										

									}

									else

									{

									  $subject1[$j]=$subject;

									  $j++;

									}

								

							

							}

							

							

								$subjects="";

							 if($counts==0)

									{

									

									   for($i=0;$i<count($subject1);$i++)

									   {

									   

										if($j==$i+1)

										 {

										  $subjects=$subjects." ".$subject1[$i];

									

										 }

										 else

										 {

										

									     $subjects=$subjects." ".$subject1[$i].",";

										 

										

										 }

									   }

									  

									   if(count($subject1)>1)

									   {

										 $errorreport=$subjects." subjects are already present . ";

										}

										else

										{

										 	$errorreport=$subject ." subject is already present . ";

										

										}

									

									}	

									

								else if($counts==1)

								    {

							            $successreport="You are successfully added ".$subject." subject ";

									}

									else

									{

										for($i=0;$i<count($subject2);$i++)

									   {

									   

											if($counts==$i+1)

											 {

											  $subjects=$subjects." ".$subject2[$i];

										

											 }

											 else

											 {

											

											 $subjects=$subjects." ".$subject2[$i].",";

											 

											

											 }

									   }

									  

									  

										

										

										

									     $successreport="You are successfully added ".$subjects." subjects";

									

									}

										

						}



?>

<html>

<head>

<script>

var i=1;

function create_input()



{





var index='E-';

 $("<div class='row formgroup' style='padding:5px;'  ><div class='col-md-3 col-md-offset-4'  ><input type='text' id="+i+" name="+i+" class='form-control' placeholder='Enter Subject Code'><input type='text' id="+i+" name="+i+" class='form-control' placeholder='Enter Subject Title'><input type='text' id="+i+" name="+i+" class='form-control' placeholder='Branch Id'><input type='text' id="+i+" name="+i+" class='form-control' placeholder='Degree Name'></div><div class='col-md-3' style='color:#FF0000;' id="+index+i+" ></div></div>").appendTo('#add');

   i=i+1;

   document.getElementById("count").value = i;

	

}



function valid()

{

   var subject_code=document.getElementById("0").value;
   var subject_name=document.getElementById("1").value;
   var branch_name=document.getElementById("2").value;
   var degree_name=document.getElementById("3").value;
   var semester_name=document.getElementById("4").value;
   regx1=/^[A-z0-9]+$/;
   if(subject_code=='')
   {
	   	document.getElementById("error").innerHTML='Please enter Subject code ';

				

				return false;
	
    }
	if(!regx1.test(subject_code) )
				{
				document.getElementById('error').innerHTML='Please enter valid Subject code';
					return false;
				}
				else
				{
					document.getElementById('error').innerHTML='';
				}
	
	if(subject_name=='')
	{
		document.getElementById("error").innerHTML='Please Enter Subject name ';

				

				return false;
		
	}
	
				//validation for name
				if(!regx1.test(subject_name) )
				{
				document.getElementById('error').innerHTML='Please Enter valid Subject name';
					return false;
				}
				else
				{
					document.getElementById('error').innerHTML='';
				}
				if(branch_name=='')
	{
		document.getElementById("error").innerHTML='Please enter branch name ';

				

				return false;
		
	}
	if(!regx1.test(branch_name) )
				{
				document.getElementById('error').innerHTML='Please enter valid branch name';
					return false;
				}
				else
				{
					document.getElementById('error').innerHTML='';
				}
	 if(degree_name=='')
   {
		document.getElementById("error").innerHTML='Please Enter degree name ';

				

				return false;
    }
	if(!regx1.test(degree_name) )
				{
				document.getElementById('error').innerHTML='Please Enter valid degree name';
					return false;
				}
				else
				{
					document.getElementById('error').innerHTML='';
				}
	if(semester_name=='')
	{
		document.getElementById("error").innerHTML='Please enter semester name ';

				

				return false;
		
	}
	if(!regx1.test(semester_name) )
				{
				document.getElementById('error').innerHTML='Please enter valid semester name';
					return false;
				}
				else
				{
					document.getElementById('error').innerHTML='';
				}
	
	

	/*var count=document.getElementById("count").value;



	var index='E-';

	

for(var i=0;i<count;i++)

	{

		var values=document.getElementById(i).value;

			

		if(values==null||values=="")

			{

			

				document.getElementById(index+i).innerHTML='Please Enter Subject code ';

				

				return false;

			}

			regx=/^[0-9]*$/;

				//validation of subject

				

			if(regx.test(values))

				{

				

					document.getElementById(index+i).innerHTML='Please Enter valid Subject';

					return false;

				}

		

	}
*/


}

</script>

</head>

<body bgcolor="#CCCCCC">

<div style="bgcolor:#CCCCCC">

<div>



</div>

<div class="container" style="padding:25px;"" >

        	

            

            	<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;background-color:#F8F8F8;">

                   <form method="post">

                    

                    

                    <div class="row">

                    <div class="col-md-3 col-md-offset-1"  style="color:#700000 ;padding:5px;" >

                    

               			 </div>

              			 <div class="col-md-3 " align="center" style="color:#663399;" >

                         	

                   				<h2>Add Projects</h2>

								<h5 align="center"><a href="Add_SubjectSheet_updated_20160109PT.php" >Add Excel Sheet</a></h5>

               			 </div>

                         

                     </div>

                  

                  

                   

                  

               <div class="row formgroup" style="padding:5px;" >

               

                   <div class="col-md-3 col-md-offset-4">

                        <input type="text" name="0" class="form-control " id="0" placeholder="Project ID">

                   </div>

				   <br/><br/>

				    <div class="col-md-3 col-md-offset-4">

                        <input type="text" name="1" class="form-control " id="1" placeholder="Project Name">

                   </div>

				    <br/><br/>

				   <div class="col-md-3 col-md-offset-4">

                        <input type="text" name="2" class="form-control " id="2" placeholder="Department Name">

                   </div>

				    <br/><br/>

				   <div class="col-md-3 col-md-offset-4">

                        <input type="text" name="3" class="form-control " id="3" placeholder="Project Domain">

                   </div>

				      <br/><br/>


                     <div class="col-md-4" id="E-0" style="color:#FF0000;">

                       

                       </div>

              

                  </div>
                  <div id="error" style="color:#F00;text-align: center;" align="center"></div>

                 <div id="add">

                </div>

                  

                   <div class="row" style="padding-top:15px;">

                

                  <div class="col-md-2 col-md-offset-4 " >

                    <input type="submit" class="btn btn-primary" name="submit" value="Add " style="width:80px;font-weight:bold;font-size:14px;" onClick="return valid()"/>

                    </div>

                    

                     <div class="col-md-3 "  align="left">

                   <a href="list_school_subject.php" style="text-decoration:none;"> <input type="button" class="btn btn-primary" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;" /></a>

                    </div>

                   

                   </div>

                 

                     <div class="row" style="padding-top:15px;">

                     <div class="col-md-4">

                     <input type="hidden" name="count" id="count" value="1">

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

</body>

</html>





