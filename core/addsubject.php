
<?php
 
 include("conn.php");
//echo "select * from tbl_user where t_email = '".$_SESSION['username']."' and t_password = '".$_SESSION['password']."'";
$query = mysql_query("select * from tbl_teacher where id = ".$_SESSION['id']);
$value = mysql_fetch_array($query);
$sc_id=$value['school_id'];
$id=$_SESSION['id'];
	  $report="";
	  
	  if(isset($_POST['submit']))
		{
 		
            if(!empty($_POST['subject']))
						{
							// Loop to store and display values of individual checked checkbox.
							foreach($_POST['subject'] as $subject_id){
								$results=mysql_query("select * from tbl_subject where school_id='$sc_id' and teacher_id='$id' and subject='$subject_id'");
								 if(mysql_num_rows($results)<=0)
									{
										$query="insert into tbl_subject (subject,teacher_id,school_id) values('$subject_id','$id','$sc_id') ";
										$rs = mysql_query($query ); 
									}
								 else
									{
									
										$report="You are already added ".$subject;
									
									}	
									}	
						}
						
			else
			{
				$report="Please Enter Subject";
			}
					
		}
		  if(isset($_POST['submit1']))
		{
 		
            if(!empty($_POST['subject1']))
						{
							// Loop to store and display values of individual checked checkbox.
							foreach($_POST['subject1'] as $subject_id){
								$results=mysql_query("select * from tbl_subject where school_id='$sc_id' and teacher_id='$id' and subject='$subject_id'");
								 if(mysql_num_rows($results)<=0)
									{
										$query="insert into tbl_subject (subject,teacher_id,school_id) values('$subject_id','$id','$sc_id') ";
										$rs = mysql_query($query ); 
									}
								 else
									{
									
										$report="You are already added ".$subject;
									
									}	
									}	
						}
						
			else
			{
				$report="Please Enter Subject";
			}
					
		}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smart Cookies</title>

<script>
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
</script>


</head>


