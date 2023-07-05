<?php
include('cookieadminheader.php');
$report = "";
$smartcookie = new smartcookie();
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$sc_id = $result['school_id'];
if (isset($_POST['submit'])) {
    $process = $_POST['process'];
	//$pro360_seq_order = $_POST['pro360_seq_order'];
	$max_points = $_POST['max_points'];
	
    $results = mysql_query("SELECT pro360_ID,pro360_process_description, pro360_seq_order,pro360_max_points FROM tbl_360process where pro360_process_description='$process'");
    if (mysql_num_rows($results) == 0) {
		
		$sql = "select pro360_ID from tbl_360process order by pro360_ID desc";
		
		$rs = mysql_query($sql);
		$result = mysql_fetch_array($rs);
		$pro360_ID = $result['pro360_ID'];
		$pro360_ID += 1;
		
        $query = "insert into tbl_360process(pro360_process_description,pro360_seq_order, pro360_max_points) values('$process','$pro360_ID','$max_points')";
        $rs = mysql_query($query);
        //$successreport = "Record inserted Successfully";
		echo "<script LANGUAGE='JavaScript'>
					window.alert('Process inserted Successfully');
					window.location.href='list_360_feedback_pricess.php';
					</script>";
    } else {
        $errorreport = 'Process already present';
    }
}
?>
<script  src="http://code.jquery.com/jquery-3.2.1.min.js"  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
			<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
			<script type="text/javascript">

function valid() {
	//alert('hi');
var act360_activity = document.getElementById("act360_activity").value;
        var pattern = /^[a-zA-Z ]+$/;
		if(act360_activity.trim()=="" || act360_activity.trim()==null)
		{
			alert("Please enter 360 activity !");
		return false;
		}
        if (pattern.test(act360_activity)) {
            //alert("Your your Academic Year is : " + course);
           // return true;
        }
		else{
        alert("It is not valid 360 activity !");
		return false;
		}
		
}
</script>
<html>
<head>

</head>
<body>
<div class="container" style="padding:25px;"
" >

<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;background-color:#F8F8F8;">

    <form method="post">

        <div class="row">

            <div class="col-md-3 col-md-offset-1" style="color:#700000 ;padding:5px;"></div>

            <div class="col-md-3 " align="center" style="color:#663399;">

                <h2>Add 360 Activity</h2>
                <!-- <h5 align="center"><a href="Add_SubjectSheet_updated_20160109PT.php" >Add Excel Sheet</a></h5>  -->
                <br><br>
            </div>


        </div>

       <div class="row" style="padding-top:30px;">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-2" style="color:#808080;font-size:18px;margin-left:50px">process:<span style="color:red;font-size: 25px;">*</span></div>
                                    <div class="col-md-3">

                <input type="text" name="process" class="form-control " id="process" placeholder="process" style="margin-left:-35px">

            </div>
         </div>
				
		<!--		<div class="row" style="padding-top:30px;">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-2" style="color:#808080;font-size:18px;margin-left:14px"> Pro360 Seq Order:<span style="color:red;font-size: 25px;"></span></div>
                                    <div class="col-md-3">
				
                <input type="text" name="pro360_seq_order" class="form-control" id="pro360_seq_order" placeholder="Pro360 Seq Order">

            </div>
			<br/><br/>
				</div>
 -->
           <div class="row" style="padding-top:30px;">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-2" style="color:#808080;font-size:18px;margin-left:14px"> Max Points:<span style="color:red;font-size: 25px;"></span></div>
                                    <div class="col-md-3">
				
                <input type="text" name="max_points" class="form-control" id="max_points" placeholder="Max Points">

            </div>

            <br/><br/>
        </div>
		
			
	
        <div id="error" style="color:#F00;text-align: center;" align="center"></div>


        <div class="row" style="padding-top:15px;">


            <div class="col-md-2 col-md-offset-4 ">

                <input type="submit" class="btn btn-primary" name="submit" value="Add "
                       style="width:80px;font-weight:bold;font-size:14px;" id = "btnValid" onClick ="return valid()"/>

            </div>


            <div class="col-md-3 " align="left">

                <a href="list_360_feedback_pricess.php" style="text-decoration:none;"> <input type="button"
                                                                                             class="btn btn-primary"
                                                                                             name="Back" value="Back"
                                                                                             style="width:80px;font-weight:bold;font-size:14px;"/></a>

            </div>


        </div>


        <div class="row" style="padding-top:15px;">

            <div class="col-md-4">

                <input type="hidden" name="count" id="count" value="1">

            </div>

            <div class="col-md-11" style="color:#FF0000;" align="center" id="error">


                <?php echo $errorreport; ?>
            </div>

            <div class="col-md-11" style="color:#063;" align="center" id="error">

                <?php echo $successreport; ?>

            </div>

        </div>

    </form>

</div>


</body>
</html>


