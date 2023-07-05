<?php

$report = "";

include('hr_header.php');

$id = $_SESSION['id'];

$fields = array("id" => $id);

$table = "tbl_school_admin";


$smartcookie = new smartcookie();


$results = $smartcookie->retrive_individual($table, $fields);

$result = mysql_fetch_array($results);

$sc_id = $result['school_id'];

if (isset($_POST['submit'])) {

    $j = 0;

    $count = $_POST['count'];

    $counts = 0;

    $subcode = $_POST['subcode'];
    $Degree_name = $_POST['Degree_name'];
    $Semester_Name = $_POST['Semester_Name'];
	$subtype = $_POST['subtype'];
	$subshortname = $_POST['subsn'];
	$BranchName = $_POST['BranchName'];

    // Loop to store and display values of individual checked checkbox.


    for ($i = 0; $i < $count; $i++) {

        $subject = ucwords(strtolower($_POST[$i]));


        $results = mysql_query("select * from tbl_school_subject where school_id='$sc_id' and subject like '$subject'");


        if (mysql_num_rows($results) == 0 && $subject != "") {
			
//change in insert query done by Pranali for bug SMC-3313
            $query = "insert into tbl_school_subject (subject,school_id,Subject_Code,Semester_id,Degree_name,Subject_type,Subject_short_name,Branch_ID) values('$subject','$sc_id','$subcode','$Semester_Name','$Degree_name','$subtype','$subshortname','$BranchName')";

            $rs = mysql_query($query);

            $subject2[$counts] = $subject;

            $counts++;


        } else {

            $subject1[$j] = $subject;

            $j++;

        }


    }


    $subjects = "";

    if ($counts == 0) {


        for ($i = 0; $i < count($subject1); $i++) {


            if ($j == $i + 1) {

                $subjects = $subjects . " " . $subject1[$i];


            } else {


                $subjects = $subjects . " " . $subject1[$i] . ",";


            }

        }


        if (count($subject1) > 1) {

            $errorreport = $subjects . " subjects are already present . ";

        } else {

            $errorreport = $subject . "Please Enter subject. ";


        }


    } else if ($counts == 1) {
		
//alert for success message and window.location.href added by Pranali for bug SMC-3313

        $successreport = "You have successfully added " . $subject . " subject ";
		
			echo '<script type=\'text/javascript\'>';
			echo 'alert("'.$successreport.'");';
			echo 'window.location.href="list_school_subject.php";</script>';

    } else {

        for ($i = 0; $i < count($subject2); $i++) {


            if ($counts == $i + 1) {

                $subjects = $subjects . " " . $subject2[$i];

            } else {

                $subjects = $subjects . " " . $subject2[$i] . ",";

            }

        }


        $successreport = "You have successfully added " . $subjects . " subjects";
		
//alert for success message and window.location.href added by Pranali for bug SMC-3313
			echo '<script type=\'text/javascript\'>';
			echo 'alert("'.$successreport.'");';
			echo 'window.location.href="list_school_subject.php";</script>';


    }


}


?>

<html>

