<?php

$report="";

include("hr_header.php");



if(!isset($_SESSION['id']))

	{

		header('location:login.php');

	}

	$id=$_SESSION['id'];

           $fields=array("id"=>$id);

		   $table="tbl_school_admin";

		   $smartcookie=new smartcookie();

		   

$results=$smartcookie->retrive_individual($table,$fields);

$result=mysql_fetch_array($results);



$sc_id=$result['school_id'];



if(isset($_GET["subject"]))

	{

		$subject_id= $_GET["subject"];

		 $sql1="select * from tbl_school_subject where id='$subject_id' and school_id='$sc_id'";

		$row=mysql_query($sql1);

	    $arr=mysql_fetch_array($row);

		$subject=$arr['subject'];

		$Subject_Code=$arr['Subject_Code'];

		

		



?>

<?php

 if(isset($_POST['submit']))

 {

   $subject=$_POST['subject'];

	







	

	if(mysql_num_rows($rows)<=0)

	{

	

   

	mysql_query("update tbl_school_subject set subject='$subject' where id='$subject_id' and school_id='$sc_id' ");

	

	mysql_query("update tbl_teacher_subject_master set 	subjectName='$subject' where subjcet_code='$Subject_Code' and school_id='$sc_id' ");

	mysql_query("update tbl_student_subject_master set 	subjectName='$subject' where subjcet_code='$Subject_Code' and school_id='$sc_id' ");

	  if(mysql_affected_rows()>0)

		{

		 $report="Subject is Successfully updated !!!";

		 header("Location:list_school_subject.php?report=".$report);

	

		}

	}

	else

	{

	

	 $report=$subject." subject is already present.";

	

	}

	

}?>

<html>

<head>

<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">

<script>

	function valid()

	{

	  var subject=document.getElementById("subject").value;

	

	  if(subject=="")

	  {

	   document.getElementById('error').innerHTML='Please Enter Subject';

	    return false;

	  }

	  regx=/^[0-9]*$/;

				//validation of subject

				

			if(regx.test(subject))

				{

					document.getElementById('error').innerHTML='Please Enter valid Subject';

					return false;

				}

	

	}

</script>

</head>

<body  align="center">

<div class="container" style="padding:10px;" align="center">

<div class="row"  >

<div class="col-md-3">

</div>

<div class="col-md-6">

<div class="container" style="padding:25px;" >

        	

            

            	<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;background-color:#F8F8F8 ;">

                   

                    

               

	

         <form method="post"  >

          <div class="row" style="color: #666;height:100px;font-family: 'Open Sans',sans-serif;font-size: 12px;">

                <h2>Edit Project</h2>

          </div>

          

          <div class="row " >

                  <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">

                 <b> Project</b>

                  </div>

                  <div class="col-md-5 form-group">

                            

                                <input type="text" name="subject" id="subject" class="form-control" style="width:100%; padding:5px;" placeholder="Enter Subject" value='<?php echo $subject; ?>'/>

                  </div>

          </div>
		  <div class="row " >

                  <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">

                 <b> Project Deadline</b>

                  </div>

                  <div class="col-md-5 form-group">

                            

                                <input type="text" name="subject" id="subject" class="form-control" style="width:100%; padding:5px;" placeholder="" value='<?php echo $subject; ?>'/>

                  </div>

          </div>

          <div class="row " >

                  

                  <div class="col-md-8 form-group col-md-offset-3" id="error" style="color:red;">

                            

                               <?php echo $report;?>

                  </div>

          </div>

          

          <div class="row" >

          	<div class="col-md-3 col-md-offset-2" style="padding:10px;">

          			   <input type="submit" name="submit" class="form-control" style="width:100%;background-color:#0080C0; color:#FFFFFF;" value="submit" onClick="return valid()"/>

             </div>

             <div class="col-md-3 col-md-offset-1" style="padding:10px;">

                <a href="list_school_subject.php" style="text-decoration:none;"><input type="button" class="form-control" name="cancel" value="cancel" style="width:100%;background-color:#0080C0; color:#FFFFFF;" ></a>

              </div>

          

          </div>

         </form>

          </div>

      </div>

    </div>

</div>



</div>

</div>



	

      

</body>

</html>

<?php }?>