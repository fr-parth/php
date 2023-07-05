<?php
//hradmin_report.php
include('scadmin_header.php');
$sc_id= $_SESSION['school_id'];
$date=date("Y-m-d");
$date1=date("Y-m-d 23:59:59");
$que="";
if (isset($_POST['submit']))
	{
		//$info = $_POST['info'];
		$from1=$_POST['from'];
		$to1=$_POST['to'];
		$Dept_Name = $_POST['Dept_Name'];
		$t_id = $_POST['name'];
		$sc_list = $_POST['sc_list'];
		$to=$to1." ".'23:59:59'; //appended '23:59:59' for timestamp
		$from=$from1." ".'00:00:00';
		$where='';
		
		if($Dept_Name=='' && $t_id=='')
		{
			$where.=" and (point_date BETWEEN '$from' AND '$to') ";
		}
		else if($Dept_Name!='' && $t_id=='')
		{
			$where.=" and  s.std_dept='".$Dept_Name."' and  (point_date BETWEEN '$from' AND '$to') ";
		}
		else if($t_id!='')
		{
			$where.=" and sp.sc_teacher_id='".$t_id."' and  (point_date BETWEEN '$from' AND '$to') ";
		}
		
		if($sc_list!='')
		{
			$where.=" and sp.reason='".$sc_list."'";
		}
	
		$row = mysql_query("select s.std_complete_name,sp.sc_stud_id,SUM(sp.sc_point) as sc_point from tbl_student s join tbl_student_point sp on s.std_PRN=sp.sc_stud_id and s.school_id=sp.school_id where sp.school_id='$sc_id' $where group by sp.sc_stud_id order by sc_point desc");

		
	}

$que = urlencode($where); 
?>
<html>
<head>
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

<!--tr:nth-child(even) {
    background-color: #dddddd;
}-->

