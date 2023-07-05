<?php
//Created by Rutuja for adding referral activity reason for SMC-4447 on 23/01/2020
$report="";
  include_once('cookieadminheader.php');
$id=$_SESSION['id'];
 $reason_id=$_GET['reason'];
 $auto_reason_id=$reason_id+1;
           $fields=array("id"=>$id);
		   $table="tbl_school_admin";

		   $smartcookie=new smartcookie();

$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$sc_id=$result['school_id'];
if($_GET['id']=="")
{
if(isset($_POST['submit']))
{
	  $i=0;
	  $reason=$_POST['reason'];

	    $results=mysql_query("select * from referral_activity_reasons where reason='$reason'");
							  //check already class exist or not
								 if(mysql_num_rows($results)==0)
									{
										$query="insert into referral_activity_reasons(reason,reason_id) values('$reason','$auto_reason_id') ";

										$rs = mysql_query($query );
									  echo ("<script LANGUAGE='JavaScript'>

                                alert('$reason Added Successfully');

                                window.location.href='referal_activity_reason.php';
                            </script>");

									}
									else {

                        $report = "$reason already present";

                    }
			
							}






?>


<html>
<head>
<script>


function valid()
{

	var reason=document.getElementById("reason").value;
	if(reason=="")
	{
	alert('Please enter referal activity reason');
	return false;
	}
	

}

</script>
</head>
<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">
<div>

</div>
<div class="container" style="padding:25px;">
        		<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
                   <form method="post">

                    <div style="background-color:#F8F8F8 ;">
                    <div class="row">
                    <div class="col-md-3 col-md-offset-1"  style="color:#700000 ;padding:5px;" >
                      <!-- <input type="button" class="btn btn-primary" name="add" value="Add more" style="width:100px;font-weight:bold;font-size:14px;" onClick="create_input()"/>-->
               			 </div>
              			 <div class="col-md-3 " align="center" style="color:#663399;" >

                   				<h2>Add Reason</h2>
               			 </div>

                     </div>
                  


               <div class="row " style="padding:5px;" >
                 <div class="col-md-2" >

                    </div>
                    <div class="col-md-2" align="left">
                    <b><h4>Enter Reason</h4></b>
                    </div>

               <div class="col-md-3 ">
             <input type="text" name="reason" id="reason" class="form-control " placeholder="Enter Referal Activity Reason">
             </div>
              

                  </div>
               
                   <div class="row" style="padding-top:15px;">
                   <div class="col-md-2">
               </div>
                  <div class="col-md-2 col-md-offset-2 "  >
                    <input type="submit" class="btn btn-primary" name="submit" value="Add " style="width:80px;font-weight:bold;font-size:14px;" onClick="return valid()"/>
                    </div>
                     <div class="col-md-3 "  align="left">
                    <a href="referal_activity_reason.php" style="text-decoration:none;"><input type="button" class="btn btn-danger" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;" /></a>
                    </div>

                   </div>

                     <div class="row" style="padding:15px;">
                     <div class="col-md-4">
                     <input type="hidden" name="count" id="count" value="1">
                     </div>
                      <div class="col-md-3" style="color:#FF0000;" align="center" id="error">


                      <?php echo $report;?>
               			</div>
						</div>
<!--Added new div for Success message by Dhanashri Tak-->

						
					</div>
                       </div>
                </form>





              
</body>
</html>
<?php }else{ 

$id=$_GET['id'];
if(isset($_POST['submit']))
{
	  $i=0;
	  $reason=$_POST['reason'];

	    $results=mysql_query("select * from referral_activity_reasons where reason='$reason'");
							  //check already class exist or not
								 if(mysql_num_rows($results)==0)
									{
										$query="update referral_activity_reasons set reason='$reason' where id='$id'";

										$rs = mysql_query($query );
									  echo ("<script LANGUAGE='JavaScript'>

                                alert('$reason Updated Successfully');

                                window.location.href='referal_activity_reason.php';
                            </script>");

									}
									else {

                        $report = "$reason already present";

                    }
			
							}






?>


<html>
<head>
<script>


function valid()
{

	var reason=document.getElementById("reason").value;
	if(reason=="")
	{
	alert('Please enter referal activity reason');
	return false;
	}
	

}

</script>
</head>
<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">
<div>

</div>
<div class="container" style="padding:25px;">
        		<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
                   <form method="post">

                    <div style="background-color:#F8F8F8 ;">
                    <div class="row">
                    <div class="col-md-3 col-md-offset-1"  style="color:#700000 ;padding:5px;" >
                      <!-- <input type="button" class="btn btn-primary" name="add" value="Add more" style="width:100px;font-weight:bold;font-size:14px;" onClick="create_input()"/>-->
               			 </div>
              			 <div class="col-md-3 " align="center" style="color:#663399;" >

                   				<h2>Update Reason</h2>
               			 </div>

                     </div>
                  


               <div class="row " style="padding:5px;" >
                 <div class="col-md-2" >

                    </div>
                    <div class="col-md-2" align="left">
                    <b><h4>Reason</h4></b>
                    </div>
<?php 
 $result=mysql_query("select * from referral_activity_reasons where id='$id'"); 
 $res=mysql_fetch_array($result);
 $reason=$res['reason'];
 ?>
               <div class="col-md-3 ">
             <input type="text" name="reason" id="reason" class="form-control " placeholder="Enter Referal Activity Reason" value="<?php echo $reason;?>" >
             </div>
              

                  </div>
               
                   <div class="row" style="padding-top:15px;">
                   <div class="col-md-2">
               </div>
                  <div class="col-md-2 col-md-offset-2 "  >
                    <input type="submit" class="btn btn-primary" name="submit" value="Update " style="width:80px;font-weight:bold;font-size:14px;" onClick="return valid()"/>
                    </div>
                     <div class="col-md-3 "  align="left">
                    <a href="referal_activity_reason.php" style="text-decoration:none;"><input type="button" class="btn btn-danger" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;" /></a>
                    </div>

                   </div>

                     <div class="row" style="padding:15px;">
                     <div class="col-md-4">
                     <input type="hidden" name="count" id="count" value="1">
                     </div>
                      <div class="col-md-3" style="color:#FF0000;" align="center" id="error">


                      <?php echo $report;?>
               			</div>
						</div>
<!--Added new div for Success message by Dhanashri Tak-->

						
					</div>
                       </div>
                </form>

	<?php } ?>