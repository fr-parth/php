<?php
		session_start();

      $report="";

		include_once('scadmin_header.php');
		$school_id=$_SESSION['school_id'];
		$group_member_id=$_SESSION['group_member_id'];

	if(isset($_POST['submit']))
	{
		$activity_type_id=$_POST['activity_type'];
		$activity1=$_POST['activity'];
		$activity2 = explode (",", $activity1);
		$activity = $activity2[1];
		$activity_id = $activity2[0];
		$SubjectName1=$_POST['SubjectName'];
		$SubjectName2 = explode (",", $SubjectName1);
		$subject_name = $SubjectName2[1];
		$subject_id = $SubjectName2[0];
		$sub_activity=$_POST['sub_activity'];
		$point=$_POST['point'];
//$sub_activity inserted into a_desc column by Pranali for SMC-4999 on 8/12/20
  $sqls= "INSERT INTO tbl_onlinesubject_activity_achivement(a_desc,a_activity_id,a_sub_activity_id,a_alloc_points,subject_id,subject_name,school_id,group_member_id) VALUES ('$sub_activity','$activity_type_id','$activity_id','$point','$subject_id','$subject_name','$school_id','$group_member_id')"; 

	$result_insert = mysql_query($sqls) or die(mysql_error()); 
			if($result_insert>=1){
		echo "<script type='text/javascript'>alert('Successfully Registered');

				window.location.href='subactivity_list.php';
				</script>";

		
		}
		
	}
?>

<!DOCTYPE html>


  <head>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function () {
        $('#btn').click(function () {
            $(".error1").hide();
            
        });
        $('#submit').click(function () {
            $(".error1").show();
            
        });
    });
	</script>
</head>
<!-- changes end-->
 <link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
  <script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
  <script src='js/bootstrap-switch.min.js' type='text/javascript'></script>
  <script src='js/bootstrap-multiselect.js' type='text/javascript'></script>
   <script type="text/javascript">
            $(function () {

                $("#id_checkin").datepicker({
                    changeMonth: true,
                    changeYear: true
                });

            });
        </script>
  <style>
  body {
   background-color:#F8F8F8;
   }
  .indent-small {
  margin-left: 5px;
}
.form-group.internal {
  margin-bottom: 0;
}

.dialog-panel {
  margin: 10px;
}
.panel-body {  
  
   font: 600 15px "Open Sans",Arial,sans-serif;
}

label.control-label {
  font-weight: 600;
  color: #777;  
}
</style>
<script src="js/city_state.js" type="text/javascript"></script>
    <script>
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

</script>

<script type="text/javascript">
/*$(document).ready(function() {  
  $('.multiselect').multiselect();
  $('.datepicker').datepicker();  


});*/


</script>
		<script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
        <link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	  	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	  
	  <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
            <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script>

function doGetActivity( value, fn ){
    var activity_type_id = value;
    var fn1 = fn;

    $.ajax({
        url: 'get_data_subactivity.php',
        type: "GET",
        data: { 'activity_type_id' : activity_type_id,
                'fn' : fn1 },
        async: false,
        success: function(result) {
            if(!result.status) {
                alert( "ERROR: " + result.message);
            } else if(result.status) {
                if ( result.records == 0 ) {
                    //alert( "New Customer");
 //Added alert when activity is not present for activity type by Pranali for SMC-4999
                    document.getElementById('activity').innerHTML = '';
                    alert("Activity is not present for selected activity type");
                } else {
					var has_subject = result.data['has_subject'];
                    document.getElementById('activity').innerHTML = result.data['strdive'];
					document.getElementById('has_subject').value = has_subject;
					if ( has_subject == "1" ) {
						$('#divSubjectName').show();
					} else {
						$('#divSubjectName').hide();
					}
					
                    //$('#divassignedtouserid').show();
                    return true;
                }
            } 
        },
        error: function(xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError:" + err);
        }
    });

}

function doGetSubjectName( value, fn ){
	
    var activity_type_id = value;
	
	var activity_name = document.getElementById('activity').options[document.getElementById("activity").selectedIndex].text;

    var fn1 = fn;

    $.ajax({
        url: 'get_data_subactivity.php',
        type: "GET",
        data: { 'activity_name' : activity_name,
                'fn' : fn1 },
        async: false,
        success: function(result) {
            if(!result.status) {
                alert( "ERROR: " + result.message);
            } else if(result.status) {
                if ( result.records == 0 ) {
                    //alert( "New Customer");
 //Added alert when subject name is not present for activity type by Pranali for SMC-4999
                    document.getElementById('SubjectName').innerHTML = '';
                    alert("Subject name is not present");
                } else {
					//alert(result.data['id']);
                    document.getElementById('SubjectName').innerHTML = result.data['strdive'];
                    //$('#divassignedtouserid').show();
                    return true;
                }
            } 
        },
        error: function(xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError:" + err);
        }
    });

}


function Relationfunction(value,fn)
{
	
 if(value!='')
 {
	 
        if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
				if(fn=='fun_course')
				{
					
					  document.getElementById("activity").innerHTML =xmlhttp.responseText;
				}
				if(fn=='fun_test')
				{
					
					  document.getElementById("testdata").value =xmlhttp.responseText;
				}
				if(fn=='fun_dept')
				{ 		
					 document.getElementById("SubjectName").innerHTML =xmlhttp.responseText;
				}
				
				
				
            }
          }
xmlhttp.open("GET","get_data_subactivity.php?fn="+fn+"&value="+value,true);
        xmlhttp.send();
 }
 


				
} 	 
				

