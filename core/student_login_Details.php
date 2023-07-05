<?php
include('cookieadminheader.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title> Student Login Logout Details</title>
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
        
		$sq = mysql_query("Select vm.std_complete_name,ls.EntityID,ls.school_id,ls.LatestLoginTime,ls.LogoutTime from tbl_LoginStatus
 ls left join 
tbl_student vm on vm.id=ls.EntityID and vm.school_id=ls.school_id  
 where ls.Entity_type=105 order by RowID
LIMIT $start_from, $webpagelimit");

$sq1 ="Select count(ls.Entity_type),vm.std_complete_name,ls.EntityID,ls.school_id,ls.LatestLoginTime,ls.LogoutTime from tbl_LoginStatus
 ls left join 
tbl_student vm on vm.id=ls.EntityID and vm.school_id=ls.school_id  
 where ls.Entity_type=105 order by RowID";

 
 $count=mysql_num_rows($sq);	
$rs_result = mysql_query($sq1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);

  }elseif ($info == "2") {
        
$sq = mysql_query("Select vm.std_complete_name,ls.EntityID,ls.school_id,ls.LatestLoginTime,ls.LogoutTime from tbl_LoginStatus
 ls left join 
tbl_student vm on vm.id=ls.EntityID and vm.school_id=ls.school_id  
 where ls.Entity_type=105  AND ls.LatestLoginTime like '%$date%' order by RowID
LIMIT $start_from, $webpagelimit");

  $sq1 ="Select count(ls.Entity_type),vm.std_complete_name,ls.EntityID,ls.school_id,ls.LatestLoginTime,ls.LogoutTime from tbl_LoginStatus
 ls left join 
tbl_student vm on vm.id=ls.EntityID and vm.school_id=ls.school_id  
 where ls.Entity_type=105 AND ls.LatestLoginTime like '%$date%' order by RowID";  
	
	$count=mysql_num_rows($sq);
	$rs_result = mysql_query($sq1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);
	
	
	

    } elseif ($info == "3") {

		$sq = mysql_query("Select vm.std_complete_name,ls.EntityID,ls.school_id,
		ls.LatestLoginTime,ls.LogoutTime from tbl_LoginStatus ls left join 
tbl_student vm on vm.id=ls.EntityID and vm.school_id=ls.school_id  
 where ls.Entity_type=105 AND (ls.LatestLoginTime BETWEEN  '$week' AND '$date1') 
 order by RowID LIMIT $start_from, $webpagelimit");
 
 
 $sq1 ="Select count(ls.Entity_type),vm.std_complete_name,ls.EntityID,ls.school_id,ls.LatestLoginTime,ls.LogoutTime from tbl_LoginStatus
 ls left join 
tbl_student vm on vm.id=ls.EntityID and vm.school_id=ls.school_id  
 where ls.Entity_type=105 AND (ls.LatestLoginTime BETWEEN  '$week' AND '$date1') 
 order by RowID";  
 $count=mysql_num_rows($sq);
 $rs_result = mysql_query($sq1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);

 
 
 
    } elseif ($info == "4") {       

        $sq = mysql_query("Select vm.std_complete_name,ls.EntityID,ls.school_id,
		ls.LatestLoginTime,ls.LogoutTime from tbl_LoginStatus ls left join 
tbl_student vm on vm.id=ls.EntityID and vm.school_id=ls.school_id  
 where ls.Entity_type=105
		AND (LatestLoginTime BETWEEN  '$first_day_this_month' AND '$last_day_this_month')
		order by RowID LIMIT $start_from, $webpagelimit");
		
		
		
		$sq1 ="Select count(ls.Entity_type),vm.std_complete_name,ls.EntityID,ls.school_id,ls.LatestLoginTime,ls.LogoutTime from tbl_LoginStatus
 ls left join 
tbl_student vm on vm.id=ls.EntityID and vm.school_id=ls.school_id  
 where ls.Entity_type=105 AND (LatestLoginTime BETWEEN  '$first_day_this_month' AND 
 '$last_day_this_month') order by RowID";  
 $count=mysql_num_rows($sq); 
$rs_result = mysql_query($sq1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);

  
    } 
	//Below query added by Pranali for task SMC-2235 on 06-07-2018 
	elseif ($info == "5") {
       

        $sq= mysql_query("Select vm.std_complete_name,ls.EntityID,ls.school_id,
		ls.LatestLoginTime,ls.LogoutTime from tbl_LoginStatus ls left join 
tbl_student vm on vm.id=ls.EntityID and vm.school_id=ls.school_id  
 where ls.Entity_type=105 AND (LatestLoginTime BETWEEN  '$from' AND '$to') 
 order by RowID LIMIT $start_from, $webpagelimit");
 
 $sq1 ="Select count(ls.Entity_type),vm.std_complete_name,ls.EntityID,ls.school_id,ls.LatestLoginTime,ls.LogoutTime from tbl_LoginStatus
 ls left join 
tbl_student vm on vm.id=ls.EntityID and vm.school_id=ls.school_id  
 where ls.Entity_type=105 AND (LatestLoginTime BETWEEN  '$from' AND '$to') 
 order by RowID ";
 $count=mysql_num_rows($sq);
 $rs_result = mysql_query($sq1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);

 
 
    }


	
	if($total_pages == $_GET['fpage']){
					$webpagelimit = $total_records;
					}else{
					$webpagelimit = $start_from + $webpagelimit;
					}
	
}



else if (!($_GET['Search'])){

if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; };  
$start_from = ($page-1) * $webpagelimit;
	
$sql=mysql_query("Select vm.std_complete_name,ls.EntityID,ls.school_id,ls.LatestLoginTime,ls.LogoutTime from tbl_LoginStatus
 ls left join 
tbl_student vm on vm.id=ls.EntityID and vm.school_id=ls.school_id  
 where ls.Entity_type=105 order by RowID
LIMIT $start_from, $webpagelimit");	

$sql1 ="Select count(ls.Entity_type),vm.std_complete_name,ls.EntityID,ls.school_id,ls.LatestLoginTime,ls.LogoutTime from tbl_LoginStatus
 ls left join 
tbl_student vm on vm.id=ls.EntityID and vm.school_id=ls.school_id  
 where ls.Entity_type=105 order by RowID"; 
 
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
		$query1=mysql_query("Select vm.std_complete_name,ls.EntityID,ls.school_id,ls.LatestLoginTime,ls.LogoutTime from tbl_LoginStatus
 ls left join 
tbl_student vm on vm.id=ls.EntityID and vm.school_id=ls.school_id  
 where ls.Entity_type=105 and
 
 vm.std_complete_name LIKE '%$searchq%' or ls.EntityID LIKE '%$searchq%'
  or ls.school_id LIKE '%$searchq%' or 
  ls.LatestLoginTime LIKE '%$searchq%' or ls.LogoutTime LIKE '%$searchq%' 
			order by RowID
  LIMIT $start_from, $webpagelimit") or die("could not Search!");
			
			$sql1 ="Select count(ls.Entity_type),vm.std_complete_name,ls.EntityID,ls.school_id,ls.LatestLoginTime,ls.LogoutTime from tbl_LoginStatus
 ls left join 
tbl_student vm on vm.id=ls.EntityID and vm.school_id=ls.school_id  
 where ls.Entity_type=105 and
 
  vm.std_complete_name LIKE '%$searchq%' or ls.EntityID LIKE '%$searchq%'
  or ls.school_id LIKE '%$searchq%' or 
  ls.LatestLoginTime LIKE '%$searchq%' or ls.LogoutTime LIKE '%$searchq%' 
			order by RowID "; 

			$rs_result = mysql_query($sql1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);

	}else{
	
	//$q1="SELECT std_name,std_Father_name,std_lastname,std_complete_name,school_id,std_school_name,std_email,std_phone,std_address from tbl_student where group_member_id = '$group_member_id' AND (std_name LIKE '$searchq%' or std_Father_name LIKE '$searchq%' or std_lastname LIKE '$searchq%' or std_complete_name LIKE '%$searchq%' or school_id LIKE '$searchq%' or std_school_name LIKE '%$searchq%' or std_email LIKE '$searchq%' or std_phone LIKE '$searchq%'or std_address LIKE '$searchq%') order by school_id";
$query1=mysql_query("Select vm.std_complete_name,ls.EntityID,ls.school_id,ls.LatestLoginTime,ls.LogoutTime from tbl_LoginStatus
 ls left join 
tbl_student vm on vm.id=ls.EntityID and vm.school_id=ls.school_id  
 where ls.Entity_type=105 and  $colname LIKE '%$searchq%' order by RowID
 
LIMIT $start_from, $webpagelimit")
 
		or die("could not Search!");
					//echo $query1;
		$sql1 ="Select count(ls.Entity_type),vm.std_complete_name,ls.EntityID,ls.school_id,ls.LatestLoginTime,ls.LogoutTime from tbl_LoginStatus
 ls left join 
tbl_student vm on vm.id=ls.EntityID and vm.school_id=ls.school_id  
 where ls.Entity_type=105 and  $colname LIKE '%$searchq%' order by RowID"; 
					$rs_result = mysql_query($sql1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);
			
			
			
		}
			
		//below query use for search count
		 
					

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
			window.location.assign('student_login_Details.php?info=<?php echo $info;?>&find=<?php echo Find;?>&from=<?php echo $from;?>&to=<?php echo $to;?>&fpage='+page);
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
			window.location.assign('student_login_Details.php?page='+page);
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
			window.location.assign('student_login_Details.php?Search=<?php echo $searchq; ?>&spage='+page);
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

            <h2 style="padding-left:20px; margin-top:2px;color:#666"> Student Login Logout Details</h2>

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

                                <option value="1" <?php if($_GET['info'] == '1') echo 'selected="selected"' ?> > All Records </option>

                                <option value="2" <?php if($_GET['info'] == '2') echo  'selected="selected"' ?> > Current Date </option>

                                <option value="3" <?php if($_GET['info'] == '3') echo 'selected="selected"' ?> > Current Week </option>

                                <option value="4" <?php if($_GET['info'] == '4') echo 'selected="selected"' ?> > Current Month </option>

								<!-- Date period option added by Pranali for task SMC-2235 on 05-07-2018-->

								<option value="5" <?php if($_GET['info'] == '5') echo  'selected="selected"' ?> > Date Period </option>

                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="submit" name="find" value="Find" class="btn btn-success" onClick="return valid();" />
                        </div>
<!-- From and To date controls added by Pranali for task SMC-2235 on 05-07-2018-->
						<div class="col-md-2 col-md-offset-4" id="fromDiv">
			  <label style="margin-top: 10px;">From:</label>
			  <input type="text" class="form-control col-md-2 col-md-offset-2" id="from" style="margin-top: 5px;" name="from" />
			  <div id="errorfrom" style="color:#FF0000"></div>
		  </div>
		  <div class="col-md-2 col-md-offset-3" style="margin-left: 10px;" id="toDiv">
			  <label style="margin-top: 10px;">To:</label>
			  <input type="text" class="form-control col-md-2 col-md-offset-2" id="to" style="margin-top: 5px;" name="to" />
			  <div id="errorto" style="color:#FF0000"></div>
		  </div>
		   <div class="col-md-4 col-md-offset-4" id="errorDate" style="color:#FF0000"></div>

                    
                </div>
		  
		  </form>
		  
		  
		  <form style="margin-top:5px;">
		  <div class='row' style="margin-left:410px;">
			<div class="col-md-2" style="width:17%;">
				<input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" placeholder="Search.." required> 
			</div>
			<div class="col-md-1" style="margin-left:55px;">
			<button type="submit" value="Search" class="btn btn-primary">Search</button>
			</div>
			<div class="col-md-1" style="margin-left:15px;">
			<input type="button" class="btn btn-info" value="Reset" onclick="window.open('student_login_Details.php','_self')" />
			</div>
					
		
					<!-- <div style="margin-left: 800px;">
						<input type="text" name="Search" value="" placeholder="Search..">
						<input type="submit" value="Search">
						<input type="button" value="Reset" onclick="window.open('beneficiary_list.php','_self')" />
					</div> -->
					
					
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
					<th>Student Name</th>
                    <th>  Member ID </th>
					 <th> School ID</th>
                   <th>Login Time</th>
                    <th> Logout Time</th> 
					
                </tr>
                </thead>

                <?php $i = 1;
					$i = ($start_from +1);
                while($result = mysql_fetch_array($sq)) {
					
                    ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>
                        
                       
                       
                        <td data-title="Student Name"><?php echo $result['std_complete_name']; ?></td>
						<td data-title="Member ID"><?php echo $result['EntityID']; ?></td>
                        <td data-title="School ID"><?php echo $result['school_id']; ?></td>
                        <td data-title="Login Time"><?php echo $result['LatestLoginTime']; ?></td>
						<td data-title="Logout Time"><?php echo $result['LogoutTime']; ?></td>

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
					<th>Student Name</th>
                    <th>  Member ID </th>
					 <th> School ID</th>
                   <th>Login Time</th>
                    <th> Logout Time</th> 
					
                </tr>
                </thead>

                <?php $i = 1;
					$i = ($start_from +1);
                while($result = mysql_fetch_array($query1)) {
					
                    ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>
                        
                       
                       
                        <td data-title="Student Name"><?php echo $result['std_complete_name']; ?></td>
						<td data-title="Member ID"><?php echo $result['EntityID']; ?></td>
                        <td data-title="School ID"><?php echo $result['school_id']; ?></td>
                        <td data-title="Login Time"><?php echo $result['LatestLoginTime']; ?></td>
						<td data-title="Logout Time"><?php echo $result['LogoutTime']; ?></td>

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
					<th>Student Name</th>
                    <th>  Member ID </th>
					 <th> School ID</th>
                   <th>Login Time</th>
                    <th> Logout Time</th> 
					
				   
                </tr>
                </thead>

                <?php $i = 1;
					$i = ($start_from +1);
                while($result = mysql_fetch_array($sql)) {
					
                    ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>
                        
                       
                       
                        <td data-title="Student Name"><?php echo $result['std_complete_name']; ?></td>
						<td data-title="Member ID"><?php echo $result['EntityID']; ?></td>
                        <td data-title="School ID"><?php echo $result['school_id']; ?></td>
                        <td data-title="Login Time"><?php echo $result['LatestLoginTime']; ?></td>
						<td data-title="Logout Time"><?php echo $result['LogoutTime']; ?></td>


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
