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
			
			

  		 $stud_id=$_GET['stud_id'];
         $school_id=$_GET['sch_id'];
		 	if(empty($_SESSION['test'])) 
		{
			$_SESSION["stud_prn"] = $stud_id;
			$_SESSION["School_id"] = $school_id;
		}   
  	//retive child information using stud_id
		$result=mysql_query("select * from tbl_student where std_PRN='".$_SESSION["stud_prn"]."' and school_id='".$_SESSION["School_id"]."'");
		$rows=mysql_fetch_array($result);
  ?> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
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
      
</head>

<body >
<div class="row" style="padding:10px;">
  <div class="col-md-3">
      
                    <div class="container" style="background-color:#FFFFFF;border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;" align="center">
                          <div class="row"><div class="col-md-16"> <b>Name:</b> <?php  echo $rows['std_complete_name']; ?></div></div>
                          <div class="row"><div class="col-md-16"> <?php if($rows['std_img_path']!="")
                          {?> <img src="<?php  echo $rows['std_img_path'];?>" width="50px;" height="60px;" /> <?php } else { ?><img src="image/avatar_2x.png"  width="50px;" height="60px;"/> <?php }?></div></div>
                          <div class="row"><div class="col-md-16"><b>School Name:</b><?php	echo $rows['std_school_name'];?></div> </div>
                          <div class="row"><div class="col-md-16"><b> Class:</b><?php	echo $rows['std_class'];?></div> </div> 
                           <div class="row"><div class="col-md-16"><b> Division:</b><?php	echo $rows['std_div'];?> </div></div>
                          <div class="row"><div class="col-md-16"><b> Roll No:</b><?php	echo $rows['std_PRN'];?></div> </div>        
                      </div>
     </div>
        <div class="col-md-9 " >               
               
                 
                     <ul class="nav nav-tabs">
                        <li class="active">
                       <a href="stud_rewardpoint.php?stud_id=<?php echo  $_SESSION["stud_prn"];?>&sch_id=<?php echo $_SESSION["School_id"]; ?>" style="color:#000000">Reward Point </a>
                        </li>
                       <!-- <li><a href="student_point.php?stud_id=<?php echo  $_SESSION["stud_prn"];?>" style="color:#000000">Point</a></li>-->
                        <li><a href="student_reward.php?stud_id=<?php echo $_SESSION["stud_prn"];?>&sch_id=<?php echo $_SESSION["School_id"]; ?>" style="color:#000000">Reward</a></li>
   					 </ul>
                                  <!--<nav  style="background-color:#CC99CC;" >
                           
                            
                              <ul  id="main-menu">
                               <li><a href="student_point.php?stud_id=<?php echo  $_SESSION["stud_prn"];?>" style="color:#000000">Point</a></li>
                               <li><a href="student_reward.php?stud_id=<?php echo $_SESSION["stud_prn"];?>" style="color:#000000">Reward</a></li>
                                <li><a href="stud_rewardpoint.php?stud_id=<?php echo $_SESSION["stud_prn"];?>" style="color:#000000">Reward Point </a></li>
                              </ul>
                            </nav>-->
                          
                            </div>

  
  </div>
  </div>
  <div class="row " style="padding:10px;">
  <div class="col-md-3">
   <div  class="container" style=" background-color:#FFFFFF;border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;" >
   
   <div style="font-weight:bold;font-size:24px;color:#000000;padding-bottom:10px;" align="center">Sponsor</div>
                          <?php
		
						  $arr=mysql_query("select * from  tbl_sponsorer where sp_city like '$city' and sp_country like 
						  '$country' ");
						        while($results=mysql_fetch_array($arr))
								{?>
                                <div style="padding-left:30px;" align="left"> <?php echo $results['sp_name'];?> </div>  <?php }?>  
                      </div>
  </div>
  <div class="col-md-9">
  <div  class="container">

  <div  class="row"  >
                      <h1 style="padding-left:20px; ">Reward Points </h1>
            </div>
            <div class="container" style="background-color:#FFFFFF; border:1px solid #CCCCCC;">

<!--<div  class="container" style="background-color:#FFFFFF; border:1px solid #CCCCCC;margin-top:10px;">-->
<!--<table style=" border:1 px solid;">
<tr style="background-color:#BDBDBD; color:#FFFFFF; height:30px;">
		 <td  style="height:25px;color:#FFFFFF;font-size:14px;font-weight:bold;" align="center">
         Sr No
        </td>
        <td  style="height:25px;color:#FFFFFF;font-size:14px;font-weight:bold;" align="center">
        Activity
        </td>
        <td  style="height:25px;color:#FFFFFF;font-size:14px;font-weight:bold;" align="center">
        Total
        </td>
</tr>
<?php  $sql="select sum(sc_point) as total_point ,sc_list, sc_id from  tbl_studentpointslist spl join tbl_student_point sp on sp.sc_studentpointlist_id=spl.sc_id  where  sc_stud_id='".$_SESSION["stud_prn"]."' and sp.school_id='".$_SESSION["School_id"]."' GROUP BY sc_list ORDER BY sc_id DESC";
		$row=mysql_query($sql);
		$i=1;
		while($results=mysql_fetch_array($row))
		{
?>
<tr>
        <td align="center">
        	<?php echo $i;$i++;?>
        </td>
        <td style="padding-left:180px;">
        	<?php echo $results['sc_list'];?>
        </td>
        <td align="center">
        	
            <?php echo $results['total_point'];?>
        </td>
</tr>
<?php } ?>
</table>
</div>-->


      <div id="no-more-tables" >
            <table class=" table-striped table-condensed cf table-bordered" width="100%" style="padding:10px;">
        		<thead  style="background-color:#BDBDBD;color:#FFFFFF;" >
        			<tr>
        				<th align="center"> Sr. No.</th>
                        <th align="center"> Activity</th>
                        <th align="center">Total</th>
						<th align="center">Date</th>
                       
        			</tr>
        		</thead>
        		<tbody>
        		<?php
                //echo $school_id;
                	  $sql="select sum(sc_point) as total_point ,point_date,sc_list, sc_id from  tbl_studentpointslist spl join tbl_student_point sp on sp.sc_studentpointlist_id=spl.sc_id  where  sc_stud_id='".$_SESSION["stud_prn"]."' and sp.school_id='".$_SESSION["School_id"]."' GROUP BY sc_list ORDER BY sc_id DESC";
					  $sum=0;
		$arr=mysql_query($sql);
		$i=0;
				while($row = mysql_fetch_array($arr))
				{
					$sum = $sum+$row['total_point'];
				$i++;
				?>
                <tr>
                	<td data-title="Sr. No." align="center"><?php echo $i;?></td>
                    <td data-title="Activity" align="center"><?php echo $row['sc_list'];?></td>
                    <td data-title="Total" > <?php echo $row['total_point'];?></td>
					<td data-title="Total" > <?php echo $row['point_date'];?></td>
                    
                </tr>
                <?php
				}
				echo $sum;
				?>
        		</tbody>
        	</table>

        </div>
    </div>















</div>
</div>
</div>
</div>
</body>
</html>
