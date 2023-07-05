 <?php

     include_once('scadmin_header.php');

     $report="";



/*$smartcookie=new smartcookie();

           $id=$_SESSION['id'];

           $fields=array("id"=>$id);

		   $table="tbl_school_admin";

		   $smartcookie=new smartcookie();*/

     $arr=array(); $sql=array();

$results=$smartcookie->retrive_individual($table,$fields);

$result=mysql_fetch_array($results);

 $sc_id=$result['school_id'];
 $condition="";
 //$entityname=='T';
 if(isset($_POST['submit']))
 {

    $entityname=trim($_POST['entity']);
     $text=trim($_POST['keywordtxt']);
     $input=trim($_POST['input']);

    if($entityname=='Teacher')
    {
      switch($input)
      {

        case 'prn' :
                        if(!empty($text))
                        {
                              $condition = "t_id='".$text."'";
                             /* getdetails($condition,$entityname); */
                              break;
                        }
        case 'name' :  if(!empty($text))
                        {
                             $condition = "t_name LIKE '".$text."%' or t_lastname LIKE '".$text."%'";
                            /* getdetails($condition,$entityname); */
                             break;
                         }

        case 'branch' :
                          if(!empty($text))
                        {
                              $condition = "t_dept LIKE '".$text."%'";
                               /* getdetails($condition,$entityname);    */
                                break;
                         }
        case 'phone' :
                          if(!empty($text))
                        {
                             $condition = "t_phone='".$text."'";
                            /* getdetails($condition,$entityname);*/
                                break;
                         }

        case 'email' :
                            if(!empty($text))
                        {
                            $condition = "t_email='".$text."'";
                           /* getdetails($condition,$entityname);      */
                            break;
                        }
        default:   $report="Invalid Input";


      }

    }







    else if($entityname=='Student')
    {
         switch($input)
      {

        case 'prn' :
                        if(!empty($text))
                        {
                        $condition = "std_PRN='".$text."'";
                       /* getdetails($condition,$entityname);    */
                        break;
                        }
        case 'name' :  if(!empty($text))
                        {
                             $condition = "std_name LIKE '".$text."%' or std_lastname LIKE '".$text."%'";
                            /* getdetails($condition,$entityname); */
                             break;
                         }

        case 'branch' :
                          if(!empty($text))
                        {
                              $condition = "std_dept='".$text."'";
                               /* getdetails($condition,$entityname);     */
                                break;
                         }
        case 'phone' :
                          if(!empty($text))
                        {
                             $condition = "std_phone='".$text."'";
                            /* getdetails($condition,$entityname);  */
                                break;
                         }

        case 'email' :
                            if(!empty($text))
                        {
                            $condition = "std_email='".$text."'";
                           /* getdetails($condition,$entityname); */
                            break;
                        }
        default:   $report="Invalid Input";


    }

   }else{

            $report="Invalid Entity Name";
   }

   }
?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">



  <style>

@media only screen and (max-width: 800px) {

    

    /* Force table to not be like tables anymore */

	#no-more-tables table, 

	#no-more-tables thead, 

	#no-more-tables tbody, 

	#no-more-tables th, 

	#no-more-tables td, 

	#no-more-tables tr { 

		display: block; 

	}

 

	/* Hide table headers (but not display: none;, for accessibility) */

	#no-more-tables thead tr { 

		position: absolute;

		top: -9999px;

		left: -9999px;

	}

 

	#no-more-tables tr { border: 1px solid #ccc; }

 

	#no-more-tables td { 

		/* Behave  like a "row" */

		border: none;

		border-bottom: 1px solid #eee; 

		position: relative;

		padding-left: 50%; 

		white-space: normal;

		text-align:left;

		font:Arial, Helvetica, sans-serif;

	}

 

	#no-more-tables td:before { 

		/* Now like a table header */

		position: absolute;

		/* Top/left values mimic padding */

		top: 6px;

		left: 6px;

		

		padding-right: 10px; 

		white-space: nowrap;

		

		

	}

 

	/*

	Label the data

	*/

	#no-more-tables td:before { content: attr(data-title); }

}

</style>

        







<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Untitled Document</title>

</head>

<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">

 <link rel="stylesheet" href="css/bootstrap.min.css">

<script src="js/jquery-1.11.1.min.js"></script>

<script src="js/jquery.dataTables.min.js"></script>



<script>

$(document).ready(function() {

    $('#example').dataTable( {

	

      

    } );

} );



</script>





<script>





function confirmation(xxx) {



    var answer = confirm("Are you sure you want to delete?")

    if (answer){

        

        window.location = "delete_teacher.php?id="+xxx;

    }

    else{

       

    }

}


</script>

 <script>
function goBack() {
    window.history.back();
}
</script>