</style>
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
        	//Added changeYear : true,	changeMonth : true by Pranali for SMC-5118
            $("#from").datepicker({
               // changeMonth: true,
                //changeYear: true
				 maxDate: 0,
				dateFormat: 'yy-mm-dd',
				changeYear : true,
				changeMonth : true
            });
        });
        $(function () {
            $("#to").datepicker({
                //changeMonth: true,
                //changeYear: true,
				 maxDate: 0,
				dateFormat: 'yy-mm-dd',
				changeYear : true,
				changeMonth : true
            });
        });
    </script>
	
 <script>
 $(document).ready(function() 
 {  
	 $("#Dept_Name").on('change',function(){ 	 
		 var deptName = document.getElementById("Dept_Name").value;

		 $.ajax({
			 type:"POST",
			 data:{deptName:deptName}, 
			 url:'fetch.php',
			 success:function(data)
			 {
			     //alert(data);
				 
				 $('#managerList').html(data);
			 }
			 
			 
		 });
		 
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
    <div class="panel-heading" align='center'><h3> Employee Activity Summary Report</h3></div>
	<br>
	 <div class="row" align="center" style="margin-top:3%;">
	 
	 
	 
         <form method="post" id="empActivity"> 

			<div class="col-md-2 col-md-offset-4" id="fromDiv">
			  <label style="margin-top: 10px;">From Date:</label>
			  <input type="text" class="form-control col-md-2 col-md-offset-2" id="from" style="margin-top: 5px;" name="from" value="<?php echo $from1;?>" autocomplete="off" />
			  <div id="errorfrom" style="color:#FF0000"></div>
		  </div>
		  <div class="col-md-2 col-md-offset-3" style="margin-left: 10px;" id="toDiv">
			  <label style="margin-top: 10px;">To Date:</label>
			  <input type="text" class="form-control col-md-2 col-md-offset-2" id="to" style="margin-top: 5px;" name="to" value="<?php echo $to1;?>" autocomplete="off" />
			  <div id="errorto" style="color:#FF0000"></div>
		  </div>
		   <div class="col-md-4 col-md-offset-4" id="errorDate" style="color:#FF0000"></div>

                   
                </div>
	<div class="panel-body">
		 <div id="no-more-tables" style="padding-top:20px;">
	<table id="example" class="display" width="100%" cellspacing="0">
	 
	
	  <div class="row" style="padding-top:20px;">
                <div class="col-md-4"></div>
                <div class="col-md-2" style="color:#808080; font-size:18px;     margin-left: 13px;" > Department<span
                            style="color:red;font-size: 25px;"></span></div>
                <div class="col-md-3">
                    <select name="Dept_Name" id="Dept_Name" class="form-control" >
                        <option value=""  selected>ALL Department</option>
                        <?php
                        $sql = "SELECT Dept_Name FROM tbl_department_master where School_ID='$sc_id'";
                        $query = mysql_query($sql);
                        while ($rows = mysql_fetch_assoc($query)) { ?>
                            <option value="<?php echo $rows['Dept_Name']; ?>" <?php if($rows['Dept_Name']==$Dept_Name){ echo "selected";}else{}?>><?php echo $rows['Dept_Name'];?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-md-4 col-md-offset-5"  style="color:#F00; text-align: center;">
                <span class="error"><?php echo $Errcourselevel; ?></span>
            </div>
		</div>
		
		
		  <div class="row" style="padding-top:30px;">
                <div class="col-md-4"></div>
                <div class="col-md-2" style="color:#808080; font-size:18px;     margin-left: 13px;" > Manager List<span
                            style="color:red;font-size: 25px;"></span></div>
                <div class="col-md-3">
                    <select name="name" id="managerList" class="form-control">
                       <option value=""  selected>ALL Manager List</option>
                         
                    </select>
                </div>
            

            <div class="col-md-4 col-md-offset-5"  style="color:#F00; text-align: center;">
                <span class="error"><?php echo $Errcourselevel; ?></span>
            </div>
			</div>
			
			  <div class="row" style="padding-top:30px;">
                <div class="col-md-4"></div>
                <div class="col-md-2" style="color:#808080; font-size:18px;     margin-left: 13px;" > Activity List<span
                            style="color:red;font-size: 25px;"></span></div>
                <div class="col-md-3">
                    <select name="sc_list" id="sc_list" class="form-control">
                        <option value=""  selected> All Activity List</option>
                        <?php
                        $sql = "SELECT sc_list FROM tbl_studentpointslist where school_id='$sc_id'";
                        $query = mysql_query($sql);
                        while ($rows = mysql_fetch_assoc($query)) { ?>
                            <option value="<?php echo $rows['sc_list']; ?>" <?php if($rows['sc_list']==$sc_list){ echo "selected";}else{}?>><?php echo $rows['sc_list'];?></option>
                        <?php } ?>
                    </select>
                </div>
            

            <div class="col-md-4 col-md-offset-5"  style="color:#F00; text-align: center;">
                <span class="error"><?php echo $Errcourselevel; ?></span>
            </div>	
			
		</div>  	
	</div>
	<br>
			<div class="col-md-12" align="center">
				<!--SMC-5118 by Pranali : Added button for exporting data to csv-->
							<a href="Export_To_CSV.php?query=<?php echo $que; ?>"><input type="button" name="export_report" value="Export Report To CSV" class="btn btn-info" ></a> &emsp;
                            <input type="submit" name="submit" value="Submit" class="btn btn-success" onClick="return valid();" /> 
                            
                        </div>
	 </form>
</table>

</div>
</div>

	<div class="panel-body">
		 <div id="no-more-tables" style="padding-top:20px;">
	<table id="example" class="display" width="100%" cellspacing="0">
	<thead style="background-color:#FFFFFF;">
                        
		<tr>
		<!--Camel casing done for Member ID & School ID by Pranali  -->
		<th>Sr.No.</th>
		<th>Employee Name</th>
		<th>Employee PRN</th>
		<th>Assign Point</th>
		</tr>
		</thead>
	<tbody>
     <?php
	 $i = 1;
	 
       while ($result= mysql_fetch_array($row)){
		
     ?>
			<tr>
			<td data-title="id"><?php echo $i; ?></td>
			<td data-title="Couponid"><?php echo $result['std_complete_name']; ?></td>

				
			<td><?php echo $result['sc_stud_id']; ?></td>
			<td><?php  if($result['sc_point']=='')
			{
				echo "0";
			}
			else 
			{
				echo $result['sc_point'];
			}	
			 ?></td>
		
	
			</tr>



		<?php $i++;
                 }
					
                    ?>
					
 </tbody>
</table>

</div>
</div>



</div>
</div>
</body>


</html>



 