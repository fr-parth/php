<?php
	
	include("Parent_header.php");
            $parent=$smartcookie->Parent_profile();
			$c_id=$parent['stud_id'];
		//	$c_school_id=$parent['school_id']; 
?>
<?php
  		 $stud_id=$_GET['stud_id'];  
  	//retive child name using stud_id
		$result=mysql_query("select std_name from tbl_student where id=$stud_id");
		$rows=mysql_fetch_array($result);   
  ?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
  <body>
  
  <nav  style="margin-top:5px;width:25%;background-color:#CC99CC;padding:2px;" >

  <ul  id="main-menu">
   <!-- <li><a href="student_point.php?stud_id=<?php echo  $stud_id;?>" style="color:#000000">Point</a></li>-->
    <li><a href="shopping.php?stud_id=<?php echo  $stud_id;?>" style="color:#000000">Reward</a></li>
    <li><a href="summary_report.php?stud_id=<?php echo  $stud_id;?>" style="color:#000000"> Reward Point </a></li>
  </ul>
</nav>
  
 <div align="left" style="margin-top:10px;font-size:16px;font-weight:bold;background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;margin-right:770px;margin-left:10px;border-radius:5px;padding:2px;">
  <?php echo $rows['std_name'];?> 
  </div>

<?Php

$rec_limit = 10;
/* Get total number of records */
$sql = "SELECT count(id) FROM tbl_accept_coupon where stud_id = $stud_id";
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
    	<div style="height:30px; border-bottom: thin solid ;padding:10px;" align="left">
        	 <h1 style="padding-left:20px; margin-top:2px;">Reward</h1>
        </div>
        <div style="height:20px;"></div>
        <div style="background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
        <div style="height:10px;"></div>

<table cellpadding="1" cellspacing="1" width="95%">
            	<tr style="background-color:#BDBDBD; color:#FFFFFF; height:30px;">
                	<th>Sr. No.</th>
                    <th>Product Name</th>
                    <th>Point Of Product</th>
                  	<th>Sponsor Name</th>
                    <th>Issue Date</th>
                </tr>
               
 <?php
				
			$i=$rec_limit*$page;
		 $sqls= "select s.id,ac.id , ac.product_name ,ac.points,ac.issue_date ,ac.sponsored_id ,sp.sp_name from tbl_accept_coupon ac join tbl_student s join tbl_sponsorer sp  on ac.sponsored_id = sp.id where s.id =$c_id and ac.stud_id=$stud_id  ORDER BY ac.id  DESC LIMIT $offset, $rec_limit";
			  
				$arr = mysql_query($sqls);
				while($row = mysql_fetch_array($arr))
				{
				$i++;
				
				?>
                <tr>
                	<td align="center"><?php echo $i;?></td>
                    <td align="center"><?php echo $row['product_name'];?></td>
                     <td style="padding-left:30px;"><?php echo $row['points'];?></td>
                     <td style="padding-left:30px;"><?php echo $row['sp_name'];?></td>
                     <td style="padding-left:30px;"><?php echo $row['issue_date'];?></td>
                     
                   
                </tr>
                <?php
				}
				?>
            </table>
 <?php
if( $page > 0 )
{
   $last = $page - 2;
   echo "<a href=\"shopping.php?page=$last&stud_id=$stud_id\">Last 10 Records</a> |";
   echo "<a href=\"shopping.php?page=$page&stud_id=$stud_id\">Next 10 Records</a>";
}
else if( $page == 0 )
{
   echo "<a href=\"shopping.php?page=$page&stud_id=$stud_id\">Next 10 Records</a>";
}
else if( $left_rec < $rec_limit )
{
   $last = $page - 2;
   echo "<a href=\"shopping.php?page=$last&stud_id=$stud_id\">Last 10 Records</a>";
}

?>
	</div>
		</div>
       </div>
      </div>
      </div>
      </div>


<body>
</body>
</html>
