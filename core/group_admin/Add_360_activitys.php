<?php
include('groupadminheader.php');
$report = "";
//$smartcookie = new smartcookie();
//$results = $smartcookie->retrive_individual($table, $fields);
//$result = mysql_fetch_array($results);
/*Below conditions & entity added by Rutuja for differentiating between Group Admin & Group Admin Staff for fetching their group_member_id for adding Feedback Activities for SMC-4557 on 26/03/2020*/
$entity = $_SESSION['entity'];
if($entity==12)
{ 
$group_member_id = $_SESSION['id'];
}
if($entity==13)
{ 
$group_member_id = $_SESSION['group_member_id'];
}
$sc_id =0;
if (isset($_POST['submit'])) {
	
    $activity = trim($_POST['activity']);
	$activity_level_ID = $_POST['activity_level_ID'];
	$credit_points = $_POST['credit_points'];
	if($activity!='')
	{
    $results = mysql_query("SELECT act360_ID,act360_activity,act360_activity_level_ID,act360_credit_points,act360_school_ID FROM tbl_360activities where group_member_id='$group_member_id' and act360_school_ID='0' and act360_activity='$activity'");
	
	if($activity_level_ID=='4')
	{
		//echo "SELECT act360_activity_level_ID,act360_school_ID,group_member_id FROM tbl_360activities where group_member_id='$group_member_id' and act360_school_ID='$sc_id' "; exit;
		$results = mysql_query("SELECT act360_activity_level_ID,act360_school_ID,group_member_id FROM tbl_360activities where group_member_id='$group_member_id' and act360_school_ID='$sc_id' and act360_activity_level_ID='4'");
		
		//$result=mysql_num_rows($a);
	}
	
    if (mysql_num_rows($results) == 0) {
        $query = "insert into tbl_360activities(act360_activity,act360_activity_level_ID, act360_credit_points,group_member_id,act360_school_ID) values('$activity','$activity_level_ID','$credit_points','$group_member_id','0')";
        $rs = mysql_query($query);
        //$successreport = "Record inserted Successfully";
		echo "<script LANGUAGE='JavaScript'>
					window.alert('Record inserted Successfully');
					window.location.href='list_360_feedback_activitys.php';
					</script>";
    } else {
        $errorreport ='Activity already present';
    }
	}
	else
	{
		$errorreport='Please Enter Activity';
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
                                    <div class="col-md-2" style="color:#808080;font-size:18px; margin-left:12px">360 Activity:<span style="color:red;font-size: 25px;"></span></div>
                                    <div class="col-md-3">

                <input type="text" name="activity" class="form-control " id="activity" placeholder="Activity" >

            </div>
         </div>
 		
            <div class="row" style="padding-top:30px;">
                <div class="col-md-4"></div>
                <div class="col-md-2" style="color:#808080; font-size:18px;     margin-left: 13px;" > Activity Level<span
                            style="color:red;font-size: 25px;"></span></div>
                <div class="col-md-3">
                    <select name="activity_level_ID" id="activity_level_ID" class="form-control" required  ">
                        <option value="" disabled selected> Select Activity Level</option>
                        <?php
                        $sql = "SELECT * FROM tbl_360activity_level";
                        $query = mysql_query($sql);
                        while ($rows = mysql_fetch_assoc($query)) { ?>
                            <option value="<?php echo $rows['actL360_ID']; ?>" <?php if($rows['actL360_ID']==$actL360_activity_level){ echo "selected";}else{}?>><?php echo $rows['actL360_activity_level'];?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-md-4 col-md-offset-5"  style="color:#F00; text-align: center;">
                <span class="error"><?php echo $Errcourselevel; ?></span>
            </div>
	
	
	
			 <div class="row" style="padding-top:30px;">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-2" style="color:#808080;font-size:18px;margin-left:14px"> Credit Points:<span style="color:red;font-size: 25px;"></span></div>
                                    <div class="col-md-3">
				
                <input type="number" name="credit_points" class="form-control " id="credit_points" placeholder="Credit Points">

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

                <a href="list_360_feedback_activitys.php" style="text-decoration:none;"> <input type="button"
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


