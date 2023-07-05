
<?php 
error_reporting(0);
$star_count=0;
include('scadmin_header.php');
$id=$_SESSION['id'];
           $fields=array("id"=>$id);
		   $table="tbl_school_admin";
		   
		   $smartcookie=new smartcookie();
		   
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$school_id=$result['school_id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
 <link rel="stylesheet" type="text/css" href="css/student_dashboard_test.css">
       <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
		<script src="js/jquery-1.11.1.min.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
  
    
 <style>
.board
{
color: #efebeb;
font-size: 18px;
font-weight: bold;
font-family: Garamond, serif;
font-style: oblique;
text-decoration: inherit;
-moz-box-shadow: inset 0px 0px 7px 0px #000000;
-webkit-box-shadow: inset 0px 0px 7px 0px #000000;
box-shadow: inset 0px 0px 7px 0px #000000;


}
</style>
<script>
   function create(option)
{
 var option=document.getElementById('option').value;
   document.getElementById('1').innerHTML='';
  var school_id=document.getElementById('school').value;

if(option=="class")
{
 

 
  
        if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
			
			
			var classes=xmlhttp.responseText;
			
		  class_array=classes.split(',');
		var selectHTML = "";
		selectHTML='<div class="col-md-2" ><select name="class" class="form-control">';
		
		for(var i=0;i<class_array.length;i++)
		{
		if(class_array[i]!='')
		{
		selectHTML+='<option value="'+ class_array[i]+'">'+class_array[i] +'</option> ';
		}
		}
		selectHTML+="</select></div>";
			document.getElementById('1').innerHTML=selectHTML;
          }
          }
		 
		  
        xmlhttp.open("GET","get_school.php?school_id="+school_id+"&type=class",true);
        xmlhttp.send();
}
if(option=="subject")
{


 
  
        if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
			
			
			var subject=xmlhttp.responseText;
					
		    subject_array=subject.split(',');
			
				var selectHTML = "";
				selectHTML='<div class="col-md-4" ><select name="subject" class="form-control">';
				
				for(var i=0;i<subject_array.length;i++)
				{
				if(subject_array[i]!='')
				{
				selectHTML+='<option value="'+ subject_array[i]+'">'+subject_array[i] +'</option> ';
				}
				}
				selectHTML+="</select></div>";
					document.getElementById('1').innerHTML=selectHTML;
				  }
				  }
		 
		  
        xmlhttp.open("GET","get_school.php?school_id="+school_id+"&type=subject",true);
        xmlhttp.send();
}
if(option=="activity")
{


 
  
        if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
			
			
			var activity=xmlhttp.responseText;
					
		    activity_array=activity.split(',');
			
				var selectHTML = "";
				selectHTML='<div class="col-md-4" ><select name="activity" class="form-control">';
				
				for(var i=0;i<activity_array.length;i++)
				{
				if(activity_array[i]!='')
				{
				selectHTML+='<option value="'+ activity_array[i]+'">'+activity_array[i] +'</option> ';
				}
				}
				selectHTML+="</select></div>";
					document.getElementById('1').innerHTML=selectHTML;
				  }
				  }
		 
		  
        xmlhttp.open("GET","get_school.php?school_id="+school_id+"&type=activity",true);
        xmlhttp.send();
}

}


</script>
        
</head>

<body >
<div class="row" style="padding:10px;">
<form method="post">
<div class="col-md-2">
<input type="hidden" id="school" value="<?php echo  $school_id;?>" />
</div>
  <div class="col-md-3 ">
<select name="option" id="option" class="form-control" onChange="create(this.value)"><option value="select">Select</option><option value="class">Class</option><option value="subject">Subject</option><option value="activity">Activity</option></select>
</div>
<div  id="1">

</div>
<div class="col-md-3 " id="1">
<input type="submit" class="btn" value="Search" name="search" />
</div>
</form>
</div>
 <body style= "background: none repeat scroll 0% 0% transparent;border: 0px none; margin: 0px; outline: 0px none; padding: 0px;">