</script>
<script>
  function valid()  
       {
		   var activity_type=document.getElementById("activity_type").value;

	  if(activity_type==null || activity_type=="")
		{

		document.getElementById('errorActivityType').innerHTML='Please select Activity Type';

				

				return false;

		}
		else
		{

		document.getElementById('errorActivityType').innerHTML='';
		}
		
		var activity=document.getElementById("activity").value;

	  if(activity==null || activity=="")
		{
		document.getElementById('errorActivity').innerHTML='Please select activity';
				return false;

		}
		else
		{

		document.getElementById('errorActivity').innerHTML='';

		}   
		// var ishas_subject = document.getElementById("has_subject").value;
		// if (ishas_subject == "1" ) {
			
			// var SubjectName=document.getElementById("SubjectName").value;
			// if(SubjectName==null || SubjectName=="")
			// { 
			// document.getElementById('errorSubjectName').innerHTML='Please select SubjectName';

					// return false;
			// }
			// else
			// {
			// document.getElementById('errorSubjectName').innerHTML='';
			// }
		// }
var sub_activity=document.getElementById("sub_activity").value;

	  if(sub_activity==null || sub_activity=="")

		{
		document.getElementById('errorSubActivity').innerHTML='Please Enter Sub Activity';
		
				return false;
		}

		else

		{
		document.getElementById('errorSubActivity').innerHTML='';
		}
	
 var point=document.getElementById("point").value

	  if(point==null || point=="")

		{
		document.getElementById('errorPoint').innerHTML='Please Enter Point';

				return false
		}

		else

		{
		document.getElementById('errorPoint').innerHTML='';

		}

	   }

</script>

<style>
.error {color: #FF0000;}
</style>
</head>

<body>

<div class='panel panel-primary dialog-panel'>
<div style="font-size:15px;font-weight:bold;margin-top:5px;" class="col-md-offset-6"><div style="color:#F00"><?php if(isset($_GET['errorreport'])){ echo $_GET['errorreport']; };echo $errorreport;?></div><div style="color:#090"><?php if(isset($_GET['successreport'])){ echo $_GET['successreport']; };echo $successreport;?></div></div>
   
      
      <div class='panel-body'>
      	<!--Back button added by PRanali for SMC-4999 on 8-12-20-->
      	<a href="subactivity_list.php" ><input type="button" name="back" class="btn btn-warning" value="Back" /></a>
        <form class='form-horizontal' role='form' method="post" action="" id="form" onSubmit="return valid()">
        
        	 <h1 align="center">Sub Activity Registration</h1>	
                </br></br></br>
		  
		  <div style="display: none" >
			 <input id="has_subject" name="has_subject" > 
		  </div>
		  <div class="form-group">
            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;" >Activity Type
<span class="error"><b> *</b></span></label>
                <div class='col-md-2' style="text-align:left;">
                   <select name="activity_type" class="form-control " id="activity_type"  onChange="doGetActivity(this.value,'getActivity')">
					   <option value="">Select Activity Type</option>
						<?php
//Removed has_achievement condition in below query by Pranali for SMC-4999
						$sql = "SELECT id,activity_type,has_subject FROM tbl_activity_type where school_id='$school_id' and activity_type!='' group by activity_type";
						$result = mysql_query($sql);
						while($row=mysql_fetch_array($result))
						{
							$activity_type_id = $row['id'];
							$activity_type = $row['activity_type'];
							$has_subject = $row['has_subject'];
							echo "<option value='$activity_type_id'>$activity_type</option>";
						}
						?>
					   </select>
	   
				</div>
		  <div class='col-md-2 error1' id="errorActivityType" style="color:#FF0000"></div>
          </div>
		 
			
			
			 <div class='form-group'>
                
           			 <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;"> Activity<span class="error"><b> *</b></span></label>
					
              		
                	  <div class='col-md-3' style="text-align:left;">
					  
                  <select name="activity" class="form-control " id="activity" onChange="doGetSubjectName(this.value,'getSubject')">
				  
						<option value="">Select Activity</option>
						<?php 
						/*
						$sql = "select sc_list,sc_id from tbl_studentpointslist where school_id='$school_id'";
						$result = mysql_query($sql);
						while($row=mysql_fetch_array($result))
						{
							$sc_list = $row['sc_list'];
							$sc_id = $row['sc_id'];
							echo "<option value='$sc_id,$sc_list'>$sc_list</option>";
						}
						*/
						
						?>
					
						</select>
                </div>

               
                     <div class='col-md-3 error1' id="errorActivity" style="color:#FF0000"></div>
					 
                
                    </div>


 
        <div class="form-group">
            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;" >Sub Activity<span class="error"><b> *</b></span></label>
                <div class='col-md-2' style="text-align:left;">
                  <input class='form-control' id="sub_activity" name="sub_activity" placeholder='Enter Sub Activity' type='text'>
	   
				</div>
		  <div class='col-md-2 error1' id="errorSubActivity" style="color:#FF0000"></div>
          </div>
		  
		   <div class="form-group">
            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;" >Point<span class="error"><b> *</b></span></span></label>
                <div class='col-md-2' style="text-align:left;">
                  <input class='form-control' id="point" name="point" placeholder='Enter Point' type='number'>
	   
				</div>
		  <div class='col-md-2 error1' id="errorPoint" style="color:#FF0000"></div>
		  
          </div>
	  
        
		<div class='form-group'>
           <div class='col-md-3 col-md-offset-3'>
                 <input class='btn-lg btn-primary' type='submit' value="Submit" id="submit" name="submit" onClick="return valid()" />
           </div>
                 <div class='col-md-2'>
                    <button class='btn-lg btn-danger' id="btn"  type='reset' >Reset</button>
                 
				 <!-- changes end  -->
				 </div>
          </div>

  </form>
      </div>
</div>
</body>
</html>
