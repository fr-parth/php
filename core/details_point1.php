<?php

 include("conn.php");

 //echo "select * from tbl_user where t_email = '".$_SESSION['username']."' and t_password = '".$_SESSION['password']."'";
$query = mysql_query("select * from tbl_teacher where t_email = '".$_SESSION['username']."' and t_password = '".$_SESSION['password']."'");
$value = mysql_fetch_array($query);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smart Cookies</title>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
</head>

<body style="background: none repeat scroll 0% 0% #E5E5E5;text-shadow: none;">
<div align="center">

    	
       <div style="width:1002px;">
    	<?php include("header.php");?>
       
               
            
        </div>
        <!--center div-->
        <div style="float:left; width:800px;">
        	
            <div style="padding-left:15px; padding-right:5px;">
            	<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; background-color:#FFFFFF;">
                    <div style="padding:2px 2px 2px 2px; background-image:url(image/images_.jpg); color:#FFFFFF; ">
                   Assign Point To Student
                    </div>
                    <?php
					$arr = mysql_query("select * from tbl_student where id =".$_GET['id']);
					$row = mysql_fetch_array($arr);
					
					?>
                    <div>
                        <div style="padding:2px 2px 2px 2px;">
                       
                           <form method="post" action="">
                            <div style="border:1px solid #CCCCCC; padding:5px 5px 5px 5px;">
                           <table style="font-size:14px;">
                          
                           	<tr>
                           		<td rowspan="4" align="center" style="padding-right:50px;"><img src="<?php if($row['std_img_path'] !=''){echo $row['std_img_path'];}else{ echo "image/avatar_2x.png";}?>" width="100" height="100" /></td><td></td><td></td><td></td><td></td>
                            </tr>
                            <tr>
                           		<td rowspan="4" align="center"></td><td style="font-size:16px;"><strong>Student Name</strong></td><td><input type="text" name="std_name" value="<?php echo $row['std_name'];?>" /></td><td><strong>DOB</strong></td><td><input type="text" name="std_name"  value="<?php echo $row['std_dob'];?>" /><input type="text" name="std_id"  value="<?php echo $row['id'];?>" style="display:none;" /></td>
                            </tr>
                            <tr>
                           		<td style="font-size:16px;"><strong>Class</strong></td><td><input type="text" name="std_class"  value="<?php echo $row['std_class'];?>" /></td><td><strong>Division</strong></td><td><input type="text" name="std_div"  value="<?php echo $row['std_div'];?>" /></td>
                            </tr>
                            <tr>
                           		<td style="font-size:16px;"><strong>Gender</strong></td><td><input type="text" name="std_gender"  value="<?php echo $row['std_gender'];?>" /></td><td><strong>Hobbies</strong></td><td><input type="text" name="std_hobbies"  value="<?php echo $row['std_hobbies'];?>" /></td>
                            </tr>
                           
                            </table>
                             <div style="height:120px; padding:15px;">
                            <div align="right" style="padding-right:50px;">
                            <div style="width:450px;">
                            <div align="left" style="height:15px; color:#FFFFFF; padding:5px; background-color:#008ACC; border:1px solid #999999; padding-left:30px; width:413px; font-size:16px;">REWARDS</div>
                           <?php
						   	$stud_id = $row['id'];
						   	$query_points = mysql_query("select sum(sc_point) points from tbl_student_point where sc_stud_id = $stud_id and sc_status = 'N'");
							$row_points = mysql_fetch_array($query_points);
						  ?>
                            <div style="width:450px; padding-top:5px;" align="center">
                            <div style="width:170px; padding:2px 2px 2px 2px;">
                            	<div style="font-size:30px; color:#008ACC; font-weight:bold;"><?php echo $row_points['points'];?></div>
                                <div>Point's</div>
                                <div style="margin-left:45px;">  <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://smartcookie.bpsi.us" data-text="Good Performance <?php echo $row['std_name'];?>" data-size="large" data-hashtags="smartcookieprogram">Tweet</a></div>
                           </div> </div> 
                          
                            <div align="left" style=" padding-left:20px; float:left;"><a href="#" style="text-decoration:none; font-size:12px; padding-right:10px;">View Reward history</a></div><div><a href="#" style="text-decoration:none; font-size:12px; padding-right:20px;">View Point history</a></div>
                             </div>
                             </div>
                            </div>
                             </div>
                           
                             <div style="border:1px solid #CCCCCC; padding:5px 5px 5px 5px;">
                             <table width="750">
                             
                             <tr style="font-size:16px; font-weight:bold; background-color:#999999; height:30px; color:#FFFFFF;"><th>Activity</th><th>Assign Points</th><th>Date</th></tr>
                             <?php
                             $query5 = mysql_query("select * from tbl_student_point where sc_stud_id = ".$_GET['id']." order by id desc limit 0, 10");
							 while($rows5 = mysql_fetch_array($query5))
							 {
							  $scid = $rows5['sc_studentpointlist_id'];
							   $query6 = mysql_query("select sc_list from tbl_studentpointslist where sc_id = $scid");
							   $rows6 = mysql_fetch_array($query6);
							  
							 ?>
                             <tr align="center">
                             	<td><?php echo $rows6['sc_list'];?></td>
                                <td><?php echo $rows5['sc_point'];?></td>
                                <td><?php echo $rows5['point_date'];?></td>
                             </tr>
                             <?php
							 }
							 ?>
                           </table>
                           </div>
                           </form> 
                           
                         </div>
                    </div>
                    <div style="height:5px;"></div>
                   
                   <!-- <div style="height:5px;"></div>
                    
                     <div style="height:90px;">
                        <div style="padding:2px 2px 2px 2px;">
                            <div style="border:1px solid #CCCCCC; height:80px;">
                                <div style="float:left; padding:2px 2px 2px 2px;">
                                    <div style="border:1px solid #CCCCCC;"><img src="image/amol.jpg" width="50" height="50" /></div>
                                </div>
                                <div align="left" style="padding-left:70px;height:50px;">Ron<p>Ron appeared for maths test and Scored 80%</p></div>
                                <div align="right" style="float:right;"><input type="button" value="Assign Points" />&nbsp;<input type="button" value="View Details" /></div>
                            </div>
                         </div>
                    </div>
                    <div style="height:5px;"></div>
                     <div style="height:90px;">
                        <div style="padding:2px 2px 2px 2px;">
                            <div style="border:1px solid #CCCCCC; height:80px;">
                                <div style="float:left; padding:2px 2px 2px 2px;">
                                    <div style="border:1px solid #CCCCCC;"><img src="image/amol.jpg" width="50" height="50" /></div>
                                </div>
                                <div align="left" style="padding-left:70px;height:50px;">Max<p>Ron appeared for maths test and Scored 80%</p></div>
                                <div align="right" style="float:right;"><input type="button" value="Assign Points" />&nbsp;<input type="button" value="View Details" /></div>
                            </div>
                         </div>
                    </div>
                    
                    <div style="height:5px;"></div>
                     <div style="height:90px;">
                        <div style="padding:2px 2px 2px 2px;">
                            <div style="border:1px solid #CCCCCC; height:80px;">
                                <div style="float:left; padding:2px 2px 2px 2px;">
                                    <div style="border:1px solid #CCCCCC;"><img src="image/amol.jpg" width="50" height="50" /></div>
                                </div>
                                <div align="left" style="padding-left:70px;height:50px;">Matt<p>Ron appeared for maths test and Scored 80%</p></div>
                                <div align="right" style="float:right;"><input type="button" value="Assign Points" />&nbsp;<input type="button" value="View Details" /></div>
                            </div>
                         </div>
                    </div>
                    
                    <div style="height:5px;"></div>
                     <div style="height:90px;">
                        <div style="padding:2px 2px 2px 2px;">
                            <div style="border:1px solid #CCCCCC; height:80px;">
                                <div style="float:left; padding:2px 2px 2px 2px;">
                                    <div style="border:1px solid #CCCCCC;"><img src="image/amol.jpg" width="50" height="50" /></div>
                                </div>
                                <div align="left" style="padding-left:70px;height:50px;">Julie<p>Ron appeared for maths test and Scored 80%</p></div>
                                <div align="right" style="float:right;padding-left:50px;height:50px;"><input type="button" value="Assign Points" />&nbsp;<input type="button" value="View Details" /></div>
                            </div>
                         </div>
                    </div>
                    
                    
                     <div style="height:5px;"></div>
                     <div style="height:90px;">
                        <div style="padding:2px 2px 2px 2px;">
                            <div style="border:1px solid #CCCCCC; height:80px;">
                                <div style="float:left; padding:2px 2px 2px 2px;">
                                    <div style="border:1px solid #CCCCCC;"><img src="image/amol.jpg" width="50" height="50" /></div>
                                </div>
                                <div align="left" style="padding-left:70px;height:50px;">Julie<p>Ron appeared for maths test and Scored 80%</p></div>
                                <div align="right" style="float:right;padding-left:50px;height:50px;"><input type="button" value="Assign Points" />&nbsp;<input type="button" value="View Details" /></div>
                            </div>
                         </div>
                    </div>
                    -->
                    
               </div>
           </div>
        </div>
        <!--right div-->
        <!--<div style="width:200px; float:right;">
        	
        	<div style="border:1px solid #CCCCCC; padding:2px 2px 2px 2px;">
            	<div style="padding:2px 2px 2px 2px; background-image:url(image/images1.jpg); color:#FFFFFF;">Reward Points</div>
                <div style="font-size:12px; font-weight:bold;">
                    <div  align="left" style="padding:5px;">
                   Attendance Points : 25/100
                   <div><input type="button" value="Details" /></div>
                    </div>
                    <div  align="left"  style="padding:5px;">
                   Attendance Points : 60/100
                   <div><input type="button" value="Details" /></div>
                    </div>
                    <div  align="left"  style="padding:5px;">
                   Attendance Points : 70/100
                   <div><input type="button" value="Details" /></div>
                    </div>
                    <div  align="left"  style="padding:5px;">
                   Attendance Points : 90/100
                   <div><input type="button" value="Details" /></div>
                    </div>
                    <div  align="left"  style="padding:5px;">
                   Attendance Points : 95/100
                   <div><input type="button" value="Details" /></div>
                    </div>
                    <div  align="left"  style="padding:5px;">
                   Attendance Points : 30 /100
                   <div><input type="button" value="Details" /></div>
                    </div>
                    <div  align="left"  style="padding:5px;">
                   Attendance Points : 30/100
                   <div><input type="button" value="Details" /></div>
                    </div>
                </div>
            </div>
            <div style="height:10px;"></div>
            <div style="border:1px solid #CCCCCC; padding:2px 2px 2px 2px; padding-bottom:70px;">
            	<div style="padding:2px 2px 2px 2px; background-image:url(image/backgrounds-background-screens-title-imovie.jpg); color:#FFFFFF;">Reward Givers</div>
                <div style="font-size:12px; font-weight:bold;">
                    <div  align="left" style="padding:5px; padding-bottom:5px;">
                  School &nbsp;&nbsp;<input type="button" value="Details" style="float:right;"/>
                    </div>
                    <div  align="left" style="padding:5px;">
                  School Admin&nbsp;&nbsp;<input type="button" value="Details" style="float:right;"/>
                    </div>
                    <div  align="left" style="padding:5px;">
                  Other Teacher &nbsp;&nbsp;<input type="button" value="Details" style="float:right;"/>
                    </div>
                    <div  align="left" style="padding:5px;">
                  Student &nbsp;&nbsp;<input type="button" value="Details" style="float:right;"/>
                    </div>
                    <div  align="left" style="padding:5px;">
                  Parent &nbsp;&nbsp;<input type="button" value="Details" style="float:right;"/>
                    </div>
                    <div  align="left" style="padding:5px;">
                  Other &nbsp;&nbsp;<input type="button" value="Details" style="float:right;"/>
                    </div>
               
                </div>
            </div>
            
        </div>-->
     </div>
</div>
</div>


</body>
</html>