<?php 
if(isset($_POST['search']))
{
$option=$_POST['option'];
if($option=="subject")
{
 $subject=trim($_POST['subject']);?>
<div class="row"><div class="col-md-offset-1"><h3><?php echo "Top 10 of ".$subject." subject";?></h3></div></div>
<?php

$row=mysql_query("SELECT sub.id,sc_stud_id,std_name,std_img_path, SUM( sc_point ) as total
FROM tbl_student_point stp
JOIN tbl_subject sub ON sub.id = stp.sc_studentpointlist_id
JOIN tbl_student s ON s.id = stp.sc_stud_id
WHERE sub.subject LIKE  '$subject'
AND sub.teacher_id !=0
AND sub.school_id =  '$school_id' and activity_type='subject'
GROUP BY sc_stud_id
ORDER BY total DESC limit 10 ");
if(mysql_num_rows($row)<=0)
{
?>
<div class="row"><div class="col-md-offset-3" style="color:#FF0000;">
<h3>
<?php
echo "Record not found";
?>
</h3>
</div>
</div>
<?php
}



}
if($option=="class")
{
$class=trim($_POST['class']);
?>
<div class="row"><div class="col-md-offset-1"><h3><?php echo "Top 10 of ".$class." class";?></h3></div></div>
<?php

$row=mysql_query("select std_img_path,s.id,s.std_name,sc_total_point as total from tbl_student s  join tbl_student_reward re on s.id=re.sc_stud_id where school_id='$school_id' and std_class like'$class' ORDER BY sc_total_point DESC limit 10");
		if(mysql_num_rows($row)<=0)
		{
		?>
		<div class="row"><div class="col-md-offset-3" style="color:#FF0000;"><h3>
		<?php
		echo "Record not found";
		?>
		</h3></div></div>
		<?php
		}
}

if($option=="activity")
{
$activity=trim($_POST['activity']);
?>
<div class="row"><div class="col-md-offset-1"><h3><?php echo "Top 10 of ".$activity." activity";?></h3></div></div>
<?php


$row=mysql_query("select std_img_path,s.id,s.std_name,sc_stud_id,sc_studentpointlist_id,sum(sc_point)as total from tbl_student_point stp join tbl_studentpointslist sp on sc_id=stp.sc_studentpointlist_id join tbl_student s on  s.id=sc_stud_id where activity_type='activity' and sc_list like'$activity' and sp.school_id ='$school_id' Group BY sc_stud_id");
		if(mysql_num_rows($row)<=0)
		{
		?>
		<div class="row"><div class="col-md-offset-3" style="color:#FF0000;"><h3>
		<?php
		echo "Record not found";
		?>
		</h3></div></div>
		<?php
		}
}
}
else
{
?>
<div class="row"><div class="col-md-offset-1"><h3><?php echo "Top 10 of School";?></h3></div></div>
<?php
$row=mysql_query("select std_img_path,s.id,s.std_name,sc_total_point as total from tbl_student s join tbl_student_reward re on s.id=re.sc_stud_id where school_id='$school_id' GROUP BY sc_stud_id ORDER BY total DESC limit 10");
if(mysql_num_rows($row)<=0)
{
?>
<div class="row"><div class="col-md-offset-3" style="color:#FF0000;"><h3>
<?php
echo "Record not found";
?>
</h3></div></div>
<?php
}
}


  ?>

<div class="container" style="padding:10px;">

          
     
                 
               
       
          
        
                  
                     <?php  
       						
                         
                     if(mysql_num_rows($row)>0)
					 {      
                    $i=0;
                 
                       while($val=mysql_fetch_array($row))
     {
  
  
  $sc_total_point=$val['total'];

                        $i++;
                        
                        if($i%4==1){?>
                        <div class="row">
                        <?php }?>
                        <div class="col-md-2 col-md-offset-1" style="
height: 200px;

border: 13px #c08430 groove;

background-color: #325238;


color: #efebeb;
font-size: 18px;
font-weight: bold;
font-family: Garamond, serif;
font-style: oblique;
text-decoration: inherit;
-moz-box-shadow: inset 0px 0px 7px 0px #000000;
-webkit-box-shadow: inset 0px 0px 7px 0px #000000;
box-shadow: inset 0px 0px 7px 0px #000000;">
                        
                            <div class="row">
                            <?php
							$star_count=0;
							 $rows=mysql_query("select * from star_table");
								while($values=mysql_fetch_array($rows))
								{
								   $from=$values['from'];
								   $to=$values['to'];
								   if($to!=0)
								   {
									 if($from<=$sc_total_point && $to>=$sc_total_point)
									 {
											$star_count=$values['star_count'];
									 }
								   }
								   else
								   {
									 if($from<=$sc_total_point)
									   {
											 $star_count=$values['star_count'];
									   }
								   
								   }
								}
								
						?>
                              <div class="col-md-3 col-md-offset-1" style="font-size:14px;font-weight:bold;height:70px;">
                              <?php if($val['std_img_path']!=""){?>
							 <img  src='<?php echo $val['std_img_path']?>'  style="height:70px;padding:10px;"/>
                               <?php }else{?>
                               
                               <img src="image/avatar_2x.png"  style="height:70px;padding:10px;" />
                               <?php }?>
                             </div>
                            </div>
                            
							  <div class="row">
                              <div class="col-md-10" style="font-size:14px;font-weight:bold;" align="center">
							<?php echo ucwords($val['std_name']);?></div>
                            </div>
                            <div class="row" align="center">
                            <?php 
							  $j=1;
                                    while($j<=$star_count)
									{
									$j++;
									 ?>
                                     <img src='image/stud_star.jpg' style="height:30px;width:30px;" />
                                     <?php
									
									}
									
									?>
                            </div>
                            </div>
                           <?php if($i%4==0){?>
                            </div><div class="row" style="height:10px;"></div>
							<?php }?>
                       
                        <?php
                        }
						
						}
                        ?>
        
                 
                    
                
           
                  </div> 
        


          
          
          
          
          
          </div>
          
          
          
          
          


</div>














<!-- body-->
</div>

</body>
</html>