<head>

    <script>

        var i = 1;

        function create_input() {


            var index = 'E-';

            $("<div class='row formgroup' style='padding:5px;'  ><div class='col-md-3 col-md-offset-4'  ><input type='text' id=" + i + " name=" + i + " class='form-control' placeholder='Enter Subject Code'><input type='text' id=" + i + " name=" + i + " class='form-control' placeholder='Enter Subject Title'><input type='text' id=" + i + " name=" + i + " class='form-control' placeholder='Branch Id'><input type='text' id=" + i + " name=" + i + " class='form-control' placeholder='Degree Name'></div><div class='col-md-3' style='color:#FF0000;' id=" + index + i + " ></div></div>").appendTo('#add');

            i = i + 1;

            document.getElementById("count").value = i;


        }


        function valid() {
//changes done by Pranali for bug SMC-3313
            var subname = document.getElementById("0").value;
			var subcode = document.getElementById("1").value;
            var subtype = document.getElementById("2").value;
            var subsn = document.getElementById("3").value;
            var BranchName = document.getElementById("BranchName").value;
            var Degree_name = document.getElementById("Degree_name").value;
            var Semester_Name = document.getElementById("Semester_Name").value;
            
			regx1 = /^[A-Za-z\s0-9]+$/;
			if (subname.trim() == '' || subname.trim() == null) {
                alert('Please Enter Subject Name');
                return false;

            }

              else if (!regx1.test(subname)) {
                alert('Please Enter valid Subject Name');
                return false;
            }
           
			if (subcode.trim() == '' || subcode.trim() == null) {
               alert('Please Enter Subject Code ');
                return false;

            }
            else if (!regx1.test(subcode)) {
               alert('Please Enter Valid Subject Code');
                return false;
            }
            
			if (subtype.trim() == '' || subtype.trim() == null) {
                alert('Please Enter Subject Type');
                return false;

            }

           else if (!regx1.test(subtype)) {
                alert('Please Enter valid Subject Type');
                return false;
            }
           

            if (subsn.trim() == '' || subsn.trim() == null) {
                alert('Please Enter Subject Short Name');
                return false;

            }

          else if (!regx1.test(subsn)) {
                alert('Please Enter valid Subject Short Name');
                return false;
            }
            

            if (BranchName == "select") {
                alert('Please Select Branch Name');
                return false;

            }
           
            if (Degree_name == "select") {
                alert('Please Select Degree Name');
                return false;
            }

            if (Semester_Name == "select") {
                alert('Please Select Semester Name');
               return false;

            }
           
		   //validation for Excel sheet
            var count=document.getElementById("count").value;

            var index='E-';

            for(var i=0;i<count;i++)
            {

				var values=document.getElementById(i).value;

				
				if(values==null||values=="")
				{
			   
					document.getElementById(index+i).innerHTML='Please Enter Subject code ';
					return false;

				}

				regx=/^[A-Za-z\s0-9]+$/;

					//validation of subject



				if(!regx.test(values))
				{
				
					document.getElementById(index+i).innerHTML='Please Enter valid Subject';
					return false;

				}
            }

            
//changes end

        }

    </script>
