<?Php

include("sponsor_header.php");
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
 $left_rec = $rec_count - ($page+2 * $rec_limit);
?>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
  <script src="js/jquery-1.11.1.min.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
          <script>
		
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');

		
		
        </script>
        <style>
		@media only screen and (max-width: 800px) {
    
    /* Force table to not be like tables anymore */
	#no-more-tables table, 
	#no-more-tables thead, 
	#no-more-tables tbody, 
	#no-more-tables th, 
	#no-more-tables td, 
	#no-more-tables tr { 
		display: block; 
	}
 
	/* Hide table headers (but not display: none;, for accessibility) */
	#no-more-tables thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
 
	#no-more-tables tr { border: 1px solid #ccc; }
 
	#no-more-tables td { 
		/* Behave  like a "row" */
		border: none;
		border-bottom: 1px solid #eee; 
		position: relative;
		padding-left: 50%; 
		white-space: normal;
		
	}
 
	#no-more-tables td:before { 
		/* Now like a table header */
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;
		text-align:left;
		font-weight: bold;
	}
 
	/*
	Label the data
	*/
	#no-more-tables td:before { content: attr(data-title); }
}
		</style>
        <script>
		function get_log()
{
		  
		var user_type=document.getElementById("user_type").value;
	
 		
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
         document.getElementById("log").innerHTML  =xmlhttp.responseText;
		
            }
          }
        xmlhttp.open("GET","get_accept_coupon_log.php?user_type="+user_type+"",true);
        xmlhttp.send();

}
		</script>
</head>

<body>

 <div class="panel panel-default"  style="">
 <div class="panel-heading">
    <h2 class="panel-title"><h4>Accepted Coupon Log <span class='badge'><?php echo $rec_count; ?></span></h4></h2>
  </div>
  <div class="panel-body">
 
 
 
 <div class="" style="padding:10px;">
<div class="row"  align="right">
<div class="col-md-2">
        	<select name="user_type" class="form-control" onChange="return get_log()" id="user_type">
			<option value="Student">Student</option>
			<option value="Teacher">Teacher</option>
			</select>
        </div>
  </div>       
 </div>
  <div class="" style="padding:10px;" id="log">
     
       
<div class="row" style=" background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;" align="center" >
       
        <div id="no-more-tables" >
        <h1><?php echo "Student"; 
		
		$arr=mysql_query("select c.id , coupon_id, product_name, points,std_Father_name,std_lastname,std_complete_name,std_name, issue_date ,s.std_img_path from tbl_accept_coupon c join tbl_student s on c.stud_id = s.std_PRN where c.sponsored_id = ".$_SESSION['id'] ." and user_type='student' ORDER BY c.id LIMIT $offset, $rec_limit");
		
		?></h1>
            <table class=" table-striped table-condensed cf table-bordered" width="100%" style="padding:10px;">
        		<thead  style="background-color:#963939;color:#FFFFFF;" >
        			<tr>
        				<th>Sr. No.</th>
                        <th>Coupon ID</th>
                        <th>User Name</th>
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
					
					?></td>
                    <td data-title="Product/Discount" ><?php echo $row['product_name'];?></td>
                    <td data-title="Photo" align="center">
                     <?php if($row['std_img_path']!="" && file_exists($row['std_img_path'])){?><img width="30" height="30" src='<?php echo $row['std_img_path'];?>' style="border:1px solid #999999;" class="img-responsive" alt="Responsive image"><?php }else{?><img width="30" height="30" src='image/avatar_2x.png' style="border:1px solid #999999;" class="img-responsive" alt="Responsive image"> 
                    <?php } ?></td>
                    <td data-title="Points" align="center"><?php echo $row['points'];?></td>
                    <td data-title="Issue Date" align="center"><?php echo $row['issue_date'];?></td>
                </tr>
                <?php
				
			
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

 </div>
 </div> 
 </div>
</body>

</html>
