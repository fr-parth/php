<?php
include('scadmin_header.php');?>
 
<?php
$report="";
$id=$_SESSION['id'];
$x=$_SESSION['AcademicYear'];
$fields=array("id"=>$id);
/*  $table="tbl_school_admin"; */
$smartcookie=new smartcookie();
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
//change done by Pranali
$sc_id=$_SESSION['school_id'];

// $webpagelimit = 10;
if (!($_GET['Search'])){  
	if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
	$start_from = ($page-1) * $webpagelimit;
	if($x != "" && $x != "All"  ){ 
		$sql=mysql_query("SELECT std_name,std_Father_name,std_lastname,std_complete_name,std_PRN,std_dept,std_email,
		std_phone,Academic_Year,Course_level FROM tbl_student WHERE school_id='$sc_id' AND promotion!=1  AND Academic_Year <='$x'
		ORDER BY std_complete_name LIMIT $start_from, $webpagelimit");
		$sql1 ="SELECT COUNT(id) FROM tbl_student WHERE school_id='$sc_id' AND Academic_Year <='$x' ORDER BY std_complete_name"; 


		// select t_emp_type_pid,id,t_designation, t_id, t_complete_name, t_name, t_middlename, t_lastname, t_email,t_phone, t_dept,t_DeptCode , t_pc,school_id, t_academic_year from tbl_teacher where school_id='$sc_id' AND t_academic_year<='$Academic_Year' $where order by t_complete_name ASC";
 
	} else { 
		$sql=mysql_query("SELECT std_name,std_Father_name,std_lastname,std_complete_name,std_PRN,std_dept,std_email,
		std_phone,Academic_Year,Course_level FROM tbl_student WHERE school_id='$sc_id' AND promotion!=1 
		ORDER BY std_complete_name LIMIT $start_from, $webpagelimit");
		$sql1 ="SELECT COUNT(id) FROM tbl_student WHERE school_id='$sc_id'  ORDER BY std_complete_name";  
	}
	$rs_result = mysql_query($sql1);  
	$row1 = mysql_fetch_row($rs_result);  
	$total_records = $row1[0];  
	$total_pages = ceil($total_records / $webpagelimit);
	if($total_pages == $_GET['page']){
		$webpagelimit = $total_records;
	}else{
		$webpagelimit = $start_from + $webpagelimit;
	}
}else{
	if (isset($_GET["spage"])){ $spage  = $_GET["spage"]; } else { $spage=1; };  
			$start_from = ($spage-1) * $webpagelimit;
//trim added at $_GET['Search'] by Pranali for SMC-5038
			$searchq=trim($_GET['Search']);
			$colname=$_GET['colname'];
			$dept_cond="";

	//Added below condition for checking ExtDeptId if selected department option and replaced std_dept by ExtDeptId in all below queries by Pranali for SMC-5038
	if($colname == 'ExtDeptId' || $colname == 'Select')
	{ 
			$search_dept = mysql_query("SELECT Dept_Name,ExtDeptId FROM tbl_department_master WHERE Dept_Name like '%".$searchq."%' AND School_id='".$sc_id."'");
			$res_dept = mysql_fetch_array($search_dept);
			$dept_ExtDeptId = $res_dept['ExtDeptId'];
			$dept_cond = " OR `$colname` = '".$dept_ExtDeptId."'";
	}

	if ($colname != ''and $colname != 'Select'  and $colname != 'Academic_Year'){
				
		$query1=mysql_query("SELECT std_name,std_Father_name,std_lastname,std_complete_name,std_PRN,
		std_dept,std_email,std_phone,Academic_Year,Course_level 
		FROM tbl_student 
		where school_id = '$sc_id' AND promotion!=1 AND (`$colname` LIKE '%$searchq%'  $dept_cond) 
		order by std_complete_name  LIMIT $start_from, $webpagelimit") or die("could not Search!");
					
		$sql1 ="select COUNT(id),std_name,std_Father_name,std_lastname,std_complete_name,school_id,std_school_name,
		std_email,std_phone,std_address from tbl_student
		where school_id = '$sc_id' AND promotion!=1 AND (`$colname` LIKE '%$searchq%' $dept_cond)  order by std_complete_name"; 
		
		$rs_result = mysql_query($sql1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);
	}
		
		  else if($colname != ''and $colname != 'Select' and $colname == 'Academic_Year')
		  { 
			$query1=mysql_query("SELECT std_name,std_Father_name,std_lastname,std_complete_name,std_PRN,
			std_dept,std_email,std_phone,Academic_Year,Course_level 
			FROM tbl_student 
			where school_id = '$sc_id' AND promotion!=1  AND Academic_Year <= '$searchq'  
			order by std_complete_name  LIMIT $start_from, $webpagelimit") or die("could not Search!");
						
			$sql1 ="select COUNT(id),std_name,std_Father_name,std_lastname,std_complete_name,school_id,std_school_name,
			std_email,std_phone,std_address from tbl_student
			where school_id = '$sc_id' AND promotion!=1  AND Academic_Year <= '$searchq'    order by std_complete_name"; 
		 //echo $sql1;exit;
		  
		
		
		  //echo $sql1; exit;
					$rs_result = mysql_query($sql1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);
	//echo $sql1; exit;	
		  }			
	
	else{ 
		
			$query1=mysql_query("SELECT std_name,std_Father_name,std_PRN,std_dept,Academic_Year,Course_level,std_lastname,
			std_complete_name,school_id,std_school_name,std_email,std_phone,std_address 
			FROM tbl_student
			WHERE school_id = '$sc_id' AND promotion!=1  AND (std_name LIKE '$searchq%' or std_Father_name LIKE '$searchq%' 
			or std_lastname LIKE '$searchq%' or std_complete_name LIKE '%$searchq%' or school_id LIKE '$searchq%' 
			or std_school_name LIKE '%$searchq%' or std_email LIKE '$searchq%' or std_phone LIKE '$searchq%'
			or std_address LIKE '$searchq%' or std_PRN LIKE '$searchq%'or ExtDeptId LIKE '$dept_ExtDeptId%'
			or Academic_Year LIKE '$searchq%'or Course_level LIKE '$searchq%') order by school_id 
			LIMIT $start_from, $webpagelimit") or die("could not Search!");
			
			$sql1 ="SELECT COUNT(id) from tbl_student
			WHERE school_id = '$sc_id' AND promotion!=1 and Academic_Year <= '$Academic_Year'
			AND (std_name LIKE '$searchq%' or std_Father_name LIKE '$searchq%' or std_lastname LIKE '$searchq%' or std_complete_name LIKE '%$searchq%' or std_PRN LIKE '$searchq%' or ExtDeptId LIKE '$dept_ExtDeptId%' or
			 std_email LIKE '$searchq%' or std_phone LIKE '$searchq%' or Academic_Year <= '$searchq%' or Course_level LIKE '$searchq%')  order by std_complete_name";   
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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Info Table</title>
<!--link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script-->
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
			window.location.assign('studlist.php?page='+page);
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
			window.location.assign('studlist.php?colname=<?php echo $colname;?>&Search=<?php echo $searchq; ?>&spage='+page);
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
		padding-left: 20%; 
		white-space: normal;
		text-align: left;
		font:Arial, Helvetica, sans-serif;
        font-size: 10px;
	}
	#no-more-tables td:before { 
		/* Now like a table header */
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		padding-right: 10px; 
		white-space: nowrap;
	}
	/*
	Label the data
	*/
	#no-more-tables td:before { content: attr(data-title); }
    .rows{
        width: 95%;
    }
}
</style>
</head>
<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">
    <div class="container" style="padding:10px;" >
        <div style="background-color:#F8F8F8 ;">
			<div class="row">
                <div class="col-md-3"  style="color:#700000 ;padding:5px;">
                </div>
                <div class="col-md-6 " align="center">
                    <h2>List of <?php echo $dynamic_student;?> </h2>
                </div>
				<div class="col-md-3"  style="color:#700000 ;padding:5px;">
                </div>
			</div>
					<form style="margin-top:9px;">
			<div class="col-md-2"></div>
			<div class="col-md-2" style="font-weight:bold;" align="right">Search By
			</div>
            <div class="col-md-2" style="width:17%;">
                <select name="colname" class="form-control">
                    <option selected="selected">Select</option>
                    <option value="std_complete_name"
					<?php if (($_GET['colname']) == "std_complete_name") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>>Name</option>
                     <option value="std_PRN"
					<?php if (($_GET['colname']) == "std_PRN") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>> <?php echo $dynamic_emp;?></option>
                     <!--ExtDeptId added for department by Pranali for SMC-5038-->
					<option value="std_dept"
					<?php if (($_GET['colname']) == "std_dept") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>> Department</option>  
							<option value="std_email"
					<?php if (($_GET['colname']) == "std_email") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>> Email</option>  
							<option value="std_phone"
					<?php if (($_GET['colname']) == "std_phone") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>> Phone</option>  
							<option value="Academic_Year"
					<?php if (($_GET['colname']) == "Academic_Year") {
                            echo $_GET['colname']; ?> selected="selected" <?php } ?>> Year of Joining</option> 
							
							
							<?php if (($school_type == 'school' or $school_type == 'organization') && $user=='School Admin'){?>
							<option value="Course_level"
					<?php if (($_GET['colname']) == "Course_level ") {
                            echo $_GET['colname']; ?> selected="selected" <?php }} ?>> Course Level</option>
                </select>
			</div>
			<div class="col-md-2" style="width:17%;">
				<input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" placeholder="Search.." required> 
			</div>
			<div class="col-md-1">
			<button type="submit" value="Search" class="btn btn-primary">Search</button>
			</div>
			<div class="col-md-1">
			<input type="button" class="btn btn-danger" value="Reset" onclick="window.open('studlist.php','_self')" />
			</div>
		</form>
		<br>
		 <!-- <div id="show" style="margin-top: 70px;">
		 			<?php if (!($_GET['Search']))
		 			{   
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<font color='blue' style='margin-left: 29px;'><b style='margin-left:400px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</b></font></div>";
		    }else
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<font color='blue' style='margin-left: 29px;'><b style='margin-left:400px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".($total_records). " records.</b></font></div>";
		 			}
		 			?>
		 			 </div> -->
			<?php
		if (isset($_GET['Search']))
		{
			$count=mysql_num_rows($query1);
			if($count == 0){
					echo "<script>$('#show').css('display','none');</script><div style='margin-top:66px;'><font color='Red' style='margin-left: 29px;'><b style='margin-left:490px;'><b>There Was No Search Result</b></font></div>";
			}
			else
			{
			?>
			<div id="no-more-tables">
				 <div class="table-responsive" style="padding:10px;" >
                            <table id="example" class="table table-bordered">
                            <thead>
                            <tr style="background-color:#428BCA;color:#FFFFFF;height:30px;">
                                <th>Sr.No</th>
                                <th><?php echo $dynamic_student;?> Name</th>
                                <th><?php echo $dynamic_emp;?></th>
                                <th>Department</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Academic Year</th>
                                <?php if (($school_type == 'school' or $school_type == 'organization') && $user=='School Admin'){?>
                                <th>Course level</th>
								<?php }?>
								<!--displayed dynamic variable $dynamic_subject by Pranali for SMC-5037-->
                                <th><?php echo $dynamic_subject; ?></th>
                            </tr>
							
                            </thead>
                            <?php
							$i=($start_from +1);
                                while ($row = mysql_fetch_array($query1)) { 
									$std_PRN=$row['std_PRN'];
									?>

                            <tr class="d0" style="height:30px;color:#808080;">  
                                <td><b><?php echo $i;?></b></td>
					            <!--td><php echo $row['std_complete_name'];?></td-->
								<td><?php
							$std_complete_name = ucwords(strtolower($row['std_complete_name']));
								if ($std_complete_name == '') {
                                echo ucwords(strtolower($row['std_name'])) . " " . ucwords(strtolower($row['std_Father_name'])) . " " . ucwords(strtolower($row['std_lastname']));
                            } else {
                                echo $std_complete_name;
                            }
                            ?></td>
					            <td><?php echo $std_PRN;?></td>
                                <td><center><?php
                                //changed $sc_id variable in query by Pranali for SMC-5038
								
								
									echo $row['std_dept'];?></center></td>
					            <td><?php echo $row['std_email'];?></td>
                                <td><?php echo $row['std_phone'];?></td>
					            <td><?php echo $row['Academic_Year'];?></td>
								
                                <?php if (($school_type == 'school' or $school_type == 'organization') && $user=='School Admin'){?>
                                <td><?php echo $row['Course_level'];?></td>
								<?php }?>

								<td style="width:100px;">
                                    <center>
                                    <?php  $sub_id= $row['id'];?>

									<form method="post" action="display_stud_all_subject.php">
									<input type='hidden' name='Name' value='<?php echo $row['std_complete_name']; ?>'>
									<input type='hidden' name='prn' value='<?php echo $row['std_PRN']; ?>'>
									<input type='hidden' name='school_id' value='<?php echo $result['school_id']; ?>'>
									<input type='hidden' name='courselevel' value='<?php echo $row['Course_level']; ?>'>

                                    <input type='submit' name='subject' value='show <?php echo $dynamic_subject;?>'>
									</form>
                                    </center>
                                </td>
								
					            <!-- <td style="width:100px;"> -->
                                    <!-- <center> -->
                                    <!-- <?php // $sub_id= $row['id'];?> -->
                                    <!-- <a href='display_stud_all_subject.php?Name=<?php //echo $row['std_complete_name']; ?> -->
									<!-- &prn=<?php //echo $row['std_PRN']; ?>&school_id=<?php //echo $result['school_id'];?>'> -->
									<!-- <input type='button' name='subject' value='show <?php //echo $dynamic_subject;?>'> -->
                                    <!-- </center> -->
                                <!-- </td> -->
                            </tr>
                            <?php $i++;?>
                            <?php }?>
                            </tbody>
                        </table>
					</div>
			<div class="container" align="center">
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
                        <!--table class="table-bordered table-striped" id="example" width="100%;"-->
						<div id="no-more-tables">
				 <div class="table-responsive" style="padding:10px;" >
                            <table id="example" class="table table-bordered">
                            <thead>
                            <tr style="background-color:#428BCA;color:#FFFFFF;height:30px;">
                                <th><center>Sr.No</center></th>
                                <th><center><?php echo $dynamic_student;?> Name</center></th>
                                <th><center><?php echo $dynamic_emp;?></center></th>
                                <th><center>Department</center></th>
                                <th><center>Email</center></th>
                                <th><center>Phone</center></th>
                                <th><center>Academic Year</center></th>
								
								<?php if (($school_type == 'school' or $school_type == 'organization') && $user=='School Admin'){?>
                                <th><center>Course level</center></th>
								<?php }?>
								<!--displayed dynamic variable $dynamic_subject by Pranali for SMC-5037-->
                                <th><center><?php echo $dynamic_subject; ?></center></th>
                            </tr>
                            </thead>
                            <?php
							$i=($start_from +1);
                                while ($row = mysql_fetch_array($sql)) { 
									$std_PRN=$row['std_PRN'];
									?>

                            <tr class="d0" style="height:30px;color:#808080;">  
                                <td><center><b><?php echo $i;?></b></center></td>
					            <!--td><php echo $row['std_complete_name'];?></td-->
								<td><center><?php
							$std_complete_name = ucwords(strtolower($row['std_complete_name']));
								if ($std_complete_name == '') {
                                echo ucwords(strtolower($row['std_name'])) . " " . ucwords(strtolower($row['std_Father_name'])) . " " . ucwords(strtolower($row['std_lastname']));
                            } else {
                                echo $std_complete_name;
                            }
                            ?></center></td>
					            <td><center><?php echo $row['std_PRN'];?></center></td>
                                <td><center><?php 
								//query added by Sayali for SMC-5030 on 11/12/2020
								 //changed $sc_id variable in query by Pranali for SMC-5038	
							echo $row['std_dept'];?></center></td>
								
					            <td><center><?php echo $row['std_email'];?></center></td>
                                <td><center><?php echo $row['std_phone'];?></center></td>
					            <td><center><?php echo $row['Academic_Year'];?></center></td>
									
									
								<?php if (($school_type == 'school' or $school_type == 'organization') && $user=='School Admin'){?>
                                <td><center><?php echo $row['Course_level'];?></center></td>
								<?php }?>
								
					            <td style="width:100px;">
                                    <center>
                                    <?php  $sub_id= $row['id'];?>

									<form method="post" action="display_stud_all_subject.php">
									<input type='hidden' name='Name' value='<?php echo $row['std_complete_name']; ?>'>
									<input type='hidden' name='prn' value='<?php echo $row['std_PRN']; ?>'>
									<input type='hidden' name='school_id' value='<?php echo $result['school_id']; ?>'>
									<input type='hidden' name='courselevel' value='<?php echo $row['Course_level']; ?>'>

                                    <input type='submit' name='subject' value='show <?php echo $dynamic_subject;?>'>
									</form>
                                    </center>
                                </td>
                            </tr>
                            <?php $i++;?>
                            <?php }?>
                            </tbody>
                        </table>
						 </div> 	
			<div class="container" align="center">
			<nav aria-label="Page navigation">
			  <ul class="pagination" id="pagination"></ul>
		    </nav>
		</div>
<?php } ?>
                </div>  
                <!-- <div class="row" style="padding:5px;">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-3 "  align="center">
                        </form>
                    </div>
                </div>
                
                <div class="row" >
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-3"  style="color:#FF0000;" align="center">
                        <php echo $report;?>
                    </div>
                </div>
                 -->
            </div>                      
       </div>
    </div>
</body>
<!--END-->
</html>
