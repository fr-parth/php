 <?php
	
	include("Parent_header.php");
            $parent=$smartcookie->Parent_profile();
		//	$c_id=$parent['stud_id'];
			
?>
<?php $stud_id=$_GET['stud_id'];?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script>
function showhide(id){
        if (document.getElementById) {
          var divid = document.getElementById(id);
          var divs = document.getElementsByClassName("hide");
          for(var i=0;i<divs.length;i++) {
            divs[i].style.display = "none";
          }
          divid.style.display = "block";
        } 
        return false;
 }
 
 !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
 </script>
</head>
  <body>
 
 <nav id= "2" style="margin-top:10px;width:40%;background-color:#CC99CC;">

  <ul  id="main-menu">
    <li><a href="student_point.php?stud_id=<?php echo  $stud_id;?>" style="color:#000000">Point</a></li>
    <li><a href="shopping.php?stud_id=<?php echo  $stud_id;?>" style="color:#000000">Used Coupon</a></li>
    <li><a href="summary_report.php?stud_id=<?php echo  $stud_id;?>" style="color:#000000">Point Summary</a></li>
  </ul>
</nav>

  <?php 
  		
		
		$result=mysql_query("select std_name from tbl_student where id=$stud_id");
	while(	$rows=mysql_fetch_array($result))
		{
  ?>
  <div align="left" style="margin-top:10px;font-size:16px;font-weight:bold;background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;margin-right:770px;margin-left:10px;border-radius:5px;padding:2px;">
  <div onclick="showhide('1');" class="bio_image">
  <?php echo $rows['std_name'];?> Report
  </div>
 

  </div>
  <?php }?>
  <div>
  <?php 
  
  $result1=mysql_query("select sc_total_point from tbl_student_reward where sc_stud_id=$stud_id");
  		$row2=mysql_fetch_array($result1)
?>
  <div style="color:#6B008F;margin-top:20px;font-size:50px;width:100px;"><b><?php echo $row2['sc_total_point'];?></b></div>
  <div style="font-size:30px;"> Point's </div> 
  <div align="center" style="margin-left: 65px;margin-top:5px;">
    <?php $sql= "select st.id , st.sc_point ,st.sc_teacher_id,tbt.t_name ,s.std_school_name,st.point_date, st.sc_studentpointlist_id ,spt.sc_list from tbl_student_point st join tbl_student s join tbl_studentpointslist spt join tbl_teacher tbt on st.sc_stud_id = s.id and st.sc_studentpointlist_id=spt.sc_id and tbt.id=st.sc_teacher_id where s.id =$stud_id  ORDER BY st.id  DESC LIMIT 1";
                                                      
                                                        $arrs = mysql_query($sql);
														$row = mysql_fetch_array($arrs);?>
  
  <a href="https://twitter.com/share" class="twitter-share-button"  data-text="I am pleased to say that my son/daughter <?php echo $rows['std_name'];?> got <?php echo $row['sc_point']; ?> Smart Cookie points from <?php echo $row['t_name'];?> at <?php echo $row['std_school_name'];?>" data-size="large" data-hashtags="smartcookieprogram">Tweet</a>
</div>
  </div> 
  <div  >        
		<?Php
        
        $rec_limit = 10;
        /* Get total number of records */
        $sql = "SELECT count(id) FROM tbl_student_point where sc_stud_id = $stud_id";
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
        <div align="center">
            <div style="width:1002px;">
                <div style="height:10px;"></div>
                <!--<div style="height:50px; background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;" align="left">
                    <h1 style="padding-left:20px; margin-top:2px;">Point's History </h1>
                </div>-->
                <div style="height:10px;"></div>
                <div style="background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
                <div style="height:10px;"></div>
        
                        <table cellpadding="1" cellspacing="1" width="95%">
                                        <tr style="background-color:#F0EEEE; height:30px;">
                                            <th>Sr. No.</th>
                                            <th>Point</th>
                                            <th>Activity</th>
                                            <th>Teacher Name</th>
                                            <th>Assign Date</th>
                                        </tr>
                                       
                                         <?php
                                                        
                                                    $i=$rec_limit*$page;
                                                      $sqls= "select st.id , st.sc_point ,st.sc_teacher_id,tbt.t_name ,st.point_date, st.sc_studentpointlist_id ,spt.sc_list from tbl_student_point st join tbl_student s join tbl_studentpointslist spt join tbl_teacher tbt on st.sc_stud_id = s.id and st.sc_studentpointlist_id=spt.sc_id and tbt.id=st.sc_teacher_id where s.id =$stud_id  ORDER BY st.id  DESC LIMIT $offset, $rec_limit";
                                                      
                                                        $arr = mysql_query($sqls);
                                                        while($row = mysql_fetch_array($arr))
                                                        {
                                                        $i++;
                                                        
                                                        ?>
                                                        <tr>
                                                             <td align="center"><?php echo $i;?></td>
                                                             <td align="center"><?php echo $row['sc_point'];?></td>
                                                             <td style="padding-left:30px;"><?php echo $row['sc_list'];?></td>
                                                             <td style="padding-left:30px;"><?php echo $row['t_name'];?></td>
                                                             <td style="padding-left:10px;"><?php echo $row['point_date'];?></td>
                                                           
                                                        </tr>
                                                        <?php
                                                        }
                                                        ?>
                        </table>
                         <?php
                        if( $page > 0 )
                        {
                           $last = $page - 2;
                           echo "<a href=\"student_point.php?page=$last&stud_id=$stud_id\">Last 10 Records</a> |";
                           echo "<a href=\"student_point.php?page=$page&stud_id=$stud_id\">Next 10 Records</a>";
                        }
                        else if( $page == 0 )
                        {
                           echo "<a href=\"student_point.php?page=$page&stud_id=$stud_id\">Next 10 Records</a>";
                        }
                        else if( $left_rec < $rec_limit )
                        {
                           $last = $page - 2;
                           echo "<a href=\"student_point.php?page=$last&stud_id=$stud_id\">Last 10 Records</a>";
                        }
                        
                        ?>
                </div>
        </div>
        </div>
    </div> <!--end of div that is hide-->
      </div>
      </div>
      </div>



</body>
</html>
