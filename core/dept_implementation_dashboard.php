<?php

/**
 * Created by PhpStorm.
 * User: Bpsi-Yogesh
 * Date: 9/210015/2020
 * Time: 3:31 PM
 */
include("scadmin_header.php");
//include("../conn.php");
$school_id = $_SESSION['school_id'];
//$group_member_id=91;
?>
<?php


if (!($_GET['Search'])){

if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; };  
$start_from = ($page-1) * $webpagelimit;

 	
$sql=mysql_query("SELECT d.ExtDeptId,d.Dept_Name,
 (select count(id)  from tbl_student where school_id='$school_id' AND std_dept=d.Dept_Name) as no_students,
 (select count(id) from tbl_teacher where school_id='$school_id' AND t_dept=d.Dept_Name) as no_teacher,
 (select count(id)  from tbl_student where school_id='$school_id' AND email_status='Send_Email' AND std_dept=d.Dept_Name) as std_send_email,
(select count(id)  from tbl_student where school_id='$school_id' AND send_unsend_status='Send_SMS' AND std_dept=d.Dept_Name) as std_send_sms,
(select count(id)  from tbl_teacher where school_id='$school_id' AND email_status='Send_Email' AND t_dept=d.Dept_Name) as teacher_send_email,
(select count(id)  from tbl_teacher where school_id='$school_id' AND send_unsend_status='Send_SMS' AND t_dept=d.Dept_Name) as teacher_send_sms,
(select count(id)  from tbl_student where school_id='$school_id' AND std_dept=d.Dept_Name AND first_login_date !='') as login_std,
(select count(id) from tbl_teacher where school_id='$school_id' AND t_dept=d.Dept_Name AND first_login_date !='') as login_teacher
FROM tbl_department_master d
where d.school_id='$school_id' order by d.id LIMIT $start_from, $webpagelimit");	

$sql1 ="select COUNT(id) from tbl_department_master where school_id = '$school_id'";  
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
$colname=mysql_real_escape_string($_GET['colname']);
	if ($colname != ''and $colname != 'Select')
	{
		
		$query1=mysql_query("SELECT d.ExtDeptId,d.Dept_Name,
 (select count(id)  from tbl_student where school_id='$school_id' AND std_dept=d.Dept_Name) as no_students,
 (select count(id) from tbl_teacher where school_id='$school_id' AND t_dept=d.Dept_Name) as no_teacher,
 (select count(id)  from tbl_student where school_id='$school_id' AND email_status='Send_Email' AND std_dept=d.Dept_Name) as std_send_email,
(select count(id)  from tbl_student where school_id='$school_id' AND send_unsend_status='Send_SMS' AND std_dept=d.Dept_Name) as std_send_sms,
(select count(id)  from tbl_teacher where school_id='$school_id' AND email_status='Send_Email' AND t_dept=d.Dept_Name) as teacher_send_email,
(select count(id)  from tbl_teacher where school_id='$school_id' AND send_unsend_status='Send_SMS' AND t_dept=d.Dept_Name) as teacher_send_sms,
(select count(id)  from tbl_student where school_id='$school_id' AND std_dept=d.Dept_Name AND first_login_date !='') as login_std,
(select count(id) from tbl_teacher where school_id='$school_id' AND t_dept=d.Dept_Name AND first_login_date !='') as login_teacher
FROM tbl_department_master d
where d.school_id='$school_id' AND `$colname` LIKE '%$searchq%' order by d.id LIMIT $start_from, $webpagelimit") or die("could not Search!");
					
		$sql1 ="SELECT d.ExtDeptId,d.Dept_Name,
 (select count(id)  from tbl_student where school_id='$school_id' AND std_dept=d.Dept_Name) as no_students,
 (select count(id) from tbl_teacher where school_id='$school_id' AND t_dept=d.Dept_Name) as no_teacher,
 (select count(id)  from tbl_student where school_id='$school_id' AND email_status='Send_Email' AND std_dept=d.Dept_Name) as std_send_email,
(select count(id)  from tbl_student where school_id='$school_id' AND send_unsend_status='Send_SMS' AND std_dept=d.Dept_Name) as std_send_sms,
(select count(id)  from tbl_teacher where school_id='$school_id' AND email_status='Send_Email' AND t_dept=d.Dept_Name) as teacher_send_email,
(select count(id)  from tbl_teacher where school_id='$school_id' AND send_unsend_status='Send_SMS' AND t_dept=d.Dept_Name) as teacher_send_sms,
(select count(id)  from tbl_student where school_id='$school_id' AND std_dept=d.Dept_Name AND first_login_date !='') as login_std,
(select count(id) from tbl_teacher where school_id='$school_id' AND t_dept=d.Dept_Name AND first_login_date !='') as login_teacher
FROM tbl_department_master d
where d.school_id='$school_id'  AND `$colname` LIKE '%$searchq%' order by d.id";
			//echo $sql1;
			//}

		 
					$rs_result = mysql_query($sql1);  
					$row1 = mysql_num_rows($rs_result);  
					$total_records = $row1;  
					$total_pages = ceil($total_records / $webpagelimit);
		
	}else{
			//$q1="SELECT std_name,std_Father_name,std_lastname,std_complete_name,school_id,std_school_name,std_email,std_phone,std_address from tbl_student where group_member_id = '$group_member_id' AND (std_name LIKE '$searchq%' or std_Father_name LIKE '$searchq%' or std_lastname LIKE '$searchq%' or std_complete_name LIKE '%$searchq%' or school_id LIKE '$searchq%' or std_school_name LIKE '%$searchq%' or std_email LIKE '$searchq%' or std_phone LIKE '$searchq%'or std_address LIKE '$searchq%') order by school_id";
				
			$query1=mysql_query("SELECT d.ExtDeptId,d.Dept_Name,
 (select count(id)  from tbl_student where school_id='$school_id' AND std_dept=d.Dept_Name) as no_students,
 (select count(id) from tbl_teacher where school_id='$school_id' AND t_dept=d.Dept_Name) as no_teacher,
 (select count(id)  from tbl_student where school_id='$school_id' AND email_status='Send_Email' AND std_dept=d.Dept_Name) as std_send_email,
(select count(id)  from tbl_student where school_id='$school_id' AND send_unsend_status='Send_SMS' AND std_dept=d.Dept_Name) as std_send_sms,
(select count(id)  from tbl_teacher where school_id='$school_id' AND email_status='Send_Email' AND t_dept=d.Dept_Name) as teacher_send_email,
(select count(id)  from tbl_teacher where school_id='$school_id' AND send_unsend_status='Send_SMS' AND t_dept=d.Dept_Name) as teacher_send_sms,
(select count(id)  from tbl_student where school_id='$school_id' AND std_dept=d.Dept_Name AND first_login_date !='') as login_std,
(select count(id) from tbl_teacher where school_id='$school_id' AND t_dept=d.Dept_Name AND first_login_date !='') as login_teacher
FROM tbl_department_master d
where d.school_id='$school_id' AND (d.ExtDeptId='$searchq' or d.Dept_Name LIKE '%$searchq%') order by d.id LIMIT $start_from, $webpagelimit") or die("could not Search!");
			
			$sql1 ="select COUNT(d.id), d.ExtDeptId,d.Dept_Name,
 (select count(id)  from tbl_student where school_id='$school_id' AND std_dept=d.Dept_Name) as no_students,
 (select count(id) from tbl_teacher where school_id='$school_id' AND t_dept=d.Dept_Name) as no_teacher,
 (select count(id)  from tbl_student where school_id='$school_id' AND email_status='Send_Email' AND std_dept=d.Dept_Name) as std_send_email,
(select count(id)  from tbl_student where school_id='$school_id' AND send_unsend_status='Send_SMS' AND std_dept=d.Dept_Name) as std_send_sms,
(select count(id)  from tbl_teacher where school_id='$school_id' AND email_status='Send_Email' AND t_dept=d.Dept_Name) as teacher_send_email,
(select count(id)  from tbl_teacher where school_id='$school_id' AND send_unsend_status='Send_SMS' AND t_dept=d.Dept_Name) as teacher_send_sms,
(select count(id)  from tbl_student where school_id='$school_id' AND std_dept=d.Dept_Name AND first_login_date !='') as login_std,
(select count(id) from tbl_teacher where school_id='$school_id' AND t_dept=d.Dept_Name AND first_login_date !='') as login_teacher
FROM tbl_department_master d
where d.school_id='$school_id' order by d.id AND (d.ExtDeptId='$searchq' or d.Dept_Name LIKE '%$searchq%') order by d.id"; 

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

<!DOCTYPE html >
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $dynamic_school;?> Information</title>
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
   <!--  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css"> -->
   <!--  <script src="//code.jquery.com/jquery-1.10.2.js"></script> -->
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
	<script src="js/jquery.twbsPagination.js" type="text/javascript"></script>

   <!--  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script> -->
  <!-- <script>
        $(function() {
            $( "#from_date" ).datepicker({
                changeMonth: true,
                changeYear: true
            });
        });
        $(function() {
            $( "#to_date" ).datepicker({
                changeMonth: true,
                changeYear: true,
  
            });
        });
    </script> -->
    <script>
    $(document).ready(function() {
    $('#example').dataTable( {
	"paging":   false,
	"searching": false,
	"info":false,
     "scrollCollapse": true
		 } );
	} );
    </script>
	<?php if (!($_GET['Search'])){?>
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
			window.location.assign('dept_implementation_dashboard.php?page='+page);
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
			window.location.assign('dept_implementation_dashboard.php?colname=<?php echo $colname;?>&Search=<?php echo $searchq; ?>&spage='+page);
        });
    });
</script>
<?php }?>
    <style>
        @media only screen and (max-width: 800px) {
            /* Force table to not be like tables anymore */
            #no-more-tables table,
            #no-more-tables thead,
            #no-more-tables tbody,
            #no-more-tables th,
            #no-more-tables td,
            #no-more-tables tr {
                display: block;
            }
            /* Hide table headers (but not display: none;, for accessibility) */
            #no-more-tables thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
            #no-more-tables tr { border: 1px solid #ccc; }
            #no-more-tables td {
                /* Behave  like a "row" */
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
                white-space: normal;
                text-align:left;
                font:Arial, Helvetica, sans-serif;
            }
            #no-more-tables td:before {
                /* Now like a table header */
                position: absolute;
                /* Top/left values mimic padding */
                top: 6px;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                text-align:left;
            }
            /*
            Label the data
            */
            #no-more-tables td:before { content: attr(data-title); }
        }
    </style>
	
