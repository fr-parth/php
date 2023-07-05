<style>
#cssmenu ul ul {
  display: none;
  background: #fff;
  
  
}
#purches div{ color:#CCCCCC; }

</style>

<link rel="stylesheet" href="css/custom-accord.css" />

<div class="" style="border:1px solid #CCCCCC; background-color:#FFFFFF;">
		
              <div  style="background-color:#333333; padding:7px 0px 7px 7px; padding-right:5px; color:#FFFFFF; text-align:center;">
                My Point </div>
       
   
             


                 
                 <div class="row" align="center"  style="padding-top:10px;">
                 <div  style=" font-size:16px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold;">  
				 <?php// echo $value['t_name']?> <?php //echo $value['t_lastname']?></div></div>
                 
                 <div class="row"  align="center"  >
                  <div  style="color:#308C00;font-size:34px;font-weight:bold;  font-family:Arial,Verdana,sans-serif;">
				 
                  </div>
                  </div>
            
                  
                
                  
              
                  
                  <div class="row" align="center" >
                          <p></p>
                  <button class="btn btn-primary" type="button">Balance Point <br /> <span class="badge" style="margin-left:8px; margin-top:7px; margin-bottom:7px;"><?php echo $value['tc_balance_point'];?></span>
                   </button>
                   <p></p>
                  
                  </div>
                   <div class="row" align="center"  style="padding-top:10px;"></div>
                 </div>
                 
                 
                 <div style="height:5px;"></div>
                
                   <div  style=" border:1px solid #CCCCCC; background-color:#fff;" align="center">
                 <div style=" background-color:#333333; padding:7px 0px 7px 7px;font-weight:bold;color:#fff;">
                    My Subjects &nbsp;&nbsp;</div>
                 
                <div  style="height:5px;"></div>
                    
                    
 <table class="">
<tr style="background-color:#003399;color:#FFFFFF; color:#FFFFFF;"><th style="width:44%; text-align:center" >Branch </th><th style="width:44%; text-align:center;">Semester </th>
<th style="width:30%" >Class</th><th></th></tr></table>
                      <?php				   
		   $smartcookiefunctions=new smartcookiefunctions();
		   
		$results=$smartcookiefunctions->retrive_teacherclasses($t_id,$sc_id);
		$i=0;
				while($row = mysql_fetch_array($results))
							{
							$i++;
							$Semester_id=$row['Semester_id'];
							$sem=substr($Semester_id,0,3);
							$no=substr($Semester_id,9,10);
							$class=$row['class'];
							$branch_name=$row['Branches_id'];
							$branch=explode(" ",$branch_name);
							$CourseLevel=$row['CourseLevel'];
						?>
                      
                        <div id="cssmenu" class="accord-sub" >
                         
<ul><li><?php echo $branch[0];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $sem." ".$no; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                   <?php echo $class; $results1=$smartcookiefunctions->retrive_teachersubjects($t_id,$sc_id,$Semester_id,$branch_name,$CourseLevel); ?>
                  
         <ul style="padding-top:15px;"> 
      <?php
      $j=0;
      	  while($row1=mysql_fetch_array($results1))
				  {
				  $j++;
				 
				  $subjectName=$row1['subjectName']; 
				  $subjcet_code=$row1['subjcet_code'];
				  $division_id=$row1['Division_id'];
$results2=$smartcookiefunctions->retrive_teachersubjectstudents($t_id,$sc_id,$Semester_id,$branch_name,$CourseLevel,$subjcet_code,$division_id);
				  ?>
<li onclick="color-clk"><a href='dashboard.php?subject_code=<?php echo $subjcet_code;?>,<?php echo $branch_name; ?>,<?php echo $Semester_id;?>' style="text-decoration:none;"><?php  echo $subjectName;?>(<?php  echo $subjcet_code; ?>)</a> &nbsp;&nbsp;&nbsp; <span class="badge"><?php $count=mysql_num_rows($results2); echo $count;?></span></li>
         
     
    <?php }?></ul>
                </a> </li></ul> </div>
                        
                        <?php
							}
						?>
                        </div>
                        
                        
                        
                 
             <!--    <div  class="" style=" padding:5px; border:1px solid #CCCCCC; background-color:#FFFFFF;">
                <div style="padding:5px;font-weight:bold;color:#990000">My Classes &nbsp;&nbsp; <a href="addclass.php" style="text-decoration:none">   <input type="button" value="Add" name ="add" id="add" style="width:50px; height:20px; font-size:12px; border:1px solid #CCCCCC;"/></a>
                </div>
                    
                    <div style="height:5px;"></div>
                   
                 
                    <table class="alternate_color">
                    	<tr  style="background-color:#003399;color:#FFFFFF; color:#FFFFFF;"><th style="width:120px;" >Sr.No</th><th style="width:150px;">Class</th><th style="width:200px;">Division</th><th>Delete</th>
                        
                       
                        </tr>
                        <?php
							/*$i=0;


							
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
							
							$i++;*/
						?>
                        <tr class="d0"><td align="center"><?php// echo $i;?></td><td><?php// echo $s['class'];?></td>
                        <td><?php// echo $division;?></td>
                        
    <td><a onClick="confirmation1(<?php// echo $classid;?>,<?php// echo $divid; ?>)"style="text-decoration:none"><img src="images/trash.png" alt="" title="" border="0" />
    </a></td>
                        
                        </tr>
                        <?php
							//}
						?>
                    </table>
     </div>-->