<!-- Style added by Pranali-->
<style>
.error {color: #FF0000;}
</style>
</head>

<body bgcolor="#CCCCCC">

<div style="bgcolor:#CCCCCC">

    <div></div>

    <div class="container" style="padding:25px;">


    <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;background-color:#F8F8F8;">

        <form method="post">


            <div class="row">

                <div class="col-md-3 col-md-offset-1" style="color:#700000 ;padding:5px;"></div>

                <div class="col-md-3 " align="center" style="color:#663399;">

                    <h2>Add <?php echo $dynamic_subject;?></h2>


                    <h5 align="center"><a href="Add_SubjectSheet_updated_20160109PT.php">Add Excel Sheet</a></h5>
                    <h5 align="center"><b style="color:red;">All Fields Are mandatory</b></h5>

                </div>

            </div>


            <!-- Design of Add Subject form changed by Pranali for bug SMC-3313 -->			
			
<div class="form-group" style="margin-left:40px;">
	<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;"><?php echo $dynamic_subject; ?> Name: <span class="error"><b> *</b></span></label>

                <div class="col-md-2" style="text-align:left;">

                <input type="text" name="0" class="form-control" id="0" placeholder="<?php echo $dynamic_subject;?> Name" />

                </div>

                
</div>
				<br/><br/>
				
				
<div class="form-group" style="margin-left:40px;">
	<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;"> <?php echo $dynamic_subject; ?> Code: <span class="error"><b> *</b></span></label>
                
				<div class="col-md-2" style="text-align:left;">

                    <input type="text" name="subcode" class="form-control" id="1" placeholder="<?php echo $dynamic_subject;?> Code" />

                </div>
</div>
				 <br/><br/>
				
<div class="form-group" style="margin-left:40px;">
	<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;"> <?php echo $dynamic_subject; ?> Type: <span class="error"><b> *</b></span></label>
               
			   <div class="col-md-2" style="text-align:left;">

                    <input type="text" name="subtype" class="form-control " id="2" placeholder="<?php echo $dynamic_subject;?> Type" />

                </div>
</div>
             <br/><br/>   

<div class="form-group" style="margin-left:40px;">
<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;"> <?php echo $dynamic_subject; ?> Short Name:<span class="error"><b> *</b></span></label>
                
				<div class="col-md-3" style="text-align:left;margin-left:-1px;">

                    <input type="text" name="subsn" class="form-control " id="3" placeholder="<?php echo $dynamic_subject;?> Short Name" />

                </div>
</div>
             <br/><br/>
             
<div class="form-group" style="margin-left:40px;">
<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;"><?php echo $dynamic_subject; ?> Branch: <span class="error"><b> *</b></span></label>

                <div class="col-md-2" style="text-align:left;">

                    <?php
                    
                    $query1 = mysql_query("select distinct branch_Name from tbl_branch_master where school_id='$sc_id'");
                    ?>
                    <select name="BranchName" id="BranchName" class="form-control" onChange="MyAlert(this.value)">
                        <option value="select">Select Branch</option>


                        <?php
                        while ($result1 = mysql_fetch_array($query1)) {
                            ?>


                            <option value=<?php echo $result1['branch_Name']; ?>><?php echo $result1['branch_Name']; ?></option>

                        <?php } ?>

                    </select>


                </div>
</div>
                <br/><br/>
				
<div class="form-group" style="margin-left:40px;">
<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;"><?php echo $dynamic_subject; ?> Degree: <span class="error"><b> *</b></span></label>
               <div class="col-md-2" style="text-align:left;">

               <?php
                 $query1 = mysql_query("select distinct Degee_name from tbl_degree_master where school_id='$sc_id'");
                    ?>
                    <select name="Degree_name" id="Degree_name" class="form-control" onChange="MyAlert(this.value)">
                        <option value="select">Select Degree</option>


                        <?php
                        while ($result1 = mysql_fetch_array($query1)) {
                            ?>


                            <option value=<?php echo $result1['Degee_name']; ?>><?php echo $result1['Degee_name']; ?></option>

                        <?php } ?>

                    </select>


                </div>
</div>
                <br/><br/>
				
<div class="form-group" style="margin-left:40px;">
<label class='control-label col-md-2 col-md-offset-2' style="text-align:left;"><?php echo $dynamic_subject; ?> Semester: <span class="error"><b> *</b></span></label>
                <div class="col-md-3" style="text-align:left;">

                   <?php
                     $query1 = mysql_query("select distinct Semester_Name from tbl_semester_master where school_id='$sc_id'");
                    ?>
                    <select name="Semester_Name" id="Semester_Name" class="form-control" onChange="MyAlert(this.value)">
                        <option value="select">Select Semester</option>


                        <?php
                        while ($result1 = mysql_fetch_array($query1)) {
                            ?>


                            <option value=<?php echo $result1['Semester_Name']; ?>><?php echo $result1['Semester_Name']; ?></option>

                        <?php } ?>

                    </select>


                </div>

                <div class="col-md-4" id="E-0" style="color:#FF0000;"></div>
</div>
				
		<br/><br/>

                <div class="col-md-4" id="E-0" style="color:#FF0000;"></div>


           


            <div id="error" style="color:#F00;text-align: center;" align="center"></div>

            <div id="add"></div>


            <div class="row" style="padding-top:15px;">


                <div class="col-md-2 col-md-offset-4 ">

                 <input type="submit" class="btn btn-primary" name="submit" value="Add" style="width:80px;font-weight:bold;font-size:14px;margin-left:33px;" onClick="return valid()"/>

                </div>


                <div class="col-md-3 " align="left">

                    <a href="list_school_subject.php" style="text-decoration:none;"> <input type="button" class="btn btn-danger" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;margin-left:-25px;"/></a>

                </div>


            </div>
 </div>

            <div class="row" style="padding-top:15px;">

                <div class="col-md-4">

                    <input type="hidden" name="count" id="count" value="1">

                </div>

                <div class="col-md-11" style="color:#FF0000;" align="center" id="error">


                    <?php echo $errorreport; ?>

                </div>
<!--changes end -->
             </div>


        </form>


    </div>

</div>


</body>

</html>
