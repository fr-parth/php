<?php

include('scadmin_header.php');
include('conn.php');
$school_id = $_SESSION['school_id'];


?>

<html>
<head>
</head>
<body>
<?php
?>
<div class="container" style="padding:25px;" >

            	<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">

                    <div style="background-color:#F8F8F8 ;">

                    <div class="row" style="padding-left:30px;">

                    <div class="col-md-4 "  style="color:#700000 ;padding:5px;" >

                       <a href="sc_add_reason.php">

                          <input type="submit" class="btn btn-primary" name="submit" value="Add Reason" style="width:150;font-weight:bold;font-size:14px;"/></a>

               			</div>

                        <div class="col-md-1 "></div>

              			 <div   class="col-md-4 ">

                   				<h3>Reason List </h3>

               			 </div>

                          <!--<div class="col-md-1 "  style="color:#700000 ;padding:5px;" >

                 <a href = "#"><input type="submit" class="btn btn-primary" name="copy" value="Copy from Cookieadmin" style="font-weight:bold;font-size:14px;"/></a>

               			</div>-->

                        </div> 

                <div class="row" style="padding-top:20px;">

                <div class="col-md-0"></div>

                    <div class="col-md-12">

            	<div align="right">

                <table id="example" class="display" width="100%" cellspacing="0">
            
                        <thead>
                    	<tr align="left" ><th>

                        Sr. No.</th><th>Reason Name</th><th>Edit</th><th>Delete</th></tr>

                        </thead>
                        <tbody>

                        <?php

							$i=$rec_limit*$page;

							$sp_id1=$_SESSION['id'];

							$sql = mysql_query("select * from tbl_student_recognition where school_id='$school_id'");

							while($row = mysql_fetch_array($sql))

							{

							$i++;

						?>

                        <tr align="left">
						<td><?php echo $i;?></td>
						<td><?php echo $row['student_recognition'];?></td>
						

                         <td><a href="#" >Edit</a></td>

                     <td> <a onclick="confirmation(<?php ?> )">Delete</a></td>

                    </tr>
                      
                        <?php

							}

						?>
						</tbody>

                    </table>

                <?php echo $report;?>

                </div>

      <!--
                 <div align="center">

        <?php


?></div>-->

       <div style="height:50px;"></div>

            </div>

            </div>

            </div>



               </div>

               </div>





























<?php

/*
$sql = mysql_query("select * from tbl_student_recognition where school_id='$school_id'");
$c = 1;
?>


              
                <table>


									
									<thead>
									<tr>
									<th>Sr.No.</th>
									
									<th>Reason</th>
									
									<th>Edit</th>
									
									<th>Delete</th>
									</tr>
									</thead>
									<tbody>
									<?php
									while($row = mysql_fetch_assoc($sql))
									{
										?>
										<tr>
										<td><?php echo $c; ?></td>
										<td><?php echo $row['student_recognition']; ?></td>
										<td><a href="#" >Edit</a></td>
										<td> <a onclick="confirmation(<?php echo $row['id']; ?> )">Delete</a></td>
										</tr>
										
										<?php
										$c++;
									}



									?>

									</tbody>
									</table>
									

									

</body>
</html>
*/?>