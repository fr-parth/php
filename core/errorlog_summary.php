<?php
include("cookieadminheader.php");

$fromd=$_GET['fr'];
$tod=$_GET['too'];
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>

    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<script src="js/jquery.twbsPagination.js" type="text/javascript"></script>
	<script>
        $(function () {
            $("#from_date").datepicker({
               // changeMonth: true,
                //changeYear: true
				dateFormat: 'yy-mm-dd',
			maxDate:0
            });
        });
        $(function () {
            $("#to_date").datepicker({
                //changeMonth: true,
                //changeYear: true,
				dateFormat: 'yy-mm-dd',
				maxDate:0
            });
        });
    </script>
<title>Smart Cookie </title>
<!--<script src='js/bootstrap.min.js' type='text/javascript'></script>-->
<!--<link href="css/style.css" rel="stylesheet">-->
 <link rel="stylesheet" href="/lib/w3.css">
<style>
.shadow{
   box-shadow: 1px 1px 1px 2px  #694489;
}

.shadow:hover{

 box-shadow: 1px 1px 1px 3px  #694489;
}
.radius{
    border-radius: 5px;
}
.hColor{
    padding:3px;
    border-radius:5px 5px 0px 0px;
    color:#fff;
    background-color: rgba(105,68,137, 0.8);
}

</style>
</head>
<body>


<div class="container" style="width:100%">
<div class="row">

<div class="col-md-15" style="padding-top:15px;">
<div class="radius " style="height:50px; width:100%; background-color:#694489;" align="center">
        	<h2 style="padding-left:20px;padding-top:15px; margin-top:20px;color:white">Error Log Summary Report</h2>
        </div>

</div>
</div>
<br>
<div class='row col-md-offset-2 col-md-8 ' >
		<form style="margin-top:5px;" method="post">
		<div class="col-md-1" style="font-weight:bold; margin-right:-36px;"> From &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <div class="col-md-offset-1 col-md-1" style="width:30%;">
                <input type="text" id="from_date" name="from_date" placeholder="YYYY/MM/DD" class="form-control" value="<?php if ($_POST['from_date'] !='') {echo $_POST['from_date'];} else if($fromd !=''){ echo $fromd;} else{ echo date('Y-m-d');} ?>" autocomplete="off"></div>
            <div class="col-md-1" style="font-weight:bold; margin-right:-45px;margin-left: -10px"> To&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <div class="col-md-offset-1 col-md-1" style="width:30%;">
                <input type="text" id="to_date" name="to_date" placeholder="YYYY/MM/DD" class="form-control" value="<?php if ($_POST['to_date'] !='') {echo $_POST['to_date'];}else if($tod !=''){ echo $tod;}else { echo date('Y-m-d 23:59:59');} ?>" autocomplete="off">
            </div>
            <div class="col-md-1"><input type="submit" name="find" value="Find" class="btn btn-primary"></div>
           
          
			</form>
		
		</div>
		<br>
		<br>
		<?php 
		
		if($_POST['from_date'] =='')
	{
		$from_date=date('Y-m-d');
	}else 
	{
		$from_date = $_POST['from_date'];
	}
	
	if($_POST['to_date'] =='')
	{
		$to_date=date('Y-m-d 23:59:59');
	}else 
	{
		$to_date = $_POST['to_date'];
	}
  
	 	
		   
// if($_GET['reset']){
	// unset($_SESSION['from']);
	// unset($_SESSION['to']);
	//header("Location:errorlog_summary.php"); 
// }		
		
if (isset($_POST['find'])) {
	
 $_SESSION['to']= $to_date;
	 $_SESSION['from']= $from_date;
	$cond="and datetime between '$from_date' and '$to_date' ";
	//echo date();
}
else if($_SESSION['from'] !='' && $_SESSION['to'] !='')
{
	$cond="and datetime between '".$_SESSION['from']."' and '".$_SESSION['to']."' ";
}else {
	$cond="and datetime between '$from_date' and '$to_date' ";
}
		?>