<body style="background: none repeat scroll 0% 0% #E5E5E5;text-shadow: none;">
<div align="center" >
<div  >
    	<?php include("header.php");?>
   
        </div>
        <div  class="row" style="padding-top:5px;padding-left:5px;">
        <div class="col-md-3 ">
    <div class="container" style="border:1px solid #CCCCCC; background-color:#FFFFFF;">
              <div class="row" style="background-image:url(image/Interior%20design%20background%20-%20red%2001.jpg); padding-left:5px; padding-right:5px; color:#FFFFFF;">
               <div class="col-md-8">
             
             
                    My Profile
                    </div>
                </div>
   
              
                 
                 <div class="row" align="center"  style="padding-top:10px;">
                 <div  style=" font-size:16px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold;">  <?php echo $value['t_name'];?></div></div>
                 <div class="row"  align="center"  >
                  <div  style="color:#308C00;font-size:34px;font-weight:bold;  font-family:"Arial,Verdana,sans-serif"";><?php echo $value['tc_balance_point'];?></div>
                  </div>
                  <div class="row" align="center" >
                  <div style="color:#0101DF;font-size:16px;font-family:"Times New Roman", Times, serif">Balance Points</div></div>
                </div>
                 <div class="container" style="height:5px;"></div>
                
                   <div class="container" style=" border:1px solid #CCCCCC; background-color:#FFFFFF;">
                 <div style="padding:5px;font-weight:bold;color:#990000">
                    My Subjects &nbsp;&nbsp;  <a href="addsubject.php" style="text-decoration:none;"> <input type="button" name="submit" value="Add" style=" width:50px; height:20px; font-size:12px; border:1px solid #CCCCCC;"/></a>
                </div>
                 
                <div style="height:5px;"></div>
                    
                    
                    <table class="alternate_color">
                     
                    	<tr  style="background-color:#003399;color:#FFFFFF; color:#FFFFFF;"><th style="width:50px;" >Sr.No</th><th style="width:150px;">Subject</th><th>Delete</th></tr>
                        <?php
							$i=0;
						
							$arr = mysql_query("select sub.id,sub.subject from tbl_subject s join tbl_school_subject  sub on s.subject=sub.id where s.teacher_id='$id' and s.school_id='$sc_id' ");
							while($row = mysql_fetch_array($arr))
							{
							$i++;
						?>
                        <tr class="d0"><td align="center"><?php echo $i;?></td><td align="left"><?php
						$subject_id=$row['id'];
						 echo $row['subject'];?></td>
                        <td>
                             <a onClick="confirmation(<?php echo $subject_id;?>,<?php echo $sc_id; ?>)"style="text-decoration:none"><img src="images/trash.png" alt="" title="" border="0" /></a></td>
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
                    	<tr  style="background-color:#003399;color:#FFFFFF; color:#FFFFFF;"><th style="width:120px;" >Sr.No</th><th style="width:150px;">Class</th><th style="width:200px;">Division</th><th>Delete</th></tr>
                        <?php
							$i=0;

							
							$arr=mysql_query("SELECT * FROM `tbl_division` WHERE  teacher_id='$id' order by class_id");
							while($row = mysql_fetch_array($arr))
							{
					
							$classid=$row['class_id'];
							$divid=$row['division'];
							$test=mysql_query("select class from tbl_school_class where id='$classid'");
							$s=mysql_fetch_array($test);
							if($divid!="")
							{
							$test1=mysql_query("select division from tbl_school_division where id='$divid' and school_id='$school_id'");
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
        	
                   
                    
                    <div style=" background-color:#FFFFFF;height:1000px;overflow:scroll;" >
                    <div class="row">
              			 <div class="col-md-3" align="right" style="color:#700000 ;" >
                         	 <form action="" method="post">
                   				
               			 </div>
                         <div class="col-md-4" style="padding:20px;">
                  			 <input type="text" class="form-control" name="subjects" id="subjects"  placeholder="Enter Subject Name"/>
                          </div>
                          <div  class="col-md-3" style="padding:20px;" >
                          <input type="submit" class="button_example" name="search" value="Search" /></form>
                          </div>
                     </div>
                   <?php if(isset($_POST['search'])){
				   				$subjects=$_POST['subjects'];
				  
                   $result=mysql_query("select * from tbl_school_subject where school_id='$sc_id' and subject like '%$subjects%'");
				         $i=1;?>
                          <form action="" method="post">
                   <div class="row">
              			 <div class="col-md-3">
               			 </div>
                           <div class="col-md-6 col-md-offest-2">
                              <table class="table-bordered">
                                 
                                    <tr style="background-color:#003399;color:#FFFFFF;"><th style="width:100px;" align="center" ><b>Sr.No</b></th><th style="width:200px;" ><b><center>Subject</center></b></th><th style="width:150px;"><b><center> Select Subject</center></b></th></tr>
                              <?php while($value=mysql_fetch_array($result)){?>
                              
                             
                             
                              <tr ><td align="center"><?php echo $i;?></td><td align="left" style="padding-left:10px;"><?php echo $value['subject']; ?></td><td align="center"><input type="checkbox" name="subject[]" value="<?php echo $value['id']; ?>"></td></tr>
                              <?php $i++;}?>
                              </table>
                              </div>
                      </div>
                              
                         <div class="row">
                  
                  <div class="col-md-6 col-md-offset-5" >
                    <input type="submit" class="button_example" name="submit" value="Add" style="width:70px;font-weight:bold;font-size:14px;"/>
                   
                   </div>
                    </div>
                    </form>
                     <div class="row" >
                   
                  <div class="col-md-6 col-md-offset-3" style="color:#FF0000">
                 <?php echo $report;?>
                 
                   </div>
                    </div>
                      
                    </div>
                   <?php }else{?>
                   
                   <?php 
				
				  $result=mysql_query("select * from tbl_school_subject where school_id='$sc_id' ");
				         $i=1;
						  ?>
               <div class="row">
               <form method="post">
               <div class="col-md-3">
               </div>
               <div class="col-md-6 col-md-offest-2">
                  <table class="table-bordered">
                     
                    	<tr style="background-color:#003399;color:#FFFFFF;"><th style="width:100px;" ><b><center>Sr.No</center></b></th><th style="width:200px;" ><center>Subject</center></th><th style="width:150px;"><b><center>Select Subject</center></b></th></tr>
                  <?php while($value=mysql_fetch_array($result)){?>
                  
                 
                 
                  <tr ><td align="center"><?php echo $i;?></td><td align="left" style="padding-left:10px;"><?php echo $value['subject']; ?></td><td align="center"><input type="checkbox" name="subject1[]" value="<?php echo $value['id']; ?>"></td></tr>
                  <?php $i++;}?>
                  </table>
                  </div>
                  </div>
                  
                  
                   <div class="row" style="padding:5px;">
                 
                  <div class="col-md-6 col-md-offset-5 " >
                    <input type="submit" class="button_example" name="submit1" value="Add" style="width:70px;font-weight:bold;font-size:14px;"/>
                   </form>
                   </div>
                    </div>
                     <div class="row" >
                      <div class="col-md-3">
               </div>
                  <div class="col-md-6 " >
                  <div style="color:#FF0000"><?php echo $report;?></div>
                 
                   </div>
                    </div>
                      
                    </div>
                 
                  <?php }
				  	?>
                 
                    
                    
                  
               </div>
           </div>
       
    
      
<div>

<?php include("footer.php");?>
</div>
</body>
  </html>      

