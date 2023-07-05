<?php
//hradmin_report.php
include('scadmin_header.php');
$sc_id= $_SESSION['school_id'];
$date=date("Y-m-d");
$date1=date("Y-m-d 23:59:59");

if (isset($_POST['submit']))
	{
		//$info = $_POST['info'];
		$from1=$_POST['from'];
		$to1=$_POST['to'];
		
		$to=$to1." ".'23:59:59'; //appended '23:59:59' for timestamp
		$from=$from1." ".'00:00:00';
		$where='';
		
		$where.=" (LatestLoginTime BETWEEN '$from' AND '$to') ";
		
		//teacher
		$sqlLoginTeacher = "SELECT distinct(ls.EntityID), ls.school_id, ls.LatestLoginTime, ls.LogoutTime, t.t_complete_name from tbl_LoginStatus  ls join tbl_teacher t on ls.EntityID=t.id where $where and  Entity_type='103' and ls.school_id='$sc_id'  GROUP BY ls.EntityID ";
		
		$resultLoginTeacher = mysql_query($sqlLoginTeacher);
		$countLoginTeacher = mysql_num_rows($resultLoginTeacher); 
		
		$sqlTeacher = " SELECT * FROM tbl_teacher where school_id='$sc_id' and  t_emp_type_pid 
		in (133,134,135,137)";
		
		$resultTeacher=mysql_query($sqlTeacher);
		$CountTotalTeacher=mysql_num_rows($resultTeacher);
		
		$percentageTeacher =  round((($countLoginTeacher*100)/$CountTotalTeacher),2);

		//student
		$sqlLoginStudent = "Select distinct (l.EntityID),s.std_complete_name,l.school_id,l.LatestLoginTime,l.LogoutTime 
        from tbl_LoginStatus l join tbl_student s on l.EntityID=s.id where $where and l.Entity_type='105' AND
        (l.school_id = '$sc_id') group by l.EntityID ";
		
		$resultLoginStudent = mysql_query($sqlLoginStudent);
		$countLoginStudent = mysql_num_rows($resultLoginStudent); 
		
		$sqlStudent = " SELECT * FROM tbl_student where school_id='$sc_id'";
		
		$resultStudent=mysql_query($sqlStudent);
		$CountTotalStudent=mysql_num_rows($resultStudent);
		
		$percentageStudent =  round((($countLoginStudent*100)/$CountTotalStudent),2);



		
		
 }
	
	

?>
<html>
<head>


<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <!--  <script>
  $( function() {
    $( "#datepicker" ).datepicker({
  				
         dateFormat: 'dd/mm/yy',     
            });
  
  } );
  </script> -->
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
  
  <script src="https://cdn.datatables.net/1.10.9/js/dataTables.bootstrap.min.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
 <script>
        $(function () {
            $("#from").datepicker({
               // changeMonth: true,
                //changeYear: true
				dateFormat: 'yy-mm-dd'
            });
        });
        $(function () {
            $("#to").datepicker({
                //changeMonth: true,
                //changeYear: true,
				dateFormat: 'yy-mm-dd'
            });
        });
    </script>
	
 	
	
	
 <script>
 $(document).ready(function() 
 { 
    $('#example').DataTable(
	{
	"pageLength": 5
	});
	
	$('#example1').DataTable(
	{
	"pageLength": 5
	});
} );
</script>
<!-- JQuery script and JavaScript valid() function added  by Pranali for task SMC-2235 on 05-07-2018  -->
<script>
$(document).ready(function(){

		$("#fromDiv").hide();
		$("#toDiv").hide();
    $('#info').on('change', function() {
      if ( this.value == "1")
      {
        $("#fromDiv").show();
		$("#toDiv").show();
      }
      else
      {
        $("#fromDiv").hide();
		$("#toDiv").hide();
      }
    });
});
</script>
<script>
function valid()
{
	//var info = document.getElementById("info");

	//if(info.value=="1")
	{
		var from = document.getElementById("from").value;
                    var myDate = new Date(from);
                    var today = new Date();
                   
					if (from == "") {

                      document.getElementById('errorfrom').innerHTML='Please select date';
                       return false;
                    }

	                else if(myDate.getFullYear() > today.getFullYear()) {
					document.getElementById('errorfrom').innerHTML='Please select valid date';
                       return false;
					}

                      else if(myDate.getFullYear() == today.getFullYear()) {

                              if (myDate.getMonth() == today.getMonth()) {
                                
								if (myDate.getDate() > today.getDate()) {

                                    document.getElementById('errorfrom').innerHTML='Please select valid date';
                                    return false;
								}
                                
                                else {
                                   document.getElementById('errorfrom').innerHTML='';
                                    
                                }


                            }

                            else if (myDate.getMonth() > today.getMonth()) {
                               document.getElementById('errorfrom').innerHTML='Please select valid date';
                                return false;

                            }
                            else {
                              document.getElementById('errorfrom').innerHTML='';  
                            }
                        }

                    

                    else {
                     document.getElementById('errorfrom').innerHTML='';
                    }

	var to = document.getElementById("to").value;
                    var myDate1 = new Date(to);
                    var today1 = new Date();
                    
					if (to == "") {

                      document.getElementById('errorto').innerHTML='Please select date';
                       return false;
                    }
	                 else if(myDate1.getFullYear() > today1.getFullYear()) {
						
						document.getElementById('errorto').innerHTML='Please select valid date';
                        return false;
		 			 }

                       else if(myDate1.getFullYear() == today1.getFullYear()) {

                              if (myDate1.getMonth() == today1.getMonth()) {
                                
									if (myDate1.getDate() > today1.getDate()) {
                                    document.getElementById('errorto').innerHTML='Please select valid date';
                                    return false;
								}
                                
                                else {
                                   document.getElementById('errorto').innerHTML='';
                                    
                                }


                            }

                            else if (myDate1.getMonth() > today1.getMonth()) {
                               document.getElementById('errorto').innerHTML='Please select valid date';
                                return false;

                            }
                            else {
                              document.getElementById('errorto').innerHTML='';  
                            }
                        }

                    

                    else {
                     document.getElementById('errorto').innerHTML='';
                    }



		if(myDate.getFullYear() > myDate1.getFullYear())
		{
			document.getElementById('errorDate').innerHTML='Start Date should be less than End Date';
			return false;
		}

		else if(myDate.getFullYear() == myDate1.getFullYear())
		{
			if(myDate.getMonth() == myDate1.getMonth()){

				if(myDate.getDate() > myDate1.getDate()) {

				document.getElementById('errorDate').innerHTML='Start Date should be less than End Date';
				return false;
				}
				else
				{
					document.getElementById('errorDate').innerHTML='';
				}

			}
			else if (myDate.getMonth() > myDate1.getMonth()) {
                               document.getElementById('errorDate').innerHTML='Start Date should be less than End Date';
                                return false;

                            }
                            else {
                              document.getElementById('errorDate').innerHTML='';  
                            }
		}
		else
		{
			document.getElementById('errorDate').innerHTML=''
			
		}
	}
}
	
	
</script>

