<?php
$report="";

 include('Parent_header.php');
if(!isset($_SESSION['id']))
	{
		header('location:login.php');
	}
	echo $user_id=$_SESSION['id'];
	$id=$_GET['id'];

$rows=mysql_query("select * from tbl_student where std_PRN='$id'");
$value=mysql_fetch_array($rows);
$school_id=$value['school_id'];
$row1=mysql_query("select thanqu_flag from tbl_school_admin where school_id='$school_id'");
$value1=mysql_fetch_array($row1);
$flag=$value1['thanqu_flag'];

if(strpos($flag,'Pa')!="")
{

?>
 <?php
            
            if(isset($_POST['assign']))
				{
				
     				 $point=$_POST['point'];
                     $activity_id=$_POST['reason'];
	 				
					$arrs=mysql_query("select * from tbl_parent where Id='$user_id' ");
      				$arr=mysql_fetch_array($arrs);
					if($arr['balance_points']>=$point)
					{
						$balance_blue_points=$arr['balance_points']-$point;
						$assign_blue_points=$arr['distributed_purple']+$point;

						mysql_query("update tbl_parent set balance_points='$balance_blue_points',distributed_purple='$assign_blue_points' where Id='$user_id'");
						$assign_date=date('d/m/Y');
						
						
						
						$arrs1=mysql_query("select sc_stud_id from tbl_student_reward where sc_stud_id='$stud_id' and school_id='$school_id'");
						//$arr=mysql_fetch_array($arrs);
						if(mysql_num_rows($arrs1)>=1) 
						{	
							$prn=mysql_query("select purple_points from tbl_student_reward where sc_stud_id='$stud_id' and school_id='$school_id'");
							$arr1=mysql_fetch_array($prn);
							$t_balance_purple_points=$arr1['purple_points']+$point;
							mysql_query("update tbl_student_reward set purple_points='$t_balance_purple_points' where sc_stud_id='$stud_id' and school_id='$school_id'");
						}else
							{
							
								$I=mysql_query("INSERT INTO tbl_student_reward(sc_stud_id,sc_assigned_by,sc_date,purple_points,school_id) VALUES('$stud_id','$user_id','$assign_date','$point','$school_id')");
							}

						
						mysql_query("update tbl_student_reward set purple_points='$t_balance_purple_points' where sc_stud_id='$id' and school_id='$school_id'");
						
						$reason=mysql_query("select `sc_list` from `tbl_studentpointslist` where `sc_id`='$activity_id'");
						$arr11=mysql_fetch_array($reason);
						$point_given_reason=$arr11['sc_list'];
						
						mysql_query("insert into tbl_student_point(sc_stud_id,sc_studentpointlist_id,sc_entites_id,sc_point,point_date,reason,sc_teacher_id) values('$id','$activity_id','106','$point','$assign_date','$point_given_reason','$user_id')");
						$report= "You have assigned $point Purple points.";
						header("location:parent_assignpurplepoint_student.php?id=$id"); 
					 }
				 else
				 {
	 				 $report1= "You have insufficient balance to assign .";
				}
	            
	 
	}
	
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
 <link rel="stylesheet" href="css/bootstrap.min.css">


<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>

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
</style>
        

  
      <script>
function validate()
{
	var elem=document.forms['radioform'].elements['reason'];
	len=elem.length-1;
	chkvalue='';
	for(i=0; i<=len; i++)
	{
	if(elem[i].checked)chkvalue=elem[i].value;
	}
	if(chkvalue=='')
	{
	
	  document.getElementById('error').innerHTML="Please select reason";
	
	return false;
	}
	else
	{
	  document.getElementById('error').innerHTML="";
	}
	var value=document.getElementById('point').value;
	if(value=='' || value==null)
	{
	
		 document.getElementById('points').innerHTML="Please enter points";
		 return false;
	
	}
	regx=/^[0-9]*$/;
				//validation of points
				
			if(!regx.test(value))
				{
			
				
					document.getElementById('points').innerHTML='Please enter valid points';
					return false;
				}
		
			else
				{
					document.getElementById('points').innerHTML="";
				}
				
	return true;
}
</script>
  
</head>

<body>
    <div class="row" style="padding:10px;">
      <div class="col-md-4" >
        <div  class="panel panel-default" style="padding:10px;">
        
        <div class="panel panel-default" style="background-color:#FFFFFF ;">
        <?php $query=mysql_query("select balance_points from tbl_parent where Id='$user_id' ");
        $results=mysql_fetch_array($query);
        print_r($results);
        ?>
        <div class="row" align="center"><h3>Balance Points</h3></div>
        <div class="row" align="center"><h5 style="color: #40a4df;
        font-size: 30px;
        font-weight: bold;">
		<?php echo $results['balance_points'];?></h5>
        </div>
        <div class="row" align="center" style="padding-top:5px;"> <h4>Points </h4>
        
        
        </div>
       
        
        
        </div>
      
        <div class="row" style="font-size:20px;" align="center">
            <?php echo ucwords($value['std_complete_name']);?>
        </div>
         <div  class="panel panel-default" >
        <!--<div class=" panel-heading" style="font-size:24px;color:#32979a;font-weight:bold;" align="center">
        <div class="panel-title">Students</div>
        </div>-->
         <ul>
        <?php 
		
		$class=mysql_query("select * from tbl_division divs join tbl_class c on c.id=divs.class_id where c.teacher_id=$id");
		      while($class_value=mysql_fetch_array($class)){
			  $std_class=$class_value['class'];
			  $std_div=$class_value['division'];
			  $student=mysql_query("select * from tbl_student where parent_id='$user_id' and std_class='$std_class' and std_div='$std_div'");
			  $std=mysql_fetch_array($student);
			  ?>
              
         <div class="row" style="font-size:12px;padding-left:70px;" >
        <?php if($std['std_name']!=""){?> <li>
         <?php echo $std['std_name'];?>
       
        </li>
        <?php } }?>
       
        </ul>
        
       </div>
        <div  class="panel panel-default" >
       <!-- <div class=" panel-heading" style="font-size:24px;color:#32979a;font-weight:bold;" align="center">
        <div class="panel-title">Classes</div>
        </div>-->
         <ul>
        <?php 
		
		$class=mysql_query("select class,division from tbl_division divs join tbl_class c on c.id=divs.class_id where c.teacher_id='$id'");
		      while($class_value=mysql_fetch_array($class)){?>
              
         <div class="row" style="font-size:12px;padding-left:70px;" >
         <li>
          <?php if($class_value['division']!=""){echo $class_value['class']."-".$class_value['division'];}
		  else
		  {echo $class_value['class'];}?>
        </div></li>
        <?php }?>
        </ul>
       </div>
        
      <div  class="panel panel-default" style="">
        <!--<div class="panel-heading" style="font-size:24px;color:#32979a;font-weight:bold;" align="center">
          <div class="panel-title"> Subjects</div>
        </div>-->
        <ul>
       <?php 
		
		$class=mysql_query("select subject from  tbl_subject where teacher_id=$id");
		      while($class_value=mysql_fetch_array($class)){?>
         <div class="row" style="font-size:12px;padding-left:70px;" >
        <li>
		 <?php echo $class_value['subject'];?>
         </li>
        </div>
        <?php }?>
        </ul>
        </div>
    </div>
        </div>
        

<div class="container" style="padding-top:20px;width:100%;">
<div class="col-md-8"> 
    	<div class="panel panel-default" >
        <form method="post" name="radioform">
        <div class="row">
        <h3 style="margin-top:2px;color:#4A7B64;font-weight:bold;" align="center">Assign Purple Points to Student </h3>
        </div>
        <div class="row">
            <div class="col-md-4"  style="padding-left:25px;font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:bold;" >
            Student Name :
            </div>
			<div class="col-md-2">
		 <?php echo ucwords($value['std_complete_name']);?>
            </div>
          </div>
           <div class="row">
            <div class="col-md-4"  style="padding-left:25px;font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:bold;">
           Student PRN :</div>
			<div class="col-md-2">
		 <?php echo $value['std_PRN'];?>
            </div>
          </div>
           <div class="row">
            <div class="col-md-4" style="padding-left:25px;font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:bold;">
           School Name :</div>
			<div class="col-md-2" >
		 <?php echo $value['std_school_name'];?>
            </div>
          </div>
           
          
          
          <div class="row">
          <div class="col-md-4">
              <div align="left" style="padding:10px;font-size:16px"><b>Reason</b></div>
			  </div>
              </div>
            
			     <?php $row=mysql_query("select * from tbl_studentpointslist where school_id='$school_id'");
				     $i=0;
					 $count=mysql_num_rows($row);
					 ?>
                     
                     <?php
				        while($values=mysql_fetch_array($row))
						{
						
						 if($i%3==0)
						 {
						  ?>
                          <div class="row">
                          <?php 
						 }
						      
								?>
                                 <div class="col-md-1" align="right">
                              <input type="radio" value='<?php echo $values['sc_id'];?>' id='<?php echo  $i;?>' name="reason">
                                </div>
                                <div class="col-md-3" align="left">
                                <?php echo ucwords($values['sc_list']);?>
                                </div>
                                 
                                
                                <?php 
							 if($i%3==2 || $count==$i+1)
								 {
								  ?>
								  </div>
								  <?php 
								 }	
								$i++;
						
						}
						    
				 ?>
              
              <div class="row" style="padding:5px;">
                   <div class="col-md-8">
               <div align="center" style="padding:10px;font-size:16px;color:#FF0000;" id="error"></div>
               </div>
               </div>
          
              
               <div class="row" style="padding:5px;">
                   <div class="col-md-4">
               <div align="left" style="padding:10px;font-size:16px"> <b>Assign Points</b></div>
               </div>
                 
                   <div class="col-md-3">
               <input type="text" name="point" class="form-control" id="point"/>
               </div>
                 
                
               </div>
               
                 <div class="row" style="padding:5px;">
                   <div class="col-md-8">
               <div align="center" style="padding:10px;font-size:16px;color:#FF0000;" id="points"></div>
               </div>
               </div>
               
               <div class="row" >
               <div class="col-md-4"></div>
             <div class="col-md-2">   <input type="submit" class="btn btn-primary"  name="assign" value="Assign" onClick="return validate()"/></div>
                <div class="col-md-2" >
                <a href="parent_listof_student.php" style="text-decoration:none;"> <input type="button" class="btn btn-danger" name="back" value="Back"/></a>
                </div>
               </div>
               <div id="error" style="color:#007f00;font-weight:bold; padding-top:20px;">
				 <div class="col-md-9 " align="center">
				 <?php echo $report;?>
				  </div>
				</div>
				 <div id="error" style="color:#FF0000;font-weight:bold; padding-top:20px;">
				<div class="col-md-9 " align="center">
				 <?php echo $report1;?>
				  </div>
				</div>
				
              <?php 
			 /*  if($report!="")
			  {
			   echo $report;
			  }
			  
			  else if(isset($_GET['report']))
						{
						echo $_GET['report'];
	                    
						} */
                       ?>
                       
               </div>
              
            </form>
           
	
            </div>
            
        </div>

        </div>
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
            
            
         
            
            
            
            
            
            
            
            
            </div>
    
		       </div>
       
       </div>
<?php
}

else
{
?>
<div class="panel panel-default" style="padding:30px;">
<div class="panel-heading" style="color:#FF0000;height:400px;" align="center">
<h4>You do not permission  assign blue points to teacher</h4>
</div>

</div>
<?php
}
?>
</body>
</html>      
 