<style>
 input[type="submit"]
        {

           background-color: #FFFFFF;
           width:100px;
           height:30px;
           border-radius: 5px;
           font-size: 17px;
           box-shadow:0px 0px 2px 3px #FFCC33;
           background: linear-gradient(#FFF,#CCC);
        }

.preview

{

border-radius:50% 50% 50% 50%;  



box-shadow: 0 3px 2px rgba(0, 0, 0, 0.3);

-webkit-border-radius: 99em;

  -moz-border-radius: 99em;

  border-radius: 99em;

  border: 5px solid #eee;

  width:100px;

}

</style>



<body bgcolor="#CCCCCC">

<div style="bgcolor:#CCCCCC">



<div class="container" style="padding:30px;">

        	

            

            	<div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">

                   

                    

                    <div style="background-color:#F8F8F8 ;">

                    <div class="row">

                    <div class="col-md-3"  style="color:#700000 ;padding:5px;">&nbsp;&nbsp;&nbsp;&nbsp;
                    <button onclick="goBack()" style="width:100;font-weight:bold;font-size:14px;">Go Back</button>
            <!-- <a href="searching.php"><input type="button" class="btn btn-primary" name="submit" value="Back" style="width:100;font-weight:bold;font-size:14px;"/></a>  -->

               			 </div>

              			 <div class="col-md-6 " align="center"  >

                         	

                   				<h2>Search</h2>

               			 </div>

                         

                     </div>
                     <form action="" method="POST" name="form1">
                  <div class="row" style="padding:10px;" >

                  <div class="col-md-12" id="no-more-tables" >
                  <select name="entity" id="" style="margin-left: 450px;width:210px;">
                  <option value="Teacher" <?php if(isset($_POST['entity']) && $_POST['entity']=='Teacher'){ ?> selected  <?php } ?>><?php echo $dynamic_teacher;?></option>
                  <option value="Student" <?php if(isset($_POST['entity']) && $_POST['entity']=='Student'){ ?> selected  <?php  } ?>><?php echo $dynamic_student;?> </option>
                   </select>
                   <br /><br />
                      <?php echo $report;?>




                     <div class="row" style="margin-left:210px;" >
                     <span style="height:30px;background: #99FFCC;color: #333333;size: 18px;text-align: left;border: solid 1px;">Enter The keyword that You want to search:</span>&nbsp;&nbsp;&nbsp;
<input type="text" placeholder="Enter Name" name="keywordtxt"  id="keyid" value="" size="20" required/>&nbsp;&nbsp;
                      <select name="input" id="" style="width:100px;height:24px;">
                       <option value="" disabled="disabled">Input Type</option>
                      <option value="prn" <?php if(isset($_POST['input']) && $_POST['input']=="prn"){ ?> selected  <?php } ?>>PRN/TID</option>
                      <option value="name" <?php if(isset($_POST['input']) &&  $_POST['input']=="name"){ ?> selected  <?php } ?>>NAME</option>
                      <option value="branch" <?php if(isset($_POST['input']) && $_POST['input']=="branch"){ ?> selected  <?php } ?>>Branch</option>
                      <option value="phone" <?php if(isset($_POST['input'])=="phone" && $_POST['input']=="phone"){ ?> selected  <?php } ?> >Phone</option>
                      <option value="email" <?php if(isset($_POST['input'])=="email" && $_POST['input']=="email"){ ?> selected  <?php } ?> >Email</option>
                      </select>&nbsp;&nbsp;
                    <input type="submit" name="submit" value="Submit" class="sbtn" />
                     </div>
                      </form>
                        <!-- ------------------------------------------------------------  -->

                    <table class="table-bordered  table-condensed cf" id="example" width="100%;" >
                      <?php  if($entityname=='Teacher') {?>
                    <thead>

                    <tr style="background-color:#555;color:#FFFFFF;height:30px;" ><th>Sr.No</th><th>Profile Picture</th><th >Teacher ID</th><th>Teacher Name</th><th >Phone No.</th>

					 <th>Email ID</th><th >Department</th><th >No of Subjects</th><th>Edit</th><th>Delete</th></tr>

                      </thead>
                      <?php }

                       else if($entityname=='Student')   { ?>
                         <thead>

                                            <tr>


                                                 <th>Sr.No</th>
                                				<th >Student PRN</th>
                                				<th >Student Name</th>
                                				<th>Email ID</th>
                                				<th>Course Level</th>
                                                	<th>Academic Year</th>
                                				<th>Phone</th>
                                				<th>Batch Id</th>
                                                  <th>Edit</th><th>Delete</th>



                                            </tr>

                                        </thead>

                      <?php } else
                      {

                         $report="Invalid Entity Name";
                      }  ?>




                 <?php




                    /*   function getdetails($condition,$entityname)
                       {*/

                            /* if()
                             {


                                $flag=1;

                                 echo "ter1";
                              }
                              if()

                              {
                                  $sql=mysql_query("select id,std_PRN,std_complete_name,std_email,Course_level,std_phone,batch_id from tbl_student where $condition and school_id='$sc_id' order by id ASC");

                              }*/
                          /*
                           }*/
                          ?>

                           <tbody>
                          <?php

                        if($entityname=='Teacher')
                        {


                                $arr=mysql_query("select * from tbl_teacher where  school_id='$sc_id'  and    ".$condition."  order by id ASC");
								$i=1;
                                 while($row=mysql_fetch_array($arr))
                              {

                                   	
                                    $t_id=$row['t_id'];
                                   $fullname=ucwords(strtolower($row['t_complete_name']));

                    				  ?>

                                      <tr>



                                    <td ><?php echo $i;?></td>

                					<td><?php if($row['t_pc']!=''){?>

                                     <img src="<?php echo $row['t_pc'];?>" class="preview" style=" width:70px;height:70px;" alt="Responsive image" />

                                     <?php }else {?> <img src="Images/avatar_2x.png"  style="border:1px solid #CCCCCC; width:70px;height:70px;" class="preview" alt="Responsive image"/> <?php }?></td>

                                     <td ><?php echo $row['t_id'];?></td>



                                    <td ><?php $teacher_name=ucwords(strtolower( $row['t_name']." ".$row['t_middlename']." ".$row['t_lastname']));?><?php if($fullname=="")

                  					{echo $teacher_name;}else{echo $fullname;}?></td>


                                        <td><?php echo $row['t_phone'];?> </td>



                    					<td ><?php echo $row['t_email'];?> </td>



                    				    <td ><?php echo $row['t_dept'];?> </td>



                    					<td>  <?php
                                                /*echo  $t_id." ".$sc_id; */
                    	                    	$sql=mysql_query("select s.tch_sub_id from tbl_teacher_subject_master s join  tbl_academic_Year y on s.AcademicYear=y.Year and s.`ExtYearID`=y.ExtYearID and y.Enable='1' where s.teacher_id='$t_id' and y.school_id='$sc_id'");



        								  $count=mysql_num_rows($sql);

        								  echo $count;

        								   ?>  </td>



                        				  <td ><a href="edit_teacher_details.php?t_id=<?php echo $row['t_id'];?>"><center><img src="Images/edit.png" height="20px" width="20px"></a></center></td>

                        				  <td><center><img src="Images/cancel.png" style=" width:25px;height:25px;" alt="Cancel" id="<?php echo $row['id']; ?>" onclick="return confirmation(this.id)"></center></td>


                                         </tr>

                                        <?php

                        				$i++;

                        				?>

                                         <?php

                             }
                         }else

                         {          //echo "std"   ;
                                    $i=1;
                                    /*$query = mysql_query($sql); */
									//echo"select id,Academic_Year,std_PRN,std_complete_name,std_email,Course_level,std_phone,batch_id tbl_student where $condition and school_id='$sc_id' order by id ASC";
                                    $sql=mysql_query("select id,Academic_Year,std_PRN,std_complete_name,std_email,Course_level,std_phone,batch_id from tbl_student where $condition and school_id='$sc_id' order by id ASC");
                                    while($rows=mysql_fetch_assoc($sql))
                                                  {      
                                                     ?>
                                                                  <tr class="active"
                                    onmouseover="this.style.cursor='pointer';this.style.textDecoration='underline';this.style.color='dodgerblue'"
                                    onmouseout="this.style.textDecoration='none';this.style.color='black';"
                                    onclick="window.location='studentinformation.php?prn=<?php echo $rows['std_PRN'];?>&key=1'"

                        style="cursor: pointer; text-decoration: underline; color: dodgerblue; background-colorrgb(239, 243, 251);height:30px;color:#808080;">
                                                                        <td ><?php echo $i;?></td>
                                                                       <td>
                                                                           <?php echo $rows['std_PRN']; ?>
                                                                       </td>
                                                                       <td >
                                                                           <?php echo $rows['std_complete_name']; ?>
                                                                       </td >
                                                                       <td>
                                                                           <?php echo $rows['std_email']; ?>
                                                                       </td>
                                                                       <td>
                                                                           <?php echo $rows['Course_level']; ?>
                                                                       </td>
                                                                       <td>
                                                                           <?php echo $rows['Academic_Year']; ?>
                                                                       </td>
                                                                       <td>
                                                                           <?php echo $rows['std_phone']; ?>
                                                                       </td>
                                                                       <td>
                                                                           <?php echo $rows['batch_id']; ?>
                                                                       </td>
                                                                       <td>
                       <a style="cursor: pointer;" href="edit_student_details.php?std_prn=<?php echo $rows['std_PRN']; ?>">Edit</a>
                                                                       </td>
                                                                       <td>
                                                                           <a style="cursor: pointer;" onClick="confirmation(<?php echo $rows['id']; ?>)">Delete </a>
                                                                       </td>
                                                                   </tr>

                                              <?php	$i++;    } ?>





                         <?php   }  ?>






                  </tbody>

                  </table>

                   <!-- ------------------------------------------------------------  -->
                  </div>

                  </div>





                   <div class="row"  style="">

                   <div class="col-md-4">

               </div>

                  <div   align="center">

                       </div>

                  </div>

               </div>



                   </div>
                     </div>
                    </div>

                     <div class="row" >

                     <div class="col-md-4">

                     </div>

                      <div class="col-md-3" style="color:#FF0000;" align="center">





               			</div>
                         </div>
                          </div>



</body>

</html>