</head>

<body bgcolor="#CCCCCC">
<div align="center">
    <div class="container" style="width:100%;">
        <div style="padding-top:20px;">
            <h2 style="padding-left:20px; margin-top:2px;color:#666">Implementation Status Dashboard</h2>
        </div>

        <!-- <div  style=" height:30px; padding:5px;"></div> -->
        <!-- <form method="post" action="">
            <label for="from">From</label>
            <input type="text" id="from_date" name="from_date" placeholder="MM/DD/YYYY">
            <label for="to">to</label>
            <input type="text" id="to_date" name="to_date" placeholder="MM/DD/YYYY">&nbsp;&nbsp;
            <input type="submit" value="Search" name="search1" id="search1" />
        </form> -->
		
		<!-- <form style="margin-top:5px;">
					<div style="margin-left: 800px;">
						<input type="text" name="Search" placeholder="Search..">
						<input type="submit" value="Search">		
					</div>
		</form> -->
		<div class='row'>
		<form style="margin-top:5px;">
			 <div class="col-md-4" style="width:17%;">
			 </div>
			<div class="col-md-2" style="font-weight:bold; margin-right:-36px;">Search By
			</div>
            <div class="col-md-2" style="width:17%;">
                <select name="colname" class="form-control">
                    <option selected="selected">Select</option>
                    <option value="ExtDeptId"
					<?php if (($_GET['colname']) == "ExtDeptId") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Department ID </option>
                     <option value="Dept_Name"
					<?php if (($_GET['colname']) == "Dept_Name") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Department Name </option>
					
                </select>
			</div>
			<div class="col-md-2" style="width:17%;">
				<input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" placeholder="Search.." required> 
			</div>
			<div class="col-md-1" >
			<button type="submit" value="Search" class="btn btn-primary">Search</button>
			</div>
			<div class="col-md-1" >
			<input type="button" class="btn btn-info" value="Reset" onclick="window.open('dept_implementation_dashboard.php','_self')" />
			</div>
					<!-- <div style="margin-left: 800px;">
						<input type="text" name="Search" value="<?php echo $searchq; ?>" placeholder="Search..">
						<input type="submit" value="Search">
						<input type="button" value="Reset" onclick="window.open('beneficiary_list.php','_self')" />
					</div> -->
		</form>
		 </div><br> 
		<!--  <div id="show" >
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
			
		<?php /* 
					$sql12 ="select COUNT(id) from tbl_school_admin where group_member_id = '$group_member_id' order by school_id";  
					$rs_result = mysql_query($sql12);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);  
					if($total_pages == $_GET['page']){
					$webpagelimit = $total_records;
					}else{
					$webpagelimit = $start_from + $webpagelimit;
					}
					$pagLink =""; 
					for ($i=1; $i<=$total_pages; $i++) { 
						$mypage = !empty($_GET['page'])?$_GET['page']:1;
						if($i == $mypage){
							$class = 'active';
							$selected = "selected";
							$pagLink .= "<option value='club_list.php?page=".$i."'".$selected." >  ".$i.''." </option> ";
						}else{
							$class = '';
							   // $pagLink .= " <option value='index.php?page=".$i."'".$selected." ><a class='$class' href='index.php?page=".$i."'>".$i.''." </a></option> "; 
							   //$pagLink .="
							   $pagLink .= "<option value='club_list.php?page=".$i."'>  ".$i.''." </option> "; 
						}		   
					};
					echo "<div class='pagination'  style='margin-top:5px;'>";
					
					echo "<form><select onchange='location = this.value;' style='margin-left:100px;' >";
					echo $pagLink ."</select>";
					echo "<font color='blue'><b style='margin-left:10px;'>Go to page number</b>"; 
					echo "<b style='margin-left:400px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</b></font></form></div>";
				*/?>

			<?php
		if (isset($_GET['Search']))
		{
			/* $searchq=$_GET['Search'];
			$q1="SELECT sa.school_id,sa.school_name,sa.reg_date,sa.name,sa.school_balance_point,sa.school_assigned_point, (select count(id) from tbl_student where school_id=sa.school_id AND group_member_id=sa.group_member_id) as no_students,(select count(id) from tbl_teacher where school_id=sa.school_id AND group_member_id=sa.group_member_id) as no_teacher FROM tbl_school_admin sa where sa.group_member_id='13' AND (school_id LIKE '$searchq%' or school_name LIKE '%$searchq%' or reg_date LIKE '%$searchq%' or name LIKE '$searchq%' or school_balance_point LIKE '$searchq%' or school_assigned_point LIKE '$searchq%') order by school_id";

			$query1=mysql_query("SELECT sa.school_id,sa.school_name,sa.reg_date,sa.name,sa.school_balance_point,sa.school_assigned_point, (select count(id) from tbl_student where school_id=sa.school_id AND group_member_id=sa.group_member_id) as no_students,(select count(id) from tbl_teacher where school_id=sa.school_id AND group_member_id=sa.group_member_id) as no_teacher FROM tbl_school_admin sa where sa.group_member_id='13' AND (school_id LIKE '$searchq%' or school_name LIKE '%$searchq%' or reg_date LIKE '%$searchq%' or name LIKE '$searchq%' or school_balance_point LIKE '$searchq%' or school_assigned_point LIKE '$searchq%') order by school_id") or die("could not Search!"); */

			$count=mysql_num_rows($query1);
			if($count == 0){
				echo "<script>$('#show').css('display','none');</script><div style='margin-top:20px;'><font color='Red'><b>There Was No Search Result</b></font></div>";
			}
			else
			{
			?>
			<div id="no-more-tables">
            <table id="example" class="col-md-12 table-bordered table-striped "  >
                <thead>
					
				<!--  <tr>  <?php echo $q1;?></tr> -->
				<tr  style="background-color:#428BCA; color:#FFFFFF; height:30px;">
                    <th> Sr. No. </th>
                    <th>  Department ID </th>
                    <th> Department Name </th>
                    <th>  No. Of. Register <?= $dynamic_students ?></th>
                    <th> No. Of. Register <?= $dynamic_teacher?> </th>
                    <th> <?= $dynamic_students ?> Welcome Email </th>
                    <th> <?= $dynamic_students ?> Welcome SMS </th>
					<th> <?= $dynamic_teacher?> Welcome Email </th>
                    <th> <?= $dynamic_teacher?> Welcome SMS </th>
                    <th> No.of. Login <?= $dynamic_students ?> </th>
					 <th> No. Of. Login <?= $dynamic_teacher?> </th>
                   
                </tr>
                </thead>
                <?php $i=1;
				$i = ($start_from +1);
                while($result=mysql_fetch_array($query1)){
                   // $school_id=$result['school_id'];
				   ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>
                        <td data-title="Dept ID"><?php echo $result['ExtDeptId']; ?></td>
                        <td  data-title="Dept Name"><?php echo $result['Dept_Name'];?></td>
                     
						 <td data-title="No.of Students"><?php 
                        if($result['no_students']=="")
                        {
                            echo "0";
                        }else 
                        {
                            echo $result['no_students'];
                        }?></a></td>
                        
                        <?php
                        //$sql1="SELECT COUNT('id') as no_teacher  FROM tbl_teacher  where school_id='$school_id'";
                        //$row_teacher=mysql_query($sql1);
                        //$results=mysql_fetch_array($row_teacher);
                       ?>
                        <td data-title="No.of Teachers"><?php 
                        if($result['no_teacher']=="")
                        {
                            echo "0";
                        }else 
                        {
                            echo $result['no_teacher'];
                        }?></a></td>
					
						 <td data-title="No.of Student Email"><?php 
                        if($result['std_send_email']=="")
                        {
                            echo "0";
                        }else 
                        {
                            echo $result['std_send_email'];
                        }?></a></td>
						 <td data-title="No.of Student SMS"><?php 
                        if($result['std_send_sms']=="")
                        {
                            echo "0";
                        }else 
                        {
                            echo $result['std_send_sms'];
                        }?></a></td>
						 <td data-title="No.of teacher Email"><?php 
                        if($result['teacher_send_email']=="")
                        {
                            echo "0";
                        }else 
                        {
                            echo $result['teacher_send_email'];
                        }?></a></td>
						 <td data-title="No.of teacher SMS"><?php 
                        if($result['teacher_send_sms']=="")
                        {
                            echo "0";
                        }else 
                        {
                            echo $result['teacher_send_sms'];
                        }?></a></td>
						<td data-title="No.of login stdent"><?php 
                        if($result['login_std']=="")
                        {
                            echo "0";
                        }else 
                        {
                            echo $result['login_std'];
                        }?></a></td>
						<td data-title="No.of login teacher"><?php 
                        if($result['login_teacher']=="")
                        {
                            echo "0";
                        }else 
                        {
                            echo $result['login_teacher'];
                        }?></a></td>
                     <!--   <td  data-title="Reg.Date"><?php //echo $result['reg_date'];?></td>
                        
						 <td  data-title="Balance Blue Points"><?php //if(!empty($result['balance_blue_points'])){ echo $result['balance_blue_points'];} else {echo "0";}?></td>
						 
                        <td  data-title="Balance Points"><?php //if(!empty($result['school_balance_point'])){ echo $result['school_balance_point'];} else {echo "0";}?></td>
                       
					   <td > <a href="group_data_quality.php?school_id=<?php //echo $school_id;?>" style="text-decoration:none;"> <input type="button" value="report" name="assign"/></a></td>
                    -->
					</tr>
                    <?php  $i++;} ?>
            </table>
				</div>
				<!--Below pagination added by Rutuja for SMC-4464 on 30/01/2020-->
        <div align='left'>
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
        <div id="no-more-tables">
            <table id="example" class="col-md-12 table-bordered table-striped "  >
                <thead>
			 <!-- <tr>  <?php echo $s;?></tr>  -->
                <tr  style="background-color:#428BCA; color:#FFFFFF; height:30px;">
                    <th> Sr. No. </th>
                    <th>  Department ID </th>
                    <th> Department Name </th>
                    <th>  No. Of. Register <?= $dynamic_students ?></th>
                    <th> No. Of. Register <?= $dynamic_teacher?> </th>
                    <th> <?= $dynamic_students ?> Welcome Email </th>
                    <th> <?= $dynamic_students ?> Welcome SMS </th>
					<th> <?= $dynamic_teacher?> Welcome Email </th>
                    <th> <?= $dynamic_teacher?> Welcome SMS </th>
                    <th> No.of. Login <?= $dynamic_students ?> </th>
					 <th> No. Of. Login <?= $dynamic_teacher?> </th>
                </tr>
                </thead>
                <?php $i=1;
				$i = ($start_from +1);
                while($result=mysql_fetch_array($sql)){
                         $school_id=$result['school_id'];?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>
                        <td data-title="Dept ID"><?php echo $result['ExtDeptId']; ?></td>
                        <td  data-title="Dept Name"><?php echo $result['Dept_Name'];?></td>
                     
						 <td data-title="No.of Students"><?php 
                        if($result['no_students']=="")
                        {
                            echo "0";
                        }else 
                        {
                            echo $result['no_students'];
                        }?></a></td>
                        
                        <?php
                        //$sql1="SELECT COUNT('id') as no_teacher  FROM tbl_teacher  where school_id='$school_id'";
                        //$row_teacher=mysql_query($sql1);
                        //$results=mysql_fetch_array($row_teacher);
                       ?>
                        <td data-title="No.of Teachers"><?php 
                        if($result['no_teacher']=="")
                        {
                            echo "0";
                        }else 
                        {
                            echo $result['no_teacher'];
                        }?></a></td>
					
						 <td data-title="No.of Student Email"><?php 
                        if($result['std_send_email']=="")
                        {
                            echo "0";
                        }else 
                        {
                            echo $result['std_send_email'];
                        }?></a></td>
						 <td data-title="No.of Student SMS"><?php 
                        if($result['std_send_sms']=="")
                        {
                            echo "0";
                        }else 
                        {
                            echo $result['std_send_sms'];
                        }?></a></td>
						 <td data-title="No.of teacher Email"><?php 
                        if($result['teacher_send_email']=="")
                        {
                            echo "0";
                        }else 
                        {
                            echo $result['teacher_send_email'];
                        }?></a></td>
						 <td data-title="No.of teacher SMS"><?php 
                        if($result['teacher_send_sms']=="")
                        {
                            echo "0";
                        }else 
                        {
                            echo $result['teacher_send_sms'];
                        }?></a></td>
						<td data-title="No.of login stdent"><?php 
                        if($result['login_std']=="")
                        {
                            echo "0";
                        }else 
                        {
                            echo $result['login_std'];
                        }?></a></td>
						<td data-title="No.of login teacher"><?php 
                        if($result['login_teacher']=="")
                        {
                            echo "0";
                        }else 
                        {
                            echo $result['login_teacher'];
                        }?></a></td>
					   </tr>
                    <?php  $i++;} ?>
            </table>
        </div>
        <!--Below pagination added by Rutuja for SMC-4464 on 30/01/2020-->
        <div align='left'>
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
    </div>
</div>
<!-- </div>
</div> -->

</body>
</html>