<div class="row" style="padding-top:10px; width:100%;">

<div  style="padding-top:20px;">
 <div class="col-sm-1" style="padding-top:20px;" ></div>

 <a href="list_error_type_log.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #694489;">
                	<h4 class="" align="center">Error Type</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#7647a2;font-weight:bold;">
									<?php
									$qr=mysql_query("select distinct(error_type) from tbl_error_log where error_type !='' and (error_type !='A-login') AND (error_type!='A-log') $cond ");
									$result = mysql_num_rows($qr);
                                                 echo $result;


                                    ?>

                        		</div>

                </div></a>
</div>


<div class="col-sm-1" style="padding-top:20px;" ></div>
 <a  href="list_email_error_log.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #694489;">
                	<h4 align="center">Email</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#7647a2;font-weight:bold;">
									<?php
                $qr=mysql_query("select distinct(email) from tbl_error_log where email !='' $cond ");
									$result = mysql_num_rows($qr);
                                                 echo $result;

				?>

                        		</div>

                </div></a>



<div class="col-sm-1" style="padding-top:20px;"></div>
 <a href="error_webservice_log.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #694489; ">
                	<h4 align="center">Webservice Name</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#7647a2;font-weight:bold;">
									 <?php
               $qr=mysql_query("select distinct(webservice_name) from tbl_error_log where webservice_name !='' $cond ");
									$result = mysql_num_rows($qr);
                                     echo $result;
				?>

                        		</div>

                </div></a>
</div>


<div class="row" style="padding-top:10px; width:100%;">

<div  style="padding-top:40px;">
<div class="col-sm-1" style="padding-top:20px;" ></div>
 <a href="error_app_name_list.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #694489;">
                	<h4 align="center">App Name</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#7647a2;font-weight:bold;">
									<?php
									  $qr=mysql_query("select distinct(app_name )from tbl_error_log where app_name !='' $cond ");
									$result = mysql_num_rows($qr);
                                     echo $result;


                                    ?>

                        		</div>

                </div></a>
</div>


<div class="col-sm-1" style="padding-top:20px;"></div>
 <a href="user_type_error_log.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #694489; ">
                	<h4 align="center">User Type</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#7647a2;font-weight:bold;">
									<?php  $qr=mysql_query("select distinct(user_type) from tbl_error_log where user_type !='' $cond ");
									$result = mysql_num_rows($qr);
                                     echo $result;
                                    ?>

                        		</div>

                </div></a>


<div class="col-sm-1" style="padding-top:20px;"></div>
 <a href="error_school_name_list.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #694489; ">
                	<h4 align="center">School ID</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#7647a2;font-weight:bold;">
									<?php   $qr=mysql_query("select distinct(school_id) from tbl_error_log where school_id !='' $cond ");
									$result = mysql_num_rows($qr);
                                     echo $result;


                                    ?>

                        		</div>

                </div></a>
</div>				
			



</div>










</body>
</html>







<!--
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smart Cookie </title>
<link href="css/style.css" rel="stylesheet">
<style>
.shadow{
   box-shadow: 1px 1px 1px 2px  rgba(150,150,150, 0.4);
}

.shadow:hover{

 box-shadow: 1px 1px 1px 3px  rgba(150,150,150, 0.5);
}
.radius{
    border-radius: 5px;
}
.hColor{
    padding:3px;
    border-radius:5px 5px 0px 0px;
    color:#fff;
    background-color: rgba(105,68,137, 0.8);
}

</style>

</head>
<body>
<div class="container" style="width:100%">
<div class="row">

<div class="col-md-15" style="padding-top:15px;">
<div style="height:50px; width:100%; background-color:#FFFFFF;box-shadow: 0px 1px 3px 1px #666666;" align="left">
        	<h2 style="padding-left:20px;padding-top:10px; margin-top:20px;">Dashboard</h2>
        </div>

