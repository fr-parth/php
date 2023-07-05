<?php
 include_once('stud_header.php');
 $id=$_SESSION['id'];
	$error="";	
		$query=mysql_query("select * from tbl_student where id='$id' ");
		$result1=mysql_fetch_array($query);
		
		$school_id=$result1['school_id'];
		$std_PRN=$result1['std_PRN'];
		
		
		
		
		$st_points=mysql_query("select id,sc_total_point from tbl_student_reward where sc_stud_id='$std_PRN'");
		$resultset=mysql_fetch_array($st_points);
		        $resultset['id'];
				 $resultset['sc_total_point'];
		$a=date('d-m-y,H:m:s');
		 //$point=@$_GET['point'];
		if(isset($_GET['t_id']))
		{          
		              $reward_point=$_GET['point'];
					  $resultset['sc_total_point'];
		          if($resultset['sc_total_point'] < $reward_point)
				            {
							    $error="Sorry...! you have not sufficient balance ";
							}
							else
							{
							
		                        $reward_ID=$_GET['t_id'];
						 
		                   
				           $sc_total_point=$resultset['sc_total_point'];
						   $resultofpoint=$sc_total_point-$reward_point;
						   $resultofpoint;
						   
						   
						   
				//echo "</br>update tbl_student_reward set sc_total_point='$resultofpoint' where sc_stud_id='$std_PRN'";
				
				$updaterewardpoint=mysql_query("update tbl_student_reward set sc_total_point ='$resultofpoint' where sc_stud_id='$std_PRN'");
				//echo "INSERT INTO `purcheseSoftreward` (`user_id` ,`userType`,`school_id` ,`reward_id` ,`point` ,`date`)VALUES ('$std_PRN','Student','$school_id', '$reward_ID', '$reward_point','now()')";
$insert=mysql_query("INSERT INTO `purcheseSoftreward` (`user_id` ,`userType`,`school_id` ,`reward_id` ,`point` ,`date`)VALUES ('$std_PRN','Student','$school_id', '$reward_ID', '$reward_point','$a')");
                              
							  
							 ?>
                             <script>alert('Congrats..! \n Thank You For Purchasing Reward');
                             window.location="purchase_softreward.php";
                             </script>
                             <?php
							 
		}
	}

?>

 <script>
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
    
    <link href="//cdn.datatables.net/1.10.4/css/jquery.dataTables.css" rel="stylesheet" type="text/css"></link>


  <script>
 function openwindow(t_id,point)
 {

if(t_id!="")
{

window.location = "purchase_softreward.php?t_id="+t_id+"&point="+point;
}
 
 }
 
</script>
<style>
.preview
{
border-radius:50% 50% 50% 50%;  

box-shadow: 0 3px 2px rgba(0, 0, 0, 0.3);
-webkit-border-radius: 99em;
  -moz-border-radius: 99em;
  border-radius: 99em;
  border: 5px solid #eee;
  width:100px;
}
</style>

 
<body style="background-color:#FFFFFF">

 <div class="container" style="padding-top:20px;">
 <div class="col-sm-3" style="padding:20px; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
         <div  style="height:50px; background-color:#0073BD; border:1px solid #0073BD;color:#FFFFFF" align="left">
        		<div style="float:left;"><h4 style="padding-left:20px; margin-top:10px; color:#FFFFFF;font-size:23px;">My Rewards</h4></div>
          </div> 
           <div align="center" style="padding-top:20px;font-size:40px;color: #308C00;
font-weight: bold;
line-height: 1.1;"><?php if($resultset['sc_total_point']=="")
{
echo "0";
}
else
{
echo $resultset['sc_total_point'];
}


 ?> </div>  
              <div align="center" style="color:#0073BD;font-size:20px;">Points</div>    
       	    </div>



<div class="col-md-9">
 <!--<div class="panel panel-default">
 <div style="padding-top:20px;">
 
  <form method="post">
            
            
            <div class="row" style="padding-left:50px;">
           
            <div class="col-md-4">
<input type="text" name="teacher_name" id="teacher_name" placeholder="Enter Teacher Name" class="form-control" value="<?php //if(isset($_POST['teacher_name'])){echo $_POST['teacher_name'];}?>"></input>
            </div>
            <div class="col-md-3">
            <input type="submit" class="btn btn-primary" name="submit" value="Search" >
         </div>
           
                 <div class="col-md-3 "> </div></form></div>
           <div style="height:20px;"></div> 
            </div>
            </div>--->
            
            

  
            <div style="padding-top:20px;">
          <table id="example" class="display table table-striped table-hover dt-responsive" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Reward Image</th>
                        <th>Reward Name</th>
                        <th>Point<th>
                      </tr>
                </thead>
             <?php
                            $i=0;
							
							
							$teacher=mysql_query("SELECT `softrewardId`,`user`,`rewardType`,`fromRange`,`imagepath` FROM `softreward` WHERE `user`='Student'");
					             while($result=mysql_fetch_array($teacher))
							      {
										$softid=$result['softrewardId'];// db row id
										$user=$result['user'];  
										$star=$result['fromRange'];// for points
										$rewardtype=$result['rewardType']; // star trophy 
										$imagespath=$result['imagepath']; // reward image
									$i++;
						?>
	
	
	 <tr>
     
         <td  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;"><?php echo $i; ?></td>
         <td ><img src="<?php echo $imagespath ?>" name="star" height="75" width="75" class="img-responsive" ></td>
                                
                 <td  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;"><?php echo $rewardtype; ?></td>
                 <td  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;"><?php echo $star ?></td>
                 
                  <!--  <td><input type="submit" value="Purchase" name="purchase" id="purchse" class="btn btn-success"></td>-->
         <td> <a class="txt-button" ><input type="submit" value="Purchase" onClick="openwindow('<?php echo $softid; ?>','<?php  echo $star; ?>');" class="btn btn-success"></a></td>
  </tr>
                              <?php
							  $i++;
                              }
							  ?>
     
            </table>  
            <div style="color:#FF0000;"><?php echo $error; ?></div>
            </div>
	
   
   
   
</div>
  </div>
</div>
</div>

 
 </div>
 
 
 

 </body>
 