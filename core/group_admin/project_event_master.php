<?php
include("groupadminheader.php");
//include('../conn.php');


$uploaded_by = $_SESSION['group_admin_id'];
$group_type = $_SESSION['data'][0]['group_type'];
$group_name = $_SESSION['data'][0]['group_name'];
$group_member_id = $_SESSION['group_admin_id'];


/*function url(){
  return sprintf(
    "%s://%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['SERVER_NAME']
  );
}*/

if($_SESSION['entity'] !=12){

	echo "You are not authorize to view this page.";
	exit;
}

if(isset($_POST["submit_file"]))
 { 
 	// echo "HELLO"; exit;
		// $id=$_POST['dropcoll']; 
//$school_name = $_POST['school_name']; 
		$proid = mysql_real_escape_string($_POST['project_id']);
		$pro_name= mysql_real_escape_string($_POST['project_name']);
		$pro_info= mysql_real_escape_string($_POST['project_info']);
		$dt_start= mysql_real_escape_string(date('Y-m-d H:i:s',strtotime($_POST['event_dt_start'])));
		if($_POST['event_dt_end']!=''){
			$dt_end= mysql_real_escape_string(date('Y-m-d H:i:s',strtotime($_POST['event_dt_end'])));
		}else{
			$dt_end= $_POST['event_dt_end'];
		}
		$pro_sponser= mysql_real_escape_string($_POST['project_sponser']);
		
      				if(($proid!='') && ($pro_name!=''))
						{	
							$sql="INSERT INTO tbl_project_event set project_id ='$proid',project_name='$pro_name',project_info='$pro_info',project_sponsor='$pro_sponser',event_date_start='$dt_start',event_date_end='$dt_end',project_origin='group', origin_id='$group_member_id' ";
			// print_r($sql); exit;
							$insert=mysql_query($sql); 
							if($insert)	
							{
							$successreport="Data Inserted Successfully ";
							}
							else
							{
				$successreport1="Data Not Inserted";
							}
							
							
						}
						else
						{
							
		$successreport1="Please Try Again";
						}
	 }  


?>
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
<style type="text/css">
	.row{
		padding-top: 10px;
	}
</style>
	<div class='container'>

		<div class='panel panel-default'>

		<div class='panel-heading' align ='center'><h2>Add Project Event</h2></div>
			<form method="post" action="" onsubmit="return pvalid();">
				<div class="panel-body" style="margin-top:10px;">
				 	<div class="center-block">
						<div class="row">
                			<label for="type" class ="control-label col-md-3">Event Code<span style="color:red;">*</span>:</label>
						 	<div class="col-md-4" >
							 	<input type="text" class="form-control" name="project_id" id="project_id" max="20" />
							</div>
							<div class="col-md-5" style="color:red;" id="project_id_err"></div>
						</div>
						<div class="row">
                			<label for="type" class ="control-label col-md-3">Event Name<span style="color:red;">*</span>:</label>
							<div class="col-md-4">
								<input type="text" class="form-control" name="project_name" id="project_name" />
							</div>
							<div class="col-md-5" style="color:red;" id="project_name_err"></div>
						</div>
						<div class="row">
                			<label for="type" class ="control-label col-md-3">Event Description:</label>
							<div class="col-md-4">
								<textarea name="project_info" class="form-control" id="project_info" rows="3"></textarea>
							</div>
							<div class="col-md-5"></div>
						</div>
						<div class="row">
                			<label for="type" class ="control-label col-md-3">Event Sponser:</label>
							<div class="col-md-4">
								<input type="text" class="form-control" name="project_sponser" id="project_sponser" />
							</div>
							<div class="col-md-5" style="color:red;" id="project_sponser_err"></div>
						</div>
						<div class="row">
                			<label for="type" class ="control-label col-md-3">Event Date start<span style="color:red;">*</span>:</label>
							<div class="col-md-4">
								<input type="text" class="form-control" name="event_dt_start" id="event_dt_start" />
							</div>
							<div class="col-md-5" style="color:red;" id="event_dt_start_err"></div>
						</div>
						<div class="row">
                			<label for="type" class ="control-label col-md-3">Event Date End:</label>
							<div class="col-md-4">
								<input type="text" class="form-control" name="event_dt_end" id="event_dt_end" />
							</div>
							<div class="col-md-5" style="color:red;" id="event_dt_end_err"></div>
						</div>
						
						<div class="row">
							<div class="col-md-offset-6 col-md-6">
								<input class="btn btn-success" type="submit" name="submit_file" value="Submit"/>
							</div>
						</div>
					</div>
				</div>
				
			</form>

		</div>
		<div class="row" style="padding:30px;padding-left:330px;">
	        <div class="col-md-10" style="color:#F00;"  id="error">
	            <b><?php echo $successreport1; ?></b>
	        </div>
	    </div>
		<div class="row" style="padding:30px;padding-left:350px;">
	        <div class="col-md-7" style="color:#008000;" align="center" id="error">
	            <b><?php echo $successreport; ?></b>
	        </div>
	    </div>	
	</div>
	<script src="../js/jquery-1.11.1.min.js"></script>
<script src='../js/bootstrap.min.js' type='text/javascript'></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="../js/moment.js"></script>
<script src="../js/bootstrap-datetimepicker.js"></script>

<script>
	
function pvalid() {
	
			var newpwd = document.getElementById("project_id").value;
            if (newpwd.trim() == "" || newpwd.trim() == null) {
				
                document.getElementById("project_id_err").innerHTML = "Enter Project Id";
                return false;
            }else{
				
                document.getElementById("project_id_err").innerHTML = ""; 
            }
			var confirmpwd = document.getElementById("project_name").value;
            if (confirmpwd.trim() == "" || confirmpwd.trim() == null) {
                document.getElementById("project_name_err").innerHTML = "Enter Project Name";
                return false;
            }else{
                document.getElementById("project_name_err").innerHTML = ""; 
            }
		}

    $(function () {
        $('#event_dt_start').datetimepicker({
          format:'DD-MM-YYYY HH:mm',
          stepping: 15,
          minDate: moment().add(0, 'days')
        });
        $('#event_dt_end').datetimepicker({
          format:'DD-MM-YYYY HH:mm',
          stepping: 15,
          useCurrent: false //Important! See issue #1075
        });
        $("#event_dt_start").on("dp.change", function (e) {
            $('#event_dt_end').data("DateTimePicker").minDate(e.date);
            // $(this).datetimepicker('hide');
        });
        $("#event_dt_end").on("dp.change", function (e) {
            $('#event_dt_start').data("DateTimePicker").maxDate(e.date);
            // $(this).datetimepicker('hide');

        });

    });
</script>