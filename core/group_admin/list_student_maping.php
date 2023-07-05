<?php
//Updated by Rutuja for adding pagination on 24/01/2020 for SMC-3922
include("groupadminheader.php");
$group_member_id = $_SESSION['group_admin_id'];

//$webpagelimit = 10;
if (!($_GET['Search'])){

if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; };  
$start_from = ($page-1) * $webpagelimit;
	//echo"select * from  tbl_student_subject_master where group_member_id='$group_member_id'";
$sql=mysql_query("select stm.student_id,stm.school_id,stm.subjcet_code,stm.subjectName,st.std_name,st.std_Father_name,st.std_lastname,st.std_complete_name,sa.school_name from tbl_student_subject_master stm  inner join tbl_school_admin sa on sa.school_id = stm.school_id join tbl_student st on stm.student_id = st.std_PRN and stm.school_id = st.school_id inner join tbl_group_school gs on sa.school_id=gs.school_id where gs.group_member_id ='$group_member_id' order by stm.school_id LIMIT $start_from, $webpagelimit");	

$sql1 ="select count(stm.group_member_id)as count from tbl_school_admin sa inner join tbl_student_subject_master stm on sa.school_id = stm.school_id join tbl_student st on stm.student_id = st.std_PRN and stm.school_id = st.school_id inner join tbl_group_school gs on sa.school_id=gs.school_id where gs.group_member_id ='$group_member_id' order by stm.school_id"; 
//echo $sql1;
					$rs_result = mysql_query($sql1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0]; 
					//echo $total_records;
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
		if($colname== "school_id"){
        $colname = "stm.".$colname;
		$query1=mysql_query("select stm.student_id,stm.school_id,stm.subjcet_code,stm.subjectName,st.std_name,st.std_Father_name,st.std_lastname,st.std_complete_name ,sa.school_name from tbl_school_admin sa inner join tbl_student_subject_master stm on sa.school_id = stm.school_id join tbl_student st on stm.student_id = st.std_PRN and stm.school_id = st.school_id inner join tbl_group_school gs on sa.school_id=gs.school_id where gs.group_member_id ='$group_member_id' AND $colname LIKE '%$searchq%' LIMIT $start_from, $webpagelimit") or die("could not Search!");
			}else{
				$query1=mysql_query("select stm.student_id,stm.school_id,stm.subjcet_code,stm.subjectName,st.std_name,st.std_Father_name,st.std_lastname,st.std_complete_name ,sa.school_name from tbl_school_admin sa inner join tbl_student_subject_master stm on sa.school_id = stm.school_id join tbl_student st on stm.student_id = st.std_PRN and stm.school_id = st.school_id inner join tbl_group_school gs on sa.school_id=gs.school_id where gs.group_member_id ='$group_member_id' AND $colname LIKE '%$searchq%' LIMIT $start_from, $webpagelimit") or die("could not Search!");
			}		
		$sql1 ="select COUNT(stm.group_member_id) as count  from tbl_school_admin sa inner join tbl_student_subject_master stm on sa.school_id = stm.school_id join tbl_student st on stm.student_id = st.std_PRN and stm.school_id = st.school_id inner join tbl_group_school gs on sa.school_id=gs.school_id where gs.group_member_id ='$group_member_id' AND $colname LIKE '%$searchq%' "; 
					$rs_result = mysql_query($sql1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0]; 
					//echo $total_records;
					$total_pages = ceil($total_records / $webpagelimit);

	}else{

			$query1=mysql_query("select stm.student_id,stm.school_id,stm.subjcet_code,stm.subjectName,st.std_name,st.std_Father_name,st.std_lastname,st.std_complete_name ,sa.school_name from tbl_school_admin sa inner join tbl_student_subject_master stm on sa.school_id = stm.school_id join tbl_student st on stm.student_id = st.std_PRN and stm.school_id = st.school_id inner join tbl_group_school gs on sa.school_id=gs.school_id where gs.group_member_id ='$group_member_id' AND (student_id LIKE '%$searchq%' or stm.school_id LIKE '%$searchq%' or stm.subjcet_code LIKE '%$searchq%' or stm.subjectName LIKE '%$searchq%' or st.std_school_name LIKE '%$searchq%') LIMIT $start_from, $webpagelimit") or die("could not Search!");
			
			$sql1 ="select COUNT(stm.group_member_id) as count from tbl_school_admin sa inner join tbl_student_subject_master stm on sa.school_id = stm.school_id join tbl_student st on stm.student_id = st.std_PRN and stm.school_id = st.school_id inner join tbl_group_school gs on sa.school_id=gs.school_id where gs.group_member_id ='$group_member_id' AND (student_id LIKE '%$searchq%' or stm.school_id LIKE '%$searchq%' or stm.subjcet_code LIKE '%$searchq%' or stm.subjectName LIKE '%$searchq%' or st.std_school_name LIKE '%$searchq%')"; 

			$rs_result = mysql_query($sql1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					//echo $total_records;
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Beneficiary Information</title>
    <link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="../js/jquery-1.11.1.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>

    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<script src="../js/jquery.twbsPagination.js" type="text/javascript"></script>
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
			window.location.assign('list_student_maping.php?page='+page);
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
			window.location.assign('list_student_maping.php?colname=<?php echo $colname;?>&Search=<?php echo $searchq; ?>&spage='+page);
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

            #no-more-tables tr {
                border: 1px solid #ccc;
            }

            #no-more-tables td {
                /* Behave  like a "row" */
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
                white-space: normal;
                text-align: left;
                font: Arial, Helvetica, sans-serif;
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
                text-align: left;

            }
            /*
            Label the data
            */
            #no-more-tables td:before {
                content: attr(data-title);
            }
        }
    </style>
