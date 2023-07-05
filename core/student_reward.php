<?php
	
	include("Parent_header.php");
	$id=$_SESSION['Id'];
	 $fields=array("id"=>$id);
		   $table="tbl_parent";
             $smartcookie=new smartcookie();
		   
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$city=$result['city'];
$country=$result['country'];
		

  		 $stud_id=$_GET['stud_id'];
          $school_id=$_GET['sch_id'];
		  	if(empty($_SESSION['test'])) 
		{
			$_SESSION["stud_prn"] = $stud_id;
			$_SESSION["School_id"] = $school_id;
		}   
			
  	//retive child name using stud_id
		$result=mysql_query("select * from tbl_student where std_PRN='".$_SESSION["stud_prn"]."'
		and school_id='".$_SESSION["School_id"]."'");
		$rows=mysql_fetch_array($result);   

$rec_limit = 10;
/* Get total number of records */
$sql = "SELECT count(id) FROM tbl_accept_coupon where stud_id='".$_SESSION["stud_prn"]."'";
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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smartcookies</title>
 <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
  <script src="js/jquery-1.11.1.min.js"></script>
  <script src="js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/responsive-datatable.css">     
       
</head>
  <body>
  <div class="row" style="padding:10px;">
       <div class="col-md-3">
       		<div class="container" style=" background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;padding:5px;" align="center">
                          <div> <b>Name:</b> <?php  echo $rows['std_complete_name']; ?></div>
                          <div> <?php if($rows['std_img_path']!="")
                          {?> <img src="<?php  echo $rows['std_img_path'];?>" width="50px;" height="60px;" /> <?php } else { ?><img src="image/avatar_2x.png"  width="50px;" height="60px;"/> <?php }?></div>
                          <div><b>School Name:</b><?php	echo $rows['std_school_name'];?> </div>
                          <div><b> Class:</b><?php	echo $rows['std_class'];?> </div>  
                           <div><b> Division:</b><?php	echo $rows['std_div'];?> </div>
                          <div><b> PRN No:</b><?php	echo $rows['std_PRN'];?> </div>       
                      </div>
       </div>
       <div class="col-md-9">
       
       <ul class="nav nav-tabs">
                        <li >
                       <a href="child_header.php?stud_id=<?php echo $stud_id;?>&sch_id=<?php echo $school_id; ?>" style="color:#000000">Teacher Reward Points </a>
                        </li>
                       <!-- <li><a href="student_point.php?stud_id=<?php echo  $stud_id;?>" style="color:#000000">Point</a></li>-->
                        <li class="active"><a href="student_reward.php?stud_id=<?php echo $_SESSION["stud_prn"];?>&sch_id=<?php echo $_SESSION["School_id"]; ?>" style="color:#000000">Sponser Reward Points</a></li>
   					 </ul>
                             <?php 
          
          $result1=mysql_query("select sc_total_point from tbl_student_reward where sc_stud_id='".$_SESSION["stud_prn"]."' and school_id='".$_SESSION["School_id"]."'");
                $row2=mysql_fetch_array($result1)
        ?>
                                      <div style="color:#308C00;font-size:50px;" align="center"><b><?php echo $row2['sc_total_point'];?></b></div>
                                      <div style="font-size:30px;" align="center"> Points </div>
									  <script>
													$(document).ready(function(){
													$('[data-toggle="popover"]').popover();
													});
									</script>
									 <div style="font-size:15px;padding-left:450px;">
									 <!-- <a class="btn_1" href="" onclick="postToFeed('32')">
										<i class="fa fa-facebook fb"></i>
										<span class="share1 fb">Share</span>								
									</a> -->
									  <a class="btn_1" href="whatsapp://send?text=Hiii I got <?php if($row2['sc_total_point']==''){echo "0";}else{echo $row2['sc_total_point']; }?> Points   http://smartcookie.in" data-toggle="popover" data-placement="top" data-content="This feature is only available in mobile/tablet devices" data-original-title="" title="">
									  <i class="fa" style="color: green;">
									  <img src="http://assets.dailyjobinfo.com/images/aboutus/walogo.png" height="24" width="24" alt="Share On Whatsapp" title="Share On Whatsapp">
									  </i>
									 <span class="share1" style="color: #79d448;">Share</span>
									 </a>
									 
									 <!--<a class="btn_1" href="https://web.whatsapp.com//send?text=Hiii I got <?php echo $row2['sc_total_point'];?> Points   http://smartcookie.in" data-toggle="popover" data-placement="top" data-content="This feature is only available in mobile/tablet devices" data-original-title="" title="">
									  <i class="fa" style="color: green;">
									  <img src="http://assets.dailyjobinfo.com/images/aboutus/walogo.png" height="24" width="24" alt="Share On Whatsapp" title="Share On Whatsapp">
									  </i>
									 <span class="share1" style="color: #79d448;">Share</span>
									 </a>-->
									 
									 
									 </div>
       </div>
  </div>
  <div class="row" style="padding:10px;">
  		<div class="col-md-3">
        		<div  class="container" style="background-color:#FFFFFF;border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;" >
    					<div style="font-weight:bold;font-size:24px;color:#000000;padding-bottom:10px;" align="center">Sponsor</div>
                          <?php
						  $arr=mysql_query("select * from  tbl_sponsorer where sp_city like '$city' and sp_country like 
						  '$country' group by sp_name");
						        while($results=mysql_fetch_array($arr))
								{?>
                                <div style="padding-left:30px;" align="left"> <?php echo $results['sp_name'];?> </div>  <?php }?>  
                      </div>
				</div>
       
        <div class="col-md-9">
            <div  class="row"  >
                        <h1 style="padding-left:20px; margin-top:2px;">Rewards </h1>
            </div>
            <div class="container" style="background-color:#FFFFFF; border:1px solid #CCCCCC;">


 <div id="no-more-tables" >
            <table class=" table-striped table-condensed cf table-bordered" width="100%" >
        		<thead  style="background-color:#BDBDBD;color:#FFFFFF;" >
        			<tr>
        				<th>Sr. No.</th>
                       <th>Product Name</th>
                       <th>Point of Product</th>
                    	<th>Sponsor Name</th>
                        <th>Issue Date</th>
        			</tr>
        		</thead>
        		<tbody>
        		<?php
				
			$i=$rec_limit*$page;
		 $sqls= "select ac.id , ac.product_name ,ac.points,ac.issue_date ,ac.sponsored_id ,sp.sp_name from tbl_accept_coupon ac  join tbl_sponsorer sp  on ac.sponsored_id =sp.id where  ac.stud_id='".$_SESSION["stud_prn"]."' LIMIT $offset, $rec_limit ";
			  
				$arr = mysql_query($sqls);
				while($row = mysql_fetch_array($arr))
				{
				$i++;
				
				?>
                <tr>
                	<td data-title="Sr. No." align="left"><?php echo $i;?></td>
            
                    <td data-title="Product Name" align="left">	<?php echo $row['product_name'];?></td>
                    <td data-title="Point Of Product" align="left"><?php echo $row['points'];?></td>
                    <td data-title="Sponsor Name"  align="left"><?php echo $row['sp_name'];?></td>
                     <td data-title="Issue Date" align="left"><?php echo $row['issue_date'];?></td>
                </tr>
                <?php
				}
				?>
        		</tbody>
        	</table>
							
   
     <div align="center">
               
  
				 <?php
                if( $page > 0 )
                {
                   $last = $page - 2;
                   echo "<a href=\"student_reward.php?page=$last&stud_id=".$_SESSION["stud_prn"]."&sch_id=".$_SESSION["School_id"]."\">Last 10 Records</a> |";
                   echo "<a href=\"student_reward.php?page=$page&stud_id=".$_SESSION["stud_prn"]."&sch_id=".$_SESSION["School_id"]."\">Next 10 Records</a>";
                }
                else if( $page == 0 )
                {
                   echo "<a href=\"student_reward.php?page=$page&stud_id=".$_SESSION["stud_prn"]."&sch_id=".$_SESSION["School_id"]."\">Next 10 Records</a>";
                }
                else if( $left_rec < $rec_limit )
                {
                   $last = $page - 2;
                   echo "<a href=\"student_reward.php?page=$last&stud_id=".$_SESSION["stud_prn"]."&sch_id=".$_SESSION["School_id"]."\">Last 10 Records</a>";
                }
                
                ?>
     </div>
	</div>
      </div>
        </div>
  </div>
  

</body>
</html>
