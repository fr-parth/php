<?php
include_once("scadmin_header.php");

$school_id = $_SESSION['school_id'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title> Teacher Login Logout Details</title>
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>

    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<script src="js/jquery.twbsPagination.js" type="text/javascript"></script>
    <script>
    $(document).ready(function() {
    $('#example').dataTable( {
	"paging":   false,
	"info":false,
	"searching": false,
     "scrollCollapse": true,
	 "scrollX": true
    } );
} );
    </script>






<?php

$date=date("Y-m-d");
$date1=date("Y-m-d 23:59:59");
$week=date('Y-m-d 00:00:00', strtotime('-6 days'));
$last_day_this_month = date('Y-m-d 23:59:59'); 
$first_day_this_month = date('Y-m-d 00:00:00', strtotime('-29 days'));// hard-coded '01' for first day

$info = $_GET['info'];
$from=$_GET['from'];
$to=$_GET['to'];
	$to=$to." ".'23:59:59';


if ($_GET['find']) {
	
	if (isset($_GET["fpage"])){ $fpage  = mysql_real_escape_string($_GET["fpage"]); } else { $fpage=1; };  
$start_from = ($fpage-1) * $webpagelimit;

    //appended '23:59:59' for timestamp

	if ($info == "1") {
		$wheres=" AND last_login_date like '%$date%' ";
	}
	elseif ($info == "2") {
		$wheres=" AND (last_login_date BETWEEN  '$week' AND '$date1')";
	}
	elseif ($info == "3") {
		$wheres=" AND (last_login_date BETWEEN  '$first_day_this_month' AND '$last_day_this_month') ";
	}
	elseif ($info == "4") {
		$wheres="";
	}
	elseif ($info == "5") {
		$wheres="  AND (last_login_date BETWEEN  '$from' AND '$to')";
	}
	$findq="Select t_complete_name,id,t_id,school_id,first_login_date,last_login_date from 
 tbl_teacher   
 where school_id='$school_id' $wheres order by id desc";
	$sq = mysql_query("Select t_complete_name,id,t_id,school_id,first_login_date,last_login_date from 
 tbl_teacher where school_id='$school_id' $wheres order by last_login_date desc LIMIT $start_from, $webpagelimit");

$sq1 ="Select count(id),t_complete_name,id,t_id,school_id,first_login_date,last_login_date from tbl_teacher 
where school_id='$school_id' $wheres order by last_login_date desc";

 
 $count=mysql_num_rows($sq);	
$rs_result = mysql_query($sq1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);
	
		
	
	if($total_pages == $_GET['fpage']){
					$webpagelimit = $total_records;
					}else{
					$webpagelimit = $start_from + $webpagelimit;
					}
	
}


else if (!($_GET['Search'])){

if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; };  
$start_from = ($page-1) * $webpagelimit;
$findq2="Select t_complete_name,id,t_id,school_id,first_login_date,last_login_date from tbl_teacher
 where school_id='$school_id' AND last_login_date like '%$date%' order by last_login_date desc";
	
$sql=mysql_query("Select t_complete_name,id,t_id,school_id,first_login_date,last_login_date from tbl_teacher
 where school_id='$school_id' AND last_login_date like '%$date%' order by last_login_date desc
LIMIT $start_from, $webpagelimit");	

$sql1 ="Select count(id),t_complete_name,id,t_id,school_id,first_login_date,last_login_date from 
tbl_teacher where school_id='$school_id' AND last_login_date like '%$date%' order by last_login_date desc"; 
 
					$rs_result = mysql_query($sql1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);
					if($total_pages == $_GET['page']){
					$webpagelimit = $total_records;
					}else{
					$webpagelimit = $start_from + $webpagelimit;
					}
}else
{
	if (isset($_GET["spage"])){ $spage  = mysql_real_escape_string($_GET["spage"]); } else { $spage=1; };  
$start_from = ($spage-1) * $webpagelimit;

$searchq=mysql_real_escape_string($_GET['Search']);
//$colname=mysql_real_escape_string($_GET['colname']);
	if ($searchq != '')
	{ 
$findq1="Select t_complete_name,id,t_id,school_id,first_login_date,last_login_date from
tbl_teacher where school_id='$school_id' and t_complete_name LIKE '%$searchq%' or id LIKE '%$searchq%'
  or school_id LIKE '%$searchq%' or first_login_date LIKE '%$searchq%' or last_login_date LIKE '%$searchq%' order by id desc";
		$query1=mysql_query("Select t_complete_name,id,t_id,school_id,first_login_date,last_login_date from
tbl_teacher where school_id='$school_id' and t_complete_name LIKE '%$searchq%' or id LIKE '%$searchq%'
  or school_id LIKE '%$searchq%' or  first_login_date LIKE '%$searchq%' or last_login_date LIKE '%$searchq%' 
order by last_login_date desc LIMIT $start_from, $webpagelimit") or die("could not Search!");
			
	$sql1 ="Select count(id),t_complete_name,id,t_id,school_id,first_login_date,last_login_date from 
tbl_teacher where school_id='$school_id' AND t_complete_name LIKE '%$searchq%' or id LIKE '%$searchq%' 
  or school_id LIKE '%$searchq%' or first_login_date LIKE '%$searchq%' or last_login_date LIKE '%$searchq%' order by id desc"; 

			$rs_result = mysql_query($sql1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);

	}else{
	$findq3="Select t_complete_name,id,school_id,t_id,first_login_date,last_login_date from tbl_teacher 
		where school_id='$school_id'  and  $colname LIKE '%$searchq%' order by id desc";
	//$q1="SELECT std_name,std_Father_name,std_lastname,std_complete_name,school_id,std_school_name,std_email,std_phone,std_address from tbl_student where group_member_id = '$group_member_id' AND (std_name LIKE '$searchq%' or std_Father_name LIKE '$searchq%' or std_lastname LIKE '$searchq%' or std_complete_name LIKE '%$searchq%' or school_id LIKE '$searchq%' or std_school_name LIKE '%$searchq%' or std_email LIKE '$searchq%' or std_phone LIKE '$searchq%'or std_address LIKE '$searchq%') order by school_id";
		$query1=mysql_query("Select t_complete_name,id,school_id,t_id,first_login_date,last_login_date from tbl_teacher 
		where school_id='$school_id'  and  $colname LIKE '%$searchq%' order by last_login_date desc LIMIT $start_from, $webpagelimit")
	or die("could not Search!");
					
		$sql1 ="Select count(id),t_complete_name,id,t_id,school_id,first_login_date,last_login_date
		 from tbl_teacher where school_id='$school_id' and  $colname LIKE '%$searchq%' order by last_login_date desc"; 
					$rs_result = mysql_query($sql1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);
			
			
			
		}
			
			

					if($total_pages == $_GET['spage']){
					$webpagelimit = $total_records;
					}else{
					$webpagelimit = $start_from + $webpagelimit;
					}
					 
}

?>


<?php if ($_GET['find']){?>
	<script type="text/javascript">
    $(function () {
		var total_pages = <?php echo $total_pages; ?> ;
		var start_page = <?php echo $fpage; ?> ;
        window.pagObj = $('#pagination').twbsPagination({
            totalPages: total_pages,
            visiblePages: 10,
			startPage: start_page,
            onPageClick: function (event, page) {
                console.info(page + ' (from options)'); 
            }
        }).on('page', function (event, page) {
            console.info(page + '(from event listening)');
			window.location.assign('school_teacher_login_Detatils.php?info=<?php echo $info;?>&find=<?php echo Find;?>&from=<?php echo $from;?>&to=<?php echo $to;?>&fpage='+page);
        });
    });
</script>
<?php }

else if (!($_GET['Search'])){?>
<script type="text/javascript">
    $(function () {
		var total_pages = <?php echo $total_pages; ?> ;
		var start_page = <?php echo $page; ?> ;
        window.pagObj = $('#pagination').twbsPagination({
            totalPages: total_pages,
            visiblePages: 10,
			startPage: start_page,
            onPageClick: function (event, page) {
                console.info(page + ' (from options)'); 
            }
        }).on('page', function (event, page) {
            console.info(page + '(from event listening)');
			window.location.assign('school_teacher_login_Detatils.php?page='+page);
        });
    });
</script>
<?php }else{
	?>
<script type="text/javascript">
    $(function () {
		var total_pages = <?php echo $total_pages; ?> ;
		var start_page = <?php echo $spage; ?> ;
        window.pagObj = $('#pagination').twbsPagination({
            totalPages: total_pages,
            visiblePages: 10,
			startPage: start_page,
            onPageClick: function (event, page) {
                console.info(page + ' (from options)'); 
            }
        }).on('page', function (event, page) {
            console.info(page + '(from event listening)');
			window.location.assign('school_teacher_login_Detatils.php?Search=<?php echo $searchq; ?>&spage='+page);
        });
    });
</script>
<?php }?>





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

 <script>
        $(function () {
            $("#from").datepicker({
               // changeMonth: true,
                //changeYear: true
				dateFormat: 'yy-mm-dd',
				maxDate:0
            });
        });
        $(function () {
            $("#to").datepicker({
                //changeMonth: true,
                //changeYear: true,
				dateFormat: 'yy-mm-dd',
				maxDate:0
            });
        });
    </script>
 
<!-- JQuery script and JavaScript valid() function added  by Pranali for task SMC-2235 on 05-07-2018  -->
<script>
$(document).ready(function(){

		$("#fromDiv").hide();
		$("#toDiv").hide();
    $('#info').on('change', function() {
      if ( this.value == "5")
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
	var info = document.getElementById("info");

	if(info.value=="5")
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
<body bgcolor="#CCCCCC">
<div align="center">
    <div class="container" style="width:100%;">
        <div style="padding-top:30px;">

            <h2 style="padding-left:20px; margin-top:2px;color:#666"> <?php echo $dynamic_teacher;?> Login Details</h2>

        </div>
		
		<div class='row'>
		<form style="margin-top:5px;">
			 <div class="col-md-4" style="width:35%;">
			 </div>
          
		  <?php
                        echo  '<div class="col-md-2"><font size="5"<b>Select Date:</b></font></div>';
                        ?>

                        <div class="col-md-3">
                             <select name="info" id="info" class="form-control">
								<option value="">Select</option>

                               

                                <option value="1" <?php if($_GET['info'] == '1') echo  'selected="selected"' ?> > Current Date </option>

                                <option value="2" <?php if($_GET['info'] == '2') echo 'selected="selected"' ?> > Current Week </option>

                                <option value="3" <?php if($_GET['info'] == '3') echo 'selected="selected"' ?> > Current Month </option>
								
								 <option value="4" <?php if($_GET['info'] == '4') echo 'selected="selected"' ?> > All Records </option>

							

								<option value="5" <?php if($_GET['info'] == '5') echo  'selected="selected"' ?> > Date Period </option>

                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="submit" name="find" value="Find" class="btn btn-success" onClick="return valid();" />
                        </div>

						<div class="col-md-2 col-md-offset-4" id="fromDiv">
			  <label style="margin-top: 10px;">From:</label>
			  <input type="text" class="form-control col-md-2 col-md-offset-2" id="from" style="margin-top: 5px;" name="from" autocomplete="off" />
			  <div id="errorfrom" style="color:#FF0000"></div>
		  </div>
		  <div class="col-md-2 col-md-offset-3" style="margin-left: 10px;" id="toDiv">
			  <label style="margin-top: 10px;">To:</label>
			  <input type="text" class="form-control col-md-2 col-md-offset-2" id="to" style="margin-top: 5px;" name="to" autocomplete="off" />
			  <div id="errorto" style="color:#FF0000"></div>
		  </div>
		   <div class="col-md-4 col-md-offset-4" id="errorDate" style="color:#FF0000"></div>

                    
                </div>
		  
		  </form>
		  
		  
		  <form style="margin-top:10px;">
		  <div class='row' style="margin-left:270px;">
			<div class="col-md-2" style="width:17%;margin-left:140px;">
				<input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" placeholder="Search.." required> 
			</div>
			<div class="col-md-1" style="margin-left:28px;">
			<button type="submit" value="Search" class="btn btn-primary">Search</button>
			</div>
			<div class="col-md-1" >
			<input type="button" class="btn btn-info" value="Reset" onclick="window.open('school_teacher_login_Detatils.php','_self')" />
			</div>
					
		
					<!-- <div style="margin-left: 800px;">
						<input type="text" name="Search" value="" placeholder="Search..">
						<input type="submit" value="Search">
						<input type="button" value="Reset" onclick="window.open('beneficiary_list.php','_self')" />
					</div> -->
					
					
			</div>	
			</br></br>
			<div class='row col-md-offset-8'>
			<div class="col-md-1" >
			 <a href="Export_report.php?fn=teacherlogin__<?php echo date('Y-m-d');?>" style="float:right; text-decoration:none;"><input type="button" value="Generate Excel Report" class="btn btn-info" style="margin-right: -500px;"/></a>
			</div><br><br>
			</div>
			
					
		</form>
		 </div> 
		 <!-- <div id="show" >
		 		<?php if (!($_GET['Search']))
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</b></font></div>";
		    }else
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".($total_records). " records.</b></font></div>";
		 			}
		 			?>
		 </div> -->
		<?php
		if ($_GET['find'])
		{
			
			//$count=mysql_num_rows($query1);
			if($count == 0){
				
				echo "<script>$('#show').css('display','none');</script><div style='margin-top:20px;'><font color='Red'><b>There Was No Search Result</b></font></div>";	
			}
			else
			{
			?>
			<div id="no-more-tables" style="padding-top:20px;">

            <table id="example" class="col-md-12 table-bordered " align="center">
                <thead>
				<!-- <tr><?php echo $sq1; ?></tr> -->
                <tr style="background-color:#0073BD; color:#FFFFFF; height:30px;">
                    
				  <th>Sr.No.</th>
					<th><?php echo $dynamic_teacher;?> Name</th>
                    <th>  Member ID </th>
					
                   <th>First Login Time</th>
                    <th>Last Login Time</th> 
					
                </tr>
                </thead>

                <?php $i = 1;
					$i = ($start_from +1);
                while($result = mysql_fetch_array($sq)) {
					
                    ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>
                        
                       
                       
                        <td data-title="Teacher Name"><?php echo $result['t_complete_name']; ?></td>
						<td data-title="Member ID"><?php echo $result['id']; ?></td>
                       
                        <td data-title="Login Time"><?php echo $result['first_login_date']; ?></td>
						<td data-title="Logout Time"><?php echo $result['last_login_date']; ?></td>

					</tr>	
                    <?php $i++;
                } ?>
            </table>
        </div>
		<div align="left">
		 		<?php 
		 				
		 				echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".($total_records). " records.</font></style></div>";
		 			
		 			?>
		 </div>
			<div class="container">
			<nav aria-label="Page navigation">
			  <ul class="pagination" id="pagination"></ul>
		    </nav>
		</div>
			<?php
			}

		}
		
		
		else if (isset($_GET['Search']))
		{
			
			$count=mysql_num_rows($query1);
			if($count == 0){
				
				echo "<script>$('#show').css('display','none');</script><div style='margin-top:20px;'><font color='Red'><b>There Was No Search Result</b></font></div>";	
			}
			else
			{
			?>
			<div id="no-more-tables" style="padding-top:20px;">

            <table id="example" class="col-md-12 table-bordered " align="center">
                <thead>
				<!-- <tr><?php echo $sql1; ?></tr> -->
                <tr style="background-color:#0073BD; color:#FFFFFF; height:30px;">
                    
				  <th>Sr.No.</th>
					<th><?php echo $dynamic_teacher;?> Name</th>
                    <th>  Member ID </th>
					
                   <th>First Login Time</th>
                    <th>Last Login Time</th> 
					
                </tr>
                </thead>

                <?php $i = 1;
					$i = ($start_from +1);
                while($result = mysql_fetch_array($query1)) {
					
                    ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>
                        
                       
                       
                        <td data-title="Teacher Name"><?php echo $result['t_complete_name']; ?></td>
						<td data-title="Member ID"><?php echo $result['id']; ?></td>
                        
                        <td data-title="Login Time"><?php echo $result['first_login_date']; ?></td>
						<td data-title="Logout Time"><?php echo $result['last_login_date']; ?></td>

					</tr>	
                    <?php $i++;
                } ?>
            </table>
        </div>
		<div align="left">
		 		<?php if (!($_GET['Search']))
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</font></style></div>";
		    }else
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".($total_records). " records.</font></style></div>";
		 			}
		 			?>
		 </div>
			<div class="container">
			<nav aria-label="Page navigation">
			  <ul class="pagination" id="pagination"></ul>
		    </nav>
		</div>
			<?php
			}

		}
		else
			{
			?>
			<div id="no-more-tables" style="padding-top:20px;">

            <table id="example" class="col-md-12 table-bordered " align="center">
                <thead>
				<!-- <tr><?php echo $sql1; ?></tr> -->
                <tr style="background-color:#0073BD; color:#FFFFFF; height:30px;">
                    <th>Sr.No.</th>
					<th><?php echo $dynamic_teacher;?> Name</th>
                    <th>  Member ID </th>
					
                   <th>First Login Time</th>
                    <th>Last Login Time</th> 
					
				   
                </tr>
                </thead>

                <?php $i = 1;
					$i = ($start_from +1);
                while($result = mysql_fetch_array($sql)) {
					
                    ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>
                        
                       
                       
                        <td data-title="Teacher Name"><?php echo $result['t_complete_name']; ?></td>
						<td data-title="Member ID"><?php echo $result['id']; ?></td>
                       
                        <td data-title="Login Time"><?php echo $result['first_login_date']; ?></td>
						<td data-title="Logout Time"><?php echo $result['last_login_date']; ?></td>


					</tr>	
                    <?php $i++;
                } ?>
            </table>
        </div>
<div align="left">
		 		<?php if (!($_GET['Search']))
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</font></style></div>";
		    }else
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".($total_records). " records.</font></style></div>";
		 			}
		 			?>
		 </div>
		<div class="container">
			<nav aria-label="Page navigation">
			  <ul class="pagination" id="pagination"></ul>
		    </nav>
		</div>

<?php } ?>

	<div style="padding-top:50px;">

            
        </div>
    </div>
</div>

</div>
</div>
</body>
</html>

<?php 
 

if($findq !='')
{
	$res=$findq;
}
else if($findq2 !='')
{
	$res=$findq2;
} 
 else if($findq1 !='') {
	
	$res=$findq1;
}
else{
	$res=$findq3;
}
 
					 $rs_result = mysql_query($res);  
					
  unset($_SESSION['report_header']);
  unset($_SESSION['report_values']);

    $_SESSION['report_header']=array("Sr.No.","Teacher Name","Member ID","First Login Time","Last Login Time");
  $j1=0;
          
    while($row7=mysql_fetch_assoc($rs_result))
    {
    
    $j=$j1++;
          
	$_SESSION['report_values'][$j][0]=$j1;
  $_SESSION['report_values'][$j][1]=$row7['t_complete_name'];
  $_SESSION['report_values'][$j][2]=$row7['id'];
    $_SESSION['report_values'][$j][3]=$row7['first_login_date'];
    $_SESSION['report_values'][$j][4]=$row7['last_login_date'];
   
  
   }  
?>        
						