</head>


<body>

		<div class="container">
 
  <div class="panel panel-default">
    <div class="panel-heading" align='center'><h3> Teacher and Student Login Logout Statistics</h3></div>
	<br>
	 <div class="row" align="center" style="margin-top:3%;">
	 
	 
	 
         <form method="post" id="empActivity"> 

			<div class="col-md-2 col-md-offset-4" id="fromDiv">
			  <label style="margin-top: 10px;">From Date:</label>
			  <input type="text" class="form-control col-md-2 col-md-offset-2" id="from" style="margin-top: 5px;" name="from" value="<?php echo $from1;?>"/>
			  <div id="errorfrom" style="color:#FF0000"></div>
		  </div>
		  <div class="col-md-2 col-md-offset-3" style="margin-left: 10px;" id="toDiv">
			  <label style="margin-top: 10px;">To Date:</label>
			  <input type="text" class="form-control col-md-2 col-md-offset-2" id="to" style="margin-top: 5px;" name="to" value="<?php echo $to1;?>"/>
			  <div id="errorto" style="color:#FF0000"></div>
		  </div>
		   <div class="col-md-4 col-md-offset-4" id="errorDate" style="color:#FF0000"></div>

                   
                </div>
				
			
				
	<div class="panel-body">
		 <div id="no-more-tables" style="padding-top:20px;">
	<table id="example" class="display" width="100%" cellspacing="0" align="center">
	 
	
	 
			<div class="col-md-18" style="margin-left:560px;">
                            <input type="submit" name="submit" value="Submit" class="btn btn-success" onClick="return valid();" />
                        </div>
						
						</br></br>
					
		<tr>
	<th style="width:100px; text-align: center;">Entity </th>
		<th style="width:100px; text-align: center;">Logged In </th>
		
		
		<th style="width:100px; text-align: center;">Total </th>
		
		
		<th style="width:100px; text-align: center;">Percentage  </th>
			
                    
		</tr>
		<tr>
		<td style="width:100px; text-align: center;">Teacher</td>
					<td style="width:100px; text-align: center;"><a href ="teacher_loginList.php?from=<?php echo $from; ?>&amp; to=<?php echo $to; ?>"> <?php echo $countLoginTeacher;?></td>
					<td style="width:100px; text-align: center;"><?php echo $CountTotalTeacher;?></td>
					<td style="width:100px; text-align: center;"><?php echo $percentageTeacher;?> %</td>
					
					
					
					
				
		<tr>		
		<td style="width:100px; text-align: center;">Student</td>
					<td style="width:100px; text-align: center;"><a href="student_loginList.php?from=<?php echo $from; ?>&amp; to=<?php echo $to; ?>"> <?php echo $countLoginStudent;?></td>
					<td style="width:100px; text-align: center;"><?php echo $CountTotalStudent;?></td>
					<td style="width:100px; text-align: center;"><?php echo $percentageStudent;?>%</td>
		</tr>
		
		<!--<tr>		
		<td style="width:100px; text-align: center;">Student Feedback</td>
					<td style="width:100px; text-align: center;"><?php echo $countFeedStudent;?></td>
					<td style="width:100px; text-align: center;"><?php echo $CountTotalStudent;?></td>
					<td style="width:100px; text-align: center;"><?php echo $percentageStudentFeed;?>%</td>
		</tr>-->
		
		
		
	 </form>
</table>

