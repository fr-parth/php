<?php
 include("smartcookiefunction.php");
  include_once("header.php");
if(isset($_SESSION['id']))
{
//echo "select * from tbl_user where t_email = '".$_SESSION['username']."' and t_password = '".$_SESSION['password']."'";
$query = mysql_query("select * from tbl_teacher where id = ".$_SESSION['id']);
$value = mysql_fetch_array($query);
$sc_id=$value['school_id'];
$teacher_id=$value['id'];
$t_id=$value['t_id'];

$report= "Could not find!!!!";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="//cdn.datatables.net/1.10.4/css/jquery.dataTables.css" rel="stylesheet" type="text/css"></link>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/accordian.js"></script>
<script>
$(document).ready(function() {

    $('#example').dataTable( {
      
    } );
} );





function makecoordinate(xx)
{

 var answer = confirm("Are you sure you want to make this student Coordinator?")
    if (answer){
        
        window.location = "make_coordinator.php?id="+xx;
    }
    else{
       
    }
}


</script>
<title>Smart Cookies</title>
</head>
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
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;
		text-align:left;
		
	}
 
	/*
	Label the data
	*/
	#no-more-tables td:before { content: attr(data-title); }
}



.myButton {
	-moz-box-shadow: 0px 0px 0px 2px #9fb4f2;
	-webkit-box-shadow: 0px 0px 0px 2px #9fb4f2;
	box-shadow: 0px 0px 0px 2px #9fb4f2;
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #7892c2), color-stop(1, #476e9e));
	background:-moz-linear-gradient(top, #7892c2 5%, #476e9e 100%);
	background:-webkit-linear-gradient(top, #7892c2 5%, #476e9e 100%);
	background:-o-linear-gradient(top, #7892c2 5%, #476e9e 100%);
	background:-ms-linear-gradient(top, #7892c2 5%, #476e9e 100%);
	background:linear-gradient(to bottom, #7892c2 5%, #476e9e 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#7892c2', endColorstr='#476e9e',GradientType=0);
	background-color:#7892c2;
	-moz-border-radius:10px;
	-webkit-border-radius:10px;
	border-radius:10px;
	border:1px solid #4e6096;
	display:inline-block;
	cursor:pointer;
	color:#ffffff;
	
	text-decoration:none;
	text-shadow:0px 1px 0px #283966;
}
.myButton:hover {
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #476e9e), color-stop(1, #7892c2));
	background:-moz-linear-gradient(top, #476e9e 5%, #7892c2 100%);
	background:-webkit-linear-gradient(top, #476e9e 5%, #7892c2 100%);
	background:-o-linear-gradient(top, #476e9e 5%, #7892c2 100%);
	background:-ms-linear-gradient(top, #476e9e 5%, #7892c2 100%);
	background:linear-gradient(to bottom, #476e9e 5%, #7892c2 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#476e9e', endColorstr='#7892c2',GradientType=0);
	background-color:#476e9e;
}
.myButton:active {
	position:relative;
	top:1px;
}


#cssmenu ul ul {
  display: none;
  background: #fff;
  
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





    	
   <body style="background: none repeat scroll 0% 0% #E9E9E9;text-shadow: none;">

   <div class="row" style="padding-top:20px; padding-left:20px;">
   <div class="col-md-12">
   <div class="col-md-3 ">
<?php include 'dashboard.inc.php';?>
              </div>

      <?php 
	  if(isset($_GET['subject_code']))
	  
	  {
      
      
      $subject_code=$_GET['subject_code'];
	 
	 $arr=explode(",",$subject_code);
	 $sub_code=$arr[0];
	 $branch=$arr[1];
	 $semester=$arr[2];?>
     
     
      <div  class="col-md-9" style="border:1px solid #CCCCCC; background-color:#FFFFFF;">
    
    <div class="row" align="center">
                  
            <div class="col-md-12" style="padding:7px 0px 7px 7px; background-color:#333333; color:#FFFFFF;">
                   My Students
                   </div>
                   </div>
                   
                   
                   
                     
       <div class="row" align="center" style="padding-top:10px;">
       
     <h4> Branch Name: <?php echo $branch;?>, <?php echo $semester;?></h4> </div>
     
          <?php  
		  
		  $query=mysql_query("select subjectName from tbl_student_subject_master where subjcet_code='$sub_code'");
		  
		  $testresult=mysql_fetch_array($query);
		  
		  
		  ?>           
       <div class="row" align="center" style="padding-top:-1px; border-bottom:1px solid #ccc; padding-bottom:12px;">
       
     <h4> Subject Name: <?php echo $testresult['subjectName'];?> </h4></div>
      
    
        
        
        
  
		
		<div id="no-more-tables" style="padding-top:20px;">
             
             
  <table id="example" class="table-bordered table-striped "  align="center" style="border:none;">
           
        	
        			
        				<thead>
        			<tr style="style=padding-top:15px;">
                	<th>Sr. No.</th><th>Image</th>
                    <th>
                      Student Name
                    </th>
                       
                    <th>Division</th>
                     <th>Branch</th>
                    <th>Green Points</th>
                      <th>Assign Points</th>
                        <th>Student Details</th>
                    <th>Student Coordinator</th>
                    
                </tr>
                </thead><tbody>
               
             <?php $j=1;
			
			
			 $sql=mysql_query("SELECT distinct ss.student_id,ss.subjectName,ss.Branches_id,ss.Division_id,std_complete_name,std_name,std_lastname,std_img_path,std_Father_name,tbl_student.id FROM tbl_student_subject_master ss left outer  join`tbl_teacher_subject_master` st on ss.`subjcet_code`=st.subjcet_code inner join tbl_academic_Year Y on st.AcademicYear=Y.Year and Y.Enable='1' inner join tbl_semester_master s on s.Semester_Name=st.Semester_id and st.Branches_id=s.Branch_name and s.CourseLevel=st.CourseLevel left outer join tbl_student on std_PRN=ss.student_id  WHERE ss.`teacher_id` ='$t_id' and ss.school_id='$sc_id' and ss.Semester_id='$semester'  and ss.Branches_id='$branch' and ss.subjcet_code='$sub_code' order by std_name");
			 
	

 while($result4=mysql_fetch_array($sql)){ 

 

 ?>
<tr style="padding:10px;"  >
<td style="padding:10px;"><?php echo $j;   ?></td>
<td style="padding:10px;"><?php //if($result4['std_img_path'] != ''){?>
                
                <?php //}else {?> <img src="image/avatar_2x.png"  style="border:1px solid #CCCCCC; width:70px;height:70px;" class="preview" alt=" " title="student image"/> <?php //}?></td>

<td style="padding:10px;"><?php

$std_PRN=$result4['student_id'];



 $std_name=$result4['std_complete_name']; 
 
 
 if($std_name=="")
 {
 
 echo $result4['std_name']." ".$result4['std_Father_name']." ".$result4['std_lastname'];
 }
 else
 {
 
echo $std_name;
 }
 
 ?></td>
 
 


<td style="padding:10px;"><?php echo $result4['Division_id'];?></td>
<td style="padding:10px;"><?php echo $result4['Branches_id'];?></td>


    <?php

	$arra=mysql_query("select sc_total_point  from  tbl_student_reward where sc_stud_id ='$std_PRN'");
	$test3=mysql_fetch_array($arra);
	?>
    
<td style="padding:10px;"><?php  if($test3['sc_total_point']=='')
{
echo 0;
}
else
{
echo $test3['sc_total_point'];
};?></td>
 <td style="padding:10px;"><a href="assign_point.php?id=<?php echo $std_PRN;?>" style="text-decoration:none;"><input type="button" class="myButton" value="Assign" /></a></td>
 <td style="padding:10px;"> <a href="details_point.php?id=<?php echo $std_PRN;?>" style="text-decoration:none;"><input type="button" class="myButton" value="View Details"/></a></td>
 
  <td >
  
  
  <?php
 $stud_id=$result4['id'];
//echo "select status from tbl_coordinator where stud_id = '$stud_id' ";die;
 $query=mysql_query("select status from tbl_coordinator where stud_id = '$stud_id' ");
$result1=mysql_fetch_array($query);
$thanqu_flag=$result1['status'];

 if($thanqu_flag =="Y")
 {
 ?>
 <input type="checkbox" class="form-control" id="coordinator" name="coordintor"  checked="checked" disabled/>

<?php }
else
{?>
<input type="checkbox" class="form-control" id="coordinator" name="coordintor" onclick="makecoordinate(<?php echo $stud_id;?>)" />
<?php }?>
  
 </td>
  
 

  

</tr>

</div>
		<?php $j++; }
		
        
		
		?>
        
        </tbody>
</table>
         
         </div>
	 

	 
	 <?php }
	  
	 else
	 {?>
	 
	 
	 
	 
	 <div  class="col-md-9" style="border:1px solid #CCCCCC; background-color:#FFFFFF;">
    
    <div class="row">
                  
                     <div class="col-md-12" style=" background-color:#333333; padding:7px 0px 7px 7px; color:#FFFFFF; ">
                   My Students
                   </div>
                   </div>
                   
                   
                   
                     
       
     
    
        
        
        
  
		
		<div id="no-more-tables" style="padding-top:0px;">
             
             
  <table id="example" class="col-md-12 table-bordered table-striped " style="border:none;" align="center">
           
        	
        			
        				<thead>
        			<tr style="style=padding-top:15px;">
                	<th>Sr. No.</th>
                    <th>Image</th>
                     <th>
                      Student Name
                    </th>
                    <th>Division</th>
                     <th>Branch</th>
                    <th>Green Points</th>
                      <th>Assign Points</th>
                        <th>Student Details</th>
                    <th>Student Coordinator</th>
                    
                </tr>
                </thead><tbody>
               
             <?php $j=1;
			 
		



				
	$rowall4=mysql_query("SELECT distinct ss.student_id,ss.subjectName,ss.Branches_id ,std_img_path,ss.Division_id,std_complete_name,std_name,std_lastname,std_Father_name,tbl_student.id FROM tbl_student_subject_master ss left outer  join`tbl_teacher_subject_master` st on ss.`subjcet_code`=st.subjcet_code inner join tbl_academic_Year Y on ss.AcademicYear=Y.Year and Y.Enable='1' inner join tbl_semester_master s on s.Semester_Name=st.Semester_id and st.Branches_id=s.Branch_name and s.CourseLevel=st.CourseLevel left outer join tbl_student on std_PRN=ss.student_id WHERE ss.`teacher_id` ='$t_id' and ss.school_id='$sc_id'  ORDER BY  std_name  ");	

 while($result4=mysql_fetch_array($rowall4)){ 

 

 ?>
<tr style="padding:10px;"  >
<td style="padding:10px;"><?php echo $j;   ?></td>
<td style="padding:10px;"><?php if($result4['std_img_path'] != ''){?>
                <img src="<?php echo $result4['std_img_path'];?>" class="preview" style=" width:70px;height:70px;" alt="" />
                <?php }else {?> <img src="image/avatar_2x.png"  style="border:1px solid #CCCCCC; width:70px;height:70px;" class="preview" alt="" title="student image"/> <?php }?></td>

<td style="padding:10px;"><?php

$std_PRN=$result4['student_id'];


$std_full_name=$result4['std_complete_name'];

if($std_full_name=="")
{

$name=$result4['std_name']." ".$result4['std_Father_name']." ".$result4['std_lastname'];

echo $name;
}

else
{

 echo $std_full_name;
 
 
 
 } ?></td>
 
 


<td style="padding:10px;"><?php echo $result4['Division_id'];?></td>
<td style="padding:10px;"><?php echo $result4['Branches_id'];?></td>


    <?php

	$arra=mysql_query("select sc_total_point  from  tbl_student_reward where sc_stud_id ='$std_PRN'");
	$test3=mysql_fetch_array($arra);
	?>
    
<td style="padding:10px;"><?php  if($test3['sc_total_point']=='')
{
echo 0;
}
else
{
echo $test3['sc_total_point'];
};?></td>
 <td style="padding:10px;"><a href="assign_point.php?id=<?php echo $std_PRN;?>" style="text-decoration:none;"><input type="button" class="myButton" value="Assign" /></a></td>
 <td style="padding:10px;"> <a href="details_point.php?id=<?php echo $std_PRN;?>" style="text-decoration:none;"><input type="button" class="myButton" value="View Details"/></a></td>
 
  <td >
  
  
  <?php
 $stud_id=$result4['id'];
//echo "select status from tbl_coordinator where stud_id = '$stud_id' ";die;
 $query=mysql_query("select status from tbl_coordinator where stud_id = '$stud_id' ");
$result1=mysql_fetch_array($query);
$thanqu_flag=$result1['status'];

 if($thanqu_flag =="Y"){?>
 <input type="checkbox" class="form-control" id="coordinator" name="coordintor"  checked="checked" disabled/>

<?php }
else
{?>
<input type="checkbox" class="form-control" id="coordinator" name="coordintor" onclick="makecoordinate(<?php echo $stud_id;?>)" />
<?php }?>
  
 </td>
  
 

  

</tr>





 

</div>
		<?php $j++; }}
		
        
		
		?>
        
        </tbody>
</table>
         
         </div>
	 
	 	  </div>
	 
	  </div>
	 
	 
	 
	 
	 
	 
	 
	 
<?php	 
	  
	  
	  

}
else
{

header('location:login.php');


}
?>  
   
   
  

       