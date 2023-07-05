<?php
	
	include("Parent_header.php");
	$id=$_SESSION['id'];
	 $fields=array("id"=>$id);
		   $table="tbl_parent";
             $smartcookie=new smartcookie();
		   
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$city=$result['city'];
$country=$result['country'];
		//	$c_id=$parent['stud_id'];

        $stud_id=$_GET['stud_id'];
          $school_id=$_GET['sch_id'];
		
		if(empty($_SESSION['test'])) 
		{
			$_SESSION["stud_prn"] = $stud_id;
			$_SESSION["School_id"] = $school_id;
		}   
			
//echo $_SESSION["stud_prn"]." ".$_SESSION["School_id"];

  	//retive child name using stud_id
		$result=mysql_query("select * from tbl_student where std_PRN='".$_SESSION["stud_prn"]."' and
		school_id='".$_SESSION["School_id"]."'");
		$rows=mysql_fetch_array($result);   
  ?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script>
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');

</script>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="css/responsive-datatable.css">
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
        
</head>

<body >

 <div class="row" style="padding:10px;">
 	<div class="col-md-3">
    			<div class="container" style=" background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 1px 1px #C3C3C4;" align="center">
                          <div> <b>Name:</b> <?php  echo $rows['std_name']; ?></div>
                          <div style="padding-top:10px;padding-bottom:10px;"> <?php if($rows['std_img_path']!="")
                          {?> <img src="<?php  echo $rows['std_img_path'];?>" width="50px;" height="60px;" /> <?php } else { ?><img src="image/avatar_2x.png"  width="50px;" height="60px;"/> <?php }?></div>
                          <div><b>School Name:</b><?php	echo $rows['std_school_name'];?> </div>
                          <div><b> Class:</b><?php	echo $rows['std_class'];?> </div>   
                          <div><b> Division:</b><?php	echo $rows['std_div'];?> </div>
                          <div><b> PRN No:</b><?php	echo $rows['std_PRN'];?> </div>
                      </div>
    </div>
    <div class="col-md-8">
    						  <ul class="nav nav-tabs">
                        <li class="active">
                        
                       
                       <a href="child_header.php?stud_id=<?php echo $stud_id;?>&sch_id=<?php echo $school_id; ?>" style="color:#000000">Teacher Reward Points </a>
                        </li>
                       <!-- <li><a href="student_point.php?stud_id=<?php echo $_SESSION["stud_prn"];?>" style="color:#000000">Point</a></li>-->
                        <li><a href="student_reward.php?stud_id=<?php echo $_SESSION["stud_prn"];?>&sch_id=<?php echo $_SESSION["School_id"]; ?>" style="color:#000000">Sponser Reward Points</a></li>
   					 </ul>
                     
                      <?php
                        $sqls= "select st.id,st.sc_point ,st.sc_teacher_id,tbt.t_complete_name ,st.point_date, st.sc_studentpointlist_id ,spt.sc_list from tbl_student_point st join tbl_student s join tbl_studentpointslist spt join tbl_teacher tbt on st.sc_stud_id = s.std_PRN and st.sc_studentpointlist_id=spt.sc_id and tbt.id=st.sc_teacher_id where s.std_PRN='".$_SESSION["stud_prn"]."'";
                                                      $sum =0;
                                                        $arr = mysql_query($sqls);
																   $sum =0;
                                                        while($row = mysql_fetch_array($arr)){
															
															
										 $sum =$sum + $row['sc_point']; 					
															
														}?>
                                                           <div style="        border: 2px solid black;
    padding-left: 140px;
    border-radius: 25px;
    margin-right: 5;
    margin-right: 300px;
    margin-left: 200px;
    margin-bottom: 20px;
    font-size: 20px;"><?php echo $sum;?>
    </div>
    <div style="   
    margin-right: 5;
    margin-right: 330px;
    margin-left: 350px;
    margin-bottom: 20px;
    font-size: 20px;">
      <a href="https://twitter.com/share" class="twitter-share-button"  data-text="I am pleased to say that my son/daughter <?php echo $rows['std_name'];?> got <?php echo $row['sc_point']; ?> Smart Cookie points from <?php echo $row['t_name'];?> at <?php// echo $row['std_school_name'];?>" data-size="large" data-hashtags="smartcookieprogram">Tweet</a>
       </div>
                     
                     
                                  <!--<nav  style="background-color:#CC99CC;" >
                           
                            
                              <ul  id="main-menu">
                               <li><a href="student_point.php?stud_id=<?php echo  $_SESSION["stud_prn"];?>" style="color:#000000">Point</a></li>
                               <li><a href="student_reward.php?stud_id=<?php echo $_SESSION["stud_prn"];?>" style="color:#000000">Reward</a></li>
                                <li><a href="stud_rewardpoint.php?stud_id=<?php echo $_SESSION["stud_prn"];?>" style="color:#000000">Reward Point </a></li>
                              </ul>
                            </nav>-->
                             <?php 

          $result1=mysql_query("select sc_total_point from tbl_student_reward where sc_stud_id='".$_SESSION["stud_prn"]."' and school_id='".$_SESSION["School_id"]."'");
                $row2=mysql_fetch_array($result1)
        ?>
                                     
                                         <div align="center">
		<?php $sql= "select st.id,st.sc_point ,st.sc_teacher_id,tbt.t_name ,s.std_school_name,st.point_date, st.sc_studentpointlist_id ,spt.sc_list from tbl_student_point st join tbl_student s join tbl_studentpointslist spt join tbl_teacher tbt on st.sc_stud_id = s.std_PRN and st.sc_studentpointlist_id=spt.sc_id and tbt.id=st.sc_teacher_id where s.std_PRN='".$_SESSION["stud_prn"]."' ORDER BY st.id  DESC LIMIT 1";
                                                          
                                                            $arrs = mysql_query($sql);
                                                            $row = mysql_fetch_array($arrs);?>
      
    
									</div>
     </div>
 </div>
  <div class="row" style="padding:10px;">
  		<div class="col-md-3">
        		<!--<div class="container" style="background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 1px 1px #C3C3C4;" >
                        <div style="font-weight:bold;font-size:24px;color:#000000;padding-bottom:10px;" align="center">Sponsor</div>
                          <?php
						 // $arr=mysql_query("select * from  tbl_sponsorer  where sp_city like '$city' and sp_country like '$country' group by sp_name");
						      //  while($results=mysql_fetch_array($arr))
								//{?>
                                <div style="padding-left:20px;" align="left"> <?php// echo $results['sp_name'];?> </div>  <?php// }?>  
                      </div>-->

       
        </div>
        	<?Php
        
       $rec_limit = 10;
        /* Get total number of records */
        $sql = "SELECT count(id) FROM tbl_student_point where sc_stud_id ='".$_SESSION["stud_prn"]."'";
        $retval = mysql_query( $sql);
        if(! $retval )
        {
          die('Could not get data: ' . mysql_error());
        }
        
        
        $row = mysql_fetch_array($retval, MYSQL_NUM );
        $rec_count = $row[0];
        
        if( isset($_GET{'page'} ) )
        {
           $page = $_GET{'page'} + 1;
           $offset = $rec_limit * $page ;
        }
        else
        {
           $page = 0;
           $offset = 0;
        }
         $left_rec = $rec_count - ($page * $rec_limit);
        ?>
        <div class="col-md-7">
         <div id="no-more-tables" >
            <table class=" table-striped table-condensed cf table-bordered" width="100%" style="">
        		<thead  style="background-color:#BDBDBD;color:#FFFFFF;" >
        			<tr>
        				                    <th>Sr. No.</th>
                                            <th>Point</th>
                                            <th>Activity</th>
                                            <th>Teacher Name</th>
                                            <th>Assign Date</th>
        			</tr>
        		</thead>
        		<tbody>
        	
                                       
                                         <?php
                                                        
                                                    $i=$rec_limit*$page;
                                                      $sqls= "select st.id,st.sc_point ,st.sc_teacher_id,tbt.t_complete_name ,st.point_date, st.sc_studentpointlist_id ,spt.sc_list from tbl_student_point st join tbl_student s join tbl_studentpointslist spt join tbl_teacher tbt on st.sc_stud_id = s.std_PRN and st.sc_studentpointlist_id=spt.sc_id and tbt.id=st.sc_teacher_id where s.std_PRN='".$_SESSION["stud_prn"]."'  ORDER BY st.id  DESC LIMIT $offset, $rec_limit";
                                                      
                                                        $arr = mysql_query($sqls);
																   $sum =0;
                                                        while($row = mysql_fetch_array($arr))
                                                        {
                                                        $i++;
                                                        
                                                        ?>
                                                        <tr>
                                                             <td data-title="Sr. No." align="left"><?php echo $i;?></td>
                    <?php
                                      ?>              
					 <td data-title="Point" align="left"><?php echo $row['sc_point'];?></td>
                                                             <td data-title="Activity" align="left"><?php echo $row['sc_list'];?></td>
                                                             <td data-title="Teacher Name" align="left"><?php echo $row['t_complete_name'];?></td>
                                                             <td data-title="Assign Date" align="left"><?php echo $row['point_date'];?></td>
                                                            
                                                        </tr>
                                                        <?php
                                                        }
														
                                                        ?>
                                                        
                                                        </tbody>
                        </table>
                        <div align="center" style="font-weight:bold;">
                         <?php
                        if( $page > 0 )
                        {
                           $last = $page - 2;
                           echo "<a href=\"child_header.php?page=$last&stud_id=".$_SESSION["stud_prn"]."&
						   sch_id=".$_SESSION["School_id"]."\">Last 10 Records</a> |";
                           echo "<a href=\"child_header.php?page=$page&stud_id=".$_SESSION["stud_prn"]."&sch_id=".$_SESSION["School_id"]."\">Next 10 Records</a>";
                        }
                        else if( $page == 0 )
                        {
                           echo "<a href=\"child_header.php?page=$page&stud_id=".$_SESSION["stud_prn"]."&sch_id=".$_SESSION["School_id"]."\">Next 10 Records</a>";
                        }
                        else if( $left_rec < $rec_limit )
                        {
                           $last = $page - 2;
                           echo "<a href=\"child_header.php?page=$last&stud_id=".$_SESSION["stud_prn"]."&sch_id=".$_SESSION["School_id"]."\">Last 10 Records</a>";
                        }
                        
                        ?>
                        </div>
        </div>
  </div>     


</body>
</html>
