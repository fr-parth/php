<?php
 
 include("conn.php");
 include("header.php");
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
 <script>
$(document).ready(function() {

    $('#example').dataTable( {
      
    } );
} );



function confirmation(xxx,yyy) {

    var answer = confirm("Are you sure you want to delete?")
    if (answer){
        
        window.location = "delete_teachersubject.php?subid="+xxx+"&sc_id="+yyy;
    }
    else{
       
    }
}


function confirmation1(xxx,yyy) {



    var answer = confirm("Are you sure you want to delete?")
    if (answer){
        
        window.location = "delete_classanddivision.php?classid="+xxx+"&divid="+yyy;
    }
    else{
       
    }
}



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




</style>



    	
   <body style="background: none repeat scroll 0% 0% #E9E9E9;text-shadow: none;">

   <div class="row" style="padding-top:20px; padding-left:20px;">
   <div class="col-md-3 ">
    <div class="container" style="border:1px solid #CCCCCC; background-color:#FFFFFF;">
              <div class="row" style="background-image:url(image/Interior%20design%20background%20-%20red%2001.jpg); padding-left:5px; padding-right:5px; color:#FFFFFF;">
               <div class="col-md-8">
             
             
                    My Profile
                    </div>
                </div>
   
              
                 
                 <div class="row" align="center"  style="padding-top:10px;">
                 <div  style=" font-size:16px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold;"><?php echo $value['t_name']?> <?php echo $value['t_lastname']?></div></div>
                 <div class="row"  align="center"  >
                  <div  style="color:#308C00;font-size:34px;font-weight:bold;  font-family:"Arial,Verdana,sans-serif"";><?php echo $value['tc_balance_point'];?></div>
                  </div>
                  <div class="row" align="center" >
                  <div style="color:#0101DF;font-size:16px;font-family:"Times New Roman", Times, serif">Balance Points</div></div>
                </div>
                 <div class="container" style="height:5px;"></div>
                
                   <div class="container" style=" border:1px solid #CCCCCC; background-color:#FFFFFF;">
                 <div style="padding:5px;font-weight:bold;color:#990000">
                    My Subjects &nbsp;&nbsp;</div>
                 
                <div style="height:5px;"></div>
                    
                    
                    <table class="alternate_color">
                     
                    <tr  style="background-color:#003399;color:#FFFFFF; color:#FFFFFF;"><th style="width:50px;" >Sr.No</th><th style="width:200px;">Subject</th><th></th></tr>
                        <?php
							$i=0;
					
							$arr = mysql_query("select subjectName,subjcet_code from tbl_teacher_subject_master where teacher_id='$t_id' and school_id='$sc_id'");
							while($row = mysql_fetch_array($arr))
							{
							$i++;
							$subjcet_code=$row['subjcet_code'];
						?>
                                <tr  onmouseover="this.style.cursor='pointer';this.style.textDecoration='underline';this.style.color='dodgerblue'" onmouseout="this.style.textDecoration='none';this.style.color='black';"  onclick="window.location='dashboard_teacher.php?subject_code=<?php echo $subjcet_code;?>'"class="d0" style="padding-top:2px;"><td align="center"><?php echo $i;?></td><td align="left"><?php 
						
						
						echo $row['subjectName'];
						?></td>
                        
                        <?php
							$sql3=mysql_query("select stud_sub_id from tbl_student_subject_master where subjcet_code='$subjcet_code' and school_id='$sc_id' ");
							$count=mysql_num_rows($sql3);
							
                        ?>
                        <td>
                      <span class="badge"><?php echo $count;?></span></td>
                        
                   
                        </tr>
                        
                        
                        <?php
							}
						?>
                    </table>
                    </div>
                    <div class="container" style="height:5px;"></div>
                                         <div  class="container" style=" padding:5px; border:1px solid #CCCCCC; background-color:#FFFFFF;">
                <div style="padding:5px;font-weight:bold;color:#990000">
                    My Classes &nbsp;&nbsp; <a href="addclass.php" style="text-decoration:none">   <input type="button" value="Add" name ="add" id="add" style="width:50px; height:20px; font-size:12px; border:1px solid #CCCCCC;"/></a>
                </div>
                    
                    <div style="height:5px;"></div>
                   
                 
                    <table class="alternate_color">
                    	<tr  style="background-color:#003399;color:#FFFFFF; color:#FFFFFF;"><th style="width:120px;" >Sr.No</th><th style="width:150px;">Class</th><th style="width:200px;">Division</th><th>Delete</th>
                        
                       
                        </tr>
                        <?php
							$i=0;


							
							$arr=mysql_query("SELECT * FROM `tbl_division` WHERE  teacher_id='$teacher_id' order by class_id");
							while($row = mysql_fetch_array($arr))
							{
					
							$classid=$row['class_id'];
							$divid=$row['division'];
							$test=mysql_query("select class from tbl_school_class where id='$classid'");
							$s=mysql_fetch_array($test);
							if($divid!="")
							{
							$test1=mysql_query("select division from tbl_school_division where id='$divid' and school_id='$sc_id'");
							$s1=mysql_fetch_array($test1);
							$division=$s1['division'];
							}
							else
							{
							$divid=0;
							$division="";
							}
							
							$i++;
						?>
                        <tr class="d0"><td align="center"><?php echo $i;?></td><td><?php echo $s['class'];?></td>
                        <td><?php echo $division;?></td>
                        
    <td><a onClick="confirmation1(<?php echo $classid;?>,<?php echo $divid; ?>)"style="text-decoration:none"><img src="images/trash.png" alt="" title="" border="0" />
    </a></td>
                        
                        </tr>
                        <?php
							}
						?>
                    </table>
                   
                   
                   
                   
                   
                </div>
                    
                    
                    
                
                
                
                </div>
                
                
                   
      
      
    <div  class="col-md-9" style="border:1px solid #CCCCCC; background-color:#FFFFFF;">
    
    <div class="row">
                  
                     <div class="col-md-12" style=" background-image:url(image/images_.jpg); color:#FFFFFF; ">
                   My Students
                   </div>
                   </div>
                   
                   
                   
                     
      
    
     
    
        
        
        
        <?php 
		
		
		if(isset ($_GET['subject_code']))
		
		{
		if($_GET['subject_code']!="ALL")
		
		{
		$subject_id=$_GET['subject_code'];
		?>
                               <div id="no-more-tables" style="padding-top:20px;">
             
             
  <table id="example" class="col-md-12 table-bordered table-striped "  align="center">
           
        	
        			
        				<thead>
        			<tr style="style=padding-top:15px;">
                	<th>Sr. No.</th>
                    <th>
                      Student Name
                    </th>
                       
                    <th>Subject Name</th>
                    <th>Green Points</th>
                    <th>Assign Points</th>
                        <th>Student Details</th>
                         <th>Student Coordinator</th>
                    
                </tr>
                </thead>
                <tbody>
             <?php $i=1;
			 
			
			
	
			$rowall2=mysql_query("select subjcet_code from tbl_teacher_subject_master where subjcet_code='$subject_id' and school_id='$sc_id' ");
		while($result=mysql_fetch_array($rowall2))
		{
			$subject_code=$result['subjcet_code'];
		
		
		$sql4=mysql_query("select subjectName,student_id,stud_sub_id from tbl_student_subject_master where subjcet_code='$subject_code' and school_id='$sc_id' ");
while($test1=mysql_fetch_array($sql4))
{
$count1=mysql_num_rows($sql4);
if($count1!=0)
{
		

		
 ?>
<tr style="padding:10px;"  >
<td style="padding:10px;"><?php echo $i;   ?></td>

<td style="padding:10px;"><?php



$std_PRN=$test1['student_id'];

$sql2=mysql_query("select id,std_name,std_lastname from tbl_student where std_PRN='$std_PRN' and school_id='$sc_id'");
$test2=mysql_fetch_array($sql2);
$std_name=$test2['std_name']." ".$test2['std_lastname'];
$std_id=$test2['id'];
 echo $std_name; ?></td>


<td style="padding:10px;"><?php echo $test1['subjectName'];?></td>

    


    <?php
	$arra=mysql_query("select sc_total_point  from  tbl_student_reward where sc_stud_id ='$std_id'");
	$test=mysql_fetch_array($arra);
	?>
    
<td style="padding:10px;"><?php  if($test['sc_total_point']=='')
{
echo 0;
}
else
{
echo $test['sc_total_point'];
};?></td>
 <td style="padding:10px;"><a href="assign_point.php?id=<?php echo $test2['id'];?>" style="text-decoration:none;"><input type="button" class="myButton" value="Assign" /></a></td>
 <td style="padding:10px;"> <a href="details_point.php?id=<?php echo $test2['id'];?>" style="text-decoration:none;"><input type="button" class="myButton" value="View Details"/></a></td>
  <td >
  
  
  <?php
 $stud_id=$test2['id'];

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


<?php  $i++;}}} ?>
</tbody>
</table>
</div>
 <?php }else
		{?>
		
		<div id="no-more-tables" style="padding-top:20px;">
             
             
  <table id="example" class="col-md-12 table-bordered table-striped "  align="center">
           
        	
        			
        				<thead>
        			<tr style="style=padding-top:15px;">
                	<th>Sr. No.</th>
                    <th>
                      Student Name
                    </th>
                       
                    <th>Subject Name</th>
                    <th>Green Points</th>
                   
                     <th>Assign Points</th>
                        <th>Student Details</th>
                         <th>Student Coordinator</th>
                </tr>
                </thead>
                <tbody>
             <?php $k=1;
			 
			
			
	$rowall3=mysql_query("select subjcet_code from tbl_teacher_subject_master where teacher_id='$t_id' and school_id='$sc_id' ");	
			
	
	while($result3=mysql_fetch_array($rowall3))
	{
			$subject_code3=$result3['subjcet_code'];
			
	
	
				$sql3=mysql_query("select student_id,stud_sub_id from tbl_student_subject_master where subjcet_code='$subject_code3' and school_id='$sc_id' order by student_id  ");
while($test1=mysql_fetch_array($sql3))
{
$count3=mysql_num_rows($sql3);

if($count3!=0)
{
		
	$rowall4=mysql_query("select subjectName,student_id from tbl_student_subject_master where subjcet_code='$subject_code3' and school_id='$sc_id' order by student_id ");	

 while($result4=mysql_fetch_array($rowall4)){ 

 

 ?>
<tr style="padding:10px;" align="center" >
<td style="padding:10px;"><?php echo $k;   ?></td>

<td style="padding:10px;"><?php

$std_PRN=$result4['student_id'];

$sql3=mysql_query("select id,std_name,std_lastname from tbl_student where std_PRN='$std_PRN' and school_id='$sc_id'");
$test2=mysql_fetch_array($sql3);
$std_id=$test2['id'];
$std_name=$test2['std_name']."  ".$test2['std_lastname'];

 echo $std_name; ?></td>
 
 


<td style="padding:10px;"><?php echo $result4['subjectName'];?></td>

    <?php

	$arra=mysql_query("select sc_total_point  from  tbl_student_reward where sc_stud_id ='$std_id'");
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
 <td style="padding:10px;"><a href="assign_point.php?id=<?php echo $test2['id'];?>" style="text-decoration:none;"><input type="button" class="myButton" value="Assign" /></a></td>
 <td style="padding:10px;"> <a href="details_point.php?id=<?php echo $test2['id'];?>" style="text-decoration:none;"><input type="button" class="myButton" value="View Details"/></a></td>
 
  <td >
  
  
  <?php
 $stud_id=$test2['id'];
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
  
 

  






 

</div>
		<?php $k++; }}}}
		}?>
		
		</tr>
</tbody>
</table>
		
		
		
		
	<?php	
		}
		
		else
		{
		
		?>
		
		
		<div id="no-more-tables" style="padding-top:20px;">
             
             
  <table id="example" class="col-md-12 table-bordered table-striped "  align="center">
           
        	
        			
        				<thead>
        			<tr style="style=padding-top:15px;">
                	<th>Sr. No.</th>
                    <th>
                      Student Name
                    </th>
                       
                    <th>Subject Name</th>
                    <th>Green Points</th>
                      <th>Assign Points</th>
                        <th>Student Details</th>
                    <th>Student Coordinator</th>
                    
                </tr>
                </thead>
                <tbody>
             <?php $j=1;
			 
			
			
	$rowall3=mysql_query("select subjcet_code from tbl_teacher_subject_master where teacher_id='$t_id' and school_id='$sc_id' ");	
			
	
	while($result3=mysql_fetch_array($rowall3))
	{
			$subject_code3=$result3['subjcet_code'];
			
	
	
				$sql3=mysql_query("select stud_sub_id from tbl_student_subject_master where subjcet_code='$subject_code3' and school_id='$sc_id' ");
while($test1=mysql_fetch_array($sql3))
{
$count3=mysql_num_rows($sql3);

if($count3!=0)
{
		
	$rowall4=mysql_query("select subjectName,student_id from tbl_student_subject_master where subjcet_code='$subject_code3' and school_id='$sc_id' ");	

 while($result4=mysql_fetch_array($rowall4)){ 

 

 ?>
<tr style="padding:10px;" align="center" >
<td style="padding:10px;"><?php echo $j;   ?></td>

<td style="padding:10px;"><?php

$std_PRN=$result4['student_id'];

$sql3=mysql_query("select id,std_name,std_lastname from tbl_student where std_PRN='$std_PRN' and school_id='$sc_id'");
$test2=mysql_fetch_array($sql3);
$std_id=$test2['id'];
$std_name=$test2['std_name']."  ".$test2['std_lastname'];

 echo $std_name; ?></td>
 
 


<td style="padding:10px;"><?php echo $result4['subjectName'];?></td>

    <?php

	$arra=mysql_query("select sc_total_point  from  tbl_student_reward where sc_stud_id ='$std_id'");
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
 <td style="padding:10px;"><a href="assign_point.php?id=<?php echo $test2['id'];?>" style="text-decoration:none;"><input type="button" class="myButton" value="Assign" /></a></td>
 <td style="padding:10px;"> <a href="details_point.php?id=<?php echo $test2['id'];?>" style="text-decoration:none;"><input type="button" class="myButton" value="View Details"/></a></td>
 
  <td >
  
  
  <?php
 $stud_id=$test2['id'];
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
  
 

  






 

</div>
		<?php $j++; }}}}
		}
        
		
		?>
        
         </div>
      <?php 

}
else
{

header('location:login.php');


}
?>  
   
   
  

       