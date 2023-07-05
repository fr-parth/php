<?php

	include_once("scadmin_header.php");
	     $id=$_SESSION['id'];
		  
           $fields=array("id"=>$id);
		
		   exit();
		   $table="tbl_school_admin";
		   
		   $smartcookie=new smartcookie();
		   
  $results=$smartcookie->retrive_individual($table,$fields);
  $result=mysql_fetch_array($results);
   $school_id=$result['school_id'];
    	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
<title>Smart Cookie Program</title>

<!--<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">-->
</head>

<body style="background-color:#F8F8F8;">
<div align="center">
	<div style="width:100%">
    	<div style="height:10px;"></div>
    	<div style="height:50px; border-bottom: thin solid #CCCCCC;" align="left">
        	<h1 style="padding-left:20px; margin-top:2px;"></h1>
        </div>
    	<div style="height:15px;"></div>
    	
        
        <div class="container">
        <div class="row">
       
        <div class="col-md-6">
        <form method="post" name="product">
        	<div style="background-color:#FFFFFF; border:1px solid #CCCCCC; padding-left:30px;box-shadow: 0px 1px 3px 1px #C3C3C4;" align="left">
            	<div style="height:10px;"></div>
            	
				<div>	<h3> No.of Teachers</h3>  </div>
              
                
            	<div style="color:#663366;font-size:60px;">
                <?php $row=mysql_query("select * from tbl_school_admin where id=".$_SESSION['id']);
				         $result=mysql_fetch_array($row);
						 
								$school_id=$result['school_id'];
						
							
				$sql_t="select count(id) as count from tbl_teacher where school_id=$school_id ";
				 $row_t=mysql_query($sql_t);
				 $count=mysql_fetch_array($row_t);
				            echo $count['count'];
				    
				?>
                </div>
              </div>
                <div style="height:10px;"></div>
          </form>
                 </div>      
                            
                
                
                 <div class="col-md-6">
              <form method="post" name="product">
                
        	<div  style="background-color:#FFFFFF; border:1px solid #CCCCCC; padding-left:30px;box-shadow: 0px 1px 3px 1px #C3C3C4;" align="left">
            	<div style="height:5px;"></div>
            	<div>
					<h3>No.of Students</h3>
                </div>
                <div style="color:#663366;font-size:60px;">
             <?php 
						
							
				$sql_t="select count(id) as count from tbl_student where school_id=$school_id ";
				 $row_t=mysql_query($sql_t);
				 $count=mysql_fetch_array($row_t);
				            echo $count['count'];
				    
				?></div>
                
                
                </div>
                <div style="height:10px;"></div>
               </form>
                </div>
                
                
                
                </div>
         </div>
     
             
             <div class="container">
             <div class="row">
     <div class="col-md-6">
        <form method="post" name="product">
        	<div style=" background-color:#FFFFFF; border:1px solid #CCCCCC; padding-left:30px;box-shadow: 0px 1px 3px 1px #C3C3C4;" align="left">
            	<div style="height:10px;"></div>
            	
				<div>	<h3>No.of Sponsors</h3>  </div>
              
                
            	<div style="color:#663366;font-size:60px;">
                <?php
						
							
				 $sql_sp="select count(id) as count from tbl_sponsorer ";
				 $row_sp=mysql_query($sql_sp);
				 $count_sp=mysql_fetch_array($row_sp);
				       ?>  <blink>   <?php echo $count_sp['count'];?></blink>
                </div>
                </div>
              <div style="height:10px;"></div>
                </form>
            </div>
                
                
              <div class="col-md-6">
                <form method="post" name="product">
        	<div style=" background-color:#FFFFFF; border:1px solid #CCCCCC; padding-left:30px;box-shadow: 0px 1px 3px 1px #C3C3C4;padding:5px;" align="left">
            	<div style="height:5px;"></div>
            	<div>
					<h3>Top 3 Students</h3>
                </div>
                 
               <?php
              
						$sql2="SELECT s.sc_stud_id, s.sc_total_point, t.std_name
								FROM  `tbl_student_reward` s
								JOIN tbl_student t
								WHERE t.id = s.`sc_stud_id` and t.school_id='$school_id' 
								ORDER BY  `sc_total_point` DESC 
								LIMIT 0 , 3" ;
									
											
						$result=mysql_query($sql2);
						
						
						
               ?>
               
              <table align="center" cellpadding="1" width="100%">
            	<tr  style="color:#003399;font-size:14px">
               <th>Student ID</th>
               		<th>Student Name</th>
                    <th>Points</th></tr>
                    <?php while($row=mysql_fetch_array($result)){?>
               <tr ><td> <?php echo $row['sc_stud_id'];?></td>
               		<td> <?php echo $row['std_name'];?></td>
                    <td> <?php echo $row['sc_total_point'];?></td></tr>
                    <?php } ?>
               </table>
                
                </div>
                <div style="height:10px;"></div>
                </form>
                </div>
                </div>
             </div> 
                
              
    </div>
</div>
<?php include("footer.php");?>
</body>
</html>
