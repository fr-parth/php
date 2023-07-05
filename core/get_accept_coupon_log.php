
<?php
include ('function.php');
 $rec_limit = 10;
/* Get total number of records */
$sql = "SELECT count(id) FROM tbl_accept_coupon where sponsored_id =".$_SESSION['id'];
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
<?php
$report="";


$user_type=$_GET['user_type'];
$id=$_SESSION['id'];
if($user_type=="Student")
{

 $arr=mysql_query("select c.id , coupon_id, product_name, points,std_Father_name,std_lastname,std_complete_name,std_name,issue_date ,s.std_img_path from tbl_accept_coupon c join tbl_student s on c.stud_id = s.std_PRN where c.sponsored_id = ".$_SESSION['id'] ." and user_type='student' ORDER BY c.id LIMIT $offset, $rec_limit");    
 }
 else
 {

 $arr=mysql_query("select c.id , coupon_id, product_name, points, t_complete_name,t_lastname,t_name, issue_date ,t_pc from tbl_accept_coupon c join tbl_teacher t on c.stud_id = t.id where c.sponsored_id = ".$_SESSION['id'] ." and user_type='teacher' ORDER BY c.id LIMIT $offset, $rec_limit"); 
 
 }      


?>
<html>
<head>
<style>
table {
    width: 100%;
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {text-align: left;}
</style>
<link rel="stylesheet" href="css/bootstrap.min.css">
 <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>

<script src='js/bootstrap.min.js' type='text/javascript'></script>
</head>
<body>
 <div class="row" style=" background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;" align="center" >
       
        <div id="no-more-tables" >
        <h1><?php echo $user_type; ?></h1>
            <table class=" table-striped table-condensed cf table-bordered" width="80%" style="padding:10px;">
        		<thead  style="background-color:#963939;color:#FFFFFF;" >
        			<tr>
        				<th>Sr. No.</th>
                        <th>Coupon Id</th>
                        <th>User name</th>
                        <th>Product/Discount</th>
                        <th>Photo</th>
                        <th>Points</th>
                        <th>Issue Date</th>
        			</tr>
        		</thead>
        		<tbody>
        		<?php $i=$rec_limit*$page;
                	
				while($row = mysql_fetch_array($arr))
				{
				$i++;
				if($user_type=='Student')
				{
				?>
                <tr>
                	<td data-title="Sr. No." align="center"><?php echo $i;?></td>
                    <td data-title="Coupon Id" align="center"><?php echo $row['coupon_id'];?></td>
                    <td data-title="student name" ><?php if($row['std_complete_name']=="")
					{
					echo $row['std_name']." ".$row['std_Father_name']." ".$row['std_lastname'];
					}
					else
					{
						echo $row['std_complete_name'];
					}
					
					?>
                 
                    
                    </td>
                    <td data-title="Product/Discount" ><?php echo $row['product_name'];?></td>
                    <td data-title="Photo" align="center">
                     <?php if($row['std_img_path']!="" && file_exists($row['std_img_path'])){?><img width="30" height="30" src='<?php echo $row['std_img_path'];?>' style="border:1px solid #999999;" class="img-responsive" alt="Responsive image"><?php }else{?><img width="30" height="30" src='image/avatar_2x.png' style="border:1px solid #999999;" class="img-responsive" alt="Responsive image"> 
                    <?php } ?></td>
                    <td data-title="Points" align="center"><?php echo $row['points'];?></td>
                    <td data-title="Issue Date" align="center"><?php echo $row['issue_date'];?></td>
                </tr>
                <?php
				}
				else
				{
				?>
                 <tr>
                	<td data-title="Sr. No." align="center"><?php echo $i;?></td>
                    <td data-title="Coupon Id" align="center"><?php echo $row['coupon_id'];?></td>
                    <td data-title="student name" > 
                       <?php if($row['t_complete_name']=="")
					{
					echo $row['t_name']." ".$row['t_lastname'];
					}
					else
					{
						echo $row['t_complete_name'];
					}
					
					?></td>
                    <td data-title="Product/Discount" ><?php echo $row['product_name'];?></td>
                    <td data-title="Photo" align="center">
                     <?php if($row['t_pc']!="" && file_exists($row['t_pc'])){?><img width="30" height="30" src='<?php echo $row['t_pc'];?>' style="border:1px solid #999999;" class="img-responsive" alt="Responsive image"><?php }else{?><img width="30" height="30" src='image/avatar_2x.png' style="border:1px solid #999999;" class="img-responsive" alt="Responsive image"> 
                    <?php } ?></td>
                    <td data-title="Points" align="center"><?php echo $row['points'];?></td>
                    <td data-title="Issue Date" align="center"><?php echo $row['issue_date'];?></td>
                </tr>
                <?php
				
				}
				}
				?>
        		</tbody>
        	</table>
							<?php
                if( $page > 0 )
                {
                   $last = $page - 2;
                   echo "<a href=\"accept_coupon_log.php?page=$last\">Last 10 Records</a> |";
                   echo "<a href=\"accept_coupon_log.php?page=$page\">Next 10 Records</a>";
                }
                else if( $page == 0 )
                {
                   echo "<a href=\"accept_coupon_log.php?page=$page\">Next 10 Records</a>";
                }
                else if( $left_rec < $rec_limit )
                {
                   $last = $page - 2;
                   echo "<a href=\"accept_coupon_log.php?page=$last\">Last 10 Records</a>";
                }
                
                ?>
        </div>
    </div>
</body>
</html>