</div>
</div>

<div class="row" style="padding-top:10px; width:100%;padding-left:15px;">

<div  style="padding-top:20px;">
 <div class="col-sm-1" style="padding-top:20px;" ></div>

 <a href="school_list.php" style="text-decoration:none";>
    <div class="col-md-3 " style="background-color:#FFFFFF; border:1px solid #CCCCCC; box-shadow: 0px 1px 3px 1px #666666;">
                	<h4 align="center">No. of Schools</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#308C00;font-weight:bold;">
									<?php $row=mysql_query("select * from tbl_school_admin where school_id!='0'");
                                             $result=mysql_num_rows($row);
                                                 echo $result;


                                    ?>

                        		</div>

                </div></a>
</div>


<div class="col-sm-1" style="padding-top:20px;" ></div>
 <a href="teacher_list.php" style="text-decoration:none";>
    <div class="col-md-3" style="background-color:#FFFFFF; border:1px solid #CCCCCC; box-shadow: 0px 1px 3px 1px #666666;">
                	<h4 align="center">No. of Teachers</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#308C00;font-weight:bold;">
									<?php
                $result = mysql_query('SELECT COUNT(id) AS total_teachers FROM tbl_teacher where school_id!=""');
				$row = mysql_fetch_array($result);
					echo $row['total_teachers'];

				?>

                        		</div>

                </div></a>



<div class="col-sm-1" style="padding-top:20px;"></div>
 <a href="student_list.php" style="text-decoration:none";>
    <div class="col-md-3" style="background-color:#FFFFFF; border:1px solid #CCCCCC; box-shadow: 0px 1px 3px 1px #666666;">
                	<h4 align="center">No. of Students</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#308C00;font-weight:bold;">
									 <?php
                $result = mysql_query('SELECT COUNT(id) AS total_students FROM tbl_student where school_id!=""');
				$row = mysql_fetch_array($result);
		 			    echo $row['total_students'];
				?>

                        		</div>

                </div></a>
</div>


<div class="row" style="padding-top:10px; width:100%;">

<div  style="padding-top:40px;">
<div class="col-sm-1" style="padding-top:20px;" ></div>
 <a href="sponsor_list.php" style="text-decoration:none";>
    <div class="col-md-3" style="background-color:#FFFFFF; border:1px solid #CCCCCC; box-shadow: 0px 1px 3px 1px #666666;">
                	<h4 align="center">No. of Sponsors</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#308C00;font-weight:bold;">
									<?php
									    $row=mysql_query("select * from tbl_sponsorer");
                                             $result=mysql_num_rows($row);
                                                 echo $result;


                                    ?>

                        		</div>

                </div></a>
</div>


<div class="col-sm-1" style="padding-top:20px;"></div>
 <a href="parent_list.php" style="text-decoration:none";>
    <div class="col-md-3" style="background-color:#FFFFFF; border:1px solid #CCCCCC; box-shadow: 0px 1px 3px 1px #666666;">
                	<h4 align="center">No. of Parents</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#308C00;font-weight:bold;">
									<?php $row=mysql_query("select * from tbl_parent");
                                             $result=mysql_num_rows($row);
                                              echo $result;


                                    ?>

                        		</div>

                </div></a>


<div class="col-sm-1" style="padding-top:20px;"></div>
 <a href="CookieAdminStaff_list.php" style="text-decoration:none";>
    <div class="col-md-3" style="background-color:#FFFFFF; border:1px solid #CCCCCC; box-shadow: 0px 1px 3px 1px #666666;">
                	<h4 align="center">No. of Staff</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#308C00;font-weight:bold;">
									<?php $row=mysql_query("select * from tbl_cookie_adminstaff");
                                             $result=mysql_num_rows($row);
                                              echo $result;


                                    ?>

                        		</div>

                </div></a>
</div>


</div>









</div>

</body>
</html>





-->