</head>

<body bgcolor="#CCCCCC">
<div align="center">
    <div class="container" style="width:100%;">
        <div style="padding-top:30px;">

            <h2 style="padding-left:20px; margin-top:2px;color:#666"> List of <?php echo $dynamic_student;?> <?php echo $dynamic_subject;?></h2>

        </div>
		<div class='row'>
		 <form style="margin-top:5px;">
			 <div class="col-md-4" style="width:17%;">
			 </div>
			<div class="col-md-2" style="font-weight:bold; margin-right:-36px;">Search By
			</div>
		            <div class="col-md-2" style="width:17%;">
		                <select name="colname" class="form-control">
		                    <option selected="selected">Select</option>
		                    <option value="student_id"
					<?php if (($_GET['colname']) == "student_id") {
		                            echo $_GET['colname']; ?> selected="selected" <?php } ?>><?php echo $dynamic_student;?> ID</option>
		                     <option value="stm.school_id"
					<?php if (($_GET['colname']) == "stm.school_id") {
		                            echo $_GET['colname']; ?> selected="selected" <?php } ?>><?php echo $dynamic_school;?> ID</option>
							<option value="stm.subjcet_code"
					<?php if (($_GET['colname']) == "stm.subjcet_code") {
		                            echo $_GET['colname']; ?> selected="selected" <?php } ?>><?php echo $dynamic_subject;?> Code</option>
							<option value="stm.subjectName"
					<?php if (($_GET['colname']) == "stm.subjectName") {
		                            echo $_GET['colname']; ?> selected="selected" <?php } ?>><?php echo $dynamic_subject;?> Title</option>
							<option value="sa.school_name"
					<?php if (($_GET['colname']) == "sa.school_name") {
		                            echo $_GET['colname']; ?> selected="selected" <?php } ?>><?php echo $dynamic_school;?> Name</option>
					
		                </select>
			</div>
			<div class="col-md-2" style="width:17%;">
				<input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" placeholder="Search.." required> 
			</div>
			<div class="col-md-1" >
			<button type="submit" value="Search" class="btn btn-primary">Search</button>
			</div>
			<div class="col-md-1" >
			<input type="button" class="btn btn-info" value="Reset" onclick="window.open('list_student_maping.php','_self')" />
			</div>
				
		</form>
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
		 </div> 
	
		<?php
		if (isset($_GET['Search']))
		{
			
			$count=mysql_num_rows($query1);
			if($count == 0){
				
				echo "<script>$('#show').css('display','none');</script><div style='margin-top:20px;'><font color='Red'><b>There Was No Search Result</b></font></div>";	
			}
			else
			{
			?>
			<div id="no-more-tables" style="padding-top:20px;">

             <table id="example" class="col-md-10 table-bordered " align="center">
                            <thead>
                            <tr style="background-color:#0073BD; color:#FFFFFF; height:30px;">
                                <th style="width:50px;"><b>
								<!-- Camel casing done for Sr. No. by Pranali -->
                                        <center>Sr. No.</center>
                                    </b>
									</th>
								<th style="width:350px;">
                                    <center><?php echo $dynamic_school;?> ID</center>
                                </th>
								<th style="width:350px;">
                                    <center><?php echo $dynamic_school;?> Name</center>
                                </th>
                                <th style="width:350px;">
                                    <center><?php echo $dynamic_student;?> Name</center>
                                </th>
                                <th style="width:350px;">
                                    <center><?php echo $dynamic_student;?> ID</center>
                                </th>
                                 
								<th style="width:350px;">
                                    <center><?php echo $dynamic_subject;?> Title</center>
                                </th>
								<th style="width:150px;">
                                    <center><?php echo $dynamic_subject;?> Code</center>
                                </th>
                                
								
                               <!--  <th style="width:350px;">
                                    <center>Branch</center>
                                </th>
                                <th style="width:50px;">
                                    <center>Semester</center>
                                </th>
                                <th style="width:100px;">
                                    <center>Course Level</center>
                                </th> -->
                                <!-- <th style="width:50px;">
                                    <center>Edit</center>
                                </th>
                                <th style="width:100px;">
                                    <center>Delete</center>
                                </th> -->
                            </tr>
                            </thead>
                            <tbody>

					<?php $i = 1;
					 $i = ($start_from +1);
					while ($row = mysql_fetch_array($query1)) 
										{
                                    $PRN = $row['student_id'];
									$std_id = $row['id'];
									
                                    ?>
                                    <tr style="height:30px;color:#808080;">
                                        <th style="width:50px;"><b>
                                                <center><?php echo $i; ?></center>
                                            </b></th>
                                        <?php
										//echo "select * from tbl_student where std_PRN='$PRN' and group_member_id='$group_member_id'";
                                        //$getteachername = mysql_query("select * from tbl_student where std_PRN='$PRN' and group_member_id='$group_member_id'");
										
                                        //while ($getRows = mysql_fetch_array($getteachername)) 
                                        //{
                                            $name = $row['std_name'];
                                            $Mname = $row['std_Father_name'];
                                            $Lname = $row['std_lastname'];
                                            $studentName = $row['std_complete_name'];
                                            if($studentName=='')
                                            {
											
                                           $studentName = $name . " " . $Mname . " " . $Lname;
											}
											else
											{
												 $studentName;
											}
                                       // }

                                        ?>
										<th style="width:100px;">
                                            <center><?php echo $row['school_id']; ?> </center>
                                        </th>
										<th style="width:100px;">
                                            <center><?php $school_name=$row['school_name']; $school_name=ucwords($school_name); echo $school_name;?></center>
                                        </th>
                                        <th style="width:100px;">
                                            <center><?php echo $studentName ?> </center>
                                        </th>
                                        <th style="width:100px;">
                                            <center><?php echo $row['student_id']; ?> </center>
                                        </th>
                                        <th style="width:400px;">
                                            <center><?php echo $row['subjectName']; ?></center>
                                        </th>
                                        <th style="width:100px;">
                                            <center><?php echo $row['subjcet_code']; ?> </center>
                                        </th>
                                        <!-- <th style="width:400px;">
                                            <center><?php echo $row['Branches_id']; ?></center>
                                        </th>
                                        <th style="width:50px;">
                                            <center><?php echo $row['Semester_id']; ?></center>
                                        </th>
                                        <th style="width:100px;">
                                            <center><?php echo $row['CourseLevel']; ?></center>
                                        </th> -->
                                     <!--   <th style="width:100px;">
                                            <center><?php $subjcet_code = $row['subjcet_code']; ?>
                                            <a href="edit_student_subject.php?subject=<?= $subjcet_code; ?>" 
                                                   style="width:100px;"><span class="glyphicon glyphicon-pencil"></span> </a> 
											 <a href="#" 
                                                   style="width:100px;"><span class="glyphicon glyphicon-pencil"></span> </a>
                                            </center>
                                        </th>
                                        <th style="width:100px;">
										<?php// echo $row['student_id'];?>
                                           <center><a onClick="confirmation('<?php echo $std_id ?>' )"><span class="glyphicon glyphicon-trash"></span></a>
                                            </center> 
											<center><a onClick="confirmation('#' )"><span class="glyphicon glyphicon-trash"></span></a>
                                            </center>
                                        </th>  -->
                                    </tr>
                                    <?php $i++; } ?>    
                            </tbody>
			</table>
       </div>
		
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
        <div id="no-more-tables" style="padding-top:20px;">

            <table id="example" class="col-md-10 table-bordered " align="center">
                            <thead>
                            <tr style="background-color:#0073BD; color:#FFFFFF; height:30px;">
                                <th style="width:50px;"><b>
								<!-- Camel casing done for Sr. No. by Pranali -->
                                        <center>Sr. No.</center>
                                    </b>
									</th>
								<th style="width:350px;">
                                    <center><?php echo $dynamic_school;?> ID</center>
                                </th>
								<th style="width:350px;">
                                    <center><?php echo $dynamic_school;?> Name</center>
                                </th>
                                <th style="width:350px;">
                                    <center><?php echo $dynamic_student;?> Name</center>
                                </th>
                                <th style="width:350px;">
                                    <center><?php echo $dynamic_student;?> ID</center>
                                </th>
                                 
								<th style="width:350px;">
                                    <center><?php echo $dynamic_subject;?> Title</center>
                                </th>
								<th style="width:150px;">
                                    <center><?php echo $dynamic_subject;?> Code</center>
                                </th>
                                
								
                               <!--  <th style="width:350px;">
                                    <center>Branch</center>
                                </th>
                                <th style="width:50px;">
                                    <center>Semester</center>
                                </th>
                                <th style="width:100px;">
                                    <center>Course Level</center>
                                </th> 
                                <th style="width:50px;">
                                    <center>Edit</center>
                                </th>
                                <th style="width:100px;">
                                    <center>Delete</center>
                                </th> -->
                            </tr>
                            </thead>
                            <tbody>

					<?php $i = 1;
					 $i = ($start_from +1);
					while ($row = mysql_fetch_array($sql)) 
										{
                                    $PRN = $row['student_id'];
									$std_id = $row['id'];
									
                                    ?>
                                    <tr style="height:30px;color:#808080;">
                                        <th style="width:50px;"><b>
                                                <center><?php echo $i; ?></center>
                                            </b></th>
                                        <?php
										//echo "select * from tbl_student where std_PRN='$PRN' and group_member_id='$group_member_id'";
                                        //$getteachername = mysql_query("select * from tbl_student where std_PRN='$PRN' and group_member_id='$group_member_id'");
										
                                        //while ($getRows = mysql_fetch_array($getteachername)) 
                                        //{
                                            $name = $row['std_name'];
                                            $Mname = $row['std_Father_name'];
                                            $Lname = $row['std_lastname'];
                                            $studentName = $row['std_complete_name'];
                                            if($studentName=='')
                                            {
											
                                           $studentName = $name . " " . $Mname . " " . $Lname;
											}
											else
											{
												 $studentName;
											}
                                       // }

                                        ?>
										<th style="width:100px;">
                                            <center><?php echo $row['school_id']; ?> </center>
                                        </th>
										<th style="width:100px;">
                                            <center><?php $school_name=$row['school_name']; $school_name=ucwords($school_name); echo $school_name;?> </center>
                                        </th>
                                        <th style="width:100px;">
                                            <center><?php echo $studentName ?> </center>
                                        </th>
                                        <th style="width:100px;">
                                            <center><?php echo $row['student_id']; ?> </center>
                                        </th>
                                        <th style="width:400px;">
                                            <center><?php echo $row['subjectName']; ?></center>
                                        </th>
                                        <th style="width:100px;">
                                            <center><?php echo $row['subjcet_code']; ?> </center>
                                        </th>
                                        <!-- <th style="width:400px;">
                                            <center><?php echo $row['Branches_id']; ?></center>
                                        </th>
                                        <th style="width:50px;">
                                            <center><?php echo $row['Semester_id']; ?></center>
                                        </th>
                                        <th style="width:100px;">
                                            <center><?php echo $row['CourseLevel']; ?></center>
                                        </th> 
                                        <th style="width:100px;">
                                            <center><?php $subjcet_code = $row['subjcet_code']; ?>
                                           <a href="edit_student_subject.php?subject=<?= $subjcet_code; ?>" 
                                                   style="width:100px;"><span class="glyphicon glyphicon-pencil"></span> </a> 
											 <a href="#" 
                                                   style="width:100px;"><span class="glyphicon glyphicon-pencil"></span> </a>
                                            </center>
                                        </th>
                                        <th style="width:100px;">
										<?php// echo $row['student_id'];?>
                                           <center><a onClick="confirmation('<?php echo $std_id ?>' )"><span class="glyphicon glyphicon-trash"></span></a>
                                            </center> 
											<center><a onClick="confirmation('#' )"><span class="glyphicon glyphicon-trash"></span></a>
                                            </center>
                                        </th> -->
                                    </tr>
                                    <?php $i++; } ?>    
                            </tbody>
			</table>
		</div>
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