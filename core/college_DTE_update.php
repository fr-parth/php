<?php
include("cookieadminheader.php");
$id = $_GET['id'];
$query = "select * from DTE_college_list where id = '$id'";
$sql =  mysql_query($query);
$row = mysql_fetch_array($sql);
$report="";
$Errorreport="";
if(isset($_POST['submit'])) {
    $college_code = $_POST['College_code'];
    $stream = $_POST['Stream'];
    $college_name = mysql_real_escape_string($_POST['College_Name']);
    $college_location = $_POST['College_Location'];
    $intake = $_POST['intake'];
    $Principal_Name = $_POST['Principal_Name'];
    $contact_number = $_POST['Contact_No'];
    $alternate_contact = $_POST['Altername_Contact'];
    $college_email = $_POST['college_email'];
    $tpo_name = $_POST['tpo_name'];
    $tpo_contact = $_POST['tpo_contact'];
    $tpo_email = $_POST['tpo_email'];
    $number_of_teachers = $_POST['No_Teacher'];
    $number_of_students = $_POST['No_Student'];
    $number_of_subjects = $_POST['No_Subject'];
    $date_Updated = $_POST['date_Updated'];
    $source = $_POST['source'];
    //echo "update DTE_college_list set college_code='$college_code',stream='$stream',college_name='$college_name',college_location='$college_location',intake='$intake',principal_name='$pricipal_name',contact_number='$contact_number',alternate_contact='$alternate_contact',college_email='$college_email',tpo_name='$tpo_name',tpo_contact='$tpo_contact',tpo_email='$tpo_email',number_of_teachers='$number_of_teachers',number_of_students='$number_of_students',number_of_subjects='$number_of_subjects',date_Updated='$date_Updated',source='$source' WHERE id='$id'";
    $sql=mysql_query("update DTE_college_list set college_code='$college_code',stream='$stream',college_name='$college_name',college_location='$college_location',intake='$intake',principal_name='$pricipal_name',contact_number='$contact_number',alternate_contact='$alternate_contact',college_email='$college_email',tpo_name='$tpo_name',tpo_contact='$tpo_contact',tpo_email='$tpo_email',number_of_teachers='$number_of_teachers',number_of_students='$number_of_students',number_of_subjects='$number_of_subjects',date_Updated='$date_Updated',source='$source' WHERE id='$id'");

    if(mysql_fetch_array($sql)>=0){
        $report="Recoard updated successfully !!";
    }else {
        $Errorreport = "please try again";
    }
}

?>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">

                <div class="panel-heading"> <h4><font color="green"><?php if($report!=''){echo $report;}else{ echo $Errorreport;}?></font></h4></div>
                <div class="panel-heading"> <h3>Update DTE College list</h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" role="form">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">College Code</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="College_code" name="College_code" placeholder="College code" value="<?php echo $row['college_code'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">Stream</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="Stream" name="Stream" placeholder="Stream" value="<?php echo $row['stream'];?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">College Name</label>
                            <div class="col-sm-9">
                                <textarea type="text" class="form-control" id="College_Name" name="College_Name" placeholder="College Name">  <?php echo $row['college_name']; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">College Location</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="College_Location" name="College_Location"  placeholder="College Location" value="<?php echo $row['college_location']; ?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">Intake</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="intake"  name="intake" placeholder="Intake" value="<?php echo $row['intake'];?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">Principal Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="Principal_Name" name="Principal_Name" placeholder="Principal Name" value="<?php echo $row['pricipal_name']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">Contact No</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="Contact_No" name="Contact_No" placeholder="Contact No"  value="<?php echo $row['contact_number'];?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">Altername Contact</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="Altername_Contact" name="Altername_Contact" placeholder="Altername Contact"  value="<?php echo $row['alternate_contact'];?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">College Email </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="College_Email" placeholder="College Email" value="<?php echo $row['college_email'];?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">TPO Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="TPO_Name" name="TPO_Name" placeholder="TPO Name" value="<?php echo $row['tpo_name'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">TPO Contact</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="TPO_Contact" name="TPO_Contact" placeholder="TPO Contact" value="<?php echo $row['tpo_contact'];?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label" >TPO Email</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="TPO_Email" name="TPO_Email"placeholder="TPO Email" value="<?php echo $row['tpo_email'];?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">No Of Teacher</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="No_Teacher" id="No_Teacher" placeholder="No Of Teacher" value="<?php echo $row['number_of_teachers'];?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">No of Student</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="No_Student" name="No_Student" placeholder="No of Student" value="<?php echo $row['number_of_students'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">No of Subject</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="No_Subject" name="No_Subject" placeholder="No of Subject" value="<?php echo $row['number_of_subjects'];?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">Date Upadated</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="date_Updated" name="date_Updated" placeholder="Date Upadated" value="<?php echo $row['date_Updated'];?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">Source</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="Source" name="Source" placeholder="Source" value="<?php echo $row['source'];?>" >
                            </div>
                        </div>
                        <div class="form-group">

                        </div>
                        <div class="form-group last">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" name="submit" class="btn btn-success btn-sm">Update</button>
                                <a href="college_list_DTE.php"><input type="button" class="btn btn-danger btn-sm" value="Back"></input></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</html>